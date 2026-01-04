<?php
require_once '../includes/config.php';
$page_title = 'Autoscuola Liana - Scuola Guida Castellammare di Stabia | Patente di Guida';
$meta_description = 'Autoscuola Liana a Castellammare di Stabia offre corsi completi per patente di guida B, A e superiori. Lezioni teoriche online e pratiche con auto moderne. Istruttori qualificati, tassi di successo elevati. Iscriviti ora!';
$meta_keywords = 'autoscuola Castellammare di Stabia, scuola guida Napoli, patente B, patente A, corso patente, lezioni guida, esame teorico, esame pratico, autoscuola Liana, patente moto, patente camion';
$canonical_url = SITE_URL . '/';
$og_type = 'website';
$og_title = 'Autoscuola Liana - Scuola Guida Castellammare di Stabia | Patente di Guida';
$og_description = 'Autoscuola Liana a Castellammare di Stabia offre corsi completi per patente di guida B, A e superiori. Lezioni teoriche online e pratiche con auto moderne.';
$og_image = SITE_URL . '/assets/img/autoscuola-liana-hero.jpg';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Get statistics
$stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$total_students = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM courses");
$total_courses = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM quiz_attempts WHERE passed = 1");
$passed_quizzes = $stmt->fetch()['count'];

require_once '../includes/header.php';
?>

<!-- Hero Section Ultra Modern -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-gradient"></div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="badge-text">🚗 Autoscuola Leader dal 1959</span>
            </div>

            <h1 class="hero-title">
                Guida il Tuo Futuro con
                <span class="highlight">Sicurezza</span>
            </h1>

            <p class="hero-subtitle">
                Formiamo conducenti eccellenti attraverso tecnologia avanzata,
                istruttori certificati e un metodo didattico rivoluzionario.
                La tua patente è solo l'inizio del viaggio.
            </p>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($total_students + 1500); ?>+</div>
                    <div class="stat-label">Studenti Formati</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Tasso Successo</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">65+</div>
                    <div class="stat-label">Anni Esperienza</div>
                </div>
            </div>

            <div class="hero-cta">
                <a href="contatti.php" class="btn btn-primary btn-3d">
                    <i class="bi bi-envelope"></i>
                    Contatta per Iscrizione
                </a>
                <a href="#features" class="btn btn-outline-light btn-scroll">
                    <i class="bi bi-chevron-down"></i>
                    Scopri di Più
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="floating-card card-1">
                <img src="assets/img/auto-license.jpg" alt="Patente Auto" style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
                <span>Patente Auto</span>
            </div>
            <div class="floating-card card-2">
                <img src="assets/img/moto-license.jpg" alt="Patente Moto" style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
                <span>Patente Moto</span>
            </div>
            <div class="floating-card card-3">
                <img src="assets/img/boat-license.jpg" alt="Patente Nautica" style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
                <span>Patente Nautica</span>
            </div>
        </div>
    </div>

    <div class="scroll-indicator">
        <div class="scroll-mouse">
            <div class="scroll-wheel"></div>
        </div>
        <span>Scroll Down</span>
    </div>
</section>

<!-- Features Section Ultra Modern -->
<section id="features" class="features-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Perché Scegliere Noi</div>
            <h2>Tecnologia & Innovazione</h2>
            <p>Siamo pionieri nell'educazione alla guida del futuro</p>
        </div>

        <div class="features-grid">
            <div class="feature-card premium">
                <div class="feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Sicurezza Prioritaria</h3>
                <p>Protocolli di sicurezza avanzati e formazione continua per zero incidenti.</p>
                <div class="feature-highlight">Zero Incidenti</div>
            </div>

            <div class="feature-card premium">
                <div class="feature-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <h3>Flessibilità Totale</h3>
                <p>Lezioni 24/7, weekend, serali. Adattiamo gli orari alla tua vita.</p>
                <div class="feature-highlight">Sempre Disponibili</div>
            </div>

            <div class="feature-card premium">
                <div class="feature-icon">
                    <i class="bi bi-laptop"></i>
                </div>
                <h3>Area Studenti</h3>
                <p>Lezioni online con quiz collegati alle unità didattiche per consolidare ogni modulo.</p>
                <div class="feature-highlight">Studio + Quiz</div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Showcase -->
