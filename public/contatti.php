<?php
require_once '../includes/config.php';
$page_title = 'Contatti - Autoscuola Liana Castellammare di Stabia';
$meta_description = 'Contatta Autoscuola Liana a Castellammare di Stabia. Telefono: +39 06 12345678, Email: info@autoscuolaliana.it. Via Amato, 4 - 80053 Castellammare di Stabia (NA). Orari: Lun-Ven 8-20, Sab 8-18.';
$meta_keywords = 'contatti autoscuola, telefono autoscuola Liana, indirizzo Castellammare di Stabia, email autoscuola, orari apertura, mappa sede, contatta scuola guida';
$canonical_url = SITE_URL . '/contatti.php';
$og_type = 'website';
$og_title = 'Contatti - Autoscuola Liana Castellammare di Stabia';
$og_description = 'Contatta Autoscuola Liana a Castellammare di Stabia. Telefono, email, indirizzo e orari di apertura.';
$og_image = SITE_URL . '/assets/img/contatti-autoscuola.jpg';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Handle form submission
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = sanitize($_POST['firstname'] ?? '');
    $lastname = sanitize($_POST['lastname'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $user_message = sanitize($_POST['message'] ?? '');

    if ($firstname && $lastname && $email && $subject && $user_message) {
        $full_name = $firstname . ' ' . $lastname;
        $stmt = $db->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$full_name, $email, $phone, $subject, $user_message])) {
            $message = 'Messaggio inviato con successo! Ti risponderemo presto.';
            $message_type = 'success';
        } else {
            $message = 'Errore nell\'invio del messaggio. Riprova.';
            $message_type = 'error';
        }
    } else {
        $message = 'Per favore, compila tutti i campi obbligatori.';
        $message_type = 'warning';
    }
}

require_once '../includes/header.php';
?>

<!-- Hero Section Contatti Ultra Modern -->
<section class="contacts-hero">
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
                <span class="badge-text">📞 Sempre Disponibili</span>
            </div>

            <h1 class="hero-title">
                Contattaci <span class="highlight">Subito</span>
            </h1>

            <p class="hero-subtitle">
                Hai domande sui nostri corsi? Hai bisogno di informazioni personalizzate?
                Il nostro team è pronto ad aiutarti. Scegli il modo che preferisci per metterti in contatto con noi.
            </p>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Supporto Online</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">< 1h</div>
                    <div class="stat-label">Risposta Media</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Soddisfazione</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Methods Section -->
