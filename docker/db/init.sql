SET NAMES utf8;
SET GLOBAL time_zone = 'Europe/Moscow';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE USER click IDENTIFIED WITH mysql_native_password BY 'click';
GRANT ALL PRIVILEGES ON *.* TO 'click'@'%';

DROP DATABASE IF EXISTS `x`;
CREATE DATABASE `x` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `x`;

DROP TABLE IF EXISTS `urls`;

CREATE TABLE urls (
   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `created_at` timestamp NOT NULL DEFAULT current_timestamp,
   `created_month` tinyint NOT NULL,
   `created_day` tinyint NOT NULL,
   `created_hour` tinyint NOT NULL,
   `created_minute` tinyint NOT NULL,
   `url` text NOT NULL,
   `content_length` bigint(20) unsigned NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
