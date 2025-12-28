<?php
require_once '../includes/config.php';
$page_title = 'Orari e Sede - Autoscuola Liana Castellammare di Stabia';
$meta_description = 'Orari di apertura Autoscuola Liana: Lun-Ven 8:00-20:00, Sab 8:00-18:00. Sede: Via Amato, 4 - 80053 Castellammare di Stabia (NA). Come raggiungerci in auto, treno e autobus.';
$meta_keywords = 'orari autoscuola, sede autoscuola Liana, indirizzo Castellammare di Stabia, orari apertura scuola guida, come raggiungere, parcheggio, trasporti pubblici';
$canonical_url = SITE_URL . '/orari-sede.php';
$og_type = 'website';
$og_title = 'Orari e Sede - Autoscuola Liana Castellammare di Stabia';
$og_description = 'Orari di apertura e indirizzo della sede di Autoscuola Liana a Castellammare di Stabia. Indicazioni stradali e trasporti pubblici.';
$og_image = SITE_URL . '/assets/img/sede-autoscuola.jpg';
require_once '../includes/auth.php';
require_once '../includes/header.php';
?>

<!-- Ultra Modern Location & Hours Hero -->
<section class="location-hero">
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
            <div class="hero-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <h1 class="hero-title">Orari & <span class="highlight">Sede</span></h1>
            <p class="hero-subtitle">Trova la nostra sede e scopri i nostri orari di apertura per iniziare il tuo percorso verso la patente</p>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">65+</div>
                    <div class="stat-label">Anni di esperienza</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Supporto emergenza</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Soddisfazione clienti</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Location Content -->
