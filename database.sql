-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 21, 2019 at 03:46 AM
-- Server version: 10.3.12-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oki`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `auth`;
CREATE TABLE IF NOT EXISTS `auth` (
  `api_key_id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key_code` varchar(40) NOT NULL,
  `created_by` int(11) DEFAULT 1,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`api_key_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`api_key_id`, `api_key_code`, `created_by`, `created_date`) VALUES
(1, '3cc5958f03c5d23ede1bb3b34afe2c9e', NULL, '2019-04-24 00:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `long_map` varchar(20) NOT NULL,
  `lat_map` varchar(20) NOT NULL,
  `speed_vehicle` int(11) NOT NULL,
  `zoom_map` tinyint(2) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `long_map`, `lat_map`, `speed_vehicle`, `zoom_map`, `created_date`) VALUES
(25, '106.9149435', '-6.126287', 20, 20, '2019-06-21 03:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `distance`
--

DROP TABLE IF EXISTS `distance`;
CREATE TABLE IF NOT EXISTS `distance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_distance` varchar(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `distance`
--

INSERT INTO `distance` (`id`, `total_distance`, `created_date`) VALUES
(14, '1.37', '2019-06-21 03:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_username` varchar(20) NOT NULL,
  `login_password` varchar(60) NOT NULL,
  `login_email` varchar(20) NOT NULL,
  `login_name` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `login_username`, `login_password`, `login_email`, `login_name`, `created_by`, `created_date`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'administrator2', 1, '2019-04-24 16:11:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
