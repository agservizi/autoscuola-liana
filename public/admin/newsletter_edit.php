<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

// Verifica che l'utente sia admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$newsletterId = (int)($_GET['id'] ?? 0);
if (!$newsletterId) {
    header('Location: newsletter.php');
    exit;
}

// Ottieni il newsletter
$stmt = $pdo->prepare("SELECT * FROM newsletters WHERE id = ?");
$stmt->execute([$newsletterId]);
$newsletter = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$newsletter) {
    header('Location: newsletter.php');
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
        $stmt = $pdo->prepare("UPDATE newsletters SET subject = ?, content = ?, status = ?, updated_at = NOW() WHERE id = ?");
        if ($stmt->execute([$subject, $content, $status, $newsletterId])) {
            $message = 'Newsletter aggiornato con successo.';
            $messageType = 'success';

            // Ricarica i dati
            $stmt = $pdo->prepare("SELECT * FROM newsletters WHERE id = ?");
            $stmt->execute([$newsletterId]);
            $newsletter = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = 'Errore durante l\'aggiornamento del newsletter.';
            $messageType = 'error';
        }
    }
}

$pageTitle = 'Modifica Newsletter';
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
                    <h1>Modifica Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="newsletter.php">Newsletter</a></li>
                        <li class="breadcrumb-item active">Modifica</li>
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
                    <h3 class="card-title">Modifica Newsletter #<?php echo $newsletter['id']; ?></h3>
                    <div class="card-tools">
                        <a href="newsletter_preview.php?id=<?php echo $newsletter['id']; ?>" class="btn btn-info btn-sm" target="_blank">
                            <i class="fas fa-eye"></i> Anteprima
                        </a>
                    </div>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="subject">Oggetto *</label>
                            <input type="text" class="form-control" id="subject" name="subject" required
                                   value="<?php echo htmlspecialchars($newsletter['subject']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="content">Contenuto *</label>
                            <textarea class="form-control" id="content" name="content" rows="15" required><?php echo htmlspecialchars($newsletter['content']); ?></textarea>
                            <small class="form-text text-muted">
                                Puoi utilizzare HTML per formattare il contenuto. Verrà inviato come email HTML.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="status">Stato</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft" <?php echo $newsletter['status'] === 'draft' ? 'selected' : ''; ?>>Bozza</option>
                                <option value="published" <?php echo $newsletter['status'] === 'published' ? 'selected' : ''; ?>>Pubblicato</option>
                            </select>
                            <small class="form-text text-muted">
                                Le bozze non possono essere inviate. Solo i newsletter pubblicati possono essere inviati ai sottoscrittori.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Creato il</label>
                                    <p class="form-control-plaintext"><?php echo date('d/m/Y H:i', strtotime($newsletter['created_at'])); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ultimo aggiornamento</label>
                                    <p class="form-control-plaintext">
                                        <?php echo $newsletter['updated_at'] ? date('d/m/Y H:i', strtotime($newsletter['updated_at'])) : 'Mai'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salva Modifiche
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

<!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2025 <?php echo SITE_NAME; ?>.</strong> All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

</body>
</html>