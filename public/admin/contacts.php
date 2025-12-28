<?php
$page_title = 'Gestisci Contatti';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Handle delete contact
$message = '';
$message_type = '';
if (isset($_GET['delete'])) {
    $contact_id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM contacts WHERE id = ?");
    $result = $stmt->execute([$contact_id]);
    if ($result) {
        $message = 'Messaggio eliminato con successo.';
        $message_type = 'success';
    } else {
        $message = 'Errore durante l\'eliminazione del messaggio.';
        $message_type = 'error';
    }
}

// Get all contacts
$stmt = $db->query("SELECT * FROM contacts ORDER BY submitted_at DESC");
$contacts = $stmt->fetchAll();

require_once '../../includes/header_dashboard.php';
?>

<!-- AdminLTE Wrapper -->
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

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Gestisci Contatti</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Contatti</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Messaggi di Contatto</h3>
                            </div>
                            <div class="card-body">

        <!-- Alert Messages -->
        <?php if ($message): ?>
        <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo $message_type; ?>" style="display: none;"></div>
        <?php endif; ?>

        <!-- Contacts Statistics -->
        <div class="stats-grid">
            <div class="stat-card contacts">
                <div class="stat-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format(count($contacts)); ?></h3>
                    <p>Messaggi Totali</p>
                    <span class="stat-trend neutral">
                        <i class="bi bi-dash"></i> Questo mese
                    </span>
                </div>
            </div>
        </div>

        <!-- Contacts List -->
        <div class="dashboard-card">
            <div class="card-header">
                <h4><i class="bi bi-list"></i> Messaggi di Contatto (<?php echo count($contacts); ?>)</h4>
                <div class="card-actions">
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cerca messaggi..." style="width: 200px;">
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($contacts)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-envelope" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">Nessun messaggio trovato</h5>
                        <p>I messaggi di contatto appariranno qui quando gli utenti invieranno richieste.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="contactsTable">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Messaggio</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y H:i', strtotime($contact['submitted_at'])); ?></td>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($contact['message'] ?? '', 0, 100)) . (strlen($contact['message'] ?? '') > 100 ? '...' : ''); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-info" title="Visualizza" onclick="viewMessage(<?php echo $contact['id']; ?>)">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="btn btn-sm btn-outline-primary" title="Rispondi">
                                                    <i class="bi bi-reply"></i>
                                                </a>
                                                <a href="contacts.php?delete=<?php echo $contact['id']; ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questo messaggio?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

            </div>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2025 <?php echo SITE_NAME; ?>.</strong> All rights reserved.
    </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
// Initialize components
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-toggle="popover"]').popover();
});

// View message in modal
function viewMessage(id) {
    // Find the contact data from the table row
    const row = document.querySelector(`tr[data-contact-id="${id}"]`) || document.querySelector(`button[onclick*="${id}"]`).closest('tr');
    if (!row) return;
    
    const cells = row.querySelectorAll('td');
    const date = cells[0].textContent;
    const name = cells[1].textContent;
    const email = cells[2].textContent;
    const message = cells[3].textContent;
    
    // Create or get modal
    let modal = document.getElementById('messageModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'messageModal';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Messaggio di Contatto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <strong>Data:</strong> ${date}
                        </div>
                        <div class="mb-3">
                            <strong>Nome:</strong> ${name}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> ${email}
                        </div>
                        <div class="mb-3">
                            <strong>Messaggio:</strong>
                            <div class="mt-2 p-3 bg-light rounded">${message}</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    modal.querySelector('.modal-body').innerHTML = `
        <div class="mb-3">
            <strong>Data:</strong> ${date}
        </div>
        <div class="mb-3">
            <strong>Nome:</strong> ${name}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> ${email}
        </div>
        <div class="mb-3">
            <strong>Messaggio:</strong>
            <div class="mt-2 p-3 bg-light rounded">${message}</div>
        </div>
    `;
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}
</script>

</body>
</html>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dettagli Messaggio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="messageContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput')?.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#contactsTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// View message details
function viewMessage(contactId) {
    // For now, we'll just show an alert. In a real application, you'd fetch the full message via AJAX
    const row = document.querySelector(`tr:has(button[onclick*="viewMessage(${contactId})"])`);
    const cells = row.querySelectorAll('td');
    const date = cells[0].textContent;
    const name = cells[1].textContent;
    const email = cells[2].textContent;
    const message = cells[3].textContent;

    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
    document.getElementById('messageContent').innerHTML = `
        <div class="mb-3">
            <strong>Data:</strong> ${date}
        </div>
        <div class="mb-3">
            <strong>Nome:</strong> ${name}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> ${email}
        </div>
        <div class="mb-3">
            <strong>Messaggio:</strong>
            <div class="mt-2 p-3 bg-light rounded">${message}</div>
        </div>
    `;
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}
</script>

</body>
</html>