<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

// Verifica che l'utente sia admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = trim($_POST['subject'] ?? '');
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? 'draft';

    if (empty($subject) || empty($content)) {
        $message = 'Tutti i campi sono obbligatori.';
        $messageType = 'error';
    } else {
        $stmt = $pdo->prepare("INSERT INTO newsletters (subject, content, status, created_at) VALUES (?, ?, ?, NOW())");
        if ($stmt->execute([$subject, $content, $status])) {
            $message = 'Newsletter creato con successo.';
            $messageType = 'success';

            // Reindirizza alla lista se pubblicato
            if ($status === 'published') {
                header('Location: newsletter.php?message=' . urlencode($message));
                exit;
            }
        } else {
            $message = 'Errore durante la creazione del newsletter.';
            $messageType = 'error';
        }
    }
}

$pageTitle = 'Crea Newsletter';
$current_page = basename(__FILE__);
include '../../includes/header_dashboard.php';
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

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Crea Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="newsletter.php">Newsletter</a></li>
                        <li class="breadcrumb-item active">Crea</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nuovo Newsletter</h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="subject">Oggetto *</label>
                            <input type="text" class="form-control" id="subject" name="subject" required
                                   value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="content">Contenuto *</label>
                            <textarea class="form-control" id="content" name="content" rows="15" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">
                                Puoi utilizzare HTML per formattare il contenuto. Verrà inviato come email HTML.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="status">Stato</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft" <?php echo ($_POST['status'] ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Bozza</option>
                                <option value="published" <?php echo ($_POST['status'] ?? '') === 'published' ? 'selected' : ''; ?>>Pubblicato</option>
                            </select>
                            <small class="form-text text-muted">
                                Le bozze non possono essere inviate. Solo i newsletter pubblicati possono essere inviati ai sottoscrittori.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salva Newsletter
                        </button>
                        <a href="newsletter.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annulla
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
</div>

<script>
// Inizializza l'editor di testo se disponibile
$(document).ready(function() {
    // Puoi aggiungere qui un editor WYSIWYG come TinyMCE o CKEditor se necessario
});
</script>

<!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2025 <?php echo SITE_NAME; ?>.</strong> All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

</body>
</html>