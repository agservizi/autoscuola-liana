<?php
$page_title = 'Gestisci Domande Corso di Teoria';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Handle add/edit question
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = (int)($_POST['quiz_id'] ?? 0);
    $question = sanitize($_POST['question'] ?? '');
    $option_a = sanitize($_POST['option_a'] ?? '');
    $option_b = sanitize($_POST['option_b'] ?? '');
    $option_c = sanitize($_POST['option_c'] ?? '');
    $option_d = sanitize($_POST['option_d'] ?? '');
    $correct_answer = sanitize($_POST['correct_answer'] ?? '');
    $explanation = sanitize($_POST['explanation'] ?? '');
    $question_id = $_POST['question_id'] ?? null;

    if ($quiz_id && $question && $option_a && $option_b && $option_c && $correct_answer) {
        if ($question_id) {
            // Update
            $stmt = $db->prepare("UPDATE questions SET quiz_id = ?, question = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_answer = ?, explanation = ? WHERE id = ?");
            $stmt->execute([$quiz_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer, $explanation, $question_id]);
            $message = 'Domanda aggiornata con successo.';
            $message_type = 'success';
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer, explanation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$quiz_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer, $explanation]);
            $message = 'Domanda aggiunta con successo.';
            $message_type = 'success';
        }
    } else {
        $message = 'Per favore, compila tutti i campi obbligatori.';
        $message_type = 'warning';
    }
}

// Handle delete question
if (isset($_GET['delete'])) {
    $question_id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $quiz_id = (int)($_GET['quiz'] ?? 0);
    header("Location: questions.php?quiz=$quiz_id");
    exit;
}

// Get quizzes (only from theory course)
$stmt = $db->prepare("SELECT q.id, q.title, c.name as course_name FROM quizzes q JOIN courses c ON q.course_id = c.id WHERE q.course_id = 4 ORDER BY q.title");
$stmt->execute();
$quizzes = $stmt->fetchAll();

// Get selected quiz
$selected_quiz_id = (int)($_GET['quiz'] ?? 0);

// Get questions for selected quiz
$questions = [];
if ($selected_quiz_id) {
    $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = ? ORDER BY id");
    $stmt->execute([$selected_quiz_id]);
    $questions = $stmt->fetchAll();
}

// Get question for editing
$edit_question = null;
if (isset($_GET['edit'])) {
    $question_id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $edit_question = $stmt->fetch();
}


// Get quiz info
$quiz_info = null;
if ($selected_quiz_id) {
    $stmt = $db->prepare("SELECT q.*, c.name as course_name FROM quizzes q JOIN courses c ON q.course_id = c.id WHERE q.id = ?");
    $stmt->execute([$selected_quiz_id]);
    $quiz_info = $stmt->fetch();
}

// Get question for editing
$edit_question = null;
if (isset($_GET['edit'])) {
    $question_id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $edit_question = $stmt->fetch();
    if ($edit_question) {
        $selected_quiz_id = $edit_question['quiz_id'];
    }
}

