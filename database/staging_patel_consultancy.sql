-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 11, 2020 at 05:59 AM
-- Server version: 5.6.47-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `staging_patel_consultancy`
--

-- --------------------------------------------------------

--
-- Table structure for table `greetings`
--

CREATE TABLE `greetings` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
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
(1, 'Happy Diwali', 'happy Diwali to you and your family.', 'yearly', '1.jpg', '2020-10-05', '2020-05-10 11:21:53', '2020-07-05 21:18:45', NULL, 1),
(2, 'Happy Birthday', 'happy Birth Day\r\nmany many happy returns of the day\r\nMay God will fulfill your all wishes.', 'yearly', '2.jpg', '2020-05-10', '2020-05-10 11:22:44', '2020-06-07 21:58:34', '2020-06-07 21:58:34', 1),
(3, 'Happy Makar Sankranti.', 'Wish You Happy Makar Sankranti..!!', 'yearly', '3.png', '2020-01-14', '2020-05-10 23:52:31', '2020-05-10 23:52:31', NULL, 1),
(4, 'Happy birthday', 'Wish you Happy birthday', 'yearly', '', '2020-06-07', '2020-06-07 21:57:39', '2020-06-21 22:17:53', '2020-06-21 22:17:53', 1),
(5, 'Demo', 'Good', 'yearly', '5.png', '2020-07-05', '2020-07-05 22:55:43', '2020-07-05 22:55:43', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `greetings_hist`
--

CREATE TABLE `greetings_hist` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` text,
  `device_token` text,
  `send_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `greetings_hist`
--

INSERT INTO `greetings_hist` (`id`, `user_id`, `type`, `date`, `details`, `device_token`, `send_at`) VALUES
(1, 2, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'dlKfrqtmSyG_sFPwW9_5n7:APA91bFeoWDgtvWKqlz8DqSpmeSwtDKB7O0v1Ycq9qBQJX0t40BjnJwBm7kLpDr7cUI940oCtL_hpFtLxsiA-hNVO3YhEAL76csl8dg8OeAkBxk93kLjLPQaS20S3gxVshhnBPCoCJNX', NULL),
(2, 3, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '123456', NULL),
(3, 4, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(4, 6, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'fflGzBPvSX-Onwz36ykvYz:APA91bGh3WErn3dNefZ0Aulx5Y7qx1RX-v-UtbA1IWjDyoc3HkyL2mz6rdjfJ4gdsLtyObNe_Tcf4iN6xWvbwfiaFK07GTm3zJXm4RpXaHyoTjFG5jE2V1YvE294-bFXx4EgpoX2bRRr', NULL),
(5, 9, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(6, 10, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(7, 11, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'cJsBoq3fSoOvaOz4j91XdE:APA91bGlOlXvBHeYk2A8UL-lAeFlpsAIZEAaKNl96e4bATuD2nznqI4pyTXYYTds9BGoYPDWfn7ymJVTW3qoweGkjVowL_rUhgaYKyvRsiZaD1SemZw49Vz_Prj_4A4RlJKT-Bsk3aUE', NULL),
(8, 12, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(9, 4, 'birthdate', '2020-07-05', '{\"title\":null,\"body\":null,\"image\":{}}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(10, 2, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'dlKfrqtmSyG_sFPwW9_5n7:APA91bFeoWDgtvWKqlz8DqSpmeSwtDKB7O0v1Ycq9qBQJX0t40BjnJwBm7kLpDr7cUI940oCtL_hpFtLxsiA-hNVO3YhEAL76csl8dg8OeAkBxk93kLjLPQaS20S3gxVshhnBPCoCJNX', NULL),
(11, 3, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '123456', NULL),
(12, 4, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(13, 6, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'fflGzBPvSX-Onwz36ykvYz:APA91bGh3WErn3dNefZ0Aulx5Y7qx1RX-v-UtbA1IWjDyoc3HkyL2mz6rdjfJ4gdsLtyObNe_Tcf4iN6xWvbwfiaFK07GTm3zJXm4RpXaHyoTjFG5jE2V1YvE294-bFXx4EgpoX2bRRr', NULL),
(14, 9, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(15, 10, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(16, 11, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'cJsBoq3fSoOvaOz4j91XdE:APA91bGlOlXvBHeYk2A8UL-lAeFlpsAIZEAaKNl96e4bATuD2nznqI4pyTXYYTds9BGoYPDWfn7ymJVTW3qoweGkjVowL_rUhgaYKyvRsiZaD1SemZw49Vz_Prj_4A4RlJKT-Bsk3aUE', NULL),
(17, 12, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(18, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.png\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(19, 2, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'dlKfrqtmSyG_sFPwW9_5n7:APA91bFeoWDgtvWKqlz8DqSpmeSwtDKB7O0v1Ycq9qBQJX0t40BjnJwBm7kLpDr7cUI940oCtL_hpFtLxsiA-hNVO3YhEAL76csl8dg8OeAkBxk93kLjLPQaS20S3gxVshhnBPCoCJNX', NULL),
(20, 3, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '123456', NULL),
(21, 4, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(22, 6, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'fflGzBPvSX-Onwz36ykvYz:APA91bGh3WErn3dNefZ0Aulx5Y7qx1RX-v-UtbA1IWjDyoc3HkyL2mz6rdjfJ4gdsLtyObNe_Tcf4iN6xWvbwfiaFK07GTm3zJXm4RpXaHyoTjFG5jE2V1YvE294-bFXx4EgpoX2bRRr', NULL),
(23, 9, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(24, 10, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(25, 11, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'cJsBoq3fSoOvaOz4j91XdE:APA91bGlOlXvBHeYk2A8UL-lAeFlpsAIZEAaKNl96e4bATuD2nznqI4pyTXYYTds9BGoYPDWfn7ymJVTW3qoweGkjVowL_rUhgaYKyvRsiZaD1SemZw49Vz_Prj_4A4RlJKT-Bsk3aUE', NULL),
(26, 12, 'status', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', '', NULL),
(27, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.png\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(28, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.png\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(29, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.png\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(30, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.png\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(31, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.png\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(32, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.jpg\"}', 'c0CMpRtoT96H85-fS3Lztl:APA91bErMLfEFXJlAnNAT1_hVgXzo0UfLtA2ehqgll_TmEUNe03EgHoyrNOdhYb_ujVe4S6FiWDkdk8oTKbhrWOhe4JovgnnkNsMJSFyK7o-nt6R9jE93JGhXyam1Ai0B6xHnUMnLWDn', NULL),
(33, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.jpg\"}', 'dYcBJrNKS1Ckx2T2AZH_1_:APA91bFy7CDc3lStfKHzOb9iv-Dn3Sp4g53l3SkoFJsAZ2OnRgnuAiyfcE4M7EbT2WUt0tl9zERRZ_jKLVWYWyuC9AtTyvx1cQFFVdOeiFqBZolAI_-ZmvAotXw3HvsROlelXY7Dq4Gb', NULL),
(34, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\Happy-Birthday.jpg\"}', 'dYcBJrNKS1Ckx2T2AZH_1_:APA91bFy7CDc3lStfKHzOb9iv-Dn3Sp4g53l3SkoFJsAZ2OnRgnuAiyfcE4M7EbT2WUt0tl9zERRZ_jKLVWYWyuC9AtTyvx1cQFFVdOeiFqBZolAI_-ZmvAotXw3HvsROlelXY7Dq4Gb', NULL),
(35, 4, 'static', '2020-07-05', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'dYcBJrNKS1Ckx2T2AZH_1_:APA91bFy7CDc3lStfKHzOb9iv-Dn3Sp4g53l3SkoFJsAZ2OnRgnuAiyfcE4M7EbT2WUt0tl9zERRZ_jKLVWYWyuC9AtTyvx1cQFFVdOeiFqBZolAI_-ZmvAotXw3HvsROlelXY7Dq4Gb', NULL),
(36, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\happybirthday.jpg\"}', 'dYcBJrNKS1Ckx2T2AZH_1_:APA91bFy7CDc3lStfKHzOb9iv-Dn3Sp4g53l3SkoFJsAZ2OnRgnuAiyfcE4M7EbT2WUt0tl9zERRZ_jKLVWYWyuC9AtTyvx1cQFFVdOeiFqBZolAI_-ZmvAotXw3HvsROlelXY7Dq4Gb', NULL),
(37, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\happybirthday.jpg\"}', 'dYcBJrNKS1Ckx2T2AZH_1_:APA91bFy7CDc3lStfKHzOb9iv-Dn3Sp4g53l3SkoFJsAZ2OnRgnuAiyfcE4M7EbT2WUt0tl9zERRZ_jKLVWYWyuC9AtTyvx1cQFFVdOeiFqBZolAI_-ZmvAotXw3HvsROlelXY7Dq4Gb', NULL),
(38, 4, 'birthdate', '2020-07-05', '{\"title\":\"Many many happy return of day\",\"body\":\"Happy Birthdate\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/images\\\\happybirthday.jpg\"}', 'dYcBJrNKS1Ckx2T2AZH_1_:APA91bFy7CDc3lStfKHzOb9iv-Dn3Sp4g53l3SkoFJsAZ2OnRgnuAiyfcE4M7EbT2WUt0tl9zERRZ_jKLVWYWyuC9AtTyvx1cQFFVdOeiFqBZolAI_-ZmvAotXw3HvsROlelXY7Dq4Gb', NULL),
(39, 6, 'static', '2020-07-05', '{\"title\":\"Happy Makar Sankranti.\",\"body\":\"Wish You Happy Makar Sankranti..!!\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/3.png\"}', 'ci1zcPKHSrqqYeC59UmP5P:APA91bGUJthecDXm5DkMKYs3iD03DWQY_TKO6Z353r9iaOCKNJogNlmFBjBvci-e5XRPHmjyWViZ7SXjD49BmHpNrQuzBRxUpYu9Il0aZuIDM9rx8cUYYWcpWNQ86lPFxO03qFNkTWMl', NULL),
(40, 10, 'static', '2020-07-06', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'cTtUaGbiS1mwTwkmif1Z36:APA91bGmUepDmaj77I8vnYOmo6zv7EJDJRA1AkEy9vDx8c1hv54if5wIhf4bKMpWESzkcEUhKM53SwvPzasHD5rOy3Q7OdFUFMbv_KjCa_usUVzcdzxBFBxZlq7em_Q9WMpy2-homKoR', NULL),
(41, 4, 'static', '2020-07-10', '{\"title\":\"Demo\",\"body\":\"Good\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/5.png\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(42, 3, 'static', '2020-07-10', '{\"title\":\"Demo\",\"body\":\"Good\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/5.png\"}', '123456', NULL),
(43, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(44, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(45, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(46, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(47, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(48, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(49, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(50, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(51, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(52, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(53, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(54, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_category`
--

CREATE TABLE `insurance_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_category`
--

INSERT INTO `insurance_category` (`id`, `name`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 'Life Insurance', 1, '2020-06-21 06:22:20', '2020-06-21 06:22:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_company`
--

CREATE TABLE `insurance_company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_company`
--

INSERT INTO `insurance_company` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 'LIC - Life Insurance Corporation of India', '1.png', 1, '2020-06-21 06:25:10', '2020-06-21 06:25:10', NULL),
(2, 'Kotak Mahindra Life Insurance Company Ltd', '2.png', 1, '2020-06-21 06:26:17', '2020-06-21 06:26:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_fields`
--

CREATE TABLE `insurance_fields` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_fields`
--

INSERT INTO `insurance_fields` (`id`, `name`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 'Car Insurance', 1, '2020-06-23 12:24:10', '2020-06-23 12:24:10', NULL),
(2, 'Life Insurance', 1, '2020-06-23 12:24:29', '2020-06-23 12:24:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_field_details`
--

CREATE TABLE `insurance_field_details` (
  `id` int(11) NOT NULL,
  `insurance_field_id` int(11) DEFAULT NULL,
  `fieldname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
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
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_sub_category`
--

INSERT INTO `insurance_sub_category` (`id`, `category_id`, `name`, `status`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 1, 'Term life Insurance', 1, '2020-06-21 06:22:31', '2020-06-21 06:22:31', NULL),
(2, 1, 'Whole life Insurance', 1, '2020-06-21 06:22:37', '2020-06-21 06:22:37', NULL),
(3, 1, 'Universal life Insurance', 1, '2020-06-21 06:22:44', '2020-06-21 06:22:44', NULL),
(4, 1, 'Variable life Insurance', 1, '2020-06-21 06:22:50', '2020-06-21 06:22:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_slider`
--

CREATE TABLE `main_slider` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_slider`
--

INSERT INTO `main_slider` (`id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, '1.jpg', 1, '2020-04-26 05:45:49', '2020-04-26 05:45:49'),
(2, '2.jpg', 1, '2020-04-26 06:00:28', '2020-04-28 01:10:17'),
(4, '4.jpg', 0, '2020-05-10 11:03:11', '2020-06-21 22:48:16');

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
(23, '2020_04_25_140038_create_main_sliders_table', 3);

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
(2, 'App\\User', 4),
(2, 'App\\User', 6),
(2, 'App\\User', 9),
(2, 'App\\User', 10),
(2, 'App\\User', 11),
(2, 'App\\User', 12);

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
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
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
(12, 'Kotak Emerging Equity', 6, 'direct', 'equity', 2, '230.00', NULL, '1200.00', NULL, '2020-05-10 16:29:43', 1, NULL, NULL),
(13, 'Aditya Birla Mutual Fund', 2, 'direct', 'equity', 1, '200.00', NULL, '2000.00', NULL, '2020-05-11 05:32:42', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_company`
--

CREATE TABLE `mutual_fund_company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Asset management company',
  `sponsors` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
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
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_investment_hist`
--

INSERT INTO `mutual_fund_investment_hist` (`id`, `investement_type`, `user_id`, `refrence_id`, `mutual_fund_user_id`, `matual_fund_id`, `investment_amount`, `purchased_units`, `nav_on_date`, `invested_date`, `created_at`, `remarks`, `deleted_at`) VALUES
(1, 1, 3, 1, 1, 1, 1300, 56.52173913043478, 23, '2020-05-10', '2020-05-10 17:03:00', 'First Installment', NULL),
(2, 0, 3, 1, 2, 10, 50000, 80.25682182985554, 623, '2020-05-10', '2020-05-10 17:04:36', NULL, NULL),
(3, 1, 4, 2, 3, 3, 1500, 75, 20, '2019-05-11', '2020-05-11 03:08:46', NULL, NULL),
(4, 0, 4, 2, 3, 3, 20000, 1000, 20, '2019-05-11', '2020-05-11 03:10:04', NULL, NULL),
(5, 1, 4, 2, 3, 3, 1500, 75, 20, '2019-06-11', '2020-05-11 03:11:01', 'Great..', NULL),
(6, 1, 4, 3, 4, 7, 1500, 3, 500, '2019-05-11', '2020-05-11 03:16:04', 'Great.. !!', NULL),
(7, 1, 4, 4, 5, 12, 1500, 7.5, 200, '2019-05-11', '2020-05-11 03:18:51', NULL, NULL),
(8, 1, 6, 5, 6, 3, 1500, 50, 30, '2019-05-11', '2020-05-11 05:37:11', 'Great..', NULL),
(9, 1, 6, 5, 6, 3, 1500, 50, 30, '2019-06-11', '2020-05-11 05:38:13', 'Great', NULL),
(10, 0, 6, 3, 6, 3, 20000, 1000, 20, '2019-05-11', '2020-05-11 05:40:27', NULL, NULL),
(11, 0, 4, 4, 7, 13, 12000, 600, 20, '2020-05-27', '2020-05-24 04:48:51', NULL, NULL),
(12, 1, 4, 2, 3, 3, 1500, 44.11764705882353, 34, '2020-06-21', '2020-06-21 15:33:23', 'Care', NULL);

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
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_type`
--

INSERT INTO `mutual_fund_type` (`id`, `main_type`, `name`, `description`, `created_at`, `status`, `is_trashed`) VALUES
(1, 'equity', 'Large Cap', 'This is large Cap Fund', '2020-04-19 11:21:03', 1, NULL),
(2, 'hybrid', 'Mid Cap', 'Mid cap Fund', '2020-04-19 13:23:11', 1, NULL),
(3, 'equity', 'Small Cap', 'Small Cap Fund', '2020-05-10 15:43:51', 1, NULL),
(4, 'hybrid', 'Multi cap', 'Multi Cap Fund', '2020-05-10 15:44:32', 1, NULL),
(5, 'equity', 'Thematic', 'Thematic', '2020-05-11 07:23:26', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutual_fund_user`
--

CREATE TABLE `mutual_fund_user` (
  `id` int(11) NOT NULL,
  `investment_through` enum('patel_consultancy','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'patel_consultancy, other',
  `user_plan_id` bigint(20) DEFAULT NULL,
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
  `annual_cached_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_user`
--

INSERT INTO `mutual_fund_user` (`id`, `investment_through`, `user_plan_id`, `user_id`, `folio_no`, `matual_fund_id`, `sip_amount`, `total_units`, `invested_amount`, `start_date`, `absolute_return`, `created_at`, `annual_return`, `status`, `is_trashed`, `end_date`, `annual_cached_at`, `updated_at`) VALUES
(1, NULL, NULL, 3, '9878981', 1, '1300.00', 56.52173913043478, 1300, '2020-05-10', 0, '2020-05-10 17:02:16', NULL, 1, NULL, NULL, NULL, NULL),
(2, NULL, NULL, 3, '198989', 10, NULL, 80.25682182985554, 50000, '2020-05-10', -44.9438202247191, '2020-05-10 17:04:36', 0, 1, NULL, NULL, '2020-06-21 15:36:46', '2020-06-21 15:36:46'),
(3, NULL, NULL, 4, '123456', 3, '4500.00', 1194.1176470588234, 24500, '2020-05-11', 65.71428571428571, '2020-05-11 03:08:10', 61.5, 1, NULL, NULL, '2020-06-21 15:33:23', '2020-06-21 15:33:23'),
(4, NULL, NULL, 4, '123457', 7, '1500.00', 3, 1500, '2020-05-11', 31.8, '2020-05-11 03:15:32', 28.9, 1, NULL, NULL, '2020-06-12 06:13:00', '2020-06-12 06:13:00'),
(5, NULL, NULL, 4, '123458', 12, '1500.00', 7.5, 1500, '2020-05-11', 16, '2020-05-11 03:18:26', 13.71, 1, NULL, NULL, '2020-06-12 06:13:00', '2020-06-12 06:13:00'),
(6, NULL, NULL, 6, '1234569', 3, '3000.00', 1100, 23000, '2020-05-11', 62.60869565217392, '2020-05-11 05:31:48', 52.72, 1, NULL, NULL, '2020-07-05 15:43:35', '2020-07-05 15:43:35'),
(7, NULL, NULL, 4, '1234510', 13, NULL, 600, 12000, '2020-05-24', 900, '2020-05-24 04:48:51', 0, 1, NULL, NULL, '2020-06-14 10:17:46', '2020-06-14 10:17:46');

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
('milanmsp7@gmail.com', '$2y$10$NeEs15ulv4DLdwdYm2fMWekE8jm3miLDWHSAc0UnAnW0l0Kcnr82a', '2020-05-31 18:16:53'),
('sd.51098@gmail.com', '$2y$10$xxbUZ/AfiCfzzwXyK5ZQ6.Gh08ZbUhIsEEzgEcF8BbM5zWYdqvfn.', '2020-06-01 13:32:25'),
('makavanaromik1214@gmail.com', '$2y$10$jrJ11kn8RZ93RCMN8v7pmOjtBEO1YmbcQmEwempvqPayrHaGDNcUK', '2020-06-29 11:24:34');

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
-- Table structure for table `policy_benefits`
--

CREATE TABLE `policy_benefits` (
  `id` int(11) NOT NULL,
  `policy_id` bigint(20) DEFAULT NULL,
  `notes` text,
  `amount` float DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policy_master`
--

CREATE TABLE `policy_master` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `policy_no` bigint(20) DEFAULT NULL,
  `plan_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `sub_category_id` bigint(20) DEFAULT NULL,
  `sum_assured` double DEFAULT NULL,
  `premium_amount` bigint(20) DEFAULT NULL,
  `permium_paying_term` bigint(20) DEFAULT NULL COMMENT 'in year',
  `last_premium_date` date DEFAULT NULL,
  `premium_mode` text COLLATE utf8mb4_unicode_ci COMMENT '0-Fortnight , 1-monthly , 2-quatarly',
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `other_fields` text COLLATE utf8mb4_unicode_ci,
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `insurance_field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policy_master`
--

INSERT INTO `policy_master` (`id`, `user_id`, `policy_no`, `plan_name`, `issue_date`, `company_id`, `category_id`, `sub_category_id`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `other_fields`, `is_trashed`, `created_at`, `updated_at`, `insurance_field_id`) VALUES
(1, 2, 64913498451, 'Kotak Term Plan', '2020-06-01', 2, 1, 1, 130000, 1000, NULL, '2030-06-01', 'monthly', 10, '[{\"car_model\":\"XUV\"},{\"car_company\":\"Honda\"}]', NULL, '2020-06-21 06:32:54', '2020-06-21 06:32:54', 1),
(2, 6, 123, 'Cyz', '2020-06-29', 1, 1, 3, 2500000, 1536, NULL, '2040-06-29', 'monthly', 20, '[{\"name\":\"Dharmesh\"},{\"person_birthdate\":\"23-09-1978\"},{\"maturity_date\":\"05-09-2030\"}]', NULL, '2020-06-29 12:08:31', '2020-06-29 12:09:34', 2),
(3, 4, 20, 'Kotak Life Care', '2020-07-01', 2, 1, 1, 150000, 1500, NULL, '2023-07-01', 'fortnightly', 3, '[{\"name\":\"Deep Sinroja\"},{\"person_birthdate\":\"05 \\/ 10 \\/ 1998\"},{\"maturity_date\":\"05 \\/ 10 \\/ 2045\"}]', NULL, '2020-07-01 23:22:12', '2020-07-01 23:23:29', 2),
(4, 4, 123456789, 'LIC', '2020-06-30', 1, 1, 1, 1568990, 15870, NULL, '2026-06-30', 'monthly', 6, '[{\"name\":\"Axis\"},{\"person_birthdate\":\"05 \\/ 10 \\/ 1998\"},{\"maturity_date\":\"30 \\/ 06 \\/ 2096\"}]', NULL, '2020-07-02 01:22:47', '2020-07-02 01:22:47', 2),
(5, 4, 6, 'Kotak Life Care', '2020-06-30', 2, 1, 3, 500000, 6000, NULL, '2035-06-30', 'quarterly', 15, '[{\"car_model\":\"Civic\"},{\"car_company\":\"Honda\"}]', NULL, '2020-07-02 01:32:43', '2020-07-02 01:32:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `premium_master`
--

CREATE TABLE `premium_master` (
  `id` bigint(20) NOT NULL,
  `policy_id` bigint(20) DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `premium_date` date DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_trashed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `premium_master`
--

INSERT INTO `premium_master` (`id`, `policy_id`, `amount`, `premium_date`, `paid_at`, `created_at`, `updated_at`, `is_trashed`) VALUES
(1, 1, 1000, '2020-06-01', NULL, '2020-06-21 06:34:40', '2020-06-21 06:34:40', NULL);

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
  `is_reported` tinyint(1) DEFAULT '0' COMMENT '1 - reported, 0 - not reported',
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
  `device_token` text COLLATE utf8mb4_unicode_ci,
  `greetings_notification` int(11) DEFAULT NULL,
  `doc_limit` int(11) NOT NULL DEFAULT '5',
  `user_docs` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_no`, `profile`, `api_token`, `is_reported`, `reason`, `password`, `status`, `remember_token`, `pan_no`, `pan_card_img`, `email_verified_at`, `created_at`, `updated_at`, `birthdate`, `device_token`, `greetings_notification`, `doc_limit`, `user_docs`) VALUES
(1, 'SuperAdmin', 'superadmin@gmail.com', NULL, NULL, NULL, 0, NULL, '$2y$10$RRN95Y3J43kRRlVtVo9ENO5aiTbdJUPOJJppJJ7RydMpHojVjXIau', 1, NULL, NULL, NULL, NULL, '2020-04-18 02:44:57', '2020-04-18 02:44:57', NULL, NULL, NULL, 5, ''),
(2, 'Milan', 'milanmsp7@gmail.com', '+919824795495', '2.jpg', 'moOQhzFP8cXNpkR2tOhlKVykXVZj2QnuqWc6opLTZ9CpAtOf8rCgpd9sJGpz', 0, NULL, '$2y$10$XyVoWK7dYRK23gvQ3MasleiF7k2GmlKy6nXjDcEdEY9vUj87/PwUW', 1, NULL, 'AJK12758', NULL, NULL, '2020-06-01 00:10:08', '2020-07-07 13:09:24', NULL, 'eZG9UNaUQAaYT7f244wleu:APA91bHhYNwtTYwO6d-MGZv3MNHRKN1liq8X313h6o4B3adiyJnHdOUQ_XmDBPXl3tz3URlFy9lA6q3P6L0KOcDYlG4vlLzeS-5yea9JY-Bey79LAb8COIFwpLVPHPb3SzMTQ0a3KFPs', NULL, 25, ''),
(3, 'Romik', 'makavanaromik12145@gmail.com', '9824795491', '3.jpg', 'lAmdsnzLSXdICWFMcWhS3IlabwYPAXyvkLGmPmlAFrezV2RXMm615ACLD3ON', 0, NULL, '$2y$10$ag6Uw6mRAW6.epkdQCvF9uyTTcxRxJhXacOVbdUKhNFBMDLgtLGnq', 1, NULL, NULL, NULL, '2020-05-03 17:24:34', '2020-05-03 11:54:34', '2020-05-06 01:04:00', NULL, '123456', NULL, 5, ''),
(4, 'Romik Makavana', 'makavanaromik1214@gmail.com', '+919913327614', '4.jpg', '', 0, NULL, '$2y$10$mkpVdWt9wiVCEQibv2VsPuW9BBN/K1yV2NKxfs7tZizpsdXTuwSXy', 1, NULL, NULL, '4.png', NULL, '2020-05-10 21:33:55', '2020-07-11 11:35:11', '2019-07-05', '', NULL, 5, ''),
(6, 'Dharmesh', 'dharmesh237@yahoo.co.in', '+919824837585', NULL, 'jwlU5rUSHf0VGBFbAeVa6IUZ1FxorkvdIlzS2HX09JbdPacl5x0fYkuS6sBr', 0, NULL, '$2y$10$tK7fX0wOKeuDbL5xhmIYZuZZtHimBJ0Q8fNHsmY6/wymwfYzZzHby', 1, NULL, '123456789', '6.jpg', NULL, '2020-05-10 23:56:56', '2020-07-05 22:42:17', NULL, 'ci1zcPKHSrqqYeC59UmP5P:APA91bGUJthecDXm5DkMKYs3iD03DWQY_TKO6Z353r9iaOCKNJogNlmFBjBvci-e5XRPHmjyWViZ7SXjD49BmHpNrQuzBRxUpYu9Il0aZuIDM9rx8cUYYWcpWNQ86lPFxO03qFNkTWMl', NULL, 5, ''),
(9, 'Deep', 'sd.51098@gmail.com', '8320578700', '9.jpg', '', 0, NULL, '$2y$10$cNUN3QLDhBJIuQPaIlS/AeUpdIRPDkirK/gpRxWwGZJLyC2.Vbp9u', 1, NULL, 'asdas54a6sd', NULL, NULL, '2020-05-28 18:38:38', '2020-07-09 19:32:17', NULL, '', NULL, 5, ''),
(10, 'Romik Makavana', 'makavanaromik121@gmail.com', '+919913357615', '10.jpg', 'rT02dH4cQx9O0VGdcUIeSiRBMBTrrinjWw6Oftf5jeJWEiGtIuDqhKb2OhPX', 0, NULL, '$2y$10$.elkkxixVQLMagCQSCGI/.nz1w/t.B/KTHdOnd7Y3XoDQzy0fkErO', 1, NULL, '12345678', NULL, NULL, '2020-05-28 18:55:44', '2020-07-06 10:22:12', NULL, 'cTtUaGbiS1mwTwkmif1Z36:APA91bGmUepDmaj77I8vnYOmo6zv7EJDJRA1AkEy9vDx8c1hv54if5wIhf4bKMpWESzkcEUhKM53SwvPzasHD5rOy3Q7OdFUFMbv_KjCa_usUVzcdzxBFBxZlq7em_Q9WMpy2-homKoR', NULL, 5, ''),
(11, 'Deep Deep Sinroja', '12345@gmail.com', '+918320578705', NULL, 'WGDCB0o8QTi894fuImyLg0A5pUbKLr061gLAYqYzCCgLvSLhF5cAjA8NNgZE', 0, NULL, '$2y$10$VTNwToyRC8TyVB443fUwfecLcvSOUd9/R9HJ6NnaFjDSac7u90rXS', 1, NULL, NULL, NULL, NULL, '2020-05-28 19:23:57', '2020-05-28 19:23:57', NULL, 'cJsBoq3fSoOvaOz4j91XdE:APA91bGlOlXvBHeYk2A8UL-lAeFlpsAIZEAaKNl96e4bATuD2nznqI4pyTXYYTds9BGoYPDWfn7ymJVTW3qoweGkjVowL_rUhgaYKyvRsiZaD1SemZw49Vz_Prj_4A4RlJKT-Bsk3aUE', NULL, 5, ''),
(12, 'Milan', 'milanpithadiya@gmal.com', '+917990988163', NULL, '', 0, NULL, '$2y$10$n3eJor5VG5TaGj/tYtgv4.eQwzaIOEUZERMkIHIN4Vm4xYBhfOx92', 1, NULL, NULL, NULL, NULL, '2020-06-07 17:01:39', '2020-06-07 17:06:49', NULL, '', NULL, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE `user_document` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_document`
--

INSERT INTO `user_document` (`id`, `user_id`, `title`, `document`, `created_at`, `updated_at`) VALUES
(136, 12, 'Id card', '12-Id-card.png', '2020-07-05 22:46:38', '2020-07-05 22:46:38'),
(139, 6, 'Id card', '6-Id-card.png', '2020-07-05 22:50:12', '2020-07-05 22:50:12'),
(141, 2, 'IMG-20200705-WA0027', '2-IMG-20200705-WA0027.jpg', '2020-07-07 13:10:15', '2020-07-07 13:13:05'),
(142, 9, 'gjvn', '9-gjvn.jpg', '2020-07-08 23:31:19', '2020-07-08 23:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_fund_type_annual_return`
--

CREATE TABLE `user_fund_type_annual_return` (
  `id` bigint(20) NOT NULL,
  `type` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fund_type_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `annual_return` double DEFAULT NULL,
  `annual_cached_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_fund_type_annual_return`
--

INSERT INTO `user_fund_type_annual_return` (`id`, `type`, `fund_type_id`, `user_id`, `annual_return`, `annual_cached_at`) VALUES
(1, 'all_funds', NULL, 4, 382.87, '2020-07-11 04:33:39'),
(2, 'sub_type_wise', 1, 4, 404.18, '2020-07-11 04:33:39'),
(3, 'sub_type_wise', 2, 4, 13.39, '2020-07-11 04:33:09'),
(4, 'sub_type_wise', 1, 6, 52.72, '2020-07-05 16:14:59'),
(5, 'all_funds', NULL, 6, 52.72, '2020-07-05 16:14:59'),
(6, 'all_funds', NULL, 6, 52.72, '2020-07-05 15:43:39');

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
(1, 'patel_consultancy', 3, '198989', 2, 10, 50000, 623, '2020-05-10 00:00:00', 80.25682182985554, '2020-05-10 17:04:36', NULL),
(2, 'patel_consultancy', 4, '123456', 3, 3, 20000, 20, '2019-05-11 00:00:00', 1000, '2020-05-11 03:10:04', NULL),
(3, 'patel_consultancy', 6, '1234569', 6, 3, 20000, 20, '2019-05-11 00:00:00', 1000, '2020-05-11 05:40:27', NULL),
(4, 'patel_consultancy', 4, '1234510', 7, 13, 12000, 20, '2020-05-27 00:00:00', 600, '2020-05-24 04:48:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `target_amount` double DEFAULT NULL,
  `return_rate` double(4,2) DEFAULT '12.00',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `document` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=''active'' , 0=''deactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `user_id`, `type`, `target_amount`, `return_rate`, `start_at`, `end_at`, `document`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 2000000, 12.00, '2020-06-08 16:24:52', '2025-05-27 16:24:52', NULL, 1, '2020-06-05 18:30:00', '2020-06-05 18:30:00'),
(2, 2, 2, 1000000, 12.00, '2020-06-08 16:24:52', '2025-05-27 16:24:52', NULL, 1, '2020-06-05 18:30:00', '2020-06-05 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_plan_sips`
--

CREATE TABLE `user_plan_sips` (
  `id` int(11) NOT NULL,
  `user_plan_id` int(11) DEFAULT NULL,
  `mutual_fund_user_id` int(11) DEFAULT NULL,
  `sip_amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plan_sips`
--

INSERT INTO `user_plan_sips` (`id`, `user_plan_id`, `mutual_fund_user_id`, `sip_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1200, '2020-06-07 11:08:40', '2020-06-07 11:08:40'),
(2, 1, 6, 1400, '2020-06-07 11:08:40', '2020-06-07 11:08:40');

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
  `email_varify` tinyint(1) DEFAULT '0' COMMENT '0 = no, 1 - yes',
  `varification_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` text COLLATE utf8mb4_unicode_ci,
  `pan_card_img` text COLLATE utf8mb4_unicode_ci,
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
(1, 'patel_consultancy', 3, '9878981', 1, 1, 1300, 1300, 'monthly', '4 years,3 months', NULL, 56.52173913043478, '2020-05-10 00:00:00', NULL, NULL, '2020-05-10 17:02:16', 1),
(2, 'patel_consultancy', 4, '123456', 3, 3, 1500, 4500, 'monthly', '1 years,0 months', NULL, 194.11764705882354, '2019-05-11 00:00:00', NULL, NULL, '2020-05-11 03:08:10', 1),
(3, 'patel_consultancy', 4, '123457', 4, 7, 1500, 1500, 'monthly', '1 years,0 months', NULL, 3, '2019-05-11 00:00:00', NULL, NULL, '2020-05-11 03:15:32', 1),
(4, 'patel_consultancy', 4, '123458', 5, 12, 1500, 1500, 'monthly', '1 years,0 months', NULL, 7.5, '2019-05-11 00:00:00', NULL, NULL, '2020-05-11 03:18:26', 1),
(5, 'patel_consultancy', 6, '1234569', 6, 3, 1500, 3000, 'monthly', '1 years,0 months', NULL, 100, '2019-05-11 00:00:00', NULL, NULL, '2020-05-11 05:31:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_user_fund`
--

CREATE TABLE `withdraw_user_fund` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `withdraw_type` enum('by_units','by_amount') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_fund_id` bigint(20) DEFAULT NULL,
  `mutual_fund_id` bigint(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `units` double DEFAULT NULL,
  `nav_on_date` double DEFAULT NULL,
  `withdraw_date` date DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `greetings`
--
ALTER TABLE `greetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `greetings_hist`
--
ALTER TABLE `greetings_hist`
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
-- Indexes for table `policy_benefits`
--
ALTER TABLE `policy_benefits`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `greetings_hist`
--
ALTER TABLE `greetings_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `insurance_category`
--
ALTER TABLE `insurance_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_company`
--
ALTER TABLE `insurance_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_fields`
--
ALTER TABLE `insurance_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_field_details`
--
ALTER TABLE `insurance_field_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `insurance_sub_category`
--
ALTER TABLE `insurance_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `main_slider`
--
ALTER TABLE `main_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `mutual_fund`
--
ALTER TABLE `mutual_fund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mutual_fund_company`
--
ALTER TABLE `mutual_fund_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mutual_fund_investment_hist`
--
ALTER TABLE `mutual_fund_investment_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mutual_fund_nav_hist`
--
ALTER TABLE `mutual_fund_nav_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mutual_fund_type`
--
ALTER TABLE `mutual_fund_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mutual_fund_user`
--
ALTER TABLE `mutual_fund_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_benefits`
--
ALTER TABLE `policy_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_master`
--
ALTER TABLE `policy_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `premium_master`
--
ALTER TABLE `premium_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_document`
--
ALTER TABLE `user_document`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `user_fund_type_annual_return`
--
ALTER TABLE `user_fund_type_annual_return`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_lamp_sum_investment`
--
ALTER TABLE `user_lamp_sum_investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_plan_sips`
--
ALTER TABLE `user_plan_sips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_register`
--
ALTER TABLE `user_register`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sip_investement`
--
ALTER TABLE `user_sip_investement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
