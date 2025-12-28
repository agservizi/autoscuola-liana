<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $name = trim($_POST['name'] ?? '');

    if (empty($email)) {
        $response['message'] = 'L\'email è obbligatoria.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'L\'email non è valida.';
    } else {
        try {
            // Verifica se l'email esiste già
            $stmt = $pdo->prepare("SELECT id, status FROM newsletter_subscribers WHERE email = ?");
            $stmt->execute([$email]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                if ($existing['is_active']) {
                    $response['message'] = 'Questa email è già iscritta alla newsletter.';
                } else {
                    // Riattiva l'iscrizione
                    $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_active = 1, first_name = ?, subscribed_at = NOW() WHERE id = ?");
                    $stmt->execute([$name, $existing['id']]);
                    $response['success'] = true;
                    $response['message'] = 'Iscrizione alla newsletter riattivata con successo!';
                }
            } else {
                // Nuova iscrizione
                $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, first_name, is_active, subscribed_at) VALUES (?, ?, 1, NOW())");
                $stmt->execute([$email, $name]);

                $response['success'] = true;
                $response['message'] = 'Iscrizione alla newsletter completata con successo!';
            }
        } catch (Exception $e) {
            $response['message'] = 'Errore durante l\'iscrizione. Riprova più tardi.';
            error_log('Newsletter subscription error: ' . $e->getMessage());
        }
    }
} else {
    $response['message'] = 'Metodo non consentito.';
}

echo json_encode($response);
?>