<section class="location-content">
    <div class="container">
        <!-- Location Grid -->
        <div class="location-grid">
            <!-- Contact Information Card -->
            <div class="location-card contact-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h2>La nostra sede</h2>
                    <p>Trova tutte le informazioni per raggiungerci</p>
                </div>

                <div class="card-body">
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Indirizzo</h4>
                                <p>Via Amato, 4<br>80053 Castellammare di Stabia (Napoli)<br>Italia</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Telefono</h4>
                                <p>+39 06 12345678</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Email</h4>
                                <p>info@autoscuolaliana.it</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Orari rapidi</h4>
                                <p>Lun-Ven: 8:00-20:00<br>Sab: 8:00-18:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hours Information Card -->
            <div class="location-card hours-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h2>Orari di apertura</h2>
                    <p>Scegli l'orario più conveniente per te</p>
                </div>

                <div class="card-body">
                    <div class="hours-sections">
                        <div class="hours-section">
                            <div class="section-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h4>Ufficio amministrativo</h4>
                            <div class="hours-list">
                                <div class="hours-item">
                                    <span class="day">Lunedì - Venerdì</span>
                                    <span class="time">8:00 - 20:00</span>
                                </div>
                                <div class="hours-item">
                                    <span class="day">Sabato</span>
                                    <span class="time">8:00 - 18:00</span>
                                </div>
                                <div class="hours-item closed">
                                    <span class="day">Domenica</span>
                                    <span class="time">Chiuso</span>
                                </div>
                            </div>
                        </div>

                        <div class="hours-section">
                            <div class="section-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <h4>Lezioni teoriche</h4>
                            <div class="hours-list">
                                <div class="hours-item">
                                    <span class="day">Mattina</span>
                                    <span class="time">9:00 - 13:00</span>
                                </div>
                                <div class="hours-item">
                                    <span class="day">Pomeriggio</span>
                                    <span class="time">14:00 - 18:00</span>
                                </div>
                                <div class="hours-item">
                                    <span class="day">Serale</span>
                                    <span class="time">19:00 - 21:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="hours-section">
                            <div class="section-icon">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <h4>Guide pratiche</h4>
                            <div class="practice-notice">
                                <i class="bi bi-calendar-check"></i>
                                <p>Su appuntamento</p>
                                <small>dal lunedì al sabato</small>
                                <a href="contatti.php" class="btn btn-sm btn-primary">Prenota ora</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Directions Section -->
        <div class="directions-section">
            <div class="section-header">
                <h2><i class="bi bi-signpost-2"></i> Come raggiungerci</h2>
                <p>Scopri tutti i modi per arrivare alla nostra sede</p>
            </div>

            <div class="directions-grid">
                <div class="direction-card">
                    <div class="direction-icon">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <div class="direction-content">
                        <h4>In auto</h4>
                        <p>Parcheggio gratuito disponibile direttamente di fronte alla sede. Segui le indicazioni per "Autoscuola Liana" a Castellammare di Stabia.</p>
                        <div class="direction-features">
                            <span class="feature"><i class="bi bi-p-circle"></i> Parcheggio gratuito</span>
                            <span class="feature"><i class="bi bi-sign-turn-right"></i> Facile accesso</span>
                        </div>
                    </div>
                </div>

                <div class="direction-card">
                    <div class="direction-icon">
                        <i class="bi bi-bus-front"></i>
                    </div>
                    <div class="direction-content">
                        <h4>In autobus</h4>
                        <p>Linee 1, 2, 3 - Fermata "Autoscuola Liana". La fermata è a soli 50 metri dalla nostra sede.</p>
                        <div class="direction-features">
                            <span class="feature"><i class="bi bi-person-walking"></i> 50m dalla fermata</span>
                            <span class="feature"><i class="bi bi-clock"></i> Ogni 10 minuti</span>
                        </div>
                    </div>
                </div>

                <div class="direction-card">
                    <div class="direction-icon">
                        <i class="bi bi-train-front"></i>
                    </div>
                    <div class="direction-content">
                        <h4>In treno</h4>
                        <p>Stazione di Castellammare di Stabia. Dalla stazione, prosegui a piedi per circa 10 minuti seguendo Via Amato.</p>
                        <div class="direction-features">
                            <span class="feature"><i class="bi bi-person-walking"></i> 10 min a piedi</span>
                            <span class="feature"><i class="bi bi-ticket-perforated"></i> Biglietto integrato</span>
                        </div>
                    </div>
                </div>

                <div class="direction-card">
                    <div class="direction-icon">
                        <i class="bi bi-bicycle"></i>
                    </div>
                    <div class="direction-content">
                        <h4>In bicicletta</h4>
                        <p>Racks per biciclette disponibili all'ingresso. La sede è facilmente raggiungibile dal centro storico.</p>
                        <div class="direction-features">
                            <span class="feature"><i class="bi bi-lock"></i> Racks sicuri</span>
                            <span class="feature"><i class="bi bi-tree"></i> Percorso ecologico</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <div class="section-header">
                <h2><i class="bi bi-map"></i> Trova la nostra sede</h2>
                <p>Visualizza la posizione esatta su Google Maps</p>
            </div>

            <div class="map-container">
                <div class="map-wrapper">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.123456789012!2d14.486365!3d40.702783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1sVia%20Amato%204%2C%2080053%20Castellammare%20di%20Stabia%20NA%2C%20Italia!5e0!3m2!1sit!2sit!4v1697123456789!5m2!1sit!2sit"
                        width="100%"
                        height="400"
                        style="border:0; border-radius: 20px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="map-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-p-circle"></i>
                        </div>
                        <span>Parcheggio gratuito</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-person-wheelchair"></i>
                        </div>
                        <span>Accessibile ai disabili</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-wifi"></i>
                        </div>
                        <span>Wi-Fi gratuito</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <span>Area relax</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="emergency-section">
            <div class="emergency-card">
                <div class="emergency-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="emergency-content">
                    <h3>Contatto di emergenza</h3>
                    <p>In caso di problemi durante le lezioni pratiche o emergenze, contattaci immediatamente al nostro numero dedicato:</p>

                    <div class="emergency-contact">
                        <a href="tel:+390612345678" class="emergency-phone">
                            <i class="bi bi-telephone"></i>
                            +39 06 12345678
                        </a>
                        <div class="emergency-info">
                            <span class="availability">Disponibile 24/7 per emergenze</span>
                            <span class="response">Risposta garantita entro 15 minuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="location-cta">
    <div class="cta-background">
        <div class="cta-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
    </div>

    <div class="container">
        <div class="cta-content">
            <h2>Pronto per <span class="highlight">iniziare?</span></h2>
            <p>Vieni a trovarci in sede per una consulenza gratuita e scopri il nostro metodo di insegnamento innovativo</p>

            <div class="cta-features">
                <div class="feature">
                    <i class="bi bi-person-check"></i>
                    <span>Consulenza gratuita</span>
                </div>
                <div class="feature">
                    <i class="bi bi-calendar-event"></i>
                    <span>Appuntamento immediato</span>
                </div>
                <div class="feature">
                    <i class="bi bi-star"></i>
                    <span>Metodo collaudato</span>
                </div>
            </div>

            <div class="cta-buttons">
                <a href="contatti.php" class="btn btn-primary btn-3d">
                    <i class="bi bi-calendar-check"></i>
                    Prenota appuntamento
                </a>
                <a href="tel:+390612345678" class="btn btn-outline-light">
                    <i class="bi bi-telephone"></i>
                    Chiama ora
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Ultra Modern Location Hero */
.location-hero {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
    padding: 120px 0;
    color: white;
}

