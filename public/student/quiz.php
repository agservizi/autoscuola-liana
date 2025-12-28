<?php
$page_title = 'Quiz delle Lezioni';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireStudent();

$current_page = basename(__FILE__);

$user_id = $_SESSION['user_id'];
$quiz_id = $_GET['id'] ?? 0;
$questions_count = 0;

if ($quiz_id) {
    // Show specific quiz
    $stmt = $db->prepare("SELECT q.*, c.name as course_name FROM quizzes q LEFT JOIN courses c ON q.course_id = c.id WHERE q.id = ?");
    $stmt->execute([$quiz_id]);
    $quiz = $stmt->fetch();

    if (!$quiz) {
        header('Location: quiz.php');
        exit;
    }

    // Get questions count
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quiz_id]);
    $questions_count = $stmt->fetch()['count'];
} else {
    // Show quiz list for course 4 (main theory course) ordered by lesson order
    $stmt = $db->query("SELECT q.*, c.name as course_name, l.lesson_order, l.title as lesson_title FROM quizzes q LEFT JOIN courses c ON q.course_id = c.id LEFT JOIN lessons l ON q.course_id = l.course_id AND q.title = CONCAT('Quiz Lezione ', l.lesson_order) WHERE q.course_id = 4 ORDER BY l.lesson_order ASC");
    $quizzes = $stmt->fetchAll();
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
    <?php include '../../includes/sidebar_student.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Quiz delle Lezioni</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Quiz delle Lezioni</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
            <?php if ($quiz_id): ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($quiz['title'] ?? ''); ?></h3>
                            <p><?php echo htmlspecialchars($quiz['description'] ?? ''); ?></p>
                            <div class="d-flex justify-content-between">
                                <small>Corso: <?php echo htmlspecialchars($quiz['course_name'] ?? 'Corso sconosciuto'); ?></small>
                                <small>Domande: <?php echo $questions_count; ?> | Tempo: <?php echo $quiz['time_limit']; ?> minuti</small>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h4>Pronto per iniziare il quiz?</h4>
                            <p>Una volta iniziato, avrai <?php echo $quiz['time_limit']; ?> minuti per completare tutte le domande.</p>
                            <p><strong>Punteggio minimo per superare: <?php echo $quiz['passing_score'] ?? 0; ?>%</strong></p>
                            <button id="start-quiz" class="btn btn-primary btn-lg">Inizia Quiz</button>
                        </div>
                    </div>

                    <div id="quiz-container" class="mt-4" style="display: none;">
                        <!-- Quiz content will be loaded here via JavaScript -->
                    </div>

                    <div id="quiz-timer" class="text-center mt-3" style="display: none;"></div>
                </div>
            </div>
            <?php else: ?>
            <!-- Quiz List -->
            <div class="row">
                <div class="col-12">
                    <h2>I Miei Quiz</h2>
                    <div class="row">
                        <?php foreach ($quizzes as $quiz): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($quiz['title'] ?? ''); ?>: <?php echo htmlspecialchars($quiz['lesson_title'] ?? ''); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($quiz['description'] ?? ''); ?></p>
                                    <p><small>Corso: <?php echo htmlspecialchars($quiz['course_name'] ?? 'Corso sconosciuto'); ?></small></p>
                                    <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-primary">Inizia Quiz</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
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
<!-- Main JS -->
<script src="assets/js/main.js"></script>

<script>
let quizId = <?php echo $quiz_id; ?>;
let totalQuestions = <?php echo $questions_count; ?>;
let quizTimeLimit = <?php echo $quiz['time_limit']; ?>;

document.getElementById('start-quiz')?.addEventListener('click', function() {
    document.querySelector('.card').style.display = 'none';
    document.getElementById('quiz-container').style.display = 'block';
    document.getElementById('quiz-timer').style.display = 'block';
    startQuiz(quizId, quizTimeLimit);
});
</script>

<!-- REQUIRED SCRIPTS -->