<section class="contact-methods-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <span>Come Contattarci</span>
            </div>

            <h2 class="section-title">
                Scegli il <span class="highlight">Contatto</span> che Preferisci
            </h2>

            <p class="section-subtitle">
                Siamo sempre disponibili per rispondere alle tue domande e fornirti tutte le informazioni necessarie.
            </p>
        </div>

        <div class="contact-methods-grid">
            <div class="contact-method-card">
                <div class="method-icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <h3>Telefono</h3>
                <p>Chiamaci direttamente per una risposta immediata</p>
                <div class="method-details">
                    <a href="tel:+390612345678" class="method-link">
                        <i class="bi bi-telephone"></i>
                        +39 06 1234 5678
                    </a>
                    <span class="method-info">Lun-Ven: 9:00-18:00</span>
                </div>
                <div class="method-decoration"></div>
            </div>

            <div class="contact-method-card">
                <div class="method-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <h3>Email</h3>
                <p>Scrivici per informazioni dettagliate sui nostri corsi</p>
                <div class="method-details">
                    <a href="mailto:info@autoscuolaliana.it" class="method-link">
                        <i class="bi bi-envelope"></i>
                        info@autoscuolaliana.it
                    </a>
                    <span class="method-info">Risposta entro 24h</span>
                </div>
                <div class="method-decoration"></div>
            </div>

            <div class="contact-method-card">
                <div class="method-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h3>Sede Fisica</h3>
                <p>Vieni a trovarci presso la nostra sede a Castellammare di Stabia</p>
                <div class="method-details">
                    <div class="method-address">
                        <i class="bi bi-geo-alt"></i>
                        Via Amato, 4<br>
                        80053 Castellammare di Stabia (Napoli)
                    </div>
                    <span class="method-info">Apertura: Lun-Sab</span>
                </div>
                <div class="method-decoration"></div>
            </div>

            <div class="contact-method-card">
                <div class="method-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h3>Chat Online</h3>
                <p>Parla con noi in tempo reale dal nostro sito</p>
                <div class="method-details">
                    <button class="method-link chat-btn" onclick="startChat()">
                        <i class="bi bi-chat-dots"></i>
                        Avvia Chat
                    </button>
                    <span class="method-info">Disponibile ora</span>
                </div>
                <div class="method-decoration"></div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Info Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-form-grid">
            <!-- Contact Information -->
            <div class="contact-info-panel">
                <div class="info-header">
                    <h3>Informazioni <span class="highlight">Dettagliate</span></h3>
                    <p>Tutte le informazioni necessarie per raggiungerci e contattarci</p>
                </div>

                <div class="info-items">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Sede Principale</h4>
                            <p>
                                Via Amato, 4<br>
                                80053 Castellammare di Stabia (Napoli)<br>
                                Italia
                            </p>
                            <a href="#" class="info-link">Ottieni indicazioni</a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="info-content">
                            <h4>Orari di Apertura</h4>
                            <div class="hours-grid">
                                <div class="hours-day">
                                    <span>Lunedì - Venerdì</span>
                                    <span>9:00 - 18:00</span>
                                </div>
                                <div class="hours-day">
                                    <span>Sabato</span>
                                    <span>9:00 - 13:00</span>
                                </div>
                                <div class="hours-day">
                                    <span>Domenica</span>
                                    <span>Chiuso</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-p-circle"></i>
                        </div>
                        <div class="info-content">
                            <h4>Parcheggio</h4>
                            <p>Parcheggio gratuito disponibile nei pressi della sede</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-bus-front"></i>
                        </div>
                        <div class="info-content">
                            <h4>Trasporti Pubblici</h4>
                            <p>Treno Circumvesuviana - Stazione Castellammare di Stabia<br>Autobus linee locali SITA e CLP</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="info-content">
                            <h4>Informazioni Aziendali</h4>
                            <p>P.IVA: 02103640765</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="social-section">
                    <h4>Seguici sui Social</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-panel">
                <div class="form-header">
                    <h3>Invia un <span class="highlight">Messaggio</span></h3>
                    <p>Compila il form sottostante e ti risponderemo il prima possibile</p>
                </div>

                <?php if ($message): ?>
                <div class="message-alert message-<?php echo $message_type; ?>">
                    <div class="message-icon">
                        <i class="bi bi-<?php echo $message_type === 'success' ? 'check-circle' : ($message_type === 'error' ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
                    </div>
                    <div class="message-content">
                        <p><?php echo $message; ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <form action="contatti.php" method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-firstname">Nome *</label>
                            <input type="text" id="contact-firstname" name="firstname"
                                   placeholder="Il tuo nome" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-lastname">Cognome *</label>
                            <input type="text" id="contact-lastname" name="lastname"
                                   placeholder="Il tuo cognome" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-email">Email *</label>
                            <input type="email" id="contact-email" name="email"
                                   placeholder="tua@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-phone">Telefono</label>
                            <input type="tel" id="contact-phone" name="phone"
                                   placeholder="+39 123 456 7890">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact-subject">Argomento *</label>
                        <select id="contact-subject" name="subject" required>
                            <option value="">Seleziona un argomento</option>
                            <option value="informazioni-corsi">Informazioni sui corsi</option>
                            <option value="prenotazione-lezione">Prenotazione lezione</option>
                            <option value="iscrizione">Iscrizione corso</option>
                            <option value="recupero-punti">Recupero punti patente</option>
                            <option value="altro">Altro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact-message">Messaggio *</label>
                        <textarea id="contact-message" name="message" rows="5"
                                  placeholder="Descrivi la tua richiesta in dettaglio..." required></textarea>
                    </div>

                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="contact-privacy" required>
                            <span class="checkmark"></span>
                            Acconsento al trattamento dei dati personali secondo la
                            <a href="privacy.php" target="_blank">Privacy Policy</a> *
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-3d">
                        <i class="bi bi-send"></i>
                        Invia Messaggio
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="map-header">
            <h2>Come <span class="highlight">Raggiungerci</span></h2>
            <p>La nostra sede è facilmente raggiungibile con i mezzi pubblici e in auto</p>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2970.123456789012!2d12.496365!3d41.902783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDU0JzEwLjAiTiAxMsKwMjknNDYuOSJF!5e0!3m2!1sit!2sit!4v1234567890123!5m2!1sit!2sit" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <div class="map-features">
            <div class="map-feature">
                <i class="bi bi-train-front"></i>
                <span>Stazione Castellammare di Stabia</span>
            </div>
            <div class="map-feature">
                <i class="bi bi-bus-front"></i>
                <span>Autobus SITA e CLP</span>
            </div>
            <div class="map-feature">
                <i class="bi bi-car-front"></i>
                <span>Parcheggio Gratuito</span>
            </div>
            <div class="map-feature">
                <i class="bi bi-person-wheelchair"></i>
                <span>Accesso Disabili</span>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <span>FAQ</span>
            </div>

            <h2 class="section-title">
                Domande <span class="highlight">Frequenti</span>
            </h2>

            <p class="section-subtitle">
                Trova rapidamente le risposte alle domande più comuni sui nostri corsi e servizi.
            </p>
        </div>

        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <h4>Quali documenti servono per iscriversi?</h4>
                    <div class="faq-toggle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <p>Per iscriverti ai nostri corsi hai bisogno di: carta d'identità valida, codice fiscale, certificato medico di idoneità alla guida e 2 foto tessera. Per i minori è richiesta anche l'autorizzazione dei genitori.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>Quanto dura il corso per la patente B?</h4>
                    <div class="faq-toggle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <p>Il corso base dura circa 3 mesi con lezioni 2-3 volte a settimana. Il corso intensivo può essere completato in 4 settimane con lezioni giornaliere. La durata dipende anche dalla disponibilità individuale.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>È possibile pagare a rate?</h4>
                    <div class="faq-toggle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <p>Sì, offriamo la possibilità di pagamento rateizzato senza interessi fino a 12 mesi. Contattaci per conoscere le opzioni disponibili e trovare la soluzione più adatta alle tue esigenze.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>Cosa succede se non supero l'esame?</h4>
                    <div class="faq-toggle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <p>In caso di mancato superamento dell'esame, offriamo lezioni di recupero gratuite e supporto personalizzato per la preparazione al riesame. Il nostro tasso di successo al secondo tentativo è del 95%.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>Offrite corsi serali o weekend?</h4>
                    <div class="faq-toggle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <p>Sì, abbiamo corsi serali dal lunedì al venerdì (18:00-22:00) e corsi weekend (sabato e domenica). Questa opzione è ideale per chi lavora o studia durante il giorno.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>Quanto costa il corso completo?</h4>
                    <div class="faq-toggle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <p>I prezzi partono da €650 per il corso base fino a €950 per il corso intensivo con tutte le pratiche incluse. Offriamo sconti per studenti, pagamento rateale e pacchetti completi con esame incluso.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="contacts-cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Hai Ancora <span class="highlight">Domande?</span></h2>
            <p>
                Non esitare a contattarci. Il nostro team è sempre pronto ad aiutarti
                a scegliere il percorso formativo più adatto alle tue esigenze.
            </p>

            <div class="cta-features">
                <div class="cta-feature">
                    <i class="bi bi-headset"></i>
                    <span>Supporto Personalizzato</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-calendar-check"></i>
                    <span>Consulenza Gratuita</span>
                </div>
                <div class="cta-feature">
                    <i class="bi bi-shield-check"></i>
                    <span>100% Affidabile</span>
                </div>
            </div>

            <div class="cta-buttons">
                <a href="tel:+390612345678" class="btn btn-primary btn-3d">
                    <i class="bi bi-telephone"></i>
                    Chiama Ora
                </a>
                <a href="#contact-form" class="btn btn-outline-light">
                    <i class="bi bi-envelope"></i>
                    Scrivici
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Contacts Hero Section */
.contacts-hero {
    position: relative;
    min-height: 70vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
}

