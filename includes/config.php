<?php
// config.php - Configuration file

// Load environment variables from .env files
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load .env.local first (for local development), then .env
loadEnv(__DIR__ . '/../.env.local');
loadEnv(__DIR__ . '/../.env');

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'autoscuola_liana');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Site configuration
define('SITE_NAME', 'Autoscuola Liana');
define('SITE_URL', 'http://localhost:8000');
define('ADMIN_EMAIL', 'info@autoscuolaliana.it');

// Email configuration (Resend)
define('RESEND_API_KEY', getenv('RESEND_API_KEY') ?: '');
define('RESEND_FROM_EMAIL', getenv('RESEND_FROM_EMAIL') ?: 'noreply@autoscuolaliana.it');
define('RESEND_FROM_NAME', getenv('RESEND_FROM_NAME') ?: 'Autoscuola Liana');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CSRF Protection functions
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>