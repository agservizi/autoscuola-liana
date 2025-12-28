<?php
session_start();
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

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
                if (isset($_POST['subscriber_id'])) {
                    $subscriberId = (int)$_POST['subscriber_id'];

                    // Elimina il sottoscrittore
                    $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = ?");
                    if ($stmt->execute([$subscriberId])) {
                        $message = 'Sottoscrittore eliminato con successo.';
                        $messageType = 'success';
                    } else {
                        $message = 'Errore durante l\'eliminazione del sottoscrittore.';
                        $messageType = 'error';
                    }
                }
                break;

            case 'toggle_status':
                if (isset($_POST['subscriber_id'])) {
                    $subscriberId = (int)$_POST['subscriber_id'];

                    // Ottieni lo stato attuale
                    $stmt = $pdo->prepare("SELECT is_active FROM newsletter_subscribers WHERE id = ?");
                    $stmt->execute([$subscriberId]);
                    $currentStatus = (int)$stmt->fetchColumn();

                    // Cambia lo stato
                    $newStatus = $currentStatus ? 0 : 1;
                    $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_active = ? WHERE id = ?");
                    if ($stmt->execute([$newStatus, $subscriberId])) {
                        $message = 'Stato del sottoscrittore aggiornato con successo.';
                        $messageType = 'success';
                    } else {
                        $message = 'Errore durante l\'aggiornamento dello stato.';
                        $messageType = 'error';
                    }
                }
                break;

            case 'add_subscriber':
                $email = trim($_POST['email'] ?? '');
                $name = trim($_POST['name'] ?? '');

                if (empty($email)) {
                    $message = 'L\'email è obbligatoria.';
                    $messageType = 'error';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = 'L\'email non è valida.';
                    $messageType = 'error';
                } else {
                    // Verifica se l'email esiste già
                    $stmt = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        $message = 'Questa email è già iscritta alla newsletter.';
                        $messageType = 'warning';
                    } else {
                        $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, first_name, is_active, subscribed_at) VALUES (?, ?, 1, NOW())");
                        if ($stmt->execute([$email, $name])) {
                            $message = 'Sottoscrittore aggiunto con successo.';
                            $messageType = 'success';
                        } else {
                            $message = 'Errore durante l\'aggiunta del sottoscrittore.';
                            $messageType = 'error';
                        }
                    }
                }
                break;
        }
    }
}

// Filtri
$statusFilter = $_GET['status'] ?? 'all';
$search = trim($_GET['search'] ?? '');

// Costruzione query
$query = "SELECT * FROM newsletter_subscribers WHERE 1=1";
$params = [];

if ($statusFilter !== 'all') {
    $query .= " AND is_active = ?";
    $params[] = $statusFilter === 'active' ? 1 : 0;
}

if (!empty($search)) {
    $query .= " AND (email LIKE ? OR name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY subscribed_at DESC";

// Paginazione
$page = (int)($_GET['page'] ?? 1);
$perPage = 20;
$offset = ($page - 1) * $perPage;

$countQuery = str_replace("SELECT *", "SELECT COUNT(*)", $query);
$stmt = $pdo->prepare($countQuery);
$stmt->execute($params);
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $perPage);

$query .= " LIMIT ? OFFSET ?";
$params[] = $perPage;
$params[] = $offset;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Statistiche
$totalActive = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE is_active = 1")->fetchColumn();
$totalUnsubscribed = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE is_active = 0")->fetchColumn();
$totalAll = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers")->fetchColumn();

$pageTitle = 'Gestione Sottoscrittori Newsletter';
include '../includes/header_dashboard.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sottoscrittori Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="newsletter.php">Newsletter</a></li>
                        <li class="breadcrumb-item active">Sottoscrittori</li>
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
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $totalActive; ?></h3>
                            <p>Sottoscrittori Attivi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $totalUnsubscribed; ?></h3>
                            <p>Disiscritti</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $totalAll; ?></h3>
                            <p>Totale Iscritti</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aggiungi Sottoscrittore -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aggiungi Sottoscrittore</h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <input type="hidden" name="action" value="add_subscriber">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="name">Nome (opzionale)</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus"></i> Aggiungi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Lista Sottoscrittori -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista Sottoscrittori</h3>
                    <div class="card-tools">
                        <form method="GET" class="d-inline">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cerca per email o nome"
                                       value="<?php echo htmlspecialchars($search); ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtri -->
                    <div class="mb-3">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <a href="?status=all<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"
                               class="btn btn-outline-primary <?php echo $statusFilter === 'all' ? 'active' : ''; ?>">
                                Tutti (<?php echo $totalAll; ?>)
                            </a>
                            <a href="?status=active<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"
                               class="btn btn-outline-success <?php echo $statusFilter === 'active' ? 'active' : ''; ?>">
                                Attivi (<?php echo $totalActive; ?>)
                            </a>
                            <a href="?status=unsubscribed<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"
                               class="btn btn-outline-warning <?php echo $statusFilter === 'unsubscribed' ? 'active' : ''; ?>">
                                Disiscritti (<?php echo $totalUnsubscribed; ?>)
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Nome</th>
                                    <th>Stato</th>
                                    <th>Iscritto il</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($subscribers)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nessun sottoscrittore trovato.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($subscribers as $subscriber): ?>
                                        <tr>
                                            <td><?php echo $subscriber['id']; ?></td>
                                            <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                            <td><?php echo htmlspecialchars($subscriber['first_name'] ?: '-'); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $subscriber['is_active'] ? 'success' : 'warning'; ?>">
                                                    <?php echo $subscriber['is_active'] ? 'Attivo' : 'Disiscritto'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($subscriber['subscribed_at'])); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="toggle_status">
                                                        <input type="hidden" name="subscriber_id" value="<?php echo $subscriber['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-<?php echo $subscriber['is_active'] ? 'warning' : 'success'; ?>"
                                                                onclick="return confirm('<?php echo $subscriber['is_active'] ? 'Disiscrivere' : 'Riattivare'; ?> questo sottoscrittore?')">
                                                            <i class="fas fa-<?php echo $subscriber['is_active'] ? 'user-times' : 'user-check'; ?>"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="subscriber_id" value="<?php echo $subscriber['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Eliminare definitivamente questo sottoscrittore?')">
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

                    <!-- Paginazione -->
                    <?php if ($totalPages > 1): ?>
                        <div class="d-flex justify-content-center">
                            <nav>
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&status=<?php echo $statusFilter; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                                Precedente
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $statusFilter; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&status=<?php echo $statusFilter; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                                Successivo
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>