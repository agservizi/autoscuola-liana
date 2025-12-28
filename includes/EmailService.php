<?php
/**
 * Email Service using Resend API
 * Handles sending transactional emails for Autoscuola Liana
 */

class EmailService {
    private $apiKey;
    private $fromEmail;
    private $fromName;
    private $apiUrl = 'https://api.resend.com/emails';

    public function __construct() {
        $this->apiKey = RESEND_API_KEY;
        $this->fromEmail = RESEND_FROM_EMAIL;
        $this->fromName = RESEND_FROM_NAME;
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($toEmail, $resetLink, $userName = '') {
        $subject = 'Reset della tua password - Autoscuola Liana';

        $htmlContent = $this->getPasswordResetTemplate($resetLink, $userName);
        $textContent = $this->getPasswordResetTextTemplate($resetLink, $userName);

        return $this->sendEmail($toEmail, $subject, $htmlContent, $textContent);
    }

    /**
     * Send welcome email for new students
     */
    public function sendWelcomeEmail($toEmail, $userName, $loginLink) {
        $subject = 'Benvenuto in Autoscuola Liana!';

        $htmlContent = $this->getWelcomeTemplate($userName, $loginLink);
        $textContent = $this->getWelcomeTextTemplate($userName, $loginLink);

        return $this->sendEmail($toEmail, $subject, $htmlContent, $textContent);
    }

    /**
     * Send course enrollment confirmation
     */
    public function sendCourseEnrollmentEmail($toEmail, $userName, $courseName) {
        $subject = 'Iscrizione corso confermata - Autoscuola Liana';

        $htmlContent = $this->getCourseEnrollmentTemplate($userName, $courseName);
        $textContent = $this->getCourseEnrollmentTextTemplate($userName, $courseName);

        return $this->sendEmail($toEmail, $subject, $htmlContent, $textContent);
    }

    /**
     * Send quiz results email
     */
    public function sendQuizResultsEmail($toEmail, $userName, $courseName, $score, $passed) {
        $subject = $passed ? 'Complimenti! Quiz superato - Autoscuola Liana' : 'Risultati quiz - Autoscuola Liana';

        $htmlContent = $this->getQuizResultsTemplate($userName, $courseName, $score, $passed);
        $textContent = $this->getQuizResultsTextTemplate($userName, $courseName, $score, $passed);

        return $this->sendEmail($toEmail, $subject, $htmlContent, $textContent);
    }

    /**
     * Generic email sending method
     */
    private function sendEmail($to, $subject, $htmlContent, $textContent = null) {
        if (empty($this->apiKey)) {
            // Fallback for development - log the email instead of sending
            error_log("Email would be sent to: $to\nSubject: $subject\nContent: $htmlContent");
            return ['success' => true, 'id' => 'dev-mode-' . time()];
        }

        $data = [
            'from' => $this->fromName . ' <' . $this->fromEmail . '>',
            'to' => [$to],
            'subject' => $subject,
            'html' => $htmlContent
        ];

        if ($textContent) {
            $data['text'] = $textContent;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $result = json_decode($response, true);

        if ($httpCode === 200 && isset($result['id'])) {
            return ['success' => true, 'id' => $result['id']];
        } else {
            error_log('Resend API Error: ' . $response);
            return ['success' => false, 'error' => $result['message'] ?? 'Unknown error'];
        }
    }

    // Email Templates
    private function getPasswordResetTemplate($resetLink, $userName) {
        $greeting = $userName ? "Ciao $userName," : "Ciao,";

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Reset Password - Autoscuola Liana</title>
        </head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h1 style='color: white; margin: 0; font-size: 24px;'>Autoscuola Liana</h1>
                <p style='color: white; margin: 10px 0 0 0;'>Reset della password</p>
            </div>

            <div style='background: white; border: 1px solid #ddd; border-radius: 0 0 10px 10px; padding: 30px;'>
                <h2 style='color: #28a745; margin-top: 0;'>Reset della tua password</h2>

                <p>$greeting</p>

                <p>Hai richiesto il reset della password per il tuo account Autoscuola Liana. Clicca sul pulsante qui sotto per creare una nuova password:</p>

                <div style='text-align: center; margin: 30px 0;'>
                    <a href='$resetLink' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>Reset Password</a>
                </div>

                <p><strong>Link diretto:</strong> <a href='$resetLink' style='color: #28a745;'>$resetLink</a></p>

                <p style='color: #666; font-size: 14px;'>
                    Questo link è valido per 1 ora. Se non hai richiesto il reset della password, ignora questa email.
                </p>

                <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>

                <p style='color: #666; font-size: 14px;'>
                    Se hai problemi con il pulsante, copia e incolla il link nel tuo browser.
                </p>

                <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;'>
                    <p>Autoscuola Liana<br>
                    Via Amato, 4 - 80053 Castellammare di Stabia (NA)<br>
                    Tel: +39 06 12345678 | Email: info@autoscuolaliana.it</p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getPasswordResetTextTemplate($resetLink, $userName) {
        $greeting = $userName ? "Ciao $userName," : "Ciao,";

        return "$greeting

Hai richiesto il reset della password per il tuo account Autoscuola Liana.

Clicca sul link seguente per creare una nuova password:
$resetLink

Questo link è valido per 1 ora. Se non hai richiesto il reset della password, ignora questa email.

Se hai problemi con il link, copia e incolla l'URL nel tuo browser.

Autoscuola Liana
Via Amato, 4 - 80053 Castellammare di Stabia (NA)
Tel: +39 06 12345678 | Email: info@autoscuolaliana.it";
    }

    private function getWelcomeTemplate($userName, $loginLink) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Benvenuto - Autoscuola Liana</title>
        </head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h1 style='color: white; margin: 0; font-size: 24px;'>Autoscuola Liana</h1>
                <p style='color: white; margin: 10px 0 0 0;'>Benvenuto!</p>
            </div>

            <div style='background: white; border: 1px solid #ddd; border-radius: 0 0 10px 10px; padding: 30px;'>
                <h2 style='color: #28a745; margin-top: 0;'>Benvenuto in Autoscuola Liana, $userName!</h2>

                <p>Il tuo account è stato creato con successo. Ora puoi accedere alla piattaforma per iniziare il tuo percorso verso la patente di guida.</p>

                <div style='text-align: center; margin: 30px 0;'>
                    <a href='$loginLink' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>Accedi Ora</a>
                </div>

                <p><strong>Link diretto:</strong> <a href='$loginLink' style='color: #28a745;'>$loginLink</a></p>

                <p>Con il tuo account potrai:</p>
                <ul>
                    <li>Accedere ai corsi online</li>
                    <li>Visualizzare il tuo progresso</li>
                    <li>Svolgere quiz e test</li>
                    <li>Contattare gli istruttori</li>
                </ul>

                <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;'>
                    <p>Autoscuola Liana<br>
                    Via Amato, 4 - 80053 Castellammare di Stabia (NA)<br>
                    Tel: +39 06 12345678 | Email: info@autoscuolaliana.it</p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getWelcomeTextTemplate($userName, $loginLink) {
        return "Benvenuto in Autoscuola Liana, $userName!

Il tuo account è stato creato con successo. Ora puoi accedere alla piattaforma per iniziare il tuo percorso verso la patente di guida.

Accedi ora: $loginLink

Con il tuo account potrai:
- Accedere ai corsi online
- Visualizzare il tuo progresso
- Svolgere quiz e test
- Contattare gli istruttori

Autoscuola Liana
Via Amato, 4 - 80053 Castellammare di Stabia (NA)
Tel: +39 06 12345678 | Email: info@autoscuolaliana.it";
    }

    private function getCourseEnrollmentTemplate($userName, $courseName) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Iscrizione Corso - Autoscuola Liana</title>
        </head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h1 style='color: white; margin: 0; font-size: 24px;'>Autoscuola Liana</h1>
                <p style='color: white; margin: 10px 0 0 0;'>Iscrizione Corso</p>
            </div>

            <div style='background: white; border: 1px solid #ddd; border-radius: 0 0 10px 10px; padding: 30px;'>
                <h2 style='color: #28a745; margin-top: 0;'>Iscrizione Confermata!</h2>

                <p>Ciao $userName,</p>

                <p>La tua iscrizione al corso <strong>$courseName</strong> è stata confermata con successo!</p>

                <p>Puoi ora accedere al corso dalla tua dashboard e iniziare il tuo percorso di apprendimento.</p>

                <div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;'>
                    <h3 style='margin-top: 0; color: #28a745;'>Prossimi passi:</h3>
                    <ol>
                        <li>Accedi al tuo account</li>
                        <li>Vai alla sezione 'I miei corsi'</li>
                        <li>Inizia con la prima lezione</li>
                        <li>Contatta il tuo istruttore se hai domande</li>
                    </ol>
                </div>

                <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;'>
                    <p>Autoscuola Liana<br>
                    Via Amato, 4 - 80053 Castellammare di Stabia (NA)<br>
                    Tel: +39 06 12345678 | Email: info@autoscuolaliana.it</p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getCourseEnrollmentTextTemplate($userName, $courseName) {
        return "Iscrizione Confermata!

Ciao $userName,

La tua iscrizione al corso '$courseName' è stata confermata con successo!

Puoi ora accedere al corso dalla tua dashboard e iniziare il tuo percorso di apprendimento.

Prossimi passi:
1. Accedi al tuo account
2. Vai alla sezione 'I miei corsi'
3. Inizia con la prima lezione
4. Contatta il tuo istruttore se hai domande

Autoscuola Liana
Via Amato, 4 - 80053 Castellammare di Stabia (NA)
Tel: +39 06 12345678 | Email: info@autoscuolaliana.it";
    }

    private function getQuizResultsTemplate($userName, $courseName, $score, $passed) {
        $statusColor = $passed ? '#28a745' : '#dc3545';
        $statusText = $passed ? 'Superato' : 'Non superato';
        $message = $passed ?
            'Complimenti! Hai superato il quiz con successo.' :
            'Il quiz non è stato superato. Puoi riprovare dopo aver studiato di più.';

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Risultati Quiz - Autoscuola Liana</title>
        </head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h1 style='color: white; margin: 0; font-size: 24px;'>Autoscuola Liana</h1>
                <p style='color: white; margin: 10px 0 0 0;'>Risultati Quiz</p>
            </div>

            <div style='background: white; border: 1px solid #ddd; border-radius: 0 0 10px 10px; padding: 30px;'>
                <h2 style='color: #28a745; margin-top: 0;'>Risultati del Quiz</h2>

                <p>Ciao $userName,</p>

                <p>Hai completato il quiz per il corso <strong>$courseName</strong>.</p>

                <div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; text-align: center;'>
                    <h3 style='margin-top: 0; color: $statusColor;'>$statusText</h3>
                    <p style='font-size: 24px; font-weight: bold; color: $statusColor; margin: 10px 0;'>$score%</p>
                    <p>$message</p>
                </div>

                " . ($passed ? "
                <div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                    <strong>Complimenti!</strong> Puoi procedere con il prossimo modulo del corso.
                </div>
                " : "
                <div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                    <strong>Continua a studiare!</strong> Rivedi il materiale e riprova il quiz quando ti senti pronto.
                </div>
                ") . "

                <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;'>
                    <p>Autoscuola Liana<br>
                    Via Amato, 4 - 80053 Castellammare di Stabia (NA)<br>
                    Tel: +39 06 12345678 | Email: info@autoscuolaliana.it</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Send newsletter email
     */
    public function sendNewsletter($toEmail, $subject, $content) {
        // Genera il link di disiscrizione
        $unsubscribeToken = $this->generateUnsubscribeToken($toEmail);
        $unsubscribeUrl = SITE_URL . "/unsubscribe.php?email=" . urlencode($toEmail) . "&token=" . $unsubscribeToken;

        // Sostituisci il placeholder nel contenuto
        $htmlContent = str_replace('[UNSUBSCRIBE_URL]', $unsubscribeUrl, $content);

        // Aggiungi footer con link di disiscrizione se non presente
        if (strpos($htmlContent, '[UNSUBSCRIBE_URL]') === false && strpos($htmlContent, 'unsubscribe') === false) {
            $htmlContent .= $this->getNewsletterFooter($unsubscribeUrl);
        }

        // Crea versione text semplice rimuovendo i tag HTML
        $textContent = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlContent));
        $textContent .= "\n\nPer disiscriverti: $unsubscribeUrl";

        return $this->sendEmail($toEmail, $subject, $htmlContent, $textContent);
    }

    /**
     * Generate unsubscribe token for email
     */
    private function generateUnsubscribeToken($email) {
        return hash_hmac('sha256', $email . time(), $this->apiKey);
    }

    /**
     * Get newsletter footer with unsubscribe link
     */
    private function getNewsletterFooter($unsubscribeUrl) {
        return "

            <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;'>
                <p>Autoscuola Liana<br>
                Via Amato, 4 - 80053 Castellammare di Stabia (NA)<br>
                Tel: 081 8701132 | Email: info@autoscuolaliana.it</p>
                <p><a href='$unsubscribeUrl' style='color: #666; text-decoration: underline;'>Clicca qui per disiscriverti dalla newsletter</a></p>
            </div>";
    }

    /**
     * Get quiz results text template
     */
    private function getQuizResultsTextTemplate($userName, $courseName, $score, $passed) {
        $statusText = $passed ? 'Superato' : 'Non superato';
        $message = $passed ?
            'Complimenti! Hai superato il quiz con successo.' :
            'Il quiz non è stato superato. Puoi riprovare dopo aver studiato di più.';

        return "Risultati del Quiz

Ciao $userName,

Hai completato il quiz per il corso '$courseName'.

Status: $statusText
Punteggio: $score%

$message

" . ($passed ? 'Complimenti! Puoi procedere con il prossimo modulo del corso.' : 'Continua a studiare! Rivedi il materiale e riprova il quiz quando ti senti pronto.') . "

Autoscuola Liana
Via Amato, 4 - 80053 Castellammare di Stabia (NA)
Tel: 081 8701132 | Email: info@autoscuolaliana.it";
    }
}
?>