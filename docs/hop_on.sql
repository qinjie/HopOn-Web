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
  `bean_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bean_id` (`bean_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `beacon`
--

INSERT INTO `beacon` (`id`, `uuid`, `major`, `minor`, `created_at`, `updated_at`, `bean_id`) VALUES
(1, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '61667', '30640', '0000-00-00 00:00:00', '2016-04-26 03:09:19', NULL),
(2, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '49256', '38045', '0000-00-00 00:00:00', '2016-04-26 03:09:19', NULL),
(3, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '6146', '27736', '0000-00-00 00:00:00', '2016-04-26 03:09:19', NULL),
(4, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '61997', '33888', '0000-00-00 00:00:00', '2016-04-26 03:09:19', NULL),

(5, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '31483', '13575', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 1),
(6, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '59687', '27425', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 2),
(7, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '37002', '8442', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 3),
(8, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '41487', '60463', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 4),
(9, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '13595', '47423', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 5),
(10, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '31483', '13575', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 6),
(11, '23A01AF0-232A-4518-9C0E-323FB773F5EF', '31483', '13575', '0000-00-00 00:00:00', '2016-04-26 03:09:19', 7);

-- (4, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '33078', '31465', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
-- (5, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '58949', '29933', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
-- (6, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '52689', '51570', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
-- (7, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '16717', '179', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
-- (8, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '23254', '34430', '0000-00-00 00:00:00', '2016-04-26 03:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `bean`
--

CREATE TABLE IF NOT EXISTS `bean` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bean`
--

INSERT INTO `bean` (`id`, `address`, `name`, `created_at`, `updated_at`) VALUES
(1, '88:C2:55:AC:35:5F', 'SG11111', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(2, '88:C2:55:AC:30:7D', 'SG11112', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(3, '98:7B:F3:75:14:EC', 'SG11113', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(4, '98:7B:F3:75:17:26', 'SG11114', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(5, '88:C2:55:AC:34:90', 'SG11115', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(6, '88:C2:55:AC:27:07', 'SG11116', '0000-00-00 00:00:00', '2016-04-26 03:09:19'),
(7, '88:C2:55:AC:28:13', 'SG11117', '0000-00-00 00:00:00', '2016-04-26 03:09:19');

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
  UNIQUE KEY `beacon_id` (`beacon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bicycle`
--

INSERT INTO `bicycle` (`id`, `serial`, `bicycle_type_id`, `desc`, `station_id`, `beacon_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 'SG11111', 1, 'Hybrid', 1, 5, 1461214049, 1461926225,0),
(6, 'SG11116', 2, 'Road', 1, 10, 1461214049, 1461926225,0),
(7, 'SG11117', 3, 'Road', 1, 11, 1461214049, 1461926225,0),

(2, 'SG11112', 1, 'Road', 2, 6, 1461214049, 1461926225,0),
(3, 'SG11113', 2, 'Road', 3, 7, 1461214049, 1461926225,0),
(4, 'SG11114', 2, 'Hybrid', 3, 8, 1461214049, 1461926225,0),
(5, 'SG11115', 3, 'Road', 5, 9, 1461214049, 1461926225,0);
-- (6, 'SG11116', 3, 'Hybrid', 5, 9, 1461214049, 1461926225,0);
-- (7, 'SG11117', 4, 'Road', 3, 3, 1461214049, 1461926225,0),
-- (8, 'SG11118', 3, 'Hybrid', 2, 3, 1461214049, 1461926225,0),
-- (9, 'SG11119', 3, 'Road', 3, 4, 1461214049, 1461926225,0),
-- (10, 'SG11121', 4, 'Hybrid', 3, 4, 1461214049, 1461926225,0),
-- (11, 'SG11122', 4, 'BMX', 3, 4, 1461214049, 1461926225,4),
-- (12, 'SG11123', 4, 'Road', 3, 4, 1461214049, 1461926225,4),
-- (13, 'SG11124', 5, 'Hybrid', 4, 5, 1461214049, 1461926225,4),
-- (14, 'SG11125', 5, 'Kids Bicycles', 4, 5, 1461214049, 1461926225,4),
-- (15, 'SG11126', 5, 'Road', 4, 5, 1461214049, 1461926225,4),
-- (16, 'SG11127', 6, 'Hybrid', 4, 5, 1461214049, 1461926225,4),
-- (17, 'SG11128', 6, 'Road', 4, 1, 1461214049, 1461926225,0),
-- (18, 'SG11129', 6, 'BMX', 4, 1, 1461214049, 1461926225,0),
-- (19, 'SG11131', 7, 'Road', 1, 1, 1461214049, 1461926225,0),
-- (20, 'SG11132', 7, 'Kids Bicycles', 1, 2, 1461214049, 1461926225,0),
-- (21, 'SG11133', 7, 'Electric', 1, 2, 1461214049, 1461926225,0),
-- (22, 'SG11134', 8, 'Kids Bicycles', 1, 2, 1461214049, 1461926225,0),
-- (23, 'SG11135', 8, 'Electric', 2, 3, 1461214049, 1461926225,0),
-- (24, 'SG11136', 8, 'Road', 2, 4, 1461214049, 1461926225,0),
-- (25, 'SG11137', 9, 'Hybrid', 2, 3, 1461214049, 1461926225,0),
-- (26, 'SG11138', 9, 'Kids Bicycles', 2, 3, 1461214049, 1461926225,0),
-- (27, 'SG11139', 9, 'Kids Bicycles', 2, 3, 1461214049, 1461926225,0),
-- (28, 'SG11141', 10, 'Kids Bicycles', 2, 3, 1461214049, 1461926225,0),
-- (29, 'SG11142', 10, 'Kids Bicycles', 2, 3, 1461214049, 1461926225,0),
-- (30, 'SG11143', 10, 'Kids Bicycles', 2, 3, 1461214049, 1461926225,0),
-- (31, 'SG11144', 10, 'Kids Bicycles', 5, 3, 1461214049, 1461926225,0),
-- (32, 'SG11145', 1, 'Kids Bicycles', 5, 5, 1461214049, 1461926225,0),
-- (33, 'SG11146', 1, 'Kids Bicycles', 5, 5, 1461214049, 1461926225,0),
-- (34, 'SG11147', 1, 'Kids Bicycles', 5, 5, 1461214049, 1461926225,0);

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
  `desc` varchar(1000) DEFAULT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bicycle_type`
--
-- Get from this: http://www.bicycle-and-bikes.com/bicycle-brands.html
INSERT INTO `bicycle_type` (`id`, `brand`, `model`, `created_at`, `updated_at`, `desc`) VALUES
(1, 'Apollo Bikes', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
(2, 'Apollo Bikes', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
(3, 'Avanti Bikes', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.');
-- (4, 'Avanti Bikes', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.');
-- (5, 'Bianchi', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (6, 'Bianchi', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (7, 'Cannondale', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (8, 'Cannondale', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (9, 'Felt', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (10, 'Felt', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.');
-- (11, 'Felt', 'BMX', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (12, 'Gary Fisher Bicycles', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (13, 'Gary Fisher Bicycles', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (14, 'Fuji', 'Kids Bicycles', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (15, 'Fuji', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (16, 'Fuji', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (17, 'Giant', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (18, 'Giant', 'BMX', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (19, 'Klein', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (20, 'Kona', 'Kids Bicycles', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (21, 'Merida Bikes', 'Electric', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (22, 'Merida Bikes', 'Kids Bicycles', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (23, 'Raleigh Bicycles', 'Electric', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (24, 'Specialized Bikes', 'Road', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (25, 'Specialized Bikes', 'Hybrid', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.'),
-- (26, 'Trek Bicycles', 'Kids Bicycles', 1461214049, 1461926225, 'Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.');

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

-- INSERT INTO `fcm_token` (`id`, `mac_address`, `fcm_token`) VALUES
-- (1, 'f8:32:e4:5f:73:f5', 'dc86n3BhgNA:APA91bEvPWTIYfEsrslMqssHMfaYhVxzS-AZUfQVB_C-5wARMGEopGAGrygGWVyNWdqyHrRP3J1Eqi-QhzXIEoyq0ooAOD77i4DznhHs_9vOkIjrlPdfGigDzK-9unNXRmL1VeSXhx2d'),
-- (2, 'f8:32:e4:5f:77:4f', 'djleq6HkaI4:APA91bEo4zJcTajz6bGd408A1GiJlmqu8NLNet2LwEbiscxiB5QZQqiXbQyemJG0TImcuiwDfCHMh25pLxJrkUZxgzM6A0ZhmxJ3SqAO5ZHmiT7cC8yNjh5w39QNzyOyFAAtD6u818Dd'),
-- (3, 'f8:32:e4:5f:6f:35', 'f5CiuKWGqv8:APA91bHql73GfkH0U6yHeBg21EQpKH7iC3X17uoPyUhp3Wy3cAlWX7DEsKvq3njV-Z-pDvXVk0aggf9spkKodpr6NA4H-TCasmVytU_ghn54O1T0GX7UHf4YAUh1IPn3TZaGxm03i0aP');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `data` blob NOT NULL,
  `bicycle_type_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `image_ibfk_1` (`bicycle_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `name`, `data`, `bicycle_type_id`, `created_at`, `updated_at`) VALUES
(1, 'bike 1', 'uploads/images/bike-1.jpg', 1, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(2, 'bike 2', 'uploads/images/bike-2.jpg', 2, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(3, 'bike 3', 'uploads/images/bike-3.jpg', 3, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (4, 'bike 1', 'uploads/images/bike-1.jpg', 4, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (5, 'bike 2', 'uploads/images/bike-2.jpg', 5, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (6, 'bike 3', 'uploads/images/bike-3.jpg', 6, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (7, 'bike 1', 'uploads/images/bike-1.jpg', 7, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (8, 'bike 2', 'uploads/images/bike-2.jpg', 8, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (9, 'bike 3', 'uploads/images/bike-3.jpg', 9, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (10, 'bike 1', 'uploads/images/bike-1.jpg', 10, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(11, 'bike 2', 'uploads/images/bike-2.jpg', 1, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(12, 'bike 3', 'uploads/images/bike-3.jpg', 2, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(13, 'bike 1', 'uploads/images/bike-1.jpg', 3, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (14, 'bike 2', 'uploads/images/bike-2.jpg', 4, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (15, 'bike 3', 'uploads/images/bike-3.jpg', 5, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (16, 'bike 1', 'uploads/images/bike-1.jpg', 6, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (17, 'bike 2', 'uploads/images/bike-2.jpg', 7, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (18, 'bike 3', 'uploads/images/bike-3.jpg', 8, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (19, 'bike 1', 'uploads/images/bike-1.jpg', 9, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (20, 'bike 2', 'uploads/images/bike-2.jpg', 10, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(21, 'bike 2', 'uploads/images/bike-2.jpg', 1, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(22, 'bike 3', 'uploads/images/bike-3.jpg', 2, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
(23, 'bike 1', 'uploads/images/bike-1.jpg', 3, '2016-08-02 15:24:56', '2016-08-02 15:24:56');
-- (24, 'bike 2', 'uploads/images/bike-2.jpg', 4, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (25, 'bike 3', 'uploads/images/bike-3.jpg', 5, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (26, 'bike 1', 'uploads/images/bike-1.jpg', 6, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (27, 'bike 2', 'uploads/images/bike-2.jpg', 7, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (28, 'bike 3', 'uploads/images/bike-3.jpg', 8, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (29, 'bike 1', 'uploads/images/bike-1.jpg', 9, '2016-08-02 15:24:56', '2016-08-02 15:24:56'),
-- (30, 'bike 2', 'uploads/images/bike-2.jpg', 10, '2016-08-02 15:24:56', '2016-08-02 15:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE IF NOT EXISTS `rental` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bicycle_id` int(11) unsigned NOT NULL,
  `serial` varchar(50) NOT NULL,
  `book_at` datetime NOT NULL,
  `pickup_at` datetime DEFAULT NULL,
  `return_at` datetime DEFAULT NULL,
  `return_station_id` int(11) unsigned DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_id` (`booking_id`),
  KEY `user_id` (`user_id`),
  KEY `bicycle_id` (`bicycle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rental`
--

INSERT INTO `rental` (`id`, `booking_id`, `user_id`, `bicycle_id`, `serial`, `book_at`, `return_at`, `duration`, `created_at`, `updated_at`, `pickup_at`, `return_station_id`) VALUES
(1, 'A1234B1111C', 1, 1, 'RENT111', '2016-08-01 15:00:00', '2016-08-01 16:30:00', 90, 1461214049, 1461926225,'2016-08-01 15:05:00',5),
(2, 'A1234B2222C', 2, 2, 'RENT112', '2016-08-01 14:00:00', '2016-08-01 14:30:00', 30, 1461214049, 1461926225,'2016-08-01 14:05:00',5),
(3, 'A1234B3333C', 3, 3, 'RENT113', '2016-08-01 12:00:00', '2016-08-01 13:00:00', 60, 1461214049, 1461926225,'2016-08-01 12:05:00',5),
(4, 'A1234B4444C', 1, 4, 'RENT114', '2016-08-02 10:00:00', '2016-08-01 10:30:00', 30, 1461214049, 1461926225,'2016-08-02 10:05:00',5),
(5, 'A1234B5555C', 2, 5, 'RENT115', '2016-08-02 14:00:00', '2016-08-01 14:30:00', 30, 1461214049, 1461926225,'2016-08-02 14:05:00',5);
-- (6, 3, 6, 'RENT116', '2016-08-02 12:00:00', '2016-08-01 12:30:00', 30, 1461214049, 1461926225,'2016-08-02 12:05:00',5);
-- (7, 1, 11, 'RENT121', '2016-08-11 15:00:00', NULL, 90, 1461214049, 1461926225,NULL,5),
-- (8, 2, 12, 'RENT122', '2016-08-11 14:00:00', NULL, 30, 1461214049, 1461926225,NULL,5),
-- (9, 3, 13, 'RENT123', '2016-08-11 12:00:00', NULL, 60, 1461214049, 1461926225,NULL,5),
-- (10, 1, 14, 'RENT124', '2016-08-12 10:00:00', NULL, 30, 1461214049, 1461926225,NULL,5),
-- (11, 2, 15, 'RENT125', '2016-08-12 14:00:00', NULL, NULL, 1461214049, 1461926225,NULL,NULL),
-- (12, 3, 16, 'RENT126', '2016-08-12 12:00:00', NULL, NULL, 1461214049, 1461926225,NULL,NULL);

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

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`id`, `name`, `address`, `latitude`, `longitude`, `postal`, `beacon_id`, `bicycle_count`, `created_at`, `updated_at`) VALUES
(1, 'Ang Mo Kio', 'Ang Mo Kio MRT', 1.370015, 103.849446, '', 1, 10, 1461214049, 1461926225),
(2, 'Mayflower', '253 Ang Mo Kio Street 21', 1.369732, 103.835231, '560253', 2, 20, 1461214049, 1461926225),
(3, 'Yio Chu Kang', '3000 Ang Mo Kio Avenue 8', 1.381841, 103.844959, '569813', 3, 10, 1461214049, 1461926225),
-- (4, 'Ang Mo Kio Garden', 'Opposite Ang Mo Kio Town Library, Ang Mo Kio Avenue 6', 1.374542, 103.843353, '567740', 4, 25, 1461214049, 1461926225),
(5, 'NP Main Gate', '535 Clementi Road', 1.334284, 103.776649, '234235', 4, 10, 1461214049, 1461926225);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` smallint(6) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `auth_key`, `password_hash`, `email`, `mobile`, `status`, `role`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ADRIAN YOO', 'X_k7Zgze', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', '1@mail.com', '1111', 10, 10, 'user', 1461214049, 1461926225),
(2, 'MICHAEL YOO', 'X_k7Zgzd', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', '2@mail.com', '2222', 10, 10, 'user', 1461214049, 1461926225),
(3, 'ANTHONY CHEN', 'X_k7Zgzc', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', '3@mail.com', '3333', 10, 10, 'user', 1461214049, 1461926225),
(4, 'DUCDD', 'X_k7Zgzb', '$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa', 'congaductq@gmail.com', 'dddd', 10, 10, 'user', 1461214049, 1461926225),
(5, 'ECE IoT', 'X_k7Zgza', '$2y$13$3eQNXkrRhnTpJnyht6fOUO6k8oAK7OBNrTtBRSnCHst5f7OcV2Flu', 'eceiot@gmail.com', '12345678', 10, 10, 'user', 1461214049, 1461926225);

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

-- INSERT INTO `user_token` (`id`, `user_id`, `token`, `title`, `ip_address`, `expire_date`, `created_date`, `updated_date`, `action`) VALUES
-- (25, 1, '5f6DYh6wbpMx2t9jR0j44lXJLKmQ0Kbk', 'ACTION_ACCESS', '116.99.174.136', '2016-09-01 15:24:56', '2016-08-02 15:24:56', '2016-08-02 15:24:56', 4);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rental_id` int(11) unsigned NOT NULL,
  `issue` varchar(100) DEFAULT 0,
  `comment` varchar(1000) DEFAULT NULL,
  `rating` double NOT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rental_id` (`rental_id`),
  KEY `feedback_ibfk_1` (`rental_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `feedback`
--

-- INSERT INTO `feedback` (`id`, `rental_id`, `issue`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
-- (1, 1, '[0,1]', 'Comment 1', 0, 1461214049, 1461926225),
-- (2, 2, '[1,2]', 'Comment 2', 1, 1461214049, 1461926225),
-- (3, 3, '[2,3]', 'Comment 3', 2, 1461214049, 1461926225),
-- (4, 4, '[3,4]', 'Comment 4', 3, 1461214049, 1461926225),
-- (5, 5, '[4,5]', 'Comment 5', 4, 1461214049, 1461926225),
-- (6, 6, '[5,0]', 'Comment 6', 5, 1461214049, 1461926225);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bicycle`
--
ALTER TABLE `beacon`
  ADD CONSTRAINT `beacon_ibfk_2` FOREIGN KEY (`bean_id`) REFERENCES `bean` (`id`) ON UPDATE CASCADE;

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

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rental` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`bicycle_type_id`) REFERENCES `bicycle_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
