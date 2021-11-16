-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2020 at 01:21 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pc_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `policy_master`
--

CREATE TABLE `policy_master` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `policy_no` bigint(20) DEFAULT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `sub_category_id` bigint(20) DEFAULT NULL,
  `sum_assured` float DEFAULT NULL,
  `premium_amount` bigint(20) DEFAULT NULL,
  `permium_paying_term` bigint(4) DEFAULT NULL COMMENT 'in year',
  `last_premium_date` date DEFAULT NULL,
  `premium_mode` text,
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `other_fields` text,
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `policy_master`
--

INSERT INTO `policy_master` (`id`, `user_id`, `policy_no`, `plan_name`, `issue_date`, `company_id`, `category_id`, `sub_category_id`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `other_fields`, `is_trashed`, `created_at`, `updated_at`) VALUES
(1, 12, 12, 'policy', '2020-06-17', 1, 1, 1, NULL, 2000, NULL, NULL, '1', 0, NULL, NULL, '2020-06-17 07:27:56', '2020-06-17 07:27:56'),
(4, 12, 3, 'yhtuk', '2020-06-18', 1, 1, 1, NULL, 8000, NULL, '2022-06-18', '1', 2, NULL, NULL, '2020-06-18 01:07:02', '2020-06-18 01:07:02'),
(7, 11, 11, 'ertyui', '2020-06-18', 1, 1, 1, 8000, 60000, NULL, '2023-06-18', '1', 3, NULL, NULL, '2020-06-18 05:17:15', '2020-06-18 05:17:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `policy_master`
--
ALTER TABLE `policy_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `policy_master`
--
ALTER TABLE `policy_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
