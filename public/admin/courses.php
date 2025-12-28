<?php
$page_title = 'Gestisci Corso di Teoria';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Handle add/edit course
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $category = sanitize($_POST['category'] ?? '');
    $course_id = $_POST['course_id'] ?? null;

    if ($name && $description && $category) {
        if ($course_id) {
            // Update
            $stmt = $db->prepare("UPDATE courses SET name = ?, description = ?, category = ? WHERE id = ?");
            $stmt->execute([$name, $description, $category, $course_id]);
            $message = 'Corso aggiornato con successo.';
            $message_type = 'success';
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO courses (name, description, category) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $category]);
            $message = 'Corso aggiunto con successo.';
            $message_type = 'success';
        }
    } else {
        $message = 'Per favore, compila tutti i campi.';
        $message_type = 'warning';
    }
}

// Handle delete course
if (isset($_GET['delete'])) {
    $course_id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    header('Location: courses.php');
    exit;
}

// Get course for editing
$edit_course = null;
if (isset($_GET['edit'])) {
    $course_id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    $edit_course = $stmt->fetch();
}

// Pagination
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Get total count - only course 4
$total_stmt = $db->query("SELECT COUNT(*) as count FROM courses WHERE id = 4");
$total_courses = $total_stmt->fetch()['count'];
$total_pages = ceil($total_courses / $per_page);

// Get courses with pagination - only course 4
$stmt = $db->prepare("SELECT * FROM courses WHERE id = 4 ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll();
require_once '../../includes/header_dashboard.php';
?>

<style>
.course-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #dee2e6;
    height: 100%;
}

.course-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.course-preview {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.4;
}

.btn-group-vertical .btn {
    border-radius: 0.375rem !important;
    margin-bottom: 0.25rem;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .col-md-6.col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>

<!-- AdminLTE Wrapper -->
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

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Gestisci Corso di Teoria</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Corsi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Corso di Teoria</h3>
                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" onclick="toggleForm()">
                                        <i class="fas fa-plus"></i> Nuovo Corso
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

        <!-- Alert Messages -->
        <?php if ($message): ?>
        <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
        <?php endif; ?>

        <!-- Course Form -->
        <div class="dashboard-card" id="courseForm" style="<?php echo $edit_course ? '' : 'display: none;'; ?>">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> <?php echo $edit_course ? 'Modifica Corso' : 'Aggiungi Nuovo Corso'; ?></h4>
                <button class="btn btn-sm btn-outline-secondary" onclick="toggleForm()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="card-body">
                <form method="post" id="courseFormData">
                    <?php if ($edit_course): ?>
                        <input type="hidden" name="course_id" value="<?php echo $edit_course['id']; ?>">
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nome Corso *</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($edit_course['name'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category" class="form-label">Categoria *</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">Seleziona categoria</option>
                                    <option value="Patente B" <?php echo ($edit_course['category'] ?? '') === 'Patente B' ? 'selected' : ''; ?>>Patente B</option>
                                    <option value="Patente A" <?php echo ($edit_course['category'] ?? '') === 'Patente A' ? 'selected' : ''; ?>>Patente A</option>
                                    <option value="Recupero" <?php echo ($edit_course['category'] ?? '') === 'Recupero' ? 'selected' : ''; ?>>Recupero</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Descrizione *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($edit_course['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> <?php echo $edit_course ? 'Aggiorna Corso' : 'Aggiungi Corso'; ?>
                        </button>
                        <?php if ($edit_course): ?>
                            <a href="courses.php" class="btn btn-secondary">
                                <i class="bi bi-x"></i> Annulla
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Courses List -->
        <div class="dashboard-card">
            <div class="card-header">
                <h4><i class="bi bi-list"></i> Corso di Teoria</h4>
                <div class="card-actions">
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cerca nel corso..." style="width: 200px;">
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($courses)): ?>
                    <div class="empty-state">
                        <i class="bi bi-book"></i>
                        <h5>Nessun corso trovato</h5>
                        <p>Non sono stati ancora creati corsi. Crea il tuo primo corso utilizzando il pulsante "Nuovo Corso".</p>
                        <button class="btn btn-primary" onclick="toggleForm()">
                            <i class="bi bi-plus"></i> Crea Primo Corso
                        </button>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 col-lg-4 mb-4 course-item" data-name="<?php echo htmlspecialchars(strtolower($course['name'])); ?>" data-description="<?php echo htmlspecialchars(strtolower($course['description'] ?? '')); ?>">
                            <div class="card course-card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <?php echo htmlspecialchars($course['name']); ?>
                                        <span class="badge bg-<?php
                                            echo ($course['category'] ?? '') === 'Patente B' ? 'primary' :
                                                 (($course['category'] ?? '') === 'Patente A' ? 'success' : 'warning');
                                        ?> float-right">
                                            <?php echo htmlspecialchars($course['category'] ?? ''); ?>
                                        </span>
                                    </h5>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="course-preview mb-3">
                                        <?php
                                        $description = $course['description'] ?? '';
                                        $preview = strlen($description) > 150 ? substr($description, 0, 150) . '...' : $description;
                                        echo htmlspecialchars($preview);
                                        ?>
                                    </div>

                                    <div class="mt-auto">
                                        <div class="btn-group-vertical w-100" role="group">
                                            <button class="btn btn-outline-primary mb-2" onclick="editCourse(<?php echo $course['id']; ?>)">
                                                <i class="bi bi-pencil"></i> Modifica
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteCourse(<?php echo $course['id']; ?>, '<?php echo htmlspecialchars($course['name']); ?>')">
                                                <i class="bi bi-trash"></i> Elimina
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>ID: <?php echo $course['id']; ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="dashboard-card">
            <div class="card-body">
                <nav aria-label="Navigazione corsi">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                    <i class="bi bi-chevron-left"></i> Precedente
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
                                    Successivo <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <p class="text-center text-muted mt-2">
                    Pagina <?php echo $page; ?> di <?php echo $total_pages; ?> (<?php echo $total_courses; ?> corsi totali)
                </p>
            </div>
        </div>
        <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2025 <?php echo SITE_NAME; ?>.</strong> All rights reserved.
    </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
// Initialize components
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-toggle="popover"]').popover();
    
    // Table filtering
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const courseItems = document.querySelectorAll('.course-item');
            
            courseItems.forEach(item => {
                const name = item.getAttribute('data-name') || '';
                const description = item.getAttribute('data-description') || '';
                
                if (name.includes(searchTerm) || description.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});

// Toggle form visibility
function toggleForm() {
    const form = document.getElementById('courseForm');
    if (form) {
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
}

// Edit course
function editCourse(id) {
    window.location.href = '?edit=' + id;
}

// Delete course
function deleteCourse(id, name) {
    if (confirm('Sei sicuro di voler eliminare il corso "' + name + '"?')) {
        window.location.href = '?delete=' + id;
    }
}
</script>

</body>
</html>
