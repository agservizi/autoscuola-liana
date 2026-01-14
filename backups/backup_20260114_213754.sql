-- Backup Gestionale Nautica
-- 2026-01-14 21:37:54

DROP TABLE IF EXISTS `agenda_guide`;
CREATE TABLE `agenda_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `pratica_id` int(11) DEFAULT NULL,
  `data_guida` date NOT NULL,
  `orario_inizio` time NOT NULL,
  `orario_fine` time NOT NULL,
  `tipo_lezione` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_cliente` (`cliente_id`),
  KEY `idx_pratica` (`pratica_id`),
  KEY `idx_data` (`data_guida`),
  KEY `idx_orario` (`orario_inizio`,`orario_fine`),
  CONSTRAINT `agenda_guide_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clienti` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agenda_guide_ibfk_2` FOREIGN KEY (`pratica_id`) REFERENCES `pratiche` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `audit_log`;
CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `entity` varchar(50) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_entity` (`entity`,`entity_id`),
  KEY `idx_action` (`action`),
  CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utenti` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `audit_log` (`id`,`user_id`,`action`,`entity`,`entity_id`,`details`,`ip_address`,`user_agent`,`created_at`) VALUES
('1','1','login','utente','1',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','2026-01-14 19:41:56');

DROP TABLE IF EXISTS `auth_attempts`;
CREATE TABLE `auth_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_attempt` timestamp NULL DEFAULT NULL,
  `locked_until` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_user_ip` (`username`,`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `clienti`;
CREATE TABLE `clienti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp(),
  `data_modifica` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_nome_cognome` (`nome`,`cognome`),
  KEY `idx_telefono` (`telefono`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pagamenti`;
CREATE TABLE `pagamenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pratica_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `tipo_pagamento` enum('Acconto','Saldo','Rata','Pagamento unico') NOT NULL,
  `importo` decimal(10,2) NOT NULL,
  `metodo_pagamento` enum('Contanti','POS') NOT NULL,
  `data_pagamento` date NOT NULL,
  `note` text DEFAULT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_pratica` (`pratica_id`),
  KEY `idx_cliente` (`cliente_id`),
  KEY `idx_data` (`data_pagamento`),
  KEY `idx_metodo` (`metodo_pagamento`),
  CONSTRAINT `pagamenti_ibfk_1` FOREIGN KEY (`pratica_id`) REFERENCES `pratiche` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pagamenti_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clienti` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pratiche`;
CREATE TABLE `pratiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `data_apertura` date NOT NULL,
  `stato` enum('Aperta','In corso','Completata','Annullata') DEFAULT 'Aperta',
  `tipo_pratica` enum('Patente entro 12 miglia','Patente oltre 12 miglia','Patente D1','Rinnovo','Duplicato','Altro') NOT NULL,
  `tipo_altro_dettaglio` varchar(255) DEFAULT NULL,
  `totale_previsto` decimal(10,2) DEFAULT 0.00,
  `totale_pagato` decimal(10,2) DEFAULT 0.00,
  `residuo` decimal(10,2) GENERATED ALWAYS AS (`totale_previsto` - `totale_pagato`) STORED,
  `data_esame` date DEFAULT NULL,
  `esito_esame` enum('Superato','Non superato','In attesa') DEFAULT NULL,
  `data_conseguimento` date DEFAULT NULL,
  `numero_patente` varchar(50) DEFAULT NULL,
  `allegati` text DEFAULT NULL,
  `data_richiesta_rinnovo` date DEFAULT NULL,
  `data_completamento_rinnovo` date DEFAULT NULL,
  `note_rinnovo` text DEFAULT NULL,
  `motivo_duplicato` enum('Smarrimento','Deterioramento','Altro') DEFAULT NULL,
  `motivo_duplicato_dettaglio` varchar(255) DEFAULT NULL,
  `data_richiesta_duplicato` date DEFAULT NULL,
  `data_chiusura_duplicato` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp(),
  `data_modifica` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_cliente` (`cliente_id`),
  KEY `idx_data_apertura` (`data_apertura`),
  KEY `idx_stato` (`stato`),
  KEY `idx_tipo` (`tipo_pratica`),
  KEY `idx_data_esame` (`data_esame`),
  CONSTRAINT `pratiche_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clienti` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pratiche_allegati`;
CREATE TABLE `pratiche_allegati` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pratica_id` int(11) NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `filename_original` varchar(255) NOT NULL,
  `filename_stored` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `data_upload` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `idx_pratica` (`pratica_id`),
  CONSTRAINT `pratiche_allegati_ibfk_1` FOREIGN KEY (`pratica_id`) REFERENCES `pratiche` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pratiche_allegati_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `utenti` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `scheduled_jobs`;
CREATE TABLE `scheduled_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_key` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `interval_minutes` int(11) NOT NULL,
  `enabled` tinyint(1) DEFAULT 1,
  `last_run` timestamp NULL DEFAULT NULL,
  `last_status` enum('ok','error') DEFAULT NULL,
  `last_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_key` (`job_key`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `scheduled_jobs` (`id`,`job_key`,`description`,`interval_minutes`,`enabled`,`last_run`,`last_status`,`last_message`,`created_at`,`updated_at`) VALUES
('1','backup_daily','Backup database quotidiano','1440','1',NULL,NULL,NULL,'2026-01-14 19:42:59','2026-01-14 19:42:59'),
('2','audit_cleanup_weekly','Cleanup audit log settimanale','10080','1',NULL,NULL,NULL,'2026-01-14 19:42:59','2026-01-14 19:42:59'),
('3','notify_daily','Invio promemoria giornaliero','1440','1',NULL,NULL,NULL,'2026-01-14 19:42:59','2026-01-14 19:42:59');

DROP TABLE IF EXISTS `spese`;
CREATE TABLE `spese` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_spesa` date NOT NULL,
  `categoria` enum('Vincenzo','Luigi','Affitto barca','Benzina','Altro') NOT NULL,
  `categoria_altro` varchar(100) DEFAULT NULL,
  `importo` decimal(10,2) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_data` (`data_spesa`),
  KEY `idx_categoria` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `ruolo` enum('admin','operatore') DEFAULT 'operatore',
  `attivo` tinyint(1) DEFAULT 1,
  `data_creazione` timestamp NULL DEFAULT current_timestamp(),
  `data_modifica` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `utenti` (`id`,`username`,`password_hash`,`ruolo`,`attivo`,`data_creazione`,`data_modifica`) VALUES
('1','admin','$2y$12$jO4wQAAXxrUOvSlto0QtJe0o0RUXgGwE8gM.EsmkEEuAQm03Dg.de','admin','1','2026-01-14 19:12:30','2026-01-14 19:12:30');

