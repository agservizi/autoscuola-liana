<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title><?php echo $page_title ?? 'Autoscuola Liana - Scuola Guida Castellammare di Stabia | Patente di Guida'; ?></title>
    <meta name="description" content="<?php echo $meta_description ?? 'Autoscuola Liana a Castellammare di Stabia offre corsi per patente di guida B, A e superiori. Lezioni teoriche e pratiche con istruttori qualificati. Iscriviti ora!'; ?>">
    <meta name="keywords" content="<?php echo $meta_keywords ?? 'autoscuola, scuola guida, patente, patente B, patente A, lezioni guida, Castellammare di Stabia, Napoli, corso patente, esame guida, istruttore guida'; ?>">
    <meta name="author" content="Autoscuola Liana">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="language" content="Italian">
    <meta name="geo.region" content="IT-NA">
    <meta name="geo.placename" content="Castellammare di Stabia">
    <meta name="geo.position" content="40.702783;14.486365">
    <meta name="ICBM" content="40.702783, 14.486365">
    <link rel="canonical" href="<?php echo $canonical_url ?? (SITE_URL . $_SERVER['REQUEST_URI']); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo $og_type ?? 'website'; ?>">
    <meta property="og:url" content="<?php echo $og_url ?? (SITE_URL . $_SERVER['REQUEST_URI']); ?>">
    <meta property="og:title" content="<?php echo $og_title ?? ($page_title ?? 'Autoscuola Liana - Scuola Guida Castellammare di Stabia'); ?>">
    <meta property="og:description" content="<?php echo $og_description ?? 'Autoscuola Liana a Castellammare di Stabia offre corsi per patente di guida B, A e superiori. Lezioni teoriche e pratiche con istruttori qualificati.'; ?>">
    <meta property="og:image" content="<?php echo $og_image ?? (SITE_URL . '/assets/img/autoscuola-liana-logo.png'); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Autoscuola Liana - Scuola Guida Castellammare di Stabia">
    <meta property="og:site_name" content="Autoscuola Liana">
    <meta property="og:locale" content="it_IT">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo $twitter_url ?? (SITE_URL . $_SERVER['REQUEST_URI']); ?>">
    <meta name="twitter:title" content="<?php echo $twitter_title ?? ($page_title ?? 'Autoscuola Liana - Scuola Guida Castellammare di Stabia'); ?>">
    <meta name="twitter:description" content="<?php echo $twitter_description ?? 'Autoscuola Liana a Castellammare di Stabia offre corsi per patente di guida B, A e superiori. Lezioni teoriche e pratiche con istruttori qualificati.'; ?>">
    <meta name="twitter:image" content="<?php echo $twitter_image ?? (SITE_URL . '/assets/img/autoscuola-liana-logo.png'); ?>">
    <meta name="twitter:image:alt" content="Autoscuola Liana - Scuola Guida Castellammare di Stabia">
    <meta name="twitter:site" content="@autoscuolaliana">
    <meta name="twitter:creator" content="@autoscuolaliana">

    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="#28a745">
    <meta name="msapplication-TileColor" content="#28a745">
    <meta name="application-name" content="Autoscuola Liana">
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>/assets/img/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITE_URL; ?>/assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE_URL; ?>/assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_URL; ?>/assets/img/favicon-16x16.png">
    <link rel="manifest" href="<?php echo SITE_URL; ?>/site.webmanifest">

    <!-- SEO Links -->
    <link rel="sitemap" type="application/xml" href="<?php echo SITE_URL; ?>/sitemap.xml">

    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "DrivingSchool",
        "name": "Autoscuola Liana",
        "description": "Autoscuola Liana a Castellammare di Stabia offre corsi per patente di guida B, A e superiori con lezioni teoriche e pratiche.",
        "url": "<?php echo SITE_URL; ?>",
        "telephone": "+39-06-12345678",
        "email": "info@autoscuolaliana.it",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Via Amato, 4",
            "addressLocality": "Castellammare di Stabia",
            "addressRegion": "NA",
            "postalCode": "80053",
            "addressCountry": "IT"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "40.702783",
            "longitude": "14.486365"
        },
        "openingHours": [
            "Mo-Fr 08:00-20:00",
            "Sa 08:00-18:00"
        ],
        "priceRange": "€€",
        "image": "<?php echo SITE_URL; ?>/assets/img/autoscuola-liana-logo.png",
        "sameAs": [
            "https://www.facebook.com/autoscuolaliana",
            "https://www.instagram.com/autoscuolaliana"
        ]
    }
    </script>

    <!-- Fonts and Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo SITE_URL; ?>/index.php"><?php echo SITE_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/chi-siamo.php">Chi siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/corsi.php">Corsi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/orari-sede.php">Orari & Sede</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/contatti.php">Contatti</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isLoggedIn()): ?>
                        <?php if (isStudent()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/student/dashboard.php">Dashboard</a>
                            </li>
                        <?php elseif (isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/admin/dashboard.php">Admin</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/login.php">Accedi</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main>