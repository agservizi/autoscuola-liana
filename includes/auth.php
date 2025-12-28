<?php
// auth.php - Authentication functions

require_once 'db.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// Check if user is student
function isStudent() {
    return isLoggedIn() && $_SESSION['role'] === 'student';
}

// Login function
function login($username_or_email, $password) {
    global $db;

    $stmt = $db->prepare("SELECT id, username, password, role, first_name, last_name FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username_or_email, $username_or_email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        return true;
    }
    return false;
}

// Logout function
function logout() {
    session_destroy();
    session_start();
}

// Require login for protected pages
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
    }
}

// Require admin for admin pages
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ' . SITE_URL . '/index.php');
        exit;
    }
}

// Require student for student pages
function requireStudent() {
    if (!isStudent()) {
        header('Location: ' . SITE_URL . '/index.php');
        exit;
    }
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>