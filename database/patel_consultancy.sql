-- phpMiniAdmin dump 1.9.170730
-- Datetime: 2020-03-06 15:47:08
-- Host: 
-- Database: patel_consultancy

/*!40030 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS `matual_fund_nav_hist`;
CREATE TABLE `matual_fund_nav_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mutual_fund_id` int(11) DEFAULT NULL,
  `nav` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `matual_fund_nav_hist` DISABLE KEYS */;
INSERT INTO `matual_fund_nav_hist` VALUES ('1','3','35',NULL);
/*!40000 ALTER TABLE `matual_fund_nav_hist` ENABLE KEYS */;

DROP TABLE IF EXISTS `matul_fund_investment_hist`;
CREATE TABLE `matul_fund_investment_hist` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `investement_type` tinyint(1) DEFAULT NULL COMMENT '1 - sip , 0 - lump_sum',
  `user_id` tinyint(5) NOT NULL,
  `refrence_id` tinyint(5) DEFAULT NULL COMMENT 'if sip then > user_sip_investment > id lump_sum then > user_lamp_investment > id',
  `matual_fund_id` int(11) DEFAULT NULL COMMENT 'matual_fund > id',
  `investment_amount` double DEFAULT NULL,
  `purchased_units` double DEFAULT NULL,
  `nav_on_date` double DEFAULT NULL,
  `invested_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `matul_fund_investment_hist` DISABLE KEYS */;
INSERT INTO `matul_fund_investment_hist` VALUES ('1','1','1','1','3','1000','10','35',NULL,'2015-01-01 00:00:00',''),('2','1','1','1','3','1000','10','35',NULL,'2016-01-01 00:00:00',''),('3','1','1','1','3','1000','10','35',NULL,'2017-01-01 00:00:00',''),('4','1','1','1','3','1000','10','35',NULL,'2018-01-01 00:00:00',''),('7','1','1','1','3','1000','10','35',NULL,'2019-01-01 00:00:00',''),('8','1','1','2','1','1200','30','40','2020-02-28',NULL,NULL),('9','1','1','2','1','1200','30','40','2020-03-06',NULL,NULL),('10','1','1','2','1','1200','30','40','2020-03-13',NULL,NULL),('11','1','1','2','1','1200','30','40','2020-03-20',NULL,NULL),('12','1','1','2','1','1200','30','40','2020-03-27',NULL,NULL),('13','1','1','2','1','1200','30','40','2020-04-03',NULL,NULL),('14','1','1','2','1','1200','30','40','2020-04-10',NULL,NULL),('15','1','1','2','1','1200','30','40','2020-04-17',NULL,NULL),('16','1','1','2','1','1200','30','40','2020-04-24',NULL,NULL),('17','1','1','2','1','1200','30','40','2020-05-01',NULL,NULL),('18','1','1','2','1','1200','30','40','2020-05-08',NULL,NULL),('19','1','1','2','1','1200','30','40','2020-05-15',NULL,NULL),('20','1','1','2','1','1200','30','40','2020-05-22',NULL,NULL),('21','1','1','2','1','1200','30','40','2020-05-29',NULL,NULL),('22','1','1','2','1','1200','30','40','2020-06-05',NULL,NULL),('23','1','1','2','1','1200','30','40','2020-06-12',NULL,NULL);
/*!40000 ALTER TABLE `matul_fund_investment_hist` ENABLE KEYS */;

DROP TABLE IF EXISTS `mutual_fund`;
CREATE TABLE `mutual_fund` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `direct_or_regular` enum('direct','regular') DEFAULT NULL,
  `main_type` enum('equity','hybrid','debt','solution_oriented','other') DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL COMMENT 'matual_fund_type > id',
  `nav` decimal(10,2) DEFAULT NULL,
  `nav_updated_at` datetime DEFAULT NULL,
  `min_sip_amount` decimal(10,2) NOT NULL,
  `fund_size` double DEFAULT NULL COMMENT 'total fund amount by amc',
  `created_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - trashed, 0- not trashed ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `mutual_fund` DISABLE KEYS */;
INSERT INTO `mutual_fund` VALUES ('1','Aditya Birla Simple Plan','2',NULL,'equity','11','35.20','2020-02-23 23:36:12','0.00',NULL,'2020-01-22 12:08:15','0','0'),('2','HDFC Prodencial Fund',NULL,NULL,NULL,NULL,'54.56',NULL,'0.00',NULL,'2020-01-22 12:10:50','1','0'),('3','Axis Bluechip Fund Direct Plan Growth','2',NULL,'equity','11','40.00','2020-02-09 09:32:10','0.00',NULL,'2020-02-08 19:43:58','1','0'),('4','Axis Prodential','2',NULL,'equity','11','30.10','2020-02-09 19:09:39','500.00',NULL,'2020-02-09 19:09:39','1','0');
/*!40000 ALTER TABLE `mutual_fund` ENABLE KEYS */;

