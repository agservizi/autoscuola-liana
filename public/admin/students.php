<?php
$page_title = 'Gestisci Studenti';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Handle delete student
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = 'Token di sicurezza non valido.';
        $message_type = 'error';
    } else {
        $student_id = (int)$_POST['student_id'];
        $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
        $result = $stmt->execute([$student_id]);
        if ($result) {
            $message = 'Studente eliminato con successo.';
            $message_type = 'success';
        } else {
            $message = 'Errore durante l\'eliminazione dello studente.';
            $message_type = 'error';
        }
    }
}

// Handle bulk delete students
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_delete_students'])) {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = 'Token di sicurezza non valido.';
        $message_type = 'error';
    } else {
    $student_ids = $_POST['student_ids'] ?? [];
    if (!empty($student_ids)) {
        $placeholders = str_repeat('?,', count($student_ids) - 1) . '?';
        $stmt = $db->prepare("DELETE FROM users WHERE id IN ($placeholders) AND role = 'student'");
        $result = $stmt->execute($student_ids);
        if ($result) {
            $message = count($student_ids) . ' studenti eliminati con successo.';
            $message_type = 'success';
        } else {
            $message = 'Errore durante l\'eliminazione degli studenti.';
            $message_type = 'error';
        }
    } else {
        $message = 'Nessuno studente selezionato.';
        $message_type = 'warning';
    }
    }
}

// Pagination
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Get total count
$total_stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$total_students = $total_stmt->fetch()['count'];
$total_pages = ceil($total_students / $per_page);

