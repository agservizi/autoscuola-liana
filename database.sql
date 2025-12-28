-- Database schema for Autoscuola Liana
-- Create database
CREATE DATABASE IF NOT EXISTS autoscuola_liana;
USE autoscuola_liana;

-- Users table (students and admins)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('student', 'admin') NOT NULL DEFAULT 'student',
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50), -- e.g., 'Patente B', 'Patente A'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Lessons table
CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    video_url VARCHAR(255),
    lesson_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Quizzes table
CREATE TABLE quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    time_limit INT, -- in minutes
    passing_score INT DEFAULT 80, -- percentage
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Questions table
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question TEXT NOT NULL,
    option_a TEXT NOT NULL,
    option_b TEXT NOT NULL,
    option_c TEXT NOT NULL,
    option_d TEXT,
    correct_answer CHAR(1) NOT NULL, -- 'a', 'b', 'c', 'd'
    explanation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

-- Quiz attempts table
CREATE TABLE quiz_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    quiz_id INT NOT NULL,
    score INT NOT NULL, -- percentage
    passed BOOLEAN NOT NULL,
    attempt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

-- Lesson progress table
CREATE TABLE lesson_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lesson_id INT NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    UNIQUE KEY unique_progress (user_id, lesson_id)
);

-- Contacts table for contact form
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
-- Admin user
INSERT INTO users (username, password, email, role, first_name, last_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@autoscuolaliana.it', 'admin', 'Admin', 'User'); -- password: password

-- Sample courses
INSERT INTO courses (name, description, category) VALUES
('Patente B', 'Corso completo per la patente B', 'Patente B'),
('Patente A2', 'Corso per la patente A2', 'Patente A'),
('Recupero Punti', 'Corso per il recupero dei punti patente', 'Recupero');

-- Sample lessons for Patente B
INSERT INTO lessons (course_id, title, content, lesson_order) VALUES
(1, 'Introduzione alla guida sicura', 'Contenuto della lezione 1...', 1),
(1, 'Segnali stradali', 'Contenuto della lezione 2...', 2);

-- Sample quiz
INSERT INTO quizzes (course_id, title, time_limit, passing_score) VALUES
(1, 'Quiz Patente B - Modulo 1', 30, 80);

-- Sample questions
INSERT INTO questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer, explanation) VALUES
(1, 'Cosa significa il segnale di stop?', 'Fermati completamente', 'Rallenta', 'Prosegui con cautela', 'Inversione di marcia', 'a', 'Il segnale di stop richiede di fermarsi completamente.'),
(1, 'Qual è il limite di velocità in città?', '50 km/h', '70 km/h', '90 km/h', '110 km/h', 'a', 'In Italia, il limite di velocità in città è generalmente 50 km/h.');