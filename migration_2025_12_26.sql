-- Migration: Enhanced Test Data for Admin Area
-- Date: 26 dicembre 2025
-- Description: Adds comprehensive test data for all admin functionalities

USE autoscuola_liana;

-- Clear existing data (optional - comment out if you want to keep existing data)
-- DELETE FROM quiz_attempts;
-- DELETE FROM questions;
-- DELETE FROM quizzes;
-- DELETE FROM lesson_progress;
-- DELETE FROM lessons;
-- DELETE FROM courses;
-- DELETE FROM contacts;
-- DELETE FROM users WHERE role = 'student';

-- Insert additional test students
INSERT IGNORE INTO users (username, password, email, role, first_name, last_name) VALUES
('student1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student1@email.com', 'student', 'Mario', 'Rossi'),
('student2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student2@email.com', 'student', 'Laura', 'Bianchi'),
('student3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student3@email.com', 'student', 'Giuseppe', 'Verdi'),
('student4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student4@email.com', 'student', 'Anna', 'Neri'),
('student5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student5@email.com', 'student', 'Luca', 'Gialli');

-- Insert additional courses
INSERT IGNORE INTO courses (name, description, category) VALUES
('Teoria Base Completa', 'Corso completo di teoria per la patente B con esercitazioni pratiche e test.', 'Patente B'),
('Guida Sicura Avanzata', 'Corso avanzato per la guida sicura con focus sulla prevenzione incidenti.', 'Patente B'),
('Patente A - Corso Completo', 'Corso completo per la patente A con teoria e pratica su due ruote.', 'Patente A'),
('Recupero Punti Intensivo', 'Corso intensivo di 24 ore per il recupero dei punti patente.', 'Recupero'),
('Aggiornamento Patentino', 'Corso di aggiornamento per il patentino di guida.', 'Aggiornamento');

-- Insert comprehensive lessons for each course
INSERT IGNORE INTO lessons (course_id, title, content, video_url, lesson_order) VALUES
-- Corso 1: Teoria Base Completa
(1, 'Introduzione al Codice della Strada', 'Panoramica generale del codice della strada italiano e principi fondamentali.', 'https://example.com/video1', 1),
(1, 'Segnali Stradali Verticali', 'Studio dettagliato dei segnali verticali: di pericolo, di prescrizione, di indicazione.', 'https://example.com/video2', 2),
(1, 'Segnali Stradali Orizzontali', 'Segnali orizzontali: strisce, frecce, scritte sul manto stradale.', 'https://example.com/video3', 3),
(1, 'Norme di Comportamento', 'Regole di comportamento del conducente e responsabilità civile.', 'https://example.com/video4', 4),
(1, 'Veicoli e Documenti', 'Caratteristiche tecniche dei veicoli e documenti obbligatori.', 'https://example.com/video5', 5),

-- Corso 2: Guida Sicura Avanzata
(2, 'Prevenzione Incidenti', 'Tecniche per prevedere e prevenire situazioni di pericolo.', 'https://example.com/video6', 1),
(2, 'Guida in Autostrada', 'Norme specifiche per la circolazione in autostrada.', 'https://example.com/video7', 2),
(2, 'Guida Notturna', 'Particolarità della guida notturna e in condizioni di scarsa visibilità.', 'https://example.com/video8', 3),
(2, 'Guida con Nebbia e Pioggia', 'Comportamento corretto in condizioni atmosferiche avverse.', 'https://example.com/video9', 4),

-- Corso 3: Patente A
(3, 'Introduzione alla Moto', 'Caratteristiche tecniche delle motociclette e differenze con gli autoveicoli.', 'https://example.com/video10', 1),
(3, 'Equipaggiamento di Sicurezza', 'Casco, giubbotto, guanti e altri dispositivi di protezione.', 'https://example.com/video11', 2),
(3, 'Guida in Gruppo', 'Norme per la circolazione in gruppo e sicurezza collettiva.', 'https://example.com/video12', 3),

-- Corso 4: Recupero Punti
(4, 'Cause delle Decurtazioni', 'Analisi delle principali cause di perdita punti patente.', 'https://example.com/video13', 1),
(4, 'Strategie di Recupero', 'Metodi efficaci per recuperare i punti persi.', 'https://example.com/video14', 2),

