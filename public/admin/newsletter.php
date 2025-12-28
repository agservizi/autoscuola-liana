<?php
session_start();
require_once '../../includes/auth.php';
require_once '../../includes/db.php';
require_once '../../includes/config.php';

// Verifica che l'utente sia admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Gestione delle azioni
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                if (isset($_POST['newsletter_id'])) {
                    $newsletterId = (int)$_POST['newsletter_id'];

                    // Elimina il newsletter
                    $stmt = $pdo->prepare("DELETE FROM newsletters WHERE id = ?");
                    if ($stmt->execute([$newsletterId])) {
                        $message = 'Newsletter eliminata con successo.';
                        $messageType = 'success';
                    } else {
                        $message = 'Errore durante l\'eliminazione del newsletter.';
                        $messageType = 'error';
                    }
                }
                break;

            case 'send':
                if (isset($_POST['newsletter_id'])) {
                    $newsletterId = (int)$_POST['newsletter_id'];

                    // Ottieni i dettagli del newsletter
                    $stmt = $pdo->prepare("SELECT * FROM newsletters WHERE id = ?");
                    $stmt->execute([$newsletterId]);
                    $newsletter = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($newsletter) {
                        // Ottieni tutti i sottoscrittori attivi
                        $stmt = $pdo->prepare("SELECT email FROM newsletter_subscribers WHERE is_active = 1");
                        $stmt->execute();
                        $subscribers = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        if (!empty($subscribers)) {
                            require_once '../../includes/EmailService.php';
                            $emailService = new EmailService();

                            $sentCount = 0;
                            $errors = [];

                            foreach ($subscribers as $email) {
                                try {
                                    $emailService->sendNewsletter($email, $newsletter['subject'], $newsletter['content']);
                                    $sentCount++;
                                } catch (Exception $e) {
                                    $errors[] = "Errore invio a $email: " . $e->getMessage();
                                }
                            }

                            // Crea una campagna
                            $stmt = $pdo->prepare("INSERT INTO newsletter_campaigns (newsletter_id, sent_at, recipient_count, status) VALUES (?, NOW(), ?, ?)");
                            $stmt->execute([$newsletterId, count($subscribers), 'sent']);

                            $message = "Newsletter inviata con successo a $sentCount destinatari.";
                            if (!empty($errors)) {
                                $message .= " Errori: " . implode(', ', $errors);
                            }
                            $messageType = 'success';
                        } else {
                            $message = 'Nessun sottoscrittore attivo trovato.';
                            $messageType = 'warning';
                        }
                    } else {
                        $message = 'Newsletter non trovato.';
                        $messageType = 'error';
                    }
                }
                break;
        }
    }
}

// Ottieni tutti i newsletter
$stmt = $pdo->query("SELECT n.*, COUNT(nc.id) as campaigns_count FROM newsletters n LEFT JOIN newsletter_campaigns nc ON n.id = nc.newsletter_id GROUP BY n.id ORDER BY n.created_at DESC");
$newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Statistiche
$totalSubscribers = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'active'")->fetchColumn();
$totalNewsletters = $pdo->query("SELECT COUNT(*) FROM newsletters")->fetchColumn();
$totalCampaigns = $pdo->query("SELECT COUNT(*) FROM newsletter_campaigns WHERE status = 'sent'")->fetchColumn();

$pageTitle = 'Gestione Newsletter';
include '../includes/header_dashboard.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestione Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : ($messageType === 'warning' ? 'warning' : 'danger'); ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Statistiche -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $totalSubscribers; ?></h3>
                            <p>Sottoscrittori Attivi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="newsletter_subscribers.php" class="small-box-footer">
                            Gestisci <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $totalNewsletters; ?></h3>
                            <p>Newsletter Create</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <a href="newsletter_create.php" class="small-box-footer">
                            Crea Nuovo <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $totalCampaigns; ?></h3>
                            <p>Campagne Inviate</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <a href="newsletter_campaigns.php" class="small-box-footer">
                            Visualizza <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'unsubscribed'")->fetchColumn(); ?></h3>
                            <p>Disiscritti</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
            </div>

            <!-- Lista Newsletter -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Newsletter</h3>
                    <div class="card-tools">
                        <a href="newsletter_create.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Crea Newsletter
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Oggetto</th>
                                <th>Stato</th>
                                <th>Creato il</th>
                                <th>Campagne</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($newsletters)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Nessun newsletter trovato.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($newsletters as $newsletter): ?>
                                    <tr>
                                        <td><?php echo $newsletter['id']; ?></td>
                                        <td><?php echo htmlspecialchars($newsletter['subject']); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $newsletter['status'] === 'draft' ? 'secondary' : 'success'; ?>">
                                                <?php echo $newsletter['status'] === 'draft' ? 'Bozza' : 'Pubblicato'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($newsletter['created_at'])); ?></td>
                                        <td><?php echo $newsletter['campaigns_count']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="newsletter_edit.php?id=<?php echo $newsletter['id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="newsletter_preview.php?id=<?php echo $newsletter['id']; ?>" class="btn btn-sm btn-warning" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($newsletter['status'] === 'published'): ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="send">
                                                        <input type="hidden" name="newsletter_id" value="<?php echo $newsletter['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Inviare questo newsletter a tutti i sottoscrittori?')">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="newsletter_id" value="<?php echo $newsletter['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Eliminare questo newsletter?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>