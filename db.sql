CREATE DATABASE slab_warriors_teszt;

USE slab_warriors_teszt;

DROP TABLE IF EXISTS fighter;

CREATE TABLE `fighter` (
	`id` INT NOT NULL,
	`type` VARCHAR(255) NOT NULL,
	`details` TEXT NOT NULL,
	`level` INT NOT NULL,
	`hp` FLOAT NOT NULL,
	`attack` FLOAT NOT NULL,
	`summon_cost` INT NOT NULL,
	PRIMARY KEY (`id`)
);