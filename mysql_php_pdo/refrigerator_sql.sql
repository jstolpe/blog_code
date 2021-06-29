-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2021 at 05:00 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `refrigerator`
--

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

DROP TABLE IF EXISTS `drinks`;
CREATE TABLE IF NOT EXISTS `drinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `flavor` varchar(100) NOT NULL,
  `sugar_free` tinyint(1) NOT NULL,
  `size` varchar(100) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`id`, `name`, `type`, `flavor`, `sugar_free`, `size`, `expiration_date`) VALUES
(1, 'Red Bull - Sugar Free', 'Red Bull', 'Regular', 1, '8oz', '2021-12-01'),
(2, 'Red Bull - Sugar Free', 'Red Bull', 'Regular', 1, '8oz', '2021-12-01'),
(3, 'Red Bull', 'Red Bull', 'Regular', 0, '8oz', '2021-12-01'),
(4, 'Red Bull', 'Red Bull', 'Regular', 0, '8oz', '2021-12-01'),
(5, 'Red Bull - Sugar Free', 'Red Bull', 'Regular', 1, '12oz', '2021-10-01'),
(6, 'Red Bull', 'Red Bull', 'Regular', 0, '12oz', '2021-10-01'),
(7, 'Red Bull', 'Red Bull', 'Regular', 0, '12oz', '2021-10-01'),
(8, 'Red Bull - Tropical', 'Red Bull', 'Tropical', 0, '12oz', '2021-11-01'),
(9, 'Red Bull - Tropical', 'Red Bull', 'Tropical', 0, '12oz', '2021-11-01'),
(10, 'Red Bull - Tropical', 'Red Bull', 'Tropical', 0, '12oz', '2021-11-01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