-- Corso 5: Aggiornamento
(5, 'Novità Normative', 'Aggiornamenti alle normative del codice della strada.', 'https://example.com/video15', 1),
(5, 'Tecnologie Veicoli', 'Nuove tecnologie nei veicoli moderni.', 'https://example.com/video16', 2);

-- Insert comprehensive quizzes
INSERT IGNORE INTO quizzes (course_id, title, description, time_limit, passing_score) VALUES
(1, 'Quiz Segnali Stradali Base', 'Test sui segnali stradali fondamentali.', 15, 80),
(1, 'Quiz Norme di Circolazione', 'Verifica delle conoscenze sulle norme base.', 20, 75),
(1, 'Quiz Veicoli e Sicurezza', 'Test sulle caratteristiche dei veicoli.', 18, 80),
(2, 'Quiz Prevenzione Incidenti', 'Test sulle tecniche di prevenzione.', 25, 85),
(2, 'Quiz Condizioni Avverse', 'Test sulla guida in condizioni particolari.', 20, 80),
(3, 'Quiz Patente A Base', 'Test specifico per la patente A.', 22, 80),
(4, 'Quiz Recupero Punti', 'Test finale per il recupero punti.', 30, 90),
(5, 'Quiz Aggiornamento', 'Test di verifica aggiornamenti.', 15, 75);

-- Insert comprehensive questions for quizzes
INSERT IGNORE INTO questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer, explanation) VALUES
-- Quiz 1: Segnali Stradali Base
(1, 'Cosa indica un segnale triangolare con bordo rosso?', 'Obbligo', 'Divieto di sosta', 'Pericolo', 'Indicazioni', 'c', 'I segnali triangolari con bordo rosso indicano situazioni di pericolo.'),
(1, 'Qual è il significato del segnale circolare blu con striscia diagonale rossa?', 'Divieto di accesso', 'Divieto di sosta', 'Divieto di fermata', 'Precedenza', 'b', 'Il segnale circolare blu con striscia rossa diagonale indica divieto di sosta.'),
(1, 'I segnali di obbligo sono generalmente di forma:', 'Triangolare', 'Circolare blu', 'Quadrata', 'Rettangolare', 'b', 'I segnali di obbligo sono generalmente circolari di colore blu.'),

-- Quiz 2: Norme di Circolazione
(2, 'Qual è il limite di velocità in autostrada per autoveicoli?', '110 km/h', '130 km/h', '90 km/h', '150 km/h', 'b', 'Il limite di velocità in autostrada è 130 km/h per la maggior parte degli autoveicoli.'),
(2, 'In caso di nebbia fitta, il conducente deve:', 'Aumentare la velocità', 'Mantenere la distanza di sicurezza', 'Usare gli abbaglianti', 'Fermarsi sul bordo strada', 'b', 'In nebbia fitta è fondamentale mantenere una distanza di sicurezza maggiore.'),
(2, 'Il segnale "STOP" impone:', 'Una sosta temporanea', 'L\'arresto completo', 'Una riduzione di velocità', 'La precedenza', 'b', 'Il segnale STOP impone l\'arresto completo del veicolo.'),

-- Quiz 3: Veicoli e Sicurezza
(3, 'Qual è la periodicità della revisione per autoveicoli?', 'Ogni 2 anni', 'Ogni 4 anni', 'Ogni anno', 'Ogni 6 mesi', 'b', 'La revisione degli autoveicoli deve essere effettuata ogni 4 anni.'),
(3, 'Il triangolo di emergenza deve essere posto a:', '50 metri dal veicolo', '100 metri dal veicolo', '30 metri dal veicolo', 'Sul tetto del veicolo', 'a', 'Il triangolo va posto a circa 50 metri dal veicolo in caso di emergenza.'),

-- Quiz 4: Prevenzione Incidenti
(4, 'Qual è la distanza di sicurezza minima da mantenere?', 'Uguale alla velocità in km/h', 'La metà della velocità', 'Il doppio della velocità', 'Non è regolamentata', 'a', 'La distanza di sicurezza dovrebbe essere almeno pari alla velocità in km/h.'),
(4, 'In curva, è consigliabile:', 'Accelerare', 'Frenare bruscamente', 'Rallentare gradualmente', 'Mantenere velocità costante', 'c', 'In curva è necessario rallentare gradualmente prima dell\'entrata.'),

