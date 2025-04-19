DROP DATABASE IF EXISTS `bookhunter`;

CREATE DATABASE `bookhunter`;

USE `bookhunter`;

CREATE TABLE `users` (
	`id` VARCHAR(255) PRIMARY KEY , -- UUID Only For Auth
	`user_id` INT(11) NOT NULL UNIQUE AUTO_INCREMENT , -- For Another Actions
	`username` VARCHAR(255) NOT NULL ,
	`email` VARCHAR(255) NOT NULL UNIQUE,
	`password` VARCHAR(255)  NOT NULL,
	`bio` TEXT NULL,
	`photo` VARCHAR(255) NULL
);

CREATE TABLE `categories`(
	`id` BIGINT PRIMARY KEY  AUTO_INCREMENT ,
	`name` VARCHAR(255) NOT NULL
);

INSERT INTO `categories` (`name`) VALUES
	('fantasy'),('history'),('adventure'),('programming'),('classics'),
	('story'),('fiction'),('manga'),('drama'),('science');


CREATE TABLE `books`(
	`id` BIGINT PRIMARY KEY  AUTO_INCREMENT , 
	`title` VARCHAR(255) NOT NULL  ,
	`descreption` TEXT NOT NULL ,
	`cover` VARCHAR(255)  NOT NULL,
	`book` VARCHAR(255) NOT NULL,
	`author` INT(11) NOT NULL,
	`category_id`  BIGINT NOT NULL,
	`created_at` DATE DEFAULT CURRENT_DATE

);


ALTER TABLE `books` ADD CONSTRAINT `fk_book_author`

FOREIGN KEY (`author`) REFERENCES `users`(`user_id`)
ON DELETE CASCADE 
ON UPDATE CASCADE;


ALTER TABLE `books` ADD CONSTRAINT `fk_book_category`

FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
ON DELETE CASCADE 
ON UPDATE CASCADE;