.contacts-hero .hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    background: linear-gradient(135deg, #0B5E28 0%, #138C3A 50%, #1FB25A 100%);
}

.contacts-hero .hero-gradient {
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

.contacts-hero .hero-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 4s ease-in-out infinite;
}

.contacts-hero .shape-1 {
    width: 200px;
    height: 200px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.contacts-hero .shape-2 {
    width: 150px;
    height: 150px;
    bottom: 30%;
    left: 15%;
    animation-delay: 2s;
}

.contacts-hero .shape-3 {
    width: 100px;
    height: 100px;
    top: 50%;
    right: 20%;
    animation-delay: 4s;
}

.contacts-hero .hero-content {
    position: relative;
    z-index: 3;
    max-width: 700px;
    color: white;
    animation: slideInLeft 1s ease-out;
}

.contacts-hero .hero-title .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Contact Methods Section */
.contact-methods-section {
    padding: 100px 0;
    background: white;
}

.contact-methods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.contact-method-card {
    background: white;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.contact-method-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.contact-method-card .method-icon {
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
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.contact-method-card h3 {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.contact-method-card p {
    color: #6c757d;
    margin-bottom: 20px;
}

.method-details {
    margin-bottom: 20px;
}

.method-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #138C3A;
    text-decoration: none;
    font-weight: 500;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.method-link:hover {
    color: #0B5E28;
    transform: translateX(5px);
}

.method-info {
    display: block;
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 5px;
}

.chat-btn {
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.method-decoration {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 0 0 20px 20px;
}

/* Contact Form Section */
.contact-form-section {
    padding: 100px 0;
    background: #f8f9fa;
}

.contact-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: start;
}

.contact-info-panel,
.contact-form-panel {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.info-header h3 .highlight {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.info-items {
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-bottom: 40px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.info-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.info-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.info-content p {
    color: #5a6c7d;
    line-height: 1.5;
    margin-bottom: 8px;
}

.info-link {
    color: #138C3A;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

.info-link:hover {
    text-decoration: underline;
}

.hours-grid {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.hours-day {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 0;
    border-bottom: 1px solid #e9ecef;
}

.hours-day:last-child {
    border-bottom: none;
}

.social-section h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* Contact Form */
.form-header h3 .highlight {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.message-alert {
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.message-success {
    background: linear-gradient(45deg, #d4edda, #c3e6cb);
    border: 1px solid #c3e6cb;
    color: #155724;
}

.message-error {
    background: linear-gradient(45deg, #f8d7da, #f5c6cb);
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.message-warning {
    background: linear-gradient(45deg, #fff3cd, #ffeaa7);
    border: 1px solid #ffeaa7;
    color: #856404;
}

.message-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-weight: 500;
    color: #2c3e50;
    font-size: 0.9rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 15px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #138C3A;
    box-shadow: 0 0 0 3px rgba(19, 140, 58, 0.1);
}

.checkbox-group {
    margin: 10px 0;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.9rem;
    line-height: 1.5;
    color: #5a6c7d;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-top: 2px;
    accent-color: #138C3A;
}

.checkbox-label a {
    color: #138C3A;
    text-decoration: none;
}

.checkbox-label a:hover {
    text-decoration: underline;
}

/* Map Section */
.map-section {
    padding: 100px 0;
    background: white;
}

.map-header {
    text-align: center;
    margin-bottom: 40px;
}

.map-header h2 .highlight {
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.map-container iframe {
    width: 100%;
    height: 400px;
    border: none;
}

.map-features {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.map-feature {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8f9fa;
    padding: 12px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    color: #5a6c7d;
}

.map-feature i {
    color: #138C3A;
}

/* FAQ Section */
.faq-section {
    padding: 100px 0;
    background: #f8f9fa;
}

.faq-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.faq-item {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

.faq-question {
    padding: 25px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    background: white;
    transition: all 0.3s ease;
}

.faq-question:hover {
    background: #f8f9fa;
}

.faq-question h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.faq-toggle {
    width: 30px;
    height: 30px;
    background: linear-gradient(45deg, #1FB25A, #138C3A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s ease;
}

.faq-item.active .faq-toggle {
    transform: rotate(45deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #f8f9fa;
}

.faq-item.active .faq-answer {
    max-height: 200px;
}

.faq-answer p {
    margin: 0;
    padding: 0 30px 25px 30px;
    color: #5a6c7d;
    line-height: 1.6;
}

/* CTA Section */
.contacts-cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.contacts-cta-section::before {
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

.cta-content h2 .highlight {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
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
    .contact-form-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .contact-methods-grid {
        grid-template-columns: 1fr;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .map-features {
        flex-direction: column;
        align-items: center;
    }

    .contacts-hero .hero-title {
        font-size: 2.5rem;
    }

    .section-title {
        font-size: 2.2rem;
    }

    .faq-question {
        padding: 20px;
    }

    .faq-answer p {
        padding: 0 20px 20px 20px;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

.contacts-hero .stat-number,
.contacts-hero .stat-label {
    color: #fff;
}

.contacts-hero .stat-label {
    opacity: 0.9;
}

@media (max-width: 480px) {
    .contacts-hero {
        min-height: 60vh;
    }

    .contact-method-card,
    .contact-info-panel,
    .contact-form-panel {
        padding: 25px;
    }

    .info-item {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .social-links {
        justify-content: center;
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

<script>
// FAQ functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const toggle = item.querySelector('.faq-toggle');

        question.addEventListener('click', () => {
            // Close all other FAQ items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });

            // Toggle current FAQ item
            item.classList.toggle('active');
        });
    });
});

// Chat functionality placeholder
function startChat() {
    alert('La chat sarà disponibile a breve. Nel frattempo, contattaci via telefono o email!');
}
</script>

<?php require_once '../includes/footer.php'; ?>