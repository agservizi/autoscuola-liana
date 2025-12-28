<?php
$page_title = 'Password Dimenticata';
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/EmailService.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: ' . SITE_URL . '/admin/dashboard.php');
    } else {
        header('Location: ' . SITE_URL . '/student/dashboard.php');
    }
    exit;
}

// Handle password reset request
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');

    if ($email) {
        // Check if email exists in database
        $stmt = $db->prepare("SELECT id, email, first_name, last_name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate reset token
            $reset_token = bin2hex(random_bytes(32));
            $reset_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Save reset token to database
            $stmt = $db->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE id = ?");
            $stmt->execute([$reset_token, $reset_expiry, $user['id']]);

            // Send reset email using Resend
            $reset_link = SITE_URL . "/reset-password.php?token=" . $reset_token;
            $user_name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

            $emailService = new EmailService();
            $emailResult = $emailService->sendPasswordResetEmail($email, $reset_link, $user_name);

            if ($emailResult['success']) {
                $message = 'Email di reset inviata! Controlla la tua casella di posta elettronica.';
                $message_type = 'success';
            } else {
                $message = 'Errore nell\'invio dell\'email. Riprova più tardi.';
                $message_type = 'error';
                error_log('Email sending failed: ' . ($emailResult['error'] ?? 'Unknown error'));
            }
        } else {
            $message = 'Email non trovata nel sistema.';
            $message_type = 'error';
        }
    } else {
        $message = 'Per favore, inserisci il tuo indirizzo email.';
        $message_type = 'warning';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_NAME; ?> - Password Dimenticata</title>

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
      <p class="login-box-msg">Recupera la tua password</p>
      <p class="text-muted">Inserisci il tuo indirizzo email e ti invieremo un link per reimpostare la password.</p>

      <?php if ($message): ?>
      <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
      <?php endif; ?>

      <form action="forgot-password.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Indirizzo Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Invia Link di Reset</button>
          </div>
        </div>
      </form>

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