-- Quiz 5: Condizioni Avverse
(5, 'Con la pioggia, la distanza di frenata:', 'Diminuisce', 'Resta invariata', 'Aumenta', 'Dipende dal veicolo', 'c', 'Con la pioggia la distanza di frenata aumenta significativamente.'),
(5, 'In caso di nebbia, è obbligatorio l\'uso dei:', 'Abbaglianti', 'Anabbaglianti', 'Luci di posizione', 'Fari di profondità', 'b', 'In nebbia è obbligatorio l\'uso degli anabbaglianti.'),

-- Quiz 6: Patente A
(6, 'Per la patente A, l\'età minima è:', '16 anni', '18 anni', '21 anni', '25 anni', 'b', 'L\'età minima per la patente A è 18 anni.'),
(6, 'Il casco protettivo è obbligatorio:', 'Solo in autostrada', 'Sempre per il conducente', 'Solo di notte', 'Solo in città', 'b', 'Il casco è obbligatorio sempre per il conducente di motocicletta.'),

-- Quiz 7: Recupero Punti
(7, 'Il corso di recupero punti ha durata di:', '8 ore', '12 ore', '24 ore', '36 ore', 'c', 'Il corso di recupero punti ha una durata minima di 24 ore.'),
(7, 'Dopo il corso, i punti recuperati sono:', '4 punti', '6 punti', '8 punti', '10 punti', 'b', 'Il corso permette di recuperare fino a 6 punti patente.'),

-- Quiz 8: Aggiornamento
(8, 'La validità del patentino è di:', '5 anni', '10 anni', '15 anni', '20 anni', 'b', 'Il patentino di guida ha validità 10 anni.'),
(8, 'Il corso di aggiornamento ha durata di:', '4 ore', '8 ore', '12 ore', '18 ore', 'c', 'Il corso di aggiornamento patentino ha durata di 12 ore.');

-- Insert sample quiz attempts for testing statistics
INSERT IGNORE INTO quiz_attempts (user_id, quiz_id, score, passed, attempt_date) VALUES
(2, 1, 85, 1, NOW()),
(2, 2, 78, 0, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 3, 92, 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(3, 1, 88, 1, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(3, 2, 95, 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(4, 1, 76, 0, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(4, 4, 82, 1, NOW()),
(5, 5, 89, 1, DATE_SUB(NOW(), INTERVAL 2 DAY));

-- Insert sample lesson progress
INSERT IGNORE INTO lesson_progress (user_id, lesson_id, completed, completed_at) VALUES
(2, 1, 1, DATE_SUB(NOW(), INTERVAL 5 DAY)),
(2, 2, 1, DATE_SUB(NOW(), INTERVAL 4 DAY)),
(2, 3, 0, NULL),
(3, 1, 1, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(3, 2, 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(3, 3, 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(4, 1, 1, NOW()),
(5, 1, 0, NULL),
(5, 2, 0, NULL);

-- Insert additional contact messages
INSERT IGNORE INTO contacts (name, email, phone, subject, message) VALUES
('Roberto Verdi', 'roberto.verdi@email.com', '3387778888', 'Informazioni corsi', 'Vorrei informazioni sui corsi per la patente A.'),
('Sara Blu', 'sara.blu@email.com', '3399990000', 'Orari corsi', 'Quando iniziano i prossimi corsi di recupero punti?'),
('Marco Giallo', 'marco.giallo@email.com', '3311112222', 'Recupero punti', 'Ho perso 10 punti, posso recuperarli tutti?'),
('Elena Rosa', 'elena.rosa@email.com', '3322223333', 'Costi corsi', 'Costo del corso completo patente B?'),
('Paolo Viola', 'paolo.viola@email.com', '3333334444', 'Orari lezioni', 'Orari delle lezioni serali?');

-- Update timestamps to make data look more realistic
UPDATE users SET created_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 365) DAY) WHERE role = 'student';
UPDATE courses SET created_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 180) DAY);
UPDATE lessons SET created_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 150) DAY);
UPDATE quizzes SET created_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 120) DAY);
UPDATE questions SET created_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 100) DAY);
UPDATE contacts SET submitted_at = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 90) DAY);

COMMIT;