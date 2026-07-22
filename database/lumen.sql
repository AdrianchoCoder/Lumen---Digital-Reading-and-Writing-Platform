-- =============================================================================
-- Lumen — esquema completo de base de datos (módulo 2)
-- Motor: MySQL 5.7+ / MariaDB (XAMPP)
-- Charset: utf8mb4 (soporta emojis y acentos)
-- PKs: INT UNSIGNED AUTO_INCREMENT (eficiente en joins e índices)
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `lumen`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `lumen`;

-- -----------------------------------------------------------------------------
-- users
-- Rol jerárquico en un solo campo ENUM (lector < escritor < administrador).
-- Los niveles numéricos (1/2/3) viven en config/config.php para el middleware.
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `follows`;
DROP TABLE IF EXISTS `chapters`;
DROP TABLE IF EXISTS `books`;
DROP TABLE IF EXISTS `writer_requests`;
DROP TABLE IF EXISTS `communities`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `display_name` VARCHAR(100) NOT NULL,
  `bio` VARCHAR(500) NULL DEFAULT NULL,
  `avatar_path` VARCHAR(255) NULL DEFAULT NULL,
  `role` ENUM('lector', 'escritor', 'administrador') NOT NULL DEFAULT 'lector',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_username` (`username`),
  UNIQUE KEY `uq_users_email` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- writer_requests
-- Solicitud de un lector para convertirse en escritor.
-- reviewed_by = admin que resolvió; ON DELETE SET NULL para no perder el historial
-- si se elimina la cuenta del admin.
-- -----------------------------------------------------------------------------
CREATE TABLE `writer_requests` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `motivation` TEXT NOT NULL,
  `status` ENUM('pendiente', 'aprobado', 'rechazado') NOT NULL DEFAULT 'pendiente',
  `admin_note` VARCHAR(500) NULL DEFAULT NULL,
  `reviewed_by` INT UNSIGNED NULL DEFAULT NULL,
  `reviewed_at` DATETIME NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_writer_requests_user` (`user_id`),
  KEY `idx_writer_requests_status` (`status`),
  KEY `idx_writer_requests_reviewed_by` (`reviewed_by`),
  CONSTRAINT `fk_writer_requests_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_writer_requests_admin`
    FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- books (historias)
-- Ligadas al autor (usuario con rol escritor o administrador).
-- -----------------------------------------------------------------------------
CREATE TABLE `books` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `synopsis` TEXT NULL DEFAULT NULL,
  `cover_path` VARCHAR(255) NULL DEFAULT NULL,
  `genre` VARCHAR(80) NULL DEFAULT NULL,
  `status` ENUM('borrador', 'publicado', 'archivado') NOT NULL DEFAULT 'borrador',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_books_author` (`author_id`),
  KEY `idx_books_status` (`status`),
  KEY `idx_books_genre` (`genre`),
  KEY `idx_books_title` (`title`),
  CONSTRAINT `fk_books_author`
    FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- chapters
-- -----------------------------------------------------------------------------
CREATE TABLE `chapters` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` INT UNSIGNED NOT NULL,
  `number` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `status` ENUM('borrador', 'publicado') NOT NULL DEFAULT 'borrador',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_chapters_book_number` (`book_id`, `number`),
  KEY `idx_chapters_status` (`status`),
  CONSTRAINT `fk_chapters_book`
    FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- follows (relación asimétrica: A sigue a B)
-- Clave primaria compuesta evita duplicados.
-- -----------------------------------------------------------------------------
CREATE TABLE `follows` (
  `follower_id` INT UNSIGNED NOT NULL,
  `followed_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`follower_id`, `followed_id`),
  KEY `idx_follows_followed` (`followed_id`),
  CONSTRAINT `fk_follows_follower`
    FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_follows_followed`
    FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chk_follows_not_self`
    CHECK (`follower_id` <> `followed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- communities (módulo escritor)
-- -----------------------------------------------------------------------------
CREATE TABLE `communities` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(120) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `cover_path` VARCHAR(255) NULL DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_communities_name` (`name`),
  KEY `idx_communities_owner` (`owner_id`),
  KEY `idx_communities_active` (`is_active`),
  CONSTRAINT `fk_communities_owner`
    FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------------------
-- Datos iniciales (opcional pero útil para pruebas)
-- Usuario administrador de demo.
-- Email: admin@lumen.local
-- Contraseña: Admin123!
-- (hash generado con password_hash de PHP)
-- -----------------------------------------------------------------------------
INSERT INTO `users` (`username`, `email`, `password_hash`, `display_name`, `bio`, `role`)
VALUES (
  'admin',
  'admin@lumen.local',
  '$2y$10$dqcwzURS8xM7fIF1kgPfCuWd6YpIHewwmHAIN93UXDPl87srMdy4O',
  'Administrador Lumen',
  'Cuenta de administración para pruebas del proyecto.',
  'administrador'
);
