<?php
require_once 'includes/db.php';
require_once 'includes/config.php';

$message = '';
$messageType = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email']) && isset($_GET['token'])) {
    $email = trim($_GET['email']);
    $token = $_GET['token'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Verifica se l'utente è iscritto
        $stmt = $pdo->prepare("SELECT id, is_active FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($subscriber) {
            if (!$subscriber['is_active']) {
                $message = 'Sei già disiscritto dalla newsletter.';
                $messageType = 'info';
            } else {
                // Disiscrivi l'utente
                $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_active = 0, unsubscribed_at = NOW() WHERE id = ?");
                if ($stmt->execute([$subscriber['id']])) {
                    $message = 'Ti sei disiscritto con successo dalla newsletter di Autoscuola Liana.';
                    $messageType = 'success';
                } else {
                    $message = 'Errore durante la disiscrizione. Riprova più tardi.';
                    $messageType = 'error';
                }
            }
        } else {
            $message = 'Email non trovata nella nostra lista newsletter.';
            $messageType = 'warning';
        }
    } else {
        $message = 'Email non valida.';
        $messageType = 'error';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Verifica se l'utente è iscritto
        $stmt = $pdo->prepare("SELECT id, is_active FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($subscriber) {
            if (!$subscriber['is_active']) {
                $message = 'Sei già disiscritto dalla newsletter.';
                $messageType = 'info';
            } else {
                // Disiscrivi l'utente
                $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_active = 0, unsubscribed_at = NOW() WHERE id = ?");
                if ($stmt->execute([$subscriber['id']])) {
                    $message = 'Ti sei disiscritto con successo dalla newsletter di Autoscuola Liana.';
                    $messageType = 'success';
                } else {
                    $message = 'Errore durante la disiscrizione. Riprova più tardi.';
                    $messageType = 'error';
                }
            }
        } else {
            $message = 'Email non trovata nella nostra lista newsletter.';
            $messageType = 'warning';
        }
    } else {
        $message = 'Inserisci un indirizzo email valido.';
        $messageType = 'error';
    }
}

$pageTitle = 'Disiscrizione Newsletter';
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope-open-text"></i>
                        Disiscrizione Newsletter
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php
                            echo $messageType === 'success' ? 'success' :
                                 ($messageType === 'error' ? 'danger' :
                                  ($messageType === 'warning' ? 'warning' : 'info'));
                        ?> alert-dismissible fade show" role="alert">
                            <i class="fas fa-<?php
                                echo $messageType === 'success' ? 'check-circle' :
                                     ($messageType === 'error' ? 'exclamation-triangle' :
                                      ($messageType === 'warning' ? 'exclamation-triangle' : 'info-circle'));
                            ?>"></i>
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="text-center mb-4">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">
                            Gestisci la tua iscrizione alla newsletter di Autoscuola Liana
                        </p>
                    </div>

                    <form method="POST" id="unsubscribe-form">
                        <div class="form-group">
                            <label for="email">Indirizzo Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?php echo htmlspecialchars($_GET['email'] ?? $_POST['email'] ?? ''); ?>"
                                   placeholder="La tua email" required>
                            <small class="form-text text-muted">
                                Inserisci l'indirizzo email con cui ti sei iscritto alla newsletter
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-user-times"></i>
                                Disiscriviti dalla Newsletter
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-2">Vuoi iscriverti nuovamente?</p>
                        <a href="<?php echo SITE_URL; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-home"></i>
                            Torna al Sito
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>
                        Autoscuola Liana - Via Amato, 4 - 80053 Castellammare di Stabia (NA)<br>
                        Tel: 081 8701132 | Email: info@autoscuolaliana.it
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-submit se ci sono parametri GET validi
<?php if (isset($_GET['email']) && isset($_GET['token']) && !$message): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('unsubscribe-form').submit();
});
<?php endif; ?>
</script>

<?php include 'includes/footer.php'; ?>