DROP TABLE IF EXISTS `mutual_fund_company`;
CREATE TABLE `mutual_fund_company` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `amc` varchar(255) DEFAULT NULL COMMENT 'Asset management company',
  `sponsors` varchar(255) DEFAULT NULL,
  `image` mediumtext,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - trashed, 0- not trashed ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `mutual_fund_company` DISABLE KEYS */;
INSERT INTO `mutual_fund_company` VALUES ('1','HDFC',NULL,NULL,'MF-638-hdfc.png','2020-01-21 14:47:54','1','0'),('2','Axis',NULL,NULL,'MF-229-axis.jpg','2020-02-05 00:11:31','1','0'),('3','SBI',NULL,NULL,'MF-458-sbi.jpg','2020-03-04 00:01:36','1','0'),('4','ICICI',NULL,NULL,'MF-615-icici.png','2020-03-04 00:02:13','1','0'),('5','Birla',NULL,NULL,'MF-464-birla.png','2020-03-04 00:02:41','1','0');
/*!40000 ALTER TABLE `mutual_fund_company` ENABLE KEYS */;

DROP TABLE IF EXISTS `mutual_fund_type`;
CREATE TABLE `mutual_fund_type` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `main_type` enum('equity','hybrid','debt','solution_oriented','other') DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - trashed, 0- not trashed ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `mutual_fund_type` DISABLE KEYS */;
INSERT INTO `mutual_fund_type` VALUES ('1','equity','Large and Mid Cap',NULL,'2020-01-19 12:27:46','1','0'),('10',NULL,'Mid Cap Fund',NULL,'2020-02-04 23:50:43','1','0'),('11','equity','Large cap',NULL,'2020-02-08 00:05:08','1','0'),('12','equity','Small Cap',NULL,'2020-02-08 00:12:18','1','0');
/*!40000 ALTER TABLE `mutual_fund_type` ENABLE KEYS */;

