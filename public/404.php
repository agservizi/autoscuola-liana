<?php
$page_title = 'Pagina Non Trovata - Autoscuola Liana';
$meta_description = 'La pagina che stai cercando non è stata trovata. Torna alla home di Autoscuola Liana a Castellammare di Stabia per informazioni sui corsi patente.';
$meta_keywords = '404, pagina non trovata, autoscuola Liana, Castellammare di Stabia';
$canonical_url = SITE_URL . '/404.php';
http_response_code(404);
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/header.php';
?>

<!-- 404 Error Page -->
<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-code">404</div>
            <h1 class="error-title">Pagina Non Trovata</h1>
            <p class="error-description">
                La pagina che stai cercando potrebbe essere stata spostata, eliminata o il link potrebbe essere errato.
            </p>
            <div class="error-actions">
                <a href="<?php echo SITE_URL; ?>/" class="btn btn-primary">
                    <i class="bi bi-house"></i> Torna alla Home
                </a>
                <a href="<?php echo SITE_URL; ?>/contatti.php" class="btn btn-outline-primary">
                    <i class="bi bi-envelope"></i> Contattaci
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.error-page {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.error-content {
    text-align: center;
    max-width: 600px;
}

.error-code {
    font-size: 8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    opacity: 0.8;
}

.error-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.error-description {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #28a745;
    border: 2px solid #28a745;
    color: white;
}

.btn-primary:hover {
    background: #218838;
    border-color: #218838;
}

.btn-outline-primary {
    border: 2px solid white;
    color: white;
}

.btn-outline-primary:hover {
    background: white;
    color: #28a745;
}
</style>

<?php require_once '../includes/footer.php'; ?>