<?php
require_once '../includes/config.php';
$page_title = 'Corsi Patente - Autoscuola Liana Castellammare di Stabia';
$meta_description = 'Scopri tutti i corsi per patente di guida offerti da Autoscuola Liana: patente B auto, patente A moto, patente C camion. Corsi accelerati, lezioni teoriche online e pratiche. Prezzi competitivi.';
$meta_keywords = 'corsi patente, patente B, patente A, patente C, corso accelerato, lezioni teoria, esame patente, autoscuola Castellammare, prezzi patente, corso guida';
$canonical_url = SITE_URL . '/corsi.php';
$og_type = 'website';
$og_title = 'Corsi Patente - Autoscuola Liana Castellammare di Stabia';
$og_description = 'Scopri tutti i corsi per patente di guida offerti da Autoscuola Liana: patente B auto, patente A moto, patente C camion.';
$og_image = SITE_URL . '/assets/img/corsi-patente.jpg';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Fetch courses from database
$stmt = $db->query("SELECT * FROM courses ORDER BY id");
$courses = $stmt->fetchAll();

// Organizza corsi per categoria
$corsi_per_categoria = [];
foreach ($courses as $course) {
    $categoria = $course['category'] ?? 'generale';
    if (!isset($corsi_per_categoria[$categoria])) {
        $corsi_per_categoria[$categoria] = [];
    }
    $corsi_per_categoria[$categoria][] = $course;
}

require_once '../includes/header.php';
?>

<!-- Hero Section Corsi -->
<section class="courses-hero">
    <div class="hero-background">
        <div class="hero-gradient"></div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="badge-text">🚗 Corsi Professionali</span>
            </div>

            <h1 class="hero-title">
                I Nostri <span class="highlight">Corsi</span>
            </h1>

            <p class="hero-subtitle">
                Scopri tutti i percorsi formativi disponibili per ottenere la tua patente.
                Dalla teoria alla pratica, ti accompagniamo verso il successo con metodologie innovative.
            </p>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($courses); ?>+</div>
                    <div class="stat-label">Corsi Disponibili</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Tasso Successo</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Supporto Online</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Course Filters Section -->
<section class="filters-section">
    <div class="container">
        <div class="filters-header">
            <h2>Scegli la Tua Categoria</h2>
            <p>Filtra i corsi per trovare quello più adatto alle tue esigenze</p>
        </div>

        <div class="filters-grid">
            <button class="filter-btn active" data-filter="all">
                <i class="bi bi-grid"></i>
                <span>Tutti i Corsi</span>
            </button>
            <?php foreach (array_keys($corsi_per_categoria) as $categoria): ?>
            <button class="filter-btn" data-filter="<?php echo strtolower(str_replace(' ', '-', $categoria)); ?>">
                <i class="bi bi-car-front"></i>
                <span><?php echo htmlspecialchars(ucfirst($categoria)); ?></span>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Courses Grid Ultra Modern -->
