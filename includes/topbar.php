<!-- Topbar -->
<div class="topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0"><?php echo $page_title ?? 'Dashboard'; ?></h4>
    </div>
    <div class="topbar-right">
        <div class="user-menu">
            <span class="user-greeting">Benvenuto, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</span>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</div>