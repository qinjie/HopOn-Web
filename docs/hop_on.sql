/*
SQLyog Ultimate v12.04 (64 bit)
MySQL - 10.1.10-MariaDB : Database - hop_on
*********************************************************************
*/
DROP DATABASE /*!32312 IF EXISTS*/`hop_on`;

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hop_on` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `hop_on`;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `device_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profileImg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` smallint(6) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`email`,`status`,`created_at`,`updated_at`,`name`,`role`, `device_hash`) values 
  (1,'1111','ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA','$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa','1111@gmail.com',10,1461214049,1461926225,'user',10,'0'),
  (2,'2222','ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA','$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa','2222@gmail.com',10,1461214049,1461926225,'user',10,'0'),
  (3,'3333','ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA','$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa','3333@gmail.com',10,1461214049,1461926225,'user',10,'0');
 
/*Table structure for table `user_token` */

DROP TABLE IF EXISTS `user_token`;

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `expire_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `action` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  CONSTRAINT `usertoken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `user_token` */


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
