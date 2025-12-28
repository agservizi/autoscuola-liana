# Autoscuola Liana - Template UI/UX Professionale

Questo progetto contiene template HTML/CSS/JS professionali per il sito web di Autoscuola Liana, una scuola guida italiana.

## 🎨 Design System

### Colori Principali
- **Primario**: Navy Blue (#1a365d) - Trasmette fiducia e professionalità
- **Secondario**: Green (#38a169) - Rappresenta sicurezza e successo
- **Accent**: Orange (#dd6b20) - Per call-to-action e elementi importanti
- **Neutro**: Light Gray (#f7fafc) - Per sfondi e testi secondari

### Tipografia
- **Font principale**: Inter (Google Fonts)
- **Gerarchia**: Heading da h1 a h6 con pesi 300-800
- **Corpo testo**: 16px con line-height 1.6

### Componenti
- **Cards**: Design moderno con ombre e bordi arrotondati
- **Bottoni**: Varianti primary, secondary, outline
- **Form**: Input con icone e validazione
- **Navbar**: Responsive con logo e menu mobile
- **Footer**: Multi-colonna con link e social

## 📁 Struttura Template

```
templates/
├── home.html          # Homepage con hero, features, corsi, stats
├── dashboard.html     # Dashboard studente con sidebar e metriche
├── corsi.html         # Pagina corsi con filtri e card dettagliate
├── auth.html          # Login/Registrazione con toggle form
├── contatti.html      # Pagina contatti con form, mappa, FAQ
└── partials/          # Componenti riutilizzabili
    ├── navbar.php     # Navigation bar
    ├── footer.php     # Footer del sito
    └── sidebar.php    # Sidebar per dashboard
```

## 🚀 Come Utilizzare

### 1. Integrazione nei File PHP Esistenti

Per utilizzare questi template nei tuoi file PHP esistenti:

```php
// Includi il template base
<?php include 'templates/home.html'; ?>

// Oppure copia il contenuto HTML nei tuoi file PHP
// e sostituisci <?php include 'partials/navbar.php'; ?> con il tuo navbar
```

### 2. Personalizzazione

#### Logo
Aggiungi il tuo logo in `assets/img/logo.png` e aggiorna il navbar:

```html
<a class="navbar-brand" href="index.php">
    <img src="assets/img/logo.png" alt="Autoscuola Liana" height="40">
</a>
```

#### Contenuti Dinamici
Sostituisci i placeholder con dati PHP:

```php
<!-- Da -->
<h4 class="alert-heading">Benvenuto, [Nome Studente]!</h4>

<!-- A -->
<h4 class="alert-heading">Benvenuto, <?php echo htmlspecialchars($user['firstname']); ?>!</h4>
```

#### Database Integration
Integra con il tuo sistema esistente:

```php
// Esempio per dashboard
$user = getCurrentUser(); // La tua funzione
$corsi = getUserCourses($user['id']); // La tua funzione
```

### 3. CSS Personalizzazioni

Il file `assets/css/custom.css` contiene:

- **Variabili CSS**: Modifica colori in `:root`
- **Componenti**: Stili per card, bottoni, form
- **Responsive**: Breakpoint per mobile/tablet/desktop
- **Animazioni**: Transizioni smooth per interazioni

```css
/* Modifica colori principali */
:root {
    --primary-color: #1a365d;    /* Navy Blue */
    --secondary-color: #38a169;  /* Green */
    --accent-color: #dd6b20;     /* Orange */
}
```

## 📱 Responsive Design

- **Mobile First**: Design ottimizzato per dispositivi mobili
- **Tablet**: Layout adattivo per tablet (768px+)
- **Desktop**: Layout completo per schermi grandi (1024px+)
- **Navbar**: Collassabile su mobile con hamburger menu

## 🎯 Funzionalità JavaScript

### main.js
- **Form Validation**: Validazione real-time dei form
- **Toggle Auth**: Switch tra login e registrazione
- **Course Filtering**: Filtro corsi per categoria
- **Smooth Scrolling**: Navigazione fluida
- **Modal Management**: Gestione popup e alert

### Utilizzo
```javascript
// Esempio filtro corsi
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', () => {
        // Logica filtro
    });
});
```

## 🔧 Personalizzazioni Comuni

### 1. Aggiungere una Nuova Pagina
1. Copia un template esistente
2. Modifica contenuto e struttura
3. Aggiorna navbar se necessario
4. Aggiungi route nel tuo sistema PHP

### 2. Modificare il Layout
- **Grid System**: Usa Bootstrap classes (col-lg-8, col-md-6)
- **Spacing**: Classi margin/padding (mb-3, py-5)
- **Colors**: Usa variabili CSS (--primary-color)

### 3. Aggiungere Nuove Sezioni
```html
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <!-- Contenuto -->
            </div>
        </div>
    </div>
</section>
```

## 🎨 Best Practices

### Accessibilità
- **Semantica HTML**: Uso corretto di heading, nav, main
- **Colori**: Contrasto sufficiente per leggibilità
- **Focus**: Indicatori visibili per navigazione tastiera
- **Alt Text**: Descrizioni per immagini

### Performance
- **Font Loading**: Preconnect per Google Fonts
- **CSS Optimization**: Variabili per colori riutilizzabili
- **Image Optimization**: Formati moderni (WebP)
- **Lazy Loading**: Per immagini non critiche

### SEO
- **Meta Tags**: Title e description per ogni pagina
- **Heading Structure**: Gerarchia logica h1-h6
- **Schema Markup**: Per recensioni e contatti
- **Mobile Friendly**: Design responsive

## 📞 Supporto

Per personalizzazioni specifiche o integrazioni particolari, contatta il team di sviluppo.

---

**Autoscuola Liana** - Scuola Guida Professionale dal 2000