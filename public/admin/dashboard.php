<?php
$page_title = 'Dashboard Admin';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Get statistics
$stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$total_students = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM courses");
$total_courses = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM quizzes");
$total_quizzes = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM quiz_attempts");
$total_attempts = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM contacts");
$total_contacts = $stmt->fetch()['count'];

// Get chart data - students registered by month (last 6 months)
$stmt = $db->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
    FROM users
    WHERE role = 'student' AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month
");
$student_chart_data = $stmt->fetchAll();

// Get quiz performance data
$stmt = $db->query("
    SELECT q.title, AVG(qa.score) as avg_score, COUNT(qa.id) as attempts
    FROM quizzes q
    LEFT JOIN quiz_attempts qa ON q.id = qa.quiz_id
    GROUP BY q.id, q.title
    HAVING attempts > 0
    ORDER BY avg_score DESC
    LIMIT 5
");
$quiz_performance = $stmt->fetchAll();

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
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                            <a href="students.php" class="small-box-footer">Più info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo number_format($total_courses); ?></h3>
                                <p>Corsi Disponibili</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <a href="courses.php" class="small-box-footer">Più info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo number_format($total_quizzes); ?></h3>
                                <p>Quiz Creati</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <a href="quizzes.php" class="small-box-footer">Più info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo number_format($total_attempts); ?></h3>
                                <p>Tentativi Quiz</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="small-box-footer">&nbsp;</div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row">
                    <!-- Student Registration Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Registrazioni Studenti (Ultimi 6 Mesi)</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="studentChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Performance Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Performance Quiz</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="quizChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Azioni Rapide</h3>
                            </div>
                            <div class="card-body">
                                <a href="courses.php?action=add" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Aggiungi Corso
                                </a>
                                <a href="students.php" class="btn btn-secondary">
                                    <i class="fas fa-users"></i> Gestisci Studenti
                                </a>
                                <a href="quizzes.php?action=add" class="btn btn-success">
                                    <i class="fas fa-question-circle"></i> Crea Quiz
                                </a>
                                <a href="contacts.php" class="btn btn-info">
                                    <i class="fas fa-envelope"></i> Visualizza Contatti
                                </a>
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
// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Student Registration Chart
    const studentCtx = document.getElementById('studentChart');
    if (studentCtx) {
        const studentData = <?php echo json_encode($student_chart_data); ?>;
        const labels = studentData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('it-IT', { month: 'short', year: 'numeric' });
        });
        const data = studentData.map(item => parseInt(item.count));

        new Chart(studentCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nuovi Studenti',
                    data: data,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Quiz Performance Chart
    const quizCtx = document.getElementById('quizChart');
    if (quizCtx) {
        const quizData = <?php echo json_encode($quiz_performance); ?>;
        const labels = quizData.map(item => item.title.length > 20 ? item.title.substring(0, 20) + '...' : item.title);
        const scores = quizData.map(item => parseFloat(item.avg_score));

        new Chart(quizCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Punteggio Medio (%)',
                    data: scores,
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: '#28a745',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    }
});
</script>


</div>
<!-- ./wrapper -->

</body>
</html>