<section class="courses-grid-section">
    <div class="container">
        <div class="courses-grid" id="coursesGrid">
            <?php foreach ($courses as $index => $course):
                $categoria = $course['category'] ?? 'generale';
                $categoria_class = strtolower(str_replace(' ', '-', $categoria));
            ?>
            <div class="course-card-modern" data-category="<?php echo $categoria_class; ?>" style="animation-delay: <?php echo ($index % 6) * 0.1; ?>s">
                <div class="course-header">
                    <div class="course-badge">
                        <?php if (strpos(strtolower($course['name']), 'patente b') !== false): ?>
                            <span class="badge-popular">Più Richiesto</span>
                        <?php elseif (strpos(strtolower($course['name']), 'a2') !== false): ?>
                            <span class="badge-new">Nuovo</span>
                        <?php endif; ?>
                    </div>
                    <div class="course-icon">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                    <div class="course-category"><?php echo htmlspecialchars($categoria); ?></div>
                </div>

                <div class="course-description">
                    <?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 120)) . (strlen($course['description'] ?? '') > 120 ? '...' : ''); ?>
                </div>

                <div class="course-features">
                    <?php
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM lessons WHERE course_id = ?");
                    $stmt->execute([$course['id']]);
                    $lesson_count = $stmt->fetch()['count'];
                    ?>
                    <div class="feature-item">
                        <i class="bi bi-book"></i>
                        <span><?php echo $lesson_count; ?> Lezioni</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-clock"></i>
                        <span>30-45 Giorni</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-people"></i>
                        <span>Classi Ridotte</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-phone"></i>
                        <span>App Mobile</span>
                    </div>
                </div>

                <div class="course-price">
                    <div class="price">€<?php echo rand(650, 950); ?></div>
                    <div class="price-note">Prezzo completo</div>
                </div>

                <div class="course-actions">
                    <?php if (isLoggedIn()): ?>
                        <a href="../student/dashboard.php?course=<?php echo $course['id']; ?>" class="btn btn-primary">
                            <i class="bi bi-play-circle"></i>
                            Accedi al Corso
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Accedi con Credenziali Fornite
                        </a>
                        <small class="text-muted d-block mt-2">Le credenziali sono rilasciate dalla segreteria al momento dell'iscrizione.</small>
                    <?php endif; ?>
                    <button class="btn btn-outline-primary course-info-btn" data-course-id="<?php echo $course['id']; ?>">
                        <i class="bi bi-info-circle"></i>
                        Dettagli
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($courses)): ?>
        <div class="no-courses">
            <div class="no-courses-icon">
                <i class="bi bi-search"></i>
            </div>
            <h3>Nessun corso trovato</h3>
            <p>Al momento non ci sono corsi disponibili in questa categoria.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Course Details Modal -->
<div class="modal fade" id="courseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dettagli del Corso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="courseModalBody">
                <!-- Course details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="courses-cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Hai Bisogno di Informazioni?</h2>
            <p>Contattaci per ricevere una consulenza gratuita sui nostri corsi e scoprire quale percorso fa per te.</p>
            <div class="cta-features">
                <div class="cta-feature">
                    <i class="bi bi-telephone"></i>
                    <span>Consulenza Telefonica</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-calendar-check"></i>
                    <span>Lezione di Prova Gratuita</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-geo-alt"></i>
                    <span>Visita la Sede</span>
                </div>
            </div>
            <div class="cta-buttons">
                <a href="contatti.php" class="btn btn-primary btn-3d">
                    <i class="bi bi-envelope"></i>
                    Richiedi Informazioni
                </a>
                <a href="tel:+390612345678" class="btn btn-outline-light">
                    <i class="bi bi-telephone"></i>
                    Chiama Ora
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Courses Hero Section */
.courses-hero {
    position: relative;
    min-height: 70vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    /* background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); */
}

.courses-hero .hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    background: linear-gradient(135deg, #0B5E28 0%, #138C3A 50%, #1FB25A 100%);
}

.courses-hero .hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: linear-gradient(45deg,
        rgba(79, 172, 254, 0.9) 0%,
        rgba(0, 242, 254, 0.8) 50%,
        rgba(142, 45, 226, 0.7) 100%);
    animation: gradientShift 6s ease infinite; */
}

.courses-hero .hero-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 4s ease-in-out infinite;
}

