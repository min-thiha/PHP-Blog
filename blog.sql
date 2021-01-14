CREATE TABLE `users` (
    `id` INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email`VARCHAR(100) NOT NULL,
    `password`VARCHAR(100) NOT NULL,
    `role` TINYINT(1),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIME
);


CREATE TABLE `posts` (
    `id` INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `title` TEXT,
    `content` LONGTEXT,
    `image` TEXT,
    `author_id` INT(11),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIME,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIME
);


CREATE TABLE `comments` (
    `id` INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `content` MEDIUMTEXT,
    `author_id` INT(11),
    `post_id` INT(11),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIME
);