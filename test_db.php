<?php
try {
    $pdo = new PDO('mysql:host=92.113.22.1;dbname=u393875765_autoscuola', 'u393875765_autoscuola', 'Liana10@');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database remoto riuscita!\n";
    
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM users');
    $result = $stmt->fetch();
    echo 'Utenti nel database: ' . $result['count'] . "\n";
    
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM courses');
    $result = $stmt->fetch();
    echo 'Corsi nel database: ' . $result['count'] . "\n";
    
} catch (PDOException $e) {
    echo 'Errore connessione database remoto: ' . $e->getMessage() . "\n";
}
?>
