<?php
$page_title = 'Reimposta Password';
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

// Check if token is provided
$token = $_GET['token'] ?? '';
$message = '';
$message_type = '';

if (!$token) {
    $message = 'Token di reset non valido o mancante.';
    $message_type = 'error';
} else {
    // Verify token
    $stmt = $db->prepare("SELECT id, email, reset_expiry FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $message = 'Token di reset non valido.';
        $message_type = 'error';
    } elseif (strtotime($user['reset_expiry']) < time()) {
        $message = 'Il token di reset è scaduto. Richiedi un nuovo link.';
        $message_type = 'error';
    }
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token && $user && strtotime($user['reset_expiry']) >= time()) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (strlen($password) < 6) {
        $message = 'La password deve essere di almeno 6 caratteri.';
        $message_type = 'warning';
    } elseif ($password !== $confirm_password) {
        $message = 'Le password non coincidono.';
        $message_type = 'error';
    } else {
        // Hash new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update password and clear reset token
        $stmt = $db->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE id = ?");
        $stmt->execute([$hashed_password, $user['id']]);

        $message = 'Password reimpostata con successo! Ora puoi accedere con la nuova password.';
        $message_type = 'success';

        // Clear user data to prevent form resubmission
        $user = null;
        $token = '';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_NAME; ?> - Reimposta Password</title>

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
      <p class="login-box-msg">Reimposta la tua password</p>

      <?php if ($message): ?>
      <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
      <?php endif; ?>

      <?php if ($token && $user && strtotime($user['reset_expiry']) >= time()): ?>
      <p class="text-muted">Inserisci la tua nuova password.</p>

      <form action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Nuova Password" required minlength="6">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Conferma Password" required minlength="6">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reimposta Password</button>
          </div>
        </div>
      </form>
      <?php else: ?>
      <div class="alert alert-danger">
        <p><?php echo $message ?: 'Link di reset non valido o scaduto.'; ?></p>
      </div>
      <p class="text-center">
        <a href="forgot-password.php">Richiedi un nuovo link</a>
      </p>
      <?php endif; ?>

      <p class="mt-3 mb-1">
        <a href="login.php">Torna al Login</a>
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

<!-- Custom JavaScript for messages -->
<script>
$(document).ready(function() {
    var messageDiv = $('div[data-php-message]');
    if (messageDiv.length > 0) {
        var message = messageDiv.data('php-message');
        var messageType = messageDiv.data('php-message-type');

        // Create toast notification
        var toastClass = 'bg-success';
        var toastIcon = 'fas fa-check-circle';

        if (messageType === 'error') {
            toastClass = 'bg-danger';
            toastIcon = 'fas fa-exclamation-triangle';
        } else if (messageType === 'warning') {
            toastClass = 'bg-warning';
            toastIcon = 'fas fa-exclamation-circle';
        }

        // Create toast HTML
        var toastHtml = '<div class="toast align-items-center text-white ' + toastClass + ' border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">' +
            '<div class="d-flex">' +
                '<div class="toast-body">' +
                    '<i class="' + toastIcon + ' me-2"></i>' + message +
                '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
            '</div>' +
        '</div>';

        // Append to body and show
        $('body').append('<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>');
        $('.toast-container').html(toastHtml);
        $('.toast').toast('show');

        // Remove toast after it's hidden
        $('.toast').on('hidden.bs.toast', function() {
            $(this).closest('.toast-container').remove();
        });
    }
});
</script>
</body>
</html>