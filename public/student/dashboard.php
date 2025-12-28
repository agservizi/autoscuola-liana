<?php
$page_title = 'Dashboard Studente';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireStudent();

$current_page = basename(__FILE__);

// Get user info
$user_id = $_SESSION['user_id'];
$user_name = htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']);

// Get enrolled courses (for now, all courses are available)
$stmt = $db->query("SELECT * FROM courses ORDER BY id");
$courses = $stmt->fetchAll();

// Get quiz attempts
$stmt = $db->prepare("SELECT qa.*, q.title as quiz_title, c.name as course_name FROM quiz_attempts qa JOIN quizzes q ON qa.quiz_id = q.id JOIN courses c ON q.course_id = c.id WHERE qa.user_id = ? ORDER BY qa.attempt_date DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_attempts = $stmt->fetchAll();

// Calculate stats
$total_quizzes = count($recent_attempts);
$passed_quizzes = count(array_filter($recent_attempts, function($attempt) { return $attempt['passed']; }));
$avg_score = $total_quizzes > 0 ? round(array_sum(array_column($recent_attempts, 'score')) / $total_quizzes) : 0;

// Calculate progress
$total_lessons = 0;
$completed_lessons = 0;
foreach ($courses as $course) {
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM lessons WHERE course_id = ?");
    $stmt->execute([$course['id']]);
    $total_lessons += $stmt->fetch()['total'];

    $stmt = $db->prepare("SELECT COUNT(*) as completed FROM lesson_progress WHERE user_id = ? AND lesson_id IN (SELECT id FROM lessons WHERE course_id = ?) AND completed = 1");
    $stmt->execute([$user_id, $course['id']]);
    $completed_lessons += $stmt->fetch()['completed'];
}
$progress_percentage = $total_lessons > 0 ? round(($completed_lessons / $total_lessons) * 100) : 0;
?>

<?php include '../../includes/header_dashboard.php'; ?>

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
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Welcome Message -->
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-info"></i> Benvenuto, <?php echo $user_name; ?>!</h5>
                    Hai completato il <?php echo $progress_percentage; ?>% del tuo percorso di apprendimento.
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $total_quizzes; ?></h3>
                                <p>Quiz Completati</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <a href="quiz.php" class="small-box-footer">Più info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $passed_quizzes; ?></h3>
                                <p>Quiz Superati</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $avg_score; ?>%</h3>
                                <p>Punteggio Medio</p>
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
                                <h3><?php echo $progress_percentage; ?>%</h3>
                                <p>Progresso Totale</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                </div>

                <!-- Courses and Recent Attempts -->
                <div class="row">
                    <!-- Available Lessons -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lezioni Disponibili</h3>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="course.php" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Corso di Teoria della Circolazione</h5>
                                            <small><?php echo $total_lessons; ?> lezioni disponibili</small>
                                        </div>
                                        <p class="mb-1">Accedi alle lezioni del corso principale di teoria per la patente di guida.</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Quiz Attempts -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Ultimi Tentativi Quiz</h3>
                            </div>
                            <div class="card-body">
                                <?php if (empty($recent_attempts)): ?>
                                    <p>Nessun tentativo recente.</p>
                                <?php else: ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($recent_attempts as $attempt): ?>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($attempt['quiz_title']); ?></strong><br>
                                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($attempt['attempt_date'])); ?></small>
                                                    </div>
                                                    <span class="badge badge-<?php echo $attempt['passed'] ? 'success' : 'danger'; ?>">
                                                        <?php echo $attempt['score']; ?>%
                                                    </span>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
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

</body>
</html>