.courses-hero .shape-1 {
    width: 200px;
    height: 200px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.courses-hero .shape-2 {
    width: 150px;
    height: 150px;
    bottom: 30%;
    left: 15%;
    animation-delay: 2s;
}

.courses-hero .hero-content {
    position: relative;
    z-index: 3;
    max-width: 700px;
    color: white;
    animation: slideInLeft 1s ease-out;
}

.courses-hero .hero-title .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Filters Section */
.filters-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.filters-header {
    text-align: center;
    margin-bottom: 40px;
}

.filters-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.filters-header p {
    font-size: 1.1rem;
    color: #6c757d;
}

.filters-grid {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 25px;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    color: #6c757d;
}

.filter-btn:hover {
    border-color: #138C3A;
    color: #138C3A;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(19, 140, 58, 0.2);
}

.filter-btn.active {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-color: transparent;
    color: white;
    box-shadow: 0 5px 15px rgba(19, 140, 58, 0.3);
}

.filter-btn i {
    font-size: 1.2rem;
}

/* Courses Grid Section */
.courses-grid-section {
    padding: 80px 0;
    background: white;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 30px;
}

.course-card-modern {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.8s ease-out both;
    display: block; /* Assicurati che siano visibili per default */
}

.course-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.course-card-modern:hover::before {
    transform: scaleX(1);
}

.course-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.course-header {
    text-align: center;
    margin-bottom: 20px;
}

.course-badge {
    position: absolute;
    top: 20px;
    right: 20px;
}

.badge-popular {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.badge-new {
    background: linear-gradient(45deg, #00d2d3, #54a0ff);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.course-header .course-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto 15px;
    font-size: 1.5rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.course-header h3 {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.course-category {
    background: #f8f9fa;
    color: #138C3A;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-block;
}

.course-description {
    color: #5a6c7d;
    line-height: 1.6;
    margin-bottom: 20px;
    text-align: center;
}

.course-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 25px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #5a6c7d;
}

@media (max-width: 576px) {
    .course-features {
        grid-template-columns: 1fr;
    }
}

.feature-item i {
    color: #28a745;
    font-size: 0.8rem;
}

.course-price {
    text-align: center;
    margin-bottom: 25px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
}

.course-price .price {
    font-size: 2rem;
    font-weight: 700;
    color: #138C3A;
    display: block;
}

.course-price .price-note {
    font-size: 0.9rem;
    color: #6c757d;
}

.course-actions {
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.course-actions .btn {
    flex: 1;
    padding: 12px 20px;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.course-info-btn {
    border: 2px solid #138C3A;
    color: #138C3A;
}

.course-info-btn:hover {
    background: #138C3A;
    color: white;
}

/* No Courses State */
.no-courses {
    text-align: center;
    padding: 60px 20px;
    grid-column: 1 / -1;
}

.no-courses-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto 20px;
    font-size: 2rem;
}

.no-courses h3 {
    font-size: 1.5rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.no-courses p {
    color: #6c757d;
}

/* CTA Section */
.courses-cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.courses-cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.03"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.03"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
}

.cta-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.cta-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.cta-features {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.cta-feature {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    padding: 10px 20px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
}

.cta-feature i {
    color: #ffd700;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Modal Styles */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
    border-bottom: 1px solid #e9ecef;
    padding: 20px 30px;
}

.modal-title {
    font-weight: 600;
    color: #2c3e50;
}

.modal-body {
    padding: 30px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .courses-grid {
        grid-template-columns: 1fr;
    }

    .filters-grid {
        flex-direction: column;
        align-items: center;
    }

    .course-features {
        grid-template-columns: 1fr;
    }

    .course-actions {
        flex-direction: column;
    }

    .cta-features {
        flex-direction: column;
        align-items: center;
    }

    .courses-hero .hero-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 480px) {
    .courses-hero {
        min-height: 60vh;
    }

    .course-card-modern {
        padding: 20px;
    }

    .courses-hero .hero-stats {
        flex-direction: column;
        gap: 1rem;
    }
}

.courses-hero .stat-number,
.courses-hero .stat-label {
    color: #fff;
}

.courses-hero .stat-label {
    opacity: 0.9;
}

/* Animations */
@keyframes slideInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
// Course filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const courseCards = document.querySelectorAll('.course-card-modern');

    // Function to show courses based on filter
    function applyFilter(filterValue) {
        courseCards.forEach(card => {
            if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                card.style.display = 'block';
                card.style.animation = 'slideInUp 0.5s ease-out';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Apply initial filter (all)
    applyFilter('all');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');

            const filterValue = button.getAttribute('data-filter');
            applyFilter(filterValue);
        });
    });

    // Course info modal functionality
    const infoButtons = document.querySelectorAll('.course-info-btn');
    const courseModal = new bootstrap.Modal(document.getElementById('courseModal'));

    infoButtons.forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.getAttribute('data-course-id');
            // Here you could load course details via AJAX
            // For now, just show a placeholder
            document.getElementById('courseModalBody').innerHTML = `
                <div class="text-center">
                    <i class="bi bi-info-circle fa-3x text-primary mb-3"></i>
                    <h5>Dettagli del Corso</h5>
                    <p>Informazioni dettagliate sul corso saranno disponibili a breve.</p>
                    <p class="text-muted">ID Corso: ${courseId}</p>
                </div>
            `;
            courseModal.show();
        });
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>