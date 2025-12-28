<?php
require_once '../includes/config.php';
$page_title = 'Chi Siamo - Autoscuola Liana Castellammare di Stabia';
$meta_description = 'Autoscuola Liana ha oltre 65 anni di esperienza nell\'insegnamento della guida a Castellammare di Stabia. Istruttori qualificati, metodo didattico innovativo, tassi di successo elevati. Scopri la nostra storia.';
$meta_keywords = 'chi siamo autoscuola Liana, storia autoscuola, esperienza scuola guida, istruttori qualificati, metodo didattico, Castellammare di Stabia, 65 anni esperienza';
$canonical_url = SITE_URL . '/chi-siamo.php';
$og_type = 'website';
$og_title = 'Chi Siamo - Autoscuola Liana Castellammare di Stabia';
$og_description = 'Autoscuola Liana ha oltre 65 anni di esperienza nell\'insegnamento della guida. Istruttori qualificati e metodo didattico innovativo.';
$og_image = SITE_URL . '/assets/img/chi-siamo-autoscuola.jpg';
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
?>

<!-- Hero Section Chi Siamo Ultra Modern -->
<section class="about-hero">
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
                <span class="badge-text">🏆 Eccellenza dal 1959</span>
            </div>

            <h1 class="hero-title">
                Chi <span class="highlight">Siamo</span>
            </h1>

            <p class="hero-subtitle">
                Da oltre 65 anni formiamo conducenti sicuri e responsabili con passione,
                professionalità e tecnologie innovative per rendere l'apprendimento della guida
                accessibile a tutti.
            </p>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">65+</div>
                    <div class="stat-label">Anni di Esperienza</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15.000+</div>
                    <div class="stat-label">Studenti Formati</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Tasso di Successo</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section Ultra Modern -->
<section class="story-section">
    <div class="container">
        <div class="story-grid">
            <div class="story-content">
                <div class="section-badge">
                    <span>La Nostra Storia</span>
                </div>

                <h2 class="section-title">
                    Un Viaggio di <span class="highlight">Passione</span> per la Sicurezza Stradale
                </h2>

                <div class="story-text">
                    <p>
                        Fondata nel 1959 da un gruppo di istruttori appassionati, <?php echo SITE_NAME; ?> è nata con
                        l'obiettivo ambizioso di rivoluzionare l'insegnamento della guida in Italia. Quello che era
                        iniziato come un piccolo progetto locale si è trasformato in una delle autoscuole più affidabili
                        e innovative del paese.
                    </p>

                    <p>
                        Da oltre due decenni, accompagniamo migliaia di studenti nel loro percorso verso la patente,
                        fornendo non solo le competenze tecniche necessarie per guidare, ma anche l'educazione e la
                        mentalità per diventare conducenti responsabili e sicuri.
                    </p>
                </div>

                <div class="story-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Riconoscimenti</h4>
                            <p>Premi per l'eccellenza didattica e la sicurezza</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Team Qualificato</h4>
                            <p>Istruttori certificati e sempre aggiornati</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Innovazione</h4>
                            <p>Tecnologie avanzate per l'apprendimento</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="story-visual">
                <div class="story-image">
                    <img src="../assets/img/driving-school.jpg" alt="Autoscuola Liana - Formazione conducenti">
                </div>
                <div class="floating-stats">
                    <div class="floating-stat">
                        <div class="stat-number">2000</div>
                        <div class="stat-label">Anno Fondazione</div>
                    </div>
                    <div class="floating-stat">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Supporto</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Values Section Ultra Modern -->
<section class="mission-values-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <span>I Nostri Valori</span>
            </div>

            <h2 class="section-title">
                Missione e <span class="highlight">Valori</span> che Guidano il Nostro Lavoro
            </h2>

            <p class="section-subtitle">
                Ogni giorno ci impegniamo per rendere l'apprendimento della guida accessibile,
                sicuro e divertente per tutti i nostri studenti.
            </p>
        </div>

        <div class="mission-values-grid">
            <div class="mission-card">
                <div class="card-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>La nostra missione</h3>
                <p>
                    Rendere l'apprendimento della guida accessibile, sicuro e divertente. Crediamo che ogni persona
                    meriti di guidare con fiducia e responsabilità, contribuendo attivamente a rendere le strade più
                    sicure per tutti.
                </p>
                <div class="card-decoration"></div>
            </div>

            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="value-content">
                        <h4>Sicurezza</h4>
                        <p>Priorità assoluta alla formazione di conducenti sicuri attraverso metodologie didattiche avanzate.</p>
                    </div>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <div class="value-content">
                        <h4>Qualità</h4>
                        <p>Istruttori altamente qualificati e materiali didattici sempre aggiornati secondo le normative vigenti.</p>
                    </div>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="value-content">
                        <h4>Trasparenza</h4>
                        <p>Prezzi chiari, comunicazione aperta e totale disponibilità nel rispondere a qualsiasi domanda.</p>
                    </div>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <div class="value-content">
                        <h4>Innovazione</h4>
                        <p>Utilizzo delle tecnologie più avanzate per rendere l'apprendimento interattivo e coinvolgente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section Ultra Modern -->
