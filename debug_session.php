<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

echo "Session status: " . session_status() . "<br>";
echo "Is logged in: " . (isLoggedIn() ? 'Yes' : 'No') . "<br>";
if (isLoggedIn()) {
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    echo "Username: " . $_SESSION['username'] . "<br>";
    echo "Role: " . $_SESSION['role'] . "<br>";
    echo "Is admin: " . (isAdmin() ? 'Yes' : 'No') . "<br>";
    echo "Is student: " . (isStudent() ? 'Yes' : 'No') . "<br>";
}
?>