// Get questions for selected quiz
$questions = [];
if ($selected_quiz_id) {
    $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = ? ORDER BY id");
    $stmt->execute([$selected_quiz_id]);
    $questions = $stmt->fetchAll();
}

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
                        <h1 class="m-0">Gestisci Domande Corso di Teoria</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Domande</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Quiz Selector -->
                <div class="card">
                    <div class="card-body">
                        <form method="get" class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="quiz" class="form-label">Seleziona Quiz</label>
                                <select class="form-control" id="quiz" name="quiz" onchange="this.form.submit()">
                                    <option value="">Seleziona un quiz...</option>
                                    <?php foreach ($quizzes as $quiz): ?>
                                        <option value="<?php echo $quiz['id']; ?>" <?php echo $selected_quiz_id == $quiz['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($quiz['course_name'] . ' - ' . $quiz['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <?php if ($selected_quiz_id): ?>
                                    <button class="btn btn-primary" onclick="toggleForm()">
                                        <i class="fas fa-plus"></i> Aggiungi Domanda
                                    </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if ($selected_quiz_id): ?>
                    <!-- Alert Messages -->
                    <?php if ($message): ?>
                    <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
                    <?php endif; ?>

                    <!-- Question Form -->
                    <div class="card" id="questionForm" style="<?php echo $edit_question ? '' : 'display: none;'; ?>">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-pencil-alt"></i> <?php echo $edit_question ? 'Modifica Domanda' : 'Aggiungi Nuova Domanda'; ?></h3>
                            <div class="card-tools">
                                <button class="btn btn-tool" onclick="toggleForm()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" id="questionFormData">
                                <?php if ($edit_question): ?>
                                    <input type="hidden" name="question_id" value="<?php echo $edit_question['id']; ?>">
                                <?php endif; ?>
                                <input type="hidden" name="quiz_id" value="<?php echo $selected_quiz_id; ?>">
                                <div class="form-group">
                                    <label for="question" class="form-label">Domanda *</label>
                                    <textarea class="form-control" id="question" name="question" rows="3" required><?php echo htmlspecialchars($edit_question['question'] ?? ''); ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="option_a" class="form-label">Opzione A *</label>
                                            <input type="text" class="form-control" id="option_a" name="option_a" value="<?php echo htmlspecialchars($edit_question['option_a'] ?? ''); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="option_b" class="form-label">Opzione B *</label>
                                            <input type="text" class="form-control" id="option_b" name="option_b" value="<?php echo htmlspecialchars($edit_question['option_b'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="option_c" class="form-label">Opzione C *</label>
                                            <input type="text" class="form-control" id="option_c" name="option_c" value="<?php echo htmlspecialchars($edit_question['option_c'] ?? ''); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="option_d" class="form-label">Opzione D (opzionale)</label>
                                            <input type="text" class="form-control" id="option_d" name="option_d" value="<?php echo htmlspecialchars($edit_question['option_d'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correct_answer" class="form-label">Risposta Corretta *</label>
                                            <select class="form-control" id="correct_answer" name="correct_answer" required>
                                                <option value="">Seleziona risposta corretta</option>
                                                <option value="a" <?php echo ($edit_question['correct_answer'] ?? '') === 'a' ? 'selected' : ''; ?>>A</option>
                                                <option value="b" <?php echo ($edit_question['correct_answer'] ?? '') === 'b' ? 'selected' : ''; ?>>B</option>
                                                <option value="c" <?php echo ($edit_question['correct_answer'] ?? '') === 'c' ? 'selected' : ''; ?>>C</option>
                                                <option value="d" <?php echo ($edit_question['correct_answer'] ?? '') === 'd' ? 'selected' : ''; ?>>D</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="explanation" class="form-label">Spiegazione (opzionale)</label>
                                    <textarea class="form-control" id="explanation" name="explanation" rows="3"><?php echo htmlspecialchars($edit_question['explanation'] ?? ''); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> <?php echo $edit_question ? 'Aggiorna Domanda' : 'Aggiungi Domanda'; ?>
                                    </button>
                                    <?php if ($edit_question): ?>
                                        <a href="questions.php?quiz=<?php echo $selected_quiz_id; ?>" class="btn btn-secondary ml-2">
                                            <i class="fas fa-times"></i> Annulla
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Questions List -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-list"></i> Domande del Quiz: <?php echo htmlspecialchars($quiz_info['title']); ?> (<?php echo count($questions); ?>)</h3>
                            <div class="card-tools">
                                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cerca domande..." style="width: 200px;">
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($questions)): ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h5 class="mt-3">Nessuna domanda trovata</h5>
                                    <p>Crea la tua prima domanda per questo quiz.</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="questionsTable">
                                        <thead>
                                            <tr>
                                                <th>Domanda</th>
                                                <th>Risposta Corretta</th>
                                                <th>Azioni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($questions as $question): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars(substr($question['question'] ?? '', 0, 80)) . (strlen($question['question'] ?? '') > 80 ? '...' : ''); ?></td>
                                                    <td>
                                                        <span class="badge badge-success"><?php echo strtoupper($question['correct_answer']); ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="questions.php?quiz=<?php echo $selected_quiz_id; ?>&edit=<?php echo $question['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifica">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="questions.php?quiz=<?php echo $selected_quiz_id; ?>&delete=<?php echo $question['id']; ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questa domanda?')">
                                                                <i class="fas fa-trash"></i>
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
    // Table filtering
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#questionsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});

// Toggle form visibility
function toggleForm() {
    const form = document.getElementById('questionForm');
    if (form) {
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
}
</script>

</body>
</html>