<section class="team-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <span>Il Nostro Team</span>
            </div>

            <h2 class="section-title">
                Professionisti <span class="highlight">Qualificati</span> al Tuo Servizio
            </h2>

            <p class="section-subtitle">
                Un team di esperti dedicato alla tua formazione e al tuo successo.
            </p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <div class="member-avatar">
                    <img src="../assets/img/instructor-1.jpg" alt="Marco Rossi - Istruttore Senior">
                    <div class="member-badge">
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Marco Rossi</h4>
                    <p class="member-role">Istruttore Senior</p>
                    <p class="member-description">
                        Con oltre 15 anni di esperienza, Marco è specializzato nell'insegnamento della guida sicura
                        e nella preparazione agli esami teorici.
                    </p>
                    <div class="member-specialties">
                        <span>Guida Sicura</span>
                        <span>Esami Teorici</span>
                        <span>Patente B</span>
                    </div>
                </div>
            </div>

            <div class="team-member">
                <div class="member-avatar">
                    <img src="../assets/img/instructor-2.jpg" alt="Laura Bianchi - Istruttrice Teoria">
                    <div class="member-badge">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Laura Bianchi</h4>
                    <p class="member-role">Istruttrice Teoria</p>
                    <p class="member-description">
                        Esperta in didattica e psicologia dell'apprendimento, Laura rende le lezioni teoriche
                        coinvolgenti e memorabili.
                    </p>
                    <div class="member-specialties">
                        <span>Didattica</span>
                        <span>Psicologia</span>
                        <span>Teoria</span>
                    </div>
                </div>
            </div>

            <div class="team-member">
                <div class="member-avatar">
                    <img src="../assets/img/instructor-3.jpg" alt="Giuseppe Verdi - Responsabile Amministrativo">
                    <div class="member-badge">
                        <i class="bi bi-gear"></i>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Giuseppe Verdi</h4>
                    <p class="member-role">Responsabile Amministrativo</p>
                    <p class="member-description">
                        Gestisce l'organizzazione e garantisce che ogni studente riceva il supporto necessario
                        durante tutto il percorso formativo.
                    </p>
                    <div class="member-specialties">
                        <span>Organizzazione</span>
                        <span>Supporto</span>
                        <span>Amministrazione</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section Ultra Modern -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <span>Testimonianze</span>
            </div>

            <h2 class="section-title">
                Cosa Dicono i <span class="highlight">Nostri Studenti</span>
            </h2>

            <p class="section-subtitle">
                Le esperienze di chi ha scelto <?php echo SITE_NAME; ?> per ottenere la patente.
            </p>
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
                <div class="testimonial-content">
                    <p>
                        "Ho ottenuto la patente al primo tentativo grazie ai fantastici istruttori di <?php echo SITE_NAME; ?>.
                        Le lezioni erano chiare, pazienti e molto professionali. Lo consiglio vivamente!"
                    </p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <i class="bi bi-person-circle" style="font-size: 60px; color: #138C3A;"></i>
                    </div>
                    <div class="author-info">
                        <h5>Sara M.</h5>
                        <p>Patente B - 2023</p>
                    </div>
                </div>
                <div class="testimonial-decoration"></div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="testimonial-content">
                    <p>
                        "Dopo aver fallito due volte con un'altra autoscuola, ho deciso di provare <?php echo SITE_NAME; ?>.
                        Il metodo di insegnamento è completamente diverso e finalmente ho capito tutto. Grazie!"
                    </p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <i class="bi bi-person-circle" style="font-size: 60px; color: #1FB25A;"></i>
                    </div>
                    <div class="author-info">
                        <h5>Alessandro R.</h5>
                        <p>Patente B - 2023</p>
                    </div>
                </div>
                <div class="testimonial-decoration"></div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="testimonial-content">
                    <p>
                        "Le lezioni serali sono state perfette per conciliare lavoro e studio. Gli istruttori sono stati
                        disponibili e preparati. Un'esperienza positiva sotto ogni aspetto."
                    </p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <i class="bi bi-person-circle" style="font-size: 60px; color: #0B5E28;"></i>
                    </div>
                    <div class="author-info">
                        <h5>Maria G.</h5>
                        <p>Patente B - 2024</p>
                    </div>
                </div>
                <div class="testimonial-decoration"></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section Ultra Modern -->
<section class="about-cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Pronto a Iniziare il Tuo Percorso?</h2>
            <p>
                Unisciti a migliaia di studenti soddisfatti e ottieni la tua patente con <?php echo SITE_NAME; ?>.
                La tua sicurezza inizia qui.
            </p>

            <div class="cta-features">
                <div class="cta-feature">
                    <i class="bi bi-clock"></i>
                    <span>Lezioni Flessibili</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-currency-euro"></i>
                    <span>Prezzi Trasparenti</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-shield-check"></i>
                    <span>Sicurezza Garantita</span>
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
/* About Hero Section */
.about-hero {
    position: relative;
    min-height: 70vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
}

