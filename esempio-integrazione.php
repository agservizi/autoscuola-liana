<?php
// index.php - Homepage con template integrato
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Ottieni dati dinamici per la homepage
$stats = [
    'studenti' => 2000,
    'successo' => 95,
    'anni' => 66,
    'auto' => 50
];

$corsi = [
    [
        'id' => 1,
        'nome' => 'Patente B',
        'descrizione' => 'Corso completo per la patente di guida B',
        'prezzo' => 850,
        'badge' => 'Più Popolare'
    ],
    // Altri corsi...
];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoscuola Liana - Scuola Guida Professionale</title>
    <meta name="description" content="Autoscuola Liana - La tua scuola guida di fiducia dal 1959. Corsi di guida sicuri e professionali.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <?php include 'partials/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">La Tua Scuola Guida di Fiducia</h1>
                <p class="hero-subtitle">
                    Formiamo conducenti sicuri e responsabili dal 1959. Scegli la qualità e la professionalità
                    di Autoscuola Liana per il tuo patentino di guida.
                </p>
                <div class="hero-cta">
                    <a href="contatti.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope"></i>
                        Contatta per Iscrizione
                    </a>
                    <a href="login.php" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Accedi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="course-icon mx-auto mb-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="card-title">Sicurezza Prima</h5>
                            <p class="card-text">
                                Insegniamo tecniche di guida sicura e responsabile,
                                formando conducenti consapevoli dei rischi stradali.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="course-icon mx-auto mb-3">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h5 class="card-title">Istruttori Qualificati</h5>
                            <p class="card-text">
                                Il nostro team di istruttori professionisti ha anni di esperienza
                                nell'insegnamento della guida sicura.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="course-icon mx-auto mb-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5 class="card-title">Flessibilità Oraria</h5>
                            <p class="card-text">
                                Orari personalizzati per adattarsi alle tue esigenze.
                                Lezioni serali e weekend disponibili.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="text-gradient">I Nostri Corsi</h2>
                <p class="lead">Scegli il corso più adatto alle tue esigenze</p>
            </div>

            <div class="row g-4">
                <?php foreach ($corsi as $corso): ?>
                <div class="col-lg-4">
                    <div class="card course-card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="course-icon mx-auto mb-3">
                                <i class="fas fa-car"></i>
                            </div>
                            <h5 class="card-title"><?php echo htmlspecialchars($corso['nome']); ?></h5>
                            <p class="card-text flex-grow-1">
                                <?php echo htmlspecialchars($corso['descrizione']); ?>
                            </p>
                            <a href="corso-dettagli.php?id=<?php echo $corso['id']; ?>" class="btn btn-primary mt-auto">
                                Scopri di più
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center">
                        <div class="card-body">
                            <div class="stats-number"><?php echo number_format($stats['studenti']); ?>+</div>
                            <div class="stats-label">Studenti Formati</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center">
                        <div class="card-body">
                            <div class="stats-number"><?php echo $stats['successo']; ?>%</div>
                            <div class="stats-label">Tasso Successo</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center">
                        <div class="card-body">
                            <div class="stats-number"><?php echo $stats['anni']; ?></div>
                            <div class="stats-label">Anni di Esperienza</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stats-card text-center">
                        <div class="card-body">
                            <div class="stats-number"><?php echo $stats['auto']; ?>+</div>
                            <div class="stats-label">Auto Scuola</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-gradient-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Pronto a Iniziare il Tuo Percorso?</h2>
            <p class="lead mb-4">
                Iscriviti oggi e inizia il tuo viaggio verso una guida sicura e responsabile.
            </p>
            <a href="contatti.php" class="btn btn-light btn-lg">
                <i class="fas fa-envelope"></i>
                Contatta per Iscrizione
            </a>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'partials/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>