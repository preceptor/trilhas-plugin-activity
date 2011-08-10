CREATE TABLE IF NOT EXISTS `activity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `classroom_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `begin` date NOT NULL,
  `end` date DEFAULT NULL,
  `status` enum('active','inactive','final') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `classroom_id` (`classroom_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `activity_text` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `activity_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `status` enum('open','final','close') DEFAULT 'open',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `activity_id` (`activity_id`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB;

ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`id`);

ALTER TABLE `activity_text`
  ADD CONSTRAINT `activity_text_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `activity_text_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `activity_text_ibfk_3` FOREIGN KEY (`sender`) REFERENCES `user` (`id`);
