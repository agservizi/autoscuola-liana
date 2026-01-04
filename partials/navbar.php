<!-- navbar.php - Professional navbar for Autoscuola Liana -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo.svg" alt="Autoscuola Liana" class="navbar-logo me-2" onerror="this.style.display='none'">
            <span class="brand-text">Autoscuola Liana</span>
        </a>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Apri il menu">
            <span class="toggler-box" aria-hidden="true">
                <span class="toggler-bar top"></span>
                <span class="toggler-bar middle"></span>
                <span class="toggler-bar bottom"></span>
            </span>
            <span class="toggler-label">Menu</span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chi-siamo.php">Chi siamo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="corsi.php">Corsi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contatti.php">Contatti</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <?php if (isStudent()): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary btn-sm me-2" href="student/dashboard.php">Area Studenti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php elseif (isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-danger btn-sm me-2" href="admin/dashboard.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary btn-sm me-2" href="login.php">Accedi</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="mobile-nav-overlay" data-target="#navbarNav"></div>