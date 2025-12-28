<?php
$page_title = 'Profilo';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireStudent();

$current_page = basename(__FILE__);

$user_id = $_SESSION['user_id'];

// Get user info
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitize($_POST['first_name'] ?? '');
    $last_name = sanitize($_POST['last_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');

    if ($first_name && $last_name && $email) {
        $stmt = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $email, $phone, $user_id]);

        $message = 'Profilo aggiornato con successo.';
        $message_type = 'success';

        // Update session
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;

        // Refresh user data
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
    } else {
        $message = 'Per favore, compila tutti i campi obbligatori.';
        $message_type = 'warning';
    }
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
                        <h1 class="m-0">Il Mio Profilo</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profilo</li>
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
                                <h3 class="card-title">Informazioni Personali</h3>
                            </div>
                            <div class="card-body">
                                <?php if ($message): ?>
                                <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
                                <?php endif; ?>

                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name" class="form-label">Nome *</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name" class="form-label">Cognome *</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Telefono</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Data Registrazione</label>
                                        <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($user['created_at'])); ?>" readonly>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check"></i> Aggiorna Profilo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Statistiche</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                // Get stats
                                $stmt = $db->prepare("SELECT COUNT(*) as total FROM lesson_progress WHERE user_id = ? AND completed = 1");
                                $stmt->execute([$user_id]);
                                $completed_lessons = $stmt->fetch()['total'];

                                $stmt = $db->prepare("SELECT COUNT(*) as total FROM quiz_attempts WHERE user_id = ?");
                                $stmt->execute([$user_id]);
                                $total_quizzes = $stmt->fetch()['total'];

                                $stmt = $db->prepare("SELECT COUNT(*) as total FROM quiz_attempts WHERE user_id = ? AND passed = 1");
                                $stmt->execute([$user_id]);
                                $passed_quizzes = $stmt->fetch()['total'];
                                ?>
                                <div class="text-center">
                                    <div class="mb-3">
                                        <h4><?php echo $completed_lessons; ?></h4>
                                        <p class="text-muted">Lezioni Completate</p>
                                    </div>
                                    <div class="mb-3">
                                        <h4><?php echo $total_quizzes; ?></h4>
                                        <p class="text-muted">Quiz Tentati</p>
                                    </div>
                                    <div class="mb-3">
                                        <h4><?php echo $passed_quizzes; ?></h4>
                                        <p class="text-muted">Quiz Superati</p>
                                    </div>
                                </div>
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