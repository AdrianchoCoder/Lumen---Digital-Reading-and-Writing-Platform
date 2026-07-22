-- Parche módulo 4: biblioteca + datos demo (para BD ya importada)
-- Ejecutar una vez en phpMyAdmin o:
--   mysql -u root lumen < database/patch_modulo4.sql

USE `lumen`;

CREATE TABLE IF NOT EXISTS `library` (
  `user_id` INT UNSIGNED NOT NULL,
  `book_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `book_id`),
  KEY `idx_library_book` (`book_id`),
  CONSTRAINT `fk_library_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_library_book`
    FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`username`, `email`, `password_hash`, `display_name`, `bio`, `role`)
SELECT 'luna_writes', 'escritor@lumen.local',
       '$2y$10$jHy4S4XKPNLfEEprlv/qDeaF6XHD50p6lzt/f7VNxAX/suf3VMF4q',
       'Luna Escritora', 'Escribo fantasía urbana y relatos cortos.', 'escritor'
WHERE NOT EXISTS (SELECT 1 FROM `users` WHERE `username` = 'luna_writes');

INSERT INTO `books` (`author_id`, `title`, `synopsis`, `genre`, `status`)
SELECT u.id, 'Luces sobre el río',
       'Una joven descubre que las farolas de su ciudad guardan memorias de quienes las miran demasiado tiempo.',
       'Fantasía', 'publicado'
FROM `users` u
WHERE u.username = 'luna_writes'
  AND NOT EXISTS (SELECT 1 FROM `books` WHERE `title` = 'Luces sobre el río')
LIMIT 1;

INSERT INTO `books` (`author_id`, `title`, `synopsis`, `genre`, `status`)
SELECT u.id, 'Café a medianoche',
       'Historias breves de desconocidos que coinciden siempre en la misma mesa de un café 24 horas.',
       'Contemporáneo', 'publicado'
FROM `users` u
WHERE u.username = 'luna_writes'
  AND NOT EXISTS (SELECT 1 FROM `books` WHERE `title` = 'Café a medianoche')
LIMIT 1;

INSERT INTO `chapters` (`book_id`, `number`, `title`, `content`, `status`)
SELECT b.id, 1, 'Capítulo 1',
       'El río brillaba como si alguien hubiera derramado estrellas sobre el agua.\n\nMarina detuvo la bicicleta y miró la farola más cercana: parpadeó dos veces, como saludando.',
       'publicado'
FROM `books` b
WHERE b.title = 'Luces sobre el río'
  AND NOT EXISTS (SELECT 1 FROM `chapters` c WHERE c.book_id = b.id AND c.number = 1)
LIMIT 1;

INSERT INTO `chapters` (`book_id`, `number`, `title`, `content`, `status`)
SELECT b.id, 1, 'Primera visita',
       'El barista no preguntó el nombre. Solo dejó una taza humeante y dijo: \"La de siempre\".\n\nEl problema era que era la primera vez.',
       'publicado'
FROM `books` b
WHERE b.title = 'Café a medianoche'
  AND NOT EXISTS (SELECT 1 FROM `chapters` c WHERE c.book_id = b.id AND c.number = 1)
LIMIT 1;
