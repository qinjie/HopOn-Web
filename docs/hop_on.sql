-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 03, 2016 at 10:13 AM
-- Server version: 5.6.30-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP DATABASE /*!32312 IF EXISTS*/`hop_on`;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hop_on`
--
CREATE DATABASE IF NOT EXISTS `hop_on` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hop_on`;

-- --------------------------------------------------------

--
-- Table structure for table `beacon`
--

CREATE TABLE IF NOT EXISTS `beacon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) NOT NULL,
  `major` varchar(10) DEFAULT NULL,
  `minor` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `beacon`
--

INSERT INTO `beacon` (`id`, `uuid`, `major`, `minor`, `created_at`, `updated_at`) VALUES
(1, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '52689', '51570', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(2, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '16717', '179', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(3, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '23254', '34430', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(4, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '33078', '31465', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(5, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '58949', '29933', '0000-00-00 00:00:00', '2016-04-26 03:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `bicycle`
--

CREATE TABLE IF NOT EXISTS `bicycle` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `serial` varchar(20) NOT NULL,
  `bicycle_type_id` int(11) unsigned DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `status` int(4) unsigned NOT NULL DEFAULT '0',
  `station_id` int(11) unsigned DEFAULT NULL,
  `beacon_id` int(11) unsigned DEFAULT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bicycle_type_id` (`bicycle_type_id`),
  KEY `station_id` (`station_id`),
  KEY `beacon_id` (`beacon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bicycle_location`
--

CREATE TABLE IF NOT EXISTS `bicycle_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bicycle_id` int(11) unsigned NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bicycle_id` (`bicycle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bicycle_type`
--

CREATE TABLE IF NOT EXISTS `bicycle_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `brand` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fcm_token`
--

CREATE TABLE IF NOT EXISTS `fcm_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mac_address` varchar(32) NOT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mac_address` (`mac_address`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fcm_token`
--

INSERT INTO `fcm_token` (`id`, `mac_address`, `fcm_token`) VALUES
(1, 'f8:32:e4:5f:73:f5', 'dc86n3BhgNA:APA91bEvPWTIYfEsrslMqssHMfaYhVxzS-AZUfQVB_C-5wARMGEopGAGrygGWVyNWdqyHrRP3J1Eqi-QhzXIEoyq0ooAOD77i4DznhHs_9vOkIjrlPdfGigDzK-9unNXRmL1VeSXhx2d'),
(2, 'f8:32:e4:5f:77:4f', 'djleq6HkaI4:APA91bEo4zJcTajz6bGd408A1GiJlmqu8NLNet2LwEbiscxiB5QZQqiXbQyemJG0TImcuiwDfCHMh25pLxJrkUZxgzM6A0ZhmxJ3SqAO5ZHmiT7cC8yNjh5w39QNzyOyFAAtD6u818Dd'),
(3, 'f8:32:e4:5f:6f:35', 'f5CiuKWGqv8:APA91bHql73GfkH0U6yHeBg21EQpKH7iC3X17uoPyUhp3Wy3cAlWX7DEsKvq3njV-Z-pDvXVk0aggf9spkKodpr6NA4H-TCasmVytU_ghn54O1T0GX7UHf4YAUh1IPn3TZaGxm03i0aP');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `data` blob NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE IF NOT EXISTS `rental` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bicycle_id` int(11) unsigned NOT NULL,
  `serial` varchar(50) NOT NULL,
  `book_at` datetime NOT NULL,
  `return_at` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bicycle_id` (`bicycle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE IF NOT EXISTS `station` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `postal` varchar(10) NOT NULL,
  `latitude` double unsigned DEFAULT NULL,
  `longitude` double unsigned DEFAULT NULL,
  `beacon_id` int(11) unsigned DEFAULT NULL,
  `bicycle_count` int(11) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `beacon_id` (`beacon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profileImg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` smallint(6) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `email`, `mobile`, `profileImg`, `status`, `role`, `name`, `created_at`, `updated_at`) VALUES
(1, '1111', 'ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', '1111@gmail.com', NULL, NULL, 10, 10, 'user', 1461214049, 1461926225),
(2, '2222', 'ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', '2222@gmail.com', NULL, NULL, 10, 10, 'user', 1461214049, 1461926225),
(3, '3333', 'ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', '3333@gmail.com', NULL, NULL, 10, 10, 'user', 1461214049, 1461926225);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  KEY `usertoken_ibfk_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `user_id`, `token`, `title`, `ip_address`, `expire_date`, `created_date`, `updated_date`, `action`) VALUES
(25, 1, '5f6DYh6wbpMx2t9jR0j44lXJLKmQ0Kbk', 'ACTION_ACCESS', '116.99.174.136', '2016-09-01 15:24:56', '2016-08-02 15:24:56', '2016-08-02 15:24:56', 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bicycle`
--
ALTER TABLE `bicycle`
  ADD CONSTRAINT `bicycle_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bicycle_ibfk_2` FOREIGN KEY (`beacon_id`) REFERENCES `beacon` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bicycle_ibfk_3` FOREIGN KEY (`bicycle_type_id`) REFERENCES `bicycle_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `bicycle_location`
--
ALTER TABLE `bicycle_location`
  ADD CONSTRAINT `bicycle_location_ibfk_1` FOREIGN KEY (`bicycle_id`) REFERENCES `bicycle` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bicycle_location_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `rental_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rental_ibfk_2` FOREIGN KEY (`bicycle_id`) REFERENCES `bicycle` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `station`
--
ALTER TABLE `station`
  ADD CONSTRAINT `station_ibfk_1` FOREIGN KEY (`beacon_id`) REFERENCES `beacon` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `usertoken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
