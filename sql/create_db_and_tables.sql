CREATE DATABASE IF NOT EXISTS scms
        DEFAULT CHARACTER SET utf8
        DEFAULT COLLATE utf8_unicode_ci;
        
USE scms;

CREATE TABLE IF NOT EXISTS `categories` (
        `cat_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) UNSIGNED NOT NULL,
        `cat_name` VARCHAR(40) NOT NULL,
        `position` INT(3) NOT NULL,
        PRIMARY KEY (`cat_id`),
        KEY `user_id` (`user_id`)
)

CREATE TABLE IF NOT EXISTS `comments` (
        `comment_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `page_id` INT(11) UNSIGNED NOT NULL,
        `author` VARCHAR(50) NOT NULL,
        `email` VARCHAR(60) NOT NULL,
        `comment` TEXT NOT NULL,
        PRIMARY KEY (`comment_id`)
)

CREATE TABLE IF NOT EXISTS `pages` (
        `page_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) UNSIGNED NOT NULL,
        `cat_id` INT(11) UNSIGNED NOT NULL,
        `page_name` VARCHAR(40) NOT NULL,
        `content` TEXT NOT NULL,
        `position` INT(3) NOT NULL,
        `post_on` DATETIME NOT NULL,
        PRIMARY KEY (`page_id`),
        KEY `user_id` (`user_id`)
)

CREATE TABLE IF NOT EXISTS `users` (
        `user_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `first_name` VARCHAR(20) NOT NULL,
        `last_name` VARCHAR(40) NOT NULL,
        `email` VARCHAR(60) NOT NULL,
        `pass` VARCHAR(40) NOT NULL,
        `website` VARCHAR(60) DEFAULT NULL,
        `yahoo` VARCHAR(60) DEFAULT NULL,
        `bio` TEXT,
        `avatar` VARCHAR(60) DEFAULT NULL,
        `user_level` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
        `active` CHAR(32) DEFAULT NULL,
        `registration_date` DATETIME NOT NULL,
        PRIMARY KEY (`user_id`),
        UNIQUE KEY `email` (`email`),
        KEY `login` (`email`,`pass`)
)