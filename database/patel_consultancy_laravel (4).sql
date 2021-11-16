-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2020 at 01:51 PM
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
-- Database: `patel_consultancy_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `greetings`
--

CREATE TABLE `greetings` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` enum('yearly') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `greetings`
--

INSERT INTO `greetings` (`id`, `title`, `body`, `frequency`, `image`, `date`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Happy Diwali', 'happy Diwali to you and your family.', 'yearly', '1.jpg', '2020-05-10', '2020-05-10 11:21:53', '2020-05-10 11:24:20', NULL, 1),
(2, 'Happy Birthday', 'happy Birth Day\r\nmany many happy returns of the day\r\nMay God will fulfill your all wishes.', 'yearly', '2.jpg', '2020-05-10', '2020-05-10 11:22:44', '2020-05-10 11:22:45', NULL, 1);

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
(1, 'Insu Category1', 0, '2020-06-13 14:32:34', '2020-06-14 01:24:15', NULL),
(2, 'Category 2', 1, '2020-06-14 01:23:56', '2020-06-14 01:23:56', NULL);

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
(1, 'ICICI', '1.jpg', 1, '2020-06-13 04:22:32', '2020-06-13 04:22:32', NULL);

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
(1, 1, 'Sub category !', 1, '2020-06-14 07:09:42', '2020-06-14 07:40:12', NULL),
(2, 1, 'Sub Category 2', 0, '2020-06-14 08:00:32', '2020-06-14 08:19:54', NULL),
(3, 2, 'Sub Category  3', 1, '2020-06-14 08:01:54', '2020-06-14 08:01:54', NULL),
(4, 2, 'Category 3', 1, '2020-06-14 08:02:59', '2020-06-14 08:02:59', NULL),
(5, 2, 'Sub Category 56', 1, '2020-06-14 08:07:19', '2020-06-14 08:07:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_slider`
--

CREATE TABLE `main_slider` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_slider`
--

INSERT INTO `main_slider` (`id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, '1.jpg', 1, '2020-04-26 05:45:49', '2020-04-26 05:45:49'),
(2, '2.jpg', 1, '2020-04-26 06:00:28', '2020-04-28 01:10:17'),
(3, '3.jpg', 1, '2020-04-26 06:07:57', '2020-04-28 01:09:10'),
(4, '4.jpg', 1, '2020-05-10 11:03:11', '2020-05-10 11:03:11');

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
(22, '2020_04_21_031007_create_greetings_table', 2),
(23, '2020_04_25_140038_create_main_sliders_table', 3),
(24, '2020_06_07_082421_add_doc_and_doc_limit_to_user_table', 4),
(26, '2020_06_12_033717_create_user_documen_table', 5),
(27, '2020_06_12_030504_add_updated_at_to_fund_and_user_fund', 6),
(31, '2020_06_13_054703_create_insurance_companies_table', 7),
(32, '2020_06_13_054831_create_insurance_categories_table', 7),
(33, '2020_06_13_055111_create_insurance_sub_categories_table', 7),
(34, '2020_06_14_145323_create_insurance_fields_table', 8);

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
(2, 'App\\User', 3);

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
(1, 'ICICI Prudential', 1, 'direct', 'equity', 1, '23.00', NULL, '1300.00', NULL, NULL, 1, NULL, NULL),
(2, 'ICICI Prudential Corporate', 1, 'regular', 'equity', 2, '21.00', NULL, '1344.00', NULL, NULL, 1, NULL, NULL),
(3, 'Aditya Birla Sun Life Equity Fund', 2, 'direct', 'equity', 1, '34.00', NULL, '1300.00', NULL, '2020-05-10 15:57:22', 1, NULL, NULL),
(4, 'Aditya Birla Sun Life Savings Fund', 2, 'direct', 'hybrid', 2, '42.00', NULL, '1400.00', NULL, '2020-05-10 16:01:13', 1, NULL, NULL),
(5, 'Tata Hybrid Fund', 3, 'direct', 'hybrid', 1, '21.00', NULL, '1600.00', NULL, '2020-05-10 16:06:11', 1, NULL, NULL),
(6, 'Tata large Cap Fund', 3, 'direct', 'equity', 1, '24.00', NULL, '700.00', NULL, '2020-05-10 16:07:43', 1, NULL, NULL),
(7, 'HDFC Equity Fund', 4, 'regular', 'equity', 1, '659.00', NULL, '1500.00', NULL, '2020-05-10 16:20:45', 1, NULL, NULL),
(8, 'HDFC Mid Cap Opportunities Fund', 4, 'direct', 'equity', 2, '52.00', NULL, '1600.00', NULL, '2020-05-10 16:21:51', 1, NULL, NULL),
(9, 'SBI Magnum Multi Cap Fund', 5, 'direct', 'hybrid', 4, '231.00', NULL, '1700.00', NULL, '2020-05-10 16:23:41', 1, NULL, NULL),
(10, 'SBI Infrastructure Fund', 5, 'direct', 'equity', 1, '343.00', NULL, '1900.00', NULL, '2020-05-10 16:24:45', 1, NULL, NULL),
(11, 'Kotak Standard Multi Cap Fund', 6, 'regular', 'hybrid', 2, '423.00', NULL, '1400.00', NULL, '2020-05-10 16:28:12', 1, NULL, NULL),
(12, 'Kotak Emerging Equity', 6, 'direct', 'equity', 2, '232.00', NULL, '1200.00', NULL, '2020-05-10 16:29:43', 1, NULL, NULL);

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
(1, 'ICICI', 'other', 'Birla', '1.png', '2020-04-21 20:39:31', 1, NULL),
(2, 'Aditya Birla', 'other', 'Birla', '2.jpg', '2020-04-21 20:43:10', 1, NULL),
(3, 'Tata', NULL, NULL, '3.png', '2020-05-10 15:49:52', 1, NULL),
(4, 'HDFC', NULL, NULL, '4.png', '2020-05-10 15:50:29', 1, NULL),
(5, 'SBI', NULL, NULL, '5.jpg', '2020-05-10 15:50:49', 1, NULL),
(6, 'Kotak Mahindra', NULL, NULL, '6.png', '2020-05-10 15:51:09', 1, NULL),
(7, 'Reliance', NULL, NULL, '7.png', '2020-05-10 16:37:53', 1, NULL);

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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_investment_hist`
--

INSERT INTO `mutual_fund_investment_hist` (`id`, `investement_type`, `user_id`, `refrence_id`, `mutual_fund_user_id`, `matual_fund_id`, `investment_amount`, `purchased_units`, `nav_on_date`, `invested_date`, `created_at`, `remarks`, `deleted_at`) VALUES
(1, 1, 3, 1, 1, 1, 1300, 56.52173913043478, 23, '2020-05-10', '2020-05-10 17:03:00', 'First Installment', NULL),
(2, 0, 3, 1, 2, 10, 50000, 80.25682182985554, 623, '2020-05-10', '2020-05-10 17:04:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_nav_hist`
--

CREATE TABLE `mutual_fund_nav_hist` (
  `id` int(11) NOT NULL,
  `mutual_fund_id` int(11) DEFAULT NULL,
  `nav` double DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'equity', 'Large Cap', 'This is large Cap Fund', '2020-04-19 11:21:03', 1, NULL),
(2, 'hybrid', 'Mid Cap', 'Mid cap Fund', '2020-04-19 13:23:11', 1, NULL),
(3, 'equity', 'Small Cap', 'Small Cap Fund', '2020-05-10 15:43:51', 1, NULL),
(4, 'hybrid', 'Multi cap', 'Multi Cap Fund', '2020-05-10 15:44:32', 1, NULL);

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
(1, NULL, 3, '9878981', 1, '1300.00', 56.52173913043478, 1300, '2020-05-10', 0, '2020-05-10 17:02:16', NULL, 1, NULL, NULL, NULL, NULL),
(2, NULL, 3, '198989', 10, NULL, 80.25682182985554, 50000, '2020-05-10', -44.9438202247191, '2020-05-10 17:04:36', 0, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'superadmin', 'web', '2020-04-18 02:44:56', '2020-04-18 02:44:56'),
(2, 'client', 'web', '2020-04-18 02:44:56', '2020-04-18 02:44:56');

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
  `user_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`user_docs`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_no`, `profile`, `api_token`, `is_reported`, `reason`, `password`, `status`, `remember_token`, `pan_no`, `pan_card_img`, `email_verified_at`, `created_at`, `updated_at`, `birthdate`, `device_token`, `greetings_notification`, `doc_limit`, `user_docs`) VALUES
