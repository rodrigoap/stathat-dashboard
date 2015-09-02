CREATE SCHEMA `geocoder_statdash`
  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `geocoder_statdash`.`stat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `json` text NOT NULL,
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8;
