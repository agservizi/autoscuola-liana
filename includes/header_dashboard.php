<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php echo SITE_URL; ?>/">
    <title><?php echo SITE_NAME; ?> - <?php echo $page_title ?? 'Dashboard'; ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Minimal Custom CSS for AdminLTE -->
    <link href="../assets/css/custom_adminlte.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <?php
    // Get sidebar state from cookie
    $admin_sidebar_collapsed = isset($_COOKIE['adminSidebarCollapsed']) && $_COOKIE['adminSidebarCollapsed'] === 'true';
    $student_sidebar_collapsed = isset($_COOKIE['studentSidebarCollapsed']) && $_COOKIE['studentSidebarCollapsed'] === 'true';
    ?>
