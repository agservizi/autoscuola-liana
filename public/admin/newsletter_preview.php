<?php
session_start();
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

// Simula l'URL di disiscrizione per l'anteprima
$unsubscribeUrl = "https://autoscuolaliana.it/unsubscribe.php?email=example@email.com";

// Sostituisci il placeholder nell'HTML
$content = str_replace('[UNSUBSCRIBE_URL]', $unsubscribeUrl, $newsletter['content']);

$pageTitle = 'Anteprima Newsletter';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($newsletter['subject']); ?> - Anteprima</title>
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            padding: 20px;
        }
        .preview-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .preview-header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .preview-content {
            padding: 20px;
        }
        .preview-actions {
            background-color: #f8f9fa;
            padding: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }
        .email-preview {
            border: 1px solid #dee2e6;
            margin: 20px 0;
            background: white;
        }
        .email-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
            color: #666;
        }
        .email-body {
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="preview-container">
            <div class="preview-header">
                <h1>Anteprima Newsletter</h1>
                <p><?php echo htmlspecialchars($newsletter['subject']); ?></p>
            </div>

            <div class="preview-content">
                <div class="row">
                    <div class="col-md-8">
                        <h4>Dettagli Newsletter</h4>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td><?php echo $newsletter['id']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Oggetto:</strong></td>
                                <td><?php echo htmlspecialchars($newsletter['subject']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Stato:</strong></td>
                                <td>
                                    <span class="badge badge-<?php echo $newsletter['status'] === 'draft' ? 'secondary' : 'success'; ?>">
                                        <?php echo $newsletter['status'] === 'draft' ? 'Bozza' : 'Pubblicato'; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Creato il:</strong></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($newsletter['created_at'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Ultimo aggiornamento:</strong></td>
                                <td><?php echo $newsletter['updated_at'] ? date('d/m/Y H:i', strtotime($newsletter['updated_at'])) : 'Mai'; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h4>Azioni</h4>
                        <a href="newsletter_edit.php?id=<?php echo $newsletter['id']; ?>" class="btn btn-primary btn-block">
                            <i class="fas fa-edit"></i> Modifica
                        </a>
                        <a href="newsletter.php" class="btn btn-secondary btn-block">
                            <i class="fas fa-list"></i> Torna alla Lista
                        </a>
                        <?php if ($newsletter['status'] === 'published'): ?>
                            <button class="btn btn-success btn-block" onclick="sendNewsletter()">
                                <i class="fas fa-paper-plane"></i> Invia Newsletter
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <h4>Anteprima Email</h4>
                <div class="email-preview">
                    <div class="email-header">
                        <strong>Da:</strong> Autoscuola Liana &lt;info@autoscuolaliana.it&gt; |
                        <strong>A:</strong> [Destinatario] |
                        <strong>Oggetto:</strong> <?php echo htmlspecialchars($newsletter['subject']); ?>
                    </div>
                    <div class="email-body">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>

            <div class="preview-actions">
                <button onclick="window.close()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Chiudi Anteprima
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        function sendNewsletter() {
            if (confirm('Inviare questo newsletter a tutti i sottoscrittori attivi?')) {
                // Crea un form nascosto per inviare la richiesta
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'newsletter.php';
                form.target = '_parent';

                var actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'send';
                form.appendChild(actionInput);

                var idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'newsletter_id';
                idInput.value = '<?php echo $newsletter['id']; ?>';
                form.appendChild(idInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>