<section class="courses-showcase">
    <div class="container">
        <div class="courses-header">
            <h2>I Nostri Percorsi Formativi</h2>
            <p>Scegli il percorso che fa per te</p>
        </div>

        <div class="courses-container">
            <?php
            $stmt = $db->query("SELECT * FROM courses ORDER BY id LIMIT 3");
            $courses = $stmt->fetchAll();

            foreach ($courses as $index => $course):
            ?>
            <div class="course-card-modern" style="animation-delay: <?php echo $index * 0.2; ?>s">
                <div class="course-header">
                    <div class="course-icon">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                </div>
                <div class="course-description">
                    <?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 100)) . '...'; ?>
                </div>
                <div class="course-features">
                    <span class="feature-tag">Teoria Online</span>
                    <span class="feature-tag">Pratica Guidata</span>
                    <span class="feature-tag">Simulatore</span>
                </div>
                <a href="corsi.php" class="course-btn">
                    Scopri il Corso
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="courses-cta">
            <a href="corsi.php" class="btn btn-secondary">
                Vedi Tutti i Corsi
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="testimonials-header">
            <h2>Cosa Dicono i Nostri Studenti</h2>
            <p>Esperienze reali da chi ha scelto la nostra autoscuola</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">
                    "Autoscuola Liana ha rivoluzionato il mio approccio alla guida.
                    Il simulatore mi ha fatto superare la paura iniziale!"
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">M</div>
                    <div class="author-info">
                        <div class="author-name">Marco Rossi</div>
                        <div class="author-title">Studente 2024</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">
                    "Grazie alla flessibilità degli orari ho potuto conciliare studio e patente.
                    Servizio eccellente e professionale!"
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <div class="author-name">Sara Bianchi</div>
                        <div class="author-title">Studente 2024</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">
                    "L'investimento in Autoscuola Liana è stato il migliore che potessi fare.
                    Ora guido con sicurezza e consapevolezza."
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">L</div>
                    <div class="author-info">
                        <div class="author-name">Luca Verdi</div>
                        <div class="author-title">Studente 2023</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section Ultra Modern -->
<section class="cta-section-modern">
    <div class="container">
        <div class="cta-content">
            <h2>Pronto a Cambiare la Tua Vita?</h2>
            <p>Unisciti alla rivoluzione della guida sicura. Iscriviti oggi e ricevi una lezione di prova gratuita!</p>
            <div class="cta-features">
                <div class="cta-feature">
                    <i class="bi bi-check-circle"></i>
                    <span>Lezione Gratuita</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-check-circle"></i>
                    <span>Materiali Inclusi</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-check-circle"></i>
                    <span>Senza Impegno</span>
                </div>
            </div>
            <div class="cta-buttons">
                <a href="contatti.php" class="btn btn-primary btn-3d">
                    <i class="bi bi-person-plus"></i>
                    Richiedi Informazioni
                </a>
                <a href="contatti.php" class="btn btn-outline-light">
                    <i class="bi bi-telephone"></i>
                    Contattaci
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Ultra Modern Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); */
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    background: linear-gradient(135deg, #0B5E28 0%, #138C3A 50%, #1FB25A 100%);
}

.hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: linear-gradient(45deg,
        rgba(102, 126, 234, 0.9) 0%,
        rgba(118, 75, 162, 0.8) 50%,
        rgba(240, 147, 251, 0.7) 100%);
    animation: gradientShift 8s ease infinite; */
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.hero-shapes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.hero-content {
    position: relative;
    z-index: 3;
    max-width: 600px;
    color: white;
    animation: slideInLeft 1s ease-out;
}

