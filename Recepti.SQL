/*
Created: 05/09/2024
Modified: 05/09/2024
Model: Recepti
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table recepti

CREATE TABLE `recepti`
(
  `id` Int NOT NULL,
  `ime` Varchar(100) NOT NULL,
  `uporabnik_id` Int NOT NULL,
  `opis` Text NOT NULL,
  `sestavine` Text NOT NULL
)
;

CREATE INDEX `IX_Relationship3` ON `recepti` (`uporabnik_id`)
;

ALTER TABLE `recepti` ADD PRIMARY KEY (`id`)
;

-- Table uporabniki

CREATE TABLE `uporabniki`
(
  `id` Int NOT NULL,
  `ime` Varchar(100) NOT NULL,
  `priimek` Varchar(100) NOT NULL,
  `telefon` Varchar(100),
  `email` Varchar(100) NOT NULL,
  `geslo` Varchar(100) NOT NULL,
  `vrste_up_id` Int NOT NULL
)
;

CREATE INDEX `IX_Relationship1` ON `uporabniki` (`vrste_up_id`)
;

ALTER TABLE `uporabniki` ADD PRIMARY KEY (`id`)
;

-- Table vrste_up

CREATE TABLE `vrste_up`
(
  `id` Int NOT NULL,
  `ime` Varchar(100) NOT NULL,
  `opis` Text
)
;

ALTER TABLE `vrste_up` ADD PRIMARY KEY (`id`)
;

-- Table ocene

CREATE TABLE `ocene`
(
  `id` Int NOT NULL,
  `ocena` Int NOT NULL,
  `recept_id` Int NOT NULL,
  `uporabnik_id` Int NOT NULL
)
;

CREATE INDEX `IX_Relationship6` ON `ocene` (`recept_id`)
;

CREATE INDEX `IX_Relationship8` ON `ocene` (`uporabnik_id`)
;

ALTER TABLE `ocene` ADD PRIMARY KEY (`id`)
;

-- Table slike

CREATE TABLE `slike`
(
  `id` Int NOT NULL,
  `ime` Varchar(100) NOT NULL,
  `url` Text NOT NULL,
  `recept_id` Int NOT NULL
)
;

CREATE INDEX `IX_Relationship9` ON `slike` (`recept_id`)
;

ALTER TABLE `slike` ADD PRIMARY KEY (`id`)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `uporabniki` ADD CONSTRAINT `Relationship1` FOREIGN KEY (`vrste_up_id`) REFERENCES `vrste_up` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `recepti` ADD CONSTRAINT `Relationship3` FOREIGN KEY (`uporabnik_id`) REFERENCES `uporabniki` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `ocene` ADD CONSTRAINT `Relationship6` FOREIGN KEY (`recept_id`) REFERENCES `recepti` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `ocene` ADD CONSTRAINT `Relationship8` FOREIGN KEY (`uporabnik_id`) REFERENCES `uporabniki` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `slike` ADD CONSTRAINT `Relationship9` FOREIGN KEY (`recept_id`) REFERENCES `recepti` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;