DROP TABLE IF EXISTS `mutual_fund_user`;
CREATE TABLE `mutual_fund_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investment_through` enum('patel_consultancy','other') DEFAULT NULL COMMENT 'patel_consultancy, other',
  `user_id` int(11) DEFAULT NULL,
  `folio_no` varchar(255) DEFAULT NULL,
  `matual_fund_id` int(11) DEFAULT NULL,
  `sip_amount` decimal(10,2) DEFAULT NULL,
  `total_units` double DEFAULT NULL COMMENT 'on change rate in matule fund, change unit',
  `invested_amount` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `absolute_return` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `annual_return` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_trashed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - trashed, 0- not trashed ',
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `mutual_fund_user` DISABLE KEYS */;
INSERT INTO `mutual_fund_user` VALUES ('1','other','1','123456','3','0.00','285.71','10000','2020-02-09','14.28','2020-02-09 00:00:00','0','1','0',NULL),('2','other','1','123456','4','0.00','10','1000','2020-02-09',NULL,'2020-02-09 00:00:00',NULL,'1','0',NULL),('3','other','2','123','4','1233.00',NULL,NULL,'2020-02-13',NULL,'2020-02-22 23:36:31',NULL,NULL,'0','2020-02-26');
/*!40000 ALTER TABLE `mutual_fund_user` ENABLE KEYS */;

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_title` varchar(255) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `is_required` enum('1','0') NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES ('1','Site Title','SITE_TITLE','Patel Consultancy','1','2018-03-10 17:31:13','2019-12-29 12:47:14'),('2','From Email','FROM_EMAIL','info@patelconsultancy.com','1','2018-03-10 17:31:13','2019-12-29 12:47:14'),('3','From Email Title','FROM_EMAIL_TITLE','Patel Consultancy','1','2018-03-10 17:31:32','2019-12-29 12:47:14'),('4','Admin Email','ADMIN_EMAIL','patelconsultancy@gmail.com','1','2018-03-10 17:32:01','2019-12-29 12:47:14'),('5','Admin Email CC 1','ADMIN_EMAIL_CC1','','0','2018-03-10 17:32:46','2018-05-19 15:28:37'),('6','Admin Email CC 2','ADMIN_EMAIL_CC2','','0','2018-03-10 17:32:46','2018-05-19 15:28:39'),('7','SMTP HOST','smtp_host','','0','2018-03-10 17:33:13','2018-05-19 15:29:02'),('8','SMTP PORT','smtp_port','','0','2018-03-10 17:33:47','2018-05-19 15:28:59'),('9','SMTP USER','smtp_user','','0','2018-03-10 17:33:47','2018-05-19 15:28:56'),('10','SMTP PASSWORD','smtp_pass','','0','2018-03-10 17:34:09','2018-05-19 15:28:53'),('11','EMAIL_FUNCTIONALITY_VARIFICATION','EMAIL_FUNCTIONALITY_VARIFICATION','0','0','0000-00-00 00:00:00','2020-01-31 05:01:05');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `mobile_number_1` varchar(15) NOT NULL,
  `mobile_number_2` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `gender` enum('Male','Female','Transgender') NOT NULL,
  `role` enum('Admin','User') NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `is_enable` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1','Patel Consultancy','otg','patelconsultancy@gmail.com','09913692740','','Rajkot','<br>','Male','Admin','background1.jpg','e94049558d21fabbd8124d874355b1ad','eb0bc03b321ab5343591e63489b5e475218b531a','1','2019-12-29 10:45:47','2019-12-29 12:55:07');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

DROP TABLE IF EXISTS `user_lamp_sum_investment`;
CREATE TABLE `user_lamp_sum_investment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio_no` varchar(255) DEFAULT NULL,
  `matual_fund_id` int(11) DEFAULT NULL,
  `invested_amount` double DEFAULT NULL,
  `nav_on_date` double DEFAULT NULL,
  `invested_at` datetime DEFAULT NULL,
  `units` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `user_lamp_sum_investment` DISABLE KEYS */;
INSERT INTO `user_lamp_sum_investment` VALUES ('1','12351','1','1000','35','2020-02-01 00:00:00','10');
/*!40000 ALTER TABLE `user_lamp_sum_investment` ENABLE KEYS */;

DROP TABLE IF EXISTS `user_register`;
CREATE TABLE `user_register` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(80) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `user_email` text NOT NULL,
  `email_varify` tinyint(4) DEFAULT '0' COMMENT '0 = no, 1 - yes',
  `varification_code` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `pan_no` varchar(12) DEFAULT NULL,
  `profile_picture` longtext,
  `pan_card_img` longtext,
  `address` text NOT NULL,
  `request_status` tinyint(4) DEFAULT NULL COMMENT 'default null, 0 - declined, 1 - approved',
  `status` enum('0','1') NOT NULL COMMENT '1=''active'' , 0=''deactive''',
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `user_register` DISABLE KEYS */;
INSERT INTO `user_register` VALUES ('1','dytlRPxAakvCrhZWMSO50HDNomgBIbqw6c48z172uXY3pjf9KQnGTEVLUsJF','Romik','de5c768c4cacd5fd96f35491c0c1177199d02414f345a9b96bcc230bc1bbcbbeea17bafdfbf29b022ed40836772b0fe03c941b1502b6af1c13c36b1788604859zoVIBVgxMJaNYDmAZV0OACtiHWLbyqJxkWfo6bxAudM=','makavanaromik1214@gmail.com','0',NULL,'123456789','123456789123','1_DailyTrends.png','http://192.168.43.113/patel_consultancy/uploads/pan_card_img/1_Pictures.jpg','','1','1','2020-01-31 05:01:44'),('2','5CcS2LPx6lXkGRygN9e304Vmvb8ZtUrHIKBMqOonAs1jzhJTaWpFfuDwEdi7','Romik','bd493fad2357c917bcd6bbcbb64dd66bfc6a839fc83548ad36a81675bbb90655f169a1b7a58ed56b81c7b0048ce9471a5e928e14e5cf82d428dd135d036b8c8ag4CuRamKJsAmC0gHmmgZ0PtAbqIB7XNaCwrCJftnjKA=','makavanaromik12141@gmail.com','0',NULL,'9913357614',NULL,NULL,NULL,'',NULL,'0','2020-02-05 00:20:42'),('3','L6rdo1VCx5gjnXh940WkUplITNQHMv2ODFfPBGsAYE3y7aRS8mwuKJqicztb','Milan Pithadiya','048ae9ffb473257cac0a8519a73d3c39b97c5abdb9867c3711f56d987072899093d26dcc077045934ea58066d90052ba639d8b333245fb103e9635a6f6e7c31frZl5hLGnGqhJuuWoAmiBo4cu8h6wjxknxvXzU7nyTV4=','milanmsp7@gmail.com','0',NULL,'9824795495',NULL,NULL,NULL,'','0','1','2020-02-23 11:56:39'),('6','neJ10WlqoT3dKQjkURxwNHruCVhzm65BibpEvts4AIO7caZ29PLgfMGSFDXy','Harsh','946ebfc88108f81642bd6e6df690371cf6a400c9e7200d50e36b3280d74fd456e5f2f80d1c50a77f6b2f3398cd3ee358e0d234ff28be21f164e8eff6bcc35c9en+EVdBHzGC2bnzGK1Ofwp91jO9gzVfjc5JdwUErKPV4=','harsh@gmail.com','0',NULL,'9912092743',NULL,NULL,NULL,'',NULL,'0','2020-03-01 12:15:53'),('7','W9NgMmYZ4iOPXejFClsbctBQR3hVIoxr7wHfuT1v852aJzpqnL6SyD0kdAKU','Milan','c1f12be80663d41b39cb85d213985046c8753584814f577a218215ecec5c5cd0ce13a850f67c0266838083572bb43ec2328bb7c1ea77326c71f95a1d36c4851embTvJSSdiS7YmYGFhk19lb4WErStDsNePsZ2rO9Dw08=','msp@gmail.com','0',NULL,'8866874892',NULL,NULL,NULL,'',NULL,'0','2020-03-01 16:11:45'),('9','TDdXug92xZSFzPtY5s1lIjAGbiQOWqRMyvJ7nwC0oaNBk4cm3Kr8UHVELe6p','Karan','76fb65d2bd4ba797eacc5a61c1dbe2245eeccb83875d7bea88e2ba16c0e329fc1db5dda18744e95f654e0f8e241fcb1383950e0403095d0dbde557f0dad8f501oVb41DM0mv6zr1ex4ostS1jWFZiAXaLPmdVvWKoXuDY=','karan@gmail.com','0',NULL,'8320578705',NULL,NULL,NULL,'','1','1','2020-03-02 11:33:23'),('10','rQJqk7hepOdIXjWctiGT0H1Mvx5bSzUmF8aRy62BLKfEo3DgAVwPN4n9ZuYC','Karan','9f7ec57269752f30385b8fd081ab74e5cf1566f5efc266fc4bbe0decada9102b2699b166459e7fcf3c09a0d59d8998135a98680f28cc4b35202d58febe8446fe0obTxx0SicEXunfuqqqmkaLUzWMNLgCpphdBM9wU0EU=','k@gmail.com','0',NULL,'9913692740',NULL,NULL,NULL,'',NULL,'0','2020-03-02 11:35:46'),('11','lUjyq8CvgYkTVupJ1zO9NLt0dn3hbQfexrEPIZMwGaH765KiWmcXsARo2DF4','Karan','165173cac56f4b255a93d7b8cbb41b89de2d3f2426b27056ca7e0a1993de4cefe82ceb7f3f88765d1418de47ff099033a5780c42b5aae252c13e409bfe361ae847BHk6KAJ5npv/H20kxGEq9HYyzfScilIukzZoqZ/MA=','sdabc@gmail.com','0',NULL,'9408181372',NULL,NULL,NULL,'',NULL,'0','2020-03-02 11:38:57');
/*!40000 ALTER TABLE `user_register` ENABLE KEYS */;

DROP TABLE IF EXISTS `user_sip_investement`;
CREATE TABLE `user_sip_investement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investment_through` enum('patel_consultancy','other') DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `folio_no` varchar(255) DEFAULT NULL,
  `matual_fund_id` int(11) DEFAULT NULL,
  `sip_amount` double DEFAULT NULL,
  `invested_amount` double DEFAULT NULL,
  `time_period` enum('weekly','fortnightly','monthly','quarterly') DEFAULT NULL,
  `investment_for` varchar(255) DEFAULT NULL,
  `target_amount` double DEFAULT NULL,
  `units` double DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_trashed` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 - trashed, 0- not trashed',
  `created_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=''active'' , 0=''deactive''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `user_sip_investement` DISABLE KEYS */;
INSERT INTO `user_sip_investement` VALUES ('1','other','1','123451','3','500','0','monthly','1 years,0 months','6000','0','2020-01-28 00:00:00',NULL,'0','2020-03-01 16:54:47','1'),('2','patel_consultancy','1','123456','3','1200',NULL,'weekly','1 years,6 months',NULL,NULL,'2020-02-28 00:00:00',NULL,'0','2020-03-01 16:47:21','1');
/*!40000 ALTER TABLE `user_sip_investement` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


-- phpMiniAdmin dump end