(1, 'SuperAdmin', 'superadmin@gmail.com', NULL, NULL, NULL, 0, NULL, '$2y$10$RRN95Y3J43kRRlVtVo9ENO5aiTbdJUPOJJppJJ7RydMpHojVjXIau', 1, NULL, NULL, NULL, NULL, '2020-04-18 02:44:57', '2020-04-18 02:44:57', NULL, NULL, NULL, 5, ''),
(2, 'Milan Pithadiya', 'milanmsp7@gmail.com', '9824795495', '2.jpg', '123', 0, NULL, '$2y$10$Xkso7Dg8LsaJ8h0xw7MtzuY7biHJ9czYly3vhzpthfUZuYsQlhwzK', 1, NULL, 'apk12zkad', '2.jpg', NULL, '2020-04-18 04:23:49', '2020-04-18 04:23:49', NULL, NULL, NULL, 5, ''),
(3, 'Romik', 'makavanaromik12145@gmail.com', '9824795491', '3.jpg', 'pICnmhN7EgTcLxZiGxkhFFVmarBgTOWuCCXVgpqX091jVs26GWVuyvvsvJBJ', 0, NULL, '$2y$10$ag6Uw6mRAW6.epkdQCvF9uyTTcxRxJhXacOVbdUKhNFBMDLgtLGnq', 1, NULL, 'jkjhj', NULL, '2020-05-03 17:24:34', '2020-05-03 11:54:34', '2020-06-11 22:01:36', NULL, '123456', NULL, 4, '{\"0\":{\"card\":\"3.jpg\"},\"card\":\"3.jpg\"}');

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE `user_document` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_document`
--

INSERT INTO `user_document` (`id`, `user_id`, `title`, `document`, `created_at`, `updated_at`) VALUES
(5, 3, 'card', '3-card3.txt', '2020-06-11 22:58:35', '2020-06-11 23:04:25'),
(6, 3, 'aadhar card', '3-aadhar-card.jpg', '2020-06-14 00:22:49', '2020-06-14 00:22:49');

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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_lamp_sum_investment`
--

