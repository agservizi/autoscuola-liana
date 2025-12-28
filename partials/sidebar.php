<!-- sidebar.php - Professional sidebar for student dashboard -->
<div class="sidebar-custom">
    <div class="sidebar-header">
        <div class="user-info">
            <div class="user-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="user-details">
                <h6 class="user-name"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></h6>
                <span class="user-role">Studente</span>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="courses.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'courses.php' ? 'active' : ''; ?>">
                    <i class="bi bi-book nav-icon"></i>
                    <span class="nav-text">I miei Corsi</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="quizzes.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'quizzes.php' ? 'active' : ''; ?>">
                    <i class="bi bi-question-circle nav-icon"></i>
                    <span class="nav-text">Quiz</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="results.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'results.php' ? 'active' : ''; ?>">
                    <i class="bi bi-bar-chart nav-icon"></i>
                    <span class="nav-text">Risultati</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="profile.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : ''; ?>">
                    <i class="bi bi-person nav-icon"></i>
                    <span class="nav-text">Profilo</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="nav-list">
            <li class="nav-item">
                <a href="../index.php" class="nav-link">
                    <i class="bi bi-house nav-icon"></i>
                    <span class="nav-text">Torna al Sito</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="../logout.php" class="nav-link logout-link">
                    <i class="bi bi-box-arrow-right nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-status">
            <div class="status-indicator online"></div>
            <span class="status-text">Online</span>
        </div>
        <div class="sidebar-version">
            <small>v2.1.0</small>
        </div>
    </div>
</div>