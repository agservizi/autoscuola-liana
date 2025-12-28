<?php
$page_title = 'Lezione';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireStudent();

$current_page = basename(__FILE__);

$lesson_id = $_GET['id'] ?? 0;

if (!$lesson_id) {
    header('Location: course.php');
    exit;
}

// Get lesson details
$stmt = $db->prepare("
    SELECT l.*, c.name as course_name, c.id as course_id,
           lp.completed, lp.completed_at
    FROM lessons l
    JOIN courses c ON l.course_id = c.id
    LEFT JOIN lesson_progress lp ON l.id = lp.lesson_id AND lp.user_id = ?
    WHERE l.id = ?
");
$stmt->execute([$_SESSION['user_id'], $lesson_id]);
$lesson = $stmt->fetch();

if (!$lesson) {
    header('Location: course.php');
    exit;
}

// Handle lesson completion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_lesson'])) {
    $stmt = $db->prepare("INSERT INTO lesson_progress (user_id, lesson_id, completed, completed_at) VALUES (?, ?, 1, NOW()) ON DUPLICATE KEY UPDATE completed = 1, completed_at = NOW()");
    $stmt->execute([$_SESSION['user_id'], $lesson_id]);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
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
            <li class="nav-item d-none d-sm-inline-block">
                <a href="course.php?id=<?php echo $lesson['course_id']; ?>" class="nav-link">Torna al Corso</a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <?php require_once '../../includes/sidebar_student.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo htmlspecialchars($lesson['title'] ?? ''); ?></h1>
                        <small><?php echo htmlspecialchars($lesson['course_name'] ?? ''); ?></small>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="course.php?id=<?php echo $lesson['course_id']; ?>"><?php echo htmlspecialchars($lesson['course_name'] ?? ''); ?></a></li>
                            <li class="breadcrumb-item active">Lezione</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <?php echo htmlspecialchars($lesson['title'] ?? ''); ?>
                                    <?php if ($lesson['completed']): ?>
                                        <span class="badge badge-success ml-2">Completata</span>
                                    <?php endif; ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="lesson-content">
                                    <?php echo nl2br(htmlspecialchars($lesson['content'] ?? '')); ?>
                                </div>

                                <?php if ($lesson['video_url']): ?>
                                <div class="mt-4">
                                    <h5>Video Lezione</h5>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="<?php echo htmlspecialchars($lesson['video_url'] ?? ''); ?>" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (!$lesson['completed']): ?>
                                <form method="post" class="mt-4">
                                    <input type="hidden" name="complete_lesson" value="1">
                                    <button type="submit" class="btn btn-success btn-lg">Segna come Completata</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php
                        // Find the corresponding quiz for this lesson
                        $stmt = $db->prepare("SELECT * FROM quizzes WHERE course_id = ? ORDER BY id");
                        $stmt->execute([$lesson['course_id']]);
                        $all_quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get the quiz corresponding to this lesson (lesson_order - 1 for 0-based index)
                        $quiz_index = $lesson['lesson_order'] - 1;
                        $quiz = isset($all_quizzes[$quiz_index]) ? $all_quizzes[$quiz_index] : null;
                        ?>

                        <?php if ($quiz): ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Quiz della Lezione</h3>
                            </div>
                            <div class="card-body">
                                <h5><?php echo htmlspecialchars($quiz['title'] ?? ''); ?></h5>
                                <p><?php echo htmlspecialchars($quiz['description'] ?? 'Testa le tue conoscenze su questa lezione.'); ?></p>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> Tempo limite: <?php echo $quiz['time_limit']; ?> minuti<br>
                                        <i class="fas fa-trophy"></i> Punteggio minimo: <?php echo $quiz['passing_score']; ?>%
                                    </small>
                                </div>
                                <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-primary btn-block">Inizia Quiz</a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Navigation between lessons -->
                        <?php
                        $stmt = $db->prepare("SELECT id, title FROM lessons WHERE course_id = ? AND lesson_order < ? ORDER BY lesson_order DESC LIMIT 1");
                        $stmt->execute([$lesson['course_id'], $lesson['lesson_order']]);
                        $prev_lesson = $stmt->fetch();

                        $stmt = $db->prepare("SELECT id, title FROM lessons WHERE course_id = ? AND lesson_order > ? ORDER BY lesson_order ASC LIMIT 1");
                        $stmt->execute([$lesson['course_id'], $lesson['lesson_order']]);
                        $next_lesson = $stmt->fetch();
                        ?>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Navigazione Lezioni</h3>
                            </div>
                            <div class="card-body">
                                <?php if ($prev_lesson): ?>
                                <a href="lesson.php?id=<?php echo $prev_lesson['id']; ?>" class="btn btn-outline-secondary btn-block mb-2">
                                    <i class="fas fa-arrow-left"></i> Lezione Precedente
                                </a>
                                <?php endif; ?>

                                <?php if ($next_lesson): ?>
                                <a href="lesson.php?id=<?php echo $next_lesson['id']; ?>" class="btn btn-outline-secondary btn-block">
                                    Lezione Successiva <i class="fas fa-arrow-right"></i>
                                </a>
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