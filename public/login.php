<?php
$page_title = 'Accedi';
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: ' . SITE_URL . '/admin/dashboard.php');
    } else {
        header('Location: ' . SITE_URL . '/student/dashboard.php');
    }
    exit;
}

// Handle login
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        if (login($email, $password)) {
            if (isAdmin()) {
                header('Location: ' . SITE_URL . '/admin/dashboard.php');
                echo '<script>window.location.href="' . SITE_URL . '/admin/dashboard.php";</script>';
            } else {
                header('Location: ' . SITE_URL . '/student/dashboard.php');
                echo '<script>window.location.href="' . SITE_URL . '/student/dashboard.php";</script>';
            }
            exit;
        } else {
            $message = 'Credenziali non valide.';
            $message_type = 'error';
        }
    } else {
        $message = 'Per favore, inserisci email e password.';
        $message_type = 'warning';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_NAME; ?> - Accedi</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Minimal Custom CSS for AdminLTE -->
  <link href="<?php echo SITE_URL; ?>/assets/css/custom_adminlte.css" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo SITE_URL; ?>"><b><?php echo SITE_NAME; ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Accedi per iniziare la tua sessione</p>

      <?php if ($message): ?>
      <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
      <?php endif; ?>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" placeholder="Email o Username" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Ricordami
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Accedi</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="forgot-password.php">Password dimenticata?</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
