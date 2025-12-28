<!-- Admin Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <span class="brand-text font-weight-light"><?php echo SITE_NAME; ?> Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
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
                    <a href="students.php" class="nav-link <?php echo $current_page == 'students.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Studenti</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="courses.php" class="nav-link <?php echo $current_page == 'courses.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Corsi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lessons.php" class="nav-link <?php echo $current_page == 'lessons.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Lezioni</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="quizzes.php" class="nav-link <?php echo $current_page == 'quizzes.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Quiz</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="questions.php" class="nav-link <?php echo $current_page == 'questions.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Domande</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="contacts.php" class="nav-link <?php echo $current_page == 'contacts.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Contatti</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="newsletter.php" class="nav-link <?php echo in_array($current_page, ['newsletter.php', 'newsletter_create.php', 'newsletter_edit.php', 'newsletter_preview.php', 'newsletter_subscribers.php', 'newsletter_campaigns.php']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Newsletter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>