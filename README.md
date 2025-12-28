# Autoscuola Liana - Sistema di Gestione Corsi

Un sistema completo per la gestione di corsi di guida e quiz di simulazione esame, sviluppato con PHP puro, JavaScript vanilla e Bootstrap.

## 🚀 Caratteristiche

- **Frontend Pubblico**: Pagine istituzionali (Home, Chi siamo, Corsi, Contatti)
- **Area Studenti**: Dashboard, corsi teorici, quiz con timer, storico risultati
- **Area Admin**: Gestione completa di studenti, corsi, lezioni, quiz e risultati
- **Sicurezza**: Autenticazione sicura con password hash, prepared statements
- **Responsive**: Design mobile-first con Bootstrap customizzato

## 🛠️ Stack Tecnologico

- **Backend**: PHP 7.4+ (procedurale/OOP leggero)
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **UI**: Bootstrap 5 (customizzato)
- **Database**: MySQL 5.7+
- **Server**: Apache/Nginx con mod_rewrite

## 📋 Prerequisiti

- PHP 7.4 o superiore
- MySQL 5.7 o superiore
- Server web (Apache/Nginx)
- Composer (opzionale, per dipendenze future)

## 🚀 Installazione

1. **Clona il repository**:
   ```bash
   git clone https://github.com/your-repo/autoscuola-liana.git
   cd autoscuola-liana
   ```

2. **Configura il database**:
   - Crea un nuovo database MySQL
   - Importa il file `database.sql`
   - Crea un file `.env` nella root del progetto con le tue credenziali:
     ```
     DB_HOST=your_host
     DB_NAME=your_database_name
     DB_USER=your_username
     DB_PASS=your_password
     ```

3. **Configura il server web**:
   - Punta la document root alla cartella `public/`
   - Assicurati che `mod_rewrite` sia abilitato per Apache

4. **Imposta i permessi**:
   ```bash
   chmod 755 -R .
   chown www-data:www-data -R .
   ```

5. **Accedi al sistema**:
   - Apri il browser e vai a `http://localhost`
   - Credenziali admin: `admin` / `password`

## ⚙️ Configurazione Ambiente

Il progetto utilizza un file `.env` per gestire le credenziali del database in modo sicuro. Crea un file `.env` nella root del progetto con il seguente contenuto:

```env
DB_HOST=92.113.22.1
DB_NAME=u393875765_autoscuola
DB_USER=u393875765_autoscuola
DB_PASS=Liana10@
```

**Nota**: Il file `.env` è incluso nel `.gitignore` per evitare di committare credenziali sensibili.

## 📁 Struttura del Progetto

```
autoscuola-liana/
├── .env                    # Environment variables (non committato)
├── .gitignore             # Git ignore rules
├── .htaccess              # Apache rewrite rules
├── database.sql           # Database schema
├── README.md              # This file
├── public/                 # Document root
│   ├── index.php          # Home page
│   ├── chi-siamo.php      # Chi siamo
│   ├── corsi.php          # Lista corsi
│   ├── contatti.php       # Form contatti
│   ├── login.php          # Login
│   └── logout.php         # Logout
├── student/               # Area studenti
│   ├── dashboard.php      # Dashboard studente
│   ├── course.php         # Visualizzazione corso
│   └── quiz.php           # Sistema quiz
├── admin/                 # Area amministratore
│   ├── dashboard.php      # Dashboard admin
│   ├── students.php       # Gestione studenti
│   └── courses.php        # Gestione corsi
├── api/                   # API endpoints
│   ├── quiz.php           # API quiz
│   └── submit_quiz.php    # Invio risultati quiz
├── includes/              # File comuni
│   ├── config.php         # Configurazione
│   ├── db.php             # Connessione DB
│   ├── auth.php           # Autenticazione
│   ├── header.php         # Header comune
│   └── footer.php         # Footer comune
├── assets/                # Risorse statiche
│   ├── css/
│   │   └── custom.css     # CSS custom
│   ├── js/
│   │   └── main.js        # JavaScript principale
│   └── img/               # Immagini
└── database.sql           # Schema database
```

## 🔐 Sicurezza

- Password hash con `password_hash()`
- Prepared statements per tutte le query
- Sanitizzazione input
- Protezione CSRF (base)
- Sessioni sicure
- Controllo accessi basato sui ruoli

## 🎯 Funzionalità Principali

### Studenti
- Registrazione e login sicuro
- Accesso ai corsi teorici
- Completamento lezioni con progresso
- Quiz con timer e valutazione automatica
- Storico risultati e statistiche

### Amministratori
- Gestione completa utenti
- CRUD corsi e lezioni
- Creazione e modifica quiz
- Visualizzazione risultati studenti
- Gestione messaggi di contatto

## 🔧 Personalizzazione

### Stili
Modifica `assets/css/custom.css` per personalizzare l'aspetto.

### Configurazione
Aggiorna `includes/config.php` per:
- Credenziali database
- Impostazioni sito
- Configurazione sicurezza

## 📊 Database Schema

### Tabelle Principali
- `users`: Utenti (studenti/admin)
- `courses`: Corsi disponibili
- `lessons`: Lezioni dei corsi
- `quizzes`: Quiz dei corsi
- `questions`: Domande dei quiz
- `quiz_attempts`: Tentativi quiz studenti
- `lesson_progress`: Progresso lezioni
- `contacts`: Messaggi form contatto

## 🚀 Estensioni Future

- Sistema pagamenti online
- App mobile companion
- Certificati digitali
- Notifiche email
- API REST completa
- Integrazione con calendari
- Sistema prenotazioni lezioni pratiche

## 📝 Note di Sviluppo

- Codice commentato e modulare
- Architettura scalabile
- Preparato per espansioni future
- Standard PSR-4 per caricamento classi
- Error handling completo

## 🤝 Contributi

1. Fork il progetto
2. Crea un branch per la feature
3. Commit le modifiche
4. Push e apri una Pull Request

## 📄 Licenza

Questo progetto è distribuito sotto licenza MIT.

## 📞 Supporto

Per supporto o domande, contatta: info@autoscuolaliana.it