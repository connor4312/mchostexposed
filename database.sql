-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table mche.hex_additionalnotes
CREATE TABLE IF NOT EXISTS `hex_additionalnotes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(50) NOT NULL DEFAULT '0',
  `comment` varchar(200) NOT NULL DEFAULT '0',
  `score` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table mche.hex_correctionrequests
CREATE TABLE IF NOT EXISTS `hex_correctionrequests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host_id` int(10) NOT NULL DEFAULT '0',
  `criteria_id` int(10) NOT NULL DEFAULT '0',
  `should_be` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(45) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table mche.hex_criteria
CREATE TABLE IF NOT EXISTS `hex_criteria` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `score` int(10) DEFAULT '0',
  `name` varchar(50) DEFAULT '0',
  `value` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table mche.hex_criteria_descriptions
CREATE TABLE IF NOT EXISTS `hex_criteria_descriptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `criteria_id` int(10) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table mche.hex_criteria_linkings
CREATE TABLE IF NOT EXISTS `hex_criteria_linkings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host_id` int(10) NOT NULL DEFAULT '0',
  `criteria_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table mche.hex_hosts
CREATE TABLE IF NOT EXISTS `hex_hosts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `mcf_url` varchar(100) DEFAULT NULL,
  `mcf_usernames` varchar(100) DEFAULT NULL,
  `paypal_email` varchar(100) DEFAULT NULL,
  `scored` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table mche.hex_requests
CREATE TABLE IF NOT EXISTS `hex_requests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `mcf_url` varchar(200) NOT NULL DEFAULT '0',
  `website` varchar(100) NOT NULL DEFAULT '0',
  `rep` int(1) NOT NULL DEFAULT '0',
  `ip` varchar(45) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