@keyframes slideInLeft {
    from { transform: translateX(-50px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.hero-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    padding: 8px 20px;
    margin-bottom: 20px;
    animation: fadeInDown 1s ease-out 0.2s both;
}

.badge-text {
    font-size: 0.9rem;
    font-weight: 500;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    animation: fadeInUp 1s ease-out 0.4s both;
}

.hero-title .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    line-height: 1.6;
    margin-bottom: 2rem;
    animation: fadeInUp 1s ease-out 0.6s both;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    animation: fadeInUp 1s ease-out 0.8s both;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #ffd700;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.hero-cta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    animation: fadeInUp 1s ease-out 1s both;
}

.btn-3d {
    position: relative;
    transform: translateY(0);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.btn-3d:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
}

.btn-scroll {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

.hero-visual {
    position: absolute;
    right: 10%;
    top: 50%;
    transform: translateY(-50%);
    z-index: 3;
    animation: slideInRight 1s ease-out 0.5s both;
}

@keyframes slideInRight {
    from { transform: translateX(50px) translateY(-50%); opacity: 0; }
    to { transform: translateX(0) translateY(-50%); opacity: 1; }
}

.floating-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    text-align: center;
    animation: floatCard 3s ease-in-out infinite;
}

.floating-card i {
    font-size: 2rem;
    color: #138C3A;
    margin-bottom: 10px;
}

.floating-card span {
    font-weight: 600;
    color: #333;
}

.card-1 { animation-delay: 0s; }
.card-2 { animation-delay: 1s; }
.card-3 { animation-delay: 2s; }

@keyframes floatCard {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    text-align: center;
    color: white;
    animation: fadeIn 1s ease-out 2s both;
}

.scroll-mouse {
    width: 24px;
    height: 36px;
    border: 2px solid rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    margin: 0 auto 10px;
    position: relative;
}

.scroll-wheel {
    width: 4px;
    height: 8px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 2px;
    position: absolute;
    top: 6px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll 2s infinite;
}

@keyframes scroll {
    0% { opacity: 0; transform: translateX(-50%) translateY(0); }
    50% { opacity: 1; transform: translateX(-50%) translateY(8px); }
    100% { opacity: 0; transform: translateX(-50%) translateY(16px); }
}

/* Features Section */
.features-section {
    padding: 100px 0;
    background: #f8f9fa;
    position: relative;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-badge {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.section-header h2 {
    font-size: 3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.section-header p {
    font-size: 1.2rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 30px;
    justify-items: stretch;
    align-items: stretch;
    max-width: 1100px;
    margin: 0 auto;
}

.feature-card {
    background: white;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
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

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.feature-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.feature-card p {
    color: #5a6c7d;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.feature-highlight {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    color: white;
    padding: 6px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-block;
}

/* Courses Showcase */
.courses-showcase {
    padding: 100px 0;
    background: white;
}

.courses-header {
    text-align: center;
    margin-bottom: 60px;
}

.courses-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.courses-header p {
    font-size: 1.1rem;
    color: #6c757d;
}

.courses-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.course-card-modern {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    animation: slideInUp 0.8s ease-out both;
}

@keyframes slideInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.course-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.course-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.course-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 15px;
    font-size: 1.2rem;
}

.course-header h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.course-description {
    color: #5a6c7d;
    line-height: 1.6;
    margin-bottom: 20px;
}

.course-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.feature-tag {
    background: #f8f9fa;
    color: #138C3A;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.course-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    color: white;
    padding: 12px 24px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.course-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.courses-cta {
    text-align: center;
}

/* Testimonials Section */
.testimonials-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.testimonials-header {
    text-align: center;
    margin-bottom: 60px;
}

.testimonials-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.testimonials-header p {
    font-size: 1.1rem;
    color: #6c757d;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
}

.testimonial-card {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    transition: all 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.testimonial-rating {
    color: #ffd700;
    margin-bottom: 20px;
}

.testimonial-text {
    font-size: 1.1rem;
    color: #5a6c7d;
    line-height: 1.6;
    margin-bottom: 25px;
    font-style: italic;
}

.testimonial-author {
    display: flex;
    align-items: center;
}

.author-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 15px;
}

.author-info .author-name {
    font-weight: 600;
    color: #2c3e50;
}

.author-info .author-title {
    font-size: 0.9rem;
    color: #6c757d;
}

/* CTA Section Modern */
.cta-section-modern {
    padding: 100px 0;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.cta-section-modern::before {
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
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: 1.3rem;
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

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .hero-stats {
        flex-direction: column;
        gap: 1rem;
    }

    .hero-visual {
        display: none;
    }

    .features-grid {
        grid-template-columns: 1fr;
    }

    .courses-container {
        grid-template-columns: 1fr;
    }

    .testimonials-grid {
        grid-template-columns: 1fr;
    }

    .cta-features {
        flex-direction: column;
        align-items: center;
    }

    .section-header h2 {
        font-size: 2rem;
    }

    .cta-content h2 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .hero-section {
        min-height: 90vh;
    }

    .hero-cta {
        flex-direction: column;
        align-items: center;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

/* Animations */
@keyframes fadeInDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>

<?php require_once '../includes/footer.php'; ?>