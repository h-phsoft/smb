-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2022 at 04:42 PM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phs_smb_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_status`
--

DROP TABLE IF EXISTS `phs_cod_status`;
CREATE TABLE IF NOT EXISTS `phs_cod_status` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_status`
--

INSERT INTO `phs_cod_status` (`id`, `name`, `rem`) VALUES
(1, 'Active', NULL),
(2, 'Disabled', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cpy`
--

DROP TABLE IF EXISTS `phs_cpy`;
CREATE TABLE IF NOT EXISTS `phs_cpy` (
  `id` smallint(6) NOT NULL COMMENT 'PK',
  `cust_id` smallint(6) NOT NULL COMMENT 'Customer',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `ord` int(11) NOT NULL COMMENT 'Order',
  `gid` varchar(50) NOT NULL COMMENT 'Global Unique Id',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `url` varchar(50) NOT NULL COMMENT 'URL',
  `users` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Number of Users, 0 Open Users',
  `devices` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Number of Devices, 0 Open Devices',
  `restriction` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Restrict Copy Only in Declared Devices',
  `dbname` varchar(50) NOT NULL COMMENT 'Database Name',
  `sdate` date DEFAULT NULL COMMENT 'Start Date',
  `edate` date DEFAULT NULL COMMENT 'End Date',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `gid` (`gid`),
  KEY `cust_id` (`cust_id`),
  KEY `phs_cpy_ibfk_2` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cpy`
--

INSERT INTO `phs_cpy` (`id`, `cust_id`, `status_id`, `ord`, `gid`, `name`, `url`, `users`, `devices`, `restriction`, `dbname`, `sdate`, `edate`, `rem`) VALUES
(0, 0, 1, 0, 'a27b9b6d6df266d8545d4f79493c6671', 'Demo', 'demo', 0, 0, 0, 'phs_smb_demo', '2022-01-01', '2022-12-31', NULL),
(1010, 1010, 1, 0, '522022864f0a7283fc7080939aef99d0', 'NSCC', 'nscc', 0, 0, 0, 'phs_smb_nscc', '2022-01-01', '2022-12-31', NULL),
(2010, 2010, 1, 0, '50730a9d2df45a87764f460431861ade', 'iCloud', 'icloud', 0, 0, 0, 'phs_smb_icloud', '2022-01-01', '2022-12-31', NULL),
(2030, 2030, 1, 0, '85ac302fbb35afa93d976ce81e7b87e2', 'Sweet Garden', 'sg', 0, 0, 0, 'phs_smb_sg', '2022-01-01', '2022-12-31', NULL),
(7203, 7203, 1, 0, 'a27b9b6d6df266d8545d4f79493c6673', 'Sparkle Clinic', 'sparkle', 0, 0, 0, 'phs_smb_sparkle', '2022-04-27', '2022-12-31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cust`
--

DROP TABLE IF EXISTS `phs_cust`;
CREATE TABLE IF NOT EXISTS `phs_cust` (
  `id` smallint(6) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `date` date NOT NULL COMMENT 'Date',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `phs_cust_ibfk_1` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cust`
--

INSERT INTO `phs_cust` (`id`, `name`, `status_id`, `ord`, `date`, `rem`) VALUES
(0, 'Default', 1, 0, '2021-01-01', NULL),
(1010, 'NSCC', 1, 0, '2021-01-01', NULL),
(2010, 'iCloud', 1, 0, '2022-01-01', NULL),
(2020, 'Damascus Electricity', 1, 0, '1994-01-01', NULL),
(2030, 'Sweet Garden', 1, 0, '2021-01-01', NULL),
(7201, 'Rasco', 1, 0, '2021-01-01', NULL),
(7202, 'Jasmine', 1, 0, '2021-01-01', NULL),
(7203, 'Sparkle', 1, 0, '2022-05-01', NULL),
(7700, 'IPU', 1, 0, '2021-01-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_lang`
--

DROP TABLE IF EXISTS `phs_lang`;
CREATE TABLE IF NOT EXISTS `phs_lang` (
  `id` int(11) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `code` varchar(10) NOT NULL COMMENT 'Language Code',
  `dir` varchar(10) NOT NULL DEFAULT 'ltr' COMMENT 'Direction',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_lang`
--

INSERT INTO `phs_lang` (`id`, `name`, `code`, `dir`, `rem`) VALUES
(1, 'Arabic', 'ar', 'rtl', NULL),
(2, 'English', 'en', 'ltr', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_pref`
--

DROP TABLE IF EXISTS `phs_pref`;
CREATE TABLE IF NOT EXISTS `phs_pref` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `key` varchar(50) NOT NULL COMMENT 'Key',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `value` varchar(100) NOT NULL COMMENT 'Value',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_pref`
--

INSERT INTO `phs_pref` (`id`, `key`, `name`, `value`, `rem`) VALUES
(1, 'Def_Direction', 'Default GUI Direction, LTR, RTL', 'RTL', NULL),
(2, 'Def_Language', 'Default GUI Language, ar, en ...', 'ar', NULL),
(3, 'Def_Theme', 'Default GUI Theme light, dark', 'dark', NULL),
(4, 'Def_GUI_ASide', 'Display aside', 'true', NULL),
(5, 'Def_GUI_ASide_Min', 'is ASide Minimized', 'true', NULL),
(6, 'Def_GUI_TOP_Menu', 'Display Top Menu', 'true', NULL),
(7, 'Def_GUI_TOP_Btns', 'Display Top Buttons', 'true', NULL),
(8, 'Def_Workperiod', 'Default Work Period', '0', NULL),
(9, 'IsWorkperiod', 'Is Copy have Work Period', 'true', NULL),
(10, 'Def_Inv_Barcode', 'Default Inventory Barcode', 'true', NULL),
(11, 'Def_Inv_Model', 'Default Inventory Model', 'true', NULL),
(12, 'Def_Inv_Color', 'Default Inventory Color', 'true', NULL),
(13, 'Def_Inv_Size', 'Default Inventory Size', 'true', NULL),
(14, 'Def_Inv_Lot', 'Default Inventory Lot', 'true', NULL),
(15, 'Def_Inv_Start', 'Default Inventory Start', 'true', NULL),
(16, 'Def_Inv_End', 'Default Inventory End', 'true', NULL),
(17, 'Def_Inv_Length', 'Default Inventory Length', 'true', NULL),
(18, 'Def_Inv_Width', 'Default Inventory Width', 'true', NULL),
(19, 'Def_Inv_Height', 'Default Inventory Height', 'true', NULL),
(20, 'Def_GUI_ASide_Hidden', 'is ASide Hidden when minimized', 'true', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `phs_cpy`
--
ALTER TABLE `phs_cpy`
  ADD CONSTRAINT `phs_cpy_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `phs_cust` (`id`),
  ADD CONSTRAINT `phs_cpy_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`);

--
-- Constraints for table `phs_cust`
--
ALTER TABLE `phs_cust`
  ADD CONSTRAINT `phs_cust_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
