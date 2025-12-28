    </main>

    <!-- Footer Ultra Modern -->
    <footer class="modern-footer">
        <!-- Main Footer Content -->
        <div class="footer-main">
            <div class="container">
                <div class="row g-4">
                    <!-- Company Info -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <div class="brand-logo">
                                <i class="bi bi-car-front-fill"></i>
                                <h3><?php echo SITE_NAME; ?></h3>
                            </div>
                            <p class="brand-description">
                                La tua scuola guida di fiducia dal 1959. Formiamo conducenti sicuri e responsabili
                                con passione, professionalità e tecnologie innovative.
                            </p>
                            <div class="brand-stats">
                                <div class="stat-item">
                                    <span class="stat-number">65+</span>
                                    <span class="stat-label">Anni di Esperienza</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">15.000+</span>
                                    <span class="stat-label">Studenti Formati</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-section">
                            <h4 class="section-title">Scopri</h4>
                            <ul class="footer-links">
                                <li><a href="<?php echo SITE_URL; ?>/chi-siamo.php">Chi Siamo</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/corsi.php">Corsi</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/orari-sede.php">Orari e Sede</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/contatti.php">Contatti</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-section">
                            <h4 class="section-title">Servizi</h4>
                            <ul class="footer-links">
                                <li><a href="<?php echo SITE_URL; ?>/corsi.php">Patente B</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/corsi.php">Patente A</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/corsi.php">CQC</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/corsi.php">Rinnovi</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-section">
                            <h4 class="section-title">Contattaci</h4>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <div>
                                        <strong>Sede Principale</strong><br>
                                        Via Amato, 4<br>
                                        80053 Castellammare di Stabia (Napoli)
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="bi bi-telephone"></i>
                                    <div>
                                        <strong>Telefono</strong><br>
                                        <a href="tel:+390818701132">081 8701132</a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="bi bi-envelope"></i>
                                    <div>
                                        <strong>Email</strong><br>
                                        <a href="mailto:info@autoscuolaliana.it">info@autoscuolaliana.it</a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="bi bi-globe"></i>
                                    <div>
                                        <strong>Sito Web</strong><br>
                                        <a href="https://www.autoscuolaliana.it" target="_blank">www.autoscuolaliana.it</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="footer-newsletter">
            <div class="container">
                <div class="newsletter-content">
                    <div class="newsletter-text">
                        <h4>Rimani Aggiornato</h4>
                        <p>Iscriviti alla nostra newsletter per ricevere aggiornamenti sui corsi e novità</p>
                    </div>
                    <div class="newsletter-form">
                        <form id="newsletter-form" class="newsletter-signup">
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="La tua email" required>
                                <input type="text" name="name" class="form-control d-none" placeholder="Il tuo nome (opzionale)">
                                <button class="btn btn-primary" type="submit" id="newsletter-submit">
                                    <i class="bi bi-send"></i>
                                    <span id="submit-text">Iscriviti</span>
                                </button>
                            </div>
                            <div id="newsletter-message" class="mt-2" style="display: none;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tutti i diritti riservati.</p>
                        <p class="company-info">P.IVA: 02103640765 | Autoscuola Autorizzata dal Ministero delle Infrastrutture e dei Trasporti</p>
                    </div>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Custom Footer Styles -->
    <style>
    .modern-footer {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .modern-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.03"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.03"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .footer-main {
        padding: 4rem 0 2rem;
        position: relative;
        z-index: 2;
    }

    .footer-brand {
        margin-bottom: 2rem;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .brand-logo i {
        font-size: 2.5rem;
        color: #28a745;
    }

    .brand-logo h3 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(45deg, #28a745, #20c997);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .brand-description {
        color: #cccccc;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .brand-stats {
        display: flex;
        gap: 2rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 1.8rem;
        font-weight: 700;
        color: #28a745;
    }

    .stat-label {
        display: block;
        font-size: 0.9rem;
        color: #cccccc;
        margin-top: 0.5rem;
    }

    .footer-section h4 {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .footer-section h4::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 30px;
        height: 2px;
        background: linear-gradient(45deg, #28a745, #20c997);
        border-radius: 1px;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: #cccccc;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .footer-links a:hover {
        color: #28a745;
        transform: translateX(5px);
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .contact-item i {
        color: #28a745;
        font-size: 1.2rem;
        margin-top: 0.2rem;
        flex-shrink: 0;
    }

    .contact-item a {
        color: #cccccc;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-item a:hover {
        color: #28a745;
    }

    .footer-newsletter {
        background: rgba(40, 167, 69, 0.1);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 2rem 0;
        position: relative;
        z-index: 2;
    }

    .newsletter-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .newsletter-text h4 {
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .newsletter-text p {
        color: #cccccc;
        margin: 0;
    }

    .newsletter-signup .input-group {
        max-width: 400px;
    }

    .newsletter-signup .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        padding: 0.75rem 1rem;
        border-radius: 8px 0 0 8px;
    }

    .newsletter-signup .form-control::placeholder {
        color: #cccccc;
    }

    .newsletter-signup .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #28a745;
        color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .newsletter-signup .btn-primary {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0 8px 8px 0;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .newsletter-signup .btn-primary:hover {
        background: linear-gradient(45deg, #218838, #17a2b8);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .newsletter-signup .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    #newsletter-message.alert {
        padding: 0.5rem 1rem;
        margin-top: 1rem;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .footer-bottom {
        background: rgba(0, 0, 0, 0.3);
        padding: 1.5rem 0;
        position: relative;
        z-index: 2;
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright {
        margin: 0;
    }

    .copyright p {
        margin: 0;
        color: #cccccc;
        font-size: 0.9rem;
    }

    .company-info {
        font-size: 0.8rem !important;
        margin-top: 0.5rem !important;
    }

    .footer-social {
        display: flex;
        gap: 1rem;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        color: #cccccc;
        text-decoration: none;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #28a745;
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    @media (max-width: 768px) {
        .footer-main {
            padding: 2rem 0 1rem;
        }

        .newsletter-content {
            flex-direction: column;
            text-align: center;
        }

        .newsletter-signup .input-group {
            max-width: 100%;
        }

        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
        }

        .brand-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .contact-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
    </style>

    <script src="<?php echo SITE_URL; ?>/assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>

    <!-- Newsletter Subscription Script -->
    <script>
    document.getElementById('newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('newsletter-submit');
        const submitText = document.getElementById('submit-text');
        const messageDiv = document.getElementById('newsletter-message');
        const originalText = submitText.textContent;

        // Disabilita il pulsante e mostra loading
        submitBtn.disabled = true;
        submitText.textContent = 'Iscrizione...';
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> <span id="submit-text">Iscrizione...</span>';

        // Nasconde eventuali messaggi precedenti
        messageDiv.style.display = 'none';

        // Crea FormData per l'invio
        const formData = new FormData(form);

        // Invia la richiesta
        fetch('<?php echo SITE_URL; ?>/api/newsletter_subscribe.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Ripristina il pulsante
            submitBtn.disabled = false;
            submitText.textContent = originalText;
            submitBtn.innerHTML = '<i class="bi bi-send"></i> <span id="submit-text">' + originalText + '</span>';

            // Mostra il messaggio
            messageDiv.style.display = 'block';
            messageDiv.className = 'mt-2 alert alert-' + (data.success ? 'success' : 'danger');
            messageDiv.textContent = data.message;

            // Se successo, resetta il form
            if (data.success) {
                form.reset();
                // Nasconde il messaggio dopo 5 secondi
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 5000);
            }
        })
        .catch(error => {
            // Ripristina il pulsante
            submitBtn.disabled = false;
            submitText.textContent = originalText;
            submitBtn.innerHTML = '<i class="bi bi-send"></i> <span id="submit-text">' + originalText + '</span>';

            // Mostra errore
            messageDiv.style.display = 'block';
            messageDiv.className = 'mt-2 alert alert-danger';
            messageDiv.textContent = 'Errore di connessione. Riprova più tardi.';

            console.error('Newsletter subscription error:', error);
        });
    });
    </script>
</body>
</html>