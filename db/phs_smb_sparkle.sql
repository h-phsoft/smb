-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2022 at 11:50 AM
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
-- Database: `phs_smb_sparkle`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `initcap`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `initcap` (`input` VARCHAR(255)) RETURNS VARCHAR(255) CHARSET utf8 BEGIN
	DECLARE len INT;
	DECLARE i INT;

	SET len   = CHAR_LENGTH(input);
	SET input = LOWER(input);
	SET i = 0;

	WHILE (i < len) DO
		IF (MID(input,i,1) = ' ' OR i = 0) THEN
			IF (i < len) THEN
				SET input = CONCAT(
					LEFT(input,i),
					UPPER(MID(input,i + 1,1)),
					RIGHT(input,len - i - 1)
				);
			END IF;
		END IF;
		SET i = i + 1;
	END WHILE;

	RETURN input;
    END$$

DROP FUNCTION IF EXISTS `nextval`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `nextval` (`seq_name` VARCHAR(100)) RETURNS BIGINT(20) BEGIN
  DECLARE cur_val bigint;

  SELECT cur_value INTO cur_val FROM phs_sequence WHERE name = seq_name;
  IF cur_val IS NULL THEN
    SET cur_val = 1;
    INSERT INTO phs_sequence (name, cur_value) VALUES (seq_name, cur_val);
  ELSE
    UPDATE phs_sequence SET
        cur_value = IF (((cur_value + increment) > max_value OR (cur_value + increment) < min_value),
            IF (cycle = TRUE, IF ((cur_value + increment) > max_value, min_value,  max_value), NULL),
            cur_value + increment
        )
    WHERE name = seq_name;
  END IF; 
  RETURN cur_val;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `acc_acc`
--

DROP TABLE IF EXISTS `acc_acc`;
CREATE TABLE IF NOT EXISTS `acc_acc` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `pid` int(11) DEFAULT '-1' COMMENT 'Parent',
  `num` varchar(15) NOT NULL COMMENT 'Number',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `type_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Type',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `dbcr_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Debit Credit Type',
  `close_id` smallint(6) NOT NULL COMMENT 'Closing Account',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`num`),
  KEY `dbcr_id` (`dbcr_id`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `close_id` (`close_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_acc`
--

INSERT INTO `acc_acc` (`id`, `pid`, `num`, `name`, `type_id`, `status_id`, `dbcr_id`, `close_id`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, -1, '0', 'افتراضي', 2, 1, 1, 1, '', -9, '2022-02-03 10:16:16', 0, '2022-05-07 14:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `acc_budmst`
--

DROP TABLE IF EXISTS `acc_budmst`;
CREATE TABLE IF NOT EXISTS `acc_budmst` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `num` int(11) NOT NULL COMMENT 'Number',
  `date` date NOT NULL COMMENT 'Date',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`num`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acc_budtrn`
--

DROP TABLE IF EXISTS `acc_budtrn`;
CREATE TABLE IF NOT EXISTS `acc_budtrn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mst_id` int(11) NOT NULL COMMENT 'Master',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `acc_id` int(11) NOT NULL COMMENT 'Account',
  `cost_id` int(11) NOT NULL COMMENT 'Cost Center',
  `budget` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Budget',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`mst_id`),
  KEY `acc_id` (`acc_id`),
  KEY `cost_id` (`cost_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acc_close`
--

DROP TABLE IF EXISTS `acc_close`;
CREATE TABLE IF NOT EXISTS `acc_close` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_close`
--

INSERT INTO `acc_close` (`id`, `ord`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 1, 'Trade', NULL, -9, '2022-02-03 10:16:17', -9, '2022-02-03 10:16:17'),
(2, 2, 'P & L', NULL, -9, '2022-02-03 10:16:17', -9, '2022-02-03 10:16:17'),
(3, 3, 'Balance Sheet', NULL, -9, '2022-02-03 10:16:17', -9, '2022-02-03 10:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `acc_cost`
--

DROP TABLE IF EXISTS `acc_cost`;
CREATE TABLE IF NOT EXISTS `acc_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `pid` int(11) DEFAULT '-1' COMMENT 'Parent',
  `num` varchar(15) NOT NULL COMMENT 'Number',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `type_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Type',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`num`),
  KEY `status_id` (`status_id`),
  KEY `type_id` (`type_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_cost`
--

INSERT INTO `acc_cost` (`id`, `pid`, `num`, `name`, `type_id`, `status_id`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, -1, '0', 'افتراضي', 2, 1, '', -9, '2022-02-03 10:16:17', 0, '2022-05-07 14:50:45'),
(2, -1, '11', '11', 2, 1, '', 0, '2022-05-07 14:53:04', -9, '2022-05-07 14:53:04'),
(3, -1, '22', '22', 2, 1, '', 0, '2022-05-07 14:53:10', -9, '2022-05-07 14:53:10'),
(5, -1, '55', '55', 2, 1, '', 0, '2022-05-07 14:54:42', 0, '2022-05-07 14:56:17'),
(6, -1, '44', '44', 2, 1, '', 0, '2022-05-07 14:55:03', -9, '2022-05-07 14:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `acc_mst`
--

DROP TABLE IF EXISTS `acc_mst`;
CREATE TABLE IF NOT EXISTS `acc_mst` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `wper_id` smallint(6) NOT NULL COMMENT 'Workperiod',
  `src_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Source',
  `num` int(11) NOT NULL COMMENT 'Number',
  `pnum` int(11) DEFAULT '0' COMMENT 'Print Number',
  `date` date NOT NULL COMMENT 'Date',
  `rem` varchar(512) DEFAULT NULL COMMENT 'Remarks',
  `trem` varchar(200) DEFAULT NULL,
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `src_id` (`src_id`),
  KEY `wper_id` (`wper_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_mst`
--

INSERT INTO `acc_mst` (`id`, `wper_id`, `src_id`, `num`, `pnum`, `date`, `rem`, `trem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 0, 0, 0, 0, '2022-05-07', '', NULL, 0, '2022-05-07 13:45:23', 0, '2022-05-07 13:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `acc_trn`
--

DROP TABLE IF EXISTS `acc_trn`;
CREATE TABLE IF NOT EXISTS `acc_trn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mst_id` int(11) NOT NULL COMMENT 'Master',
  `acc_id` int(11) NOT NULL COMMENT 'Account',
  `cost_id` int(11) NOT NULL COMMENT 'Cost Center',
  `acc_rid` int(11) DEFAULT NULL COMMENT 'Related Account',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `deb` decimal(17,3) NOT NULL DEFAULT '0.000' COMMENT 'Debit',
  `crd` decimal(17,3) NOT NULL DEFAULT '0.000' COMMENT 'Credit',
  `curn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Currency',
  `rate` decimal(15,7) NOT NULL DEFAULT '1.0000000' COMMENT 'Rate',
  `debc` decimal(17,3) NOT NULL DEFAULT '0.000' COMMENT 'Foreign Debit',
  `crdc` decimal(17,3) NOT NULL DEFAULT '0.000' COMMENT 'Foreign Credit',
  `bcurn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Base Currency',
  `brate` decimal(15,7) NOT NULL DEFAULT '1.0000000' COMMENT 'Base Rate',
  `debb` decimal(17,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Debit',
  `crdb` decimal(17,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Credit',
  `rid` int(11) DEFAULT NULL COMMENT 'Related Id',
  `srem` varchar(256) DEFAULT NULL COMMENT 'System Remarks',
  `rem` varchar(256) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`mst_id`),
  KEY `acc_id` (`acc_id`),
  KEY `acc_rid` (`acc_rid`),
  KEY `bcurn_id` (`bcurn_id`),
  KEY `cost_id` (`cost_id`),
  KEY `curn_id` (`curn_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_trn`
--

INSERT INTO `acc_trn` (`id`, `mst_id`, `acc_id`, `cost_id`, `acc_rid`, `ord`, `deb`, `crd`, `curn_id`, `rate`, `debc`, `crdc`, `bcurn_id`, `brate`, `debb`, `crdb`, `rid`, `srem`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(5, 1, 0, 3, 0, 0, '100.000', '0.000', 1, '1.0000000', '100.000', '0.000', 1, '1.0000000', '0.000', '0.000', 0, '', '', 0, '2022-05-07 14:58:06', 0, '2022-05-07 14:58:40'),
(6, 1, 0, 2, 0, 0, '0.000', '100.000', 1, '1.0000000', '0.000', '100.000', 1, '1.0000000', '0.000', '0.000', 0, '', '', 0, '2022-05-07 14:58:06', 0, '2022-05-07 14:58:40');

-- --------------------------------------------------------

--
-- Stand-in structure for view `acc_vacc`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `acc_vacc`;
CREATE TABLE IF NOT EXISTS `acc_vacc` (
`id` int(11)
,`pid` int(11)
,`num` varchar(15)
,`name` varchar(100)
,`type_id` tinyint(4)
,`type_name` varchar(100)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`dbcr_id` tinyint(4)
,`dbcr_name` varchar(100)
,`close_id` smallint(6)
,`close_name` varchar(100)
,`rem` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `acc_vbudget`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `acc_vbudget`;
CREATE TABLE IF NOT EXISTS `acc_vbudget` (
`mst_id` int(11)
,`mst_num` int(11)
,`mst_name` varchar(100)
,`mst_date` date
,`mst_rem` varchar(100)
,`trn_id` int(11)
,`acc_id` int(11)
,`acc_num` varchar(15)
,`acc_name` varchar(100)
,`cost_id` int(11)
,`cost_num` varchar(15)
,`cost_name` varchar(100)
,`trn_ord` smallint(6)
,`trn_budget` decimal(10,3)
,`trn_rem` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `acc_vcost`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `acc_vcost`;
CREATE TABLE IF NOT EXISTS `acc_vcost` (
`id` int(11)
,`pid` int(11)
,`num` varchar(15)
,`name` varchar(100)
,`type_id` tinyint(4)
,`type_name` varchar(100)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`rem` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `acc_vtrn`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `acc_vtrn`;
CREATE TABLE IF NOT EXISTS `acc_vtrn` (
`mst_id` int(11)
,`wper_id` smallint(6)
,`wper_ord` tinyint(4)
,`wper_name` varchar(100)
,`wper_sdate` date
,`wper_edate` date
,`mst_src_id` smallint(6)
,`mst_num` int(11)
,`mst_pnum` int(11)
,`mst_date` date
,`mst_rem` varchar(512)
,`trn_id` int(11)
,`acc_id` int(11)
,`acc_num` varchar(15)
,`dbcr_id` tinyint(4)
,`status_id` tinyint(4)
,`close_id` smallint(6)
,`acc_name` varchar(100)
,`cost_id` int(11)
,`cost_num` varchar(15)
,`cost_name` varchar(100)
,`acc_rid` int(11)
,`trn_ord` smallint(6)
,`trn_deb` decimal(17,3)
,`trn_crd` decimal(17,3)
,`curn_id` int(11)
,`curn_code` varchar(10)
,`curn_name` varchar(100)
,`curn_color` varchar(25)
,`curn_rate` decimal(15,7)
,`trn_debc` decimal(17,3)
,`trn_crdc` decimal(17,3)
,`bcurn_id` int(11)
,`bcurn_code` varchar(10)
,`bcurn_name` varchar(100)
,`bcurn_color` varchar(25)
,`bcurn_rate` decimal(15,7)
,`trn_debb` decimal(17,3)
,`trn_crdb` decimal(17,3)
,`trn_rid` int(11)
,`trn_srem` varchar(256)
,`trn_rem` varchar(256)
);

-- --------------------------------------------------------

--
-- Table structure for table `clnc_appointment`
--

DROP TABLE IF EXISTS `clnc_appointment`;
CREATE TABLE IF NOT EXISTS `clnc_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `type_id` int(11) NOT NULL COMMENT 'Type',
  `doctor_id` int(11) NOT NULL COMMENT 'Doctor',
  `special_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Speciality',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `date` date NOT NULL COMMENT 'Date',
  `hour` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Appointment Hour',
  `minute` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Appointment Minute',
  `minutes` int(11) NOT NULL DEFAULT '15' COMMENT 'Appointment Minutes',
  `status_id` tinyint(4) NOT NULL DEFAULT '10' COMMENT 'Status',
  `amt` decimal(10,0) NOT NULL DEFAULT '0' COMMENT 'Payment Amount',
  `description` varchar(512) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_id_2` (`doctor_id`,`date`,`hour`,`minute`),
  KEY `clinic_id` (`clinic_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  KEY `status_id` (`status_id`),
  KEY `type_id` (`type_id`),
  KEY `special_id` (`special_id`),
  KEY `date` (`date`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_appointment`
--

INSERT INTO `clnc_appointment` (`id`, `clinic_id`, `type_id`, `doctor_id`, `special_id`, `patient_id`, `date`, `hour`, `minute`, `minutes`, `status_id`, `amt`, `description`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(2, 1, 2, 1, 1, 2, '2022-05-08', 10, 0, 15, 10, '0', NULL, -9, '2022-05-07 17:24:02', -9, '2022-05-08 08:09:35'),
(3, 1, 4, 1, 1, 2, '2022-05-08', 8, 0, 15, 10, '0', '', 0, '2022-05-07 18:27:51', -9, '2022-05-08 08:09:39'),
(5, 1, 6, 1, 1, 3, '2022-05-08', 14, 0, 15, 10, '0', '', 0, '2022-05-07 18:28:43', -9, '2022-05-08 18:38:34'),
(7, 1, 1, 1, 0, 2, '2022-05-08', 8, 30, 15, 10, '0', '', 0, '2022-05-08 08:20:45', -9, '2022-05-08 08:20:45'),
(9, 1, 1, 1, 0, 3, '2022-05-08', 8, 15, 15, 10, '0', '', 0, '2022-05-08 08:21:40', -9, '2022-05-08 18:38:37'),
(10, 1, 1, 1, 0, 2, '2022-05-08', 12, 0, 15, 10, '0', '', 0, '2022-05-08 16:40:39', -9, '2022-05-08 16:40:39'),
(11, 1, 1, 1, 0, 3, '2022-05-08', 13, 0, 15, 10, '0', '', 0, '2022-05-08 16:40:58', -9, '2022-05-08 18:38:30'),
(15, 1, 1, 1, 0, 2, '2022-05-08', 19, 0, 15, 10, '0', '', 0, '2022-05-08 16:56:23', -9, '2022-05-08 16:56:23'),
(16, 1, 1, 1, 0, 3, '2022-05-08', 18, 0, 15, 10, '0', '', 0, '2022-05-08 16:58:49', -9, '2022-05-08 18:38:28'),
(17, 1, 1, 1, 0, 2, '2022-05-08', 15, 0, 15, 10, '0', '', 0, '2022-05-08 17:00:01', -9, '2022-05-08 17:00:01'),
(18, 1, 1, 1, 0, 3, '2022-05-08', 17, 0, 15, 10, '0', '', 0, '2022-05-08 17:06:17', -9, '2022-05-08 18:38:24'),
(20, 1, 1, 2, 0, 4, '2022-05-08', 8, 0, 15, 10, '0', '999', 0, '2022-05-08 19:13:55', -9, '2022-05-08 19:13:55'),
(23, 1, 1, 3, 0, 7, '2022-05-08', 8, 0, 15, 10, '0', '', 0, '2022-05-08 19:34:44', -9, '2022-05-08 19:34:44'),
(24, 1, 1, 3, 1, 9, '2022-05-09', 8, 0, 15, 10, '0', '33', 0, '2022-05-09 14:47:46', -9, '2022-05-09 14:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_app_change`
--

DROP TABLE IF EXISTS `clnc_app_change`;
CREATE TABLE IF NOT EXISTS `clnc_app_change` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `app_id` int(11) NOT NULL COMMENT 'Appointment',
  `status_id` tinyint(4) NOT NULL COMMENT 'Status',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'DateTime',
  `reason` varchar(256) NOT NULL COMMENT 'Reason',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`),
  KEY `status_id` (`status_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_app_procedures`
--

DROP TABLE IF EXISTS `clnc_app_procedures`;
CREATE TABLE IF NOT EXISTS `clnc_app_procedures` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `app_id` int(11) NOT NULL COMMENT 'Appointment',
  `procedure_id` int(11) NOT NULL COMMENT 'Procedure',
  `qnt` decimal(10,3) NOT NULL DEFAULT '1.000' COMMENT 'Quantity',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `discount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Discount',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `description` varchar(256) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`),
  KEY `procedure_id` (`procedure_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_app_type`
--

DROP TABLE IF EXISTS `clnc_app_type`;
CREATE TABLE IF NOT EXISTS `clnc_app_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `capacity` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Capacity',
  `time` tinyint(4) NOT NULL DEFAULT '15' COMMENT 'Appointment Time',
  `tbg_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Title Background Color',
  `tfg_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Title Text Color',
  `nfg_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Patient Name Text Color',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `clnc_app_type_ibfk_1` (`tbg_id`),
  KEY `nfg_id` (`nfg_id`),
  KEY `clnc_app_type_ibfk_3` (`tfg_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_app_type`
--

INSERT INTO `clnc_app_type` (`id`, `name`, `capacity`, `time`, `tbg_id`, `tfg_id`, `nfg_id`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 'Consultation', 0, 15, 4, 3, 4, -9, '2021-04-03 15:06:05', -9, '2022-04-24 15:38:56'),
(2, 'Cementation Full case', 0, 60, 1, 3, 6, -9, '2021-04-03 15:06:05', -9, '2022-04-24 15:38:56'),
(3, 'Impression Full Case', 0, 60, 8, 1, 7, -9, '2021-04-03 15:06:05', -9, '2022-04-24 15:38:56'),
(4, 'Scaling Cleaning Polishing', 0, 30, 6, 3, 6, -9, '2021-04-03 15:06:05', -9, '2022-04-24 15:38:56'),
(5, 'Whitening', 0, 60, 10, 0, 9, -9, '2021-04-07 05:41:05', -9, '2022-04-24 15:38:56'),
(6, 'Treatments', 0, 30, 5, 0, 0, -9, '2021-04-07 05:44:50', -9, '2022-04-24 15:38:56'),
(7, 'Implant', 0, 15, 9, 0, 0, -9, '2021-04-07 05:45:47', -9, '2022-04-24 15:38:56'),
(8, 'Units Cementation', 0, 15, 3, 9, 7, -9, '2021-12-27 04:47:59', -9, '2022-04-24 15:38:56'),
(9, 'Units Impression', 0, 15, 1, 7, 8, -9, '2021-12-27 04:49:13', -9, '2022-04-24 15:38:56'),
(10, 'Follow up visit', 0, 15, 6, 7, 1, -9, '2021-12-27 04:53:04', -9, '2022-04-24 15:38:56'),
(11, 'Veneer Removal Full Case', 0, 60, 7, 0, 0, -9, '2022-01-10 02:14:00', -9, '2022-04-24 15:38:56'),
(12, 'Composite Removal Full Case', 0, 60, 8, 0, 0, -9, '2022-01-10 02:14:28', -9, '2022-04-24 15:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_clinic`
--

DROP TABLE IF EXISTS `clnc_clinic`;
CREATE TABLE IF NOT EXISTS `clnc_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `prefix` varchar(5) NOT NULL,
  `email` varchar(75) DEFAULT NULL COMMENT 'Email',
  `phone1` varchar(30) DEFAULT NULL COMMENT 'Phone 1',
  `phone2` varchar(30) DEFAULT NULL COMMENT 'Phone 2',
  `phone3` varchar(30) DEFAULT NULL COMMENT 'Phone 3',
  `address` varchar(256) DEFAULT NULL COMMENT 'Address',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `status_id` (`status_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_clinic`
--

INSERT INTO `clnc_clinic` (`id`, `status_id`, `name`, `prefix`, `email`, `phone1`, `phone2`, `phone3`, `address`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 1, 'Sparkle', 'SP', 'clinic@clinic.com', 'a', '11111', '12354', 'aaaaaaaa', -9, '2021-04-03 15:06:16', -1, '2022-04-29 04:47:06'),
(9, 1, 'Shahbandar', 'SH', '.', '.', '.', '', '.', 0, '2022-04-30 11:58:09', 0, '2022-05-07 22:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_cod_hownow`
--

DROP TABLE IF EXISTS `clnc_cod_hownow`;
CREATE TABLE IF NOT EXISTS `clnc_cod_hownow` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_cod_hownow`
--

INSERT INTO `clnc_cod_hownow` (`id`, `name`, `rem`) VALUES
(0, 'None', NULL),
(1, 'Relative', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clnc_discount`
--

DROP TABLE IF EXISTS `clnc_discount`;
CREATE TABLE IF NOT EXISTS `clnc_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `date` date NOT NULL COMMENT 'Date',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `description` varchar(256) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `patient_id` (`patient_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_invoice`
--

DROP TABLE IF EXISTS `clnc_invoice`;
CREATE TABLE IF NOT EXISTS `clnc_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `num` int(11) NOT NULL COMMENT 'Number',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date',
  `discount_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Discount Type',
  `discount_value` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Discount Percent/Amount',
  `discount_amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Discount Amount',
  `discount_reason` varchar(100) DEFAULT NULL COMMENT 'Discount Reason',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `patient_id` (`patient_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_invoice_treatment`
--

DROP TABLE IF EXISTS `clnc_invoice_treatment`;
CREATE TABLE IF NOT EXISTS `clnc_invoice_treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `invoice_id` int(11) NOT NULL COMMENT 'Invoice',
  `treatment_id` int(11) NOT NULL COMMENT 'Treatment',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_id` (`invoice_id`,`treatment_id`),
  KEY `treatment_id` (`treatment_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_offer`
--

DROP TABLE IF EXISTS `clnc_offer`;
CREATE TABLE IF NOT EXISTS `clnc_offer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `status_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Status',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `sdate` date NOT NULL COMMENT 'Start Date',
  `edate` date NOT NULL COMMENT 'End Date',
  `description` varchar(512) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`),
  KEY `clnc_offer_ibfk_1` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_offer_clinic`
--

DROP TABLE IF EXISTS `clnc_offer_clinic`;
CREATE TABLE IF NOT EXISTS `clnc_offer_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `offer_id` int(11) NOT NULL COMMENT 'Offer',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `description` varchar(512) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `offer_id` (`offer_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_offer_procedure`
--

DROP TABLE IF EXISTS `clnc_offer_procedure`;
CREATE TABLE IF NOT EXISTS `clnc_offer_procedure` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `offer_id` int(11) NOT NULL COMMENT 'Offer',
  `procedure_id` int(11) NOT NULL COMMENT 'Procedure',
  `price` decimal(10,0) NOT NULL DEFAULT '0' COMMENT 'Offer Price',
  `description` varchar(512) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `offer_id` (`offer_id`),
  KEY `procedure_id` (`procedure_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_patient`
--

DROP TABLE IF EXISTS `clnc_patient`;
CREATE TABLE IF NOT EXISTS `clnc_patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Patient Clinic',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `num` varchar(15) NOT NULL COMMENT 'MR Number',
  `birthday` date NOT NULL COMMENT 'Birthdate',
  `gender_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Gender',
  `martial_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Martial Status',
  `nat_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Nationality',
  `visa_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Visa Type',
  `hormonal_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Hormonal Disorder',
  `smoked_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Smoked',
  `alcoholic_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Alcoholic',
  `pregnancy_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Pregnancy',
  `breastfeed_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Breastfeed',
  `nat_num` varchar(25) DEFAULT NULL COMMENT 'National Id',
  `idtype_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Id Type',
  `idnum` varchar(30) DEFAULT NULL COMMENT 'Id Number',
  `mobile` varchar(100) DEFAULT NULL COMMENT 'Mobile',
  `land1` varchar(25) DEFAULT NULL COMMENT 'Land Number 1',
  `land2` varchar(25) DEFAULT NULL COMMENT 'Land Number 2',
  `job_name` varchar(100) DEFAULT NULL COMMENT 'Job Name',
  `addr` varchar(100) DEFAULT NULL COMMENT 'Address',
  `chronic_diseases` varchar(100) DEFAULT NULL COMMENT 'Chronic Diseases',
  `pre_operations` varchar(100) DEFAULT NULL COMMENT 'Previous operations',
  `medicines_used` varchar(100) DEFAULT NULL COMMENT 'Medicines Used',
  `patrem` varchar(100) DEFAULT NULL COMMENT 'Patient Remarks',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `hownowid` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'How Now Id',
  `hownow` varchar(100) DEFAULT NULL COMMENT 'How Know Sparkle',
  `email` varchar(75) DEFAULT NULL COMMENT 'Email',
  `company` varchar(100) DEFAULT NULL COMMENT 'Company Name',
  `langs` varchar(100) DEFAULT NULL COMMENT 'Languages Known',
  `description` varchar(100) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`num`),
  KEY `gender_id` (`gender_id`),
  KEY `idtype_id` (`idtype_id`),
  KEY `martial_id` (`martial_id`),
  KEY `nat_id` (`nat_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`),
  KEY `clinic_id` (`clinic_id`),
  KEY `pregnancy_id` (`pregnancy_id`),
  KEY `alcoholic_id` (`alcoholic_id`),
  KEY `breastfeed_id` (`breastfeed_id`),
  KEY `hormonal_id` (`hormonal_id`),
  KEY `smoked_id` (`smoked_id`),
  KEY `visa_id` (`visa_id`),
  KEY `hownowid` (`hownowid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_patient`
--

INSERT INTO `clnc_patient` (`id`, `clinic_id`, `name`, `num`, `birthday`, `gender_id`, `martial_id`, `nat_id`, `visa_id`, `hormonal_id`, `smoked_id`, `alcoholic_id`, `pregnancy_id`, `breastfeed_id`, `nat_num`, `idtype_id`, `idnum`, `mobile`, `land1`, `land2`, `job_name`, `addr`, `chronic_diseases`, `pre_operations`, `medicines_used`, `patrem`, `rem`, `hownowid`, `hownow`, `email`, `company`, `langs`, `description`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(2, 1, 'Patient 1', 'SP111', '2000-01-01', 2, 1, 760, 1, 2, 2, 2, 2, 2, NULL, 1, NULL, '', NULL, NULL, '.', '.', '.', '.', '.', '.', '.', 0, '.', '.', '.', '.', '.', -9, '2022-05-07 17:22:50', -9, '2022-05-07 17:22:50'),
(3, 1, '1111', '1111', '2022-05-08', 1, 1, 4, 1, 2, 2, 2, 2, 2, '1111', 1, '11111', '111', '111', '111', '111', '111', '11', '11', '11', '11', '111', 0, '11', '111', '111', '111', '111', 0, '2022-05-08 18:32:23', -9, '2022-05-08 18:32:23'),
(4, 1, '9999', '999', '2022-05-08', 1, 1, 760, 1, 2, 2, 2, 2, 2, '9999', 1, '999', '999', '999', '999', '99', '99', '99', '99', '99', '99', '99', 0, '99', '99', '999', '99', '99', 0, '2022-05-08 19:13:04', -9, '2022-05-08 19:13:04'),
(5, 1, '000', '000', '2022-05-08', 1, 1, 4, 1, 2, 2, 2, 2, 2, '000', 1, '000', '000', '000', '000', '000', '000', '000', '000', '000', '000', '000', 0, '000', '000', '000', '000', '000', 0, '2022-05-08 19:14:43', -9, '2022-05-08 19:14:43'),
(6, 1, '5555', '5555', '2022-05-08', 2, 1, 4, 1, 2, 2, 2, 2, 2, '5555', 1, '555', '555', '555', '555', '555', '555', '555', '555', '555', '555', '555', 0, '555', '555', '555', '555', '555', 0, '2022-05-08 19:19:58', -9, '2022-05-08 19:19:58'),
(7, 1, '9090', '9090', '2022-05-08', 2, 1, 4, 1, 2, 2, 2, 2, 2, '9090', 1, '9090', '9090', '9090', '9090', '9090', '9090', '9090', '9090', '9090', '9090', '9090', 0, '9090', '9090', '9090', '9090', '9090', 0, '2022-05-08 19:34:12', -9, '2022-05-08 19:34:12'),
(8, 1, '8080', '8080', '2022-05-08', 2, 1, 4, 1, 2, 2, 2, 2, 2, '8080', 1, '8080', '8080', '8080', '8080', '8080', '8080', '8080', '8080', '8080', '8080', '8080', 0, '8080', '8080', '8080', '8080', '8080', 0, '2022-05-08 19:53:57', -9, '2022-05-08 19:53:57'),
(9, 1, '7070', '7070', '2022-05-09', 1, 1, 4, 1, 2, 2, 2, 2, 2, '7070', 1, '7070', '7070', '7070', '7070', '7070', '7070', '7070', '7070', '7070', '7070', '7070', 0, '7070', '7070', '7070', '7070', '7070', 0, '2022-05-09 14:47:46', -9, '2022-05-09 14:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_patient_note`
--

DROP TABLE IF EXISTS `clnc_patient_note`;
CREATE TABLE IF NOT EXISTS `clnc_patient_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `doctor_id` int(11) NOT NULL COMMENT 'Doctor',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date Time',
  `note` varchar(512) NOT NULL COMMENT 'Note',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_payment`
--

DROP TABLE IF EXISTS `clnc_payment`;
CREATE TABLE IF NOT EXISTS `clnc_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `doctor_id` int(11) NOT NULL COMMENT 'Doctor',
  `method_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Payment Method',
  `date` date NOT NULL COMMENT 'Date',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `description` varchar(256) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `patient_id` (`patient_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`),
  KEY `method_id` (`method_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_procedure`
--

DROP TABLE IF EXISTS `clnc_procedure`;
CREATE TABLE IF NOT EXISTS `clnc_procedure` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `cat_id` int(11) NOT NULL COMMENT 'Category',
  `code` varchar(10) NOT NULL COMMENT 'Code',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `vat_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Vat Type',
  `vat` decimal(10,0) NOT NULL DEFAULT '0' COMMENT 'Vat Percent/Amount',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `cat_id` (`cat_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`),
  KEY `clnc_procedure_ibfk_2` (`vat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_procedure`
--

INSERT INTO `clnc_procedure` (`id`, `cat_id`, `code`, `name`, `price`, `vat_id`, `vat`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 1, 'DP-01', 'Consultation ', '0.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2021-04-03 15:06:44'),
(2, 1, 'DP-02', 'Bridge - Zircon', '100.000', 1, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(3, 1, 'DP-03', 'Crown - Zircon', '100.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(4, 2, 'LP-0101', 'Gingival Contouring - UPPER', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(6, 2, 'LP-0201', 'Gingivectomy - Laser Balance - UPPER', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(7, 2, 'LP-0202', 'Gingivectomy - Laser Balance - LOWER', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(8, 2, 'LP-03', 'Gum Depigmentation / Bleaching', '150.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(9, 2, 'LP-04', 'Veneer Removal with Laser', '150.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(10, 2, 'LP-05', 'Whitening', '150.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(11, 3, 'OP-01', 'X-Ray', '25.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(13, 4, 'VIP-01', 'VIP Service', '100.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(14, 5, 'CP-01', 'Refund Cancellation Fees', '35.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(15, 6, 'TP-01', 'Braces Removal', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(16, 6, 'TP-02', 'Cleaning &amp; Polishing', '35.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(17, 6, 'TP-03', 'Extraction Tooth', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(18, 6, 'TP-04', 'Filling Tooth', '35.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(19, 6, 'TP-05', 'Post And Core', '70.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(20, 6, 'TP-06', 'Root Canal Retreatment', '150.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(21, 6, 'TP-07', 'Root Canal treatment', '150.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(22, 6, 'TP-08', 'Scaling &amp; Root Planning', '35.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(23, 6, 'TP-09', 'Wax-UP', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(24, 7, 'VP-01', 'Emax', '0.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(25, 7, 'VP-02', 'Emax Per Unit', '20.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(26, 7, 'VP-03', '3D', '0.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(27, 7, 'VP-04', '3D Per Unit', '30.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(28, 7, 'VP-05', 'Zircon', '0.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(29, 7, 'VP-06', 'Zircon Per Unit', '50.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(30, 7, 'VP-07', '3D Max', '0.000', 0, '0', -9, '2021-04-03 15:06:44', -9, '2021-04-03 15:06:44'),
(31, 7, 'VP-08', 'Snap On Smile', '150.000', 1, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(32, 7, 'VP-09', 'Thailand Smile Removal /Direct Veneer Removal', '100.000', 1, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(33, 7, 'VP-10', 'Upper Night Guard', '50.000', 1, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(34, 7, 'VP-11', 'Veneer Removal Without Laser', '100.000', 1, '0', -9, '2021-04-03 15:06:44', -9, '2022-04-24 15:46:36'),
(35, 1, 'DP-04', 'Implant + Crown zircon', '350.000', 0, '0', -9, '2021-09-14 10:01:06', -9, '2022-04-24 15:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_procedure_category`
--

DROP TABLE IF EXISTS `clnc_procedure_category`;
CREATE TABLE IF NOT EXISTS `clnc_procedure_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `image` varchar(512) DEFAULT NULL COMMENT 'Image',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_procedure_category`
--

INSERT INTO `clnc_procedure_category` (`id`, `name`, `image`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 'Dental', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45'),
(2, 'Laser Gum Cutting And Whitening', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45'),
(3, 'OPG', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45'),
(4, 'VIP', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45'),
(5, 'Cancellation Fees', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45'),
(6, 'Treatment , Cleaning And Polishing', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45'),
(7, 'Veneer & None-Prep Veneer', 'procCats.jpg', -9, '2021-04-03 15:06:45', -9, '2021-04-03 15:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_refund`
--

DROP TABLE IF EXISTS `clnc_refund`;
CREATE TABLE IF NOT EXISTS `clnc_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `date` date NOT NULL COMMENT 'Date',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `description` varchar(256) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `patient_id` (`patient_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_special`
--

DROP TABLE IF EXISTS `clnc_special`;
CREATE TABLE IF NOT EXISTS `clnc_special` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_special`
--

INSERT INTO `clnc_special` (`id`, `name`, `rem`) VALUES
(0, 'ALL', NULL),
(1, 'Dental', NULL),
(2, 'Laser', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clnc_staff`
--

DROP TABLE IF EXISTS `clnc_staff`;
CREATE TABLE IF NOT EXISTS `clnc_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `type_id` smallint(6) NOT NULL DEFAULT '2' COMMENT 'Type',
  `grp_id` int(11) NOT NULL DEFAULT '2' COMMENT 'Group Policy',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `gender_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Gender',
  `special_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Specialty',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `username` varchar(100) NOT NULL COMMENT 'Logon name',
  `password` varchar(100) NOT NULL COMMENT 'Password',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `image` varchar(100) DEFAULT NULL COMMENT 'Image',
  PRIMARY KEY (`id`),
  KEY `special_id` (`special_id`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `gender_id` (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_staff`
--

INSERT INTO `clnc_staff` (`id`, `type_id`, `grp_id`, `status_id`, `gender_id`, `special_id`, `name`, `username`, `password`, `rem`, `image`) VALUES
(1, 2, 2, 1, 1, 1, 'Mouhamad', 'DrMhmd', 'Password', 'rem', 'image'),
(2, 2, 2, 1, 2, 1, 'Maria', 'DrMaria', 'Password', 'rem', 'image'),
(3, 2, 2, 1, 2, 1, 'Mira', 'DrMira', 'Password', 'rem', 'image');

-- --------------------------------------------------------

--
-- Table structure for table `clnc_staff_clinic`
--

DROP TABLE IF EXISTS `clnc_staff_clinic`;
CREATE TABLE IF NOT EXISTS `clnc_staff_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `staff_id` int(11) NOT NULL COMMENT 'Staff',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_treatment`
--

DROP TABLE IF EXISTS `clnc_treatment`;
CREATE TABLE IF NOT EXISTS `clnc_treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `doctor_id` int(11) NOT NULL COMMENT 'Doctor',
  `patient_id` int(11) NOT NULL COMMENT 'Patient',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date',
  `description` varchar(512) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `patient_id` (`patient_id`),
  KEY `status_id` (`status_id`),
  KEY `clnc_treatment_ibfk_4` (`doctor_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clnc_treatment_procedures`
--

DROP TABLE IF EXISTS `clnc_treatment_procedures`;
CREATE TABLE IF NOT EXISTS `clnc_treatment_procedures` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `treatment_id` int(11) NOT NULL COMMENT 'Treatment',
  `procedure_id` int(11) NOT NULL COMMENT 'Procedure',
  `vat_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Vat Type',
  `qnt` decimal(10,3) NOT NULL DEFAULT '1.000' COMMENT 'Quantity',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `discount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Discount',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `vat_value` decimal(10,0) NOT NULL DEFAULT '0' COMMENT 'Vat Percent/Amount Type',
  `vat_amt` decimal(10,0) NOT NULL DEFAULT '0' COMMENT 'Vat Amount',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Datetime',
  `description` varchar(256) DEFAULT NULL COMMENT 'Description',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `treatment_id` (`treatment_id`),
  KEY `procedure_id` (`procedure_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`),
  KEY `vat_id` (`vat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vappointment`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vappointment`;
CREATE TABLE IF NOT EXISTS `clnc_vappointment` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`date` date
,`hour` tinyint(4)
,`minute` tinyint(4)
,`minutes` int(11)
,`amount` decimal(10,0)
,`description` varchar(512)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`status_icon` varchar(50)
,`status_color` tinyint(4)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`clinic_prefix` varchar(5)
,`clinic_email` varchar(75)
,`clinic_phone1` varchar(30)
,`clinic_phone2` varchar(30)
,`clinic_phone3` varchar(30)
,`clinic_address` varchar(256)
,`clinic_status_id` tinyint(4)
,`doctor_id` int(11)
,`doctor_name` varchar(100)
,`doctor_mobile` char(0)
,`doctor_gender_id` tinyint(4)
,`doctor_status_id` tinyint(4)
,`doctor_special_id` tinyint(4)
,`type_id` int(11)
,`type_name` varchar(100)
,`type_capacity` tinyint(4)
,`type_time` tinyint(4)
,`type_titlebg_id` tinyint(4)
,`type_titlfg_id` tinyint(4)
,`type_namefg_id` tinyint(4)
,`special_id` tinyint(4)
,`special_name` varchar(100)
,`patient_id` int(11)
,`patient_num` varchar(15)
,`patient_name` varchar(100)
,`patient_mobile` varchar(100)
,`patient_nat_num` varchar(25)
,`patient_nat_id` smallint(6)
,`patient_gender_id` tinyint(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vclinic`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vclinic`;
CREATE TABLE IF NOT EXISTS `clnc_vclinic` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`name` varchar(100)
,`prefix` varchar(5)
,`email` varchar(75)
,`phone1` varchar(30)
,`phone2` varchar(30)
,`phone3` varchar(30)
,`address` varchar(256)
,`status_id` tinyint(4)
,`status_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vdiscount`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vdiscount`;
CREATE TABLE IF NOT EXISTS `clnc_vdiscount` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`date` date
,`amt` decimal(10,3)
,`description` varchar(256)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`patient_id` int(11)
,`patient_num` varchar(15)
,`patient_name` varchar(100)
,`patient_mobile` varchar(100)
,`patient_nat_num` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vinvoice`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vinvoice`;
CREATE TABLE IF NOT EXISTS `clnc_vinvoice` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`num` int(11)
,`date` datetime
,`discount_id` tinyint(4)
,`discount_name` varchar(100)
,`discount_value` decimal(10,3)
,`discount_amt` decimal(10,3)
,`discount_reason` varchar(100)
,`description` char(0)
,`amt` decimal(32,3)
,`vat` decimal(32,0)
,`net` decimal(37,3)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`patient_id` int(11)
,`patient_num` varchar(15)
,`patient_name` varchar(100)
,`patient_mobile` varchar(100)
,`patient_nat_num` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_voffer`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_voffer`;
CREATE TABLE IF NOT EXISTS `clnc_voffer` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`name` varchar(100)
,`sdate` date
,`edate` date
,`description` varchar(512)
,`status_id` tinyint(4)
,`status_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_voffer_clinic`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_voffer_clinic`;
CREATE TABLE IF NOT EXISTS `clnc_voffer_clinic` (
`offer_id` int(11)
,`offer_iuser_id` int(11)
,`offer_idate` datetime
,`offer_uuser_id` int(11)
,`offer_udate` datetime
,`offer_name` varchar(100)
,`offer_sdate` date
,`offer_edate` date
,`offer_description` varchar(512)
,`offer_status_id` tinyint(4)
,`offer_status_name` varchar(100)
,`clinic_id` int(11)
,`clinic_iuser_id` int(11)
,`clinic_idate` datetime
,`clinic_uuser_id` int(11)
,`clinic_udate` datetime
,`clinic_name` varchar(100)
,`clinic_email` varchar(75)
,`clinic_phone1` varchar(30)
,`clinic_phone2` varchar(30)
,`clinic_phone3` varchar(30)
,`clinic_address` varchar(256)
,`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`description` varchar(512)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_voffer_procedure`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_voffer_procedure`;
CREATE TABLE IF NOT EXISTS `clnc_voffer_procedure` (
`offer_id` int(11)
,`offer_name` varchar(100)
,`offer_sdate` date
,`offer_edate` date
,`offer_description` varchar(512)
,`offer_status_id` tinyint(4)
,`offer_status_name` varchar(100)
,`procedure_id` int(11)
,`procedure_iuser_id` int(11)
,`procedure_idate` datetime
,`procedure_uuser_id` int(11)
,`procedure_udate` datetime
,`procedure_code` varchar(10)
,`procedure_name` varchar(100)
,`procedure_price` decimal(10,3)
,`procedure_vat` decimal(10,0)
,`vat_id` tinyint(4)
,`vat_name` varchar(100)
,`cat_id` int(11)
,`cat_name` varchar(100)
,`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`price` decimal(10,0)
,`description` varchar(512)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vpatient`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vpatient`;
CREATE TABLE IF NOT EXISTS `clnc_vpatient` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`name` varchar(100)
,`num` varchar(15)
,`birthday` date
,`nat_num` varchar(25)
,`idnum` varchar(30)
,`mobile` varchar(100)
,`land1` varchar(25)
,`land2` varchar(25)
,`email` varchar(75)
,`company` varchar(100)
,`langs` varchar(100)
,`description` varchar(100)
,`gender_id` tinyint(4)
,`gender_name` varchar(100)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`martial_id` tinyint(4)
,`martial_name` varchar(100)
,`nat_id` smallint(6)
,`nat_name` varchar(39)
,`visa_id` tinyint(4)
,`visa_name` varchar(100)
,`idtype_id` tinyint(4)
,`idtype_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vpatient_card`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vpatient_card`;
CREATE TABLE IF NOT EXISTS `clnc_vpatient_card` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`trt_id` bigint(20)
,`trt_name` varchar(7)
,`num` bigint(20)
,`date` datetime
,`discount` decimal(18,3)
,`vat` decimal(32,0)
,`amt` decimal(32,3)
,`net` decimal(37,3)
,`dbt` decimal(37,3)
,`crd` decimal(10,3)
,`description` varchar(256)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`patient_id` int(11)
,`patient_num` varchar(15)
,`patient_name` varchar(100)
,`patient_nat_num` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vpatient_note`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vpatient_note`;
CREATE TABLE IF NOT EXISTS `clnc_vpatient_note` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`datetime` datetime
,`note` varchar(512)
,`patient_id` int(11)
,`patient_name` varchar(100)
,`doctor_id` int(11)
,`doctor_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vpayment`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vpayment`;
CREATE TABLE IF NOT EXISTS `clnc_vpayment` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`date` date
,`amt` decimal(10,3)
,`description` varchar(256)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`method_id` tinyint(4)
,`method_name` varchar(100)
,`doctor_id` int(11)
,`doctor_name` varchar(100)
,`patient_id` int(11)
,`patient_num` varchar(15)
,`patient_name` varchar(100)
,`patient_mobile` varchar(100)
,`patient_nat_num` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vprocedure`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vprocedure`;
CREATE TABLE IF NOT EXISTS `clnc_vprocedure` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`code` varchar(10)
,`name` varchar(100)
,`price` decimal(10,3)
,`vat` decimal(10,0)
,`vat_id` tinyint(4)
,`vat_name` varchar(100)
,`cat_id` int(11)
,`cat_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vrefund`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vrefund`;
CREATE TABLE IF NOT EXISTS `clnc_vrefund` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`date` date
,`amt` decimal(10,3)
,`description` varchar(256)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`patient_id` int(11)
,`patient_num` varchar(15)
,`patient_name` varchar(100)
,`patient_mobile` varchar(100)
,`patient_nat_num` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vstaff`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vstaff`;
CREATE TABLE IF NOT EXISTS `clnc_vstaff` (
`id` int(11)
,`rid` int(11)
,`type_id` smallint(6)
,`type_name` varchar(100)
,`grp_id` int(11)
,`grp_name` varchar(100)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`gender_id` tinyint(4)
,`gender_name` varchar(100)
,`special_id` tinyint(4)
,`special_name` varchar(100)
,`name` varchar(100)
,`logon` varchar(100)
,`password` varchar(100)
,`rem` varchar(100)
,`image` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vtreatment`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vtreatment`;
CREATE TABLE IF NOT EXISTS `clnc_vtreatment` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`date` datetime
,`description` varchar(512)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`doctor_id` int(11)
,`doctor_name` varchar(100)
,`doctor_special_id` tinyint(4)
,`doctor_special_name` varchar(100)
,`patient_id` int(11)
,`patient_name` varchar(100)
,`patient_num` varchar(15)
,`patient_nat_num` varchar(25)
,`patient_mobile` varchar(100)
,`patient_company` varchar(100)
,`patient_description` varchar(100)
,`patient_gender_name` varchar(100)
,`patient_nat_name` varchar(39)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `clnc_vtreatment_procedure`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `clnc_vtreatment_procedure`;
CREATE TABLE IF NOT EXISTS `clnc_vtreatment_procedure` (
`id` int(11)
,`iuser_id` int(11)
,`idate` datetime
,`uuser_id` int(11)
,`udate` datetime
,`qnt` decimal(10,3)
,`price` decimal(10,3)
,`discount` decimal(10,3)
,`amt` decimal(10,3)
,`vat_id` tinyint(4)
,`vat_value` decimal(10,0)
,`vat_amt` decimal(10,0)
,`datetime` datetime
,`description` varchar(256)
,`treatment_id` int(11)
,`treatment_date` datetime
,`treatment_description` varchar(512)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`clinic_id` int(11)
,`clinic_name` varchar(100)
,`doctor_id` int(11)
,`doctor_name` varchar(100)
,`doctor_special_name` varchar(100)
,`patient_id` int(11)
,`patient_name` varchar(100)
,`patient_num` varchar(15)
,`patient_nat_num` varchar(25)
,`patient_mobile` varchar(100)
,`patient_company` varchar(100)
,`patient_description` varchar(100)
,`patient_gender_name` varchar(100)
,`patient_nat_name` varchar(39)
,`cat_id` int(11)
,`cat_name` varchar(100)
,`procedure_id` int(11)
,`procedure_code` varchar(10)
,`procedure_name` varchar(100)
,`procedure_price` decimal(10,3)
);

-- --------------------------------------------------------

--
-- Table structure for table `clnc_worktime`
--

DROP TABLE IF EXISTS `clnc_worktime`;
CREATE TABLE IF NOT EXISTS `clnc_worktime` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `hour` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Hour',
  `minute` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Minute',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clnc_worktime`
--

INSERT INTO `clnc_worktime` (`id`, `hour`, `minute`) VALUES
(-4, 8, 0),
(-3, 8, 15),
(-2, 8, 30),
(-1, 8, 45),
(1, 9, 0),
(2, 9, 15),
(3, 9, 30),
(4, 9, 45),
(5, 10, 0),
(6, 10, 15),
(7, 10, 30),
(8, 10, 45),
(9, 11, 0),
(10, 11, 15),
(11, 11, 30),
(12, 11, 45),
(13, 12, 0),
(14, 12, 15),
(15, 12, 30),
(16, 12, 45),
(17, 13, 0),
(18, 13, 15),
(19, 13, 30),
(20, 13, 45),
(21, 14, 0),
(22, 14, 15),
(23, 14, 30),
(24, 14, 45),
(25, 15, 0),
(26, 15, 15),
(27, 15, 30),
(28, 15, 45),
(29, 16, 0),
(30, 16, 15),
(31, 16, 30),
(32, 16, 45),
(33, 17, 0),
(34, 17, 15),
(35, 17, 30),
(36, 17, 45),
(37, 18, 0),
(38, 18, 15),
(39, 18, 30),
(40, 18, 45),
(41, 19, 0),
(42, 19, 15),
(43, 19, 30),
(44, 19, 45),
(45, 20, 0),
(46, 20, 15),
(47, 20, 30),
(48, 20, 45),
(49, 21, 0),
(50, 21, 15),
(51, 21, 30),
(52, 21, 45),
(53, 22, 0),
(54, 22, 15),
(55, 22, 30),
(56, 22, 45),
(57, 23, 0),
(58, 23, 15),
(59, 23, 30),
(60, 23, 45),
(61, 0, 0),
(62, 0, 15),
(63, 0, 30),
(64, 0, 45),
(65, 1, 0),
(66, 1, 15),
(67, 1, 30),
(68, 1, 45);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_cod_doc`
--

DROP TABLE IF EXISTS `cpy_cod_doc`;
CREATE TABLE IF NOT EXISTS `cpy_cod_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_cod_doc`
--

INSERT INTO `cpy_cod_doc` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'Document', 'Document Type', -9, '2022-02-03 10:16:18', -9, '2022-02-03 10:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_cod_unit`
--

DROP TABLE IF EXISTS `cpy_cod_unit`;
CREATE TABLE IF NOT EXISTS `cpy_cod_unit` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_cod_unit`
--

INSERT INTO `cpy_cod_unit` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 'عدد', 'Piece', -9, '2022-02-03 10:16:19', -9, '2022-02-03 10:16:19'),
(2, 'متر', 'Mitr', -9, '2022-02-03 10:16:19', -9, '2022-02-03 10:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_customize`
--

DROP TABLE IF EXISTS `cpy_customize`;
CREATE TABLE IF NOT EXISTS `cpy_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `cust_id` int(11) NOT NULL COMMENT 'Customize Field',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Display Status',
  `value` varchar(100) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`id`),
  KEY `cust_id` (`cust_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cpy_device`
--

DROP TABLE IF EXISTS `cpy_device`;
CREATE TABLE IF NOT EXISTS `cpy_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `guid` varchar(100) NOT NULL COMMENT 'GUID',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `shour` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Start Hour',
  `sminute` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Start Minute',
  `ehour` tinyint(4) NOT NULL DEFAULT '23' COMMENT 'End Hour',
  `eminute` tinyint(4) NOT NULL DEFAULT '59' COMMENT 'End Minute',
  `day1` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 1 Status',
  `day2` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 2 Status',
  `day3` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 3 Status',
  `day4` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 4 Status',
  `day5` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 5 Status',
  `day6` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 6 Status',
  `day7` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Work Day 7 Status',
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Added At',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `guid` (`guid`),
  KEY `status_id` (`status_id`),
  KEY `day1` (`day1`),
  KEY `day2` (`day2`),
  KEY `day3` (`day3`),
  KEY `day4` (`day4`),
  KEY `day5` (`day5`),
  KEY `day6` (`day6`),
  KEY `day7` (`day7`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_device`
--

INSERT INTO `cpy_device` (`id`, `name`, `guid`, `status_id`, `shour`, `sminute`, `ehour`, `eminute`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `added_at`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(-9, 'System', '-9', 1, 0, 0, 23, 59, 1, 1, 1, 1, 1, 1, 1, '2022-01-31 14:22:22', -9, '2022-02-03 07:17:49', -9, '2022-02-03 07:17:49'),
(1, 'New', 'cd7876d0f82f3da0a9c136c554bb614f', 1, 0, 0, 23, 59, 1, 1, 1, 1, 1, 1, 1, '2022-01-31 14:22:22', -9, '2022-02-03 07:17:49', -9, '2022-02-03 07:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_log`
--

DROP TABLE IF EXISTS `cpy_log`;
CREATE TABLE IF NOT EXISTS `cpy_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `type_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Operation Type',
  `rel_id` int(11) NOT NULL COMMENT 'Related Id',
  `table_name` varchar(100) NOT NULL COMMENT 'Table Name',
  `old_value` text COMMENT 'old Value',
  `new_value` text COMMENT 'New Value',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Datetime',
  PRIMARY KEY (`id`),
  KEY `ins_user` (`ins_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cpy_notification`
--

DROP TABLE IF EXISTS `cpy_notification`;
CREATE TABLE IF NOT EXISTS `cpy_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `user_id` int(11) NOT NULL COMMENT 'User',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Type',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `title` varchar(100) NOT NULL COMMENT 'Message Title',
  `icon` varchar(50) NOT NULL DEFAULT 'logos/favicon.png' COMMENT 'Message Icon',
  `body` varchar(512) NOT NULL COMMENT 'Message Body',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_notification`
--

INSERT INTO `cpy_notification` (`id`, `user_id`, `type`, `status_id`, `title`, `icon`, `body`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(41, 0, 1, 2, 'Abed', 'logos/favicon.png', 'Hi Abed', -9, '2022-02-03 10:21:14', -9, '2022-04-24 13:55:41'),
(42, 0, 1, 2, 'Abed', 'logos/favicon.png', 'Hi Abed', -9, '2022-02-03 10:21:14', -9, '2022-04-24 13:55:41'),
(43, 0, 1, 2, 'Nart', 'logos/favicon.png', 'أهلين بهاي العين', -9, '2022-02-03 10:21:14', -9, '2022-04-24 13:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_perm`
--

DROP TABLE IF EXISTS `cpy_perm`;
CREATE TABLE IF NOT EXISTS `cpy_perm` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `grp_id` int(11) NOT NULL COMMENT 'Permission Group',
  `prog_id` int(11) NOT NULL COMMENT 'Menu Program',
  `isok` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Permission',
  `vperiod` smallint(6) NOT NULL DEFAULT '9999' COMMENT 'View Period Days',
  `iperiod` smallint(6) NOT NULL DEFAULT '9999' COMMENT 'Insert Period Days',
  `domain_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Work Domain',
  `ins` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Insert',
  `upd` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Update',
  `qry` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Query',
  `del` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Delete',
  `prt` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Print',
  `exp` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Export',
  `imp` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Import',
  `cmt` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Commit',
  `rvk` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Revoke',
  `spc` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Special',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `cpy_perm_ibfk_1` (`domain_id`),
  KEY `prog_id` (`prog_id`),
  KEY `grp_id` (`grp_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cpy_perm_grp`
--

DROP TABLE IF EXISTS `cpy_perm_grp`;
CREATE TABLE IF NOT EXISTS `cpy_perm_grp` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `wpstatus_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Workperiod Status',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `wpstatus_id` (`wpstatus_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_perm_grp`
--

INSERT INTO `cpy_perm_grp` (`id`, `name`, `wpstatus_id`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(-1, 'Super Users', 1, '', -9, '2022-02-03 10:21:14', -9, '2022-02-03 10:21:14'),
(0, 'Administrators', 1, '', -9, '2022-02-03 10:21:14', -9, '2022-02-03 10:21:14'),
(1, 'إدارة', 1, '', -9, '2022-02-03 10:21:14', -9, '2022-02-03 10:21:14'),
(2, 'الدكاترة', 1, '', -9, '2022-02-03 10:21:14', -9, '2022-02-03 10:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_pref`
--

DROP TABLE IF EXISTS `cpy_pref`;
CREATE TABLE IF NOT EXISTS `cpy_pref` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `key` varchar(50) NOT NULL COMMENT 'Key',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `value` varchar(100) NOT NULL COMMENT 'Value',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_pref`
--

INSERT INTO `cpy_pref` (`id`, `key`, `name`, `value`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 'Def_Direction', 'Default GUI Direction, LTR, RTL', 'rtl', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-06 14:31:18'),
(2, 'Def_Language', 'Default GUI Language, ar, en ...', 'ar', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-06 14:31:22'),
(3, 'Def_Theme', 'Default GUI Theme light, dark', 'dark', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(4, 'Def_GUI_ASide', 'Display aside', 'true', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(5, 'Def_GUI_ASide_Min', 'is ASide Minimized', 'true', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(6, 'Def_GUI_TOP_Menu', 'Display Top Menu', 'true', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(7, 'Def_GUI_TOP_Btns', 'Display Top Buttons', 'true', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(8, 'Copy_Title', 'Copy Title', 'Sparkle', NULL, -9, '2022-02-03 10:21:15', -9, '2022-05-08 19:01:00'),
(9, 'Def_Workperiod', 'Default Workperiod', '0', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(10, 'Def_Inv_Barcode', 'Default Inventory Barcode', 'false', '', -9, '2022-02-03 10:21:15', -9, '2022-02-03 16:54:34'),
(11, 'Def_Inv_Model', 'Default Inventory Model', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(12, 'Def_Inv_Color', 'Default Inventory Color', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(13, 'Def_Inv_Size', 'Default Inventory Size', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(14, 'Def_Inv_Lot', 'Default Inventory Lot', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-05-07 12:22:13'),
(15, 'Def_Inv_Start', 'Default Inventory Start', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-05-07 12:22:16'),
(16, 'Def_Inv_End', 'Default Inventory End', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-05-07 12:22:18'),
(17, 'Def_Inv_Length', 'Default Inventory Length', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(18, 'Def_Inv_Width', 'Default Inventory Width', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(19, 'Def_Inv_Height', 'Default Inventory Height', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(20, 'isWorkperiod', 'Is there a Workperiods', 'true', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(21, 'Def_GUI_ASide_Hidden', 'is ASide Hidden when minimized', 'false', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(22, 'WORK-START-TIME', 'WORK-START-TIME', '08', NULL, -9, '2022-04-24 15:19:59', -9, '2022-04-24 15:19:59'),
(23, 'WORK-END-TIME', 'WORK-END-TIME', '02', NULL, -9, '2022-04-24 15:19:59', -9, '2022-04-24 15:19:59'),
(24, 'WORK-APP-TIME', 'WORK-APP-TIME', '15', NULL, -9, '2022-04-24 15:19:59', -9, '2022-04-24 15:19:59'),
(25, 'PATIENT-NUM-LEADING', 'PATIENT-NUM-LEADING', '7', NULL, -9, '2022-04-24 15:19:59', -9, '2022-04-24 15:19:59'),
(26, 'Current-Offer', 'Current-Offer', '0', NULL, -9, '2022-04-24 15:19:59', -9, '2022-04-24 15:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_sequence`
--

DROP TABLE IF EXISTS `cpy_sequence`;
CREATE TABLE IF NOT EXISTS `cpy_sequence` (
  `name` varchar(100) NOT NULL,
  `increment` int(11) NOT NULL DEFAULT '1',
  `min_value` int(11) NOT NULL DEFAULT '0',
  `max_value` bigint(20) NOT NULL DEFAULT '9223372036854775807',
  `cur_value` bigint(20) DEFAULT '0',
  `cycle` tinyint(1) NOT NULL DEFAULT '0',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_sequence`
--

INSERT INTO `cpy_sequence` (`name`, `increment`, `min_value`, `max_value`, `cur_value`, `cycle`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
('MS', 1, 0, 9223372036854775807, 0, 0, -9, '2022-04-27 14:04:15', -9, '2022-04-27 14:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_token`
--

DROP TABLE IF EXISTS `cpy_token`;
CREATE TABLE IF NOT EXISTS `cpy_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `gid` varchar(100) NOT NULL COMMENT 'GUID',
  `device_id` int(11) NOT NULL DEFAULT '-9' COMMENT 'Device',
  `user_id` int(11) NOT NULL COMMENT 'User',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `sdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Start',
  `edate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'End',
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last Active',
  `pvkey` varchar(3072) DEFAULT NULL COMMENT 'Private Key',
  `pbkey` varchar(3072) DEFAULT NULL COMMENT 'Public Key',
  `ip` varchar(100) DEFAULT NULL COMMENT 'IP',
  `port` varchar(100) DEFAULT NULL COMMENT 'Port',
  `host` varchar(100) DEFAULT NULL COMMENT 'Host',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gid` (`gid`),
  KEY `user_id` (`user_id`),
  KEY `status_id` (`status_id`),
  KEY `client_id` (`device_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_token`
--

INSERT INTO `cpy_token` (`id`, `gid`, `device_id`, `user_id`, `status_id`, `sdate`, `edate`, `adate`, `pvkey`, `pbkey`, `ip`, `port`, `host`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(2, 'd63cfc752f9bc9d0cad4803bbad8afeb', -9, 0, 1, '2022-04-24 13:50:35', '2022-05-24 13:50:35', '2022-04-24 13:50:35', '', '', '', '', '127.0.0.1', 0, '2022-04-24 13:50:35', -9, '2022-04-24 13:50:35'),
(3, '1f206db60cbcf4e6188b8f275dd14d0a', -9, 0, 1, '2022-04-24 16:21:22', '2022-05-24 16:21:22', '2022-04-24 16:21:22', '', '', '', '', '127.0.0.1', 0, '2022-04-24 16:21:22', -9, '2022-04-24 16:21:22'),
(6, '9c8526171d90bd2261d59d05c509933e', -9, 0, 1, '2022-04-27 16:12:41', '2022-05-27 16:12:41', '2022-04-27 16:12:41', '', '', '', '', '127.0.0.1', 0, '2022-04-27 16:12:41', -9, '2022-04-27 16:12:41'),
(7, 'dc6a9a30cdfd7c94cf54dd051bda9347', -9, 0, 1, '2022-04-27 16:12:43', '2022-05-27 16:12:43', '2022-04-27 16:12:43', '', '', '', '', '127.0.0.1', 0, '2022-04-27 16:12:43', -9, '2022-04-27 16:12:43'),
(8, 'c1dd755a04460d6ccef9c7cce069dfd4', -9, 0, 1, '2022-04-27 16:12:43', '2022-05-27 16:12:43', '2022-04-27 16:12:43', '', '', '', '', '127.0.0.1', 0, '2022-04-27 16:12:43', -9, '2022-04-27 16:12:43'),
(9, '60af46c537d5586884e3860131bdc1cf', -9, -1, 1, '2022-04-27 16:12:48', '2022-05-27 16:12:48', '2022-04-27 16:12:48', '', '', '', '', '127.0.0.1', -1, '2022-04-27 16:12:48', -9, '2022-04-27 16:12:48'),
(10, 'bb043b4f8689c6790d7238b40e7e65e3', -9, 0, 1, '2022-04-27 16:34:24', '2022-05-27 16:34:24', '2022-04-27 16:34:24', '', '', '', '', '127.0.0.1', 0, '2022-04-27 16:34:24', -9, '2022-04-27 16:34:24'),
(11, '582ab2f559030df258c26a17d7bd0182', -9, 0, 1, '2022-04-28 14:43:29', '2022-05-28 14:43:29', '2022-04-28 14:43:29', '', '', '', '', '127.0.0.1', 0, '2022-04-28 14:43:29', -9, '2022-04-28 14:43:29'),
(12, 'ef3e498e5d3a01d76bee81e07bd1fe5a', -9, 0, 1, '2022-04-29 01:17:02', '2022-05-29 01:17:02', '2022-04-29 01:17:02', '', '', '', '', '127.0.0.1', 0, '2022-04-29 01:17:02', -9, '2022-04-29 01:17:02'),
(13, '0c78fe30e94cfb96decc97a0264cc576', -9, 0, 1, '2022-04-29 03:11:36', '2022-05-29 03:11:36', '2022-04-29 03:11:36', '', '', '', '', '127.0.0.1', 0, '2022-04-29 03:11:36', -9, '2022-04-29 03:11:36'),
(15, 'ead166be7976490ff46398c58d1a08e5', -9, -1, 1, '2022-04-29 04:38:46', '2022-05-29 04:38:46', '2022-04-29 04:38:46', '', '', '', '', '127.0.0.1', -1, '2022-04-29 04:38:46', -9, '2022-04-29 04:38:46'),
(16, '36b64da77f40b78d1a480eed4adcb210', -9, 0, 1, '2022-04-29 05:19:16', '2022-05-29 05:19:16', '2022-04-29 05:19:16', '', '', '', '', '127.0.0.1', 0, '2022-04-29 05:19:16', -9, '2022-04-29 05:19:16'),
(17, '7808b1d6c722e7c841189101a4d49137', -9, 0, 1, '2022-04-30 04:15:42', '2022-05-30 04:15:42', '2022-04-30 04:15:42', '', '', '', '', '127.0.0.1', 0, '2022-04-30 04:15:42', -9, '2022-04-30 04:15:42'),
(19, '961ab8dc8c9805382dea4ed278edcf20', -9, 0, 1, '2022-04-30 13:42:34', '2022-05-30 13:42:34', '2022-04-30 13:42:34', '', '', '', '', '127.0.0.1', 0, '2022-04-30 13:42:34', -9, '2022-04-30 13:42:34'),
(20, '90ad01d4df4d285749b73d3abe0d5c62', -9, 0, 1, '2022-04-30 14:58:18', '2022-05-30 14:58:18', '2022-04-30 14:58:18', '', '', '', '', '127.0.0.1', 0, '2022-04-30 14:58:18', -9, '2022-04-30 14:58:18'),
(21, '684e7bc0df67312ee26d61882ded3930', -9, 0, 1, '2022-04-30 14:58:47', '2022-05-30 14:58:47', '2022-04-30 14:58:47', '', '', '', '', '::1', 0, '2022-04-30 14:58:47', -9, '2022-04-30 14:58:47'),
(22, '48fce2e873f27ce72809d641e75324b0', -9, 0, 1, '2022-04-30 16:00:33', '2022-05-30 16:00:33', '2022-04-30 16:00:33', '', '', '', '', '127.0.0.1', 0, '2022-04-30 16:00:33', -9, '2022-04-30 16:00:33'),
(23, 'cf7d0f7731b433976756e0ea29e23eb2', -9, 0, 1, '2022-05-01 00:44:10', '2022-05-31 00:44:10', '2022-05-01 00:44:10', '', '', '', '', '127.0.0.1', 0, '2022-05-01 00:44:10', -9, '2022-05-01 00:44:10'),
(24, '09b493edaa33b21942b440f010efd839', -9, 0, 1, '2022-05-01 04:53:59', '2022-05-31 04:53:59', '2022-05-01 04:53:59', '', '', '', '', '127.0.0.1', 0, '2022-05-01 04:53:59', -9, '2022-05-01 04:53:59'),
(26, 'c3c4a5b7c06446b24f2177d22e5978c0', -9, 0, 1, '2022-05-07 11:41:06', '2022-06-06 11:41:06', '2022-05-07 11:41:06', '', '', '', '', '127.0.0.1', 0, '2022-05-07 11:41:06', -9, '2022-05-07 11:41:06'),
(27, '3f68815e8606ccb7689aea8754df3823', -9, 0, 1, '2022-05-07 11:41:16', '2022-06-06 11:41:16', '2022-05-07 11:41:16', '', '', '', '', '127.0.0.1', 0, '2022-05-07 11:41:16', -9, '2022-05-07 11:41:16'),
(28, 'a4b99a76b00b4c43e70f14eb8c07c77e', -9, 0, 1, '2022-05-07 11:43:24', '2022-06-06 11:43:24', '2022-05-07 11:43:24', '', '', '', '', '127.0.0.1', 0, '2022-05-07 11:43:24', -9, '2022-05-07 11:43:24'),
(31, '970fc295bd8edaff95f3a68341e48e69', -9, 0, 1, '2022-05-08 19:01:42', '2022-06-07 19:01:42', '2022-05-08 19:01:42', '', '', '', '', '127.0.0.1', 0, '2022-05-08 19:01:42', -9, '2022-05-08 19:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_user`
--

DROP TABLE IF EXISTS `cpy_user`;
CREATE TABLE IF NOT EXISTS `cpy_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `grp_id` int(11) NOT NULL COMMENT 'Permission Group',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `gender_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Gender',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `logon` varchar(50) NOT NULL COMMENT 'Logon Name',
  `password` varchar(512) NOT NULL COMMENT 'Password',
  `image` varchar(512) DEFAULT NULL COMMENT 'User Image',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `logon` (`logon`),
  KEY `grp_id` (`grp_id`),
  KEY `status_id` (`status_id`),
  KEY `gender_id` (`gender_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_user`
--

INSERT INTO `cpy_user` (`id`, `grp_id`, `status_id`, `gender_id`, `name`, `logon`, `password`, `image`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(-9, -1, 1, 1, 'System', 'system', 'f03bde11d261f185cbacfa32c1c6538c', 'avatars/avatar-manager1_256.png', -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(-1, -1, 1, 1, 'Supervisor', 'super', 'f03bde11d261f185cbacfa32c1c6538c', 'avatars/avatar-manager1_256.png', -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(0, 0, 1, 1, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'avatars/avatar-manager1_256.png', -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(4, 1, 1, 1, 'مستخدم', 'مستخدم', '827ccb0eea8a706c4c34a16891f84e7b', NULL, -9, '2022-02-03 10:21:15', 0, '2022-05-07 16:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_user_clinic`
--

DROP TABLE IF EXISTS `cpy_user_clinic`;
CREATE TABLE IF NOT EXISTS `cpy_user_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `user_id` int(11) NOT NULL COMMENT 'User',
  `clinic_id` int(11) NOT NULL COMMENT 'Clinic',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`clinic_id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_user_clinic`
--

INSERT INTO `cpy_user_clinic` (`id`, `user_id`, `clinic_id`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(124, 0, 1, -9, '2022-04-30 13:30:50', -9, '2022-04-30 13:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_user_shift`
--

DROP TABLE IF EXISTS `cpy_user_shift`;
CREATE TABLE IF NOT EXISTS `cpy_user_shift` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `user_id` int(11) NOT NULL COMMENT 'User',
  `date` int(11) NOT NULL COMMENT 'Date',
  `type_id` tinyint(4) NOT NULL DEFAULT '3' COMMENT 'Type',
  `start` int(11) NOT NULL COMMENT 'Start Time',
  `end` int(11) NOT NULL COMMENT 'End Time',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cpy_user_type`
--

DROP TABLE IF EXISTS `cpy_user_type`;
CREATE TABLE IF NOT EXISTS `cpy_user_type` (
  `id` smallint(6) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_user_type`
--

INSERT INTO `cpy_user_type` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'User', NULL, -9, '2022-02-03 10:21:15', -9, '2022-02-03 10:21:15'),
(2, 'Doctor', NULL, -9, '2022-05-07 16:15:39', -9, '2022-05-07 16:15:39'),
(3, 'Assistance', NULL, -9, '2022-05-07 16:15:39', -9, '2022-05-07 16:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_user_type_menu`
--

DROP TABLE IF EXISTS `cpy_user_type_menu`;
CREATE TABLE IF NOT EXISTS `cpy_user_type_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `type_id` smallint(6) NOT NULL COMMENT 'User Type',
  `prog_id` int(11) NOT NULL COMMENT 'Program',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_id` (`type_id`,`prog_id`),
  KEY `prog_id` (`prog_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_user_type_menu`
--

INSERT INTO `cpy_user_type_menu` (`id`, `type_id`, `prog_id`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 0, 0, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(2, 2, 0, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(3, 3, 0, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vuser`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vuser`;
CREATE TABLE IF NOT EXISTS `cpy_vuser` (
`id` int(11)
,`rid` int(11)
,`type_id` smallint(6)
,`type_name` varchar(100)
,`grp_id` int(11)
,`grp_name` varchar(100)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`gender_id` tinyint(4)
,`gender_name` varchar(100)
,`special_id` tinyint(4)
,`special_name` varchar(100)
,`name` varchar(100)
,`logon` varchar(100)
,`password` varchar(512)
,`rem` varchar(100)
,`image` varchar(512)
);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_wperiod`
--

DROP TABLE IF EXISTS `cpy_wperiod`;
CREATE TABLE IF NOT EXISTS `cpy_wperiod` (
  `id` smallint(6) NOT NULL COMMENT 'PK',
  `status_id` tinyint(4) NOT NULL COMMENT 'Status',
  `ord` tinyint(4) NOT NULL COMMENT 'Order',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `sdate` date NOT NULL COMMENT 'Start',
  `edate` date NOT NULL COMMENT 'End',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `status_id` (`status_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_wperiod`
--

INSERT INTO `cpy_wperiod` (`id`, `status_id`, `ord`, `name`, `sdate`, `edate`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 1, 0, 'Default', '2000-01-01', '2099-12-31', '', -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `fund_box`
--

DROP TABLE IF EXISTS `fund_box`;
CREATE TABLE IF NOT EXISTS `fund_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `rem` varchar(255) DEFAULT NULL,
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `box_name_uk` (`name`),
  KEY `user_id` (`user_id`),
  KEY `acc_id` (`acc_id`),
  KEY `status_id` (`status_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fund_box`
--

INSERT INTO `fund_box` (`id`, `user_id`, `acc_id`, `status_id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 4, 181001, 1, 'الصندوق 1', '', -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(2, 4, 0, 1, 'الرئيسي', '', 0, '2022-05-07 15:30:13', 0, '2022-05-07 19:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `fund_diary`
--

DROP TABLE IF EXISTS `fund_diary`;
CREATE TABLE IF NOT EXISTS `fund_diary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(4) NOT NULL DEFAULT '2',
  `box_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL DEFAULT '1',
  `cost_id` int(11) NOT NULL DEFAULT '1',
  `curn_id` int(11) NOT NULL,
  `print` tinyint(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `camt` decimal(10,0) NOT NULL DEFAULT '0',
  `rate` decimal(15,7) NOT NULL DEFAULT '1.0000000',
  `amt` decimal(10,0) NOT NULL DEFAULT '0',
  `rem` varchar(255) DEFAULT NULL,
  `attach` varchar(512) DEFAULT NULL COMMENT 'Attached',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `box_id` (`box_id`),
  KEY `acc_id` (`acc_id`),
  KEY `cost_id` (`cost_id`),
  KEY `curn_id` (`curn_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fund_diary`
--

INSERT INTO `fund_diary` (`id`, `type_id`, `box_id`, `acc_id`, `cost_id`, `curn_id`, `print`, `date`, `camt`, `rate`, `amt`, `rem`, `attach`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(2, 1, 1, 114001, 135000, 1, 0, '2021-12-14', '10000000', '1.0000000', '10000000', '', NULL, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(3, 2, 1, 114001, 135000, 2, 0, '2021-12-15', '500', '1.0000000', '500', '', NULL, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(8, 2, 1, 114001, 135000, 1, 0, '2021-12-15', '3500000', '1.0000000', '3500000', '', NULL, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(9, 1, 1, 114001, 135000, 2, 0, '2021-12-13', '1000', '1.0000000', '1000', '', NULL, -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(10, 1, 1, 114001, 135000, 1, 0, '2022-01-23', '10000', '1.0000000', '10000', '', 'fund_Attache_220123_095013.jpg', -9, '2022-02-03 10:21:16', -9, '2022-02-03 10:21:16'),
(11, 1, 2, 0, 2, 1, 0, '2022-05-07', '10000', '1.0000000', '10000', '', '', 0, '2022-05-07 15:37:46', -9, '2022-05-07 15:37:46'),
(12, 2, 2, 0, 2, 1, 0, '2022-05-07', '10000', '1.0000000', '10000', '', '', 0, '2022-05-07 15:38:38', -9, '2022-05-07 15:38:38'),
(13, 1, 2, 0, 2, 1, 0, '2022-05-07', '10000', '1.0000000', '10000', '', '', 0, '2022-05-07 19:35:37', -9, '2022-05-07 19:35:37'),
(14, 1, 2, 0, 2, 1, 0, '2022-05-07', '10000', '1.0000000', '10000', '', '', 0, '2022-05-07 19:36:05', -9, '2022-05-07 19:36:05'),
(15, 1, 2, 0, 0, 1, 0, '2022-05-06', '500000', '1.0000000', '500000', 'افتتاحي', '', 0, '2022-05-07 19:39:24', -9, '2022-05-07 19:39:24');

-- --------------------------------------------------------

--
-- Stand-in structure for view `fund_vbox`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `fund_vbox`;
CREATE TABLE IF NOT EXISTS `fund_vbox` (
`acc_id` int(11)
,`acc_num` varchar(15)
,`acc_name` varchar(100)
,`acc_rem` varchar(100)
,`user_id` int(11)
,`user_name` varchar(100)
,`user_logon` varchar(50)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`status_rem` varchar(100)
,`box_id` int(11)
,`box_name` varchar(100)
,`box_rem` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `fund_vdiary`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `fund_vdiary`;
CREATE TABLE IF NOT EXISTS `fund_vdiary` (
`acc_id` int(11)
,`acc_num` varchar(15)
,`acc_name` varchar(100)
,`acc_rem` varchar(100)
,`cost_id` int(11)
,`cost_num` varchar(15)
,`cost_name` varchar(100)
,`curn_id` int(11)
,`curn_name` varchar(100)
,`curn_rate` decimal(15,7)
,`curn_color` varchar(25)
,`curn_code` varchar(10)
,`type_id` tinyint(4)
,`type_name` varchar(100)
,`box_id` int(11)
,`box_user_id` int(11)
,`box_acc_id` int(11)
,`box_status_id` tinyint(4)
,`box_name` varchar(100)
,`box_rem` varchar(255)
,`id` int(11)
,`ccrd` decimal(10,0)
,`cdeb` decimal(10,0)
,`crd` decimal(10,0)
,`deb` decimal(10,0)
,`print` tinyint(4)
,`date` date
,`camt` decimal(10,0)
,`rate` decimal(15,7)
,`amt` decimal(10,0)
,`rem` varchar(255)
,`attach` varchar(512)
);

-- --------------------------------------------------------

--
-- Table structure for table `mng_curn`
--

DROP TABLE IF EXISTS `mng_curn`;
CREATE TABLE IF NOT EXISTS `mng_curn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `num` smallint(6) NOT NULL COMMENT 'Number',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `code` varchar(10) NOT NULL COMMENT 'Code',
  `rate` decimal(15,7) NOT NULL DEFAULT '1.0000000' COMMENT 'Rate',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Rate Date',
  `color` varchar(25) DEFAULT NULL COMMENT 'Color',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `status_id` (`status_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mng_curn`
--

INSERT INTO `mng_curn` (`id`, `status_id`, `num`, `name`, `code`, `rate`, `date`, `color`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 1, 0, 'NONE', 'NONE', '600.0000000', '2021-09-21 14:13:47', NULL, '', -9, '2022-02-03 10:21:18', -9, '2022-02-03 10:21:18'),
(1, 1, 1, 'Syrian Pound', 'SYP', '1.0000000', '2022-02-03 00:00:00', '', '', -9, '2022-02-03 10:21:18', -9, '2022-02-03 10:39:13'),
(2, 1, 2, 'Unitedt State Dollar', 'USD', '1300.0000000', '2022-02-03 00:00:00', NULL, '', -9, '2022-02-03 10:21:18', 0, '2022-02-03 10:46:47'),
(3, 1, 3, 'Euro', 'EUR', '1000.0000000', '2022-02-03 00:00:00', NULL, '', -9, '2022-02-03 10:21:18', 0, '2022-02-03 10:48:20'),
(6, 1, 6, 'UED', 'UED', '600.0000000', '2022-02-03 00:00:00', NULL, '', -9, '2022-02-03 10:21:18', -9, '2022-02-03 10:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `mng_curn_rate`
--

DROP TABLE IF EXISTS `mng_curn_rate`;
CREATE TABLE IF NOT EXISTS `mng_curn_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `curn_id` int(11) NOT NULL COMMENT 'Currency',
  `date` date NOT NULL COMMENT 'Date',
  `rate` decimal(15,7) NOT NULL DEFAULT '1.0000000' COMMENT 'Rate',
  `min` decimal(15,7) NOT NULL DEFAULT '1.0000000' COMMENT 'Min Rate',
  `max` decimal(15,7) NOT NULL DEFAULT '1.0000000' COMMENT 'Max Rate',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `curn_id` (`curn_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mng_curn_rate`
--

INSERT INTO `mng_curn_rate` (`id`, `curn_id`, `date`, `rate`, `min`, `max`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 3, '2022-02-03', '1000.0000000', '1000.0000000', '1000.0000000', NULL, 0, '2022-02-03 10:48:20', -9, '2022-02-03 10:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_addsub`
--

DROP TABLE IF EXISTS `phs_cod_addsub`;
CREATE TABLE IF NOT EXISTS `phs_cod_addsub` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_addsub`
--

INSERT INTO `phs_cod_addsub` (`id`, `name`, `rem`) VALUES
(-1, 'Subtract', NULL),
(1, 'Add', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_app_status`
--

DROP TABLE IF EXISTS `phs_cod_app_status`;
CREATE TABLE IF NOT EXISTS `phs_cod_app_status` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `icon` varchar(50) NOT NULL COMMENT 'Icon',
  `color_id` tinyint(4) DEFAULT '0' COMMENT 'Color',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_app_status`
--

INSERT INTO `phs_cod_app_status` (`id`, `name`, `icon`, `color_id`) VALUES
(10, 'New', 'icon-md flaticon-calendar-with-a-clock-time-tools', 0),
(20, 'Done', 'icon-md flaticon2-correct', 6),
(31, 'Delayed', 'icon-md flaticon-time-1', 9),
(32, 'Waiting', 'icon-md flaticon2-hourglass-1', 8),
(40, 'Canceled', 'icon-md flaticon2-delete', 7),
(50, 'No Show', 'icon-md flaticon2-rocket-1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_cash_type`
--

DROP TABLE IF EXISTS `phs_cod_cash_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_cash_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(250) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_cash_type`
--

INSERT INTO `phs_cod_cash_type` (`id`, `name`, `rem`) VALUES
(1, 'Cash.Collect', NULL),
(2, 'Cash.Payment', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_color`
--

DROP TABLE IF EXISTS `phs_cod_color`;
CREATE TABLE IF NOT EXISTS `phs_cod_color` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `fgclass` varchar(50) NOT NULL COMMENT 'FG Classes',
  `bgclass` varchar(50) NOT NULL COMMENT 'BG Classes',
  `bgtext` varchar(50) NOT NULL COMMENT 'BG Color',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_color`
--

INSERT INTO `phs_cod_color` (`id`, `name`, `fgclass`, `bgclass`, `bgtext`) VALUES
(0, 'Body', 'text-body', 'bg-body bg-gradient', 'text-dark'),
(1, 'Dark', 'text-dark', 'bg-dark bg-gradient', 'text-white'),
(2, 'Transparent', 'text-dark', 'bg-transparent', 'text-dark'),
(3, 'White', 'text-white', 'bg-white bg-gradient', 'text-dark'),
(4, 'Primary', 'text-primary', 'bg-primary bg-gradient', 'text-white'),
(5, 'Secondary', 'text-secondary', 'bg-secondary bg-gradient', 'text-dark'),
(6, 'Success', 'text-success', 'bg-success bg-gradient', 'text-white'),
(7, 'Danger', 'text-danger', 'bg-danger bg-gradient', 'text-white'),
(8, 'Warning', 'text-warning', 'bg-warning bg-gradient', 'text-dark'),
(9, 'Info', 'text-info', 'bg-info bg-gradient', 'text-white'),
(10, 'Light', 'text-light', 'bg-light bg-gradient', 'text-dark');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_country`
--

DROP TABLE IF EXISTS `phs_cod_country`;
CREATE TABLE IF NOT EXISTS `phs_cod_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` int(11) NOT NULL,
  `code` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `capital` varchar(80) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `continent` varchar(30) DEFAULT NULL,
  `continent_code` varchar(2) DEFAULT NULL,
  `alpha_3` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_country`
--

INSERT INTO `phs_cod_country` (`id`, `phone`, `code`, `name`, `symbol`, `capital`, `currency`, `continent`, `continent_code`, `alpha_3`) VALUES
(1, 93, 'AF', 'Afghanistan', '؋', 'Kabul', 'AFN', 'Asia', 'AS', 'AFG'),
(2, 358, 'AX', 'Aland Islands', '€', 'Mariehamn', 'EUR', 'Europe', 'EU', 'ALA'),
(3, 355, 'AL', 'Albania', 'Lek', 'Tirana', 'ALL', 'Europe', 'EU', 'ALB'),
(4, 213, 'DZ', 'Algeria', 'دج', 'Algiers', 'DZD', 'Africa', 'AF', 'DZA'),
(5, 1684, 'AS', 'American Samoa', '$', 'Pago Pago', 'USD', 'Oceania', 'OC', 'ASM'),
(6, 376, 'AD', 'Andorra', '€', 'Andorra la Vella', 'EUR', 'Europe', 'EU', 'AND'),
(7, 244, 'AO', 'Angola', 'Kz', 'Luanda', 'AOA', 'Africa', 'AF', 'AGO'),
(8, 1264, 'AI', 'Anguilla', '$', 'The Valley', 'XCD', 'North America', 'NA', 'AIA'),
(9, 672, 'AQ', 'Antarctica', '$', 'Antarctica', 'AAD', 'Antarctica', 'AN', 'ATA'),
(10, 1268, 'AG', 'Antigua and Barbuda', '$', 'St. John\'s', 'XCD', 'North America', 'NA', 'ATG'),
(11, 54, 'AR', 'Argentina', '$', 'Buenos Aires', 'ARS', 'South America', 'SA', 'ARG'),
(12, 374, 'AM', 'Armenia', '֏', 'Yerevan', 'AMD', 'Asia', 'AS', 'ARM'),
(13, 297, 'AW', 'Aruba', 'ƒ', 'Oranjestad', 'AWG', 'North America', 'NA', 'ABW'),
(14, 61, 'AU', 'Australia', '$', 'Canberra', 'AUD', 'Oceania', 'OC', 'AUS'),
(15, 43, 'AT', 'Austria', '€', 'Vienna', 'EUR', 'Europe', 'EU', 'AUT'),
(16, 994, 'AZ', 'Azerbaijan', 'm', 'Baku', 'AZN', 'Asia', 'AS', 'AZE'),
(17, 1242, 'BS', 'Bahamas', 'B$', 'Nassau', 'BSD', 'North America', 'NA', 'BHS'),
(18, 973, 'BH', 'Bahrain', '.د.ب', 'Manama', 'BHD', 'Asia', 'AS', 'BHR'),
(19, 880, 'BD', 'Bangladesh', '৳', 'Dhaka', 'BDT', 'Asia', 'AS', 'BGD'),
(20, 1246, 'BB', 'Barbados', 'Bds$', 'Bridgetown', 'BBD', 'North America', 'NA', 'BRB'),
(21, 375, 'BY', 'Belarus', 'Br', 'Minsk', 'BYN', 'Europe', 'EU', 'BLR'),
(22, 32, 'BE', 'Belgium', '€', 'Brussels', 'EUR', 'Europe', 'EU', 'BEL'),
(23, 501, 'BZ', 'Belize', '$', 'Belmopan', 'BZD', 'North America', 'NA', 'BLZ'),
(24, 229, 'BJ', 'Benin', 'CFA', 'Porto-Novo', 'XOF', 'Africa', 'AF', 'BEN'),
(25, 1441, 'BM', 'Bermuda', '$', 'Hamilton', 'BMD', 'North America', 'NA', 'BMU'),
(26, 975, 'BT', 'Bhutan', 'Nu.', 'Thimphu', 'BTN', 'Asia', 'AS', 'BTN'),
(27, 591, 'BO', 'Bolivia', 'Bs.', 'Sucre', 'BOB', 'South America', 'SA', 'BOL'),
(28, 599, 'BQ', 'Bonaire, Sint Eustatius and Saba', '$', 'Kralendijk', 'USD', 'North America', 'NA', 'BES'),
(29, 387, 'BA', 'Bosnia and Herzegovina', 'KM', 'Sarajevo', 'BAM', 'Europe', 'EU', 'BIH'),
(30, 267, 'BW', 'Botswana', 'P', 'Gaborone', 'BWP', 'Africa', 'AF', 'BWA'),
(31, 55, 'BV', 'Bouvet Island', 'kr', '', 'NOK', 'Antarctica', 'AN', 'BVT'),
(32, 55, 'BR', 'Brazil', 'R$', 'Brasilia', 'BRL', 'South America', 'SA', 'BRA'),
(33, 246, 'IO', 'British Indian Ocean Territory', '$', 'Diego Garcia', 'USD', 'Asia', 'AS', 'IOT'),
(34, 673, 'BN', 'Brunei Darussalam', 'B$', 'Bandar Seri Begawan', 'BND', 'Asia', 'AS', 'BRN'),
(35, 359, 'BG', 'Bulgaria', 'Лв.', 'Sofia', 'BGN', 'Europe', 'EU', 'BGR'),
(36, 226, 'BF', 'Burkina Faso', 'CFA', 'Ouagadougou', 'XOF', 'Africa', 'AF', 'BFA'),
(37, 257, 'BI', 'Burundi', 'FBu', 'Bujumbura', 'BIF', 'Africa', 'AF', 'BDI'),
(38, 855, 'KH', 'Cambodia', 'KHR', 'Phnom Penh', 'KHR', 'Asia', 'AS', 'KHM'),
(39, 237, 'CM', 'Cameroon', 'FCFA', 'Yaounde', 'XAF', 'Africa', 'AF', 'CMR'),
(40, 1, 'CA', 'Canada', '$', 'Ottawa', 'CAD', 'North America', 'NA', 'CAN'),
(41, 238, 'CV', 'Cape Verde', '$', 'Praia', 'CVE', 'Africa', 'AF', 'CPV'),
(42, 1345, 'KY', 'Cayman Islands', '$', 'George Town', 'KYD', 'North America', 'NA', 'CYM'),
(43, 236, 'CF', 'Central African Republic', 'FCFA', 'Bangui', 'XAF', 'Africa', 'AF', 'CAF'),
(44, 235, 'TD', 'Chad', 'FCFA', 'N\'Djamena', 'XAF', 'Africa', 'AF', 'TCD'),
(45, 56, 'CL', 'Chile', '$', 'Santiago', 'CLP', 'South America', 'SA', 'CHL'),
(46, 86, 'CN', 'China', '¥', 'Beijing', 'CNY', 'Asia', 'AS', 'CHN'),
(47, 61, 'CX', 'Christmas Island', '$', 'Flying Fish Cove', 'AUD', 'Asia', 'AS', 'CXR'),
(48, 672, 'CC', 'Cocos (Keeling) Islands', '$', 'West Island', 'AUD', 'Asia', 'AS', 'CCK'),
(49, 57, 'CO', 'Colombia', '$', 'Bogota', 'COP', 'South America', 'SA', 'COL'),
(50, 269, 'KM', 'Comoros', 'CF', 'Moroni', 'KMF', 'Africa', 'AF', 'COM'),
(51, 242, 'CG', 'Congo', 'FC', 'Brazzaville', 'XAF', 'Africa', 'AF', 'COG'),
(52, 242, 'CD', 'Congo, Democratic Republic of the Congo', 'FC', 'Kinshasa', 'CDF', 'Africa', 'AF', 'COD'),
(53, 682, 'CK', 'Cook Islands', '$', 'Avarua', 'NZD', 'Oceania', 'OC', 'COK'),
(54, 506, 'CR', 'Costa Rica', '₡', 'San Jose', 'CRC', 'North America', 'NA', 'CRI'),
(55, 225, 'CI', 'Cote D\'Ivoire', 'CFA', 'Yamoussoukro', 'XOF', 'Africa', 'AF', 'CIV'),
(56, 385, 'HR', 'Croatia', 'kn', 'Zagreb', 'HRK', 'Europe', 'EU', 'HRV'),
(57, 53, 'CU', 'Cuba', '$', 'Havana', 'CUP', 'North America', 'NA', 'CUB'),
(58, 599, 'CW', 'Curacao', 'ƒ', 'Willemstad', 'ANG', 'North America', 'NA', 'CUW'),
(59, 357, 'CY', 'Cyprus', '€', 'Nicosia', 'EUR', 'Asia', 'AS', 'CYP'),
(60, 420, 'CZ', 'Czech Republic', 'Kč', 'Prague', 'CZK', 'Europe', 'EU', 'CZE'),
(61, 45, 'DK', 'Denmark', 'Kr.', 'Copenhagen', 'DKK', 'Europe', 'EU', 'DNK'),
(62, 253, 'DJ', 'Djibouti', 'Fdj', 'Djibouti', 'DJF', 'Africa', 'AF', 'DJI'),
(63, 1767, 'DM', 'Dominica', '$', 'Roseau', 'XCD', 'North America', 'NA', 'DMA'),
(64, 1809, 'DO', 'Dominican Republic', '$', 'Santo Domingo', 'DOP', 'North America', 'NA', 'DOM'),
(65, 593, 'EC', 'Ecuador', '$', 'Quito', 'USD', 'South America', 'SA', 'ECU'),
(66, 20, 'EG', 'Egypt', 'ج.م', 'Cairo', 'EGP', 'Africa', 'AF', 'EGY'),
(67, 503, 'SV', 'El Salvador', '$', 'San Salvador', 'USD', 'North America', 'NA', 'SLV'),
(68, 240, 'GQ', 'Equatorial Guinea', 'FCFA', 'Malabo', 'XAF', 'Africa', 'AF', 'GNQ'),
(69, 291, 'ER', 'Eritrea', 'Nfk', 'Asmara', 'ERN', 'Africa', 'AF', 'ERI'),
(70, 372, 'EE', 'Estonia', '€', 'Tallinn', 'EUR', 'Europe', 'EU', 'EST'),
(71, 251, 'ET', 'Ethiopia', 'Nkf', 'Addis Ababa', 'ETB', 'Africa', 'AF', 'ETH'),
(72, 500, 'FK', 'Falkland Islands (Malvinas)', '£', 'Stanley', 'FKP', 'South America', 'SA', 'FLK'),
(73, 298, 'FO', 'Faroe Islands', 'Kr.', 'Torshavn', 'DKK', 'Europe', 'EU', 'FRO'),
(74, 679, 'FJ', 'Fiji', 'FJ$', 'Suva', 'FJD', 'Oceania', 'OC', 'FJI'),
(75, 358, 'FI', 'Finland', '€', 'Helsinki', 'EUR', 'Europe', 'EU', 'FIN'),
(76, 33, 'FR', 'France', '€', 'Paris', 'EUR', 'Europe', 'EU', 'FRA'),
(77, 594, 'GF', 'French Guiana', '€', 'Cayenne', 'EUR', 'South America', 'SA', 'GUF'),
(78, 689, 'PF', 'French Polynesia', '₣', 'Papeete', 'XPF', 'Oceania', 'OC', 'PYF'),
(79, 262, 'TF', 'French Southern Territories', '€', 'Port-aux-Francais', 'EUR', 'Antarctica', 'AN', 'ATF'),
(80, 241, 'GA', 'Gabon', 'FCFA', 'Libreville', 'XAF', 'Africa', 'AF', 'GAB'),
(81, 220, 'GM', 'Gambia', 'D', 'Banjul', 'GMD', 'Africa', 'AF', 'GMB'),
(82, 995, 'GE', 'Georgia', 'ლ', 'Tbilisi', 'GEL', 'Asia', 'AS', 'GEO'),
(83, 49, 'DE', 'Germany', '€', 'Berlin', 'EUR', 'Europe', 'EU', 'DEU'),
(84, 233, 'GH', 'Ghana', 'GH₵', 'Accra', 'GHS', 'Africa', 'AF', 'GHA'),
(85, 350, 'GI', 'Gibraltar', '£', 'Gibraltar', 'GIP', 'Europe', 'EU', 'GIB'),
(86, 30, 'GR', 'Greece', '€', 'Athens', 'EUR', 'Europe', 'EU', 'GRC'),
(87, 299, 'GL', 'Greenland', 'Kr.', 'Nuuk', 'DKK', 'North America', 'NA', 'GRL'),
(88, 1473, 'GD', 'Grenada', '$', 'St. George\'s', 'XCD', 'North America', 'NA', 'GRD'),
(89, 590, 'GP', 'Guadeloupe', '€', 'Basse-Terre', 'EUR', 'North America', 'NA', 'GLP'),
(90, 1671, 'GU', 'Guam', '$', 'Hagatna', 'USD', 'Oceania', 'OC', 'GUM'),
(91, 502, 'GT', 'Guatemala', 'Q', 'Guatemala City', 'GTQ', 'North America', 'NA', 'GTM'),
(92, 44, 'GG', 'Guernsey', '£', 'St Peter Port', 'GBP', 'Europe', 'EU', 'GGY'),
(93, 224, 'GN', 'Guinea', 'FG', 'Conakry', 'GNF', 'Africa', 'AF', 'GIN'),
(94, 245, 'GW', 'Guinea-Bissau', 'CFA', 'Bissau', 'XOF', 'Africa', 'AF', 'GNB'),
(95, 592, 'GY', 'Guyana', '$', 'Georgetown', 'GYD', 'South America', 'SA', 'GUY'),
(96, 509, 'HT', 'Haiti', 'G', 'Port-au-Prince', 'HTG', 'North America', 'NA', 'HTI'),
(97, 0, 'HM', 'Heard Island and Mcdonald Islands', '$', '', 'AUD', 'Antarctica', 'AN', 'HMD'),
(98, 39, 'VA', 'Holy See (Vatican City State)', '€', 'Vatican City', 'EUR', 'Europe', 'EU', 'VAT'),
(99, 504, 'HN', 'Honduras', 'L', 'Tegucigalpa', 'HNL', 'North America', 'NA', 'HND'),
(100, 852, 'HK', 'Hong Kong', '$', 'Hong Kong', 'HKD', 'Asia', 'AS', 'HKG'),
(101, 36, 'HU', 'Hungary', 'Ft', 'Budapest', 'HUF', 'Europe', 'EU', 'HUN'),
(102, 354, 'IS', 'Iceland', 'kr', 'Reykjavik', 'ISK', 'Europe', 'EU', 'ISL'),
(103, 91, 'IN', 'India', '₹', 'New Delhi', 'INR', 'Asia', 'AS', 'IND'),
(104, 62, 'ID', 'Indonesia', 'Rp', 'Jakarta', 'IDR', 'Asia', 'AS', 'IDN'),
(105, 98, 'IR', 'Iran, Islamic Republic of', '﷼', 'Tehran', 'IRR', 'Asia', 'AS', 'IRN'),
(106, 964, 'IQ', 'Iraq', 'د.ع', 'Baghdad', 'IQD', 'Asia', 'AS', 'IRQ'),
(107, 353, 'IE', 'Ireland', '€', 'Dublin', 'EUR', 'Europe', 'EU', 'IRL'),
(108, 44, 'IM', 'Isle of Man', '£', 'Douglas, Isle of Man', 'GBP', 'Europe', 'EU', 'IMN'),
(109, 972, 'IL', 'Israel', '₪', 'Jerusalem', 'ILS', 'Asia', 'AS', 'ISR'),
(110, 39, 'IT', 'Italy', '€', 'Rome', 'EUR', 'Europe', 'EU', 'ITA'),
(111, 1876, 'JM', 'Jamaica', 'J$', 'Kingston', 'JMD', 'North America', 'NA', 'JAM'),
(112, 81, 'JP', 'Japan', '¥', 'Tokyo', 'JPY', 'Asia', 'AS', 'JPN'),
(113, 44, 'JE', 'Jersey', '£', 'Saint Helier', 'GBP', 'Europe', 'EU', 'JEY'),
(114, 962, 'JO', 'Jordan', 'ا.د', 'Amman', 'JOD', 'Asia', 'AS', 'JOR'),
(115, 7, 'KZ', 'Kazakhstan', 'лв', 'Astana', 'KZT', 'Asia', 'AS', 'KAZ'),
(116, 254, 'KE', 'Kenya', 'KSh', 'Nairobi', 'KES', 'Africa', 'AF', 'KEN'),
(117, 686, 'KI', 'Kiribati', '$', 'Tarawa', 'AUD', 'Oceania', 'OC', 'KIR'),
(118, 850, 'KP', 'Korea, Democratic People\'s Republic of', '₩', 'Pyongyang', 'KPW', 'Asia', 'AS', 'PRK'),
(119, 82, 'KR', 'Korea, Republic of', '₩', 'Seoul', 'KRW', 'Asia', 'AS', 'KOR'),
(120, 381, 'XK', 'Kosovo', '€', 'Pristina', 'EUR', 'Europe', 'EU', 'XKX'),
(121, 965, 'KW', 'Kuwait', 'ك.د', 'Kuwait City', 'KWD', 'Asia', 'AS', 'KWT'),
(122, 996, 'KG', 'Kyrgyzstan', 'лв', 'Bishkek', 'KGS', 'Asia', 'AS', 'KGZ'),
(123, 856, 'LA', 'Lao People\'s Democratic Republic', '₭', 'Vientiane', 'LAK', 'Asia', 'AS', 'LAO'),
(124, 371, 'LV', 'Latvia', '€', 'Riga', 'EUR', 'Europe', 'EU', 'LVA'),
(125, 961, 'LB', 'Lebanon', '£', 'Beirut', 'LBP', 'Asia', 'AS', 'LBN'),
(126, 266, 'LS', 'Lesotho', 'L', 'Maseru', 'LSL', 'Africa', 'AF', 'LSO'),
(127, 231, 'LR', 'Liberia', '$', 'Monrovia', 'LRD', 'Africa', 'AF', 'LBR'),
(128, 218, 'LY', 'Libyan Arab Jamahiriya', 'د.ل', 'Tripolis', 'LYD', 'Africa', 'AF', 'LBY'),
(129, 423, 'LI', 'Liechtenstein', 'CHf', 'Vaduz', 'CHF', 'Europe', 'EU', 'LIE'),
(130, 370, 'LT', 'Lithuania', '€', 'Vilnius', 'EUR', 'Europe', 'EU', 'LTU'),
(131, 352, 'LU', 'Luxembourg', '€', 'Luxembourg', 'EUR', 'Europe', 'EU', 'LUX'),
(132, 853, 'MO', 'Macao', '$', 'Macao', 'MOP', 'Asia', 'AS', 'MAC'),
(133, 389, 'MK', 'Macedonia, the Former Yugoslav Republic of', 'ден', 'Skopje', 'MKD', 'Europe', 'EU', 'MKD'),
(134, 261, 'MG', 'Madagascar', 'Ar', 'Antananarivo', 'MGA', 'Africa', 'AF', 'MDG'),
(135, 265, 'MW', 'Malawi', 'MK', 'Lilongwe', 'MWK', 'Africa', 'AF', 'MWI'),
(136, 60, 'MY', 'Malaysia', 'RM', 'Kuala Lumpur', 'MYR', 'Asia', 'AS', 'MYS'),
(137, 960, 'MV', 'Maldives', 'Rf', 'Male', 'MVR', 'Asia', 'AS', 'MDV'),
(138, 223, 'ML', 'Mali', 'CFA', 'Bamako', 'XOF', 'Africa', 'AF', 'MLI'),
(139, 356, 'MT', 'Malta', '€', 'Valletta', 'EUR', 'Europe', 'EU', 'MLT'),
(140, 692, 'MH', 'Marshall Islands', '$', 'Majuro', 'USD', 'Oceania', 'OC', 'MHL'),
(141, 596, 'MQ', 'Martinique', '€', 'Fort-de-France', 'EUR', 'North America', 'NA', 'MTQ'),
(142, 222, 'MR', 'Mauritania', 'MRU', 'Nouakchott', 'MRO', 'Africa', 'AF', 'MRT'),
(143, 230, 'MU', 'Mauritius', '₨', 'Port Louis', 'MUR', 'Africa', 'AF', 'MUS'),
(144, 269, 'YT', 'Mayotte', '€', 'Mamoudzou', 'EUR', 'Africa', 'AF', 'MYT'),
(145, 52, 'MX', 'Mexico', '$', 'Mexico City', 'MXN', 'North America', 'NA', 'MEX'),
(146, 691, 'FM', 'Micronesia, Federated States of', '$', 'Palikir', 'USD', 'Oceania', 'OC', 'FSM'),
(147, 373, 'MD', 'Moldova, Republic of', 'L', 'Chisinau', 'MDL', 'Europe', 'EU', 'MDA'),
(148, 377, 'MC', 'Monaco', '€', 'Monaco', 'EUR', 'Europe', 'EU', 'MCO'),
(149, 976, 'MN', 'Mongolia', '₮', 'Ulan Bator', 'MNT', 'Asia', 'AS', 'MNG'),
(150, 382, 'ME', 'Montenegro', '€', 'Podgorica', 'EUR', 'Europe', 'EU', 'MNE'),
(151, 1664, 'MS', 'Montserrat', '$', 'Plymouth', 'XCD', 'North America', 'NA', 'MSR'),
(152, 212, 'MA', 'Morocco', 'DH', 'Rabat', 'MAD', 'Africa', 'AF', 'MAR'),
(153, 258, 'MZ', 'Mozambique', 'MT', 'Maputo', 'MZN', 'Africa', 'AF', 'MOZ'),
(154, 95, 'MM', 'Myanmar', 'K', 'Nay Pyi Taw', 'MMK', 'Asia', 'AS', 'MMR'),
(155, 264, 'NA', 'Namibia', '$', 'Windhoek', 'NAD', 'Africa', 'AF', 'NAM'),
(156, 674, 'NR', 'Nauru', '$', 'Yaren', 'AUD', 'Oceania', 'OC', 'NRU'),
(157, 977, 'NP', 'Nepal', '₨', 'Kathmandu', 'NPR', 'Asia', 'AS', 'NPL'),
(158, 31, 'NL', 'Netherlands', '€', 'Amsterdam', 'EUR', 'Europe', 'EU', 'NLD'),
(159, 599, 'AN', 'Netherlands Antilles', 'NAf', 'Willemstad', 'ANG', 'North America', 'NA', 'ANT'),
(160, 687, 'NC', 'New Caledonia', '₣', 'Noumea', 'XPF', 'Oceania', 'OC', 'NCL'),
(161, 64, 'NZ', 'New Zealand', '$', 'Wellington', 'NZD', 'Oceania', 'OC', 'NZL'),
(162, 505, 'NI', 'Nicaragua', 'C$', 'Managua', 'NIO', 'North America', 'NA', 'NIC'),
(163, 227, 'NE', 'Niger', 'CFA', 'Niamey', 'XOF', 'Africa', 'AF', 'NER'),
(164, 234, 'NG', 'Nigeria', '₦', 'Abuja', 'NGN', 'Africa', 'AF', 'NGA'),
(165, 683, 'NU', 'Niue', '$', 'Alofi', 'NZD', 'Oceania', 'OC', 'NIU'),
(166, 672, 'NF', 'Norfolk Island', '$', 'Kingston', 'AUD', 'Oceania', 'OC', 'NFK'),
(167, 1670, 'MP', 'Northern Mariana Islands', '$', 'Saipan', 'USD', 'Oceania', 'OC', 'MNP'),
(168, 47, 'NO', 'Norway', 'kr', 'Oslo', 'NOK', 'Europe', 'EU', 'NOR'),
(169, 968, 'OM', 'Oman', '.ع.ر', 'Muscat', 'OMR', 'Asia', 'AS', 'OMN'),
(170, 92, 'PK', 'Pakistan', '₨', 'Islamabad', 'PKR', 'Asia', 'AS', 'PAK'),
(171, 680, 'PW', 'Palau', '$', 'Melekeok', 'USD', 'Oceania', 'OC', 'PLW'),
(172, 970, 'PS', 'Palestinian Territory, Occupied', '₪', 'East Jerusalem', 'ILS', 'Asia', 'AS', 'PSE'),
(173, 507, 'PA', 'Panama', 'B/.', 'Panama City', 'PAB', 'North America', 'NA', 'PAN'),
(174, 675, 'PG', 'Papua New Guinea', 'K', 'Port Moresby', 'PGK', 'Oceania', 'OC', 'PNG'),
(175, 595, 'PY', 'Paraguay', '₲', 'Asuncion', 'PYG', 'South America', 'SA', 'PRY'),
(176, 51, 'PE', 'Peru', 'S/.', 'Lima', 'PEN', 'South America', 'SA', 'PER'),
(177, 63, 'PH', 'Philippines', '₱', 'Manila', 'PHP', 'Asia', 'AS', 'PHL'),
(178, 64, 'PN', 'Pitcairn', '$', 'Adamstown', 'NZD', 'Oceania', 'OC', 'PCN'),
(179, 48, 'PL', 'Poland', 'zł', 'Warsaw', 'PLN', 'Europe', 'EU', 'POL'),
(180, 351, 'PT', 'Portugal', '€', 'Lisbon', 'EUR', 'Europe', 'EU', 'PRT'),
(181, 1787, 'PR', 'Puerto Rico', '$', 'San Juan', 'USD', 'North America', 'NA', 'PRI'),
(182, 974, 'QA', 'Qatar', 'ق.ر', 'Doha', 'QAR', 'Asia', 'AS', 'QAT'),
(183, 262, 'RE', 'Reunion', '€', 'Saint-Denis', 'EUR', 'Africa', 'AF', 'REU'),
(184, 40, 'RO', 'Romania', 'lei', 'Bucharest', 'RON', 'Europe', 'EU', 'ROM'),
(185, 70, 'RU', 'Russian Federation', '₽', 'Moscow', 'RUB', 'Asia', 'AS', 'RUS'),
(186, 250, 'RW', 'Rwanda', 'FRw', 'Kigali', 'RWF', 'Africa', 'AF', 'RWA'),
(187, 590, 'BL', 'Saint Barthelemy', '€', 'Gustavia', 'EUR', 'North America', 'NA', 'BLM'),
(188, 290, 'SH', 'Saint Helena', '£', 'Jamestown', 'SHP', 'Africa', 'AF', 'SHN'),
(189, 1869, 'KN', 'Saint Kitts and Nevis', '$', 'Basseterre', 'XCD', 'North America', 'NA', 'KNA'),
(190, 1758, 'LC', 'Saint Lucia', '$', 'Castries', 'XCD', 'North America', 'NA', 'LCA'),
(191, 590, 'MF', 'Saint Martin', '€', 'Marigot', 'EUR', 'North America', 'NA', 'MAF'),
(192, 508, 'PM', 'Saint Pierre and Miquelon', '€', 'Saint-Pierre', 'EUR', 'North America', 'NA', 'SPM'),
(193, 1784, 'VC', 'Saint Vincent and the Grenadines', '$', 'Kingstown', 'XCD', 'North America', 'NA', 'VCT'),
(194, 684, 'WS', 'Samoa', 'SAT', 'Apia', 'WST', 'Oceania', 'OC', 'WSM'),
(195, 378, 'SM', 'San Marino', '€', 'San Marino', 'EUR', 'Europe', 'EU', 'SMR'),
(196, 239, 'ST', 'Sao Tome and Principe', 'Db', 'Sao Tome', 'STD', 'Africa', 'AF', 'STP'),
(197, 966, 'SA', 'Saudi Arabia', '﷼', 'Riyadh', 'SAR', 'Asia', 'AS', 'SAU'),
(198, 221, 'SN', 'Senegal', 'CFA', 'Dakar', 'XOF', 'Africa', 'AF', 'SEN'),
(199, 381, 'RS', 'Serbia', 'din', 'Belgrade', 'RSD', 'Europe', 'EU', 'SRB'),
(200, 381, 'CS', 'Serbia and Montenegro', 'din', 'Belgrade', 'RSD', 'Europe', 'EU', 'SCG'),
(201, 248, 'SC', 'Seychelles', 'SRe', 'Victoria', 'SCR', 'Africa', 'AF', 'SYC'),
(202, 232, 'SL', 'Sierra Leone', 'Le', 'Freetown', 'SLL', 'Africa', 'AF', 'SLE'),
(203, 65, 'SG', 'Singapore', '$', 'Singapur', 'SGD', 'Asia', 'AS', 'SGP'),
(204, 1, 'SX', 'Sint Maarten', 'ƒ', 'Philipsburg', 'ANG', 'North America', 'NA', 'SXM'),
(205, 421, 'SK', 'Slovakia', '€', 'Bratislava', 'EUR', 'Europe', 'EU', 'SVK'),
(206, 386, 'SI', 'Slovenia', '€', 'Ljubljana', 'EUR', 'Europe', 'EU', 'SVN'),
(207, 677, 'SB', 'Solomon Islands', 'Si$', 'Honiara', 'SBD', 'Oceania', 'OC', 'SLB'),
(208, 252, 'SO', 'Somalia', 'Sh.so.', 'Mogadishu', 'SOS', 'Africa', 'AF', 'SOM'),
(209, 27, 'ZA', 'South Africa', 'R', 'Pretoria', 'ZAR', 'Africa', 'AF', 'ZAF'),
(210, 500, 'GS', 'South Georgia and the South Sandwich Islands', '£', 'Grytviken', 'GBP', 'Antarctica', 'AN', 'SGS'),
(211, 211, 'SS', 'South Sudan', '£', 'Juba', 'SSP', 'Africa', 'AF', 'SSD'),
(212, 34, 'ES', 'Spain', '€', 'Madrid', 'EUR', 'Europe', 'EU', 'ESP'),
(213, 94, 'LK', 'Sri Lanka', 'Rs', 'Colombo', 'LKR', 'Asia', 'AS', 'LKA'),
(214, 249, 'SD', 'Sudan', '.س.ج', 'Khartoum', 'SDG', 'Africa', 'AF', 'SDN'),
(215, 597, 'SR', 'Suriname', '$', 'Paramaribo', 'SRD', 'South America', 'SA', 'SUR'),
(216, 47, 'SJ', 'Svalbard and Jan Mayen', 'kr', 'Longyearbyen', 'NOK', 'Europe', 'EU', 'SJM'),
(217, 268, 'SZ', 'Swaziland', 'E', 'Mbabane', 'SZL', 'Africa', 'AF', 'SWZ'),
(218, 46, 'SE', 'Sweden', 'kr', 'Stockholm', 'SEK', 'Europe', 'EU', 'SWE'),
(219, 41, 'CH', 'Switzerland', 'CHf', 'Berne', 'CHF', 'Europe', 'EU', 'CHE'),
(220, 963, 'SY', 'Syrian Arab Republic', 'LS', 'Damascus', 'SYP', 'Asia', 'AS', 'SYR'),
(221, 886, 'TW', 'Taiwan, Province of China', '$', 'Taipei', 'TWD', 'Asia', 'AS', 'TWN'),
(222, 992, 'TJ', 'Tajikistan', 'SM', 'Dushanbe', 'TJS', 'Asia', 'AS', 'TJK'),
(223, 255, 'TZ', 'Tanzania, United Republic of', 'TSh', 'Dodoma', 'TZS', 'Africa', 'AF', 'TZA'),
(224, 66, 'TH', 'Thailand', '฿', 'Bangkok', 'THB', 'Asia', 'AS', 'THA'),
(225, 670, 'TL', 'Timor-Leste', '$', 'Dili', 'USD', 'Asia', 'AS', 'TLS'),
(226, 228, 'TG', 'Togo', 'CFA', 'Lome', 'XOF', 'Africa', 'AF', 'TGO'),
(227, 690, 'TK', 'Tokelau', '$', '', 'NZD', 'Oceania', 'OC', 'TKL'),
(228, 676, 'TO', 'Tonga', '$', 'Nuku\'alofa', 'TOP', 'Oceania', 'OC', 'TON'),
(229, 1868, 'TT', 'Trinidad and Tobago', '$', 'Port of Spain', 'TTD', 'North America', 'NA', 'TTO'),
(230, 216, 'TN', 'Tunisia', 'ت.د', 'Tunis', 'TND', 'Africa', 'AF', 'TUN'),
(231, 90, 'TR', 'Turkey', '₺', 'Ankara', 'TRY', 'Asia', 'AS', 'TUR'),
(232, 7370, 'TM', 'Turkmenistan', 'T', 'Ashgabat', 'TMT', 'Asia', 'AS', 'TKM'),
(233, 1649, 'TC', 'Turks and Caicos Islands', '$', 'Cockburn Town', 'USD', 'North America', 'NA', 'TCA'),
(234, 688, 'TV', 'Tuvalu', '$', 'Funafuti', 'AUD', 'Oceania', 'OC', 'TUV'),
(235, 256, 'UG', 'Uganda', 'USh', 'Kampala', 'UGX', 'Africa', 'AF', 'UGA'),
(236, 380, 'UA', 'Ukraine', '₴', 'Kiev', 'UAH', 'Europe', 'EU', 'UKR'),
(237, 971, 'AE', 'United Arab Emirates', 'إ.د', 'Abu Dhabi', 'AED', 'Asia', 'AS', 'ARE'),
(238, 44, 'GB', 'United Kingdom', '£', 'London', 'GBP', 'Europe', 'EU', 'GBR'),
(239, 1, 'US', 'United States', '$', 'Washington', 'USD', 'North America', 'NA', 'USA'),
(240, 1, 'UM', 'United States Minor Outlying Islands', '$', '', 'USD', 'North America', 'NA', 'UMI'),
(241, 598, 'UY', 'Uruguay', '$', 'Montevideo', 'UYU', 'South America', 'SA', 'URY'),
(242, 998, 'UZ', 'Uzbekistan', 'лв', 'Tashkent', 'UZS', 'Asia', 'AS', 'UZB'),
(243, 678, 'VU', 'Vanuatu', 'VT', 'Port Vila', 'VUV', 'Oceania', 'OC', 'VUT'),
(244, 58, 'VE', 'Venezuela', 'Bs', 'Caracas', 'VEF', 'South America', 'SA', 'VEN'),
(245, 84, 'VN', 'Viet Nam', '₫', 'Hanoi', 'VND', 'Asia', 'AS', 'VNM'),
(246, 1284, 'VG', 'Virgin Islands, British', '$', 'Road Town', 'USD', 'North America', 'NA', 'VGB'),
(247, 1340, 'VI', 'Virgin Islands, U.s.', '$', 'Charlotte Amalie', 'USD', 'North America', 'NA', 'VIR'),
(248, 681, 'WF', 'Wallis and Futuna', '₣', 'Mata Utu', 'XPF', 'Oceania', 'OC', 'WLF'),
(249, 212, 'EH', 'Western Sahara', 'MAD', 'El-Aaiun', 'MAD', 'Africa', 'AF', 'ESH'),
(250, 967, 'YE', 'Yemen', '﷼', 'Sanaa', 'YER', 'Asia', 'AS', 'YEM'),
(251, 260, 'ZM', 'Zambia', 'ZK', 'Lusaka', 'ZMW', 'Africa', 'AF', 'ZMB'),
(252, 263, 'ZW', 'Zimbabwe', '$', 'Harare', 'ZWL', 'Africa', 'AF', 'ZWE');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_customize_type`
--

DROP TABLE IF EXISTS `phs_cod_customize_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_customize_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_customize_type`
--

INSERT INTO `phs_cod_customize_type` (`id`, `name`, `rem`) VALUES
(1, 'Number', NULL),
(2, 'Varchar', NULL),
(3, 'Date', NULL),
(4, 'Time', NULL),
(5, 'Datetime', NULL),
(6, 'Select', NULL),
(7, 'Autocomplete', NULL),
(8, 'PhsCode', NULL),
(9, 'CpyCode', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_dbcr`
--

DROP TABLE IF EXISTS `phs_cod_dbcr`;
CREATE TABLE IF NOT EXISTS `phs_cod_dbcr` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_dbcr`
--

INSERT INTO `phs_cod_dbcr` (`id`, `name`, `rem`) VALUES
(1, 'Debit', NULL),
(2, 'Credit', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_discount_type`
--

DROP TABLE IF EXISTS `phs_cod_discount_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_discount_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_discount_type`
--

INSERT INTO `phs_cod_discount_type` (`id`, `name`, `rem`) VALUES
(0, 'None', NULL),
(1, 'Discount.Amount', NULL),
(2, 'Discount.Percent', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_domain`
--

DROP TABLE IF EXISTS `phs_cod_domain`;
CREATE TABLE IF NOT EXISTS `phs_cod_domain` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_domain`
--

INSERT INTO `phs_cod_domain` (`id`, `name`, `rem`) VALUES
(0, 'All', 'ضمن مجموعة الصلاحيات'),
(1, 'Owner Data', 'بياناته فقط');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_element_type`
--

DROP TABLE IF EXISTS `phs_cod_element_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_element_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_element_type`
--

INSERT INTO `phs_cod_element_type` (`id`, `name`, `rem`) VALUES
(1, 'Item', NULL),
(2, 'Service', NULL),
(3, 'Account', NULL),
(4, 'Contact', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_gender`
--

DROP TABLE IF EXISTS `phs_cod_gender`;
CREATE TABLE IF NOT EXISTS `phs_cod_gender` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_gender`
--

INSERT INTO `phs_cod_gender` (`id`, `name`, `rem`) VALUES
(1, 'Male', NULL),
(2, 'Female', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_idtype`
--

DROP TABLE IF EXISTS `phs_cod_idtype`;
CREATE TABLE IF NOT EXISTS `phs_cod_idtype` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_idtype`
--

INSERT INTO `phs_cod_idtype` (`id`, `name`, `rem`) VALUES
(1, 'Id', NULL),
(2, 'Passport', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_languages`
--

DROP TABLE IF EXISTS `phs_cod_languages`;
CREATE TABLE IF NOT EXISTS `phs_cod_languages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(49) DEFAULT NULL,
  `short` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_languages`
--

INSERT INTO `phs_cod_languages` (`id`, `name`, `short`) VALUES
(1, 'English', 'en'),
(2, 'Afar', 'aa'),
(3, 'Abkhazian', 'ab'),
(4, 'Afrikaans', 'af'),
(5, 'Amharic', 'am'),
(6, 'Arabic', 'ar'),
(7, 'Assamese', 'as'),
(8, 'Aymara', 'ay'),
(9, 'Azerbaijani', 'az'),
(10, 'Bashkir', 'ba'),
(11, 'Belarusian', 'be'),
(12, 'Bulgarian', 'bg'),
(13, 'Bihari', 'bh'),
(14, 'Bislama', 'bi'),
(15, 'Bengali/Bangla', 'bn'),
(16, 'Tibetan', 'bo'),
(17, 'Breton', 'br'),
(18, 'Catalan', 'ca'),
(19, 'Corsican', 'co'),
(20, 'Czech', 'cs'),
(21, 'Welsh', 'cy'),
(22, 'Danish', 'da'),
(23, 'German', 'de'),
(24, 'Bhutani', 'dz'),
(25, 'Greek', 'el'),
(26, 'Esperanto', 'eo'),
(27, 'Spanish', 'es'),
(28, 'Estonian', 'et'),
(29, 'Basque', 'eu'),
(30, 'Persian', 'fa'),
(31, 'Finnish', 'fi'),
(32, 'Fiji', 'fj'),
(33, 'Faeroese', 'fo'),
(34, 'French', 'fr'),
(35, 'Frisian', 'fy'),
(36, 'Irish', 'ga'),
(37, 'Scots/Gaelic', 'gd'),
(38, 'Galician', 'gl'),
(39, 'Guarani', 'gn'),
(40, 'Gujarati', 'gu'),
(41, 'Hausa', 'ha'),
(42, 'Hindi', 'hi'),
(43, 'Croatian', 'hr'),
(44, 'Hungarian', 'hu'),
(45, 'Armenian', 'hy'),
(46, 'Interlingua', 'ia'),
(47, 'Interlingue', 'ie'),
(48, 'Inupiak', 'ik'),
(49, 'Indonesian', 'in'),
(50, 'Icelandic', 'is'),
(51, 'Italian', 'it'),
(52, 'Hebrew', 'iw'),
(53, 'Japanese', 'ja'),
(54, 'Yiddish', 'ji'),
(55, 'Javanese', 'jw'),
(56, 'Georgian', 'ka'),
(57, 'Kazakh', 'kk'),
(58, 'Greenlandic', 'kl'),
(59, 'Cambodian', 'km'),
(60, 'Kannada', 'kn'),
(61, 'Korean', 'ko'),
(62, 'Kashmiri', 'ks'),
(63, 'Kurdish', 'ku'),
(64, 'Kirghiz', 'ky'),
(65, 'Latin', 'la'),
(66, 'Lingala', 'ln'),
(67, 'Laothian', 'lo'),
(68, 'Lithuanian', 'lt'),
(69, 'Latvian/Lettish', 'lv'),
(70, 'Malagasy', 'mg'),
(71, 'Maori', 'mi'),
(72, 'Macedonian', 'mk'),
(73, 'Malayalam', 'ml'),
(74, 'Mongolian', 'mn'),
(75, 'Moldavian', 'mo'),
(76, 'Marathi', 'mr'),
(77, 'Malay', 'ms'),
(78, 'Maltese', 'mt'),
(79, 'Burmese', 'my'),
(80, 'Nauru', 'na'),
(81, 'Nepali', 'ne'),
(82, 'Dutch', 'nl'),
(83, 'Norwegian', 'no'),
(84, 'Occitan', 'oc'),
(85, '(Afan)/Oromoor/Oriya', 'om'),
(86, 'Punjabi', 'pa'),
(87, 'Polish', 'pl'),
(88, 'Pashto/Pushto', 'ps'),
(89, 'Portuguese', 'pt'),
(90, 'Quechua', 'qu'),
(91, 'Rhaeto-Romance', 'rm'),
(92, 'Kirundi', 'rn'),
(93, 'Romanian', 'ro'),
(94, 'Russian', 'ru'),
(95, 'Kinyarwanda', 'rw'),
(96, 'Sanskrit', 'sa'),
(97, 'Sindhi', 'sd'),
(98, 'Sangro', 'sg'),
(99, 'Serbo-Croatian', 'sh'),
(100, 'Singhalese', 'si'),
(101, 'Slovak', 'sk'),
(102, 'Slovenian', 'sl'),
(103, 'Samoan', 'sm'),
(104, 'Shona', 'sn'),
(105, 'Somali', 'so'),
(106, 'Albanian', 'sq'),
(107, 'Serbian', 'sr'),
(108, 'Siswati', 'ss'),
(109, 'Sesotho', 'st'),
(110, 'Sundanese', 'su'),
(111, 'Swedish', 'sv'),
(112, 'Swahili', 'sw'),
(113, 'Tamil', 'ta'),
(114, 'Telugu', 'te'),
(115, 'Tajik', 'tg'),
(116, 'Thai', 'th'),
(117, 'Tigrinya', 'ti'),
(118, 'Turkmen', 'tk'),
(119, 'Tagalog', 'tl'),
(120, 'Setswana', 'tn'),
(121, 'Tonga', 'to'),
(122, 'Turkish', 'tr'),
(123, 'Tsonga', 'ts'),
(124, 'Tatar', 'tt'),
(125, 'Twi', 'tw'),
(126, 'Ukrainian', 'uk'),
(127, 'Urdu', 'ur'),
(128, 'Uzbek', 'uz'),
(129, 'Vietnamese', 'vi'),
(130, 'Volapuk', 'vo'),
(131, 'Wolof', 'wo'),
(132, 'Xhosa', 'xh'),
(133, 'Yoruba', 'yo'),
(134, 'Chinese', 'zh'),
(135, 'Zulu', 'zu');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_martial`
--

DROP TABLE IF EXISTS `phs_cod_martial`;
CREATE TABLE IF NOT EXISTS `phs_cod_martial` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'الاسم',
  `rem` varchar(250) DEFAULT NULL COMMENT 'ملاحظات',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_martial`
--

INSERT INTO `phs_cod_martial` (`id`, `name`, `rem`) VALUES
(1, 'Single', NULL),
(2, 'Married', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_military`
--

DROP TABLE IF EXISTS `phs_cod_military`;
CREATE TABLE IF NOT EXISTS `phs_cod_military` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'الاسم',
  `rem` varchar(250) DEFAULT NULL COMMENT 'ملاحظات',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_military`
--

INSERT INTO `phs_cod_military` (`id`, `name`, `rem`) VALUES
(1, 'None', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_mst_status`
--

DROP TABLE IF EXISTS `phs_cod_mst_status`;
CREATE TABLE IF NOT EXISTS `phs_cod_mst_status` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_mst_status`
--

INSERT INTO `phs_cod_mst_status` (`id`, `name`, `rem`) VALUES
(1, 'New', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_nationality`
--

DROP TABLE IF EXISTS `phs_cod_nationality`;
CREATE TABLE IF NOT EXISTS `phs_cod_nationality` (
  `num_code` smallint(6) NOT NULL DEFAULT '0',
  `alpha_2_code` varchar(2) DEFAULT NULL,
  `alpha_3_code` varchar(3) DEFAULT NULL,
  `en_short_name` varchar(52) DEFAULT NULL,
  `nationality` varchar(39) DEFAULT NULL,
  PRIMARY KEY (`num_code`),
  UNIQUE KEY `alpha_2_code` (`alpha_2_code`),
  UNIQUE KEY `alpha_3_code` (`alpha_3_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_nationality`
--

INSERT INTO `phs_cod_nationality` (`num_code`, `alpha_2_code`, `alpha_3_code`, `en_short_name`, `nationality`) VALUES
(4, 'AF', 'AFG', 'Afghanistan', 'Afghan'),
(8, 'AL', 'ALB', 'Albania', 'Albanian'),
(10, 'AQ', 'ATA', 'Antarctica', 'Antarctic'),
(12, 'DZ', 'DZA', 'Algeria', 'Algerian'),
(16, 'AS', 'ASM', 'American Samoa', 'American Samoan'),
(20, 'AD', 'AND', 'Andorra', 'Andorran'),
(24, 'AO', 'AGO', 'Angola', 'Angolan'),
(28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antiguan or Barbudan'),
(31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbaijani, Azeri'),
(32, 'AR', 'ARG', 'Argentina', 'Argentine'),
(36, 'AU', 'AUS', 'Australia', 'Australian'),
(40, 'AT', 'AUT', 'Austria', 'Austrian'),
(44, 'BS', 'BHS', 'Bahamas', 'Bahamian'),
(48, 'BH', 'BHR', 'Bahrain', 'Bahraini'),
(50, 'BD', 'BGD', 'Bangladesh', 'Bangladeshi'),
(51, 'AM', 'ARM', 'Armenia', 'Armenian'),
(52, 'BB', 'BRB', 'Barbados', 'Barbadian'),
(56, 'BE', 'BEL', 'Belgium', 'Belgian'),
(60, 'BM', 'BMU', 'Bermuda', 'Bermudian, Bermudan'),
(64, 'BT', 'BTN', 'Bhutan', 'Bhutanese'),
(68, 'BO', 'BOL', 'Bolivia (Plurinational State of)', 'Bolivian'),
(70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnian or Herzegovinian'),
(72, 'BW', 'BWA', 'Botswana', 'Motswana, Botswanan'),
(74, 'BV', 'BVT', 'Bouvet Island', 'Bouvet Island'),
(76, 'BR', 'BRA', 'Brazil', 'Brazilian'),
(84, 'BZ', 'BLZ', 'Belize', 'Belizean'),
(86, 'IO', 'IOT', 'British Indian Ocean Territory', 'BIOT'),
(90, 'SB', 'SLB', 'Solomon Islands', 'Solomon Island'),
(92, 'VG', 'VGB', 'Virgin Islands (British)', 'British Virgin Island'),
(96, 'BN', 'BRN', 'Brunei Darussalam', 'Bruneian'),
(100, 'BG', 'BGR', 'Bulgaria', 'Bulgarian'),
(104, 'MM', 'MMR', 'Myanmar', 'Burmese'),
(108, 'BI', 'BDI', 'Burundi', 'Burundian'),
(112, 'BY', 'BLR', 'Belarus', 'Belarusian'),
(116, 'KH', 'KHM', 'Cambodia', 'Cambodian'),
(120, 'CM', 'CMR', 'Cameroon', 'Cameroonian'),
(124, 'CA', 'CAN', 'Canada', 'Canadian'),
(132, 'CV', 'CPV', 'Cabo Verde', 'Cabo Verdean'),
(136, 'KY', 'CYM', 'Cayman Islands', 'Caymanian'),
(140, 'CF', 'CAF', 'Central African Republic', 'Central African'),
(144, 'LK', 'LKA', 'Sri Lanka', 'Sri Lankan'),
(148, 'TD', 'TCD', 'Chad', 'Chadian'),
(152, 'CL', 'CHL', 'Chile', 'Chilean'),
(156, 'CN', 'CHN', 'China', 'Chinese'),
(158, 'TW', 'TWN', 'Taiwan, Province of China', 'Chinese, Taiwanese'),
(162, 'CX', 'CXR', 'Christmas Island', 'Christmas Island'),
(166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Cocos Island'),
(170, 'CO', 'COL', 'Colombia', 'Colombian'),
(174, 'KM', 'COM', 'Comoros', 'Comoran, Comorian'),
(175, 'YT', 'MYT', 'Mayotte', 'Mahoran'),
(178, 'CG', 'COG', 'Congo (Republic of the)', 'Congolese'),
(180, 'CD', 'COD', 'Congo (Democratic Republic of the)', 'Congolese'),
(184, 'CK', 'COK', 'Cook Islands', 'Cook Island'),
(188, 'CR', 'CRI', 'Costa Rica', 'Costa Rican'),
(191, 'HR', 'HRV', 'Croatia', 'Croatian'),
(192, 'CU', 'CUB', 'Cuba', 'Cuban'),
(196, 'CY', 'CYP', 'Cyprus', 'Cypriot'),
(203, 'CZ', 'CZE', 'Czech Republic', 'Czech'),
(204, 'BJ', 'BEN', 'Benin', 'Beninese, Beninois'),
(208, 'DK', 'DNK', 'Denmark', 'Danish'),
(212, 'DM', 'DMA', 'Dominica', 'Dominican'),
(214, 'DO', 'DOM', 'Dominican Republic', 'Dominican'),
(218, 'EC', 'ECU', 'Ecuador', 'Ecuadorian'),
(222, 'SV', 'SLV', 'El Salvador', 'Salvadoran'),
(226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Equatorial Guinean, Equatoguinean'),
(231, 'ET', 'ETH', 'Ethiopia', 'Ethiopian'),
(232, 'ER', 'ERI', 'Eritrea', 'Eritrean'),
(233, 'EE', 'EST', 'Estonia', 'Estonian'),
(234, 'FO', 'FRO', 'Faroe Islands', 'Faroese'),
(238, 'FK', 'FLK', 'Falkland Islands (Malvinas)', 'Falkland Island'),
(239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'South Georgia or South Sandwich Islands'),
(242, 'FJ', 'FJI', 'Fiji', 'Fijian'),
(246, 'FI', 'FIN', 'Finland', 'Finnish'),
(248, 'AX', 'ALA', 'Åland Islands', 'Åland Island'),
(250, 'FR', 'FRA', 'France', 'French'),
(254, 'GF', 'GUF', 'French Guiana', 'French Guianese'),
(258, 'PF', 'PYF', 'French Polynesia', 'French Polynesian'),
(260, 'TF', 'ATF', 'French Southern Territories', 'French Southern Territories'),
(262, 'DJ', 'DJI', 'Djibouti', 'Djiboutian'),
(266, 'GA', 'GAB', 'Gabon', 'Gabonese'),
(268, 'GE', 'GEO', 'Georgia', 'Georgian'),
(270, 'GM', 'GMB', 'Gambia', 'Gambian'),
(275, 'PS', 'PSE', 'Palestine, State of', 'Palestinian'),
(276, 'DE', 'DEU', 'Germany', 'German'),
(288, 'GH', 'GHA', 'Ghana', 'Ghanaian'),
(292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar'),
(296, 'KI', 'KIR', 'Kiribati', 'I-Kiribati'),
(300, 'GR', 'GRC', 'Greece', 'Greek, Hellenic'),
(304, 'GL', 'GRL', 'Greenland', 'Greenlandic'),
(308, 'GD', 'GRD', 'Grenada', 'Grenadian'),
(312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe'),
(316, 'GU', 'GUM', 'Guam', 'Guamanian, Guambat'),
(320, 'GT', 'GTM', 'Guatemala', 'Guatemalan'),
(324, 'GN', 'GIN', 'Guinea', 'Guinean'),
(328, 'GY', 'GUY', 'Guyana', 'Guyanese'),
(332, 'HT', 'HTI', 'Haiti', 'Haitian'),
(334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Heard Island or McDonald Islands'),
(336, 'VA', 'VAT', 'Vatican City State', 'Vatican'),
(340, 'HN', 'HND', 'Honduras', 'Honduran'),
(344, 'HK', 'HKG', 'Hong Kong', 'Hong Kong, Hong Kongese'),
(348, 'HU', 'HUN', 'Hungary', 'Hungarian, Magyar'),
(352, 'IS', 'ISL', 'Iceland', 'Icelandic'),
(356, 'IN', 'IND', 'India', 'Indian'),
(360, 'ID', 'IDN', 'Indonesia', 'Indonesian'),
(364, 'IR', 'IRN', 'Iran', 'Iranian, Persian'),
(368, 'IQ', 'IRQ', 'Iraq', 'Iraqi'),
(372, 'IE', 'IRL', 'Ireland', 'Irish'),
(376, 'IL', 'ISR', 'Israel', 'Israeli'),
(380, 'IT', 'ITA', 'Italy', 'Italian'),
(384, 'CI', 'CIV', 'Côte d\'Ivoire', 'Ivorian'),
(388, 'JM', 'JAM', 'Jamaica', 'Jamaican'),
(392, 'JP', 'JPN', 'Japan', 'Japanese'),
(398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazakhstani, Kazakh'),
(400, 'JO', 'JOR', 'Jordan', 'Jordanian'),
(404, 'KE', 'KEN', 'Kenya', 'Kenyan'),
(408, 'KP', 'PRK', 'Korea (Democratic People\'s Republic of)', 'North Korean'),
(410, 'KR', 'KOR', 'Korea (Republic of)', 'South Korean'),
(414, 'KW', 'KWT', 'Kuwait', 'Kuwaiti'),
(417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kyrgyzstani, Kyrgyz, Kirgiz, Kirghiz'),
(418, 'LA', 'LAO', 'Lao People\'s Democratic Republic', 'Lao, Laotian'),
(422, 'LB', 'LBN', 'Lebanon', 'Lebanese'),
(426, 'LS', 'LSO', 'Lesotho', 'Basotho'),
(428, 'LV', 'LVA', 'Latvia', 'Latvian'),
(430, 'LR', 'LBR', 'Liberia', 'Liberian'),
(434, 'LY', 'LBY', 'Libya', 'Libyan'),
(438, 'LI', 'LIE', 'Liechtenstein', 'Liechtenstein'),
(440, 'LT', 'LTU', 'Lithuania', 'Lithuanian'),
(442, 'LU', 'LUX', 'Luxembourg', 'Luxembourg, Luxembourgish'),
(446, 'MO', 'MAC', 'Macao', 'Macanese, Chinese'),
(450, 'MG', 'MDG', 'Madagascar', 'Malagasy'),
(454, 'MW', 'MWI', 'Malawi', 'Malawian'),
(458, 'MY', 'MYS', 'Malaysia', 'Malaysian'),
(462, 'MV', 'MDV', 'Maldives', 'Maldivian'),
(466, 'ML', 'MLI', 'Mali', 'Malian, Malinese'),
(470, 'MT', 'MLT', 'Malta', 'Maltese'),
(474, 'MQ', 'MTQ', 'Martinique', 'Martiniquais, Martinican'),
(478, 'MR', 'MRT', 'Mauritania', 'Mauritanian'),
(480, 'MU', 'MUS', 'Mauritius', 'Mauritian'),
(484, 'MX', 'MEX', 'Mexico', 'Mexican'),
(492, 'MC', 'MCO', 'Monaco', 'Monégasque, Monacan'),
(496, 'MN', 'MNG', 'Mongolia', 'Mongolian'),
(498, 'MD', 'MDA', 'Moldova (Republic of)', 'Moldovan'),
(499, 'ME', 'MNE', 'Montenegro', 'Montenegrin'),
(500, 'MS', 'MSR', 'Montserrat', 'Montserratian'),
(504, 'MA', 'MAR', 'Morocco', 'Moroccan'),
(508, 'MZ', 'MOZ', 'Mozambique', 'Mozambican'),
(512, 'OM', 'OMN', 'Oman', 'Omani'),
(516, 'NA', 'NAM', 'Namibia', 'Namibian'),
(520, 'NR', 'NRU', 'Nauru', 'Nauruan'),
(524, 'NP', 'NPL', 'Nepal', 'Nepali, Nepalese'),
(528, 'NL', 'NLD', 'Netherlands', 'Dutch, Netherlandic'),
(531, 'CW', 'CUW', 'Curaçao', 'Curaçaoan'),
(533, 'AW', 'ABW', 'Aruba', 'Aruban'),
(534, 'SX', 'SXM', 'Sint Maarten (Dutch part)', 'Sint Maarten'),
(535, 'BQ', 'BES', 'Bonaire, Sint Eustatius and Saba', 'Bonaire'),
(540, 'NC', 'NCL', 'New Caledonia', 'New Caledonian'),
(548, 'VU', 'VUT', 'Vanuatu', 'Ni-Vanuatu, Vanuatuan'),
(554, 'NZ', 'NZL', 'New Zealand', 'New Zealand, NZ'),
(558, 'NI', 'NIC', 'Nicaragua', 'Nicaraguan'),
(562, 'NE', 'NER', 'Niger', 'Nigerien'),
(566, 'NG', 'NGA', 'Nigeria', 'Nigerian'),
(570, 'NU', 'NIU', 'Niue', 'Niuean'),
(574, 'NF', 'NFK', 'Norfolk Island', 'Norfolk Island'),
(578, 'NO', 'NOR', 'Norway', 'Norwegian'),
(580, 'MP', 'MNP', 'Northern Mariana Islands', 'Northern Marianan'),
(581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'American'),
(583, 'FM', 'FSM', 'Micronesia (Federated States of)', 'Micronesian'),
(584, 'MH', 'MHL', 'Marshall Islands', 'Marshallese'),
(585, 'PW', 'PLW', 'Palau', 'Palauan'),
(586, 'PK', 'PAK', 'Pakistan', 'Pakistani'),
(591, 'PA', 'PAN', 'Panama', 'Panamanian'),
(598, 'PG', 'PNG', 'Papua New Guinea', 'Papua New Guinean, Papuan'),
(600, 'PY', 'PRY', 'Paraguay', 'Paraguayan'),
(604, 'PE', 'PER', 'Peru', 'Peruvian'),
(608, 'PH', 'PHL', 'Philippines', 'Philippine, Filipino'),
(612, 'PN', 'PCN', 'Pitcairn', 'Pitcairn Island'),
(616, 'PL', 'POL', 'Poland', 'Polish'),
(620, 'PT', 'PRT', 'Portugal', 'Portuguese'),
(624, 'GW', 'GNB', 'Guinea-Bissau', 'Bissau-Guinean'),
(626, 'TL', 'TLS', 'Timor-Leste', 'Timorese'),
(630, 'PR', 'PRI', 'Puerto Rico', 'Puerto Rican'),
(634, 'QA', 'QAT', 'Qatar', 'Qatari'),
(638, 'RE', 'REU', 'Réunion', 'Réunionese, Réunionnais'),
(642, 'RO', 'ROU', 'Romania', 'Romanian'),
(643, 'RU', 'RUS', 'Russian Federation', 'Russian'),
(646, 'RW', 'RWA', 'Rwanda', 'Rwandan'),
(652, 'BL', 'BLM', 'Saint Barthélemy', 'Barthélemois'),
(654, 'SH', 'SHN', 'Saint Helena, Ascension and Tristan da Cunha', 'Saint Helenian'),
(659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Kittitian or Nevisian'),
(660, 'AI', 'AIA', 'Anguilla', 'Anguillan'),
(662, 'LC', 'LCA', 'Saint Lucia', 'Saint Lucian'),
(663, 'MF', 'MAF', 'Saint Martin (French part)', 'Saint-Martinoise'),
(666, 'PM', 'SPM', 'Saint Pierre and Miquelon', 'Saint-Pierrais or Miquelonnais'),
(670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint Vincentian, Vincentian'),
(674, 'SM', 'SMR', 'San Marino', 'Sammarinese'),
(678, 'ST', 'STP', 'Sao Tome and Principe', 'São Toméan'),
(682, 'SA', 'SAU', 'Saudi Arabia', 'Saudi, Saudi Arabian'),
(686, 'SN', 'SEN', 'Senegal', 'Senegalese'),
(688, 'RS', 'SRB', 'Serbia', 'Serbian'),
(690, 'SC', 'SYC', 'Seychelles', 'Seychellois'),
(694, 'SL', 'SLE', 'Sierra Leone', 'Sierra Leonean'),
(702, 'SG', 'SGP', 'Singapore', 'Singaporean'),
(703, 'SK', 'SVK', 'Slovakia', 'Slovak'),
(704, 'VN', 'VNM', 'Vietnam', 'Vietnamese'),
(705, 'SI', 'SVN', 'Slovenia', 'Slovenian, Slovene'),
(706, 'SO', 'SOM', 'Somalia', 'Somali, Somalian'),
(710, 'ZA', 'ZAF', 'South Africa', 'South African'),
(716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabwean'),
(724, 'ES', 'ESP', 'Spain', 'Spanish'),
(728, 'SS', 'SSD', 'South Sudan', 'South Sudanese'),
(729, 'SD', 'SDN', 'Sudan', 'Sudanese'),
(732, 'EH', 'ESH', 'Western Sahara', 'Sahrawi, Sahrawian, Sahraouian'),
(740, 'SR', 'SUR', 'Suriname', 'Surinamese'),
(744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard'),
(748, 'SZ', 'SWZ', 'Swaziland', 'Swazi'),
(752, 'SE', 'SWE', 'Sweden', 'Swedish'),
(756, 'CH', 'CHE', 'Switzerland', 'Swiss'),
(760, 'SY', 'SYR', 'Syrian Arab Republic', 'Syrian'),
(762, 'TJ', 'TJK', 'Tajikistan', 'Tajikistani'),
(764, 'TH', 'THA', 'Thailand', 'Thai'),
(768, 'TG', 'TGO', 'Togo', 'Togolese'),
(772, 'TK', 'TKL', 'Tokelau', 'Tokelauan'),
(776, 'TO', 'TON', 'Tonga', 'Tongan'),
(780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinidadian or Tobagonian'),
(784, 'AE', 'ARE', 'United Arab Emirates', 'Emirati, Emirian, Emiri'),
(788, 'TN', 'TUN', 'Tunisia', 'Tunisian'),
(792, 'TR', 'TUR', 'Turkey', 'Turkish'),
(795, 'TM', 'TKM', 'Turkmenistan', 'Turkmen'),
(796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Turks and Caicos Island'),
(798, 'TV', 'TUV', 'Tuvalu', 'Tuvaluan'),
(800, 'UG', 'UGA', 'Uganda', 'Ugandan'),
(804, 'UA', 'UKR', 'Ukraine', 'Ukrainian'),
(807, 'MK', 'MKD', 'Macedonia (the former Yugoslav Republic of)', 'Macedonian'),
(818, 'EG', 'EGY', 'Egypt', 'Egyptian'),
(826, 'GB', 'GBR', 'United Kingdom of Great Britain and Northern Ireland', 'British, UK'),
(831, 'GG', 'GGY', 'Guernsey', 'Channel Island'),
(832, 'JE', 'JEY', 'Jersey', 'Channel Island'),
(833, 'IM', 'IMN', 'Isle of Man', 'Manx'),
(834, 'TZ', 'TZA', 'Tanzania, United Republic of', 'Tanzanian'),
(840, 'US', 'USA', 'United States of America', 'American'),
(850, 'VI', 'VIR', 'Virgin Islands (U.S.)', 'U.S. Virgin Island'),
(854, 'BF', 'BFA', 'Burkina Faso', 'Burkinabé'),
(858, 'UY', 'URY', 'Uruguay', 'Uruguayan'),
(860, 'UZ', 'UZB', 'Uzbekistan', 'Uzbekistani, Uzbek'),
(862, 'VE', 'VEN', 'Venezuela (Bolivarian Republic of)', 'Venezuelan'),
(876, 'WF', 'WLF', 'Wallis and Futuna', 'Wallis and Futuna, Wallisian or Futunan'),
(882, 'WS', 'WSM', 'Samoa', 'Samoan'),
(887, 'YE', 'YEM', 'Yemen', 'Yemeni'),
(894, 'ZM', 'ZMB', 'Zambia', 'Zambian');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_payment_type`
--

DROP TABLE IF EXISTS `phs_cod_payment_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_payment_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phs_cod_payment_type`
--

INSERT INTO `phs_cod_payment_type` (`id`, `name`, `rem`) VALUES
(1, 'Cash', NULL),
(2, 'Credit Card', NULL),
(3, 'Bank Transfer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_prog_type`
--

DROP TABLE IF EXISTS `phs_cod_prog_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_prog_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_prog_type`
--

INSERT INTO `phs_cod_prog_type` (`id`, `name`, `rem`) VALUES
(0, 'Menu', NULL),
(1, 'Sub Menu', NULL),
(2, 'Menu Item', NULL),
(3, 'Menu Link', NULL),
(4, 'Top-Bar Item', NULL),
(5, 'Modal', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_shift_type`
--

DROP TABLE IF EXISTS `phs_cod_shift_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_shift_type` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `color` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Color',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_shift_type`
--

INSERT INTO `phs_cod_shift_type` (`id`, `name`, `color`) VALUES
(1, 'Day', 0),
(2, 'Night', 0),
(3, 'Period', 0);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_src`
--

DROP TABLE IF EXISTS `phs_cod_src`;
CREATE TABLE IF NOT EXISTS `phs_cod_src` (
  `id` smallint(6) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_src`
--

INSERT INTO `phs_cod_src` (`id`, `name`, `rem`) VALUES
(0, 'Manual', NULL),
(1, 'Inventory', NULL),
(2, 'Cstomers', NULL);

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
-- Table structure for table `phs_cod_treatment_status`
--

DROP TABLE IF EXISTS `phs_cod_treatment_status`;
CREATE TABLE IF NOT EXISTS `phs_cod_treatment_status` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_treatment_status`
--

INSERT INTO `phs_cod_treatment_status` (`id`, `name`) VALUES
(4, 'Canceled'),
(2, 'Done'),
(3, 'Invoiced'),
(1, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_tree_type`
--

DROP TABLE IF EXISTS `phs_cod_tree_type`;
CREATE TABLE IF NOT EXISTS `phs_cod_tree_type` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_tree_type`
--

INSERT INTO `phs_cod_tree_type` (`id`, `name`, `rem`) VALUES
(1, 'Tree.Head', NULL),
(2, 'Tree.Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_vat`
--

DROP TABLE IF EXISTS `phs_cod_vat`;
CREATE TABLE IF NOT EXISTS `phs_cod_vat` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_vat`
--

INSERT INTO `phs_cod_vat` (`id`, `name`, `rem`) VALUES
(0, 'None', NULL),
(1, 'Percent', NULL),
(2, 'Amount', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_visa`
--

DROP TABLE IF EXISTS `phs_cod_visa`;
CREATE TABLE IF NOT EXISTS `phs_cod_visa` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_visa`
--

INSERT INTO `phs_cod_visa` (`id`, `name`, `rem`) VALUES
(1, 'Local', NULL),
(2, 'Resident', NULL),
(3, 'Visitor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_warranty`
--

DROP TABLE IF EXISTS `phs_cod_warranty`;
CREATE TABLE IF NOT EXISTS `phs_cod_warranty` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_warranty`
--

INSERT INTO `phs_cod_warranty` (`id`, `name`, `rem`) VALUES
(0, 'out of Warranty', NULL),
(1, 'in Warranty', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_wpstatus`
--

DROP TABLE IF EXISTS `phs_cod_wpstatus`;
CREATE TABLE IF NOT EXISTS `phs_cod_wpstatus` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_wpstatus`
--

INSERT INTO `phs_cod_wpstatus` (`id`, `name`, `rem`) VALUES
(1, 'Open', NULL),
(2, 'Close Pending', NULL),
(3, 'Closed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_cod_yes_no`
--

DROP TABLE IF EXISTS `phs_cod_yes_no`;
CREATE TABLE IF NOT EXISTS `phs_cod_yes_no` (
  `id` tinyint(4) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_cod_yes_no`
--

INSERT INTO `phs_cod_yes_no` (`id`, `name`, `rem`) VALUES
(1, 'Yes', NULL),
(2, 'No', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_customize`
--

DROP TABLE IF EXISTS `phs_customize`;
CREATE TABLE IF NOT EXISTS `phs_customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `sys_id` int(11) NOT NULL DEFAULT '0' COMMENT 'System',
  `prog_id` int(11) NOT NULL COMMENT 'Program',
  `ord` mediumint(9) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL COMMENT 'Display Name',
  `pname` varchar(100) NOT NULL COMMENT 'Programing Name',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Default Status',
  `value` varchar(100) NOT NULL DEFAULT '0' COMMENT 'Default Value',
  `type_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Type',
  `table_idfld` varchar(50) DEFAULT NULL COMMENT 'Id Field Name',
  `table_namefld` varchar(100) DEFAULT NULL COMMENT 'Label Field Name',
  `table_name` varchar(100) DEFAULT NULL COMMENT 'Table Name',
  `table_cond` varchar(100) DEFAULT NULL COMMENT 'Where Clause',
  `table_order` varchar(100) DEFAULT NULL COMMENT 'Order',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`sys_id`,`prog_id`,`name`) USING BTREE,
  UNIQUE KEY `pname` (`sys_id`,`prog_id`,`pname`) USING BTREE,
  KEY `status_id` (`status_id`),
  KEY `type_id` (`type_id`),
  KEY `prog_id` (`prog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_customize`
--

INSERT INTO `phs_customize` (`id`, `sys_id`, `prog_id`, `ord`, `name`, `pname`, `status_id`, `value`, `type_id`, `table_idfld`, `table_namefld`, `table_name`, `table_cond`, `table_order`) VALUES
(1, 0, 0, 11001, 'Account', 'ACC_ACC', 1, '0', 7, NULL, NULL, 'cpy-Account-Accounts-ListAutocompleteActives', NULL, NULL),
(2, 0, 0, 11002, 'Cost Center', 'ACC_COST', 1, '0', 7, NULL, NULL, 'cpy-Account-CostCenters-ListAutocompleteActives', NULL, NULL),
(3, 0, 0, 99001, 'Currency', 'MNG_CURN', 1, '3', 6, 'id', 'code', 'mng_curn', 'id>0', 'id'),
(4, 0, 0, 99001, 'Inventory Transaction Types', 'STR_TRN_Type', 1, '0', 9, NULL, NULL, 'str_trn_type', NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `phs_program`
--

DROP TABLE IF EXISTS `phs_program`;
CREATE TABLE IF NOT EXISTS `phs_program` (
  `id` int(11) NOT NULL COMMENT 'PK',
  `prog_id` int(11) DEFAULT NULL COMMENT 'Parent',
  `sys_id` int(11) NOT NULL DEFAULT '0' COMMENT 'System',
  `grp_id` tinyint(4) NOT NULL DEFAULT '127' COMMENT 'Minimum Permission Group',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `type_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Type',
  `open` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Open Type',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `icon` varchar(50) DEFAULT NULL COMMENT 'Icon',
  `file` varchar(100) DEFAULT NULL COMMENT 'Filename',
  `css` varchar(100) DEFAULT NULL COMMENT 'CSS File',
  `js` varchar(100) DEFAULT NULL COMMENT 'JS File',
  `attributes` varchar(512) DEFAULT NULL COMMENT 'Special Attributes',
  `params` varchar(1024) DEFAULT NULL COMMENT 'Parameters',
  PRIMARY KEY (`id`),
  KEY `mprg_id` (`prog_id`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `sys_id` (`sys_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_program`
--

INSERT INTO `phs_program` (`id`, `prog_id`, `sys_id`, `grp_id`, `status_id`, `type_id`, `open`, `ord`, `name`, `icon`, `file`, `css`, `js`, `attributes`, `params`) VALUES
(0, NULL, 0, 127, 1, 0, 0, 0, 'Main Menu', NULL, NULL, NULL, NULL, NULL, NULL),
(1, 0, 0, 127, 1, 3, 0, 1, 'Dashboard', 'icon-home', 'dashboard', NULL, 'dashboard', NULL, NULL),
(11, NULL, 0, 127, 1, 0, 0, 0, 'Top Menu', NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 0, 127, 1, 0, 0, 0, 'User Menu', NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 0, 127, 1, 0, 0, 0, 'Tool Menu', NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 0, 127, 1, 0, 0, 0, 'Top Bar', NULL, NULL, NULL, NULL, NULL, NULL),
(101, NULL, 0, 127, 1, 0, 0, 0, 'Students Menu', NULL, NULL, NULL, NULL, NULL, NULL),
(1100, 0, 1100, 127, 1, 1, 0, 1100, 'Accounting', 'icon-diamond', NULL, NULL, NULL, NULL, NULL),
(1101, 0, 1101, 127, 1, 1, 0, 1101, 'Finance', 'icon-layers', NULL, NULL, NULL, NULL, NULL),
(1102, 0, 1102, 127, 1, 1, 0, 1102, 'Cash', 'icon-social-dropbox', NULL, NULL, NULL, NULL, NULL),
(1103, 0, 1103, 127, 1, 1, 0, 1103, 'Bank', 'icon-bag', NULL, NULL, NULL, NULL, NULL),
(1130, 0, 1131, 127, 1, 1, 0, 1130, 'Human Resources', 'flaticon-users', NULL, NULL, NULL, NULL, NULL),
(1131, 1130, 1131, 127, 1, 1, 0, 1131, 'HR', 'flaticon-users', NULL, NULL, NULL, NULL, NULL),
(1132, 1130, 1132, 127, 1, 1, 0, 1132, 'Attendance', 'icon-clock', NULL, NULL, NULL, NULL, NULL),
(1133, 1130, 1133, 127, 1, 1, 0, 1133, 'Payroll', 'icon-wallet', NULL, NULL, NULL, NULL, NULL),
(1201, 0, 1201, 127, 1, 1, 0, 1201, 'Warehouses', 'icon-grid', NULL, NULL, NULL, NULL, NULL),
(1300, 13, 0, 127, 1, 1, 1, 1, 'Declare Device', 'la la-file-invoice-dollar', 'mng/declareDevice', NULL, 'mng/declareDevice', NULL, NULL),
(1301, 13, 0, 127, 1, 1, 1, 1, 'POS Print Order', 'la la-file-invoice-dollar', 'pos/printOrder', NULL, 'pos/printOrder', NULL, NULL),
(1302, 0, 1302, 127, 1, 1, 0, 1302, 'Sales', 'icon-calculator', NULL, NULL, NULL, NULL, NULL),
(1401, 14, 0, 127, 2, 4, 0, 1401, 'Top Bar Item', 'icon-diamond', '', NULL, NULL, NULL, NULL),
(1402, 0, 1402, 127, 1, 1, 0, 1402, 'Purchases', 'icon-basket', NULL, NULL, NULL, NULL, NULL),
(1601, 0, 1601, 127, 1, 1, 0, 1601, 'Manufacture', 'icon-chemistry', NULL, NULL, NULL, NULL, NULL),
(7001, 0, 7001, 127, 1, 1, 0, 7001, 'CRM', 'icon-trophy', NULL, NULL, NULL, NULL, NULL),
(7002, 0, 7002, 127, 1, 1, 0, 7002, 'Fund Diary', 'fas fa-dollar-sign', NULL, NULL, NULL, NULL, NULL),
(7020, 0, 7020, 127, 1, 1, 0, 7020, 'Maintenance', 'fas fa-eye-dropper', NULL, NULL, NULL, NULL, NULL),
(8001, 11, 8001, 127, 1, 1, 0, 8001, 'Services', 'icon-layers', NULL, NULL, NULL, NULL, NULL),
(9001, 0, 9001, 127, 1, 1, 0, 9001, 'Management', 'icon-settings', NULL, NULL, NULL, NULL, NULL),
(9901, 12, 9901, 127, 1, 1, 0, 9901, 'User', 'icon-user', NULL, NULL, NULL, NULL, NULL),
(9909, 0, 9909, -1, 1, 1, 0, 9909, 'Supervisor', 'icon-wrench', NULL, NULL, NULL, NULL, NULL),
(11311, 1131, 1131, 127, 1, 1, 0, 101, 'Daily', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(11312, 1131, 1131, 127, 1, 1, 0, 102, 'Queries', 'icon-magnifier', NULL, NULL, NULL, NULL, NULL),
(11313, 1131, 1131, 127, 1, 1, 0, 103, 'Management', 'icon-briefcase', NULL, NULL, NULL, NULL, NULL),
(11314, 1131, 1131, 127, 1, 1, 0, 104, 'Special Queries', 'icon-directions', NULL, NULL, NULL, NULL, NULL),
(11321, 1132, 1132, 127, 1, 1, 0, 101, 'Daily', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(11322, 1132, 1132, 127, 1, 1, 0, 102, 'Queries', 'icon-magnifier', NULL, NULL, NULL, NULL, NULL),
(11323, 1132, 1132, 127, 1, 1, 0, 103, 'Management', 'icon-briefcase', NULL, NULL, NULL, NULL, NULL),
(11331, 1133, 1133, 127, 1, 1, 0, 101, 'Daily', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(11332, 1133, 1133, 127, 1, 1, 0, 102, 'Queries', 'icon-magnifier', NULL, NULL, NULL, NULL, NULL),
(11333, 1133, 1133, 127, 1, 1, 0, 103, 'Management', 'icon-briefcase', NULL, NULL, NULL, NULL, NULL),
(13021, 1302, 1302, 127, 1, 1, 0, 101, 'Daily', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(13022, 1302, 1302, 127, 1, 1, 0, 102, 'Queries', 'icon-magnifier', NULL, NULL, NULL, NULL, NULL),
(13023, 1302, 1302, 127, 1, 1, 0, 103, 'Management', 'icon-briefcase', NULL, NULL, NULL, NULL, NULL),
(14021, 1402, 1402, 127, 1, 1, 0, 101, 'Daily', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(14022, 1402, 1402, 127, 1, 1, 0, 102, 'Queries', 'icon-magnifier', NULL, NULL, NULL, NULL, NULL),
(14023, 1402, 1402, 127, 1, 1, 0, 103, 'Management', 'icon-briefcase', NULL, NULL, NULL, NULL, NULL),
(16011, 1601, 1601, 127, 1, 1, 0, 101, 'Daily', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(16012, 1601, 1601, 127, 1, 1, 0, 102, 'Queries', 'icon-magnifier', NULL, NULL, NULL, NULL, NULL),
(16013, 1601, 1601, 127, 1, 1, 0, 103, 'Management', 'icon-briefcase', NULL, NULL, NULL, NULL, NULL),
(70301, 0, 7030, 127, 1, 0, 0, 7030, 'Clinic', 'flaticon2-hospital', NULL, NULL, NULL, NULL, NULL),
(1100101, 1100, 1100, 127, 1, 3, 0, 111, 'Daily Journal', 'icon-control-play', 'acc/dailyJournal', NULL, 'acc/dailyJournal', NULL, NULL),
(1100201, 1100, 1100, 127, 1, 3, 0, 211, 'Trial Balance', 'icon-magnifier', 'acc/qry/trialBalance', NULL, 'acc/qry/trialBalance', NULL, NULL),
(1100202, 1100, 1100, 127, 1, 3, 0, 212, 'General Ledger', 'icon-magnifier', 'acc/qry/generalLedger', NULL, 'acc/qry/genderLedger', NULL, NULL),
(1100203, 1100, 1100, 127, 2, 3, 0, 213, 'Daily Journal', 'icon-magnifier', 'acc/qry/dailyJournal', NULL, 'acc/qry/dailyJournal', NULL, NULL),
(1100204, 1100, 1100, 127, 2, 3, 0, 214, 'Debit Ageing', 'icon-magnifier', 'acc/qry/debitAgeing', NULL, 'acc/qry/debitAgeing', NULL, NULL),
(1100205, 1100, 1100, 127, 2, 3, 0, 215, 'Currency Rate Vouchers', 'icon-magnifier', 'acc/qry/currencyRate Vouchers', NULL, 'acc/qry/currencyRate Vouchers', NULL, NULL),
(1100206, 1100, 1100, 127, 2, 3, 0, 216, 'Closing Accounts', 'icon-magnifier', 'acc/qry/closingAccounts', NULL, 'acc/qry/closingAccounts', NULL, NULL),
(1100207, 1100, 1100, 127, 2, 3, 0, 217, 'Execute Report', 'icon-magnifier', 'acc/qry/executeReport', NULL, 'acc/qry/executeReport', NULL, NULL),
(1100301, 1100, 1100, 127, 1, 3, 0, 311, 'Chart of Cost Centers', 'icon-briefcase', 'acc/treeCostCenters', NULL, 'acc/treeCostCenters', NULL, NULL),
(1100302, 1100, 1100, 127, 1, 3, 0, 312, 'Chart of Accounts', 'icon-briefcase', 'acc/treeAccounts', NULL, 'acc/treeAccounts', NULL, NULL),
(1100321, 1100, 1100, 127, 2, 3, 0, 321, 'Total Accounts', 'icon-briefcase', 'acc/totalAccounts', NULL, 'acc/totalAccounts', NULL, NULL),
(1100322, 1100, 1100, 127, 2, 3, 0, 322, 'Reports', 'icon-briefcase', 'acc/reports', NULL, 'acc/reports', NULL, NULL),
(1100399, 1100, 1100, 127, 2, 3, 0, 999, 'Sort Vouchers', 'icon-briefcase', 'acc/tool/sortVouchers', NULL, 'acc/tool/sortVouchers', NULL, NULL),
(1101101, 1101, 1101, 127, 1, 3, 0, 111, 'Invoices', 'icon-control-play', 'fin/invoice', NULL, 'fin/invoice', NULL, NULL),
(1101102, 1101, 1101, 127, 1, 3, 0, 112, 'Commercial Debit Notes', 'icon-control-play', 'fin/comDebitNote', NULL, 'fin/comDebitNote', NULL, NULL),
(1101103, 1101, 1101, 127, 1, 3, 0, 113, 'Commercial Credit Notes', 'icon-control-play', 'fin/comCreditNote', NULL, 'fin/comCreditNote', NULL, NULL),
(1101104, 1101, 1101, 127, 1, 3, 0, 114, 'Commercial Expense Notes', 'icon-control-play', 'fin/comExpenseNote', NULL, 'fin/comExpenseNote', NULL, NULL),
(1101105, 1101, 1101, 127, 1, 3, 0, 115, 'Commercial Clearing', 'icon-control-play', 'fin/comClearing', NULL, 'fin/comClearing', NULL, NULL),
(1101122, 1101, 1101, 127, 1, 3, 0, 122, 'Non-Commercial Debit Notes', 'icon-control-play', 'fin/debitNote', NULL, 'fin/debitNote', NULL, NULL),
(1101123, 1101, 1101, 127, 1, 3, 0, 123, 'Non-Commercial Credit Notes', 'icon-control-play', 'fin/creditNote', NULL, 'fin/creditNote', NULL, NULL),
(1101124, 1101, 1101, 127, 1, 3, 0, 124, 'Non-Commercial Expense Notes', 'icon-control-play', 'fin/expenseNote', NULL, 'fin/expenseNote', NULL, NULL),
(1101201, 1101, 1101, 127, 1, 3, 0, 211, 'Contact Open Documents Statement', 'icon-magnifier', 'fin/qry/accountStatement', NULL, 'fin/qry/accountStatement', NULL, NULL),
(1101202, 1101, 1101, 127, 1, 3, 0, 212, 'Contact Balances', 'icon-magnifier', 'fin/qry/contactBalance', NULL, 'fin/qry/contactBalance', NULL, NULL),
(1101203, 1101, 1101, 127, 1, 3, 0, 213, 'Overcredits Contacts', 'icon-magnifier', 'fin/qry/overCredits', NULL, 'fin/qry/overCredits', NULL, NULL),
(1102111, 1102, 1102, 127, 1, 3, 0, 111, 'Cash Orders', 'icon-control-play', 'cash/orders', NULL, 'cash/orders', NULL, NULL),
(1102112, 1102, 1102, 127, 1, 3, 0, 112, 'Collection Orders', 'icon-control-play', 'cash/collectionVoucher', NULL, 'cash/collectionVoucher', NULL, NULL),
(1102113, 1102, 1102, 127, 1, 3, 0, 113, 'Payment Orders', 'icon-control-play', 'cash/paymentVoucher', NULL, 'cash/paymentVoucher', NULL, NULL),
(1102114, 1102, 1102, 127, 1, 3, 0, 114, 'Service Payment Orders', 'icon-control-play', 'cash/servicePaymentVoucher', NULL, 'cash/servicePaymentVoucher', NULL, NULL),
(1102115, 1102, 1102, 127, 1, 3, 0, 115, 'Advanced Payment Orders', 'icon-control-play', 'cash/advancedPaymentVoucher', NULL, 'cash/advancedPaymentVoucher', NULL, NULL),
(1102116, 1102, 1102, 127, 1, 3, 0, 116, 'Exchange Orders', 'icon-control-play', 'cash/exchangeVoucher', NULL, 'cash/exchangeVoucher', NULL, NULL),
(1102117, 1102, 1102, 127, 1, 3, 0, 117, 'Deposit Orders', 'icon-control-play', 'cash/depositVoucher', NULL, 'cash/depositVoucher', NULL, NULL),
(1102118, 1102, 1102, 127, 1, 3, 0, 118, 'Withdraw Orders', 'icon-control-play', 'cash/withdrawVoucher', NULL, 'cash/withdrawVoucher', NULL, NULL),
(1102211, 1102, 1102, 127, 1, 3, 0, 211, 'Cash Daily', 'icon-magnifier', 'cash/qry/daily', NULL, 'cash/qry/daily', NULL, NULL),
(1102311, 1102, 1102, 127, 1, 3, 0, 311, 'Cashiers', 'icon-briefcase', 'cash/cashier', NULL, 'cash/cashier', NULL, NULL),
(1102312, 1102, 1102, 127, 1, 3, 0, 312, 'Cash Boxs', 'icon-briefcase', 'cash/box', NULL, 'cash/box', NULL, NULL),
(1103121, 1103, 1103, 127, 1, 3, 0, 111, 'Collection Orders', 'icon-control-play', 'bank/collectionVoucher', NULL, 'bank/collectionVoucher', NULL, NULL),
(1103122, 1103, 1103, 127, 1, 3, 0, 112, 'Payment Orders', 'icon-control-play', 'bank/paymentVoucher', NULL, 'bank/paymentVoucher', NULL, NULL),
(1103123, 1103, 1103, 127, 1, 3, 0, 113, 'Service Payment Orders', 'icon-control-play', 'bank/servicePaymentVoucher', NULL, 'bank/servicePaymentVoucher', NULL, NULL),
(1103124, 1103, 1103, 127, 1, 3, 0, 114, 'Advanced Payment Orders', 'icon-control-play', 'bank/advancedPaymentVoucher', NULL, 'bank/advancedPaymentVoucher', NULL, NULL),
(1103125, 1103, 1103, 127, 1, 3, 0, 115, 'Exchange Orders', 'icon-control-play', 'bank/exchangeVoucher', NULL, 'bank/exchangeVoucher', NULL, NULL),
(1103126, 1103, 1103, 127, 1, 3, 0, 116, 'Transfer Orders', 'icon-control-play', 'bank/transferVoucher', NULL, 'bank/transferVoucher', NULL, NULL),
(1103211, 1103, 1103, 127, 1, 3, 0, 211, 'Bank Daily', 'icon-magnifier', 'bank/qry/daily', NULL, 'bank/qry/daily', NULL, NULL),
(1103311, 1103, 1103, 127, 1, 3, 0, 311, 'Bank Accounts', 'icon-briefcase', 'bank/bankAccount', NULL, 'bank/bankAccount', NULL, NULL),
(1131111, 11311, 1131, 127, 1, 1, 0, 11, 'Application Form', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(1131112, 11311, 1131, 127, 1, 3, 0, 12, 'Appraisal Note', 'icon-control-play', 'hr/hr/appraisalNote', NULL, 'hr/hr/appraisalNote', NULL, NULL),
(1131113, 11311, 1131, 127, 1, 3, 0, 13, 'Employee History', 'icon-control-play', 'hr/hr/employeeHistory', NULL, 'hr/hr/employeeHistory', NULL, NULL),
(1131114, 11311, 1131, 127, 1, 3, 0, 14, 'ADM Consideration', 'icon-control-play', 'hr/hr/admConsideration', NULL, 'hr/hr/admConsideration', NULL, NULL),
(1131115, 11311, 1131, 127, 1, 3, 0, 15, 'ADM Punishment', 'icon-control-play', 'hr/hr/admPunishment', NULL, 'hr/hr/admPunishment', NULL, NULL),
(1131116, 11311, 1131, 127, 1, 3, 0, 16, 'Employee Appraisal', 'icon-control-play', 'hr/hr/employeeAppraisal', NULL, 'hr/hr/employeeAppraisal', NULL, NULL),
(1131117, 11311, 1131, 127, 1, 3, 0, 17, 'Recruitment', 'icon-control-play', 'hr/hr/recruitment', NULL, 'hr/hr/recruitment', NULL, NULL),
(1131118, 11311, 1131, 127, 1, 3, 0, 18, 'Grade Change', 'icon-control-play', 'hr/hr/gradeChange', NULL, 'hr/hr/gradeChange', NULL, NULL),
(1131311, 11313, 1131, 127, 1, 3, 0, 11, 'Employee Card', 'icon-briefcase', 'hr/hr/empCard', NULL, 'hr/hr/empCard', NULL, NULL),
(1131312, 11313, 1131, 127, 1, 3, 0, 12, 'Appraisal Template', 'icon-briefcase', 'hr/hr/gradeChange', NULL, 'hr/hr/gradeChange', NULL, NULL),
(1131313, 11313, 1131, 127, 1, 3, 0, 13, 'Grade Groups', 'icon-briefcase', 'hr/hr/gradeGroup', NULL, 'hr/hr/gradeGroup', NULL, NULL),
(1132111, 11321, 1132, 127, 1, 3, 0, 11, 'Leave Request', 'icon-control-play', 'hr/att/leaveRequest', NULL, 'hr/att/leaveRequest', NULL, NULL),
(1132112, 11321, 1132, 127, 1, 3, 0, 12, 'Mission Request', 'icon-control-play', 'hr/att/missionRequest', NULL, 'hr/att/missionRequest', NULL, NULL),
(1132113, 11321, 1132, 127, 1, 3, 0, 13, 'Overtime Request', 'icon-control-play', 'hr/att/overtimeRequest', NULL, 'hr/att/overtimeRequest', NULL, NULL),
(1132115, 11321, 1132, 127, 1, 3, 0, 15, 'Approve HR Requests', 'icon-control-play', 'hr/att/approveRequest', NULL, 'hr/att/approveRequest', NULL, NULL),
(1132121, 11321, 1132, 127, 1, 3, 0, 21, 'Prepare Attendance', 'icon-control-play', 'hr/att/prepareAttendance', NULL, 'hr/att/prepareAttendance', NULL, NULL),
(1132123, 11321, 1132, 127, 1, 3, 0, 23, 'Daily Attendance', 'icon-control-play', 'hr/att/dailyAttendance', NULL, 'hr/att/dailyAttendance', NULL, NULL),
(1132131, 11321, 1132, 127, 1, 3, 0, 31, 'Leaves', 'icon-control-play', 'hr/att/leave', NULL, 'hr/att/leave', NULL, NULL),
(1132132, 11321, 1132, 127, 1, 3, 0, 32, 'Missions', 'icon-control-play', 'hr/att/mission', NULL, 'hr/att/mission', NULL, NULL),
(1132133, 11321, 1132, 127, 1, 3, 0, 33, 'Overtimes', 'icon-control-play', 'hr/att/overtime', NULL, 'hr/att/overtime', NULL, NULL),
(1132211, 11322, 1132, 127, 1, 3, 0, 11, 'Leave Request', 'icon-magnifier', 'hr/att/qry/leaveRequest', NULL, 'hr/att/qry/leaveRequest', NULL, NULL),
(1132212, 11322, 1132, 127, 1, 3, 0, 12, 'Mission Request', 'icon-magnifier', 'hr/att/qry/missionRequest', NULL, 'hr/att/qry/missionRequest', NULL, NULL),
(1132213, 11322, 1132, 127, 1, 3, 0, 13, 'Overtime Request', 'icon-magnifier', 'hr/att/qry/overtimeRequest', NULL, 'hr/att/qry/overtimeRequest', NULL, NULL),
(1132221, 11322, 1132, 127, 1, 3, 0, 21, 'Daily Attendance', 'icon-magnifier', 'hr/att/qry/dailyAttendance', NULL, 'hr/att/qry/dailyAttendance', NULL, NULL),
(1132222, 11322, 1132, 127, 1, 3, 0, 22, 'Leave Balances', 'icon-magnifier', 'hr/att/qry/leaveBalance', NULL, 'hr/att/qry/leaveBalance', NULL, NULL),
(1132231, 11322, 1132, 127, 1, 3, 0, 31, 'Leaves', 'icon-magnifier', 'hr/att/qry/leave', NULL, 'hr/att/qry/leave', NULL, NULL),
(1132232, 11322, 1132, 127, 1, 3, 0, 32, 'Missions', 'icon-magnifier', 'hr/att/qry/mission', NULL, 'hr/att/qry/mission', NULL, NULL),
(1132233, 11322, 1132, 127, 1, 3, 0, 33, 'Overtimes', 'icon-magnifier', 'hr/att/qry/overtime', NULL, 'hr/att/qry/overtime', NULL, NULL),
(1132311, 11323, 1132, 127, 1, 3, 0, 11, 'Working Shifts', 'icon-briefcase', 'hr/att/workingShift', NULL, 'hr/att/workingShift', NULL, NULL),
(1133111, 11331, 1133, 127, 1, 3, 0, 11, 'Attendance For Salaries', 'icon-control-play', 'hr/pay/attForSalary', NULL, 'hr/pay/attForSalary', NULL, NULL),
(1133112, 11331, 1133, 127, 1, 3, 0, 12, 'Audit Salary Attendance', 'icon-control-play', 'hr/pay/auditSalaryAttendance', NULL, 'hr/pay/auditSalaryAttendance', NULL, NULL),
(1133121, 11331, 1133, 127, 1, 3, 0, 21, 'Monthly Withdrawals', 'icon-control-play', 'hr/pay/monthlyWithdrawal', NULL, 'hr/pay/monthlyWithdrawal', NULL, NULL),
(1133122, 11331, 1133, 127, 1, 3, 0, 22, 'Loans', 'icon-control-play', 'hr/pay/loan', NULL, 'hr/pay/loan', NULL, NULL),
(1133123, 11331, 1133, 127, 1, 3, 0, 23, 'Loan Payments', 'icon-control-play', 'hr/pay/loanPayment', NULL, 'hr/pay/loanPayment', NULL, NULL),
(1133141, 11331, 1133, 127, 1, 3, 0, 41, 'Add to Salary', 'icon-control-play', 'hr/pay/addToSalary', NULL, 'hr/pay/addToSalary', NULL, NULL),
(1133142, 11331, 1133, 127, 1, 3, 0, 42, 'Deduct From Salary', 'icon-control-play', 'hr/pay/deductFromSalary', NULL, 'hr/pay/deductFromSalary', NULL, NULL),
(1133199, 11331, 1133, 127, 1, 3, 0, 99, 'Calculate Salaries', 'icon-control-play', 'hr/pay/calculateSalaries', NULL, 'hr/pay/calculateSalaries', NULL, NULL),
(1133311, 11333, 1133, 127, 1, 3, 0, 11, 'Salary Accredited', 'icon-briefcase', 'hr/pay/accredited', NULL, 'hr/pay/accredited', NULL, NULL),
(1133312, 11333, 1133, 127, 1, 3, 0, 12, 'Taxable Salary Groups', 'icon-briefcase', 'hr/pay/taxableSalaryGroup', NULL, 'hr/pay/taxableSalaryGroup', NULL, NULL),
(1133313, 11333, 1133, 127, 1, 3, 0, 13, 'Tax', 'icon-briefcase', 'hr/pay/tax', NULL, 'hr/pay/tax', NULL, NULL),
(1133321, 11333, 1133, 127, 1, 3, 0, 21, 'Compensation Types', 'icon-briefcase', 'hr/pay/compensationType', NULL, 'hr/pay/compensationType', NULL, NULL),
(1133322, 11333, 1133, 127, 1, 3, 0, 22, 'Employee Compensation', 'icon-briefcase', 'hr/pay/employeeCompensation', NULL, 'hr/pay/employeeCompensation', NULL, NULL),
(1133331, 11333, 1133, 127, 1, 3, 0, 31, 'Deduction Types', 'icon-briefcase', 'hr/pay/deduction', NULL, 'hr/pay/deduction', NULL, NULL),
(1133332, 11333, 1133, 127, 1, 3, 0, 32, 'Employee Deduction', 'icon-briefcase', 'hr/pay/employeeDeduction', NULL, 'hr/pay/employeeDeduction', NULL, NULL),
(1133341, 11333, 1133, 127, 1, 3, 0, 41, 'Salary Change', 'icon-briefcase', 'hr/pay/salaryChange', NULL, 'hr/pay/salaryChange', NULL, NULL),
(1133342, 11333, 1133, 127, 1, 3, 0, 42, 'Change Salary Slices', 'icon-briefcase', 'hr/pay/salaryChangeSlices', NULL, 'hr/pay/salaryChangeSlices', NULL, NULL),
(1133399, 11333, 1133, 127, 1, 3, 0, 99, 'Salaries', 'icon-briefcase', 'hr/pay/salaries', NULL, 'hr/pay/salaries', NULL, NULL),
(1201101, 1201, 1201, 127, 1, 3, 0, 111, 'Inbounds', 'icon-control-play', 'inv/inbound', NULL, 'inv/inbound', NULL, NULL),
(1201102, 1201, 1201, 127, 1, 3, 0, 112, 'Outbounds', 'icon-control-play', 'inv/outbound', NULL, 'inv/outbound', NULL, NULL),
(1201180, 1201, 1201, 127, 2, 3, 0, 180, 'Actual Quantities', 'icon-control-play', 'inv/actualQuantity', NULL, 'inv/actualQuantity', NULL, NULL),
(1201201, 1201, 1201, 127, 1, 3, 0, 211, 'Inventory Quantities', 'icon-magnifier', 'inv/qry/storeBalances', NULL, 'inv/qry/storeBalances', NULL, NULL),
(1201204, 1201, 1201, 127, 2, 3, 0, 214, 'Inventory Differences', 'icon-magnifier', 'inv/qry/differnces', NULL, 'inv/qry/differnces', NULL, NULL),
(1201221, 1201, 1201, 127, 1, 3, 0, 221, 'Material Movments Card', 'icon-magnifier', 'inv/qry/itemCard', NULL, 'inv/qry/itemCard', NULL, NULL),
(1201222, 1201, 1201, 127, 2, 3, 0, 222, 'Over Limits Quantities', 'icon-magnifier', 'inv/qry/auditLimits', NULL, 'inv/qry/auditLimits', NULL, NULL),
(1201231, 1201, 1201, 127, 2, 3, 0, 231, 'Movements', 'icon-magnifier', 'inv/qry/movements', NULL, 'inv/qry/movements', NULL, NULL),
(1201232, 1201, 1201, 127, 2, 3, 0, 232, 'Compare Movements in Periods', 'icon-magnifier', 'inv/qry/transCompaire', NULL, 'inv/qry/transCompaire', NULL, NULL),
(1201241, 1201, 1201, 127, 2, 3, 0, 241, 'Movements Statistics', 'icon-magnifier', 'inv/qry/statistics', NULL, 'inv/qry/statistics', NULL, NULL),
(1201301, 1201, 1201, 127, 1, 3, 0, 311, 'Materials', 'icon-briefcase', 'inv/materials', NULL, 'inv/materials', NULL, NULL),
(1201302, 1201, 1201, 127, 1, 3, 0, 312, 'Warehouses', 'icon-briefcase', 'inv/warehouses', NULL, 'inv/warehouses', NULL, NULL),
(1201303, 1201, 1201, 127, 2, 3, 0, 313, 'Warehouse Materials', 'icon-briefcase', 'inv/wMaterials', NULL, 'inv/wMaterials', NULL, NULL),
(1201393, 1201, 1201, 127, 1, 3, 0, 393, 'Coded Tables', 'icon-briefcase', 'inv/codes', NULL, 'cpy/codes', NULL, NULL),
(7001111, 7001, 7001, 127, 1, 3, 0, 111, 'crm.Assign Contacts', 'icon-control-play', 'crm/assignContact', NULL, 'crm/assignContact', NULL, NULL),
(7001112, 7001, 7001, 127, 1, 3, 0, 112, 'Sales Representatives Reports', 'icon-control-play', 'crm/report', NULL, 'crm/report', NULL, NULL),
(7001113, 7001, 7001, 127, 1, 3, 0, 113, 'Offers', 'icon-control-play', 'crm/offers', NULL, 'crm/offers', NULL, NULL),
(7001211, 7001, 7001, 127, 2, 3, 0, 211, 'Contacts', 'icon-magnifier', 'crm/qry/contact', NULL, 'crm/qry/contact', NULL, NULL),
(7001212, 7001, 7001, 127, 2, 3, 0, 212, 'Sales Representatives Reports', 'icon-magnifier', 'crm/qry/report', NULL, 'crm/qry/report', NULL, NULL),
(7001213, 7001, 7001, 127, 2, 3, 0, 213, 'Offers', 'icon-magnifier', 'crm/qry/offer', NULL, 'crm/qry/offer', NULL, NULL),
(7001311, 7001, 7001, 127, 1, 3, 0, 311, 'Sales Representatives', 'icon-briefcase', 'crm/representative', NULL, 'crm/representative', NULL, NULL),
(7001312, 7001, 7001, 127, 1, 3, 0, 312, 'Contacts', 'icon-briefcase', 'crm/contact', NULL, 'mng/contact', NULL, NULL),
(7001313, 7001, 7001, 127, 1, 3, 0, 313, 'crm.Terms', 'icon-briefcase', 'crm/term', NULL, 'crm/term', NULL, NULL),
(7001990, 7001, 7001, 127, 1, 3, 0, 990, 'Coded Tables', 'icon-briefcase', 'crm/codes', NULL, 'cpy/codes', NULL, NULL),
(7002111, 7002, 7002, 127, 1, 3, 0, 111, 'Fund Diary', 'icon-control-play', 'fund/diary', NULL, 'fund/diary', NULL, NULL),
(7002211, 7002, 7002, 127, 1, 3, 0, 211, 'Fund Ledger', 'icon-magnifier', 'fund/qry/fundLedger', NULL, 'fund/qry/fundLedger', NULL, NULL),
(7002212, 7002, 7002, 127, 1, 3, 0, 212, 'Fund Balances', 'icon-magnifier', 'fund/qry/fundBalance', NULL, 'fund/qry/fundBalance', NULL, NULL),
(7002312, 7002, 7002, 127, 1, 3, 0, 312, 'Fund Box', 'icon-briefcase', 'fund/box', NULL, 'fund/box', NULL, NULL),
(7020111, 7020, 7020, 127, 1, 3, 0, 111, 'Maintenance', 'icon-control-play', 'maint/maintenance', NULL, 'maint/maintenance', NULL, NULL),
(7020215, 7020, 7020, 127, 1, 3, 0, 214, 'Device Card', 'icon-magnifier', 'maint/qry/deviceCard', NULL, 'maint/qry/deviceCard', NULL, NULL),
(7020311, 7020, 7020, 127, 1, 3, 0, 311, 'Customers', 'icon-briefcase', 'maint/customers', NULL, 'maint/customers', NULL, NULL),
(7020313, 7020, 7020, 127, 1, 3, 0, 312, 'Devices', 'icon-briefcase', 'maint/devices', NULL, 'maint/devices', NULL, NULL),
(7020990, 7020, 7020, 127, 1, 3, 0, 990, 'Coded Tables', 'icon-briefcase', 'maint/codes', NULL, 'cpy/codes', NULL, NULL),
(7030102, 70301, 7030, 127, 1, 3, 0, 1, 'Appointments', 'flaticon-event-calendar-symbol', 'clinic/appointments', NULL, 'clinic/appointments', NULL, NULL),
(7030103, 70301, 7030, 127, 1, 1, 0, 3, 'Finance', 'la la-file-invoice-dollar', NULL, NULL, NULL, NULL, NULL),
(7030105, 70301, 7030, 127, 1, 3, 0, 2, 'Patients', 'flaticon-users', 'clinic/patients', NULL, 'clinic/patients', NULL, NULL),
(7030107, 70301, 7030, 127, 1, 1, 0, 6, 'Queries', 'flaticon2-open-text-book', NULL, NULL, NULL, NULL, NULL),
(7030108, 70301, 7030, 127, 1, 1, 0, 7, 'Settings', 'flaticon2-console', NULL, NULL, NULL, NULL, NULL),
(7030109, 70301, 7030, 127, 1, 3, 0, 1, 'Doctor Appointments', 'flaticon-event-calendar-symbol', 'clinic/drAppointments', NULL, 'clinic/drAppointments', NULL, NULL),
(7030110, 70301, 7030, 127, 1, 3, 0, 1, 'Treatments', 'fas fa-ambulance', 'clinic/treatments', NULL, 'clinic/treatments', NULL, NULL),
(7030201, 14, 7030, 127, 1, 4, 0, 1, 'Top Menu - Add Appointment', 'flaticon2-calendar-6', 'addAppointment', NULL, NULL, 'data-modal=\"addAppointmentModal\"', NULL),
(7030202, 14, 7030, 127, 2, 4, 0, 2, 'Top Menu - Add Invoice', 'la la-file-invoice-dollar', 'addInvoice', NULL, NULL, 'data-modal=\"addInvoiceModal\"', NULL),
(7030203, 14, 7030, 127, 1, 4, 0, 3, 'Top Menu - Add Payment', 'flaticon-coins', 'addPayment', NULL, NULL, 'data-modal=\"addPaymentModal\"', NULL),
(7030204, 14, 7030, 127, 1, 4, 0, 4, 'Top Menu - Add Patient', 'flaticon-users', 'addPatient', NULL, NULL, 'data-modal=\"addPatientModal\"', NULL),
(7030205, 14, 7030, 127, 1, 4, 0, 5, 'Top Menu - Treatment', 'fas fa-ambulance', 'openTreatments', NULL, NULL, 'data-modal=\"addTreatmentModal\"', NULL),
(8001103, 8001, 8001, 127, 1, 5, 0, 13, 'Outside Missions Request', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(8001106, 8001, 8001, 127, 1, 5, 0, 16, 'IT Requests', 'icon-control-play', NULL, NULL, NULL, NULL, NULL),
(9001111, 9001, 9001, 127, 1, 3, 0, 111, 'Currency Rates', 'icon-control-play', 'mng/currencyRates', NULL, 'mng/currencyRates', NULL, NULL),
(9001112, 9001, 9001, 127, 2, 3, 0, 112, 'Copy Preferences', 'icon-control-play', 'cpy/prefs', NULL, 'cpy/prefs', NULL, NULL),
(9001113, 9001, 9001, 127, 1, 3, 0, 113, 'Coded Tables', 'icon-control-play', 'cpy/codes', NULL, 'cpy/codes', NULL, NULL),
(9001310, 9001, 9001, 127, 2, 3, 0, 310, 'Activities', 'icon-briefcase', 'cpy/activities', NULL, 'cpy/activities', NULL, NULL),
(9001311, 9001, 9001, 127, 2, 3, 0, 311, 'Special Lists', 'icon-briefcase', 'cpy/specialLists', NULL, 'cpy/specialLists', NULL, NULL),
(9001312, 9001, 9001, 127, 1, 3, 0, 312, 'Permission Groups', 'icon-briefcase', 'cpy/pgrp', NULL, 'cpy/pgrp', NULL, NULL),
(9001313, 9001, 9001, 127, 1, 3, 0, 313, 'Users', 'icon-briefcase', 'cpy/users', NULL, 'cpy/users', NULL, NULL),
(9001314, 9001, 9001, 127, 1, 3, 0, 314, 'Work Periods', 'icon-briefcase', 'cpy/workperiods', NULL, 'cpy/workperiods', NULL, NULL),
(9001315, 9001, 9001, 127, 2, 3, 0, 315, 'Customize Copy', 'icon-briefcase', 'cpy/customize', NULL, 'cpy/customize', NULL, NULL),
(9001316, 9001, 9001, 127, 1, 3, 0, 316, 'Currencies', 'icon-briefcase', 'mng/currency', NULL, 'mng/currency', NULL, NULL),
(9001317, 9001, 9001, 127, 2, 3, 0, 317, 'Devices', 'icon-briefcase', 'cpy/devices', NULL, 'cpy/devices', NULL, NULL),
(9901101, 9901, 9901, 127, 1, 5, 0, 11, 'Change Password', 'flaticon-lock', 'PhChangePassword', NULL, NULL, 'data-toggle=\"modal\" data-target=\"#changePasswordModal\"', NULL),
(9901102, 9901, 9901, 127, 2, 5, 0, 12, 'Change Image', 'fas fa-image', 'PhChangeImage', NULL, NULL, 'data-toggle=\"modal\" data-target=\"#changeImageModal\"', NULL),
(9909101, 9909, 9909, -1, 1, 3, 0, 111, 'Languages', NULL, 'sup/language', NULL, 'sup/language', NULL, NULL),
(9909104, 9909, 9909, -1, 1, 3, 0, 114, 'System Coded Tables', NULL, 'sup/codes', NULL, 'sup/codes', NULL, NULL),
(9909205, 9909, 9909, -1, 1, 3, 0, 211, 'Menu Programs', NULL, 'sup/program', NULL, 'sup/program', NULL, NULL),
(9909301, 9909, 9909, -1, 1, 3, 0, 311, 'Copy Menus', NULL, 'sup/systems', NULL, 'sup/systems', NULL, NULL),
(9909302, 9909, 9909, -1, 1, 3, 0, 312, 'System Preferences', NULL, 'sup/prefs', NULL, 'sup/prefs', NULL, NULL),
(11013021, 1101, 1101, 127, 1, 3, 0, 321, 'Services', 'icon-briefcase', 'mng/service', NULL, 'mng/service', NULL, NULL),
(11013031, 1101, 1101, 127, 1, 3, 0, 331, 'Contacts', 'icon-briefcase', 'mng/contact', NULL, 'mng/contact', NULL, NULL),
(11312201, 11312, 1131, 127, 1, 3, 0, 201, 'Application Form', 'icon-magnifier', 'hr/hr/qry/applicationForm', NULL, 'hr/hr/qry/applicationForm', NULL, NULL),
(11312202, 11312, 1131, 127, 1, 3, 0, 202, 'Application Form Details', 'icon-magnifier', 'hr/hr/qry/applicationFormDetail', NULL, 'hr/hr/qry/applicationFormDetail', NULL, NULL),
(11312203, 11312, 1131, 127, 1, 3, 0, 203, 'Appraisal Note', 'icon-magnifier', 'hr/hr/qry/appraisalNote', NULL, 'hr/hr/qry/appraisalNote', NULL, NULL),
(11312204, 11312, 1131, 127, 1, 3, 0, 204, 'Employee History', 'icon-magnifier', 'hr/hr/qry/employeeHistory', NULL, 'hr/hr/qry/employeeHistory', NULL, NULL),
(11312205, 11312, 1131, 127, 1, 3, 0, 205, 'ADM Consideration', 'icon-magnifier', 'hr/hr/qry/admConsideration', NULL, 'hr/hr/qry/admConsideration', NULL, NULL),
(11312206, 11312, 1131, 127, 1, 3, 0, 206, 'ADM Punishment', 'icon-magnifier', 'hr/hr/qry/admPunishment', NULL, 'hr/hr/qry/admPunishment', NULL, NULL),
(11312207, 11312, 1131, 127, 1, 3, 0, 207, 'Employee Appraisal', 'icon-magnifier', 'hr/hr/qry/employeeAppraisal', NULL, 'hr/hr/qry/employeeAppraisal', NULL, NULL),
(11312209, 11312, 1131, 127, 1, 3, 0, 209, 'Recruitment', 'icon-magnifier', 'hr/hr/qry/recruitment', NULL, 'hr/hr/qry/recruitment', NULL, NULL),
(11312210, 11312, 1131, 127, 1, 3, 0, 210, 'Grade Change', 'icon-magnifier', 'hr/hr/qry/gradeChange', NULL, 'hr/hr/qry/gradeChange', NULL, NULL),
(11312211, 11312, 1131, 127, 1, 3, 0, 211, 'Employee Card', 'icon-magnifier', 'hr/hr/qry/employeeCard', NULL, 'hr/hr/qry/employeeCard', NULL, NULL),
(11312212, 11312, 1131, 127, 1, 3, 0, 212, 'Appraisal Template', 'icon-magnifier', 'hr/hr/qry/appraisalTemplate', NULL, 'hr/hr/qry/appraisalTemplate', NULL, NULL),
(11312213, 11312, 1131, 127, 1, 3, 0, 213, 'Grade Groups', 'icon-magnifier', 'hr/hr/qry/gradeGroup', NULL, 'hr/hr/qry/gradeGroup', NULL, NULL),
(11314301, 11314, 1131, 127, 1, 3, 0, 301, 'Query Employee Card', 'icon-directions', 'hr/hr/qry/fullEmployeeCard', NULL, 'hr/hr/qry/fullEmployeeCard', NULL, NULL),
(11314302, 11314, 1131, 127, 1, 3, 0, 302, 'Query Self Information', 'icon-directions', 'hr/hr/qry/selfInformation', NULL, 'hr/hr/qry/selfInformation', NULL, NULL),
(11332101, 11332, 1133, 127, 1, 3, 0, 11, 'Salary Attendance', 'icon-magnifier', 'hr/pay/qry/salaryAttaendance', NULL, 'hr/pay/qry/salaryAttaendance', NULL, NULL),
(11332102, 11332, 1133, 127, 1, 3, 0, 12, 'Monthly Payroll Table', 'icon-magnifier', 'hr/pay/qry/monthlyPayrollTable', NULL, 'hr/pay/qry/monthlyPayrollTable', NULL, NULL),
(11332103, 11332, 1133, 127, 1, 3, 0, 13, 'Employees Payroll Tax', 'icon-magnifier', 'hr/pay/qry/employeePayrollTax', NULL, 'hr/pay/qry/employeePayrollTax', NULL, NULL),
(11332201, 11332, 1133, 127, 1, 3, 0, 201, 'Monthly Withdrawals', 'icon-magnifier', 'hr/pay/qry/monthlyWithdrawal', NULL, 'hr/pay/qry/monthlyWithdrawal', NULL, NULL),
(11332202, 11332, 1133, 127, 1, 3, 0, 202, 'Loans', 'icon-magnifier', 'hr/pay/qry/loan', NULL, 'hr/pay/qry/loan', NULL, NULL),
(11332203, 11332, 1133, 127, 1, 3, 0, 203, 'Loan Payments', 'icon-magnifier', 'hr/pay/qry/loanPayment', NULL, 'hr/pay/qry/loanPayment', NULL, NULL),
(11332302, 11332, 1133, 127, 1, 3, 0, 302, 'Employee Compensation', 'icon-magnifier', 'hr/pay/qry/employeeCompensation', NULL, 'hr/pay/qry/employeeCompensation', NULL, NULL),
(11332304, 11332, 1133, 127, 1, 3, 0, 304, 'Employee Deduction', 'icon-magnifier', 'hr/pay/qry/employeeDeduction', NULL, 'hr/pay/qry/employeeDeduction', NULL, NULL),
(11332501, 11332, 1133, 127, 1, 3, 0, 501, 'Salary Change', 'icon-magnifier', 'hr/pay/qry/salaryChange', NULL, 'hr/pay/qry/salaryChange', NULL, NULL),
(13021011, 13021, 1302, 127, 1, 3, 0, 11, 'Sales', '', 'sales/sales', NULL, 'sales/sales', NULL, NULL),
(13021012, 13021, 1302, 127, 1, 3, 0, 12, 'Sales Returns', '', 'sales/salesReturn', NULL, 'sales/salesReturn', NULL, NULL),
(13022011, 13022, 1302, 127, 1, 3, 0, 11, 'Sales', '', 'sales/qry/sales', NULL, 'sales/qry/sales', NULL, NULL),
(13022021, 13022, 1302, 127, 1, 3, 0, 21, 'Sales Statistics', '', 'sales/qry/salesStatistics', NULL, 'sales/qry/salesStatistics', NULL, NULL),
(13022022, 13022, 1302, 127, 1, 3, 0, 22, 'Compare Sales in Periods', '', 'sales/qry/salesComparePeriods', NULL, 'sales/qry/salesComparePeriods', NULL, NULL),
(13022031, 13022, 1302, 127, 1, 3, 0, 31, 'Price Lists', '', 'sales/qry/priceList', NULL, 'sales/qry/priceList', NULL, NULL),
(13022032, 13022, 1302, 127, 1, 3, 0, 32, 'Sales Commissions', '', 'sales/qry/salesCommissions', NULL, 'sales/qry/salesCommissions', NULL, NULL),
(13023011, 13023, 1302, 127, 1, 3, 0, 11, 'Sales Representatives', '', 'sales/representative', NULL, 'sales/representative', NULL, NULL),
(14021011, 14021, 1402, 127, 1, 3, 0, 11, 'Purchase', '', 'pur/purchase', NULL, 'pur/purchase', NULL, NULL),
(14021012, 14021, 1402, 127, 1, 3, 0, 12, 'Purchase Returns', '', 'pur/purchaseReturn', NULL, 'pur/purchaseReturn', NULL, NULL),
(14021021, 14021, 1402, 127, 1, 3, 0, 21, 'Purchase Request', '', 'pur/purchaseRequest', NULL, 'pur/purchaseRequest', NULL, NULL),
(14021022, 14021, 1402, 127, 1, 3, 0, 22, 'Purchase Orders', '', 'pur/purchaseOrder', NULL, 'pur/purchaseOrder', NULL, NULL),
(14021023, 14021, 1402, 127, 1, 3, 0, 23, 'Proforma Invoice', '', 'pur/proforma', NULL, 'pur/proforma', NULL, NULL),
(14021024, 14021, 1402, 127, 1, 3, 0, 24, 'Proforma Invoice Expenses', '', 'pur/proformaExpense', NULL, 'pur/proformaExpense', NULL, NULL),
(14021025, 14021, 1402, 127, 1, 3, 0, 25, 'Costing Proforma Invoice', '', 'pur/closingProforma', NULL, 'pur/closingProforma', NULL, NULL),
(14021026, 14021, 1402, 127, 1, 3, 0, 26, 'Prepare Final Invoice', '', 'pur/prepareFinalInvoice', NULL, 'pur/prepareFinalInvoice', NULL, NULL),
(14021027, 14021, 1402, 127, 1, 3, 0, 27, 'Final Invoice', '', 'pur/finalInvoice', NULL, 'pur/finalInvoice', NULL, NULL),
(14022011, 14022, 1402, 127, 1, 3, 0, 11, 'Purchase', '', 'pur/qry/purchase', NULL, 'pur/qry/purchase', NULL, NULL),
(14022026, 14022, 1402, 127, 1, 3, 0, 36, 'Prepare Final Invoice', '', 'pur/qry/prepareFinalInvoice', NULL, 'pur/qry/prepareFinalInvoice', NULL, NULL),
(14022031, 14022, 1402, 127, 1, 3, 0, 31, 'Purchase Request', '', 'pur/qry/purchaseRequest', NULL, 'pur/qry/purchaseRequest', NULL, NULL),
(14022033, 14022, 1402, 127, 1, 3, 0, 35, 'Costing Proforma Invoice', '', 'pur/qry/closingProforma', NULL, 'pur/qry/closingProforma', NULL, NULL),
(14022034, 14022, 1402, 127, 1, 3, 0, 34, 'Proforma Invoice Expenses', '', 'pur/qry/proformaExpense', NULL, 'pur/qry/proformaExpense', NULL, NULL),
(14022035, 14022, 1402, 127, 1, 3, 0, 33, 'Proforma Invoice', '', 'pur/qry/proforma', NULL, 'pur/qry/proforma', NULL, NULL),
(14022041, 14022, 1402, 127, 1, 3, 0, 41, 'Purchase Statistics', '', 'pur/qry/proformaStatistics', NULL, 'pur/qry/proformaStatistics', NULL, NULL),
(14023011, 14023, 1402, 127, 1, 3, 0, 11, 'Expenses Type', '', 'pur/expenseType', NULL, 'pur/expenseType', NULL, NULL),
(16011011, 16011, 1601, 127, 1, 3, 0, 11, 'Product Entry Orders', '', 'man/product', NULL, 'man/product', NULL, NULL),
(16011012, 16011, 1601, 127, 1, 3, 0, 12, 'Product Return Orders', '', 'man/productRetrun', NULL, 'man/productRetrun', NULL, NULL),
(16011013, 16011, 1601, 127, 1, 3, 0, 13, 'Transfer Request', '', 'man/transferRequest', NULL, 'man/transferRequest', NULL, NULL),
(16011021, 16011, 1601, 127, 1, 3, 0, 21, 'Manufacturing Orders', '', 'man/manufacturingOrder', NULL, 'man/manufacturingOrder', NULL, NULL),
(16011022, 16011, 1601, 127, 1, 3, 0, 22, 'Manufacturing Orders Workers', '', 'man/manufacturingWorker', NULL, 'man/manufacturingWorker', NULL, NULL),
(16011023, 16011, 1601, 127, 1, 3, 0, 23, 'Manufacturing Orders Machines', '', 'man/manufacturingMachine', NULL, 'man/manufacturingMachine', NULL, NULL),
(16011024, 16011, 1601, 127, 1, 3, 0, 24, 'Manufacturing Orders Expenses', '', 'man/manufacturingExpense', NULL, 'man/manufacturingExpense', NULL, NULL),
(16011025, 16011, 1601, 127, 1, 3, 0, 25, 'Manufacturing Orders Follow Up', '', 'man/manufacturingFollowup', NULL, 'man/manufacturingFollowup', NULL, NULL),
(16012011, 16012, 1601, 127, 1, 3, 0, 11, 'Plans', NULL, 'man/qry/plans', NULL, 'man/qry/plans', NULL, NULL),
(16012012, 16012, 1601, 127, 1, 3, 0, 12, 'Possibility Plan Materials', '', 'man/qry/possibilityPlanMaterials', NULL, 'man/qry/possibilityPlanMaterials', NULL, NULL),
(16012013, 16012, 1601, 127, 1, 3, 0, 13, 'Needed Plan Materials', '', 'man/qry/neededPlanMaterials', NULL, 'man/qry/neededPlanMaterials', NULL, NULL),
(16012021, 16012, 1601, 127, 1, 3, 0, 21, 'Manufacturing Orders', '', 'man/qry/manufactureOrder', NULL, 'man/qry/manufactureOrder', NULL, NULL),
(16012022, 16012, 1601, 127, 1, 3, 0, 22, 'Manufacturing Orders Products', '', 'man/qry/manufactureProduct', NULL, 'man/qry/manufactureProduct', NULL, NULL),
(16012023, 16012, 1601, 127, 1, 3, 0, 23, 'Manufacturing Orders Wastes', '', 'man/qry/manufactureWastes', NULL, 'man/qry/manufactureWastes', NULL, NULL),
(16013011, 16013, 1601, 127, 1, 3, 0, 11, 'Production Plans', '', 'man/productoinPlane', NULL, 'man/productoinPlane', NULL, NULL),
(16013021, 16013, 1601, 127, 1, 3, 0, 21, 'Expenses Type', '', 'man/expenseType', NULL, 'man/expenseType', NULL, NULL),
(16013022, 16013, 1601, 127, 1, 3, 0, 22, 'Semi-Finished Materials', '', 'man/semiFinishedMaterial', NULL, 'man/semiFinishedMaterial', NULL, NULL),
(16013031, 16013, 1601, 127, 1, 3, 0, 31, 'Production Stages', '', 'man/productionStages', NULL, 'man/productionStages', NULL, NULL),
(16013032, 16013, 1601, 127, 1, 3, 0, 32, 'Production Formola', '', 'man/productionFormola', NULL, 'man/productionFormola', NULL, NULL),
(70301031, 7030103, 7030, 127, 2, 3, 0, 1, 'Invoices', 'la la-file-invoice-dollar', 'clinic/finInvoices', NULL, 'clinic/finInvoices', NULL, NULL),
(70301032, 7030103, 7030, 127, 1, 3, 0, 2, 'Payments', 'la la-file-invoice-dollar', 'clinic/finPayments', NULL, 'clinic/finPayments', NULL, NULL),
(70301033, 7030103, 7030, 127, 1, 3, 0, 3, 'Refunds', 'la la-file-invoice-dollar', 'clinic/finRefunds', NULL, 'clinic/finRefunds', NULL, NULL),
(70301034, 7030103, 7030, 127, 1, 3, 0, 4, 'Discounts', 'la la-file-invoice-dollar', 'clinic/finDiscounts', NULL, 'clinic/finDiscounts', NULL, NULL),
(70301071, 7030107, 7030, 127, 1, 3, 0, 1, 'Appointments', NULL, 'clinic/qry/appointments', NULL, 'clinic/qry/appointments', NULL, NULL),
(70301072, 7030107, 7030, 127, 1, 3, 0, 2, 'Patient History', NULL, 'clinic/qry/patientHistory', NULL, 'clinic/qry/patientHistory', NULL, NULL),
(70301073, 7030107, 7030, 127, 1, 3, 0, 3, 'Appointment List', NULL, 'clinic/qry/appointmentList', NULL, 'clinic/qry/appointmentList', NULL, NULL),
(70301081, 7030108, 7030, 127, 1, 3, 0, 1, 'Clinics', 'fas fa-clinic-medical', 'clinic/clinics', NULL, 'clinic/clinics', NULL, NULL),
(70301082, 7030108, 7030, 127, 1, 3, 0, 2, 'Appointment Types', 'flaticon-calendar-2', 'clinic/appointmentTypes', NULL, 'clinic/appointmentTypes', NULL, NULL),
(70301083, 7030108, 7030, 127, 1, 3, 0, 3, 'Procedure Categories', 'flaticon2-writing', 'clinic/procedureCategories', NULL, 'clinic/procedureCategories', NULL, NULL),
(70301084, 7030108, 7030, 127, 1, 3, 0, 4, 'Procedures', 'flaticon-list', 'clinic/procedures', NULL, 'clinic/procedures', NULL, NULL),
(70301089, 7030108, 7030, -1, 1, 3, 0, 99, 'Permissions', 'flaticon-list-3', 'pages/permissions', NULL, 'assets/js/pages/permission.js', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_sequence`
--

DROP TABLE IF EXISTS `phs_sequence`;
CREATE TABLE IF NOT EXISTS `phs_sequence` (
  `name` varchar(100) NOT NULL COMMENT 'Sequence Name',
  `increment` int(11) NOT NULL DEFAULT '1' COMMENT 'Incremented Value',
  `min_value` int(11) NOT NULL DEFAULT '0' COMMENT 'Minimum Value',
  `max_value` bigint(20) NOT NULL DEFAULT '9223372036854775807' COMMENT 'Maximum Value',
  `cur_value` bigint(20) DEFAULT '0' COMMENT 'Current Value',
  `cycle` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cycle Flag',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_sequence`
--

INSERT INTO `phs_sequence` (`name`, `increment`, `min_value`, `max_value`, `cur_value`, `cycle`) VALUES
('inv', 1, 0, 9223372036854775807, 57, 0),
('MM', 1, 0, 9223372036854775807, 1998, 0),
('MS', 1, 0, 9223372036854775807, 999, 0);

-- --------------------------------------------------------

--
-- Table structure for table `phs_system`
--

DROP TABLE IF EXISTS `phs_system`;
CREATE TABLE IF NOT EXISTS `phs_system` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_system`
--

INSERT INTO `phs_system` (`id`, `status_id`, `name`) VALUES
(0, 1, 'Public'),
(1100, 1, 'Accounting'),
(1101, 2, 'Finance'),
(1102, 2, 'Cash'),
(1103, 2, 'Bank'),
(1131, 2, 'HR'),
(1132, 2, 'Attendance'),
(1133, 2, 'Payroll'),
(1201, 1, 'Warehouses'),
(1302, 2, 'Sales'),
(1402, 2, 'Purchases'),
(1601, 2, 'Manufacture'),
(7001, 2, 'CRM'),
(7002, 1, 'Fund Diary'),
(7020, 2, 'Maintenance'),
(7030, 1, 'Clininc'),
(8001, 2, 'Services'),
(9001, 1, 'Management'),
(9901, 1, 'User'),
(9909, 1, 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `phs_token`
--

DROP TABLE IF EXISTS `phs_token`;
CREATE TABLE IF NOT EXISTS `phs_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `gid` varchar(50) NOT NULL COMMENT 'GUID',
  `user_id` int(11) NOT NULL COMMENT 'User',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `sdate` datetime NOT NULL COMMENT 'Start',
  `edate` datetime NOT NULL COMMENT 'End',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gid` (`gid`),
  KEY `phs_token_ibfk_2` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `phs_vprogram`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `phs_vprogram`;
CREATE TABLE IF NOT EXISTS `phs_vprogram` (
`id` int(11)
,`prog_id` int(11)
,`name` varchar(100)
,`ord` smallint(6)
,`icon` varchar(50)
,`grp_id` tinyint(4)
,`open` tinyint(4)
,`status_id` tinyint(4)
,`status_name` varchar(100)
,`file` varchar(100)
,`css` varchar(100)
,`js` varchar(100)
,`attributes` varchar(512)
,`params` varchar(1024)
,`sys_id` int(11)
,`sys_status_id` tinyint(4)
,`sys_name` varchar(100)
,`type_id` tinyint(4)
,`type_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `str_acmst`
--

DROP TABLE IF EXISTS `str_acmst`;
CREATE TABLE IF NOT EXISTS `str_acmst` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `stor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Store',
  `wper_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Workperiod',
  `doc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Document',
  `docn` varchar(10) DEFAULT NULL COMMENT 'Document Number',
  `docd` date DEFAULT NULL COMMENT 'Document Date',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT 'Number',
  `date` date NOT NULL COMMENT 'Date',
  `person` varchar(100) DEFAULT NULL COMMENT 'Person Name',
  `phone` varchar(100) DEFAULT NULL COMMENT 'Person Phone',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk00` (`wper_id`,`stor_id`,`num`),
  KEY `stor_id` (`stor_id`),
  KEY `wper_id` (`wper_id`),
  KEY `doc_id` (`doc_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_actrn`
--

DROP TABLE IF EXISTS `str_actrn`;
CREATE TABLE IF NOT EXISTS `str_actrn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mst_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Master',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Item',
  `ics_id` int(11) DEFAULT NULL COMMENT 'Item Classification',
  `sics_id` int(11) DEFAULT NULL COMMENT 'Store Item Classification',
  `unit_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Unit',
  `color_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Color',
  `size_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Size',
  `ord` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `uperc` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Unit Percent to Default Unit',
  `qnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Quantity',
  `wqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Weight',
  `sqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Quantity',
  `swqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Weight',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `camt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Currency Amount',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `cost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Cost',
  `length` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Length',
  `width` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Width',
  `height` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Height',
  `barcode` varchar(100) DEFAULT NULL COMMENT 'Barcode',
  `model` varchar(100) DEFAULT NULL COMMENT 'Model',
  `lotser` varchar(100) DEFAULT NULL COMMENT 'Lot/Serail',
  `sdate` date DEFAULT NULL COMMENT 'Start Date',
  `edate` date DEFAULT NULL COMMENT 'End Date',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`mst_id`),
  KEY `item_id` (`item_id`),
  KEY `ics_id` (`ics_id`),
  KEY `sics_id` (`sics_id`),
  KEY `unit_id` (`unit_id`),
  KEY `color_id` (`color_id`),
  KEY `size_id` (`size_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_loc1`
--

DROP TABLE IF EXISTS `str_cod_loc1`;
CREATE TABLE IF NOT EXISTS `str_cod_loc1` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_loc1`
--

INSERT INTO `str_cod_loc1` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:21', -9, '2022-02-03 10:21:21'),
(1, 'الشهبندر', '', -9, '2022-02-03 10:21:21', 0, '2022-05-07 13:12:29'),
(2, 'المالكي', '', -9, '2022-02-03 10:21:21', 0, '2022-05-07 13:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_loc2`
--

DROP TABLE IF EXISTS `str_cod_loc2`;
CREATE TABLE IF NOT EXISTS `str_cod_loc2` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_loc2`
--

INSERT INTO `str_cod_loc2` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:21', -9, '2022-02-03 10:21:21'),
(1, 'الصالة', '', 0, '2022-05-07 13:13:23', -9, '2022-05-07 13:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_loc3`
--

DROP TABLE IF EXISTS `str_cod_loc3`;
CREATE TABLE IF NOT EXISTS `str_cod_loc3` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_loc3`
--

INSERT INTO `str_cod_loc3` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:21', -9, '2022-02-03 10:21:21'),
(1, 'غرفة المعالجة', '', 0, '2022-05-07 13:13:37', -9, '2022-05-07 13:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_spc1`
--

DROP TABLE IF EXISTS `str_cod_spc1`;
CREATE TABLE IF NOT EXISTS `str_cod_spc1` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_spc1`
--

INSERT INTO `str_cod_spc1` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:21', -9, '2022-02-03 10:21:21'),
(1, 'حشوات', '', 0, '2022-05-07 15:07:25', -9, '2022-05-07 15:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_spc2`
--

DROP TABLE IF EXISTS `str_cod_spc2`;
CREATE TABLE IF NOT EXISTS `str_cod_spc2` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_spc2`
--

INSERT INTO `str_cod_spc2` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:21', -9, '2022-02-03 10:21:21'),
(1, 'سيراميك', '', 0, '2022-05-07 15:07:36', -9, '2022-05-07 15:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_spc3`
--

DROP TABLE IF EXISTS `str_cod_spc3`;
CREATE TABLE IF NOT EXISTS `str_cod_spc3` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_spc3`
--

INSERT INTO `str_cod_spc3` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22'),
(1, 'زيركون', '', 0, '2022-05-07 15:07:59', 0, '2022-05-07 15:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_spc4`
--

DROP TABLE IF EXISTS `str_cod_spc4`;
CREATE TABLE IF NOT EXISTS `str_cod_spc4` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_spc4`
--

INSERT INTO `str_cod_spc4` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_spc5`
--

DROP TABLE IF EXISTS `str_cod_spc5`;
CREATE TABLE IF NOT EXISTS `str_cod_spc5` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_spc5`
--

INSERT INTO `str_cod_spc5` (`id`, `name`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 'None', NULL, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `str_cod_trn_type`
--

DROP TABLE IF EXISTS `str_cod_trn_type`;
CREATE TABLE IF NOT EXISTS `str_cod_trn_type` (
  `id` smallint(6) NOT NULL COMMENT 'PK',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Kind',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_cod_trn_type`
--

INSERT INTO `str_cod_trn_type` (`id`, `name`, `rem`, `kind`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(100, 'إدخال', NULL, 1, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22'),
(150, 'إدخال ترحيل', NULL, 1, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22'),
(200, 'إخراج', NULL, 2, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22'),
(250, 'إخراج ترحيل', NULL, 2, -9, '2022-02-03 10:21:22', -9, '2022-02-03 10:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `str_inmst`
--

DROP TABLE IF EXISTS `str_inmst`;
CREATE TABLE IF NOT EXISTS `str_inmst` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `stor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Store',
  `src_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Document Source',
  `trntype_id` smallint(6) NOT NULL DEFAULT '100' COMMENT 'Transaction Type',
  `wper_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Workperiod',
  `acc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Account',
  `cost_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Center',
  `rel_id` int(11) DEFAULT NULL COMMENT 'Related',
  `vhr_id` int(11) DEFAULT NULL COMMENT 'Voucher',
  `fin_id` int(11) DEFAULT NULL COMMENT 'Finance',
  `curn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Currency',
  `bcurn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Base Currency',
  `curn_rate` decimal(10,5) NOT NULL DEFAULT '1.00000' COMMENT 'Currency Rate',
  `bcurn_rate` decimal(10,5) NOT NULL DEFAULT '1.00000' COMMENT 'Base Rate',
  `doc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Document',
  `docn` varchar(10) DEFAULT NULL COMMENT 'Document Number',
  `docd` date DEFAULT NULL COMMENT 'Document Date',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT 'Number',
  `date` date NOT NULL COMMENT 'Date',
  `person` varchar(100) DEFAULT NULL COMMENT 'Person Name',
  `phone` varchar(100) DEFAULT NULL COMMENT 'Person Phone',
  `rem` varchar(200) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk00` (`stor_id`,`wper_id`,`trntype_id`,`num`) USING BTREE,
  KEY `stor_id` (`stor_id`),
  KEY `src_id` (`src_id`),
  KEY `wper_id` (`wper_id`),
  KEY `acc_id` (`acc_id`),
  KEY `cost_id` (`cost_id`),
  KEY `rel_id` (`rel_id`),
  KEY `vhr_id` (`vhr_id`),
  KEY `fin_id` (`fin_id`),
  KEY `doc_id` (`doc_id`),
  KEY `curn_id` (`curn_id`),
  KEY `str_inmst_ibfk_7` (`trntype_id`),
  KEY `bcurn_id` (`bcurn_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_intrn`
--

DROP TABLE IF EXISTS `str_intrn`;
CREATE TABLE IF NOT EXISTS `str_intrn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mst_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Master',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Item',
  `rel_id` int(11) DEFAULT NULL COMMENT 'Related',
  `ics_id` int(11) DEFAULT NULL COMMENT 'Item Classification',
  `sics_id` int(11) DEFAULT NULL COMMENT 'Store Item Classification',
  `unit_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Unit',
  `color_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Color',
  `size_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Size',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `uperc` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Unit Percent to Default Unit',
  `qnt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Quantity',
  `wqnt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Weight',
  `cqnt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Quantity',
  `cwqnt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Weight',
  `sqnt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Quantity',
  `swqnt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Weight',
  `price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `camt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Currency Amount',
  `bamt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Currency Amount',
  `amt` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `cost` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Cost',
  `bcost` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Currency Cost',
  `length` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Length',
  `width` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Width',
  `height` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT 'Height',
  `barcode` varchar(100) DEFAULT NULL COMMENT 'Barcode',
  `model` varchar(100) DEFAULT NULL COMMENT 'Model',
  `lotser` varchar(100) DEFAULT NULL COMMENT 'Lot/Serail',
  `sdate` date DEFAULT NULL COMMENT 'Start Date',
  `edate` date DEFAULT NULL COMMENT 'End Date',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`mst_id`),
  KEY `item_id` (`item_id`),
  KEY `ics_id` (`ics_id`),
  KEY `sics_id` (`sics_id`),
  KEY `unit_id` (`unit_id`),
  KEY `rel_id` (`rel_id`),
  KEY `color_id` (`color_id`),
  KEY `size_id` (`size_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_item`
--

DROP TABLE IF EXISTS `str_item`;
CREATE TABLE IF NOT EXISTS `str_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `num` varchar(15) NOT NULL COMMENT 'Number',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `partnum` varchar(15) NOT NULL COMMENT 'Part Number - Vendor Number',
  `type_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Type 1 Row material / 2 Product',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status 1 Active / 2 Disabled',
  `costtype_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Cost Type, 1 Average / 2 By Method',
  `method_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Method Type 1 normal / 2 fifo / 3 lifo / 4 serial / 5 lot / 6 manual',
  `unit_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Unit',
  `insale_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Is Item On Sale',
  `season_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Is Season Item 1 Normal / 2 Season Item',
  `warnty_days` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Waranty Days',
  `nofp` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Number of Pricing',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Category',
  `spc1_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Classification 1',
  `spc2_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Classification 2',
  `spc3_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Classification 3',
  `spc4_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Classification 4',
  `spc5_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Classification 5',
  `min_unit` decimal(10,3) NOT NULL DEFAULT '1.000' COMMENT 'Minimum Unit of Item',
  `fqnt` decimal(10,3) NOT NULL DEFAULT '1.000' COMMENT 'Formula Quantity',
  `box` decimal(10,3) NOT NULL DEFAULT '1.000' COMMENT 'Box Capacity',
  `ccost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'The current cost in the market ',
  `nprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Normal Price',
  `dprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Discount Price',
  `sprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Sale Price',
  `wprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Wholesale Price',
  `rprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Retail Price',
  `hprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Half Wholesale Price',
  `mprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Media Price',
  `image` varchar(512) DEFAULT NULL COMMENT 'Item Image',
  `desc` varchar(1024) DEFAULT NULL COMMENT 'Description',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`num`),
  UNIQUE KEY `name` (`name`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `costtype_id` (`costtype_id`),
  KEY `method_id` (`method_id`),
  KEY `unit_id` (`unit_id`),
  KEY `insale_id` (`insale_id`),
  KEY `season_id` (`season_id`),
  KEY `spc1_id` (`spc1_id`),
  KEY `spc2_id` (`spc2_id`),
  KEY `spc3_id` (`spc3_id`),
  KEY `spc4_id` (`spc4_id`),
  KEY `spc5_id` (`spc5_id`),
  KEY `cat_id` (`cat_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_item`
--

INSERT INTO `str_item` (`id`, `num`, `name`, `partnum`, `type_id`, `status_id`, `costtype_id`, `method_id`, `unit_id`, `insale_id`, `season_id`, `warnty_days`, `nofp`, `cat_id`, `spc1_id`, `spc2_id`, `spc3_id`, `spc4_id`, `spc5_id`, `min_unit`, `fqnt`, `box`, `ccost`, `nprice`, `dprice`, `sprice`, `wprice`, `rprice`, `hprice`, `mprice`, `image`, `desc`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, '1', '1', '1', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '1.000', '1.000', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '', '', -9, '2022-02-03 10:21:26', 0, '2022-05-07 12:54:54'),
(1, '11', '11', '22', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '1.000', '1.000', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '', '', 0, '2022-05-07 12:55:36', 0, '2022-05-07 13:04:09'),
(4, '22', '22', '33', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '1.000', '1.000', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '', '', 0, '2022-05-07 13:00:24', 0, '2022-05-07 13:04:17'),
(5, '33', '33', '44', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '1.000', '1.000', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '', '', 0, '2022-05-07 13:01:14', 0, '2022-05-07 13:04:24'),
(6, '44', '44', '55', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '1.000', '1.000', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '', '', 0, '2022-05-07 13:02:19', 0, '2022-05-07 13:04:34'),
(8, '55', '55', '66', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '1.000', '1.000', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '', '', 0, '2022-05-07 13:03:53', 0, '2022-05-07 13:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `str_itemcat`
--

DROP TABLE IF EXISTS `str_itemcat`;
CREATE TABLE IF NOT EXISTS `str_itemcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `ord` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `image` varchar(512) DEFAULT NULL COMMENT 'Image',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_itemcat`
--

INSERT INTO `str_itemcat` (`id`, `ord`, `name`, `image`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(0, 0, 'بلا', NULL, -9, '2022-02-03 10:21:27', -9, '2022-02-03 10:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `str_oumst`
--

DROP TABLE IF EXISTS `str_oumst`;
CREATE TABLE IF NOT EXISTS `str_oumst` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `stor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Store',
  `src_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Document Source',
  `trntype_id` smallint(6) NOT NULL DEFAULT '200' COMMENT 'Transaction Type',
  `wper_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Workperiod',
  `acc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Account',
  `cost_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Center',
  `rel_id` int(11) DEFAULT NULL COMMENT 'Related',
  `vhr_id` int(11) DEFAULT NULL COMMENT 'Voucher',
  `fin_id` int(11) DEFAULT NULL COMMENT 'Finance',
  `curn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Currency',
  `bcurn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Base Currency',
  `curn_rate` decimal(10,5) NOT NULL DEFAULT '1.00000' COMMENT 'Currency Rate',
  `bcurn_rate` decimal(10,5) NOT NULL DEFAULT '1.00000' COMMENT 'Base Rate',
  `doc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Document',
  `docn` varchar(10) DEFAULT NULL COMMENT 'Document Number',
  `docd` date DEFAULT NULL COMMENT 'Document Date',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT 'Number',
  `date` date NOT NULL COMMENT 'Date',
  `person` varchar(100) DEFAULT NULL COMMENT 'Person Name',
  `phone` varchar(100) DEFAULT NULL COMMENT 'Person Phone',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk00` (`stor_id`,`wper_id`,`trntype_id`,`num`) USING BTREE,
  KEY `stor_id` (`stor_id`),
  KEY `src_id` (`src_id`),
  KEY `wper_id` (`wper_id`),
  KEY `acc_id` (`acc_id`),
  KEY `cost_id` (`cost_id`),
  KEY `rel_id` (`rel_id`),
  KEY `vhr_id` (`vhr_id`),
  KEY `fin_id` (`fin_id`),
  KEY `doc_id` (`doc_id`),
  KEY `curn_id` (`curn_id`),
  KEY `str_oumst_ibfk_7` (`trntype_id`),
  KEY `bcurn_id` (`bcurn_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_outrn`
--

DROP TABLE IF EXISTS `str_outrn`;
CREATE TABLE IF NOT EXISTS `str_outrn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mst_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Master',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Item',
  `rel_id` int(11) DEFAULT NULL COMMENT 'Related',
  `ics_id` int(11) DEFAULT NULL COMMENT 'Item Classification',
  `sics_id` int(11) DEFAULT NULL COMMENT 'Store Item Classification',
  `unit_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Unit',
  `color_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Color',
  `size_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Size',
  `ord` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `uperc` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Unit Percent to Default Unit',
  `qnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Quantity',
  `wqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Weight',
  `cqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Quantity',
  `cwqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Weight',
  `sqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Quantity',
  `swqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Weight',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `camt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Currency Amount',
  `bamt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Currency Amount',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `cost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Cost',
  `bcost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Currency Cost',
  `length` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Length',
  `width` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Width',
  `height` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Height',
  `barcode` varchar(100) DEFAULT NULL COMMENT 'Barcode',
  `model` varchar(100) DEFAULT NULL COMMENT 'Model',
  `lotser` varchar(100) DEFAULT NULL COMMENT 'Lot/Serail',
  `sdate` date DEFAULT NULL COMMENT 'Start Date',
  `edate` date DEFAULT NULL COMMENT 'End Date',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`mst_id`),
  KEY `item_id` (`item_id`),
  KEY `ics_id` (`ics_id`),
  KEY `sics_id` (`sics_id`),
  KEY `unit_id` (`unit_id`),
  KEY `rel_id` (`rel_id`),
  KEY `color_id` (`color_id`),
  KEY `size_id` (`size_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_sitem`
--

DROP TABLE IF EXISTS `str_sitem`;
CREATE TABLE IF NOT EXISTS `str_sitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `stor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Store',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Item',
  `loc1_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Location 1',
  `loc2_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Location 2',
  `loc3_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Location 3',
  `cost_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Center',
  `acc_sid` int(11) NOT NULL DEFAULT '0' COMMENT 'Inventory Account',
  `acc_cid` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Account',
  `acc_rid` int(11) NOT NULL DEFAULT '0' COMMENT 'Revenue Account',
  `acc_mid` int(11) NOT NULL DEFAULT '0' COMMENT 'Commission Account',
  `acc_did` int(11) NOT NULL DEFAULT '0' COMMENT 'Discount Account',
  `cqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Quantity',
  `cwqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Weight',
  `cost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Current Cost',
  `bcost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Base Currency Cost',
  `bqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Booked Quantity',
  `bwqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Booked Weight',
  `qmin` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity',
  `qreq` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity',
  `qmax` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity',
  `qmin1` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 1',
  `qreq1` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 1',
  `qmax1` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 1',
  `qmin2` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 2',
  `qreq2` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 2',
  `qmax2` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 2',
  `qmin3` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 3',
  `qreq3` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 3',
  `qmax3` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 3',
  `qmin4` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 4',
  `qreq4` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 4',
  `qmax4` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 4',
  `qmin5` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 5',
  `qreq5` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 5',
  `qmax5` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 5',
  `qmin6` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 6',
  `qreq6` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 6',
  `qmax6` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 6',
  `qmin7` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 7',
  `qreq7` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 7',
  `qmax7` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 7',
  `qmin8` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 8',
  `qreq8` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 8',
  `qmax8` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 8',
  `qmin9` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 9',
  `qreq9` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 9',
  `qmax9` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 9',
  `qmin10` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 10',
  `qreq10` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 10',
  `qmax10` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 10',
  `qmin11` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 11',
  `qreq11` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 11',
  `qmax11` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 11',
  `qmin12` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Minimum Limit Quantity For Month 12',
  `qreq12` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Request Limit Quantity For Month 12',
  `qmax12` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Maximum Store Limit Quantity For Month 12',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `stor_item` (`stor_id`,`item_id`),
  KEY `loc1_id` (`loc1_id`),
  KEY `loc2_id` (`loc2_id`),
  KEY `loc3_id` (`loc3_id`),
  KEY `cost_id` (`cost_id`),
  KEY `acc_sid` (`acc_sid`),
  KEY `acc_cid` (`acc_cid`),
  KEY `acc_rid` (`acc_rid`),
  KEY `acc_mid` (`acc_mid`),
  KEY `acc_did` (`acc_did`),
  KEY `item_id` (`item_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_store`
--

DROP TABLE IF EXISTS `str_store`;
CREATE TABLE IF NOT EXISTS `str_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `num` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Number',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `type_id` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Type Head / Active',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `sales_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Is Sales Store',
  `isowned` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Is Owned',
  `cost_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Center',
  `acc_sid` int(11) NOT NULL DEFAULT '0' COMMENT 'Inventory Account',
  `acc_cid` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Account',
  `acc_rid` int(11) NOT NULL DEFAULT '0' COMMENT 'Revenue Account',
  `acc_mid` int(11) NOT NULL DEFAULT '0' COMMENT 'Commission Account',
  `acc_did` int(11) NOT NULL DEFAULT '0' COMMENT 'Discount Account',
  `sdate` date NOT NULL COMMENT 'Start Date',
  `edate` date NOT NULL COMMENT 'End Date',
  `address` varchar(25) DEFAULT NULL COMMENT 'Address',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`num`),
  UNIQUE KEY `name` (`name`),
  KEY `typ_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `sales_id` (`sales_id`),
  KEY `isowned` (`isowned`),
  KEY `cost_id` (`cost_id`),
  KEY `acc_sid` (`acc_sid`),
  KEY `acc_cid` (`acc_cid`),
  KEY `acc_rid` (`acc_rid`),
  KEY `acc_mid` (`acc_mid`),
  KEY `acc_did` (`acc_did`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `str_store`
--

INSERT INTO `str_store` (`id`, `num`, `name`, `type_id`, `status_id`, `sales_id`, `isowned`, `cost_id`, `acc_sid`, `acc_cid`, `acc_rid`, `acc_mid`, `acc_did`, `sdate`, `edate`, `address`, `rem`, `ins_user`, `ins_date`, `upd_user`, `upd_date`) VALUES
(1, 1, 'الرئيسي', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, '2022-01-01', '2099-12-31', '', '', -9, '2022-02-03 10:21:29', 0, '2022-05-07 15:25:26');

-- --------------------------------------------------------

--
-- Table structure for table `str_trmst`
--

DROP TABLE IF EXISTS `str_trmst`;
CREATE TABLE IF NOT EXISTS `str_trmst` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `fstor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'From Store',
  `tstor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'To Store',
  `src_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Document Source',
  `ftrntype_id` smallint(6) NOT NULL DEFAULT '150' COMMENT 'From Transaction Type',
  `ttrntype_id` smallint(6) NOT NULL DEFAULT '250' COMMENT 'To Transaction Type',
  `wper_id` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Workperiod',
  `acc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Account',
  `cost_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Cost Center',
  `vhr_id` int(11) DEFAULT NULL COMMENT 'Voucher',
  `fin_id` int(11) DEFAULT NULL COMMENT 'Finance',
  `curn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Currency',
  `bcurn_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Base Currency',
  `curn_rate` decimal(10,5) NOT NULL DEFAULT '1.00000' COMMENT 'Currency Rate',
  `bcurn_rate` decimal(10,5) NOT NULL DEFAULT '1.00000',
  `doc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Document',
  `docn` varchar(10) DEFAULT NULL COMMENT 'Document Number',
  `docd` date DEFAULT NULL COMMENT 'Document Date',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT 'Number',
  `date` date NOT NULL COMMENT 'Date',
  `fperson` varchar(100) DEFAULT NULL COMMENT 'From Person Name',
  `fphone` varchar(100) DEFAULT NULL COMMENT 'From Person Phone',
  `rperson` varchar(100) DEFAULT NULL COMMENT 'From Person Name',
  `rphone` varchar(100) DEFAULT NULL COMMENT 'From Person Phone',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk00` (`wper_id`,`fstor_id`,`ftrntype_id`,`num`),
  KEY `fstor_id` (`fstor_id`),
  KEY `tstor_id` (`tstor_id`),
  KEY `ftrntype_id` (`ftrntype_id`),
  KEY `ttrntype_id` (`ttrntype_id`),
  KEY `src_id` (`src_id`),
  KEY `wper_id` (`wper_id`),
  KEY `acc_id` (`acc_id`),
  KEY `cost_id` (`cost_id`),
  KEY `vhr_id` (`vhr_id`),
  KEY `fin_id` (`fin_id`),
  KEY `doc_id` (`doc_id`),
  KEY `curn_id` (`curn_id`),
  KEY `bcurn_id` (`bcurn_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_trtrn`
--

DROP TABLE IF EXISTS `str_trtrn`;
CREATE TABLE IF NOT EXISTS `str_trtrn` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `mst_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Master',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Item',
  `ics_id` int(11) DEFAULT NULL COMMENT 'Item Classification',
  `fsics_id` int(11) DEFAULT NULL COMMENT 'From Store Item Classification',
  `tsics_id` int(11) DEFAULT NULL COMMENT 'To Store Item Classification',
  `unit_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Unit',
  `color_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Color',
  `size_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Size',
  `ord` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `uperc` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Unit Percent to Default Unit',
  `qnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Quantity',
  `wqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Weight',
  `sqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Quantity',
  `swqnt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Store Weight',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Price',
  `camt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Currency Amount',
  `amt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Amount',
  `cost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Cost',
  `length` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Length',
  `width` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Width',
  `height` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Height',
  `barcode` varchar(100) DEFAULT NULL COMMENT 'Barcode',
  `model` varchar(100) DEFAULT NULL COMMENT 'Model',
  `lotser` varchar(100) DEFAULT NULL COMMENT 'Lot/Serail',
  `sdate` date DEFAULT NULL COMMENT 'Start Date',
  `edate` date DEFAULT NULL COMMENT 'End Date',
  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',
  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',
  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`mst_id`),
  KEY `item_id` (`item_id`),
  KEY `ics_id` (`ics_id`),
  KEY `fsics_id` (`fsics_id`),
  KEY `tsics_id` (`tsics_id`),
  KEY `unit_id` (`unit_id`),
  KEY `color_id` (`color_id`),
  KEY `size_id` (`size_id`),
  KEY `ins_user` (`ins_user`),
  KEY `upd_user` (`upd_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vdocs`
--

DROP TABLE IF EXISTS `str_vdocs`;
CREATE TABLE IF NOT EXISTS `str_vdocs` (
  `mst_id` int(11) DEFAULT NULL,
  `src_id` smallint(6) DEFAULT NULL,
  `trntype_id` smallint(6) DEFAULT NULL,
  `mrel_id` int(11) DEFAULT NULL,
  `vhr_id` int(11) DEFAULT NULL,
  `fin_id` int(11) DEFAULT NULL,
  `curn_rate` decimal(10,5) DEFAULT NULL,
  `bcurn_rate` decimal(10,5) DEFAULT NULL,
  `mst_docn` varchar(10) DEFAULT NULL,
  `mst_docd` date DEFAULT NULL,
  `mst_num` int(11) DEFAULT NULL,
  `mst_date` date DEFAULT NULL,
  `mst_person` varchar(100) DEFAULT NULL,
  `mst_phone` varchar(100) DEFAULT NULL,
  `mst_rem` varchar(200) DEFAULT NULL,
  `wper_id` smallint(6) DEFAULT NULL,
  `wper_name` varchar(100) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_num` smallint(6) DEFAULT NULL,
  `stor_name` varchar(100) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `acc_num` varchar(15) DEFAULT NULL,
  `acc_name` varchar(100) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `cost_num` varchar(15) DEFAULT NULL,
  `cost_name` varchar(100) DEFAULT NULL,
  `curn_id` int(11) DEFAULT NULL,
  `curn_num` smallint(6) DEFAULT NULL,
  `curn_code` varchar(10) DEFAULT NULL,
  `curn_name` varchar(100) DEFAULT NULL,
  `bcurn_id` int(11) DEFAULT NULL,
  `bcurn_num` smallint(6) DEFAULT NULL,
  `bcurn_code` varchar(10) DEFAULT NULL,
  `bcurn_name` varchar(100) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL,
  `trn_id` int(11) DEFAULT NULL,
  `trel_id` int(11) DEFAULT NULL,
  `ics_id` int(11) DEFAULT NULL,
  `sics_id` int(11) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `color_name` varchar(100) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_num` varchar(15) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_partnum` varchar(15) DEFAULT NULL,
  `item_type_id` tinyint(4) DEFAULT NULL,
  `item_status_id` tinyint(4) DEFAULT NULL,
  `item_costtype_id` tinyint(4) DEFAULT NULL,
  `item_method_id` tinyint(4) DEFAULT NULL,
  `item_unit_id` tinyint(4) DEFAULT NULL,
  `item_insale_id` tinyint(4) DEFAULT NULL,
  `item_season_id` tinyint(4) DEFAULT NULL,
  `item_warnty_days` smallint(6) DEFAULT NULL,
  `item_nofp` smallint(6) DEFAULT NULL,
  `item_cat_id` int(11) DEFAULT NULL,
  `item_spc1_id` int(11) DEFAULT NULL,
  `item_spc2_id` int(11) DEFAULT NULL,
  `item_spc3_id` int(11) DEFAULT NULL,
  `item_spc4_id` int(11) DEFAULT NULL,
  `item_spc5_id` int(11) DEFAULT NULL,
  `item_min_unit` decimal(10,3) DEFAULT NULL,
  `item_box` decimal(10,3) DEFAULT NULL,
  `item_ccost` decimal(10,3) DEFAULT NULL,
  `item_nprice` decimal(10,3) DEFAULT NULL,
  `item_dprice` decimal(10,3) DEFAULT NULL,
  `item_sprice` decimal(10,3) DEFAULT NULL,
  `item_wprice` decimal(10,3) DEFAULT NULL,
  `item_rprice` decimal(10,3) DEFAULT NULL,
  `item_hprice` decimal(10,3) DEFAULT NULL,
  `item_mprice` decimal(10,3) DEFAULT NULL,
  `item_image` varchar(512) DEFAULT NULL,
  `item_desc` text,
  `item_rem` varchar(100) DEFAULT NULL,
  `trn_ord` smallint(6) DEFAULT NULL,
  `trn_uperc` decimal(20,3) DEFAULT NULL,
  `trn_qnt` decimal(20,3) DEFAULT NULL,
  `trn_wqnt` decimal(20,3) DEFAULT NULL,
  `trn_cqnt` decimal(20,3) DEFAULT NULL,
  `trn_cwqnt` decimal(20,3) DEFAULT NULL,
  `trn_sqnt` decimal(20,3) DEFAULT NULL,
  `trn_swqnt` decimal(20,3) DEFAULT NULL,
  `trn_price` decimal(20,3) DEFAULT NULL,
  `trn_camt` decimal(20,3) DEFAULT NULL,
  `trn_bamt` decimal(20,3) DEFAULT NULL,
  `trn_amt` decimal(20,3) DEFAULT NULL,
  `trn_cost` decimal(20,3) DEFAULT NULL,
  `trn_bcost` decimal(20,3) DEFAULT NULL,
  `trn_in_qnt` decimal(20,3) DEFAULT NULL,
  `trn_in_wqnt` decimal(20,3) DEFAULT NULL,
  `trn_in_sqnt` decimal(20,3) DEFAULT NULL,
  `trn_in_swqnt` decimal(20,3) DEFAULT NULL,
  `trn_in_price` decimal(20,3) DEFAULT NULL,
  `trn_in_camt` decimal(20,3) DEFAULT NULL,
  `trn_in_bamt` decimal(20,3) DEFAULT NULL,
  `trn_in_amt` decimal(20,3) DEFAULT NULL,
  `trn_in_cost` decimal(20,3) DEFAULT NULL,
  `trn_in_bcost` decimal(20,3) DEFAULT NULL,
  `trn_ou_qnt` decimal(10,3) DEFAULT NULL,
  `trn_ou_wqnt` decimal(10,3) DEFAULT NULL,
  `trn_ou_sqnt` decimal(10,3) DEFAULT NULL,
  `trn_ou_swqnt` decimal(10,3) DEFAULT NULL,
  `trn_ou_price` decimal(10,3) DEFAULT NULL,
  `trn_ou_camt` decimal(10,3) DEFAULT NULL,
  `trn_ou_bamt` decimal(10,3) DEFAULT NULL,
  `trn_ou_amt` decimal(10,3) DEFAULT NULL,
  `trn_ou_cost` decimal(10,3) DEFAULT NULL,
  `trn_ou_bcost` decimal(10,3) DEFAULT NULL,
  `trn_all_qnt` decimal(20,3) DEFAULT NULL,
  `trn_all_wqnt` decimal(20,3) DEFAULT NULL,
  `trn_all_sqnt` decimal(20,3) DEFAULT NULL,
  `trn_all_swqnt` decimal(20,3) DEFAULT NULL,
  `trn_all_price` decimal(20,3) DEFAULT NULL,
  `trn_all_camt` decimal(20,3) DEFAULT NULL,
  `trn_all_bamt` decimal(20,3) DEFAULT NULL,
  `trn_all_amt` decimal(20,3) DEFAULT NULL,
  `trn_all_cost` decimal(20,3) DEFAULT NULL,
  `trn_all_bcost` decimal(20,3) DEFAULT NULL,
  `trn_length` decimal(20,3) DEFAULT NULL,
  `trn_width` decimal(20,3) DEFAULT NULL,
  `trn_height` decimal(20,3) DEFAULT NULL,
  `trn_barcode` varchar(100) DEFAULT NULL,
  `trn_model` varchar(100) DEFAULT NULL,
  `trn_lotser` varchar(100) DEFAULT NULL,
  `trn_sdate` date DEFAULT NULL,
  `trn_edate` date DEFAULT NULL,
  `trn_rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vindocs`
--

DROP TABLE IF EXISTS `str_vindocs`;
CREATE TABLE IF NOT EXISTS `str_vindocs` (
  `mst_id` int(11) DEFAULT NULL,
  `src_id` smallint(6) DEFAULT NULL,
  `trntype_id` smallint(6) DEFAULT NULL,
  `mrel_id` int(11) DEFAULT NULL,
  `vhr_id` int(11) DEFAULT NULL,
  `fin_id` int(11) DEFAULT NULL,
  `curn_rate` decimal(10,5) DEFAULT NULL,
  `bcurn_rate` decimal(10,5) DEFAULT NULL,
  `mst_docn` varchar(10) DEFAULT NULL,
  `mst_docd` date DEFAULT NULL,
  `mst_num` int(11) DEFAULT NULL,
  `mst_date` date DEFAULT NULL,
  `mst_person` varchar(100) DEFAULT NULL,
  `mst_phone` varchar(100) DEFAULT NULL,
  `mst_rem` varchar(200) DEFAULT NULL,
  `wper_id` smallint(6) DEFAULT NULL,
  `wper_name` varchar(100) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_num` smallint(6) DEFAULT NULL,
  `stor_name` varchar(100) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `acc_num` varchar(15) DEFAULT NULL,
  `acc_name` varchar(100) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `cost_num` varchar(15) DEFAULT NULL,
  `cost_name` varchar(100) DEFAULT NULL,
  `curn_id` int(11) DEFAULT NULL,
  `curn_num` smallint(6) DEFAULT NULL,
  `curn_code` varchar(10) DEFAULT NULL,
  `curn_name` varchar(100) DEFAULT NULL,
  `bcurn_id` int(11) DEFAULT NULL,
  `bcurn_num` smallint(6) DEFAULT NULL,
  `bcurn_code` varchar(10) DEFAULT NULL,
  `bcurn_name` varchar(100) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL,
  `trn_id` int(11) DEFAULT NULL,
  `trel_id` int(11) DEFAULT NULL,
  `ics_id` int(11) DEFAULT NULL,
  `sics_id` int(11) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `color_name` varchar(100) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_num` varchar(15) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_partnum` varchar(15) DEFAULT NULL,
  `item_type_id` tinyint(4) DEFAULT NULL,
  `item_status_id` tinyint(4) DEFAULT NULL,
  `item_costtype_id` tinyint(4) DEFAULT NULL,
  `item_method_id` tinyint(4) DEFAULT NULL,
  `item_unit_id` tinyint(4) DEFAULT NULL,
  `item_insale_id` tinyint(4) DEFAULT NULL,
  `item_season_id` tinyint(4) DEFAULT NULL,
  `item_warnty_days` smallint(6) DEFAULT NULL,
  `item_nofp` smallint(6) DEFAULT NULL,
  `item_cat_id` int(11) DEFAULT NULL,
  `item_spc1_id` int(11) DEFAULT NULL,
  `item_spc2_id` int(11) DEFAULT NULL,
  `item_spc3_id` int(11) DEFAULT NULL,
  `item_spc4_id` int(11) DEFAULT NULL,
  `item_spc5_id` int(11) DEFAULT NULL,
  `item_min_unit` decimal(10,3) DEFAULT NULL,
  `item_box` decimal(10,3) DEFAULT NULL,
  `item_ccost` decimal(10,3) DEFAULT NULL,
  `item_nprice` decimal(10,3) DEFAULT NULL,
  `item_dprice` decimal(10,3) DEFAULT NULL,
  `item_sprice` decimal(10,3) DEFAULT NULL,
  `item_wprice` decimal(10,3) DEFAULT NULL,
  `item_rprice` decimal(10,3) DEFAULT NULL,
  `item_hprice` decimal(10,3) DEFAULT NULL,
  `item_mprice` decimal(10,3) DEFAULT NULL,
  `item_image` varchar(512) DEFAULT NULL,
  `item_desc` varchar(1024) DEFAULT NULL,
  `item_rem` varchar(100) DEFAULT NULL,
  `trn_ord` smallint(6) DEFAULT NULL,
  `trn_uperc` decimal(20,3) DEFAULT NULL,
  `trn_qnt` decimal(20,3) DEFAULT NULL,
  `trn_wqnt` decimal(20,3) DEFAULT NULL,
  `trn_cqnt` decimal(20,3) DEFAULT NULL,
  `trn_cwqnt` decimal(20,3) DEFAULT NULL,
  `trn_sqnt` decimal(20,3) DEFAULT NULL,
  `trn_swqnt` decimal(20,3) DEFAULT NULL,
  `trn_price` decimal(20,3) DEFAULT NULL,
  `trn_camt` decimal(20,3) DEFAULT NULL,
  `trn_bamt` decimal(20,3) DEFAULT NULL,
  `trn_amt` decimal(20,3) DEFAULT NULL,
  `trn_cost` decimal(20,3) DEFAULT NULL,
  `trn_bcost` decimal(20,3) DEFAULT NULL,
  `trn_length` decimal(20,3) DEFAULT NULL,
  `trn_width` decimal(20,3) DEFAULT NULL,
  `trn_height` decimal(20,3) DEFAULT NULL,
  `trn_barcode` varchar(100) DEFAULT NULL,
  `trn_model` varchar(100) DEFAULT NULL,
  `trn_lotser` varchar(100) DEFAULT NULL,
  `trn_sdate` date DEFAULT NULL,
  `trn_edate` date DEFAULT NULL,
  `trn_rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vinmst`
--

DROP TABLE IF EXISTS `str_vinmst`;
CREATE TABLE IF NOT EXISTS `str_vinmst` (
  `mst_id` int(11) DEFAULT NULL,
  `src_id` smallint(6) DEFAULT NULL,
  `trntype_id` smallint(6) DEFAULT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `vhr_id` int(11) DEFAULT NULL,
  `fin_id` int(11) DEFAULT NULL,
  `curn_rate` decimal(10,5) DEFAULT NULL,
  `bcurn_rate` decimal(10,5) DEFAULT NULL,
  `mst_docn` varchar(10) DEFAULT NULL,
  `mst_docd` date DEFAULT NULL,
  `mst_num` int(11) DEFAULT NULL,
  `mst_date` date DEFAULT NULL,
  `mst_person` varchar(100) DEFAULT NULL,
  `mst_phone` varchar(100) DEFAULT NULL,
  `mst_rem` varchar(200) DEFAULT NULL,
  `wper_id` smallint(6) DEFAULT NULL,
  `wper_name` varchar(100) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_num` smallint(6) DEFAULT NULL,
  `stor_name` varchar(100) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `acc_num` varchar(15) DEFAULT NULL,
  `acc_name` varchar(100) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `cost_num` varchar(15) DEFAULT NULL,
  `cost_name` varchar(100) DEFAULT NULL,
  `curn_id` int(11) DEFAULT NULL,
  `curn_num` smallint(6) DEFAULT NULL,
  `curn_code` varchar(10) DEFAULT NULL,
  `curn_name` varchar(100) DEFAULT NULL,
  `bcurn_id` int(11) DEFAULT NULL,
  `bcurn_num` smallint(6) DEFAULT NULL,
  `bcurn_code` varchar(10) DEFAULT NULL,
  `bcurn_name` varchar(100) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vintrn`
--

DROP TABLE IF EXISTS `str_vintrn`;
CREATE TABLE IF NOT EXISTS `str_vintrn` (
  `trn_id` int(11) DEFAULT NULL,
  `trel_id` int(11) DEFAULT NULL,
  `ics_id` int(11) DEFAULT NULL,
  `sics_id` int(11) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `color_name` varchar(100) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_num` varchar(15) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_partnum` varchar(15) DEFAULT NULL,
  `item_type_id` tinyint(4) DEFAULT NULL,
  `item_status_id` tinyint(4) DEFAULT NULL,
  `item_costtype_id` tinyint(4) DEFAULT NULL,
  `item_method_id` tinyint(4) DEFAULT NULL,
  `item_unit_id` tinyint(4) DEFAULT NULL,
  `item_insale_id` tinyint(4) DEFAULT NULL,
  `item_season_id` tinyint(4) DEFAULT NULL,
  `item_warnty_days` smallint(6) DEFAULT NULL,
  `item_nofp` smallint(6) DEFAULT NULL,
  `item_cat_id` int(11) DEFAULT NULL,
  `item_spc1_id` int(11) DEFAULT NULL,
  `item_spc2_id` int(11) DEFAULT NULL,
  `item_spc3_id` int(11) DEFAULT NULL,
  `item_spc4_id` int(11) DEFAULT NULL,
  `item_spc5_id` int(11) DEFAULT NULL,
  `item_min_unit` decimal(10,3) DEFAULT NULL,
  `item_box` decimal(10,3) DEFAULT NULL,
  `item_ccost` decimal(10,3) DEFAULT NULL,
  `item_nprice` decimal(10,3) DEFAULT NULL,
  `item_dprice` decimal(10,3) DEFAULT NULL,
  `item_sprice` decimal(10,3) DEFAULT NULL,
  `item_wprice` decimal(10,3) DEFAULT NULL,
  `item_rprice` decimal(10,3) DEFAULT NULL,
  `item_hprice` decimal(10,3) DEFAULT NULL,
  `item_mprice` decimal(10,3) DEFAULT NULL,
  `item_image` varchar(512) DEFAULT NULL,
  `item_desc` varchar(1024) DEFAULT NULL,
  `item_rem` varchar(100) DEFAULT NULL,
  `trn_ord` smallint(6) DEFAULT NULL,
  `trn_uperc` decimal(20,3) DEFAULT NULL,
  `trn_qnt` decimal(20,3) DEFAULT NULL,
  `trn_wqnt` decimal(20,3) DEFAULT NULL,
  `trn_cqnt` decimal(20,3) DEFAULT NULL,
  `trn_cwqnt` decimal(20,3) DEFAULT NULL,
  `trn_sqnt` decimal(20,3) DEFAULT NULL,
  `trn_swqnt` decimal(20,3) DEFAULT NULL,
  `trn_price` decimal(20,3) DEFAULT NULL,
  `trn_camt` decimal(20,3) DEFAULT NULL,
  `trn_bamt` decimal(20,3) DEFAULT NULL,
  `trn_amt` decimal(20,3) DEFAULT NULL,
  `trn_cost` decimal(20,3) DEFAULT NULL,
  `trn_bcost` decimal(20,3) DEFAULT NULL,
  `trn_length` decimal(20,3) DEFAULT NULL,
  `trn_width` decimal(20,3) DEFAULT NULL,
  `trn_height` decimal(20,3) DEFAULT NULL,
  `trn_barcode` varchar(100) DEFAULT NULL,
  `trn_model` varchar(100) DEFAULT NULL,
  `trn_lotser` varchar(100) DEFAULT NULL,
  `trn_sdate` date DEFAULT NULL,
  `trn_edate` date DEFAULT NULL,
  `trn_rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vitem`
--

DROP TABLE IF EXISTS `str_vitem`;
CREATE TABLE IF NOT EXISTS `str_vitem` (
  `id` int(11) DEFAULT NULL,
  `num` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `partnum` varchar(15) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `cat_name` varchar(100) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `spc1_id` int(11) DEFAULT NULL,
  `spc1_name` varchar(100) DEFAULT NULL,
  `spc2_id` int(11) DEFAULT NULL,
  `spc2_name` varchar(100) DEFAULT NULL,
  `spc3_id` int(11) DEFAULT NULL,
  `spc3_name` varchar(100) DEFAULT NULL,
  `spc4_id` int(11) DEFAULT NULL,
  `spc4_name` varchar(100) DEFAULT NULL,
  `spc5_id` int(11) DEFAULT NULL,
  `spc5_name` varchar(100) DEFAULT NULL,
  `type_id` tinyint(4) DEFAULT NULL,
  `status_id` tinyint(4) DEFAULT NULL,
  `costtype_id` tinyint(4) DEFAULT NULL,
  `method_id` tinyint(4) DEFAULT NULL,
  `insale_id` tinyint(4) DEFAULT NULL,
  `season_id` tinyint(4) DEFAULT NULL,
  `warnty_days` smallint(6) DEFAULT NULL,
  `nofp` smallint(6) DEFAULT NULL,
  `min_unit` decimal(10,3) DEFAULT NULL,
  `box` decimal(10,3) DEFAULT NULL,
  `ccost` decimal(10,3) DEFAULT NULL,
  `nprice` decimal(10,3) DEFAULT NULL,
  `dprice` decimal(10,3) DEFAULT NULL,
  `sprice` decimal(10,3) DEFAULT NULL,
  `wprice` decimal(10,3) DEFAULT NULL,
  `rprice` decimal(10,3) DEFAULT NULL,
  `hprice` decimal(10,3) DEFAULT NULL,
  `mprice` decimal(10,3) DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL,
  `desc` varchar(1024) DEFAULT NULL,
  `rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_voudocs`
--

DROP TABLE IF EXISTS `str_voudocs`;
CREATE TABLE IF NOT EXISTS `str_voudocs` (
  `mst_id` int(11) DEFAULT NULL,
  `src_id` smallint(6) DEFAULT NULL,
  `trntype_id` smallint(6) DEFAULT NULL,
  `mrel_id` int(11) DEFAULT NULL,
  `vhr_id` int(11) DEFAULT NULL,
  `fin_id` int(11) DEFAULT NULL,
  `curn_rate` decimal(10,5) DEFAULT NULL,
  `bcurn_rate` decimal(10,5) DEFAULT NULL,
  `mst_docn` varchar(10) DEFAULT NULL,
  `mst_docd` date DEFAULT NULL,
  `mst_num` int(11) DEFAULT NULL,
  `mst_date` date DEFAULT NULL,
  `mst_person` varchar(100) DEFAULT NULL,
  `mst_phone` varchar(100) DEFAULT NULL,
  `mst_rem` varchar(100) DEFAULT NULL,
  `wper_id` smallint(6) DEFAULT NULL,
  `wper_name` varchar(100) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_num` smallint(6) DEFAULT NULL,
  `stor_name` varchar(100) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `acc_num` varchar(15) DEFAULT NULL,
  `acc_name` varchar(100) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `cost_num` varchar(15) DEFAULT NULL,
  `cost_name` varchar(100) DEFAULT NULL,
  `curn_id` int(11) DEFAULT NULL,
  `curn_num` smallint(6) DEFAULT NULL,
  `curn_code` varchar(10) DEFAULT NULL,
  `curn_name` varchar(100) DEFAULT NULL,
  `bcurn_id` int(11) DEFAULT NULL,
  `bcurn_num` smallint(6) DEFAULT NULL,
  `bcurn_code` varchar(10) DEFAULT NULL,
  `bcurn_name` varchar(100) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL,
  `trn_id` int(11) DEFAULT NULL,
  `trel_id` int(11) DEFAULT NULL,
  `ics_id` int(11) DEFAULT NULL,
  `sics_id` int(11) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `color_name` varchar(100) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_num` varchar(15) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_partnum` varchar(15) DEFAULT NULL,
  `item_type_id` tinyint(4) DEFAULT NULL,
  `item_status_id` tinyint(4) DEFAULT NULL,
  `item_costtype_id` tinyint(4) DEFAULT NULL,
  `item_method_id` tinyint(4) DEFAULT NULL,
  `item_unit_id` tinyint(4) DEFAULT NULL,
  `item_insale_id` tinyint(4) DEFAULT NULL,
  `item_season_id` tinyint(4) DEFAULT NULL,
  `item_warnty_days` smallint(6) DEFAULT NULL,
  `item_nofp` smallint(6) DEFAULT NULL,
  `item_cat_id` int(11) DEFAULT NULL,
  `item_spc1_id` int(11) DEFAULT NULL,
  `item_spc2_id` int(11) DEFAULT NULL,
  `item_spc3_id` int(11) DEFAULT NULL,
  `item_spc4_id` int(11) DEFAULT NULL,
  `item_spc5_id` int(11) DEFAULT NULL,
  `item_min_unit` decimal(10,3) DEFAULT NULL,
  `item_box` decimal(10,3) DEFAULT NULL,
  `item_ccost` decimal(10,3) DEFAULT NULL,
  `item_nprice` decimal(10,3) DEFAULT NULL,
  `item_dprice` decimal(10,3) DEFAULT NULL,
  `item_sprice` decimal(10,3) DEFAULT NULL,
  `item_wprice` decimal(10,3) DEFAULT NULL,
  `item_rprice` decimal(10,3) DEFAULT NULL,
  `item_hprice` decimal(10,3) DEFAULT NULL,
  `item_mprice` decimal(10,3) DEFAULT NULL,
  `item_image` varchar(512) DEFAULT NULL,
  `item_desc` varchar(1024) DEFAULT NULL,
  `item_rem` varchar(100) DEFAULT NULL,
  `trn_ord` tinyint(4) DEFAULT NULL,
  `trn_uperc` decimal(10,3) DEFAULT NULL,
  `trn_qnt` decimal(10,3) DEFAULT NULL,
  `trn_wqnt` decimal(10,3) DEFAULT NULL,
  `trn_cqnt` decimal(10,3) DEFAULT NULL,
  `trn_cwqnt` decimal(10,3) DEFAULT NULL,
  `trn_sqnt` decimal(10,3) DEFAULT NULL,
  `trn_swqnt` decimal(10,3) DEFAULT NULL,
  `trn_price` decimal(10,3) DEFAULT NULL,
  `trn_camt` decimal(10,3) DEFAULT NULL,
  `trn_bamt` decimal(10,3) DEFAULT NULL,
  `trn_amt` decimal(10,3) DEFAULT NULL,
  `trn_cost` decimal(10,3) DEFAULT NULL,
  `trn_bcost` decimal(10,3) DEFAULT NULL,
  `trn_length` decimal(10,3) DEFAULT NULL,
  `trn_width` decimal(10,3) DEFAULT NULL,
  `trn_height` decimal(10,3) DEFAULT NULL,
  `trn_barcode` varchar(100) DEFAULT NULL,
  `trn_model` varchar(100) DEFAULT NULL,
  `trn_lotser` varchar(100) DEFAULT NULL,
  `trn_sdate` date DEFAULT NULL,
  `trn_edate` date DEFAULT NULL,
  `trn_rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_voumst`
--

DROP TABLE IF EXISTS `str_voumst`;
CREATE TABLE IF NOT EXISTS `str_voumst` (
  `mst_id` int(11) DEFAULT NULL,
  `src_id` smallint(6) DEFAULT NULL,
  `trntype_id` smallint(6) DEFAULT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `vhr_id` int(11) DEFAULT NULL,
  `fin_id` int(11) DEFAULT NULL,
  `curn_rate` decimal(10,5) DEFAULT NULL,
  `bcurn_rate` decimal(10,5) DEFAULT NULL,
  `mst_docn` varchar(10) DEFAULT NULL,
  `mst_docd` date DEFAULT NULL,
  `mst_num` int(11) DEFAULT NULL,
  `mst_date` date DEFAULT NULL,
  `mst_person` varchar(100) DEFAULT NULL,
  `mst_phone` varchar(100) DEFAULT NULL,
  `mst_rem` varchar(100) DEFAULT NULL,
  `wper_id` smallint(6) DEFAULT NULL,
  `wper_name` varchar(100) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_num` smallint(6) DEFAULT NULL,
  `stor_name` varchar(100) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `acc_num` varchar(15) DEFAULT NULL,
  `acc_name` varchar(100) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `cost_num` varchar(15) DEFAULT NULL,
  `cost_name` varchar(100) DEFAULT NULL,
  `curn_id` int(11) DEFAULT NULL,
  `curn_num` smallint(6) DEFAULT NULL,
  `curn_code` varchar(10) DEFAULT NULL,
  `curn_name` varchar(100) DEFAULT NULL,
  `bcurn_id` int(11) DEFAULT NULL,
  `bcurn_num` smallint(6) DEFAULT NULL,
  `bcurn_code` varchar(10) DEFAULT NULL,
  `bcurn_name` varchar(100) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_voutrn`
--

DROP TABLE IF EXISTS `str_voutrn`;
CREATE TABLE IF NOT EXISTS `str_voutrn` (
  `trn_id` int(11) DEFAULT NULL,
  `trel_id` int(11) DEFAULT NULL,
  `ics_id` int(11) DEFAULT NULL,
  `sics_id` int(11) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `color_name` varchar(100) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_num` varchar(15) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_partnum` varchar(15) DEFAULT NULL,
  `item_type_id` tinyint(4) DEFAULT NULL,
  `item_status_id` tinyint(4) DEFAULT NULL,
  `item_costtype_id` tinyint(4) DEFAULT NULL,
  `item_method_id` tinyint(4) DEFAULT NULL,
  `item_unit_id` tinyint(4) DEFAULT NULL,
  `item_insale_id` tinyint(4) DEFAULT NULL,
  `item_season_id` tinyint(4) DEFAULT NULL,
  `item_warnty_days` smallint(6) DEFAULT NULL,
  `item_nofp` smallint(6) DEFAULT NULL,
  `item_cat_id` int(11) DEFAULT NULL,
  `item_spc1_id` int(11) DEFAULT NULL,
  `item_spc2_id` int(11) DEFAULT NULL,
  `item_spc3_id` int(11) DEFAULT NULL,
  `item_spc4_id` int(11) DEFAULT NULL,
  `item_spc5_id` int(11) DEFAULT NULL,
  `item_min_unit` decimal(10,3) DEFAULT NULL,
  `item_box` decimal(10,3) DEFAULT NULL,
  `item_ccost` decimal(10,3) DEFAULT NULL,
  `item_nprice` decimal(10,3) DEFAULT NULL,
  `item_dprice` decimal(10,3) DEFAULT NULL,
  `item_sprice` decimal(10,3) DEFAULT NULL,
  `item_wprice` decimal(10,3) DEFAULT NULL,
  `item_rprice` decimal(10,3) DEFAULT NULL,
  `item_hprice` decimal(10,3) DEFAULT NULL,
  `item_mprice` decimal(10,3) DEFAULT NULL,
  `item_image` varchar(512) DEFAULT NULL,
  `item_desc` varchar(1024) DEFAULT NULL,
  `item_rem` varchar(100) DEFAULT NULL,
  `trn_ord` tinyint(4) DEFAULT NULL,
  `trn_uperc` decimal(10,3) DEFAULT NULL,
  `trn_qnt` decimal(10,3) DEFAULT NULL,
  `trn_wqnt` decimal(10,3) DEFAULT NULL,
  `trn_cqnt` decimal(10,3) DEFAULT NULL,
  `trn_cwqnt` decimal(10,3) DEFAULT NULL,
  `trn_sqnt` decimal(10,3) DEFAULT NULL,
  `trn_swqnt` decimal(10,3) DEFAULT NULL,
  `trn_price` decimal(10,3) DEFAULT NULL,
  `trn_camt` decimal(10,3) DEFAULT NULL,
  `trn_bamt` decimal(10,3) DEFAULT NULL,
  `trn_amt` decimal(10,3) DEFAULT NULL,
  `trn_cost` decimal(10,3) DEFAULT NULL,
  `trn_bcost` decimal(10,3) DEFAULT NULL,
  `trn_length` decimal(10,3) DEFAULT NULL,
  `trn_width` decimal(10,3) DEFAULT NULL,
  `trn_height` decimal(10,3) DEFAULT NULL,
  `trn_barcode` varchar(100) DEFAULT NULL,
  `trn_model` varchar(100) DEFAULT NULL,
  `trn_lotser` varchar(100) DEFAULT NULL,
  `trn_sdate` date DEFAULT NULL,
  `trn_edate` date DEFAULT NULL,
  `trn_rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vstore`
--

DROP TABLE IF EXISTS `str_vstore`;
CREATE TABLE IF NOT EXISTS `str_vstore` (
  `id` int(11) DEFAULT NULL,
  `num` smallint(6) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type_id` tinyint(4) DEFAULT NULL,
  `status_id` tinyint(4) DEFAULT NULL,
  `sales_id` tinyint(4) DEFAULT NULL,
  `isowned` tinyint(4) DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `edate` date DEFAULT NULL,
  `address` varchar(25) DEFAULT NULL,
  `rem` varchar(100) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `cost_name` varchar(100) DEFAULT NULL,
  `acc_sid` int(11) DEFAULT NULL,
  `acc_sname` varchar(100) DEFAULT NULL,
  `acc_cid` int(11) DEFAULT NULL,
  `acc_cname` varchar(100) DEFAULT NULL,
  `acc_rid` int(11) DEFAULT NULL,
  `acc_rname` varchar(100) DEFAULT NULL,
  `acc_mid` int(11) DEFAULT NULL,
  `acc_mname` varchar(100) DEFAULT NULL,
  `acc_did` int(11) DEFAULT NULL,
  `acc_dname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `str_vstritem`
--

DROP TABLE IF EXISTS `str_vstritem`;
CREATE TABLE IF NOT EXISTS `str_vstritem` (
  `item_id` int(11) DEFAULT NULL,
  `item_num` varchar(15) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_partnum` varchar(15) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `cat_name` varchar(100) DEFAULT NULL,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_name` varchar(100) DEFAULT NULL,
  `spc1_id` int(11) DEFAULT NULL,
  `spc1_name` varchar(100) DEFAULT NULL,
  `spc2_id` int(11) DEFAULT NULL,
  `spc2_name` varchar(100) DEFAULT NULL,
  `spc3_id` int(11) DEFAULT NULL,
  `spc3_name` varchar(100) DEFAULT NULL,
  `spc4_id` int(11) DEFAULT NULL,
  `spc4_name` varchar(100) DEFAULT NULL,
  `spc5_id` int(11) DEFAULT NULL,
  `spc5_name` varchar(100) DEFAULT NULL,
  `type_id` tinyint(4) DEFAULT NULL,
  `status_id` tinyint(4) DEFAULT NULL,
  `costtype_id` tinyint(4) DEFAULT NULL,
  `method_id` tinyint(4) DEFAULT NULL,
  `insale_id` tinyint(4) DEFAULT NULL,
  `season_id` tinyint(4) DEFAULT NULL,
  `item_warnty_days` smallint(6) DEFAULT NULL,
  `item_nofp` smallint(6) DEFAULT NULL,
  `item_min_unit` decimal(10,3) DEFAULT NULL,
  `item_box` decimal(10,3) DEFAULT NULL,
  `item_ccost` decimal(10,3) DEFAULT NULL,
  `item_nprice` decimal(10,3) DEFAULT NULL,
  `item_dprice` decimal(10,3) DEFAULT NULL,
  `item_sprice` decimal(10,3) DEFAULT NULL,
  `item_wprice` decimal(10,3) DEFAULT NULL,
  `item_rprice` decimal(10,3) DEFAULT NULL,
  `item_hprice` decimal(10,3) DEFAULT NULL,
  `item_mprice` decimal(10,3) DEFAULT NULL,
  `item_image` varchar(512) DEFAULT NULL,
  `item_desc` varchar(1024) DEFAULT NULL,
  `item_rem` varchar(100) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_num` smallint(6) DEFAULT NULL,
  `stor_name` varchar(100) DEFAULT NULL,
  `stor_type_id` tinyint(4) DEFAULT NULL,
  `stor_status_id` tinyint(4) DEFAULT NULL,
  `stor_sales_id` tinyint(4) DEFAULT NULL,
  `stor_isowned` tinyint(4) DEFAULT NULL,
  `stor_sdate` date DEFAULT NULL,
  `stor_edate` date DEFAULT NULL,
  `stor_address` varchar(25) DEFAULT NULL,
  `stor_rem` varchar(100) DEFAULT NULL,
  `stor_cost_id` int(11) DEFAULT NULL,
  `stor_cost_name` varchar(100) DEFAULT NULL,
  `stor_acc_sid` int(11) DEFAULT NULL,
  `stor_acc_sname` varchar(100) DEFAULT NULL,
  `stor_acc_cid` int(11) DEFAULT NULL,
  `stor_acc_cname` varchar(100) DEFAULT NULL,
  `stor_acc_rid` int(11) DEFAULT NULL,
  `stor_acc_rname` varchar(100) DEFAULT NULL,
  `stor_acc_mid` int(11) DEFAULT NULL,
  `stor_acc_mname` varchar(100) DEFAULT NULL,
  `stor_acc_did` int(11) DEFAULT NULL,
  `stor_acc_dname` varchar(100) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `acc_sid` int(11) DEFAULT NULL,
  `acc_cid` int(11) DEFAULT NULL,
  `acc_rid` int(11) DEFAULT NULL,
  `acc_mid` int(11) DEFAULT NULL,
  `acc_did` int(11) DEFAULT NULL,
  `loc1_id` int(11) DEFAULT NULL,
  `loc1_name` varchar(100) DEFAULT NULL,
  `loc2_id` int(11) DEFAULT NULL,
  `loc2_name` varchar(100) DEFAULT NULL,
  `loc3_id` int(11) DEFAULT NULL,
  `loc3_name` varchar(100) DEFAULT NULL,
  `cqnt` decimal(10,3) DEFAULT NULL,
  `cwqnt` decimal(10,3) DEFAULT NULL,
  `cost` decimal(10,3) DEFAULT NULL,
  `bcost` decimal(10,3) DEFAULT NULL,
  `bqnt` decimal(10,3) DEFAULT NULL,
  `bwqnt` decimal(10,3) DEFAULT NULL,
  `qmin` decimal(10,3) DEFAULT NULL,
  `qreq` decimal(10,3) DEFAULT NULL,
  `qmax` decimal(10,3) DEFAULT NULL,
  `qmin1` decimal(10,3) DEFAULT NULL,
  `qreq1` decimal(10,3) DEFAULT NULL,
  `qmax1` decimal(10,3) DEFAULT NULL,
  `qmin2` decimal(10,3) DEFAULT NULL,
  `qreq2` decimal(10,3) DEFAULT NULL,
  `qmax2` decimal(10,3) DEFAULT NULL,
  `qmin3` decimal(10,3) DEFAULT NULL,
  `qreq3` decimal(10,3) DEFAULT NULL,
  `qmax3` decimal(10,3) DEFAULT NULL,
  `qmin4` decimal(10,3) DEFAULT NULL,
  `qreq4` decimal(10,3) DEFAULT NULL,
  `qmax4` decimal(10,3) DEFAULT NULL,
  `qmin5` decimal(10,3) DEFAULT NULL,
  `qreq5` decimal(10,3) DEFAULT NULL,
  `qmax5` decimal(10,3) DEFAULT NULL,
  `qmin6` decimal(10,3) DEFAULT NULL,
  `qreq6` decimal(10,3) DEFAULT NULL,
  `qmax6` decimal(10,3) DEFAULT NULL,
  `qmin7` decimal(10,3) DEFAULT NULL,
  `qreq7` decimal(10,3) DEFAULT NULL,
  `qmax7` decimal(10,3) DEFAULT NULL,
  `qmin8` decimal(10,3) DEFAULT NULL,
  `qreq8` decimal(10,3) DEFAULT NULL,
  `qmax8` decimal(10,3) DEFAULT NULL,
  `qmin9` decimal(10,3) DEFAULT NULL,
  `qreq9` decimal(10,3) DEFAULT NULL,
  `qmax9` decimal(10,3) DEFAULT NULL,
  `qmin10` decimal(10,3) DEFAULT NULL,
  `qreq10` decimal(10,3) DEFAULT NULL,
  `qmax10` decimal(10,3) DEFAULT NULL,
  `qmin11` decimal(10,3) DEFAULT NULL,
  `qreq11` decimal(10,3) DEFAULT NULL,
  `qmax11` decimal(10,3) DEFAULT NULL,
  `qmin12` decimal(10,3) DEFAULT NULL,
  `qreq12` decimal(10,3) DEFAULT NULL,
  `qmax12` decimal(10,3) DEFAULT NULL,
  `rem` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `acc_vacc`
--
DROP TABLE IF EXISTS `acc_vacc`;

DROP VIEW IF EXISTS `acc_vacc`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `acc_vacc`  AS SELECT `a`.`id` AS `id`, `a`.`pid` AS `pid`, `a`.`num` AS `num`, `a`.`name` AS `name`, `t`.`id` AS `type_id`, `t`.`name` AS `type_name`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name`, `d`.`id` AS `dbcr_id`, `d`.`name` AS `dbcr_name`, `c`.`id` AS `close_id`, `c`.`name` AS `close_name`, `a`.`rem` AS `rem` FROM ((((`acc_acc` `a` join `phs_cod_tree_type` `t`) join `phs_cod_status` `s`) join `phs_cod_dbcr` `d`) join `acc_close` `c`) WHERE ((`a`.`type_id` = `t`.`id`) AND (`a`.`dbcr_id` = `d`.`id`) AND (`a`.`status_id` = `s`.`id`) AND (`a`.`close_id` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `acc_vbudget`
--
DROP TABLE IF EXISTS `acc_vbudget`;

DROP VIEW IF EXISTS `acc_vbudget`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `acc_vbudget`  AS SELECT `m`.`id` AS `mst_id`, `m`.`num` AS `mst_num`, `m`.`name` AS `mst_name`, `m`.`date` AS `mst_date`, `m`.`rem` AS `mst_rem`, `t`.`id` AS `trn_id`, `a`.`id` AS `acc_id`, `a`.`num` AS `acc_num`, `a`.`name` AS `acc_name`, `c`.`id` AS `cost_id`, `c`.`num` AS `cost_num`, `c`.`name` AS `cost_name`, `t`.`ord` AS `trn_ord`, `t`.`budget` AS `trn_budget`, `t`.`rem` AS `trn_rem` FROM (((`acc_budmst` `m` join `acc_budtrn` `t`) join `acc_acc` `a`) join `acc_cost` `c`) WHERE ((`t`.`mst_id` = `m`.`id`) AND (`t`.`acc_id` = `a`.`id`) AND (`t`.`cost_id` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `acc_vcost`
--
DROP TABLE IF EXISTS `acc_vcost`;

DROP VIEW IF EXISTS `acc_vcost`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `acc_vcost`  AS SELECT `a`.`id` AS `id`, `a`.`pid` AS `pid`, `a`.`num` AS `num`, `a`.`name` AS `name`, `t`.`id` AS `type_id`, `t`.`name` AS `type_name`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name`, `a`.`rem` AS `rem` FROM ((`acc_cost` `a` join `phs_cod_tree_type` `t`) join `phs_cod_status` `s`) WHERE ((`a`.`type_id` = `t`.`id`) AND (`a`.`status_id` = `s`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `acc_vtrn`
--
DROP TABLE IF EXISTS `acc_vtrn`;

DROP VIEW IF EXISTS `acc_vtrn`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `acc_vtrn`  AS SELECT `m`.`id` AS `mst_id`, `w`.`id` AS `wper_id`, `w`.`ord` AS `wper_ord`, `w`.`name` AS `wper_name`, `w`.`sdate` AS `wper_sdate`, `w`.`edate` AS `wper_edate`, `m`.`src_id` AS `mst_src_id`, `m`.`num` AS `mst_num`, `m`.`pnum` AS `mst_pnum`, `m`.`date` AS `mst_date`, `m`.`rem` AS `mst_rem`, `t`.`id` AS `trn_id`, `a`.`id` AS `acc_id`, `a`.`num` AS `acc_num`, `a`.`dbcr_id` AS `dbcr_id`, `a`.`status_id` AS `status_id`, `a`.`close_id` AS `close_id`, `a`.`name` AS `acc_name`, `c`.`id` AS `cost_id`, `c`.`num` AS `cost_num`, `c`.`name` AS `cost_name`, `t`.`acc_rid` AS `acc_rid`, `t`.`ord` AS `trn_ord`, `t`.`deb` AS `trn_deb`, `t`.`crd` AS `trn_crd`, `cr`.`id` AS `curn_id`, `cr`.`code` AS `curn_code`, `cr`.`name` AS `curn_name`, `cr`.`color` AS `curn_color`, `t`.`rate` AS `curn_rate`, `t`.`debc` AS `trn_debc`, `t`.`crdc` AS `trn_crdc`, `br`.`id` AS `bcurn_id`, `br`.`code` AS `bcurn_code`, `br`.`name` AS `bcurn_name`, `br`.`color` AS `bcurn_color`, `t`.`brate` AS `bcurn_rate`, `t`.`debb` AS `trn_debb`, `t`.`crdb` AS `trn_crdb`, `t`.`rid` AS `trn_rid`, `t`.`srem` AS `trn_srem`, `t`.`rem` AS `trn_rem` FROM ((((((`acc_mst` `m` join `acc_trn` `t`) join `cpy_wperiod` `w`) join `acc_acc` `a`) join `acc_cost` `c`) join `mng_curn` `cr`) join `mng_curn` `br`) WHERE ((`t`.`mst_id` = `m`.`id`) AND (`m`.`wper_id` = `w`.`id`) AND (`t`.`acc_id` = `a`.`id`) AND (`t`.`cost_id` = `c`.`id`) AND (`t`.`curn_id` = `cr`.`id`) AND (`t`.`bcurn_id` = `br`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vappointment`
--
DROP TABLE IF EXISTS `clnc_vappointment`;

DROP VIEW IF EXISTS `clnc_vappointment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vappointment`  AS SELECT `a`.`id` AS `id`, `a`.`ins_user` AS `iuser_id`, `a`.`ins_date` AS `idate`, `a`.`upd_user` AS `uuser_id`, `a`.`upd_date` AS `udate`, `a`.`date` AS `date`, `a`.`hour` AS `hour`, `a`.`minute` AS `minute`, `a`.`minutes` AS `minutes`, `a`.`amt` AS `amount`, `a`.`description` AS `description`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name`, `s`.`icon` AS `status_icon`, `s`.`color_id` AS `status_color`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `c`.`prefix` AS `clinic_prefix`, `c`.`email` AS `clinic_email`, `c`.`phone1` AS `clinic_phone1`, `c`.`phone2` AS `clinic_phone2`, `c`.`phone3` AS `clinic_phone3`, `c`.`address` AS `clinic_address`, `c`.`status_id` AS `clinic_status_id`, `d`.`id` AS `doctor_id`, `d`.`name` AS `doctor_name`, '' AS `doctor_mobile`, `d`.`gender_id` AS `doctor_gender_id`, `d`.`status_id` AS `doctor_status_id`, `d`.`special_id` AS `doctor_special_id`, `t`.`id` AS `type_id`, `t`.`name` AS `type_name`, `t`.`capacity` AS `type_capacity`, `t`.`time` AS `type_time`, `t`.`tbg_id` AS `type_titlebg_id`, `t`.`tfg_id` AS `type_titlfg_id`, `t`.`nfg_id` AS `type_namefg_id`, `e`.`id` AS `special_id`, `e`.`name` AS `special_name`, `p`.`id` AS `patient_id`, `p`.`num` AS `patient_num`, `p`.`name` AS `patient_name`, `p`.`mobile` AS `patient_mobile`, `p`.`nat_num` AS `patient_nat_num`, `p`.`nat_id` AS `patient_nat_id`, `p`.`gender_id` AS `patient_gender_id` FROM ((((((`clnc_appointment` `a` join `clnc_clinic` `c`) join `clnc_staff` `d`) join `phs_cod_app_status` `s`) join `clnc_special` `e`) join `clnc_app_type` `t`) join `clnc_patient` `p`) WHERE ((`a`.`clinic_id` = `c`.`id`) AND (`a`.`doctor_id` = `d`.`id`) AND (`a`.`status_id` = `s`.`id`) AND (`a`.`special_id` = `e`.`id`) AND (`a`.`type_id` = `t`.`id`) AND (`a`.`patient_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vclinic`
--
DROP TABLE IF EXISTS `clnc_vclinic`;

DROP VIEW IF EXISTS `clnc_vclinic`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vclinic`  AS SELECT `c`.`id` AS `id`, `c`.`ins_user` AS `iuser_id`, `c`.`ins_date` AS `idate`, `c`.`upd_user` AS `uuser_id`, `c`.`upd_date` AS `udate`, `c`.`name` AS `name`, `c`.`prefix` AS `prefix`, `c`.`email` AS `email`, `c`.`phone1` AS `phone1`, `c`.`phone2` AS `phone2`, `c`.`phone3` AS `phone3`, `c`.`address` AS `address`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name` FROM (`clnc_clinic` `c` join `phs_cod_status` `s`) WHERE (`c`.`status_id` = `s`.`id`) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vdiscount`
--
DROP TABLE IF EXISTS `clnc_vdiscount`;

DROP VIEW IF EXISTS `clnc_vdiscount`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vdiscount`  AS SELECT `t`.`id` AS `id`, `t`.`ins_user` AS `iuser_id`, `t`.`ins_date` AS `idate`, `t`.`upd_user` AS `uuser_id`, `t`.`upd_date` AS `udate`, `t`.`date` AS `date`, `t`.`amt` AS `amt`, `t`.`description` AS `description`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `p`.`id` AS `patient_id`, `p`.`num` AS `patient_num`, `p`.`name` AS `patient_name`, `p`.`mobile` AS `patient_mobile`, `p`.`nat_num` AS `patient_nat_num` FROM ((`clnc_discount` `t` join `clnc_clinic` `c`) join `clnc_patient` `p`) WHERE ((`t`.`clinic_id` = `c`.`id`) AND (`t`.`patient_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vinvoice`
--
DROP TABLE IF EXISTS `clnc_vinvoice`;

DROP VIEW IF EXISTS `clnc_vinvoice`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vinvoice`  AS SELECT `t`.`id` AS `id`, `t`.`ins_user` AS `iuser_id`, `t`.`ins_date` AS `idate`, `t`.`upd_user` AS `uuser_id`, `t`.`upd_date` AS `udate`, `t`.`num` AS `num`, `t`.`date` AS `date`, `d`.`id` AS `discount_id`, `d`.`name` AS `discount_name`, `t`.`discount_value` AS `discount_value`, `t`.`discount_amt` AS `discount_amt`, `t`.`discount_reason` AS `discount_reason`, '' AS `description`, sum(`tp`.`amt`) AS `amt`, sum(`tp`.`vat_amt`) AS `vat`, ((sum(`tp`.`amt`) + sum(`tp`.`vat_amt`)) - `t`.`discount_amt`) AS `net`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `p`.`id` AS `patient_id`, `p`.`num` AS `patient_num`, `p`.`name` AS `patient_name`, `p`.`mobile` AS `patient_mobile`, `p`.`nat_num` AS `patient_nat_num` FROM ((((((`clnc_invoice` `t` join `phs_cod_discount_type` `d`) join `clnc_clinic` `c`) join `clnc_patient` `p`) join `clnc_invoice_treatment` `tt`) join `clnc_treatment` `tm`) join `clnc_treatment_procedures` `tp`) WHERE ((`t`.`clinic_id` = `c`.`id`) AND (`t`.`discount_id` = `d`.`id`) AND (`t`.`patient_id` = `p`.`id`) AND (`tt`.`invoice_id` = `t`.`id`) AND (`tt`.`treatment_id` = `tm`.`id`) AND (`tp`.`treatment_id` = `tm`.`id`)) GROUP BY `t`.`id`, `t`.`num`, `t`.`date`, `d`.`id`, `d`.`name`, `t`.`discount_value`, `t`.`discount_amt`, `t`.`discount_reason`, `c`.`id`, `c`.`name`, `p`.`id`, `p`.`num`, `p`.`name`, `p`.`mobile`, `p`.`nat_num` ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_voffer`
--
DROP TABLE IF EXISTS `clnc_voffer`;

DROP VIEW IF EXISTS `clnc_voffer`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_voffer`  AS SELECT `o`.`id` AS `id`, `o`.`ins_user` AS `iuser_id`, `o`.`ins_date` AS `idate`, `o`.`upd_user` AS `uuser_id`, `o`.`upd_date` AS `udate`, `o`.`name` AS `name`, `o`.`sdate` AS `sdate`, `o`.`edate` AS `edate`, `o`.`description` AS `description`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name` FROM (`clnc_offer` `o` join `phs_cod_status` `s`) WHERE (`o`.`status_id` = `s`.`id`) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_voffer_clinic`
--
DROP TABLE IF EXISTS `clnc_voffer_clinic`;

DROP VIEW IF EXISTS `clnc_voffer_clinic`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_voffer_clinic`  AS SELECT `o`.`id` AS `offer_id`, `o`.`iuser_id` AS `offer_iuser_id`, `o`.`idate` AS `offer_idate`, `o`.`uuser_id` AS `offer_uuser_id`, `o`.`udate` AS `offer_udate`, `o`.`name` AS `offer_name`, `o`.`sdate` AS `offer_sdate`, `o`.`edate` AS `offer_edate`, `o`.`description` AS `offer_description`, `o`.`status_id` AS `offer_status_id`, `o`.`status_name` AS `offer_status_name`, `c`.`id` AS `clinic_id`, `c`.`ins_user` AS `clinic_iuser_id`, `c`.`ins_date` AS `clinic_idate`, `c`.`upd_user` AS `clinic_uuser_id`, `c`.`upd_date` AS `clinic_udate`, `c`.`name` AS `clinic_name`, `c`.`email` AS `clinic_email`, `c`.`phone1` AS `clinic_phone1`, `c`.`phone2` AS `clinic_phone2`, `c`.`phone3` AS `clinic_phone3`, `c`.`address` AS `clinic_address`, `oc`.`id` AS `id`, `oc`.`ins_user` AS `iuser_id`, `oc`.`ins_date` AS `idate`, `oc`.`upd_user` AS `uuser_id`, `oc`.`upd_date` AS `udate`, `oc`.`description` AS `description` FROM ((`clnc_voffer` `o` join `clnc_offer_clinic` `oc`) join `clnc_clinic` `c`) WHERE ((`oc`.`offer_id` = `o`.`id`) AND (`oc`.`clinic_id` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_voffer_procedure`
--
DROP TABLE IF EXISTS `clnc_voffer_procedure`;

DROP VIEW IF EXISTS `clnc_voffer_procedure`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_voffer_procedure`  AS SELECT `o`.`id` AS `offer_id`, `o`.`name` AS `offer_name`, `o`.`sdate` AS `offer_sdate`, `o`.`edate` AS `offer_edate`, `o`.`description` AS `offer_description`, `o`.`status_id` AS `offer_status_id`, `o`.`status_name` AS `offer_status_name`, `p`.`id` AS `procedure_id`, `p`.`iuser_id` AS `procedure_iuser_id`, `p`.`idate` AS `procedure_idate`, `p`.`uuser_id` AS `procedure_uuser_id`, `p`.`udate` AS `procedure_udate`, `p`.`code` AS `procedure_code`, `p`.`name` AS `procedure_name`, `p`.`price` AS `procedure_price`, `p`.`vat` AS `procedure_vat`, `p`.`vat_id` AS `vat_id`, `p`.`vat_name` AS `vat_name`, `p`.`cat_id` AS `cat_id`, `p`.`cat_name` AS `cat_name`, `op`.`id` AS `id`, `op`.`ins_user` AS `iuser_id`, `op`.`ins_date` AS `idate`, `op`.`upd_user` AS `uuser_id`, `op`.`upd_date` AS `udate`, `op`.`price` AS `price`, `op`.`description` AS `description` FROM ((`clnc_voffer` `o` join `clnc_offer_procedure` `op`) join `clnc_vprocedure` `p`) WHERE ((`op`.`offer_id` = `o`.`id`) AND (`op`.`procedure_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vpatient`
--
DROP TABLE IF EXISTS `clnc_vpatient`;

DROP VIEW IF EXISTS `clnc_vpatient`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vpatient`  AS SELECT `p`.`id` AS `id`, `p`.`ins_user` AS `iuser_id`, `p`.`ins_date` AS `idate`, `p`.`upd_user` AS `uuser_id`, `p`.`upd_date` AS `udate`, `p`.`name` AS `name`, `p`.`num` AS `num`, `p`.`birthday` AS `birthday`, `p`.`nat_num` AS `nat_num`, `p`.`idnum` AS `idnum`, `p`.`mobile` AS `mobile`, `p`.`land1` AS `land1`, `p`.`land2` AS `land2`, `p`.`email` AS `email`, `p`.`company` AS `company`, `p`.`langs` AS `langs`, `p`.`description` AS `description`, `g`.`id` AS `gender_id`, `g`.`name` AS `gender_name`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `m`.`id` AS `martial_id`, `m`.`name` AS `martial_name`, `n`.`num_code` AS `nat_id`, `n`.`nationality` AS `nat_name`, `v`.`id` AS `visa_id`, `v`.`name` AS `visa_name`, `i`.`id` AS `idtype_id`, `i`.`name` AS `idtype_name` FROM ((((((`clnc_patient` `p` join `clnc_clinic` `c`) join `phs_cod_gender` `g`) join `phs_cod_martial` `m`) join `phs_cod_nationality` `n`) join `phs_cod_visa` `v`) join `phs_cod_idtype` `i`) WHERE ((`p`.`clinic_id` = `c`.`id`) AND (`p`.`gender_id` = `g`.`id`) AND (`p`.`martial_id` = `m`.`id`) AND (`p`.`nat_id` = `n`.`num_code`) AND (`p`.`visa_id` = `v`.`id`) AND (`p`.`idtype_id` = `i`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vpatient_card`
--
DROP TABLE IF EXISTS `clnc_vpatient_card`;

DROP VIEW IF EXISTS `clnc_vpatient_card`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vpatient_card`  AS SELECT `ip`.`id` AS `id`, `ip`.`iuser_id` AS `iuser_id`, `ip`.`idate` AS `idate`, `ip`.`uuser_id` AS `uuser_id`, `ip`.`udate` AS `udate`, `ip`.`trt_id` AS `trt_id`, `ip`.`trt_name` AS `trt_name`, `ip`.`num` AS `num`, `ip`.`date` AS `date`, `ip`.`discount` AS `discount`, `ip`.`vat` AS `vat`, `ip`.`amt` AS `amt`, `ip`.`net` AS `net`, `ip`.`dbt` AS `dbt`, `ip`.`crd` AS `crd`, `ip`.`description` AS `description`, `ip`.`clinic_id` AS `clinic_id`, `ip`.`clinic_name` AS `clinic_name`, `ip`.`patient_id` AS `patient_id`, `ip`.`patient_num` AS `patient_num`, `ip`.`patient_name` AS `patient_name`, `ip`.`patient_nat_num` AS `patient_nat_num` FROM (select `iv`.`id` AS `id`,`iv`.`iuser_id` AS `iuser_id`,`iv`.`idate` AS `idate`,`iv`.`uuser_id` AS `uuser_id`,`iv`.`udate` AS `udate`,1 AS `trt_id`,'Invoice' AS `trt_name`,`iv`.`num` AS `num`,`iv`.`date` AS `date`,`iv`.`discount_amt` AS `discount`,`iv`.`vat` AS `vat`,`iv`.`amt` AS `amt`,`iv`.`net` AS `net`,`iv`.`net` AS `dbt`,0 AS `crd`,`iv`.`description` AS `description`,`iv`.`clinic_id` AS `clinic_id`,`iv`.`clinic_name` AS `clinic_name`,`iv`.`patient_id` AS `patient_id`,`iv`.`patient_num` AS `patient_num`,`iv`.`patient_name` AS `patient_name`,`iv`.`patient_nat_num` AS `patient_nat_num` from `clnc_vinvoice` `iv` union all select `py`.`id` AS `id`,`py`.`iuser_id` AS `iuser_id`,`py`.`idate` AS `idate`,`py`.`uuser_id` AS `uuser_id`,`py`.`udate` AS `udate`,2 AS `trt_id`,'Payment' AS `trt_name`,0 AS `num`,`py`.`date` AS `date`,0 AS `discount`,0 AS `vat`,`py`.`amt` AS `amt`,`py`.`amt` AS `net`,0 AS `dbt`,`py`.`amt` AS `crd`,`py`.`description` AS `description`,`py`.`clinic_id` AS `clinic_id`,`py`.`clinic_name` AS `clinic_name`,`py`.`patient_id` AS `patient_id`,`py`.`patient_num` AS `patient_num`,`py`.`patient_name` AS `patient_name`,`py`.`patient_nat_num` AS `patient_nat_num` from `clnc_vpayment` `py`) AS `ip` ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vpatient_note`
--
DROP TABLE IF EXISTS `clnc_vpatient_note`;

DROP VIEW IF EXISTS `clnc_vpatient_note`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vpatient_note`  AS SELECT `n`.`id` AS `id`, `n`.`ins_user` AS `iuser_id`, `n`.`ins_date` AS `idate`, `n`.`upd_user` AS `uuser_id`, `n`.`upd_date` AS `udate`, `n`.`datetime` AS `datetime`, `n`.`note` AS `note`, `p`.`id` AS `patient_id`, `p`.`name` AS `patient_name`, `d`.`id` AS `doctor_id`, `d`.`name` AS `doctor_name` FROM ((`clnc_patient_note` `n` join `clnc_patient` `p`) join `cpy_user` `d`) WHERE ((`n`.`patient_id` = `p`.`id`) AND (`n`.`doctor_id` = `d`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vpayment`
--
DROP TABLE IF EXISTS `clnc_vpayment`;

DROP VIEW IF EXISTS `clnc_vpayment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vpayment`  AS SELECT `t`.`id` AS `id`, `t`.`ins_user` AS `iuser_id`, `t`.`ins_date` AS `idate`, `t`.`upd_user` AS `uuser_id`, `t`.`upd_date` AS `udate`, `t`.`date` AS `date`, `t`.`amt` AS `amt`, `t`.`description` AS `description`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `m`.`id` AS `method_id`, `m`.`name` AS `method_name`, `u`.`id` AS `doctor_id`, `u`.`name` AS `doctor_name`, `p`.`id` AS `patient_id`, `p`.`num` AS `patient_num`, `p`.`name` AS `patient_name`, `p`.`mobile` AS `patient_mobile`, `p`.`nat_num` AS `patient_nat_num` FROM ((((`clnc_payment` `t` join `clnc_clinic` `c`) join `clnc_patient` `p`) join `cpy_user` `u`) join `phs_cod_payment_type` `m`) WHERE ((`t`.`clinic_id` = `c`.`id`) AND (`t`.`patient_id` = `p`.`id`) AND (`t`.`doctor_id` = `u`.`id`) AND (`t`.`method_id` = `m`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vprocedure`
--
DROP TABLE IF EXISTS `clnc_vprocedure`;

DROP VIEW IF EXISTS `clnc_vprocedure`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vprocedure`  AS SELECT `p`.`id` AS `id`, `p`.`ins_user` AS `iuser_id`, `p`.`ins_date` AS `idate`, `p`.`upd_user` AS `uuser_id`, `p`.`upd_date` AS `udate`, `p`.`code` AS `code`, `p`.`name` AS `name`, `p`.`price` AS `price`, `p`.`vat` AS `vat`, `v`.`id` AS `vat_id`, `v`.`name` AS `vat_name`, `c`.`id` AS `cat_id`, `c`.`name` AS `cat_name` FROM ((`clnc_procedure` `p` join `clnc_procedure_category` `c`) join `phs_cod_vat` `v`) WHERE ((`p`.`cat_id` = `c`.`id`) AND (`p`.`vat_id` = `v`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vrefund`
--
DROP TABLE IF EXISTS `clnc_vrefund`;

DROP VIEW IF EXISTS `clnc_vrefund`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vrefund`  AS SELECT `t`.`id` AS `id`, `t`.`ins_user` AS `iuser_id`, `t`.`ins_date` AS `idate`, `t`.`upd_user` AS `uuser_id`, `t`.`upd_date` AS `udate`, `t`.`date` AS `date`, `t`.`amt` AS `amt`, `t`.`description` AS `description`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `p`.`id` AS `patient_id`, `p`.`num` AS `patient_num`, `p`.`name` AS `patient_name`, `p`.`mobile` AS `patient_mobile`, `p`.`nat_num` AS `patient_nat_num` FROM ((`clnc_refund` `t` join `clnc_clinic` `c`) join `clnc_patient` `p`) WHERE ((`t`.`clinic_id` = `c`.`id`) AND (`t`.`patient_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vstaff`
--
DROP TABLE IF EXISTS `clnc_vstaff`;

DROP VIEW IF EXISTS `clnc_vstaff`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vstaff`  AS SELECT `ss`.`id` AS `id`, `ss`.`id` AS `rid`, `ut`.`id` AS `type_id`, `ut`.`name` AS `type_name`, `gp`.`id` AS `grp_id`, `gp`.`name` AS `grp_name`, `st`.`id` AS `status_id`, `st`.`name` AS `status_name`, `gd`.`id` AS `gender_id`, `gd`.`name` AS `gender_name`, `sp`.`id` AS `special_id`, `sp`.`name` AS `special_name`, `ss`.`name` AS `name`, `ss`.`username` AS `logon`, `ss`.`password` AS `password`, `ss`.`rem` AS `rem`, concat('avatars/avatar-',`ss`.`type_id`,'-',`ss`.`gender_id`,'.png') AS `image` FROM (((((`clnc_staff` `ss` join `cpy_user_type` `ut`) join `cpy_perm_grp` `gp`) join `phs_cod_status` `st`) join `phs_cod_gender` `gd`) join `clnc_special` `sp`) WHERE ((`ss`.`type_id` = `ut`.`id`) AND (`ss`.`grp_id` = `gp`.`id`) AND (`ss`.`status_id` = `st`.`id`) AND (`ss`.`gender_id` = `gd`.`id`) AND (`ss`.`special_id` = `sp`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vtreatment`
--
DROP TABLE IF EXISTS `clnc_vtreatment`;

DROP VIEW IF EXISTS `clnc_vtreatment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vtreatment`  AS SELECT `tr`.`id` AS `id`, `tr`.`ins_user` AS `iuser_id`, `tr`.`ins_date` AS `idate`, `tr`.`upd_user` AS `uuser_id`, `tr`.`upd_date` AS `udate`, `tr`.`date` AS `date`, `tr`.`description` AS `description`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name`, `c`.`id` AS `clinic_id`, `c`.`name` AS `clinic_name`, `d`.`id` AS `doctor_id`, `d`.`name` AS `doctor_name`, `sp`.`id` AS `doctor_special_id`, `sp`.`name` AS `doctor_special_name`, `p`.`id` AS `patient_id`, `p`.`name` AS `patient_name`, `p`.`num` AS `patient_num`, `p`.`nat_num` AS `patient_nat_num`, `p`.`mobile` AS `patient_mobile`, `p`.`company` AS `patient_company`, `p`.`description` AS `patient_description`, `p`.`gender_name` AS `patient_gender_name`, `p`.`nat_name` AS `patient_nat_name` FROM (((((`clnc_treatment` `tr` join `phs_cod_treatment_status` `s`) join `clnc_clinic` `c`) join `clnc_staff` `d`) join `clnc_special` `sp`) join `clnc_vpatient` `p`) WHERE ((`tr`.`status_id` = `s`.`id`) AND (`tr`.`clinic_id` = `c`.`id`) AND (`tr`.`doctor_id` = `d`.`id`) AND (`tr`.`patient_id` = `p`.`id`) AND (`d`.`special_id` = `sp`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `clnc_vtreatment_procedure`
--
DROP TABLE IF EXISTS `clnc_vtreatment_procedure`;

DROP VIEW IF EXISTS `clnc_vtreatment_procedure`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clnc_vtreatment_procedure`  AS SELECT `tp`.`id` AS `id`, `tp`.`ins_user` AS `iuser_id`, `tp`.`ins_date` AS `idate`, `tp`.`upd_user` AS `uuser_id`, `tp`.`upd_date` AS `udate`, `tp`.`qnt` AS `qnt`, `tp`.`price` AS `price`, `tp`.`discount` AS `discount`, `tp`.`amt` AS `amt`, `tp`.`vat_id` AS `vat_id`, `tp`.`vat_value` AS `vat_value`, `tp`.`vat_amt` AS `vat_amt`, `tp`.`datetime` AS `datetime`, `tp`.`description` AS `description`, `tr`.`id` AS `treatment_id`, `tr`.`date` AS `treatment_date`, `tr`.`description` AS `treatment_description`, `tr`.`status_id` AS `status_id`, `tr`.`status_name` AS `status_name`, `tr`.`clinic_id` AS `clinic_id`, `tr`.`clinic_name` AS `clinic_name`, `tr`.`doctor_id` AS `doctor_id`, `tr`.`doctor_name` AS `doctor_name`, `tr`.`doctor_special_name` AS `doctor_special_name`, `tr`.`patient_id` AS `patient_id`, `tr`.`patient_name` AS `patient_name`, `tr`.`patient_num` AS `patient_num`, `tr`.`patient_nat_num` AS `patient_nat_num`, `tr`.`patient_mobile` AS `patient_mobile`, `tr`.`patient_company` AS `patient_company`, `tr`.`patient_description` AS `patient_description`, `tr`.`patient_gender_name` AS `patient_gender_name`, `tr`.`patient_nat_name` AS `patient_nat_name`, `pr`.`cat_id` AS `cat_id`, `pr`.`cat_name` AS `cat_name`, `pr`.`id` AS `procedure_id`, `pr`.`code` AS `procedure_code`, `pr`.`name` AS `procedure_name`, `pr`.`price` AS `procedure_price` FROM ((`clnc_vtreatment` `tr` join `clnc_treatment_procedures` `tp`) join `clnc_vprocedure` `pr`) WHERE ((`tp`.`treatment_id` = `tr`.`id`) AND (`tp`.`procedure_id` = `pr`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `cpy_vuser`
--
DROP TABLE IF EXISTS `cpy_vuser`;

DROP VIEW IF EXISTS `cpy_vuser`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cpy_vuser`  AS SELECT `usv`.`id` AS `id`, `usv`.`rid` AS `rid`, `usv`.`type_id` AS `type_id`, `usv`.`type_name` AS `type_name`, `usv`.`grp_id` AS `grp_id`, `usv`.`grp_name` AS `grp_name`, `usv`.`status_id` AS `status_id`, `usv`.`status_name` AS `status_name`, `usv`.`gender_id` AS `gender_id`, `usv`.`gender_name` AS `gender_name`, `usv`.`special_id` AS `special_id`, `usv`.`special_name` AS `special_name`, `usv`.`name` AS `name`, `usv`.`logon` AS `logon`, `usv`.`password` AS `password`, `usv`.`rem` AS `rem`, `usv`.`image` AS `image` FROM (select `ss`.`id` AS `id`,`ss`.`id` AS `rid`,`ut`.`id` AS `type_id`,`ut`.`name` AS `type_name`,`gp`.`id` AS `grp_id`,`gp`.`name` AS `grp_name`,`st`.`id` AS `status_id`,`st`.`name` AS `status_name`,`gd`.`id` AS `gender_id`,`gd`.`name` AS `gender_name`,`sp`.`id` AS `special_id`,`sp`.`name` AS `special_name`,`ss`.`name` AS `name`,`ss`.`logon` AS `logon`,`ss`.`password` AS `password`,'' AS `rem`,`ss`.`image` AS `image` from (((((`cpy_user` `ss` join `cpy_user_type` `ut`) join `cpy_perm_grp` `gp`) join `phs_cod_status` `st`) join `phs_cod_gender` `gd`) join `clnc_special` `sp`) where ((`ss`.`grp_id` = `gp`.`id`) and (`ss`.`status_id` = `st`.`id`) and (`ss`.`gender_id` = `gd`.`id`) and (`ut`.`id` = 0) and (`sp`.`id` = 0)) union all select `ss`.`id` AS `id`,`ss`.`id` AS `rid`,`ut`.`id` AS `type_id`,`ut`.`name` AS `type_name`,`gp`.`id` AS `grp_id`,`gp`.`name` AS `grp_name`,`st`.`id` AS `status_id`,`st`.`name` AS `status_name`,`gd`.`id` AS `gender_id`,`gd`.`name` AS `gender_name`,`sp`.`id` AS `special_id`,`sp`.`name` AS `special_name`,`ss`.`name` AS `name`,`ss`.`username` AS `logon`,`ss`.`password` AS `password`,`ss`.`rem` AS `rem`,concat('avatars/avatar-',`ss`.`type_id`,'-',`ss`.`gender_id`,'.png') AS `image` from (((((`clnc_staff` `ss` join `cpy_user_type` `ut`) join `cpy_perm_grp` `gp`) join `phs_cod_status` `st`) join `phs_cod_gender` `gd`) join `clnc_special` `sp`) where ((`ss`.`type_id` = `ut`.`id`) and (`ss`.`grp_id` = `gp`.`id`) and (`ss`.`status_id` = `st`.`id`) and (`ss`.`gender_id` = `gd`.`id`) and (`ss`.`special_id` = `sp`.`id`))) AS `usv` ;

-- --------------------------------------------------------

--
-- Structure for view `fund_vbox`
--
DROP TABLE IF EXISTS `fund_vbox`;

DROP VIEW IF EXISTS `fund_vbox`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fund_vbox`  AS SELECT `ac`.`id` AS `acc_id`, `ac`.`num` AS `acc_num`, `ac`.`name` AS `acc_name`, `ac`.`rem` AS `acc_rem`, `us`.`id` AS `user_id`, `us`.`name` AS `user_name`, `us`.`logon` AS `user_logon`, `st`.`id` AS `status_id`, `st`.`name` AS `status_name`, `st`.`rem` AS `status_rem`, `cb`.`id` AS `box_id`, `cb`.`name` AS `box_name`, `cb`.`rem` AS `box_rem` FROM (((`cpy_user` `us` join `acc_acc` `ac`) join `fund_box` `cb`) join `phs_cod_status` `st`) WHERE ((`cb`.`user_id` = `us`.`id`) AND (`cb`.`acc_id` = `ac`.`id`) AND (`cb`.`status_id` = `st`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `fund_vdiary`
--
DROP TABLE IF EXISTS `fund_vdiary`;

DROP VIEW IF EXISTS `fund_vdiary`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fund_vdiary`  AS SELECT `ac`.`id` AS `acc_id`, `ac`.`num` AS `acc_num`, `ac`.`name` AS `acc_name`, `ac`.`rem` AS `acc_rem`, `cn`.`id` AS `cost_id`, `cn`.`num` AS `cost_num`, `cn`.`name` AS `cost_name`, `cc`.`id` AS `curn_id`, `cc`.`name` AS `curn_name`, `cc`.`rate` AS `curn_rate`, `cc`.`color` AS `curn_color`, `cc`.`code` AS `curn_code`, `ct`.`id` AS `type_id`, `ct`.`name` AS `type_name`, `cb`.`id` AS `box_id`, `cb`.`user_id` AS `box_user_id`, `cb`.`acc_id` AS `box_acc_id`, `cb`.`status_id` AS `box_status_id`, `cb`.`name` AS `box_name`, `cb`.`rem` AS `box_rem`, `aa`.`id` AS `id`, (case when (`aa`.`type_id` = 1) then `aa`.`camt` else 0 end) AS `ccrd`, (case when (`aa`.`type_id` = 2) then `aa`.`camt` else 0 end) AS `cdeb`, (case when (`aa`.`type_id` = 1) then `aa`.`amt` else 0 end) AS `crd`, (case when (`aa`.`type_id` = 2) then `aa`.`amt` else 0 end) AS `deb`, `aa`.`print` AS `print`, `aa`.`date` AS `date`, `aa`.`camt` AS `camt`, `aa`.`rate` AS `rate`, `aa`.`amt` AS `amt`, `aa`.`rem` AS `rem`, `aa`.`attach` AS `attach` FROM (((((`phs_cod_cash_type` `ct` join `mng_curn` `cc`) join `fund_box` `cb`) join `acc_acc` `ac`) join `acc_cost` `cn`) join `fund_diary` `aa`) WHERE ((`aa`.`type_id` = `ct`.`id`) AND (`aa`.`curn_id` = `cc`.`id`) AND (`aa`.`box_id` = `cb`.`id`) AND (`aa`.`acc_id` = `ac`.`id`) AND (`aa`.`cost_id` = `cn`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `phs_vprogram`
--
DROP TABLE IF EXISTS `phs_vprogram`;

DROP VIEW IF EXISTS `phs_vprogram`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `phs_vprogram`  AS SELECT `p`.`id` AS `id`, `p`.`prog_id` AS `prog_id`, `p`.`name` AS `name`, `p`.`ord` AS `ord`, ifnull(`p`.`icon`,' ') AS `icon`, `p`.`grp_id` AS `grp_id`, `p`.`open` AS `open`, `s`.`id` AS `status_id`, `s`.`name` AS `status_name`, `p`.`file` AS `file`, `p`.`css` AS `css`, `p`.`js` AS `js`, `p`.`attributes` AS `attributes`, `p`.`params` AS `params`, `y`.`id` AS `sys_id`, `y`.`status_id` AS `sys_status_id`, `y`.`name` AS `sys_name`, `t`.`id` AS `type_id`, `t`.`name` AS `type_name` FROM (((`phs_program` `p` join `phs_system` `y`) join `phs_cod_prog_type` `t`) join `phs_cod_status` `s`) WHERE ((`p`.`sys_id` = `y`.`id`) AND (`p`.`type_id` = `t`.`id`) AND (`p`.`status_id` = `s`.`id`)) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acc_acc`
--
ALTER TABLE `acc_acc`
  ADD CONSTRAINT `acc_acc_ibfk_1` FOREIGN KEY (`dbcr_id`) REFERENCES `phs_cod_dbcr` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `phs_cod_tree_type` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_4` FOREIGN KEY (`close_id`) REFERENCES `acc_close` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_5` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_6` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_7` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_acc_ibfk_8` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `acc_budmst`
--
ALTER TABLE `acc_budmst`
  ADD CONSTRAINT `acc_budmst_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_budmst_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_budmst_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_budmst_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `acc_budtrn`
--
ALTER TABLE `acc_budtrn`
  ADD CONSTRAINT `acc_budtrn_ibfk_1` FOREIGN KEY (`mst_id`) REFERENCES `acc_budmst` (`id`),
  ADD CONSTRAINT `acc_budtrn_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `acc_budtrn_ibfk_3` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `acc_budtrn_ibfk_4` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_budtrn_ibfk_5` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_budtrn_ibfk_6` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_budtrn_ibfk_7` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `acc_close`
--
ALTER TABLE `acc_close`
  ADD CONSTRAINT `acc_close_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_close_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_close_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_close_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `acc_cost`
--
ALTER TABLE `acc_cost`
  ADD CONSTRAINT `acc_cost_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `acc_cost_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `phs_cod_tree_type` (`id`),
  ADD CONSTRAINT `acc_cost_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_cost_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_cost_ibfk_5` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_cost_ibfk_6` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `acc_mst`
--
ALTER TABLE `acc_mst`
  ADD CONSTRAINT `acc_mst_ibfk_1` FOREIGN KEY (`src_id`) REFERENCES `phs_cod_src` (`id`),
  ADD CONSTRAINT `acc_mst_ibfk_2` FOREIGN KEY (`wper_id`) REFERENCES `cpy_wperiod` (`id`),
  ADD CONSTRAINT `acc_mst_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_mst_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_mst_ibfk_5` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_mst_ibfk_6` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `acc_trn`
--
ALTER TABLE `acc_trn`
  ADD CONSTRAINT `acc_trn_ibfk_1` FOREIGN KEY (`mst_id`) REFERENCES `acc_mst` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_10` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_3` FOREIGN KEY (`acc_rid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_4` FOREIGN KEY (`bcurn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_5` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_6` FOREIGN KEY (`curn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_7` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_8` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `acc_trn_ibfk_9` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_appointment`
--
ALTER TABLE `clnc_appointment`
  ADD CONSTRAINT `clnc_appointment_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `clnc_staff` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_3` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_app_status` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_5` FOREIGN KEY (`type_id`) REFERENCES `clnc_app_type` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_6` FOREIGN KEY (`special_id`) REFERENCES `clnc_special` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_7` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_appointment_ibfk_8` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_app_change`
--
ALTER TABLE `clnc_app_change`
  ADD CONSTRAINT `clnc_app_change_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `clnc_appointment` (`id`),
  ADD CONSTRAINT `clnc_app_change_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_app_change_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_app_change_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_app_status` (`id`);

--
-- Constraints for table `clnc_app_procedures`
--
ALTER TABLE `clnc_app_procedures`
  ADD CONSTRAINT `clnc_app_procedures_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `clnc_appointment` (`id`),
  ADD CONSTRAINT `clnc_app_procedures_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_app_procedures_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_app_procedures_ibfk_2` FOREIGN KEY (`procedure_id`) REFERENCES `clnc_procedure` (`id`);

--
-- Constraints for table `clnc_app_type`
--
ALTER TABLE `clnc_app_type`
  ADD CONSTRAINT `clnc_app_type_ibfk_1` FOREIGN KEY (`tbg_id`) REFERENCES `phs_cod_color` (`id`),
  ADD CONSTRAINT `clnc_app_type_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_app_type_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_app_type_ibfk_2` FOREIGN KEY (`nfg_id`) REFERENCES `phs_cod_color` (`id`),
  ADD CONSTRAINT `clnc_app_type_ibfk_3` FOREIGN KEY (`tfg_id`) REFERENCES `phs_cod_color` (`id`);

--
-- Constraints for table `clnc_clinic`
--
ALTER TABLE `clnc_clinic`
  ADD CONSTRAINT `clnc_clinic_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `clnc_clinic_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_clinic_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_discount`
--
ALTER TABLE `clnc_discount`
  ADD CONSTRAINT `clnc_discount_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_discount_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_discount_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_discount_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`);

--
-- Constraints for table `clnc_invoice`
--
ALTER TABLE `clnc_invoice`
  ADD CONSTRAINT `clnc_invoice_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_invoice_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_invoice_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_invoice_ibfk_12` FOREIGN KEY (`discount_id`) REFERENCES `phs_cod_discount_type` (`id`),
  ADD CONSTRAINT `clnc_invoice_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`);

--
-- Constraints for table `clnc_invoice_treatment`
--
ALTER TABLE `clnc_invoice_treatment`
  ADD CONSTRAINT `clnc_invoice_treatment_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `clnc_invoice` (`id`),
  ADD CONSTRAINT `clnc_invoice_treatment_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_invoice_treatment_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_invoice_treatment_ibfk_2` FOREIGN KEY (`treatment_id`) REFERENCES `clnc_treatment` (`id`);

--
-- Constraints for table `clnc_offer`
--
ALTER TABLE `clnc_offer`
  ADD CONSTRAINT `clnc_offer_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `clnc_offer_ibfk_2` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_offer_ibfk_3` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_offer_clinic`
--
ALTER TABLE `clnc_offer_clinic`
  ADD CONSTRAINT `clnc_offer_clinic_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_offer_clinic_ibfk_2` FOREIGN KEY (`offer_id`) REFERENCES `clnc_offer` (`id`),
  ADD CONSTRAINT `clnc_offer_clinic_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_offer_clinic_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_offer_procedure`
--
ALTER TABLE `clnc_offer_procedure`
  ADD CONSTRAINT `clnc_offer_procedure_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `clnc_offer` (`id`),
  ADD CONSTRAINT `clnc_offer_procedure_ibfk_2` FOREIGN KEY (`procedure_id`) REFERENCES `clnc_procedure` (`id`),
  ADD CONSTRAINT `clnc_offer_procedure_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_offer_procedure_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_patient`
--
ALTER TABLE `clnc_patient`
  ADD CONSTRAINT `clnc_patient_ibfk_1` FOREIGN KEY (`gender_id`) REFERENCES `phs_cod_gender` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_12` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_13` FOREIGN KEY (`pregnancy_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_14` FOREIGN KEY (`alcoholic_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_15` FOREIGN KEY (`breastfeed_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_16` FOREIGN KEY (`hormonal_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_17` FOREIGN KEY (`smoked_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_18` FOREIGN KEY (`visa_id`) REFERENCES `phs_cod_visa` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_19` FOREIGN KEY (`hownowid`) REFERENCES `clnc_cod_hownow` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_2` FOREIGN KEY (`idtype_id`) REFERENCES `phs_cod_idtype` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_3` FOREIGN KEY (`martial_id`) REFERENCES `phs_cod_martial` (`id`),
  ADD CONSTRAINT `clnc_patient_ibfk_4` FOREIGN KEY (`nat_id`) REFERENCES `phs_cod_nationality` (`num_code`);

--
-- Constraints for table `clnc_patient_note`
--
ALTER TABLE `clnc_patient_note`
  ADD CONSTRAINT `clnc_patient_note_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_patient_note_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_patient_note_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_patient_note_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`);

--
-- Constraints for table `clnc_payment`
--
ALTER TABLE `clnc_payment`
  ADD CONSTRAINT `clnc_payment_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_payment_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_payment_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_payment_ibfk_12` FOREIGN KEY (`method_id`) REFERENCES `phs_cod_payment_type` (`id`),
  ADD CONSTRAINT `clnc_payment_ibfk_13` FOREIGN KEY (`doctor_id`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_payment_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`);

--
-- Constraints for table `clnc_procedure`
--
ALTER TABLE `clnc_procedure`
  ADD CONSTRAINT `clnc_procedure_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `clnc_procedure_category` (`id`),
  ADD CONSTRAINT `clnc_procedure_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_procedure_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_procedure_ibfk_2` FOREIGN KEY (`vat_id`) REFERENCES `phs_cod_vat` (`id`);

--
-- Constraints for table `clnc_refund`
--
ALTER TABLE `clnc_refund`
  ADD CONSTRAINT `clnc_refund_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_refund_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_refund_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_refund_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`);

--
-- Constraints for table `clnc_staff`
--
ALTER TABLE `clnc_staff`
  ADD CONSTRAINT `clnc_staff_ibfk_1` FOREIGN KEY (`special_id`) REFERENCES `clnc_special` (`id`),
  ADD CONSTRAINT `clnc_staff_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `cpy_user_type` (`id`),
  ADD CONSTRAINT `clnc_staff_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `clnc_staff_ibfk_4` FOREIGN KEY (`gender_id`) REFERENCES `phs_cod_gender` (`id`);

--
-- Constraints for table `clnc_treatment`
--
ALTER TABLE `clnc_treatment`
  ADD CONSTRAINT `clnc_treatmen_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_treatmen_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_treatment_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `clnc_treatment_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `clnc_patient` (`id`),
  ADD CONSTRAINT `clnc_treatment_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_treatment_status` (`id`),
  ADD CONSTRAINT `clnc_treatment_ibfk_4` FOREIGN KEY (`doctor_id`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `clnc_treatment_procedures`
--
ALTER TABLE `clnc_treatment_procedures`
  ADD CONSTRAINT `clnc_treatment_procedures_ibfk_1` FOREIGN KEY (`procedure_id`) REFERENCES `clnc_procedure` (`id`),
  ADD CONSTRAINT `clnc_treatment_procedures_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_treatment_procedures_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_treatment_procedures_ibfk_12` FOREIGN KEY (`vat_id`) REFERENCES `phs_cod_vat` (`id`),
  ADD CONSTRAINT `clnc_treatment_procedures_ibfk_2` FOREIGN KEY (`treatment_id`) REFERENCES `clnc_treatment` (`id`);

--
-- Constraints for table `cpy_cod_doc`
--
ALTER TABLE `cpy_cod_doc`
  ADD CONSTRAINT `cpy_cod_doc_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_cod_doc_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_cod_unit`
--
ALTER TABLE `cpy_cod_unit`
  ADD CONSTRAINT `cpy_cod_unit_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_cod_unit_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_cod_unit_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_cod_unit_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_customize`
--
ALTER TABLE `cpy_customize`
  ADD CONSTRAINT `cpy_customize_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `phs_customize` (`id`),
  ADD CONSTRAINT `cpy_customize_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`);

--
-- Constraints for table `cpy_device`
--
ALTER TABLE `cpy_device`
  ADD CONSTRAINT `cpy_device_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_10` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_2` FOREIGN KEY (`day1`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_3` FOREIGN KEY (`day2`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_4` FOREIGN KEY (`day3`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_5` FOREIGN KEY (`day4`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_6` FOREIGN KEY (`day5`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_7` FOREIGN KEY (`day6`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_8` FOREIGN KEY (`day7`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `cpy_device_ibfk_9` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_log`
--
ALTER TABLE `cpy_log`
  ADD CONSTRAINT `phs_smb_log_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_notification`
--
ALTER TABLE `cpy_notification`
  ADD CONSTRAINT `cpy_notification_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_notification_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_perm`
--
ALTER TABLE `cpy_perm`
  ADD CONSTRAINT `cpy_perm_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `phs_cod_domain` (`id`),
  ADD CONSTRAINT `cpy_perm_ibfk_2` FOREIGN KEY (`prog_id`) REFERENCES `phs_program` (`id`),
  ADD CONSTRAINT `cpy_perm_ibfk_3` FOREIGN KEY (`grp_id`) REFERENCES `cpy_perm_grp` (`id`),
  ADD CONSTRAINT `cpy_perm_ibfk_4` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_perm_ibfk_5` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_perm_grp`
--
ALTER TABLE `cpy_perm_grp`
  ADD CONSTRAINT `cpy_perm_grp_ibfk_1` FOREIGN KEY (`wpstatus_id`) REFERENCES `phs_cod_wpstatus` (`id`),
  ADD CONSTRAINT `cpy_perm_grp_ibfk_2` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_perm_grp_ibfk_3` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_pref`
--
ALTER TABLE `cpy_pref`
  ADD CONSTRAINT `cpy_pref_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_pref_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_sequence`
--
ALTER TABLE `cpy_sequence`
  ADD CONSTRAINT `cpy_sequence_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_sequence_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_token`
--
ALTER TABLE `cpy_token`
  ADD CONSTRAINT `cpy_token_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_token_ibfk_5` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `cpy_token_ibfk_6` FOREIGN KEY (`device_id`) REFERENCES `cpy_device` (`id`),
  ADD CONSTRAINT `cpy_token_ibfk_7` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_token_ibfk_8` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_user`
--
ALTER TABLE `cpy_user`
  ADD CONSTRAINT `cpy_user_ibfk_1` FOREIGN KEY (`grp_id`) REFERENCES `cpy_perm_grp` (`id`),
  ADD CONSTRAINT `cpy_user_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `cpy_user_ibfk_3` FOREIGN KEY (`gender_id`) REFERENCES `phs_cod_gender` (`id`),
  ADD CONSTRAINT `cpy_user_ibfk_4` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_user_ibfk_5` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_user_clinic`
--
ALTER TABLE `cpy_user_clinic`
  ADD CONSTRAINT `clnc_user_clinic_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_user_clinic_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_user_clinic_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clnc_clinic` (`id`),
  ADD CONSTRAINT `cpy_user_clinic_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_user_shift`
--
ALTER TABLE `cpy_user_shift`
  ADD CONSTRAINT `clnc_user_shift_ibfk_10` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `clnc_user_shift_ibfk_11` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_user_shift_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `phs_cod_shift_type` (`id`),
  ADD CONSTRAINT `cpy_user_shift_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_user_type`
--
ALTER TABLE `cpy_user_type`
  ADD CONSTRAINT `cpy_user_type_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_user_type_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_user_type_menu`
--
ALTER TABLE `cpy_user_type_menu`
  ADD CONSTRAINT `cpy_user_type_menu_ibfk_1` FOREIGN KEY (`prog_id`) REFERENCES `phs_program` (`id`),
  ADD CONSTRAINT `cpy_user_type_menu_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `cpy_user_type` (`id`),
  ADD CONSTRAINT `cpy_user_type_menu_ibfk_3` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_user_type_menu_ibfk_4` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `cpy_wperiod`
--
ALTER TABLE `cpy_wperiod`
  ADD CONSTRAINT `cpy_wperiod_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_wpstatus` (`id`),
  ADD CONSTRAINT `cpy_wperiod_ibfk_2` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `cpy_wperiod_ibfk_3` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `fund_box`
--
ALTER TABLE `fund_box`
  ADD CONSTRAINT `fund_box_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `fund_box_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `fund_diary`
--
ALTER TABLE `fund_diary`
  ADD CONSTRAINT `fund_diary_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `fund_diary_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `mng_curn`
--
ALTER TABLE `mng_curn`
  ADD CONSTRAINT `mng_curn_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `mng_curn_ibfk_2` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `mng_curn_ibfk_3` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `mng_curn_rate`
--
ALTER TABLE `mng_curn_rate`
  ADD CONSTRAINT `mng_curn_rate_ibfk_1` FOREIGN KEY (`curn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `mng_curn_rate_ibfk_2` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `mng_curn_rate_ibfk_3` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `phs_cod_app_status`
--
ALTER TABLE `phs_cod_app_status`
  ADD CONSTRAINT `phs_cod_app_status_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `phs_cod_color` (`id`);

--
-- Constraints for table `phs_customize`
--
ALTER TABLE `phs_customize`
  ADD CONSTRAINT `phs_customize_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `phs_customize_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `phs_cod_customize_type` (`id`),
  ADD CONSTRAINT `phs_customize_ibfk_3` FOREIGN KEY (`sys_id`) REFERENCES `phs_system` (`id`),
  ADD CONSTRAINT `phs_customize_ibfk_4` FOREIGN KEY (`prog_id`) REFERENCES `phs_program` (`id`);

--
-- Constraints for table `phs_program`
--
ALTER TABLE `phs_program`
  ADD CONSTRAINT `phs_program_ibfk_1` FOREIGN KEY (`prog_id`) REFERENCES `phs_program` (`id`),
  ADD CONSTRAINT `phs_program_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `phs_cod_prog_type` (`id`),
  ADD CONSTRAINT `phs_program_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `phs_program_ibfk_4` FOREIGN KEY (`sys_id`) REFERENCES `phs_system` (`id`);

--
-- Constraints for table `phs_system`
--
ALTER TABLE `phs_system`
  ADD CONSTRAINT `phs_system_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`);

--
-- Constraints for table `phs_token`
--
ALTER TABLE `phs_token`
  ADD CONSTRAINT `phs_token_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`);

--
-- Constraints for table `str_acmst`
--
ALTER TABLE `str_acmst`
  ADD CONSTRAINT `str_acmst_ibfk_1` FOREIGN KEY (`stor_id`) REFERENCES `str_store` (`id`),
  ADD CONSTRAINT `str_acmst_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `cpy_cod_doc` (`id`),
  ADD CONSTRAINT `str_acmst_ibfk_3` FOREIGN KEY (`wper_id`) REFERENCES `cpy_wperiod` (`id`),
  ADD CONSTRAINT `str_acmst_ibfk_4` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_acmst_ibfk_5` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_actrn`
--
ALTER TABLE `str_actrn`
  ADD CONSTRAINT `str_actrn_ibfk_1` FOREIGN KEY (`mst_id`) REFERENCES `str_acmst` (`id`),
  ADD CONSTRAINT `str_actrn_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `str_item` (`id`),
  ADD CONSTRAINT `str_actrn_ibfk_7` FOREIGN KEY (`unit_id`) REFERENCES `cpy_cod_unit` (`id`),
  ADD CONSTRAINT `str_actrn_ibfk_8` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_actrn_ibfk_9` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_loc1`
--
ALTER TABLE `str_cod_loc1`
  ADD CONSTRAINT `str_cod_loc1_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_loc1_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_loc2`
--
ALTER TABLE `str_cod_loc2`
  ADD CONSTRAINT `str_cod_loc2_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_loc2_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_loc3`
--
ALTER TABLE `str_cod_loc3`
  ADD CONSTRAINT `str_cod_loc3_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_loc3_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_spc1`
--
ALTER TABLE `str_cod_spc1`
  ADD CONSTRAINT `str_cod_spc1_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_spc1_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_spc2`
--
ALTER TABLE `str_cod_spc2`
  ADD CONSTRAINT `str_cod_spc2_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_spc2_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_spc3`
--
ALTER TABLE `str_cod_spc3`
  ADD CONSTRAINT `str_cod_spc3_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_spc3_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_spc4`
--
ALTER TABLE `str_cod_spc4`
  ADD CONSTRAINT `str_cod_spc4_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_spc4_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_spc5`
--
ALTER TABLE `str_cod_spc5`
  ADD CONSTRAINT `str_cod_spc5_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_spc5_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_cod_trn_type`
--
ALTER TABLE `str_cod_trn_type`
  ADD CONSTRAINT `str_cod_trn_type_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_cod_trn_type_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_inmst`
--
ALTER TABLE `str_inmst`
  ADD CONSTRAINT `str_inmst_ibfk_0` FOREIGN KEY (`rel_id`) REFERENCES `str_oumst` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_1` FOREIGN KEY (`stor_id`) REFERENCES `str_store` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_10` FOREIGN KEY (`bcurn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_11` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_12` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_3` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_4` FOREIGN KEY (`curn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_5` FOREIGN KEY (`wper_id`) REFERENCES `cpy_wperiod` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_6` FOREIGN KEY (`doc_id`) REFERENCES `cpy_cod_doc` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_7` FOREIGN KEY (`trntype_id`) REFERENCES `str_cod_trn_type` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_8` FOREIGN KEY (`src_id`) REFERENCES `phs_cod_src` (`id`),
  ADD CONSTRAINT `str_inmst_ibfk_9` FOREIGN KEY (`vhr_id`) REFERENCES `acc_mst` (`id`);

--
-- Constraints for table `str_intrn`
--
ALTER TABLE `str_intrn`
  ADD CONSTRAINT `str_intrn_ibfk_1` FOREIGN KEY (`mst_id`) REFERENCES `str_inmst` (`id`),
  ADD CONSTRAINT `str_intrn_ibfk_10` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_intrn_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `cpy_cod_unit` (`id`),
  ADD CONSTRAINT `str_intrn_ibfk_6` FOREIGN KEY (`item_id`) REFERENCES `str_item` (`id`),
  ADD CONSTRAINT `str_intrn_ibfk_8` FOREIGN KEY (`rel_id`) REFERENCES `str_outrn` (`id`),
  ADD CONSTRAINT `str_intrn_ibfk_9` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_item`
--
ALTER TABLE `str_item`
  ADD CONSTRAINT `str_item_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `str_item_ibfk_10` FOREIGN KEY (`spc4_id`) REFERENCES `str_cod_spc4` (`id`),
  ADD CONSTRAINT `str_item_ibfk_11` FOREIGN KEY (`spc5_id`) REFERENCES `str_cod_spc5` (`id`),
  ADD CONSTRAINT `str_item_ibfk_14` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_item_ibfk_15` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_item_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `str_itemcat` (`id`),
  ADD CONSTRAINT `str_item_ibfk_3` FOREIGN KEY (`insale_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `str_item_ibfk_4` FOREIGN KEY (`season_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `str_item_ibfk_6` FOREIGN KEY (`unit_id`) REFERENCES `cpy_cod_unit` (`id`),
  ADD CONSTRAINT `str_item_ibfk_7` FOREIGN KEY (`spc1_id`) REFERENCES `str_cod_spc1` (`id`),
  ADD CONSTRAINT `str_item_ibfk_8` FOREIGN KEY (`spc2_id`) REFERENCES `str_cod_spc2` (`id`),
  ADD CONSTRAINT `str_item_ibfk_9` FOREIGN KEY (`spc3_id`) REFERENCES `str_cod_spc3` (`id`);

--
-- Constraints for table `str_itemcat`
--
ALTER TABLE `str_itemcat`
  ADD CONSTRAINT `str_itemcat_ibfk_1` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_itemcat_ibfk_2` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_oumst`
--
ALTER TABLE `str_oumst`
  ADD CONSTRAINT `str_oumst_ibfk_0` FOREIGN KEY (`rel_id`) REFERENCES `str_inmst` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_1` FOREIGN KEY (`stor_id`) REFERENCES `str_store` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_10` FOREIGN KEY (`bcurn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_11` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_12` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_3` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_4` FOREIGN KEY (`curn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_5` FOREIGN KEY (`wper_id`) REFERENCES `cpy_wperiod` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_6` FOREIGN KEY (`doc_id`) REFERENCES `cpy_cod_doc` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_7` FOREIGN KEY (`trntype_id`) REFERENCES `str_cod_trn_type` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_8` FOREIGN KEY (`src_id`) REFERENCES `phs_cod_src` (`id`),
  ADD CONSTRAINT `str_oumst_ibfk_9` FOREIGN KEY (`vhr_id`) REFERENCES `acc_mst` (`id`);

--
-- Constraints for table `str_outrn`
--
ALTER TABLE `str_outrn`
  ADD CONSTRAINT `str_outrn_ibfk_1` FOREIGN KEY (`mst_id`) REFERENCES `str_oumst` (`id`),
  ADD CONSTRAINT `str_outrn_ibfk_10` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_outrn_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `str_item` (`id`),
  ADD CONSTRAINT `str_outrn_ibfk_7` FOREIGN KEY (`unit_id`) REFERENCES `cpy_cod_unit` (`id`),
  ADD CONSTRAINT `str_outrn_ibfk_8` FOREIGN KEY (`rel_id`) REFERENCES `str_intrn` (`id`),
  ADD CONSTRAINT `str_outrn_ibfk_9` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`);

--
-- Constraints for table `str_sitem`
--
ALTER TABLE `str_sitem`
  ADD CONSTRAINT `str_sitem_ibfk_1` FOREIGN KEY (`stor_id`) REFERENCES `str_store` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_10` FOREIGN KEY (`acc_rid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_11` FOREIGN KEY (`acc_sid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_12` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_13` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `str_item` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_3` FOREIGN KEY (`loc1_id`) REFERENCES `str_cod_loc1` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_4` FOREIGN KEY (`loc2_id`) REFERENCES `str_cod_loc2` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_5` FOREIGN KEY (`loc3_id`) REFERENCES `str_cod_loc3` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_6` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_7` FOREIGN KEY (`acc_cid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_8` FOREIGN KEY (`acc_did`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_sitem_ibfk_9` FOREIGN KEY (`acc_mid`) REFERENCES `acc_acc` (`id`);

--
-- Constraints for table `str_store`
--
ALTER TABLE `str_store`
  ADD CONSTRAINT `str_store_ibfk_1` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `str_store_ibfk_10` FOREIGN KEY (`acc_sid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_store_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `phs_cod_status` (`id`),
  ADD CONSTRAINT `str_store_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `phs_cod_tree_type` (`id`),
  ADD CONSTRAINT `str_store_ibfk_4` FOREIGN KEY (`sales_id`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `str_store_ibfk_5` FOREIGN KEY (`isowned`) REFERENCES `phs_cod_yes_no` (`id`),
  ADD CONSTRAINT `str_store_ibfk_6` FOREIGN KEY (`acc_cid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_store_ibfk_7` FOREIGN KEY (`acc_did`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_store_ibfk_8` FOREIGN KEY (`acc_mid`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_store_ibfk_9` FOREIGN KEY (`acc_rid`) REFERENCES `acc_acc` (`id`);

--
-- Constraints for table `str_trmst`
--
ALTER TABLE `str_trmst`
  ADD CONSTRAINT `str_trmst_ibfk_11` FOREIGN KEY (`fstor_id`) REFERENCES `str_store` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_12` FOREIGN KEY (`tstor_id`) REFERENCES `str_store` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `acc_acc` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_3` FOREIGN KEY (`cost_id`) REFERENCES `acc_cost` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_4` FOREIGN KEY (`curn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_5` FOREIGN KEY (`wper_id`) REFERENCES `cpy_wperiod` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_6` FOREIGN KEY (`doc_id`) REFERENCES `cpy_cod_doc` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_71` FOREIGN KEY (`ftrntype_id`) REFERENCES `str_cod_trn_type` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_72` FOREIGN KEY (`ttrntype_id`) REFERENCES `str_cod_trn_type` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_73` FOREIGN KEY (`bcurn_id`) REFERENCES `mng_curn` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_74` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_75` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_8` FOREIGN KEY (`src_id`) REFERENCES `phs_cod_src` (`id`),
  ADD CONSTRAINT `str_trmst_ibfk_9` FOREIGN KEY (`vhr_id`) REFERENCES `acc_mst` (`id`);

--
-- Constraints for table `str_trtrn`
--
ALTER TABLE `str_trtrn`
  ADD CONSTRAINT `str_trtrn_ibfk_1` FOREIGN KEY (`mst_id`) REFERENCES `str_trmst` (`id`),
  ADD CONSTRAINT `str_trtrn_ibfk_10` FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`),
  ADD CONSTRAINT `str_trtrn_ibfk_6` FOREIGN KEY (`item_id`) REFERENCES `str_item` (`id`),
  ADD CONSTRAINT `str_trtrn_ibfk_8` FOREIGN KEY (`unit_id`) REFERENCES `cpy_cod_unit` (`id`),
  ADD CONSTRAINT `str_trtrn_ibfk_9` FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
