-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2020 at 11:04 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patel_consultancy_laravel_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `greetings`
--

CREATE TABLE `greetings` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` enum('yearly') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `greetings`
--

INSERT INTO `greetings` (`id`, `title`, `body`, `image`, `frequency`, `date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 'Happy Diwali', 'Have a happy and prosperous Diwali! Wish you all a very very happy diwali and hope that every person transform from the darkness to the happiness.', '9.jpg', 'yearly', '2020-04-26', 1, '2020-04-26 02:10:20', '2020-04-26 02:10:20', NULL),
(10, 'Happy Makar Sankranti', 'Wish you and your family a very Happy Makar Sankranti! May the Makar Sankranti fire bring you joy and happiness and burn all your moments of sadness.', NULL, 'yearly', '2020-04-26', 1, '2020-04-26 02:28:02', '2020-04-26 02:28:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_category`
--

CREATE TABLE `insurance_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_category`
--

INSERT INTO `insurance_category` (`id`, `name`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 'Health insurance', 1, '2020-06-15 21:12:12', '2020-06-15 21:12:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_company`
--

CREATE TABLE `insurance_company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_company`
--

INSERT INTO `insurance_company` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 'Life Insurance Corporation of India', '1.png', 1, '2020-06-15 21:13:38', '2020-06-15 21:13:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_fields`
--

CREATE TABLE `insurance_fields` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_fields`
--

INSERT INTO `insurance_fields` (`id`, `name`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 'Car Insurance', 1, '2020-06-15 21:15:00', '2020-06-15 21:15:00', NULL),
(2, 'Life Insurance', 1, '2020-06-23 01:35:05', '2020-06-23 01:35:05', NULL),
(3, 'Auto Insurance', 1, '2020-06-23 01:35:24', '2020-06-23 01:35:24', NULL),
(4, 'Residential Property Insurance', 1, '2020-06-23 01:35:41', '2020-06-23 01:35:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_field_details`
--

CREATE TABLE `insurance_field_details` (
  `id` int(11) NOT NULL,
  `insurance_field_id` int(11) DEFAULT NULL,
  `fieldname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_field_details`
--

INSERT INTO `insurance_field_details` (`id`, `insurance_field_id`, `fieldname`, `description`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 1, 'Car Model', 'Enter Car Model', 1, '2020-06-21 07:11:11', '2020-06-25 23:35:42', NULL),
(2, 1, 'Car Company', 'Enter your Car Company', 1, '2020-06-22 11:16:18', '2020-06-24 00:19:56', NULL),
(3, 2, 'Name', NULL, 1, '2020-06-23 01:39:00', '2020-06-23 01:39:00', NULL),
(4, 2, 'Person Birthdate', NULL, 1, '2020-06-23 01:44:19', '2020-06-23 01:44:19', NULL),
(5, 2, 'Maturity Date', NULL, 1, '2020-06-23 23:57:32', '2020-06-23 23:57:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_sub_category`
--

CREATE TABLE `insurance_sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_sub_category`
--

INSERT INTO `insurance_sub_category` (`id`, `category_id`, `name`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 1, 'Accident insurance', 1, '2020-06-15 21:12:26', '2020-06-15 21:12:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_slider`
--

CREATE TABLE `main_slider` (
  `id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_slider`
--

INSERT INTO `main_slider` (`id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, '1.jpg', 1, '2020-04-27', '2020-04-27 09:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_04_03_030119_create_model_has_permissions_table', 1),
(2, '2020_04_03_030119_create_model_has_roles_table', 1),
(3, '2020_04_03_030119_create_mutual_fund_company_table', 1),
(4, '2020_04_03_030119_create_mutual_fund_investment_hist_table', 1),
(5, '2020_04_03_030119_create_mutual_fund_nav_hist_table', 1),
(6, '2020_04_03_030119_create_mutual_fund_table', 1),
(7, '2020_04_03_030119_create_mutual_fund_type_table', 1),
(8, '2020_04_03_030119_create_mutual_fund_user_table', 1),
(9, '2020_04_03_030119_create_password_resets_table', 1),
(10, '2020_04_03_030119_create_permissions_table', 1),
(11, '2020_04_03_030119_create_role_has_permissions_table', 1),
(12, '2020_04_03_030119_create_roles_table', 1),
(13, '2020_04_03_030119_create_site_settings_table', 1),
(14, '2020_04_03_030119_create_user_lamp_sum_investment_table', 1),
(15, '2020_04_03_030119_create_user_register_table', 1),
(16, '2020_04_03_030119_create_user_sip_investement_table', 1),
(17, '2020_04_03_030119_create_users_table', 1),
(18, '2020_04_03_030122_add_foreign_keys_to_model_has_permissions_table', 1),
(19, '2020_04_03_030122_add_foreign_keys_to_model_has_roles_table', 1),
(20, '2020_04_03_030122_add_foreign_keys_to_role_has_permissions_table', 1),
(21, '2020_04_21_030204_update_users_for_greetings', 2),
(22, '2020_04_21_031007_create_greetings_table', 3),
(23, '2020_04_25_140038_create_main_sliders_table', 3),
(24, '2020_06_07_082421_add_doc_and_doc_limit_to_user_table', 4),
(25, '2020_06_21_073533_create_insurance_field_details_table', 5),
(26, '2020_06_25_051733_add_insurance_field_id_to_policy_master', 6),
(29, '2020_06_21_121233_create_user_document_table', 7),
(30, '2020_06_28_063520_create_user_plans_table', 8),
(33, '2020_06_28_063532_create_user_plan_sips_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(2, 'App\\User', 3),
(2, 'App\\User', 10),
(2, 'App\\User', 11),
(2, 'App\\User', 12),
(2, 'App\\User', 13),
(2, 'App\\User', 14),
(2, 'App\\User', 15),
(2, 'App\\User', 16),
(2, 'App\\User', 17);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund`
--

CREATE TABLE `mutual_fund` (
  `id` int(11) NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `direct_or_regular` enum('direct','regular') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_type` enum('equity','hybrid','debt','solution_oriented','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL COMMENT 'matual_fund_type > id',
  `nav` decimal(10,2) DEFAULT NULL,
  `nav_updated_at` datetime DEFAULT NULL,
  `min_sip_amount` decimal(10,2) DEFAULT NULL,
  `fund_size` double DEFAULT NULL COMMENT 'total fund amount by amc',
  `created_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund`
--

INSERT INTO `mutual_fund` (`id`, `name`, `company_id`, `direct_or_regular`, `main_type`, `type_id`, `nav`, `nav_updated_at`, `min_sip_amount`, `fund_size`, `created_at`, `status`, `is_trashed`, `updated_at`) VALUES
(1, 'Jeanette Bins', 1, NULL, 'equity', 1, '20.00', NULL, '500.00', NULL, '2020-03-29 08:15:07', 1, NULL, NULL),
(2, 'Nella Stehr', 2, NULL, 'equity', 1, '13.00', NULL, '1000.00', NULL, '2020-03-29 08:15:07', 1, NULL, '2020-06-12 05:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_company`
--

CREATE TABLE `mutual_fund_company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Asset management company',
  `sponsors` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_company`
--

INSERT INTO `mutual_fund_company` (`id`, `name`, `amc`, `sponsors`, `image`, `created_at`, `status`, `is_trashed`) VALUES
(1, 'Ms. Theresa Marks', NULL, NULL, '2.jpg', '2020-03-29 08:15:01', 1, '2020-04-07 00:00:00'),
(2, 'Karianne Hauck', NULL, NULL, '2.jpg', '2020-03-29 08:15:01', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_investment_hist`
--

CREATE TABLE `mutual_fund_investment_hist` (
  `id` int(11) NOT NULL,
  `investement_type` int(11) DEFAULT NULL COMMENT '1 - sip , 0 - lump_sum',
  `user_id` int(11) DEFAULT NULL,
  `refrence_id` int(11) DEFAULT NULL COMMENT 'if sip then > user_sip_investment > id lump_sum then > user_lamp_investment > id',
  `mutual_fund_user_id` int(11) DEFAULT NULL,
  `matual_fund_id` int(11) DEFAULT NULL COMMENT 'matual_fund > id',
  `investment_amount` double DEFAULT NULL,
  `purchased_units` double DEFAULT NULL,
  `nav_on_date` double DEFAULT NULL,
  `invested_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_investment_hist`
--

INSERT INTO `mutual_fund_investment_hist` (`id`, `investement_type`, `user_id`, `refrence_id`, `mutual_fund_user_id`, `matual_fund_id`, `investment_amount`, `purchased_units`, `nav_on_date`, `invested_date`, `created_at`, `remarks`, `deleted_at`) VALUES
(1, 1, 2, 1, NULL, 1, 500, 50, 10, '2020-04-01', '2020-04-01 03:22:35', NULL, '2020-04-02 02:08:48'),
(2, 1, 2, 1, NULL, 1, 500, 50, 10, '2020-05-01', '2020-04-02 01:03:26', NULL, '2020-04-06 00:00:00'),
(3, 1, 2, 1, 2, 1, 500, 50, 10, '2020-04-01', '2020-04-02 02:10:07', NULL, '2020-04-05 03:37:04'),
(5, 1, 2, 1, 2, 1, 500, 50, 10, '2020-05-01', '2020-04-02 02:47:07', NULL, '2020-04-02 02:47:40'),
(8, 1, 2, 1, 2, 1, 500, 50, 10, '2019-03-01', '2020-04-02 02:49:10', NULL, '2020-04-05 03:37:04'),
(10, 1, 2, 1, 2, 1, 500, 50, 10, '2020-05-01', '2020-04-02 02:54:43', NULL, '2020-04-02 02:55:11'),
(11, 0, 3, 2, 4, 1, 1200, 120, 10, '2019-01-01', '2020-04-04 02:37:22', 'test note', '2020-04-05 03:38:55'),
(12, 0, 2, 3, 5, 1, 1000, 100, 10, '2020-10-04', '2020-04-10 08:42:50', NULL, NULL),
(13, 0, 2, 4, 2, 1, 10000, 1000, 10, '2019-01-01', '2020-04-10 08:45:40', NULL, NULL),
(14, 0, 2, 5, 6, 2, 12000, 1200, 10, '2019-01-01', '2020-04-14 18:19:29', NULL, NULL),
(15, 1, 14, 4, 9, 1, 500, 25, 20, '2020-04-26', '2020-04-26 10:39:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_nav_hist`
--

CREATE TABLE `mutual_fund_nav_hist` (
  `id` int(11) NOT NULL,
  `mutual_fund_id` int(11) DEFAULT NULL,
  `nav` double DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_nav_hist`
--

INSERT INTO `mutual_fund_nav_hist` (`id`, `mutual_fund_id`, `nav`, `date`) VALUES
(1, 2, 13, NULL),
(2, 2, 13, '2020-06-08 13:32:05'),
(3, 2, 12, '2020-06-11 22:00:07'),
(4, 2, 13, '2020-06-12 00:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_type`
--

CREATE TABLE `mutual_fund_type` (
  `id` int(11) NOT NULL,
  `main_type` enum('equity','hybrid','debt','solution_oriented','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_type`
--

INSERT INTO `mutual_fund_type` (`id`, `main_type`, `name`, `description`, `created_at`, `status`, `is_trashed`) VALUES
(1, 'equity', 'Odell Ondricka', NULL, '2020-03-29 08:14:55', 1, NULL),
(2, 'equity', 'Rosendo Wisozk', NULL, '2020-03-29 08:14:55', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_user`
--

CREATE TABLE `mutual_fund_user` (
  `id` int(11) NOT NULL,
  `investment_through` enum('patel_consultancy','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'patel_consultancy, other',
  `user_id` int(11) DEFAULT NULL,
  `folio_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matual_fund_id` int(11) DEFAULT NULL,
  `sip_amount` decimal(10,2) DEFAULT NULL,
  `total_units` double DEFAULT NULL COMMENT 'on change rate in matule fund, change unit',
  `invested_amount` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `absolute_return` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `annual_return` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `annual_cached_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_user`
--

INSERT INTO `mutual_fund_user` (`id`, `investment_through`, `user_id`, `folio_no`, `matual_fund_id`, `sip_amount`, `total_units`, `invested_amount`, `start_date`, `absolute_return`, `created_at`, `annual_return`, `status`, `is_trashed`, `end_date`, `updated_at`, `annual_cached_at`) VALUES
(2, NULL, 2, '123456', 1, '0.00', 1000, 10000, '2020-03-29', 100, '2020-03-29 09:19:50', 71.7, 1, NULL, NULL, NULL, NULL),
(4, NULL, 3, '123456', 1, NULL, 0, 0, '2020-04-04', 0, '2020-04-04 02:37:22', 0, 1, NULL, NULL, NULL, NULL),
(5, NULL, 2, '0001', 1, NULL, 100, 1000, '2020-04-10', 100, '2020-04-10 08:42:50', 0, 1, NULL, NULL, NULL, NULL),
(6, NULL, 2, '123455', 2, NULL, 1200, 12000, '2020-04-14', 20, '2020-04-14 18:19:29', 19.93, 1, NULL, NULL, '2020-06-12 05:47:19', '2020-06-12 05:47:19'),
(7, NULL, 17, '123456', 1, '1200.00', 100, 12000, '2020-04-26', NULL, '2020-04-26 10:31:06', NULL, 1, NULL, NULL, NULL, NULL),
(8, NULL, 17, '123457', 2, '1300.00', 100, 13000, '2020-04-26', NULL, '2020-04-26 10:35:32', NULL, 1, NULL, NULL, NULL, NULL),
(9, NULL, 14, '123458', 1, '500.00', 25, 500, '2020-04-26', 0, '2020-04-26 10:36:59', 0, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('makavanaromik1214@gmail.com', '$2y$10$qbsRyaXe5f3aa4ZzvfWOHu.5eQa5P/zDJ.94hdgKei7WV1FlBOgWu', '2020-04-08 02:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `premium_mode` text DEFAULT NULL,
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `other_fields` text DEFAULT NULL,
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `insurance_field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `policy_master`
--

INSERT INTO `policy_master` (`id`, `user_id`, `policy_no`, `plan_name`, `issue_date`, `company_id`, `category_id`, `sub_category_id`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `other_fields`, `is_trashed`, `created_at`, `updated_at`, `insurance_field_id`) VALUES
(1, 12, 12, 'policy', '2020-06-17', 1, 1, 1, NULL, 2000, NULL, NULL, '1', 0, NULL, NULL, '2020-06-17 07:27:56', '2020-06-17 07:27:56', 0),
(4, 12, 3, 'yhtuk', '2020-06-18', 1, 1, 1, NULL, 8000, NULL, '2022-06-18', '1', 2, NULL, NULL, '2020-06-18 01:07:02', '2020-06-18 01:07:02', 0),
(7, 11, 11, 'ertyui', '2020-06-18', 1, 1, 1, 8000, 60000, NULL, '2023-06-18', '1', 3, NULL, NULL, '2020-06-18 05:17:15', '2020-06-18 05:17:15', 0),
(15, 2, 12345, 'New Plan', '2020-06-26', 1, 1, 1, 250000, 1300, NULL, '2040-06-27', 'monthly', 20, '[{\"car_model\":\"XUV\"},{\"car_company\":\"Honda\"}]', NULL, '2020-06-26 03:31:00', '2020-06-27 15:37:59', 1),
(16, 2, 123, 'New Plans', '2020-06-27', 1, 1, 1, 129999, 1300, NULL, '2030-06-27', 'monthly', 10, '[{\"name\":\"XYZ\"},{\"person_birthdate\":\"20-10-1999\"},{\"maturity_date\":\"20-10-2022\"}]', NULL, '2020-06-27 12:37:19', '2020-06-27 15:35:47', 2),
(17, 3, 123456, 'Qwerty', '2020-06-27', 1, 1, 1, 1227780, 1200, NULL, '2030-06-27', 'monthly', 10, '[{\"name\":\"MSP\"},{\"person_birthdate\":\"21-02-2002\"},{\"maturity_date\":\"2025\"}]', '2020-06-27', '2020-06-27 15:47:18', '2020-06-27 15:47:59', 2);

-- --------------------------------------------------------

--
-- Table structure for table `premium_master`
--

CREATE TABLE `premium_master` (
  `id` bigint(20) NOT NULL,
  `policy_id` bigint(20) DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `premium_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2020-03-29 02:44:43', '2020-03-29 02:44:43'),
(2, 'client', 'web', '2020-03-29 02:44:43', '2020-03-29 02:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_reported` tinyint(1) DEFAULT 0 COMMENT '1 - reported, 0 - not reported',
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=''active'' , 0=''deactive''',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_card_img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `greetings_notification` int(11) DEFAULT NULL,
  `doc_limit` int(11) NOT NULL DEFAULT 5,
  `user_docs` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_no`, `profile`, `api_token`, `is_reported`, `reason`, `password`, `status`, `remember_token`, `pan_no`, `pan_card_img`, `email_verified_at`, `created_at`, `updated_at`, `birthdate`, `device_token`, `greetings_notification`, `doc_limit`, `user_docs`) VALUES
(1, 'SuperAdmin', 'superadmin@gmail.com', NULL, NULL, NULL, 0, NULL, '$2y$10$jSBSAcVeHPDeEF5mFtcLGuL5EqVFaHdtAlI5fRp5Bc4.l3M8YMfN6', NULL, NULL, NULL, NULL, NULL, '2020-03-29 02:44:43', '2020-03-29 02:44:43', NULL, NULL, NULL, 5, NULL),
(2, 'Romik', 'romik@gmail.com', '123456789', '2.png', '1IL55ADNEYItAm8IDp4kQVAHZz7B49M7V4KHAXCLnubqt0E5WrnyJR1By4Hy', 0, NULL, '$2y$10$99u8S.lkdpVcNRhulZeWy.HCwbbSrTjS1eVDx2cNzVIoPpGltsjuK', 1, NULL, NULL, NULL, NULL, '2020-03-29 02:51:40', '2020-06-14 04:35:11', NULL, 'new token', NULL, 5, NULL),
(3, 'Prince', 'prince@gmail.coom', '1234567809', NULL, NULL, 0, NULL, '$2y$10$TTQ5goVfoDVA3Xgg1ZW5peVZnhKjXe5cKxZr3XY68ikpo9Qv6tz5.', 1, NULL, NULL, NULL, NULL, '2020-03-29 04:40:21', '2020-04-04 21:08:23', NULL, NULL, NULL, 5, NULL),
(10, 'Romik 2', 'romik2@gmail.com', '12345678909', NULL, 'LKzz6D12oVcyOwgjSB6Ntnax6j3KTGHXtvlNk5XTV4TZrtU21BAMc8VEAIMd', 0, NULL, '$2y$10$Sica4/K9XisAXIUqiQSmFOfjBNXb4cLyKDvz3bcE4zCQBRHaGg9Sy', 1, NULL, NULL, NULL, NULL, '2020-04-05 07:46:26', '2020-04-26 08:38:42', NULL, 'new token', NULL, 5, NULL),
(11, 'romik', 'romik3@gmail.com', '12345678902', '11.png', NULL, 0, NULL, '$2y$10$cKflxgZna.fzaqzLGK1l0eVNceM1v5/yH.BAgaWluG.ZfgrzLzTgO', 1, NULL, NULL, NULL, NULL, '2020-04-05 07:49:42', '2020-04-05 07:49:42', NULL, NULL, NULL, 5, NULL),
(12, 'romik', 'romik4@gmail.com', '12345678903', '12.png', NULL, 0, NULL, '$2y$10$5BMZW.aPGW0wNXHQnv7due981HXMzxUxrJUooxuU6XJdBVwqjs32K', 1, NULL, NULL, '12.png', NULL, '2020-04-05 08:10:05', '2020-04-05 08:10:05', NULL, NULL, NULL, 5, NULL),
(13, 'romik5', 'romik5@gmail.com', '12345678905', '13.jpg', '6rTG9omgbn0IPGDDDJauukVyueuG6eOSIfTRiwVphR2hZZyjG840G6BT0GZE', 0, NULL, '$2y$10$p0XBBQ.9hxy4Xx5U4POZwu.Vp5uItqRGsBC.BQQ2iTzqGku1FYqCC', 1, NULL, 'AQDPP82778', '13.jpg', NULL, '2020-04-05 21:15:44', '2020-04-10 03:16:45', NULL, NULL, NULL, 5, NULL),
(14, 'Romik', 'makavanaromik1214@gmail.com', '9913357614', NULL, 'V0TWi2YkmK2T031h56mqLnEUv37cI7pjWgmzzxNerNrNvqeGfaNrISBWpANS', 0, NULL, '$2y$10$8b36WxZMj0wtKakHJ9atO.hoLD/n5s.X/vQ4WZygXMbspffHh.vPW', 1, NULL, NULL, NULL, NULL, '2020-04-07 21:22:02', '2020-06-14 04:35:05', NULL, 'new token', NULL, 5, NULL),
(17, 'Romik', 'makavanaromik12145@gmail.com', '99913357614', NULL, 'JDm4C76jZv2O5RHeaEvOr96SdgzIUEmDIQfX7m4ZEq8BNOvAFzuO2WhVwxnG', 0, NULL, '$2y$10$zXs0O3lxbCdhcAblJS5GNOWSTLMC0IIHOfi6s8npXjzO6MvJ7xrIm', 1, NULL, 'AAECC6548C', NULL, NULL, '2020-04-25 22:58:04', '2020-06-15 21:19:47', NULL, 'new token', NULL, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE `user_document` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_fund_type_annual_return`
--

CREATE TABLE `user_fund_type_annual_return` (
  `id` bigint(20) NOT NULL,
  `fund_type_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `annual_return` float DEFAULT NULL,
  `annual_cached_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_fund_type_annual_return`
--

INSERT INTO `user_fund_type_annual_return` (`id`, `fund_type_id`, `user_id`, `annual_return`, `annual_cached_at`) VALUES
(1, 1, 2, 19.93, '2020-06-14 10:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_lamp_sum_investment`
--

CREATE TABLE `user_lamp_sum_investment` (
  `id` int(11) NOT NULL,
  `investment_through` enum('patel_consultancy','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `folio_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutual_fund_user_id` int(11) DEFAULT NULL COMMENT 'mutual_fund_user > id',
  `matual_fund_id` int(11) DEFAULT NULL,
  `invested_amount` double DEFAULT NULL,
  `nav_on_date` double DEFAULT NULL,
  `invested_at` datetime DEFAULT NULL,
  `units` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_lamp_sum_investment`
--

INSERT INTO `user_lamp_sum_investment` (`id`, `investment_through`, `user_id`, `folio_no`, `mutual_fund_user_id`, `matual_fund_id`, `invested_amount`, `nav_on_date`, `invested_at`, `units`, `created_at`, `deleted_at`) VALUES
(2, 'patel_consultancy', 3, '123456', 4, 1, 1200, 10, '2019-01-01 00:00:00', 120, '2020-04-04 02:37:22', '2020-04-05 03:38:55'),
(3, 'patel_consultancy', 2, '0001', 5, 1, 1000, 10, '2020-10-04 00:00:00', 100, '2020-04-10 08:42:50', NULL),
(4, 'patel_consultancy', 2, '123456', 2, 1, 10000, 10, '2019-01-01 00:00:00', 1000, '2020-04-10 08:45:40', NULL),
(5, 'patel_consultancy', 2, '123455', 6, 2, 12000, 10, '2019-01-01 00:00:00', 1200, '2020-04-14 18:19:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `target_amount` double DEFAULT NULL,
  `return_rate` double(4,2) DEFAULT 12.00,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `document` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `user_id`, `type`, `target_amount`, `return_rate`, `start_at`, `end_at`, `document`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2000000, 12.00, '2020-06-08 16:24:52', '2025-05-27 16:24:52', NULL, 1, '2020-06-05 18:30:00', '2020-06-05 18:30:00'),
(2, 2, 2, 1000000, 12.00, '2020-06-08 16:24:52', '2025-05-27 16:24:52', NULL, 1, '2020-06-05 18:30:00', '2020-06-05 18:30:00'),
(3, 2, 2, 1000000, 12.00, '2008-06-20 00:00:00', '2027-05-20 00:00:00', NULL, 1, '2020-07-01 03:31:27', '2020-07-01 03:31:27'),
(4, 3, 2, 1000000, 12.00, '2020-06-20 00:00:00', '2020-05-20 00:00:00', NULL, 1, '2020-07-01 03:31:50', '2020-07-01 03:32:31'),
(5, 14, 2, 30000, 11.00, '2016-07-13 00:00:00', '2030-07-01 00:00:00', NULL, 1, '2020-07-01 03:42:52', '2020-07-01 03:42:52'),
(6, 14, 2, 30000, 11.00, '2016-07-13 00:00:00', '2030-07-01 00:00:00', NULL, 1, '2020-07-01 03:42:53', '2020-07-01 03:42:53'),
(7, 17, 2, 500000, 12.00, '2020-07-03 00:00:00', '2035-07-03 00:00:00', NULL, 1, '2020-07-03 03:17:17', '2020-07-03 03:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_plan_sips`
--

CREATE TABLE `user_plan_sips` (
  `id` int(11) NOT NULL,
  `user_plan_id` int(11) DEFAULT NULL,
  `mutual_fund_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plan_sips`
--

INSERT INTO `user_plan_sips` (`id`, `user_plan_id`, `mutual_fund_user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2020-06-07 11:08:40', '2020-06-07 11:08:40'),
(2, 1, 6, '2020-06-07 11:08:40', '2020-06-07 11:08:40'),
(5, 6, 9, '2020-07-02 14:57:10', '2020-07-02 14:57:10'),
(10, 6, 9, '2020-07-03 01:28:41', '2020-07-03 01:28:41'),
(11, 7, 7, '2020-07-03 03:17:36', '2020-07-03 03:17:36'),
(12, 7, 8, '2020-07-03 03:18:27', '2020-07-03 03:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_register`
--

CREATE TABLE `user_register` (
  `user_id` int(11) NOT NULL,
  `access_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_varify` tinyint(1) DEFAULT 0 COMMENT '0 = no, 1 - yes',
  `varification_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_card_img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_status` tinyint(1) DEFAULT NULL COMMENT 'default null, 0 - declined, 1 - approved',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=''active'' , 0=''deactive''',
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sip_investement`
--

CREATE TABLE `user_sip_investement` (
  `id` int(11) NOT NULL,
  `investment_through` enum('patel_consultancy','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `folio_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutual_fund_user_id` int(11) DEFAULT NULL COMMENT 'mutual_fund_user > id',
  `matual_fund_id` int(11) DEFAULT NULL,
  `sip_amount` double DEFAULT NULL,
  `invested_amount` double DEFAULT NULL,
  `time_period` enum('weekly','fortnightly','monthly','quarterly') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `investment_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_amount` double DEFAULT NULL,
  `units` double DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=''active'' , 0=''deactive'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sip_investement`
--

INSERT INTO `user_sip_investement` (`id`, `investment_through`, `user_id`, `folio_no`, `mutual_fund_user_id`, `matual_fund_id`, `sip_amount`, `invested_amount`, `time_period`, `investment_for`, `target_amount`, `units`, `start_date`, `end_date`, `deleted_at`, `created_at`, `status`) VALUES
(1, 'patel_consultancy', 2, '123456', 2, 1, 500, 0, 'monthly', '10 years,0 months', NULL, 0, '2020-03-29 09:19:50', NULL, '2020-04-04 22:07:04', '2020-03-29 09:19:50', 1),
(2, 'patel_consultancy', 17, '123456', 7, 1, 500, 0, 'monthly', '1 years,0 months', NULL, NULL, '2020-04-26 10:31:06', NULL, NULL, '2020-04-26 10:31:06', 1),
(3, 'patel_consultancy', 17, '123457', 8, 2, 1000, 0, 'monthly', '1 years,0 months', NULL, NULL, '2020-04-23 00:00:00', NULL, NULL, '2020-04-26 10:35:32', 1),
(4, 'patel_consultancy', 14, '123458', 9, 1, 500, 500, 'monthly', '1 years,0 months', NULL, 25, '2020-04-10 00:00:00', NULL, NULL, '2020-04-26 10:36:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_user_fund`
--

CREATE TABLE `withdraw_user_fund` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `withdraw_type` enum('by_units','by_amount') DEFAULT NULL,
  `user_fund_id` bigint(20) DEFAULT NULL,
  `mutual_fund_id` bigint(20) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `units` float DEFAULT NULL,
  `nav_on_date` float DEFAULT NULL,
  `withdraw_date` date DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `greetings`
--
ALTER TABLE `greetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_category`
--
ALTER TABLE `insurance_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_company`
--
ALTER TABLE `insurance_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_fields`
--
ALTER TABLE `insurance_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_field_details`
--
ALTER TABLE `insurance_field_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_sub_category`
--
ALTER TABLE `insurance_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_slider`
--
ALTER TABLE `main_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `mutual_fund`
--
ALTER TABLE `mutual_fund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutual_fund_company`
--
ALTER TABLE `mutual_fund_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutual_fund_investment_hist`
--
ALTER TABLE `mutual_fund_investment_hist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutual_fund_nav_hist`
--
ALTER TABLE `mutual_fund_nav_hist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutual_fund_type`
--
ALTER TABLE `mutual_fund_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutual_fund_user`
--
ALTER TABLE `mutual_fund_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policy_master`
--
ALTER TABLE `policy_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premium_master`
--
ALTER TABLE `premium_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_document`
--
ALTER TABLE `user_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_fund_type_annual_return`
--
ALTER TABLE `user_fund_type_annual_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_lamp_sum_investment`
--
ALTER TABLE `user_lamp_sum_investment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_plan_sips`
--
ALTER TABLE `user_plan_sips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_register`
--
ALTER TABLE `user_register`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_sip_investement`
--
ALTER TABLE `user_sip_investement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_user_fund`
--
ALTER TABLE `withdraw_user_fund`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `greetings`
--
ALTER TABLE `greetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `insurance_category`
--
ALTER TABLE `insurance_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_company`
--
ALTER TABLE `insurance_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_fields`
--
ALTER TABLE `insurance_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `insurance_field_details`
--
ALTER TABLE `insurance_field_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `insurance_sub_category`
--
ALTER TABLE `insurance_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `main_slider`
--
ALTER TABLE `main_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `mutual_fund`
--
ALTER TABLE `mutual_fund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mutual_fund_company`
--
ALTER TABLE `mutual_fund_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mutual_fund_investment_hist`
--
ALTER TABLE `mutual_fund_investment_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mutual_fund_nav_hist`
--
ALTER TABLE `mutual_fund_nav_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mutual_fund_type`
--
ALTER TABLE `mutual_fund_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mutual_fund_user`
--
ALTER TABLE `mutual_fund_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_master`
--
ALTER TABLE `policy_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `premium_master`
--
ALTER TABLE `premium_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_document`
--
ALTER TABLE `user_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_fund_type_annual_return`
--
ALTER TABLE `user_fund_type_annual_return`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_lamp_sum_investment`
--
ALTER TABLE `user_lamp_sum_investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_plan_sips`
--
ALTER TABLE `user_plan_sips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_register`
--
ALTER TABLE `user_register`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sip_investement`
--
ALTER TABLE `user_sip_investement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `withdraw_user_fund`
--
ALTER TABLE `withdraw_user_fund`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
