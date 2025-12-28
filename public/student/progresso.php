<?php
$page_title = 'Progresso';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireStudent();

$current_page = basename(__FILE__);

$user_id = $_SESSION['user_id'];
$user_name = htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']);

// Get lessons progress for course 4 (main theory course)
$stmt = $db->prepare("SELECT l.*, lp.completed, lp.completed_at FROM lessons l LEFT JOIN lesson_progress lp ON l.id = lp.lesson_id AND lp.user_id = ? WHERE l.course_id = 4 ORDER BY l.lesson_order");
$stmt->execute([$user_id]);
$lessons_progress = $stmt->fetchAll();

// Calculate overall progress
$total_lessons = count($lessons_progress);
$completed_lessons = count(array_filter($lessons_progress, function($lesson) { return $lesson['completed']; }));
$progress_percentage = $total_lessons > 0 ? round(($completed_lessons / $total_lessons) * 100) : 0;

// Get quiz attempts for course 4 only
$stmt = $db->prepare("SELECT qa.*, q.title as quiz_title, c.name as course_name FROM quiz_attempts qa JOIN quizzes q ON qa.quiz_id = q.id JOIN courses c ON q.course_id = c.id WHERE qa.user_id = ? AND q.course_id = 4 ORDER BY qa.attempt_date DESC");
$stmt->execute([$user_id]);
$quiz_attempts = $stmt->fetchAll();

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
                        <h1 class="m-0">Il Mio Progresso</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Progresso</li>
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
                                <h3 class="card-title">Progresso nelle Lezioni</h3>
                            </div>
                            <div class="card-body">
                                <!-- Overall Progress -->
                                <div class="mb-4">
                                    <h5>Progresso Generale</h5>
                                    <div class="progress mb-2">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_percentage; ?>%" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $progress_percentage; ?>%
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo $completed_lessons; ?> di <?php echo $total_lessons; ?> lezioni completate
                                    </small>
                                </div>

                                <!-- Individual Lessons Progress -->
                                <h5>Dettaglio Lezioni</h5>
                                <div class="row">
                                    <?php foreach ($lessons_progress as $lesson): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card <?php echo $lesson['completed'] ? 'border-success' : 'border-warning'; ?>">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="card-title mb-1">
                                                            Lezione <?php echo $lesson['lesson_order']; ?>: <?php echo htmlspecialchars($lesson['title']); ?>
                                                        </h6>
                                                        <?php if ($lesson['completed']): ?>
                                                            <small class="text-success">
                                                                <i class="fas fa-check-circle"></i> Completata
                                                                <?php if ($lesson['completed_at']): ?>
                                                                    il <?php echo date('d/m/Y', strtotime($lesson['completed_at'])); ?>
                                                                <?php endif; ?>
                                                            </small>
                                                        <?php else: ?>
                                                            <small class="text-warning">
                                                                <i class="fas fa-clock"></i> Non completata
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <?php if ($lesson['completed']): ?>
                                                            <span class="badge badge-success">✓</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-warning">○</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Storico Quiz delle Lezioni</h3>
                            </div>
                            <div class="card-body">
                                <?php if (empty($quiz_attempts)): ?>
                                    <p>Nessun tentativo di quiz ancora effettuato.</p>
                                <?php else: ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Quiz</th>
                                                <th>Corso</th>
                                                <th>Punteggio</th>
                                                <th>Superato</th>
                                                <th>Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($quiz_attempts as $attempt): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($attempt['quiz_title']); ?></td>
                                                <td><?php echo htmlspecialchars($attempt['course_name']); ?></td>
                                                <td><?php echo $attempt['score']; ?>%</td>
                                                <td>
                                                    <span class="badge <?php echo $attempt['passed'] ? 'badge-success' : 'badge-danger'; ?>">
                                                        <?php echo $attempt['passed'] ? 'Sì' : 'No'; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($attempt['attempt_date'])); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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