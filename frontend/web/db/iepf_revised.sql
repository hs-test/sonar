/*
SQLyog Ultimate v11.33 (32 bit)
MySQL - 10.1.35-MariaDB : Database - iepf
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`iepf-v1` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `iepf-v1`;

/*Table structure for table `company` */

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cin_no` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`),
  UNIQUE KEY `cin_no` (`cin_no`),
  KEY `company_created_by` (`created_by`),
  CONSTRAINT `company_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `company` */

/*Table structure for table `financial_year` */

CREATE TABLE `financial_year` (
  `code` smallint(4) NOT NULL,
  `guid` varchar(40) NOT NULL,
  `name` varchar(10) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `financial_year_guid` (`guid`),
  UNIQUE KEY `name` (`name`),
  KEY `financial_year_created_by` (`created_by`),
  KEY `financial_year_modified_by` (`modified_by`),
  CONSTRAINT `financial_year_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `financial_year_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `financial_year` */

/*Table structure for table `grievance` */

CREATE TABLE `grievance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `srn_no` varchar(50) NOT NULL,
  `applicant_name` varchar(50) NOT NULL,
  `applicant_designation` varchar(50) DEFAULT NULL,
  `no_of_share` int(11) NOT NULL,
  `financial_year` smallint(4) NOT NULL,
  `security_depository_type` enum('NSDL','CDSL') NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0-pending',
  `discrepancy_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`),
  UNIQUE KEY `srn_no` (`srn_no`),
  KEY `grievance_company_id` (`company_id`),
  KEY `grievance_created_by` (`created_by`),
  KEY `grievance_discrepancy_id` (`discrepancy_id`),
  KEY `grievance_financial_year` (`financial_year`),
  KEY `grievance_modified_by` (`modified_by`),
  CONSTRAINT `grievance_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `grievance_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `grievance_discrepancy_id` FOREIGN KEY (`discrepancy_id`) REFERENCES `list_type` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `grievance_financial_year` FOREIGN KEY (`financial_year`) REFERENCES `financial_year` (`code`) ON UPDATE NO ACTION,
  CONSTRAINT `grievance_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `grievance` */

/*Table structure for table `grievance_log` */

CREATE TABLE `grievance_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grievance_id` int(11) NOT NULL,
  `grievance_status` tinyint(2) NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grievance_log_created_by` (`created_by`),
  KEY `grievance_log_grievance_id` (`grievance_id`),
  CONSTRAINT `grievance_log_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `grievance_log_grievance_id` FOREIGN KEY (`grievance_id`) REFERENCES `grievance` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `grievance_log` */

/*Table structure for table `list_type` */

CREATE TABLE `list_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(40) NOT NULL,
  `category` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `display_order` tinyint(2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`),
  UNIQUE KEY `title` (`title`),
  KEY `list_type_created_by` (`created_by`),
  KEY `list_type_modified_by` (`modified_by`),
  CONSTRAINT `list_type_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `list_type_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `list_type` */

/*Table structure for table `media` */

CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(40) NOT NULL,
  `media_type` char(30) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `cdn_path` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_created_by` (`created_by`),
  CONSTRAINT `media_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `media` */

/*Table structure for table `migration` */

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `migration` */

/*Table structure for table `role` */

CREATE TABLE `role` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `role` */

insert  into `role`(`id`,`name`) values (1,'SuperAdmin');

/*Table structure for table `user` */

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role_id` tinyint(2) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '10',
  `created_on` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`),
  UNIQUE KEY `username` (`username`),
  KEY `user_role_id` (`role_id`),
  CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
