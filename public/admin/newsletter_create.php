<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/db.php';

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
include '../includes/header_dashboard.php';
?>

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

            <!-- Template di esempio -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Template di Esempio</h3>
                </div>
                <div class="card-body">
                    <p>Ecco un template HTML di esempio che puoi copiare e modificare:</p>
                    <div class="bg-light p-3 rounded">
                        <pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta charset="utf-8"&gt;
    &lt;title&gt;Newsletter Autoscuola Liana&lt;/title&gt;
&lt;/head&gt;
&lt;body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;"&gt;
    &lt;div style="background-color: #28a745; color: white; padding: 20px; text-align: center;"&gt;
        &lt;h1&gt;Autoscuola Liana&lt;/h1&gt;
        &lt;p&gt;La tua scuola guida di fiducia a Castellammare di Stabia&lt;/p&gt;
    &lt;/div&gt;

    &lt;div style="padding: 20px;"&gt;
        &lt;h2&gt;Titolo del Newsletter&lt;/h2&gt;
        &lt;p&gt;Contenuto del newsletter...&lt;/p&gt;

        &lt;div style="background-color: #f8f9fa; padding: 15px; margin: 20px 0; border-left: 4px solid #28a745;"&gt;
            &lt;h3&gt;Novità e Offerte&lt;/h3&gt;
            &lt;p&gt;Dettagli delle novità...&lt;/p&gt;
        &lt;/div&gt;

        &lt;a href="https://autoscuolaliana.it" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;"&gt;
            Visita il nostro sito
        &lt;/a&gt;
    &lt;/div&gt;

    &lt;div style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #666;"&gt;
        &lt;p&gt;Autoscuola Liana - Via Roma, 123 - 80053 Castellammare di Stabia (NA)&lt;/p&gt;
        &lt;p&gt;Tel: 081 123 4567 | Email: info@autoscuolaliana.it&lt;/p&gt;
        &lt;p&gt;&lt;a href="[UNSUBSCRIBE_URL]"&gt;Clicca qui per disiscriverti&lt;/a&gt;&lt;/p&gt;
    &lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Inizializza l'editor di testo se disponibile
$(document).ready(function() {
    // Puoi aggiungere qui un editor WYSIWYG come TinyMCE o CKEditor se necessario
});
</script>

<?php include '../includes/footer.php'; ?>