.location-hero .hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    background: linear-gradient(135deg, #0B5E28 0%, #138C3A 50%, #1FB25A 100%);
}

.location-hero .hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: linear-gradient(45deg,
        rgba(102, 126, 234, 0.9) 0%,
        rgba(118, 75, 162, 0.8) 50%,
        rgba(0, 242, 254, 0.7) 100%);
    animation: gradientShift 8s ease infinite; */
}

.location-hero .hero-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.location-hero .shape-1 {
    width: 300px;
    height: 300px;
    top: 10%;
    right: 5%;
    animation-delay: 0s;
}

.location-hero .shape-2 {
    width: 200px;
    height: 200px;
    bottom: 20%;
    left: 10%;
    animation-delay: 3s;
}

.location-hero .shape-3 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 15%;
    animation-delay: 6s;
}

.hero-content {
    position: relative;
    z-index: 3;
    text-align: center;
    max-width: 800px;
}

.hero-icon {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 30px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.hero-title {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-title .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.4rem;
    opacity: 0.9;
    margin-bottom: 3rem;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-top: 3rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #ffd700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Location Content */
.location-content {
    padding: 100px 0;
    background: #f8f9fa;
}

.location-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 80px;
}

.location-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.4s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.location-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    color: white;
    padding: 40px 30px 30px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

.card-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 20px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.card-header h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    position: relative;
    z-index: 2;
}

.card-header p {
    opacity: 0.9;
    font-size: 1rem;
    margin: 0;
    position: relative;
    z-index: 2;
}

.card-body {
    padding: 40px 30px;
}

/* Contact Details */
.contact-details {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.contact-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #1FB25A, #138C3A);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.contact-info h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.contact-info p {
    color: #5a6c7d;
    line-height: 1.5;
    margin: 0;
}

/* Hours Sections */
.hours-sections {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 30px;
}

.hours-section {
    text-align: center;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.hours-section:hover {
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

.section-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #1FB25A, #138C3A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin: 0 auto 15px;
}

.hours-section h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.hours-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.hours-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #e9ecef;
}

.hours-item.closed .time {
    color: #e74c3c;
    font-weight: 600;
}

.day {
    font-weight: 500;
    color: #2c3e50;
    font-size: 0.9rem;
}

.time {
    color: #138C3A;
    font-weight: 600;
    font-size: 0.9rem;
}

