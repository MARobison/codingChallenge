-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for paylocity
CREATE DATABASE IF NOT EXISTS `paylocity` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `paylocity`;

-- Dumping structure for table paylocity.dependents
CREATE TABLE IF NOT EXISTS `dependents` (
  `companyId` int(10) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `age` int(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table paylocity.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `employerId` int(10) NOT NULL DEFAULT '123456',
  `companyId` int(10) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `paycheck` decimal(10,0) DEFAULT '51000',
  `dependents` varchar(250) DEFAULT NULL,
  `salary` decimal(10,0) DEFAULT '52000',
  `benefitsCosts` decimal(10,0) DEFAULT '1000',
  `status` enum('ACTIVE','NON_ACTIVE') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
