<!-- Student Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <span class="brand-text font-weight-light"><?php echo SITE_NAME; ?> Student</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle fa-2x text-white"></i>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></a>
                <span class="text-white">Studente</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="course.php" class="nav-link <?php echo $current_page == 'course.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>I Miei Corsi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="quiz.php" class="nav-link <?php echo $current_page == 'quiz.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Quiz</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="progresso.php" class="nav-link <?php echo $current_page == 'progresso.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Progresso</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="profilo.php" class="nav-link <?php echo $current_page == 'profilo.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profilo</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>