// Get students with pagination
$stmt = $db->prepare("
    SELECT u.id, u.email, u.first_name, u.last_name, u.created_at, u.username,
           COUNT(DISTINCT qa.id) as total_attempts,
           COUNT(DISTINCT CASE WHEN qa.passed = 1 THEN qa.id END) as passed_quizzes,
           MAX(qa.attempt_date) as last_activity
    FROM users u
    LEFT JOIN quiz_attempts qa ON u.id = qa.user_id
    WHERE u.role = 'student'
    GROUP BY u.id, u.email, u.first_name, u.last_name, u.created_at, u.username
    ORDER BY u.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll();

// Calculate additional statistics
// Active students in last 30 days
$active_stmt = $db->query("
    SELECT COUNT(DISTINCT u.id) as count 
    FROM users u 
    INNER JOIN quiz_attempts qa ON u.id = qa.user_id 
    WHERE u.role = 'student' 
    AND qa.attempt_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
");
$active_students = $active_stmt->fetch()['count'];

// Total quiz attempts
$attempts_stmt = $db->query("SELECT COUNT(*) as count FROM quiz_attempts");
$total_attempts = $attempts_stmt->fetch()['count'];

// Average passed quizzes per student
$avg_stmt = $db->query("
    SELECT AVG(passed_count) as average 
    FROM (
        SELECT COUNT(CASE WHEN qa.passed = 1 THEN 1 END) as passed_count 
        FROM users u 
        LEFT JOIN quiz_attempts qa ON u.id = qa.user_id 
        WHERE u.role = 'student' 
        GROUP BY u.id
    ) as student_stats
");
$avg_passed = round($avg_stmt->fetch()['average'] ?? 0, 1);

require_once '../../includes/header_dashboard.php';
?>

<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="dashboard.php" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">Benvenuto, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</span>
            </li>
            <li class="nav-item">
                <a href="../logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <?php include '../../includes/sidebar_admin.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Gestisci Studenti</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Studenti</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo number_format($total_students); ?></h3>
                                <p>Studenti Registrati</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo number_format($active_students); ?></h3>
                                <p>Studenti Attivi (30gg)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo number_format($total_attempts); ?></h3>
                                <p>Tentativi Quiz Totali</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo number_format($avg_passed, 1); ?></h3>
                                <p>Quiz Superati (Media)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                </div>

        <!-- Hidden elements for JavaScript toast messages -->
        <?php if ($message): ?>
        <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo htmlspecialchars($message_type); ?>" style="display: none;"></div>
        <?php endif; ?>

        <!-- Students List -->
        <div class="dashboard-card">
            <div class="card-header">
                <h4><i class="bi bi-list"></i> Lista Studenti</h4>
                <div class="card-actions d-flex justify-content-end align-items-center" style="gap: 1rem;">
                    <a href="add_student.php" class="btn btn-success btn-sm">
                        <i class="bi bi-person-plus"></i> Registra Nuovo Studente
                    </a>
                    <div class="bulk-actions" id="bulkActions" style="display: none;">
                        <form method="post" id="bulkForm" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <input type="hidden" name="student_ids[]" id="selectedIds">
                            <button type="submit" name="bulk_delete_students" class="btn btn-sm btn-outline-danger" onclick="return confirm('Sei sicuro di voler eliminare gli studenti selezionati?')">
                                <i class="bi bi-trash"></i> Elimina Selezionati
                            </button>
                        </form>
                    </div>
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cerca studenti..." style="width: 200px;">
                    <select id="statusFilter" class="form-control form-control-sm" style="width: 150px;">
                        <option value="">Tutti gli studenti</option>
                        <option value="active">Attivi (30gg)</option>
                        <option value="inactive">Inattivi</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($students)): ?>
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h5>Nessuno studente trovato</h5>
                        <p>Non sono ancora stati registrati studenti nella piattaforma.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes()"></th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Stato</th>
                                    <th>Iscritto</th>
                                    <th>Ultima Attività</th>
                                    <th>Tentativi</th>
                                    <th>Superati</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><input type="checkbox" class="student-checkbox-input" value="<?php echo $student['id']; ?>" onchange="updateBulkActions()"></td>
                                    <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['phone'] ?? ''); ?></td>
                                    <td>
                                        <?php
                                        $is_active = $student['last_activity'] && strtotime($student['last_activity']) > strtotime('-30 days');
                                        ?>
                                        <span class="status-badge <?php echo $is_active ? 'active' : 'inactive'; ?>">
                                            <i class="fas fa-<?php echo $is_active ? 'circle' : 'circle'; ?>"></i>
                                            <?php echo $is_active ? 'Attivo' : 'Inattivo'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($student['created_at'])); ?></td>
                                    <td><?php echo $student['last_activity'] ? date('d/m/Y H:i', strtotime($student['last_activity'])) : 'Mai'; ?></td>
                                    <td><?php echo $student['total_attempts']; ?></td>
                                    <td><?php echo $student['passed_quizzes']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" onclick="viewStudentDetails(<?php echo htmlspecialchars(json_encode([
                                            'id' => (int)$student['id'],
                                            'firstName' => (string)$student['first_name'],
                                            'lastName' => (string)$student['last_name'],
                                            'email' => (string)$student['email'],
                                            'username' => (string)($student['username'] ?? ''),
                                            'createdAt' => date('d/m/Y', strtotime($student['created_at'])),
                                            'lastActivity' => $student['last_activity'] ? date('d/m/Y H:i', strtotime($student['last_activity'])) : 'Mai',
                                            'totalAttempts' => (int)$student['total_attempts'],
                                            'passedQuizzes' => (int)$student['passed_quizzes']
                                        ])); ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteStudent(<?php echo $student['id']; ?>, '<?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="dashboard-card">
            <div class="card-body">
                <nav aria-label="Navigazione studenti">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                    <i class="fas fa-chevron-left"></i> Precedente
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);

                        if ($start_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1">1</a>
                            </li>
                            <?php if ($start_page > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                                    Successivo <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <p class="text-center text-muted mt-2">
                    Pagina <?php echo $page; ?> di <?php echo $total_pages; ?> (<?php echo $total_students; ?> studenti totali)
                </p>
            </div>
        </div>
        <?php endif; ?>

        </div>
    </main>
</div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2025 <?php echo SITE_NAME; ?>.</strong> All rights reserved.
    </footer>
</div>

<!-- Student Details Modal -->
<div class="modal fade" id="studentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person"></i> Dettagli Studente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="studentModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', filterStudents);
document.getElementById('statusFilter').addEventListener('change', filterStudents);

function filterStudents() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const studentCards = document.querySelectorAll('.student-card');

    studentCards.forEach(card => {
        const studentName = card.querySelector('h5').textContent.toLowerCase();
        const username = card.querySelector('.username').textContent.toLowerCase();
        const email = card.querySelector('.detail-item span').textContent.toLowerCase();
        const statusBadge = card.querySelector('.status-badge');

        let matchesSearch = studentName.includes(searchTerm) ||
                           username.includes(searchTerm) ||
                           email.includes(searchTerm);

        let matchesStatus = true;
        if (statusFilter) {
            const isActive = statusBadge.classList.contains('active');
            matchesStatus = (statusFilter === 'active' && isActive) ||
                           (statusFilter === 'inactive' && !isActive);
        }

        card.style.display = (matchesSearch && matchesStatus) ? 'block' : 'none';
    });
}

// View student details
function viewStudentDetails(studentData) {
    const modalBody = document.getElementById('studentModalBody');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-8">
                <h5 class="mb-3"><i class="fas fa-user-circle text-primary me-2"></i>Dettagli Studente</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-id-card me-1"></i>ID Studente</h6>
                            <p class="mb-0 fw-bold">#${studentData.id}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-user me-1"></i>Nome Completo</h6>
                            <p class="mb-0 fw-bold">${studentData.firstName} ${studentData.lastName}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-envelope me-1"></i>Email</h6>
                            <p class="mb-0">${studentData.email}</p>
                        </div>
                    </div>
                    ${studentData.username ? `
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-at me-1"></i>Username</h6>
                            <p class="mb-0">${studentData.username}</p>
                        </div>
                    </div>
                    ` : ''}
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-calendar-plus me-1"></i>Data Registrazione</h6>
                            <p class="mb-0">${studentData.createdAt}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3"><i class="fas fa-chart-line text-success me-2"></i>Statistiche</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="border rounded p-3 text-center">
                            <div class="h4 mb-1 text-primary">${studentData.totalAttempts}</div>
                            <small class="text-muted">Quiz Tentati</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 text-center">
                            <div class="h4 mb-1 text-success">${studentData.passedQuizzes}</div>
                            <small class="text-muted">Quiz Superati</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 text-center">
                            <div class="h4 mb-1 text-info">${studentData.totalAttempts > 0 ? Math.round((studentData.passedQuizzes / studentData.totalAttempts) * 100) : 0}%</div>
                            <small class="text-muted">Tasso Successo</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-clock me-1"></i>Ultima Attività</h6>
                            <p class="mb-0 small">${studentData.lastActivity}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('studentModal')).show();
}

// Delete student with confirmation
function deleteStudent(studentId, studentName) {
    if (confirm(`Sei sicuro di voler eliminare lo studente "${studentName}"? Questa azione non può essere annullata.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <input type="hidden" name="student_id" value="${studentId}">
            <input type="hidden" name="delete_student" value="1">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script type="text/javascript">
// Search and filter functionality for table
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput && statusFilter) {
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const name = cells[1].textContent.toLowerCase();
                const email = cells[2].textContent.toLowerCase();
                const statusBadge = cells[4].querySelector('.status-badge');
                const status = statusBadge.classList.contains('active') ? 'active' : 'inactive';
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesStatus = statusValue === '' || status === statusValue;
                
                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    }
});
</script>

<script type="text/javascript">
// Search and filter functionality for table
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput && statusFilter) {
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const name = cells[1].textContent.toLowerCase();
                const email = cells[2].textContent.toLowerCase();
                const statusBadge = cells[4].querySelector('.status-badge');
                const status = statusBadge.classList.contains('active') ? 'active' : 'inactive';
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesStatus = statusValue === '' || status === statusValue;
                
                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    }
});

// Bulk actions functionality
function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.student-checkbox-input:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedIds = document.getElementById('selectedIds');

    if (checkboxes.length > 0) {
        bulkActions.style.display = 'flex';
        const ids = Array.from(checkboxes).map(cb => cb.value);
        selectedIds.value = ids.join(',');
    } else {
        bulkActions.style.display = 'none';
        selectedIds.value = '';
    }
}

// Select all functionality
function toggleAllCheckboxes() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.student-checkbox-input');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
    updateBulkActions();
}
</script>

</body>
</html>