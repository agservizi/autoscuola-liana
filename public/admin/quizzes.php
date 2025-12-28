<?php
$page_title = 'Gestisci Quiz Corso di Teoria';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Handle add/edit quiz
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = (int)($_POST['course_id'] ?? 0);
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $time_limit = (int)($_POST['time_limit'] ?? 0);
    $passing_score = (int)($_POST['passing_score'] ?? 80);
    $quiz_id = $_POST['quiz_id'] ?? null;

    if ($course_id && $title && $description) {
        if ($quiz_id) {
            // Update
            $stmt = $db->prepare("UPDATE quizzes SET course_id = ?, title = ?, description = ?, time_limit = ?, passing_score = ? WHERE id = ?");
            $stmt->execute([$course_id, $title, $description, $time_limit, $passing_score, $quiz_id]);
            $message = 'Quiz aggiornato con successo.';
            $message_type = 'success';
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO quizzes (course_id, title, description, time_limit, passing_score) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$course_id, $title, $description, $time_limit, $passing_score]);
            $message = 'Quiz aggiunto con successo.';
            $message_type = 'success';
        }
    } else {
        $message = 'Per favore, compila tutti i campi obbligatori.';
        $message_type = 'warning';
    }
}

// Get courses (only theory course)
$stmt = $db->prepare("SELECT * FROM courses WHERE id = 4");
$stmt->execute();
$courses = $stmt->fetchAll();

// Get selected course (default to theory course)
$selected_course_id = 4;

// Handle delete quiz
if (isset($_GET['delete'])) {
    $quiz_id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->execute([$quiz_id]);
    header('Location: quizzes.php?course=' . $selected_course_id);
    exit;
}

// Get quizzes for selected course
$quizzes = [];
if ($selected_course_id) {
    $stmt = $db->prepare("
        SELECT 
            q.*,
            COALESCE(COUNT(DISTINCT ques.id), 0) as question_count,
            COALESCE(COUNT(DISTINCT qa.id), 0) as attempt_count,
            AVG(qa.score) as avg_score
        FROM quizzes q
        LEFT JOIN questions ques ON q.id = ques.quiz_id
        LEFT JOIN quiz_attempts qa ON q.id = qa.quiz_id
        WHERE q.course_id = ?
        GROUP BY q.id
        ORDER BY q.id DESC
    ");
    $stmt->execute([$selected_course_id]);
    $quizzes = $stmt->fetchAll();
}

// Get quiz for editing
$edit_quiz = null;
if (isset($_GET['edit'])) {
    $quiz_id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM quizzes WHERE id = ?");
    $stmt->execute([$quiz_id]);
    $edit_quiz = $stmt->fetch();
}

require_once '../../includes/header_dashboard.php';
?>

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
                        <h1 class="m-0">Gestisci Quiz Corso di Teoria</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quiz</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Course Selector -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Seleziona Corso</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm" onclick="toggleForm()">
                                <i class="fas fa-plus"></i> Nuovo Quiz
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="get" class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="course" class="form-label">Seleziona Corso</label>
                                <select class="form-control" id="course" name="course" onchange="this.form.submit()">
                                    <option value="">Seleziona un corso...</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?php echo $course['id']; ?>" <?php echo $selected_course_id == $course['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($course['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

        <?php if ($selected_course_id): ?>
        <!-- Alert Messages -->
        <?php if ($message): ?>
        <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
        <?php endif; ?>

        <!-- Quiz Form -->
        <div class="dashboard-card" id="quizForm" style="<?php echo $edit_quiz ? '' : 'display: none;'; ?>">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> <?php echo $edit_quiz ? 'Modifica Quiz' : 'Aggiungi Nuovo Quiz'; ?></h4>
                <button class="btn btn-sm btn-outline-secondary" onclick="toggleForm()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="card-body">
                <form method="post" id="quizFormData">
                    <?php if ($edit_quiz): ?>
                        <input type="hidden" name="quiz_id" value="<?php echo $edit_quiz['id']; ?>">
                    <?php endif; ?>
                    <input type="hidden" name="course_id" value="<?php echo $selected_course_id; ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="form-label">Titolo Quiz *</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($edit_quiz['title'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passing_score" class="form-label">Punteggio Minimo (%)</label>
                                <input type="number" class="form-control" id="passing_score" name="passing_score" value="<?php echo $edit_quiz['passing_score'] ?? 80; ?>" min="0" max="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_limit" class="form-label">Limite Tempo (minuti)</label>
                                <input type="number" class="form-control" id="time_limit" name="time_limit" value="<?php echo $edit_quiz['time_limit'] ?? 0; ?>" min="0" placeholder="0 = nessun limite">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Descrizione *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($edit_quiz['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> <?php echo $edit_quiz ? 'Aggiorna Quiz' : 'Aggiungi Quiz'; ?>
                        </button>
                        <?php if ($edit_quiz): ?>
                            <a href="quizzes.php?course=<?php echo $selected_course_id; ?>" class="btn btn-secondary">
                                <i class="bi bi-x"></i> Annulla
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quizzes List -->
        <div class="dashboard-card">
            <div class="card-header">
                <h4><i class="bi bi-list"></i> Quiz del Corso (<?php echo count($quizzes); ?>)</h4>
                <div class="card-tools">
                    <input type="text" id="searchInput" class="form-control form-control-sm d-inline-block" placeholder="Cerca quiz..." style="width: 200px; margin-right: 10px;">
                    <button class="btn btn-primary btn-sm" onclick="toggleForm()">
                        <i class="bi bi-plus"></i> Nuovo Quiz
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($quizzes)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">Nessun quiz trovato</h5>
                        <p>Crea il tuo primo quiz per questo corso.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="quizzesTable">
                            <thead>
                                <tr>
                                    <th>Titolo</th>
                                    <th>Domande</th>
                                    <th>Tentativi</th>
                                    <th>Punteggio Medio</th>
                                    <th>Limite Tempo</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quizzes as $quiz): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                                        <td><?php echo $quiz['question_count']; ?></td>
                                        <td><?php echo $quiz['attempt_count']; ?></td>
                                        <td><?php echo $quiz['avg_score'] ? round($quiz['avg_score'], 1) . '%' : '-'; ?></td>
                                        <td><?php echo $quiz['time_limit'] ? $quiz['time_limit'] . ' min' : 'Nessuno'; ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="questions.php?quiz=<?php echo $quiz['id']; ?>" class="btn btn-sm btn-outline-info" title="Gestisci Domande">
                                                    <i class="bi bi-question-circle"></i>
                                                </a>
                                                <a href="quizzes.php?course=<?php echo $selected_course_id; ?>&edit=<?php echo $quiz['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifica">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="quizzes.php?course=<?php echo $selected_course_id; ?>&delete=<?php echo $quiz['id']; ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questo quiz?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

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
            const rows = document.querySelectorAll('#quizzesTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});

// Toggle form visibility
function toggleForm() {
    const form = document.getElementById('quizForm');
    if (form) {
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
}
</script>

</body>
</html>