.practice-notice {
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.practice-notice i {
    font-size: 1.5rem;
    color: #138C3A;
    margin-bottom: 8px;
    display: block;
}

.practice-notice p {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.practice-notice small {
    color: #6c757d;
    font-size: 0.8rem;
    display: block;
    margin-bottom: 10px;
}

/* Directions Section */
.directions-section {
    margin-bottom: 80px;
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.section-header p {
    font-size: 1.2rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.directions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.direction-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.direction-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.direction-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #1FB25A, #138C3A);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    margin-bottom: 20px;
}

.direction-content h4 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.direction-content p {
    color: #5a6c7d;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.direction-features {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.direction-features .feature {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    color: #138C3A;
    font-weight: 500;
}

.direction-features .feature i {
    font-size: 0.8rem;
}

/* Map Section */
.map-section {
    margin-bottom: 80px;
}

.map-container {
    background: white;
    border-radius: 25px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.map-wrapper {
    margin-bottom: 30px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.map-features {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #5a6c7d;
    font-weight: 500;
}

.feature-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #1FB25A, #138C3A);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

/* Emergency Section */
.emergency-section {
    margin-bottom: 80px;
}

.emergency-card {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    border-radius: 25px;
    padding: 50px;
    display: flex;
    align-items: center;
    gap: 40px;
    color: white;
    box-shadow: 0 20px 60px rgba(231, 76, 60, 0.3);
}

.emergency-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
}

.emergency-content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.emergency-content p {
    opacity: 0.9;
    margin-bottom: 2rem;
    line-height: 1.6;
    font-size: 1.1rem;
}

.emergency-contact {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.emergency-phone {
    color: white;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    padding: 15px 25px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.emergency-phone:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.emergency-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.emergency-info span {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* CTA Section */
.location-cta {
    position: relative;
    padding: 100px 0;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    overflow: hidden;
}

.location-cta .cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.location-cta .cta-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    animation: float 8s ease-in-out infinite;
}

.location-cta .shape-1 {
    width: 400px;
    height: 400px;
    top: -200px;
    right: -100px;
    animation-delay: 0s;
}

.location-cta .shape-2 {
    width: 250px;
    height: 250px;
    bottom: -125px;
    left: -50px;
    animation-delay: 4s;
}

.cta-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.cta-content h2 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
}

.cta-content h2 .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.cta-content p {
    font-size: 1.3rem;
    opacity: 0.9;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.cta-features {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.cta-features .feature {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 500;
}

.cta-features .feature i {
    color: #ffd700;
    font-size: 1.2rem;
}

.cta-buttons {
    display: flex;
    gap: 2rem;
    justify-content: center;
    flex-wrap: wrap;
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

@keyframes pulse {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .hours-sections {
        grid-template-columns: 1fr 1fr;
    }

    .directions-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 768px) {
    .location-hero {
        padding: 80px 0;
        min-height: auto;
    }

    .hero-title {
        font-size: 2.8rem;
    }

    .hero-stats {
        flex-direction: column;
        gap: 2rem;
    }

    .location-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .hours-sections {
        grid-template-columns: 1fr;
    }

    .directions-grid {
        grid-template-columns: 1fr;
    }

    .emergency-card {
        flex-direction: column;
        text-align: center;
        gap: 30px;
        padding: 40px;
    }

    .cta-content h2 {
        font-size: 2.5rem;
    }

    .cta-features {
        flex-direction: column;
        gap: 1rem;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2.2rem;
    }

    .location-card {
        margin: 0 10px;
    }

    .card-body {
        padding: 30px 20px;
    }

    .emergency-card {
        margin: 0 10px;
        padding: 30px 20px;
    }

    .map-container {
        margin: 0 10px;
        padding: 30px 20px;
    }
}
</style>
                <div class="card-header">
                    <h2><i class="bi bi-geo-alt"></i> La nostra sede</h2>
                </div>
                <div class="card-body">
                    <div class="contact-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="detail-content">
                                <h4><?php echo SITE_NAME; ?></h4>
                                <p>Scuola Guida Professionale</p>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Indirizzo</h4>
                                <p>Via Amato, 4<br>80053 Castellammare di Stabia (Napoli)<br>Italia</p>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Telefono</h4>
                                <p>+39 06 12345678</p>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Email</h4>
                                <p>info@autoscuolaliana.it</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hours Information -->
            <div class="hours-card">
                <div class="card-header">
                    <h2><i class="bi bi-clock"></i> Orari di apertura</h2>
                </div>
                <div class="card-body">
                    <div class="hours-grid">
                        <div class="hours-section">
                            <h4>Ufficio amministrativo</h4>
                            <div class="hours-list">
                                <div class="hours-item">
                                    <span class="day">Lunedì - Venerdì</span>
                                    <span class="time">8:00 - 20:00</span>
                                </div>
                                <div class="hours-item">
                                    <span class="day">Sabato</span>
                                    <span class="time">8:00 - 18:00</span>
                                </div>
                                <div class="hours-item closed">
                                    <span class="day">Domenica</span>
                                    <span class="time">Chiuso</span>
                                </div>
                            </div>
                        </div>

                        <div class="hours-section">
                            <h4>Lezioni teoriche</h4>
                            <div class="hours-list">
                                <div class="hours-item">
                                    <span class="day">Mattina</span>
                                    <span class="time">9:00 - 13:00</span>
                                </div>
                                <div class="hours-item">
                                    <span class="day">Pomeriggio</span>
                                    <span class="time">14:00 - 18:00</span>
                                </div>
                                <div class="hours-item">
                                    <span class="day">Serale</span>
                                    <span class="time">19:00 - 21:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="hours-section">
                            <h4>Guide pratiche</h4>
                            <div class="hours-notice">
                                <i class="bi bi-calendar-check"></i>
                                <p>Su appuntamento dal lunedì al sabato</p>
                                <small>Contattaci per prenotare la tua lezione</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Directions -->
        <div class="directions-card">
            <div class="card-header">
                <h2><i class="bi bi-signpost-2"></i> Come raggiungerci</h2>
            </div>
            <div class="card-body">
                <div class="directions-grid">
                    <div class="direction-item">
                        <div class="direction-icon">
                            <i class="bi bi-car-front"></i>
                        </div>
                        <div class="direction-content">
                            <h4>In auto</h4>
                            <p>Parcheggio gratuito disponibile direttamente di fronte alla sede. Segui le indicazioni per "Autoscuola Liana" a Castellammare di Stabia.</p>
                        </div>
                    </div>

                    <div class="direction-item">
                        <div class="direction-icon">
                            <i class="bi bi-bus-front"></i>
                        </div>
                        <div class="direction-content">
                            <h4>In autobus</h4>
                            <p>Linee 1, 2, 3 - Fermata "Autoscuola Liana". La fermata è a soli 50 metri dalla nostra sede.</p>
                        </div>
                    </div>

                    <div class="direction-item">
                        <div class="direction-icon">
                            <i class="bi bi-train-front"></i>
                        </div>
                        <div class="direction-content">
                            <h4>In treno</h4>
                            <p>Stazione di Castellammare di Stabia. Dalla stazione, prosegui a piedi per circa 10 minuti seguendo Via Amato.</p>
                        </div>
                    </div>

                    <div class="direction-item">
                        <div class="direction-icon">
                            <i class="bi bi-bicycle"></i>
                        </div>
                        <div class="direction-content">
                            <h4>In bicicletta</h4>
                            <p>Racks per biciclette disponibili all'ingresso. La sede è facilmente raggiungibile dal centro storico.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-card">
            <div class="card-header">
                <h2><i class="bi bi-map"></i> Trova la nostra sede</h2>
            </div>
            <div class="card-body">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.123456789012!2d14.486365!3d40.702783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1sVia%20Amato%204%2C%2080053%20Castellammare%20di%20Stabia%20NA%2C%20Italia!5e0!3m2!1sit!2sit!4v1697123456789!5m2!1sit!2sit"
                        width="100%"
                        height="400"
                        style="border:0; border-radius: 12px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="map-info">
                    <div class="info-item">
                        <i class="bi bi-p-circle"></i>
                        <span>Parcheggio gratuito disponibile</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-person-wheelchair"></i>
                        <span>Accessibile ai disabili</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-wifi"></i>
                        <span>Wi-Fi gratuito</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="emergency-card">
            <div class="emergency-content">
                <div class="emergency-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="emergency-text">
                    <h3>Contatto di emergenza</h3>
                    <p>In caso di problemi durante le lezioni pratiche o emergenze, contattaci immediatamente:</p>
                    <div class="emergency-contact">
                        <a href="tel:+390612345678" class="emergency-phone">
                            <i class="bi bi-telephone"></i>
                            +39 06 12345678
                        </a>
                        <span class="emergency-note">Disponibile 24/7 per emergenze</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="location-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Pronto per iniziare?</h2>
            <p>Vieni a trovarci in sede per una consulenza gratuita e scopri il nostro metodo di insegnamento.</p>
            <div class="cta-buttons">
                <a href="contatti.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-calendar-check"></i> Prenota appuntamento
                </a>
                <a href="tel:+390612345678" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-telephone"></i> Chiama ora
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Location Page Styles */
.location-hero {
    background: linear-gradient(135deg, #1FB25A 0%, #138C3A 100%);
    color: white;
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.location-hero .hero-content {
    text-align: center;
    position: relative;
    z-index: 2;
}

.location-hero .hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.location-hero .hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('assets/img/road-pattern.svg') repeat, rgba(0,0,0,0.3);
    z-index: 1;
}

/* Main Content */
.location-content {
    padding: 80px 0;
    background: #f8f9fa;
}

.location-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 60px;
}

/* Cards */
.contact-info-card,
.hours-card,
.directions-card,
.map-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    padding: 25px 30px;
}

.card-header h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-body {
    padding: 30px;
}

/* Contact Details */
.contact-details {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.detail-icon {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3498db;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.detail-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.detail-content p {
    color: #5a6c7d;
    line-height: 1.5;
    margin: 0;
}

/* Hours */
.hours-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 30px;
}

.hours-section h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.hours-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.hours-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f8f9fa;
}

.hours-item.closed .time {
    color: #e74c3c;
    font-weight: 600;
}

.day {
    font-weight: 500;
    color: #2c3e50;
}

.time {
    color: #3498db;
    font-weight: 600;
}

.hours-notice {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.hours-notice i {
    font-size: 2rem;
    color: #3498db;
    margin-bottom: 10px;
    display: block;
}

.hours-notice p {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.hours-notice small {
    color: #6c757d;
}

/* Directions */
.directions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.direction-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.direction-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.direction-icon {
    width: 40px;
    height: 40px;
    background: #3498db;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.direction-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.direction-content p {
    color: #5a6c7d;
    line-height: 1.4;
    margin: 0;
    font-size: 0.9rem;
}

/* Map */
.map-container {
    margin-bottom: 20px;
}

.map-info {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-weight: 500;
}

.info-item i {
    color: #27ae60;
}

/* Emergency Contact */
.emergency-card {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
    border-radius: 12px;
    padding: 30px;
    margin: 40px 0;
}

.emergency-content {
    display: flex;
    align-items: center;
    gap: 25px;
}

.emergency-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.emergency-text h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.emergency-text p {
    opacity: 0.9;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.emergency-contact {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.emergency-phone {
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.emergency-phone:hover {
    opacity: 0.8;
}

.emergency-note {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* CTA Section */
.location-cta {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.location-cta .cta-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.location-cta .cta-content p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.location-cta .cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

/* Responsive Design */
@media (max-width: 768px) {
    .location-hero .hero-title {
        font-size: 2.5rem;
    }

    .location-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .hours-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }

    .directions-grid {
        grid-template-columns: 1fr;
    }

    .emergency-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }

    .map-info {
        flex-direction: column;
        gap: 15px;
        align-items: center;
    }
}
</style>

<?php require_once '../includes/footer.php'; ?>