CREATE SCHEMA `geocoder_statdash`
  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `stat` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `json` text NOT NULL,
    `id_dash` varchar(10) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `unq_id_stat` (`id_dash`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