INSERT INTO `user_lamp_sum_investment` (`id`, `investment_through`, `user_id`, `folio_no`, `mutual_fund_user_id`, `matual_fund_id`, `invested_amount`, `nav_on_date`, `invested_at`, `units`, `created_at`, `deleted_at`) VALUES
(1, 'patel_consultancy', 3, '198989', 2, 10, 50000, 623, '2020-05-10 00:00:00', 80.25682182985554, '2020-05-10 17:04:36', NULL);

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
(1, 'patel_consultancy', 3, '9878981', 1, 1, 1300, 1300, 'monthly', '4 years,3 months', NULL, 56.52173913043478, '2020-05-10 00:00:00', NULL, NULL, '2020-05-10 17:02:16', 1);

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
-- Indexes for table `user_lamp_sum_investment`
--
ALTER TABLE `user_lamp_sum_investment`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `greetings`
--
ALTER TABLE `greetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_category`
--
ALTER TABLE `insurance_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_company`
--
ALTER TABLE `insurance_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_fields`
--
ALTER TABLE `insurance_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_sub_category`
--
ALTER TABLE `insurance_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `main_slider`
--
ALTER TABLE `main_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `mutual_fund`
--
ALTER TABLE `mutual_fund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mutual_fund_company`
--
ALTER TABLE `mutual_fund_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mutual_fund_investment_hist`
--
ALTER TABLE `mutual_fund_investment_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mutual_fund_nav_hist`
--
ALTER TABLE `mutual_fund_nav_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mutual_fund_type`
--
ALTER TABLE `mutual_fund_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mutual_fund_user`
--
ALTER TABLE `mutual_fund_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_document`
--
ALTER TABLE `user_document`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_lamp_sum_investment`
--
ALTER TABLE `user_lamp_sum_investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_register`
--
ALTER TABLE `user_register`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sip_investement`
--
ALTER TABLE `user_sip_investement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