.about-hero .hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    background: linear-gradient(135deg, #0B5E28 0%, #138C3A 50%, #1FB25A 100%);
}

.about-hero .hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: linear-gradient(45deg,
        rgba(102, 126, 234, 0.9) 0%,
        rgba(118, 75, 162, 0.8) 50%,
        rgba(0, 242, 254, 0.7) 100%);
    animation: gradientShift 6s ease infinite; */
}

.about-hero .hero-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 4s ease-in-out infinite;
}

.about-hero .shape-1 {
    width: 200px;
    height: 200px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.about-hero .shape-2 {
    width: 150px;
    height: 150px;
    bottom: 30%;
    left: 15%;
    animation-delay: 2s;
}

.about-hero .shape-3 {
    width: 100px;
    height: 100px;
    top: 50%;
    right: 20%;
    animation-delay: 4s;
}

.about-hero .hero-content {
    position: relative;
    z-index: 3;
    max-width: 700px;
    color: white;
    animation: slideInLeft 1s ease-out;
}

.about-hero .hero-title .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Story Section */
.story-section {
    padding: 100px 0;
    background: white;
}

.story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.story-content {
    position: relative;
}

.section-badge {
    display: inline-block;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 2rem;
    line-height: 1.2;
}

.section-title .highlight {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.story-text p {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #5a6c7d;
    margin-bottom: 1.5rem;
}

.story-features {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    margin-top: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    transform: translateX(5px);
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.feature-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.feature-content p {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

.story-visual {
    position: relative;
}

.story-image {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.story-image img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.story-visual:hover .story-image img {
    transform: scale(1.05);
}

.floating-stats {
    position: absolute;
    bottom: -30px;
    left: -30px;
    display: flex;
    gap: 15px;
}

.floating-stat {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    min-width: 100px;
}

.floating-stat .stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #138C3A;
    display: block;
}

.floating-stat .stat-label {
    font-size: 0.8rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Mission & Values Section */
.mission-values-section {
    padding: 100px 0;
    background: #f8f9fa;
}

.mission-values-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 60px;
    align-items: start;
}

.mission-card {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.mission-card .card-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto 20px;
    box-shadow: 0 8px 25px rgba(19, 140, 58, 0.3);
}

.mission-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
    text-align: center;
}

.mission-card p {
    color: #5a6c7d;
    line-height: 1.6;
    text-align: center;
}

.mission-card .card-decoration {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
}

.values-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.value-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.value-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.value-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.value-content p {
    color: #5a6c7d;
    line-height: 1.5;
    margin: 0;
}

/* Team Section */
.team-section {
    padding: 100px 0;
    background: white;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 40px;
}

.team-member {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.team-member:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.member-avatar {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.member-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-member:hover .member-avatar img {
    transform: scale(1.05);
}

.member-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2c3e50;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
}

.member-info {
    padding: 25px;
}

.member-info h4 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.member-role {
    color: #138C3A;
    font-weight: 500;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.member-description {
    color: #5a6c7d;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.member-specialties {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.member-specialties span {
    background: #f8f9fa;
    color: #138C3A;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Testimonials Section */
.testimonials-section {
    padding: 100px 0;
    background: #f8f9fa;
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
    border: 1px solid #e9ecef;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.testimonial-rating {
    color: #ffd700;
    margin-bottom: 15px;
}

.testimonial-content p {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #5a6c7d;
    font-style: italic;
    margin-bottom: 20px;
    position: relative;
    padding-left: 20px;
}

.testimonial-content p:before {
    content: '"';
    font-size: 3rem;
    color: #138C3A;
    opacity: 0.2;
    position: absolute;
    top: -10px;
    left: 0;
    font-family: Georgia, serif;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 15px;
}

.author-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #138C3A;
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-info h5 {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.author-info p {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

.testimonial-decoration {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 0 0 20px 20px;
}

/* CTA Section */
.about-cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.about-cta-section::before {
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

/* Responsive Design */
@media (max-width: 768px) {
    .story-grid,
    .mission-values-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .values-grid {
        grid-template-columns: 1fr;
    }

    .team-grid {
        grid-template-columns: 1fr;
    }

    .testimonials-grid {
        grid-template-columns: 1fr;
    }

    .section-title {
        font-size: 2.2rem;
    }

    .about-hero .hero-title {
        font-size: 2.5rem;
    }

    .floating-stats {
        position: static;
        margin-top: 20px;
        justify-content: center;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .about-hero {
        min-height: 60vh;
    }

    .story-section {
        padding: 60px 0;
    }

    .mission-values-section,
    .team-section,
    .testimonials-section {
        padding: 60px 0;
    }

    .mission-card,
    .value-card,
    .testimonial-card {
        padding: 20px;
    }

    .team-member {
        max-width: 100%;
    }
}

/* Animations */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes slideInLeft {
    from { transform: translateX(-50px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
</style>

<?php require_once '../includes/footer.php'; ?>