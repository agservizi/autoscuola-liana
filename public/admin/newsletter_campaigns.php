<?php
session_start();
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

// Verifica che l'utente sia admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Ottieni tutte le campagne
$stmt = $pdo->query("
    SELECT nc.*, n.subject as newsletter_subject
    FROM newsletter_campaigns nc
    JOIN newsletters n ON nc.newsletter_id = n.id
    ORDER BY nc.sent_at DESC
");
$campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Statistiche campagne
$totalCampaigns = count($campaigns);
$totalRecipients = array_sum(array_column($campaigns, 'recipient_count'));
$successfulCampaigns = count(array_filter($campaigns, function($c) { return $c['status'] === 'sent'; }));

$pageTitle = 'Campagne Newsletter';
include '../includes/header_dashboard.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Campagne Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="newsletter.php">Newsletter</a></li>
                        <li class="breadcrumb-item active">Campagne</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Statistiche -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $totalCampaigns; ?></h3>
                            <p>Campagne Totali</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $successfulCampaigns; ?></h3>
                            <p>Campagne Completate</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?php echo $totalRecipients; ?></h3>
                            <p>Email Inviate</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista Campagne -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Storico Campagne</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Newsletter</th>
                                <th>Data Invio</th>
                                <th>Destinatari</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($campaigns)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Nessuna campagna trovata.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($campaigns as $campaign): ?>
                                    <tr>
                                        <td><?php echo $campaign['id']; ?></td>
                                        <td><?php echo htmlspecialchars($campaign['newsletter_subject']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($campaign['sent_at'])); ?></td>
                                        <td><?php echo $campaign['recipient_count']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $campaign['status'] === 'sent' ? 'success' : 'warning'; ?>">
                                                <?php echo $campaign['status'] === 'sent' ? 'Inviata' : 'In Corso'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="newsletter_campaign_detail.php?id=<?php echo $campaign['id']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Dettagli
                                            </a>
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