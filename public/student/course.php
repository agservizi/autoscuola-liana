<?php
$page_title = 'Corso';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireStudent();

$current_page = basename(__FILE__);

$user_id = $_SESSION['user_id'] ?? 0;
$course_id = 4; // Always show course 4 (main theory course)

// Always show specific course (default to course 4)
$stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if (!$course) {
    header('Location: course.php');
    exit;
}

// Get lessons
$stmt = $db->prepare("SELECT l.*, lp.completed FROM lessons l LEFT JOIN lesson_progress lp ON l.id = lp.lesson_id AND lp.user_id = ? WHERE l.course_id = ? ORDER BY l.lesson_order");
$stmt->execute([$user_id, $course_id]);
$lessons = $stmt->fetchAll();

// Handle lesson completion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lesson_id'])) {
    $lesson_id = (int)$_POST['lesson_id'];
    $stmt = $db->prepare("INSERT INTO lesson_progress (user_id, lesson_id, completed, completed_at) VALUES (?, ?, 1, NOW()) ON DUPLICATE KEY UPDATE completed = 1, completed_at = NOW()");
    $stmt->execute([$user_id, $lesson_id]);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

require_once '../../includes/header_dashboard.php';
?>

<style>
.lesson-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #dee2e6;
}

.lesson-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.lesson-preview {
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
    font-size: 1rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .col-md-6.col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>

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
                        <h1 class="m-0"><?php echo htmlspecialchars($course['name'] ?? ''); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Lezioni</li>
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
                        <p class="mb-4"><?php echo htmlspecialchars($course['description'] ?? ''); ?></p>

                        <h3 class="mb-3">Lezioni del Corso</h3>

                        <div class="row">
                            <?php
                            // Get quizzes for this course
                            $stmt = $db->prepare("SELECT * FROM quizzes WHERE course_id = ? ORDER BY id");
                            $stmt->execute([$course_id]);
                            $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <?php foreach ($lessons as $index => $lesson): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card lesson-card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            Lezione <?php echo $lesson['lesson_order']; ?>: <?php echo htmlspecialchars($lesson['title'] ?? ''); ?>
                                            <?php if ($lesson['completed']): ?>
                                                <span class="badge badge-success float-right">Completata</span>
                                            <?php endif; ?>
                                        </h5>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="lesson-preview mb-3">
                                            <?php
                                            $content = $lesson['content'] ?? '';
                                            $preview = strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                                            echo htmlspecialchars($preview);
                                            ?>
                                        </div>

                                        <div class="mt-auto">
                                            <div class="btn-group-vertical w-100" role="group">
                                                <a href="lesson.php?id=<?php echo $lesson['id']; ?>" class="btn btn-primary mb-2">
                                                    <i class="fas fa-book-open"></i> Visualizza Lezione
                                                </a>

                                                <?php
                                                // Find corresponding quiz for this lesson
                                                $quiz = isset($quizzes[$index]) ? $quizzes[$index] : null;
                                                if ($quiz):
                                                ?>
                                                <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-success">
                                                    <i class="fas fa-question-circle"></i> Fai il Quiz
                                                </a>
                                                <?php else: ?>
                                                <button class="btn btn-secondary" disabled>
                                                    <i class="fas fa-question-circle"></i> Quiz non disponibile
                                                </button>
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