# Email Service con Resend - Autoscuola Liana

## Panoramica
Il sistema email di Autoscuola Liana utilizza Resend per l'invio di email transazionali. Questo servizio garantisce deliverability elevata e monitoraggio dettagliato delle email inviate.

## Configurazione

### 1. Account Resend
1. Registrati su [resend.com](https://resend.com)
2. Verifica il tuo dominio `autoscuolaliana.it`
3. Ottieni la tua API Key dalla dashboard

### 2. Configurazione Ambiente
Aggiungi al file `.env`:
```env
# Resend Email Configuration
RESEND_API_KEY=your_actual_resend_api_key_here
RESEND_FROM_EMAIL=noreply@autoscuolaliana.it
RESEND_FROM_NAME=Autoscuola Liana
```

### 3. Verifica Dominio
Prima di poter inviare email, verifica il dominio su Resend:
- Aggiungi i record DNS forniti da Resend
- Verifica che il dominio sia attivo

## Utilizzo del Servizio Email

### Inizializzazione
```php
require_once 'includes/EmailService.php';
$emailService = new EmailService();
```

### Tipi di Email Disponibili

#### 1. Reset Password
```php
$result = $emailService->sendPasswordResetEmail(
    'user@example.com',           // Destinatario
    'https://...',               // Link di reset
    'Mario Rossi'                // Nome utente (opzionale)
);
```

#### 2. Email di Benvenuto
```php
$result = $emailService->sendWelcomeEmail(
    'user@example.com',           // Destinatario
    'Mario Rossi',                // Nome utente
    'https://.../login'          // Link di accesso
);
```

#### 3. Conferma Iscrizione Corso
```php
$result = $emailService->sendCourseEnrollmentEmail(
    'user@example.com',           // Destinatario
    'Mario Rossi',                // Nome utente
    'Patente B - Corso Base'      // Nome del corso
);
```

#### 4. Risultati Quiz
```php
$result = $emailService->sendQuizResultsEmail(
    'user@example.com',           // Destinatario
    'Mario Rossi',                // Nome utente
    'Patente B - Corso Base',     // Nome del corso
    85,                          // Punteggio
    true                         // Superato (true/false)
);
```

### Gestione Risultati
```php
if ($result['success']) {
    // Email inviata con successo
    $emailId = $result['id']; // ID dell'email per tracking
    echo "Email inviata con ID: " . $emailId;
} else {
    // Errore nell'invio
    $error = $result['error'];
    error_log("Errore invio email: " . $error);
    // Gestisci l'errore (mostra messaggio utente, riprova, ecc.)
}
```

## Template Email

I template email sono ottimizzati per:
- **Responsive Design**: Compatibili con tutti i dispositivi
- **Brand Identity**: Utilizzo dei colori e logo Autoscuola Liana
- **Accessibilità**: Testo alternativo e struttura semantica
- **SEO**: Meta tag appropriati per client email

### Personalizzazione Template

I template possono essere personalizzati modificando i metodi privati in `EmailService.php`:
- `getPasswordResetTemplate()`
- `getWelcomeTemplate()`
- `getCourseEnrollmentTemplate()`
- `getQuizResultsTemplate()`

## Sicurezza

### Rate Limiting
Resend include automaticamente rate limiting per prevenire abusi.

### Autenticazione
- API Key crittografata
- Validazione dominio SPF/DKIM
- Monitoraggio tentativi di invio

### Privacy
- Nessun dato utente memorizzato nei log
- Conformità GDPR per dati personali
- Cancellazione automatica token di reset

## Monitoraggio

### Dashboard Resend
- Statistiche deliverability
- Aperture e click
- Bounce e complaint
- Geografia destinatari

### Logging Applicazione
```php
// Log successo
if ($result['success']) {
    error_log("Email sent successfully to: $email, ID: " . $result['id']);
}

// Log errori
if (!$result['success']) {
    error_log("Email sending failed to: $email, Error: " . ($result['error'] ?? 'Unknown'));
}
```

## Modalità Sviluppo

Quando `RESEND_API_KEY` non è configurata, il sistema:
- Non invia email reali
- Logga il contenuto nel file di errore
- Restituisce sempre successo per testing

```php
// In development mode, check error_log for email content
// In production, emails are sent via Resend API
```

## Troubleshooting

### Email non arrivano
1. Verifica configurazione API Key
2. Controlla verifica dominio su Resend
3. Verifica cartella spam
4. Controlla log applicazione

### Errori API
- `401 Unauthorized`: API Key non valida
- `403 Forbidden`: Dominio non verificato
- `429 Too Many Requests`: Rate limit superato
- `500 Internal Error`: Errore server Resend

### Test Email
```php
// Test email sending
$testResult = $emailService->sendPasswordResetEmail(
    'test@example.com',
    'https://example.com/reset?token=test',
    'Test User'
);
```

## Costi

Resend offre un piano gratuito con:
- 3.000 email/mese
- Piani a pagamento per volumi maggiori

Monitora l'utilizzo nella dashboard per evitare interruzioni del servizio.