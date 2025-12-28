# Bootstrap Installation - Autoscuola Liana

## File Installati Localmente

### Bootstrap 5.3.2
- **CSS**: `assets/bootstrap/bootstrap.min.css`
- **JavaScript**: `assets/bootstrap/bootstrap.bundle.min.js`

### Font Awesome 6.4.2
- **CSS**: `assets/fontawesome.min.css`

### Google Fonts
- **Inter Font**: Caricato da Google Fonts CDN

## Come aggiornare Bootstrap

Per aggiornare Bootstrap a una versione più recente:

```bash
# Rimuovi i file vecchi
rm assets/bootstrap/bootstrap.min.css
rm assets/bootstrap/bootstrap.bundle.min.js

# Scarica la nuova versione (sostituisci X.X.X con la versione desiderata)
curl -L -o assets/bootstrap/bootstrap.min.css https://cdn.jsdelivr.net/npm/bootstrap@X.X.X/dist/css/bootstrap.min.css
curl -L -o assets/bootstrap/bootstrap.bundle.min.js https://cdn.jsdelivr.net/npm/bootstrap@X.X.X/dist/js/bootstrap.bundle.min.js
```

## Vantaggi dell'installazione locale

- ✅ Nessuna dipendenza da CDN esterne
- ✅ Caricamento più veloce
- ✅ Controllo completo sui file
- ✅ Funzionamento offline
- ✅ Sicurezza migliorata (no rischi di CDN compromesse)

## File inclusi automaticamente

I file vengono inclusi automaticamente in tutti i template tramite:
- `includes/header.php` - CSS files
- `includes/footer.php` - JavaScript files