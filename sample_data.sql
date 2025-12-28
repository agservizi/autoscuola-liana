-- Sample data for Autoscuola Liana
USE autoscuola_liana;

-- Insert admin user
INSERT INTO users (username, password, email, role, first_name, last_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@autoscuolaliana.it', 'admin', 'Admin', 'Liana');

-- Insert sample courses
INSERT INTO courses (name, description, category) VALUES
('Teoria Base', 'Corso completo di teoria per la patente B. Include tutte le nozioni fondamentali per la guida sicura.', 'Patente B'),
('Teoria Avanzata', 'Approfondimenti teorici per una preparazione completa all\'esame di teoria.', 'Patente B'),
('Guida Sicura', 'Tecniche avanzate di guida sicura e prevenzione incidenti.', 'Patente B'),
('Patente A - Teoria', 'Corso completo per la teoria della patente A (moto).', 'Patente A'),
('Recupero Punti', 'Corso intensivo per il recupero dei punti patente.', 'Recupero');

-- Insert sample lessons
INSERT INTO lessons (course_id, title, content, lesson_order) VALUES
(1, 'Segnali Stradali', 'Studio completo dei segnali stradali verticali e orizzontali.', 1),
(1, 'Norme della Circolazione', 'Regole fondamentali del codice della strada.', 2),
(1, 'Comportamento del Conducente', 'Responsabilità e comportamento corretto alla guida.', 3),
(2, 'Veicoli e Sicurezza', 'Caratteristiche tecniche dei veicoli e dispositivi di sicurezza.', 1),
(2, 'Incidenti Stradali', 'Prevenzione e comportamento in caso di incidente.', 2);

-- Insert sample quizzes
INSERT INTO quizzes (course_id, title, description, time_limit, passing_score) VALUES
(1, 'Quiz Segnali Stradali', 'Test sui segnali stradali appresi nella lezione 1.', 15, 80),
(1, 'Quiz Norme Circolazione', 'Verifica delle conoscenze sulle norme della circolazione.', 20, 75),
(2, 'Quiz Sicurezza', 'Test sulle norme di sicurezza stradale.', 25, 80);

-- Insert sample questions (for quiz 1)
INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, correct_answer) VALUES
(1, 'Cosa indica un segnale stradale triangolare?', 'Obbligo', 'Divieto', 'Pericolo', 'C'),
(1, 'Qual è il significato del segnale "Stop"?', 'Fermarsi sempre', 'Rallentare', 'Precedenza', 'A'),
(1, 'I segnali di divieto sono di forma:', 'Circolare', 'Triangolare', 'Quadrata', 'A');

-- Insert sample quiz attempts
INSERT INTO quiz_attempts (user_id, quiz_id, score, passed, attempt_date) VALUES
(1, 1, 85, 1, NOW()),
(1, 2, 92, 1, NOW());

-- Insert sample contacts
INSERT INTO contacts (name, email, phone, subject, message, created_at) VALUES
('Mario Rossi', 'mario.rossi@email.com', '3331234567', 'Informazioni corsi', 'Vorrei informazioni sui corsi per la patente B.', NOW()),
('Laura Bianchi', 'laura.bianchi@email.com', '3349876543', 'Recupero punti', 'Ho bisogno di recuperare 8 punti patente. Quali sono le opzioni disponibili?', NOW());