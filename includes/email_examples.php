<?php
/**
 * Esempi di utilizzo del servizio email Resend
 * Questo file mostra come integrare le email in varie parti dell'applicazione
 */

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/EmailService.php';
require_once '../includes/auth.php';

// Inizializza il servizio email
$emailService = new EmailService();

/**
 * Esempio 1: Invio email di benvenuto dopo registrazione
 */
function sendWelcomeEmailAfterRegistration($userId, $userEmail, $userName, $db, $emailService) {
    $loginLink = SITE_URL . '/login.php';

    $result = $emailService->sendWelcomeEmail($userEmail, $userName, $loginLink);

    if ($result['success']) {
        // Log successo
        error_log("Welcome email sent to: $userEmail, ID: " . $result['id']);

        // Aggiorna database per tracciare che l'email è stata inviata
        $stmt = $db->prepare("UPDATE users SET welcome_email_sent = 1 WHERE id = ?");
        $stmt->execute([$userId]);

        return true;
    } else {
        // Log errore
        error_log("Failed to send welcome email to: $userEmail, Error: " . ($result['error'] ?? 'Unknown'));

        return false;
    }
}

/**
 * Esempio 2: Invio conferma iscrizione corso
 */
function sendCourseEnrollmentConfirmation($userId, $courseId, $db, $emailService) {
    // Recupera dati utente
    $stmt = $db->prepare("SELECT email, first_name, last_name FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) return false;

    $userName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

    // Recupera dati corso
    $stmt = $db->prepare("SELECT name FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch();

    if (!$course) return false;

    $result = $emailService->sendCourseEnrollmentEmail($user['email'], $userName, $course['name']);

    if ($result['success']) {
        error_log("Course enrollment email sent to: {$user['email']}, Course: {$course['name']}, ID: " . $result['id']);
        return true;
    } else {
        error_log("Failed to send course enrollment email to: {$user['email']}, Error: " . ($result['error'] ?? 'Unknown'));
        return false;
    }
}

/**
 * Esempio 3: Invio risultati quiz
 */
function sendQuizResults($userId, $courseId, $quizId, $score, $passed, $db, $emailService) {
    // Recupera dati utente
    $stmt = $db->prepare("SELECT email, first_name, last_name FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) return false;

    $userName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

    // Recupera dati corso
    $stmt = $db->prepare("SELECT name FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch();

    if (!$course) return false;

    $result = $emailService->sendQuizResultsEmail($user['email'], $userName, $course['name'], $score, $passed);

    if ($result['success']) {
        error_log("Quiz results email sent to: {$user['email']}, Score: {$score}%, Passed: " . ($passed ? 'Yes' : 'No') . ", ID: " . $result['id']);
        return true;
    } else {
        error_log("Failed to send quiz results email to: {$user['email']}, Error: " . ($result['error'] ?? 'Unknown'));
        return false;
    }
}

/**
 * Esempio 4: Sistema di notifiche programmate
 * (Da integrare con un cron job o task scheduler)
 */
function sendScheduledNotifications($db, $emailService) {
    // Esempio: Promemoria lezione settimanale
    $query = "
        SELECT u.email, u.first_name, u.last_name, c.name as course_name
        FROM users u
        JOIN user_courses uc ON u.id = uc.user_id
        JOIN courses c ON uc.course_id = c.id
        WHERE u.email_notifications = 1
        AND uc.last_access < DATE_SUB(NOW(), INTERVAL 7 DAY)
    ";

    $stmt = $db->query($query);
    $users = $stmt->fetchAll();

    foreach ($users as $user) {
        $userName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
        $subject = "Promemoria: Continua il tuo corso {$user['course_name']}";
        $message = "Ciao $userName,\n\nÈ passato qualche giorno dall'ultima volta che hai studiato. Continua il tuo percorso!\n\nAccedi ora: " . SITE_URL . "/student/dashboard.php";

        // Per notifiche personalizzate, puoi estendere EmailService con un metodo sendCustomEmail
        // $result = $emailService->sendCustomEmail($user['email'], $subject, $message);

        error_log("Reminder sent to: {$user['email']} for course: {$user['course_name']}");
    }
}

/**
 * Esempio 5: Email di sistema (amministratore)
 */
function sendSystemNotification($adminEmail, $subject, $message, $emailService) {
    // Per email di sistema, puoi creare un metodo dedicato o usare sendCustomEmail
    // Questo è utile per notifiche di sistema, backup completati, errori, ecc.

    // $result = $emailService->sendSystemNotification($adminEmail, $subject, $message);

    error_log("System notification: $subject - $message");
}

/**
 * Utilizzo negli script esistenti
 */

// Dopo registrazione utente
/*
if (registerUser($userData)) {
    $userId = getLastInsertId();
    sendWelcomeEmailAfterRegistration($userId, $userData['email'], $userData['name'], $db, $emailService);
}
*/

// Dopo iscrizione corso
/*
if (enrollUserInCourse($userId, $courseId)) {
    sendCourseEnrollmentConfirmation($userId, $courseId, $db, $emailService);
}
*/

// Dopo completamento quiz
/*
$quizResult = calculateQuizScore($quizId, $answers);
if (saveQuizResult($userId, $quizId, $quizResult['score'], $quizResult['passed'])) {
    sendQuizResults($userId, $courseId, $quizId, $quizResult['score'], $quizResult['passed'], $db, $emailService);
}
*/

// Notifiche programmate (da cron job)
/*
sendScheduledNotifications($db, $emailService);
*/

?>