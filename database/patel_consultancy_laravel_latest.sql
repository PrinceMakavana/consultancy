-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 04:06 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patel_consultancy`
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
  `details` text DEFAULT NULL,
  `device_token` text DEFAULT NULL,
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
(54, 4, 'static', '2020-07-10', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ejS1d_fKSv2yE9s5vfrFMu:APA91bFrlcFsxiN9oqS8T3843XFiKVeQIgN0cPe28VFiwwfiyBzq1oCDWVyKxQdOq-3fyhZXzPz4Yj_guzZIR6fFPym8SfKmI3ItFx5Acsy4k4u2FtSDAQHQwxe-oIl8aP5AASABn0Ox', NULL),
(55, 13, 'static', '2020-08-19', '{\"title\":\"Demo\",\"body\":\"Good\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/5.png\"}', 'dp7Nb0O3SMy1hQM00gHA4T:APA91bHKjep5WHlagzIsT6DrDhhFfZrZgR-LG857mH8efBp0z_i4Ov8bssAGr_Nz0OoHdbw0pxeo5JRDA4ytLDhq49q4qgkPFVYAbmMsg5pcuj5_-OIgD5dXMZaAvn8sPPJr22r56S7y', NULL),
(56, 13, 'static', '2020-08-20', '{\"title\":\"Happy Diwali\",\"body\":\"happy Diwali to you and your family.\",\"image\":\"http:\\/\\/patelconsultancy2005.com\\/staging\\/public\\/greetings_images\\/1.jpg\"}', 'ci1zcPKHSrqqYeC59UmP5P:APA91bGUJthecDXm5DkMKYs3iD03DWQY_TKO6Z353r9iaOCKNJogNlmFBjBvci-e5XRPHmjyWViZ7SXjD49BmHpNrQuzBRxUpYu9Il0aZuIDM9rx8cUYYWcpWNQ86lPFxO03qFNkTWMl', NULL);

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
(1, 'Life Insurance', 1, '2020-06-21 06:22:20', '2020-06-21 06:22:20', NULL);

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
(1, 'LIC - Life Insurance Corporation of India', '1.png', 1, '2020-06-21 06:25:10', '2020-06-21 06:25:10', NULL),
(2, 'Kotak Mahindra Life Insurance Company Ltd', '2.png', 1, '2020-06-21 06:26:17', '2020-06-21 06:26:17', NULL),
(3, 'Aditya Birla Capital', '3.png', 1, '2020-08-19 01:42:55', '2020-09-18 13:07:02', NULL),
(4, 'Tata', '4.png', 1, '2020-10-03 11:07:35', '2020-10-12 11:44:10', NULL);

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
(5, 2, 'Maturity Date', NULL, 1, '2020-06-23 23:57:32', '2020-06-23 23:57:32', NULL),
(6, 2, 'Nominee Name', NULL, 1, '2020-07-17 23:35:06', '2020-07-17 23:35:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_installment_mode_hist`
--

CREATE TABLE `insurance_installment_mode_hist` (
  `id` int(11) NOT NULL,
  `policy_id` int(11) DEFAULT NULL,
  `tbl_type` varchar(190) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `premium_mode` varchar(190) DEFAULT NULL,
  `premium_amount` varchar(190) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_installment_mode_hist`
--

INSERT INTO `insurance_installment_mode_hist` (`id`, `policy_id`, `tbl_type`, `from_date`, `premium_mode`, `premium_amount`, `created_at`, `updated_at`) VALUES
(1, 7, 'life_insurance_traditionals', '2017-02-22', 'half_yearly', '4500', '2020-11-08 14:33:39', '2020-11-08 14:33:39'),
(2, 10, 'life_insurance_traditionals', '2016-02-22', 'yearly', '980', '2020-11-09 02:20:19', '2020-11-09 02:20:19'),
(3, 10, 'life_insurance_traditionals', '2020-02-22', 'half_yearly', '4500', '2020-11-09 02:58:04', '2020-11-09 02:58:04');

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
(1, 1, 'Term life Insurance', 1, '2020-06-21 06:22:31', '2020-06-21 06:22:31', NULL),
(2, 1, 'Whole life Insurance', 1, '2020-06-21 06:22:37', '2020-06-21 06:22:37', NULL),
(3, 1, 'Universal life Insurance', 1, '2020-06-21 06:22:44', '2020-06-21 06:22:44', NULL),
(4, 1, 'Variable life Insurance', 1, '2020-06-21 06:22:50', '2020-06-21 06:22:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `life_insurance_traditionals`
--

CREATE TABLE `life_insurance_traditionals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `investment_through` enum('patel_consultancy','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_no` bigint(20) DEFAULT NULL,
  `plan_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `maturity_date` date DEFAULT NULL,
  `maturity_amount` double NOT NULL,
  `maturity_amount_8_per` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `sum_assured` double DEFAULT NULL,
  `premium_amount` bigint(20) DEFAULT NULL,
  `permium_paying_term` bigint(20) DEFAULT NULL COMMENT 'in year',
  `last_premium_date` date DEFAULT NULL,
  `premium_mode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0-Fortnight , 1-monthly , 2-quatarly',
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `is_policy_statement_done` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'complete, open',
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `life_insurance_traditionals`
--

INSERT INTO `life_insurance_traditionals` (`id`, `user_id`, `investment_through`, `policy_no`, `plan_name`, `issue_date`, `maturity_date`, `maturity_amount`, `maturity_amount_8_per`, `company_id`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `is_policy_statement_done`, `status`, `is_trashed`, `created_at`, `updated_at`) VALUES
(9, 4, 'patel_consultancy', 123456, 'Aditya Biral Life Insurance', '2016-02-22', '2039-02-22', 0, NULL, 3, 125000, 9800, 12, '2027-02-22', 'yearly', 23, 1, NULL, NULL, '2020-11-08 09:38:28', '2020-11-08 09:40:51'),
(10, 4, 'patel_consultancy', 1212345678, 'Aditya Birla Capital Life Insurance', '2016-02-22', '2039-02-22', 0, NULL, 3, 125000, 980, 12, '2027-02-22', 'yearly', 23, 1, NULL, NULL, '2020-11-08 20:50:19', '2020-11-08 21:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `life_insurance_ulips`
--

CREATE TABLE `life_insurance_ulips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `investment_through` enum('patel_consultancy','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `policy_no` bigint(20) DEFAULT NULL,
  `plan_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nav` decimal(10,2) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `maturity_date` date DEFAULT NULL,
  `maturity_amount` double DEFAULT NULL,
  `sum_assured` double DEFAULT NULL,
  `premium_amount` bigint(20) DEFAULT NULL,
  `permium_paying_term` bigint(20) DEFAULT NULL COMMENT 'in year',
  `last_premium_date` date DEFAULT NULL,
  `premium_mode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0-Fortnight , 1-monthly , 2-quatarly',
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `life_insurance_ulips`
--

INSERT INTO `life_insurance_ulips` (`id`, `user_id`, `investment_through`, `company_id`, `policy_no`, `plan_name`, `nav`, `issue_date`, `maturity_date`, `maturity_amount`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `is_trashed`, `created_at`, `updated_at`) VALUES
(1, 4, 'patel_consultancy', 4, 123456, 'Tata Sampurna Raksha', '10.50', '2020-10-30', '2045-10-30', NULL, 250000, 1300, 7, '2027-10-30', 'yearly', 25, NULL, '2020-10-30 12:55:00', '2020-10-30 12:55:00'),
(2, 2, 'patel_consultancy', 3, 98654, 'Aditya Sampurna Raksha', '10.50', '2020-11-01', '2045-11-01', NULL, 250000, 1422, 8, '2028-11-01', 'yearly', 25, NULL, '2020-11-01 07:40:29', '2020-11-01 07:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `life_insusrance_traditional`
--

CREATE TABLE `life_insusrance_traditional` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `policy_no` bigint(20) DEFAULT NULL,
  `plan_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `sum_assured` double DEFAULT NULL,
  `premium_amount` bigint(20) DEFAULT NULL,
  `permium_paying_term` bigint(20) DEFAULT NULL COMMENT 'in year',
  `last_premium_date` date DEFAULT NULL,
  `premium_mode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0-Fortnight , 1-monthly , 2-quatarly',
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `life_insusrance_traditional`
--

INSERT INTO `life_insusrance_traditional` (`id`, `user_id`, `policy_no`, `plan_name`, `issue_date`, `company_id`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `is_trashed`, `created_at`, `updated_at`) VALUES
(1, 2, 64913498451, 'Kotak Term Plan', '2020-06-01', 2, 130000, 1000, NULL, '2030-06-01', 'monthly', 10, '2020-08-18', '2020-06-21 06:32:54', '2020-08-19 01:40:51'),
(2, 6, 123, 'Cyz', '2020-06-29', 1, 2500000, 1536, NULL, '2040-06-29', 'monthly', 20, '2020-08-18', '2020-06-29 12:08:31', '2020-08-19 01:40:59'),
(3, 4, 20, 'Kotak Life Care', '2020-07-01', 2, 150000, 1500, NULL, '2023-07-01', 'fortnightly', 3, '2020-08-18', '2020-07-01 23:22:12', '2020-08-19 01:41:08'),
(4, 4, 123456789, 'LIC', '2020-06-30', 1, 1568990, 15870, NULL, '2026-06-30', 'monthly', 6, '2020-08-18', '2020-07-02 01:22:47', '2020-08-19 01:41:17'),
(5, 4, 6, 'Kotak Life Care', '2020-06-30', 2, 500000, 6000, NULL, '2035-06-30', 'quarterly', 15, NULL, '2020-07-02 01:32:43', '2020-07-02 01:32:43');

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
(4, '4.jpg', 1, '2020-05-10 11:03:11', '2020-07-21 19:19:19');

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
(24, '2020_09_09_060134_create_life_insurance_traditionals_table', 4),
(25, '2020_10_22_125629_create_life_insurance_ulips_table', 5);

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
(2, 'App\\User', 4),
(2, 'App\\User', 13),
(2, 'App\\User', 14);

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
(11, 'Kotak Standard Multi Cap Fund', 6, 'regular', 'hybrid', 2, '400.00', NULL, '1400.00', NULL, '2020-05-10 16:28:12', 1, NULL, '2020-08-20 17:03:05'),
(12, 'Kotak Emerging Equity', 6, 'direct', 'equity', 2, '230.00', NULL, '1200.00', NULL, '2020-05-10 16:29:43', 1, NULL, NULL),
(13, 'Aditya Birla Mutual Fund', 2, 'direct', 'equity', 1, '300.00', NULL, '2000.00', NULL, '2020-05-11 05:32:42', 1, NULL, '2020-08-23 10:19:11');

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
(6, 'Kotak Mahindra', NULL, NULL, '6.png', '2020-05-10 15:51:09', 1, '2020-08-23 09:59:28'),
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
  `due_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mutual_fund_investment_hist`
--

INSERT INTO `mutual_fund_investment_hist` (`id`, `investement_type`, `user_id`, `refrence_id`, `mutual_fund_user_id`, `matual_fund_id`, `investment_amount`, `purchased_units`, `nav_on_date`, `invested_date`, `due_date`, `created_at`, `remarks`, `deleted_at`) VALUES
(1, 1, 3, 1, 1, 1, 1300, 56.52173913043478, 23, '2020-05-10', '2020-05-10', '2020-05-10 17:03:00', 'First Installment', NULL),
(2, 0, 3, 1, 2, 10, 50000, 80.25682182985554, 623, '2020-05-10', '2020-05-10', '2020-05-10 17:04:36', NULL, NULL),
(3, 1, 4, 2, 3, 3, 1500, 75, 20, '2019-05-11', '2019-05-11', '2020-05-11 03:08:46', NULL, NULL),
(4, 0, 4, 2, 3, 3, 20000, 1000, 20, '2019-05-11', '2019-05-11', '2020-05-11 03:10:04', NULL, NULL),
(5, 1, 4, 2, 3, 3, 1500, 75, 20, '2019-06-11', '2019-06-11', '2020-05-11 03:11:01', 'Great..', NULL),
(6, 1, 4, 3, 4, 7, 1500, 3, 500, '2019-05-11', '2019-05-11', '2020-05-11 03:16:04', 'Great.. !!', NULL),
(7, 1, 4, 4, 5, 12, 1500, 7.5, 200, '2019-05-11', '2019-05-11', '2020-05-11 03:18:51', NULL, NULL),
(8, 1, 6, 5, 6, 3, 1500, 50, 30, '2019-05-11', '2019-05-11', '2020-05-11 05:37:11', 'Great..', NULL),
(9, 1, 6, 5, 6, 3, 1500, 50, 30, '2019-06-11', '2019-06-11', '2020-05-11 05:38:13', 'Great', NULL),
(10, 0, 6, 3, 6, 3, 20000, 1000, 20, '2019-05-11', '2019-05-11', '2020-05-11 05:40:27', NULL, NULL),
(11, 0, 4, 4, 7, 13, 12000, 600, 20, '2020-05-27', '2020-05-27', '2020-05-24 04:48:51', NULL, NULL),
(12, 1, 4, 2, 3, 3, 1500, 44.11764705882353, 34, '2020-06-21', '2020-06-21', '2020-06-21 15:33:23', 'Care', NULL),
(13, 1, 6, 5, 6, 3, 1500, 44.11764705882353, 34, '2019-07-11', '2019-07-11', '2020-07-29 16:41:37', NULL, NULL),
(14, 1, 13, 6, 8, 13, 2500, 10, 250, '2020-01-12', '2020-01-12', '2020-08-18 17:40:38', NULL, '2020-08-19 00:58:21'),
(15, 0, 13, 5, 9, 8, 5000, 20, 250, '2020-08-12', NULL, '2020-08-18 17:45:20', NULL, NULL),
(16, 0, 13, 6, 11, 1, 5000, 200, 25, '2020-04-18', NULL, '2020-08-18 17:50:10', NULL, NULL),
(17, 0, 13, 7, 13, 9, 10000, 47.61904761904762, 210, '2020-08-17', NULL, '2020-08-18 18:17:16', NULL, NULL),
(18, 1, 13, 10, 12, 13, 2000, 9.30232558139535, 215, '2020-08-18', '2020-08-18', '2020-08-18 18:20:56', NULL, NULL),
(19, 0, 13, 8, 12, 13, 5500, 25.58139534883721, 215, '2020-08-18', NULL, '2020-08-18 18:29:32', NULL, NULL),
(20, 1, 13, 11, 14, 11, 1500, 3.75, 400, '2020-08-20', '2020-08-20', '2020-08-20 16:48:15', NULL, NULL),
(21, 1, 13, 11, 14, 11, 1500, 3, 500, '2020-09-20', '2020-09-20', '2020-08-20 16:59:46', NULL, NULL),
(22, 1, 4, 12, 15, 13, 5000, 19.23076923076923, 260, '2020-08-23', '2020-08-23', '2020-08-23 10:17:43', NULL, NULL);

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

--
-- Dumping data for table `mutual_fund_nav_hist`
--

INSERT INTO `mutual_fund_nav_hist` (`id`, `mutual_fund_id`, `nav`, `date`) VALUES
(1, 11, 300, '2020-08-20'),
(2, 11, 500, '2020-08-20'),
(3, 13, 215, '2020-08-20'),
(4, 13, 260, '2020-08-20'),
(5, 11, 400, '2020-08-20'),
(6, 13, 300, '2020-08-23');

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
(1, NULL, NULL, 3, '9878981', 1, '1300.00', 56.52173913043478, 1300, '2020-05-10', 0, '2020-05-10 17:02:16', NULL, 1, '2020-08-18 17:41:13', NULL, NULL, '2020-08-18 17:41:13'),
(2, NULL, NULL, 3, '198989', 10, NULL, 80.25682182985554, 50000, '2020-05-10', -44.9438202247191, '2020-05-10 17:04:36', 0, 1, '2020-08-18 17:41:23', NULL, '2020-06-21 15:36:46', '2020-08-18 17:41:23'),
(3, NULL, 3, 4, '123456', 3, '4500.00', 1194.1176470588234, 24500, '2020-05-11', 65.71428571428571, '2020-05-11 03:08:10', 57.58, 1, '2020-08-18 17:41:33', NULL, '2020-07-11 15:24:09', '2020-08-18 17:41:33'),
(4, NULL, 3, 4, '123457', 7, '1500.00', 3, 1500, '2020-05-11', 31.8, '2020-05-11 03:15:32', 26.62, 1, '2020-08-18 17:41:41', NULL, '2020-07-11 15:24:10', '2020-08-18 17:41:41'),
(5, NULL, 4, 4, '123458', 12, '1500.00', 7.5, 1500, '2020-05-11', 16, '2020-05-11 03:18:26', 12.69, 1, '2020-08-18 17:41:54', NULL, '2020-07-11 15:24:10', '2020-08-18 17:41:54'),
(6, NULL, NULL, 6, '1234569', 3, '4500.00', 1144.1176470588234, 24500, '2020-05-11', 58.77551020408164, '2020-05-11 05:31:48', 46.8, 1, '2020-08-18 17:42:00', NULL, '2020-07-29 16:41:41', '2020-08-18 17:42:00'),
(7, NULL, 4, 4, '1234510', 13, NULL, 600, 12000, '2020-05-24', 900, '2020-05-24 04:48:51', 12, 1, '2020-08-18 17:42:10', NULL, '2020-07-11 15:24:11', '2020-08-18 17:42:10'),
(8, NULL, NULL, 13, '51515151', 13, '0.00', 0, 0, '2020-08-18', 0, '2020-08-18 17:38:23', 0, 1, '2020-08-18 17:59:34', NULL, '2020-08-18 17:58:21', '2020-08-18 17:59:34'),
(9, NULL, NULL, 13, '52525252', 8, NULL, 20, 5000, '2020-08-18', -79.2, '2020-08-18 17:43:57', 0, 1, '2020-08-18 17:47:09', NULL, '2020-08-18 17:45:22', '2020-08-18 17:47:09'),
(10, NULL, NULL, 13, '52525252', 8, NULL, NULL, NULL, '2020-08-18', NULL, '2020-08-18 17:47:52', NULL, 1, '2020-08-18 17:48:20', NULL, NULL, '2020-08-18 17:48:20'),
(11, NULL, NULL, 13, '535353', 1, NULL, 200, 5000, '2020-08-18', -8, '2020-08-18 17:49:03', -21.92, 1, '2020-08-18 17:59:57', NULL, '2020-08-18 17:50:11', '2020-08-18 17:59:57'),
(12, NULL, 6, 13, '123456', 13, '2000.00', 34.883720930232556, 7500, '2020-08-18', -6.976744186046514, '2020-08-18 18:02:15', 113, 1, NULL, NULL, '2020-08-20 16:56:11', '2020-10-03 16:22:36'),
(13, NULL, NULL, 13, '1234567', 9, NULL, 47.61904761904762, 10000, '2020-08-18', 10, '2020-08-18 18:17:16', 128, 1, NULL, NULL, '2020-08-18 18:18:44', '2020-08-18 18:18:44'),
(14, NULL, NULL, 13, '6525652', 11, '3000.00', 6.75, 3000, '2020-08-20', 12.5, '2020-08-20 16:44:32', 0, 1, NULL, NULL, '2020-08-20 17:04:14', '2020-08-20 17:04:14'),
(15, NULL, NULL, 4, '123456789', 13, '5000.00', 19.23076923076923, 5000, '2020-08-23', 0, '2020-08-23 10:12:35', 0, 1, NULL, NULL, '2020-08-23 10:19:17', '2020-08-23 10:19:17');

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
  `tbl_key` varchar(50) NOT NULL,
  `benefit_type` varchar(20) NOT NULL,
  `notes` text DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_done` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `policy_benefits`
--

INSERT INTO `policy_benefits` (`id`, `policy_id`, `tbl_key`, `benefit_type`, `notes`, `amount`, `received_at`, `date`, `is_done`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 10, 'life_insurance_traditionals', 'assured_benefit', NULL, 25000, NULL, '2032-02-22', NULL, '2020-11-09 02:42:38', '2020-11-09 02:47:27', NULL);

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
  `premium_mode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0-Fortnight , 1-monthly , 2-quatarly',
  `policy_term` int(11) DEFAULT NULL COMMENT 'in year',
  `other_fields` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_trashed` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `insurance_field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policy_master`
--

INSERT INTO `policy_master` (`id`, `user_id`, `policy_no`, `plan_name`, `issue_date`, `company_id`, `category_id`, `sub_category_id`, `sum_assured`, `premium_amount`, `permium_paying_term`, `last_premium_date`, `premium_mode`, `policy_term`, `other_fields`, `is_trashed`, `created_at`, `updated_at`, `insurance_field_id`) VALUES
(1, 2, 64913498451, 'Kotak Term Plan', '2020-06-01', 2, 1, 1, 130000, 1000, NULL, '2030-06-01', 'monthly', 10, '[{\"car_model\":\"XUV\"},{\"car_company\":\"Honda\"}]', '2020-08-18', '2020-06-21 06:32:54', '2020-08-19 01:40:51', 1),
(2, 6, 123, 'Cyz', '2020-06-29', 1, 1, 3, 2500000, 1536, NULL, '2040-06-29', 'monthly', 20, '[{\"name\":\"Dharmesh\"},{\"person_birthdate\":\"23-09-1978\"},{\"maturity_date\":\"05-09-2030\"}]', '2020-08-18', '2020-06-29 12:08:31', '2020-08-19 01:40:59', 2),
(3, 4, 20, 'Kotak Life Care', '2020-07-01', 2, 1, 1, 150000, 1500, NULL, '2023-07-01', 'fortnightly', 3, '[{\"name\":\"Deep Sinroja\"},{\"person_birthdate\":\"05 \\/ 10 \\/ 1998\"},{\"maturity_date\":\"05 \\/ 10 \\/ 2045\"}]', '2020-08-18', '2020-07-01 23:22:12', '2020-08-19 01:41:08', 2),
(4, 4, 123456789, 'LIC', '2020-06-30', 1, 1, 1, 1568990, 15870, NULL, '2026-06-30', 'monthly', 6, '[{\"name\":\"Axis\"},{\"person_birthdate\":\"05 \\/ 10 \\/ 1998\"},{\"maturity_date\":\"30 \\/ 06 \\/ 2096\"}]', '2020-08-18', '2020-07-02 01:22:47', '2020-08-19 01:41:17', 2),
(5, 4, 6, 'Kotak Life Care', '2020-06-30', 2, 1, 3, 500000, 6000, NULL, '2035-06-30', 'quarterly', 15, '[{\"car_model\":\"Civic\"},{\"car_company\":\"Honda\"}]', NULL, '2020-07-02 01:32:43', '2020-07-02 01:32:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `premium_master`
--

CREATE TABLE `premium_master` (
  `id` bigint(20) NOT NULL,
  `policy_id` bigint(20) DEFAULT NULL,
  `tbl_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `premium_master` (`id`, `policy_id`, `tbl_key`, `amount`, `premium_date`, `paid_at`, `created_at`, `updated_at`, `is_trashed`) VALUES
(5, 3, 'life_insurance_traditionals', 2866, '2020-09-04', '2020-09-12', '2020-09-12 14:30:40', '2020-09-12 14:30:40', NULL),
(6, 3, 'life_insurance_traditionals', 2866, '2020-10-04', '2020-10-01', '2020-09-13 06:17:37', '2020-09-13 06:17:37', NULL),
(7, 2, 'life_insurance_traditionals', 2866, '2020-09-04', '2020-09-27', '2020-09-27 04:15:17', '2020-09-27 04:15:17', NULL),
(8, 2, 'life_insurance_traditionals', 2866, '2020-10-04', '2020-09-27', '2020-09-27 08:40:22', '2020-09-27 08:40:22', NULL),
(11, 3, 'life_insurance_traditionals', 2866, '2020-11-04', '2020-09-27', '2020-09-27 08:55:09', '2020-09-27 08:55:09', NULL),
(12, 1, 'life_insurance_traditionals', 2866, '2020-09-04', '2020-09-27', '2020-09-27 08:56:12', '2020-09-27 08:56:12', NULL),
(13, 1, 'life_insurance_traditionals', 2866, '2020-12-04', '2020-09-27', '2020-09-27 08:56:25', '2020-09-27 08:56:25', NULL),
(14, 2, 'life_insurance_traditionals', 2866, '2020-11-04', '2020-09-28', '2020-09-28 10:36:07', '2020-09-28 10:36:07', NULL),
(15, 4, 'life_insurance_traditionals', 40000, '2020-03-01', '2020-10-03', '2020-10-03 11:21:30', '2020-10-03 11:21:30', NULL),
(16, 4, 'life_insurance_traditionals', 40000, '2020-06-01', '2020-10-03', '2020-10-03 11:21:55', '2020-10-03 11:21:55', NULL),
(17, 1, 'life_insurance_traditionals', 2866, '2021-03-04', '2020-10-30', '2020-10-30 15:31:17', '2020-10-30 15:31:17', NULL),
(18, 1, 'life_insurance_traditionals', 2866, '2021-06-04', '2020-10-30', '2020-10-30 15:33:40', '2020-10-30 15:33:40', NULL),
(23, 2, 'life_insurance_ulips', 1420, '2020-12-04', '2020-11-01', '2020-11-01 08:01:47', '2020-11-01 08:01:47', NULL),
(24, 7, 'life_insurance_traditionals', 9836, '2016-02-22', '2020-11-08', '2020-11-08 05:39:41', '2020-11-08 05:39:41', NULL);

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
  `user_docs` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_no`, `profile`, `api_token`, `is_reported`, `reason`, `password`, `status`, `remember_token`, `pan_no`, `pan_card_img`, `email_verified_at`, `created_at`, `updated_at`, `birthdate`, `device_token`, `greetings_notification`, `doc_limit`, `user_docs`) VALUES
(1, 'SuperAdmin', 'superadmin@gmail.com', NULL, NULL, NULL, 0, NULL, '$2y$10$RRN95Y3J43kRRlVtVo9ENO5aiTbdJUPOJJppJJ7RydMpHojVjXIau', 1, NULL, NULL, NULL, NULL, '2020-04-18 02:44:57', '2020-04-18 02:44:57', NULL, NULL, NULL, 5, ''),
(2, 'Milan', 'milanmsp7@gmail.com', '+919824795495', '2.jpg', '74w1Nykn1z1xG5tsJUPKXujTiuh5hatIltTpqHMSYbuSK4yRXBg9KI9QccVj', 0, NULL, '$2y$10$XyVoWK7dYRK23gvQ3MasleiF7k2GmlKy6nXjDcEdEY9vUj87/PwUW', 1, NULL, 'AJK12758', NULL, NULL, '2020-06-01 00:10:08', '2020-08-23 17:10:29', '2000-12-23', 'dp7Nb0O3SMy1hQM00gHA4T:APA91bHKjep5WHlagzIsT6DrDhhFfZrZgR-LG857mH8efBp0z_i4Ov8bssAGr_Nz0OoHdbw0pxeo5JRDA4ytLDhq49q4qgkPFVYAbmMsg5pcuj5_-OIgD5dXMZaAvn8sPPJr22r56S7y', NULL, 25, ''),
(4, 'Romik Makwana', 'makavanaromik1214@gmail.com', '+919913327614', '4.jpg', '9J580hiF0POwwrZFdpmEYfNbIBPdVnlk4r8WdmiXTBGFfSQFfOGlqD0FJZRF', 0, NULL, '$2y$10$mkpVdWt9wiVCEQibv2VsPuW9BBN/K1yV2NKxfs7tZizpsdXTuwSXy', 1, NULL, '111222', '4.png', NULL, '2020-05-10 21:33:55', '2020-08-23 17:09:14', '2021-12-15', 'eCWT3g2iS_CwAs7ISS-atn:APA91bGuHILMYG6CjJq19GWX7eAa_TAC5nMzD5DRTndHY9ZkTJNn4iUYOHBMq8DoIH2g0yvNvF3IY7JBfUtkWQRPCb4vj8IjnAndm4bTLE3RLGl_pwgFrq0CfqYRR1P9C9PvEnn2ykxx', NULL, 5, ''),
(13, 'Dharmesh Gadhiya', 'dharmeshgadhiya237@gmail.com', '+919824837585', NULL, 'BaqIv43jLaG2vsEyGeHPtNlWbfEqP7EsSGZdxOymulNFogpUX3ORHymlvQVj', 0, NULL, '$2y$10$5P39hI.aFMuW3UKVZV896uqNFWthA.lTFXh4Eom5FTP7E6ylu1uKC', 1, NULL, 'AJGPG5882P', NULL, NULL, '2020-08-19 00:32:48', '2020-08-20 23:22:59', '1983-07-23', 'ci1zcPKHSrqqYeC59UmP5P:APA91bGUJthecDXm5DkMKYs3iD03DWQY_TKO6Z353r9iaOCKNJogNlmFBjBvci-e5XRPHmjyWViZ7SXjD49BmHpNrQuzBRxUpYu9Il0aZuIDM9rx8cUYYWcpWNQ86lPFxO03qFNkTWMl', NULL, 5, ''),
(14, 'Sheetal Gadhiya', 'sg@gmail.com', '+919898093548', NULL, NULL, 0, NULL, '$2y$10$gtugo6NXha3ghG5KgxlLKudwZTF7X4XFREoozcZFQ0YrBx9OPlRKC', 1, NULL, 'aEKPT1846F', NULL, NULL, '2020-10-03 11:05:30', '2020-10-03 11:05:30', '1981-09-17', NULL, NULL, 5, '');

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
(162, 4, 'ID Card', '4-ID-Card.pdf', '2020-07-12 13:00:27', '2020-07-12 13:00:27'),
(166, 4, 'Question', '4-Question.PDF', '2020-07-12 19:40:29', '2020-07-12 19:40:29'),
(169, 9, 'RESUME(1)', '9-RESUME(1).pdf', '2020-07-17 20:12:17', '2020-07-17 20:12:17'),
(195, 2, 'image1', '2-image1.jpg', '2020-07-20 00:45:25', '2020-07-20 00:45:25'),
(204, 9, 'deep', '9-deep.jpg', '2020-07-23 22:49:52', '2020-07-23 22:49:52'),
(206, 9, '1595682732094', '9-1595682732094.jpg', '2020-07-25 20:12:14', '2020-07-25 20:12:14'),
(207, 14, 'Aadhar Card', '14-Aadhar-Card.png', '2020-10-03 11:06:03', '2020-10-03 11:06:03');

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
(1, 'all_funds', NULL, 4, 0, '2020-08-23 13:13:04'),
(2, 'sub_type_wise', 1, 4, 0, '2020-08-23 13:13:04'),
(3, 'sub_type_wise', 2, 4, 12.69, '2020-07-19 05:13:44'),
(4, 'sub_type_wise', 1, 6, 52.72, '2020-07-21 06:23:36'),
(5, 'all_funds', NULL, 6, 52.72, '2020-07-21 06:23:36'),
(6, 'all_funds', NULL, 6, 52.72, '2020-07-05 15:43:39'),
(7, 'sub_type_wise', 1, 13, 0, '2020-08-20 16:54:29'),
(8, 'sub_type_wise', 2, 13, 0, '2020-08-20 16:54:30'),
(9, 'sub_type_wise', 4, 13, 10, '2020-08-20 16:54:30'),
(10, 'all_funds', NULL, 13, 0, '2020-08-20 17:04:16');

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
(1, 'patel_consultancy', 3, '198989', 2, 10, 50000, 623, '2020-05-10 00:00:00', 80.25682182985554, '2020-05-10 17:04:36', '2020-08-19 00:41:23'),
(2, 'patel_consultancy', 4, '123456', 3, 3, 20000, 20, '2019-05-11 00:00:00', 1000, '2020-05-11 03:10:04', '2020-08-19 00:41:33'),
(3, 'patel_consultancy', 6, '1234569', 6, 3, 20000, 20, '2019-05-11 00:00:00', 1000, '2020-05-11 05:40:27', '2020-08-19 00:42:00'),
(4, 'patel_consultancy', 4, '1234510', 7, 13, 12000, 20, '2020-05-27 00:00:00', 600, '2020-05-24 04:48:51', '2020-08-19 00:42:10'),
(5, 'other', 13, '52525252', 9, 8, 5000, 250, '2020-08-12 00:00:00', 20, '2020-08-18 17:45:20', '2020-08-19 00:47:09'),
(6, 'other', 13, '535353', 11, 1, 5000, 25, '2020-04-18 00:00:00', 200, '2020-08-18 17:50:10', '2020-08-19 00:59:57'),
(7, 'patel_consultancy', 13, '1234567', 13, 9, 10000, 210, '2020-08-17 00:00:00', 47.61904761904762, '2020-08-18 18:17:16', NULL),
(8, 'patel_consultancy', 13, '123456', 12, 13, 5500, 215, '2020-08-18 00:00:00', 25.58139534883721, '2020-08-18 18:29:32', NULL);

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
(1, 9, 1, 2000000, 12.00, '2020-06-08 16:24:52', '2025-05-27 16:24:52', NULL, 1, '2020-06-05 18:30:00', '2020-06-05 18:30:00'),
(2, 2, 2, 1000000, 12.00, '2020-06-08 16:24:52', '2025-05-27 16:24:52', NULL, 1, '2020-06-05 18:30:00', '2020-06-05 18:30:00'),
(3, 4, 1, 1000000, 12.00, '2020-07-01 00:00:00', '2030-07-01 00:00:00', NULL, 1, '2020-07-11 20:06:17', '2020-07-11 20:06:17'),
(4, 4, 2, 1000000, 12.00, '2020-07-01 00:00:00', '2030-07-01 00:00:00', NULL, 1, '2020-07-11 20:35:42', '2020-07-11 20:35:42'),
(5, 13, 1, 1000000, 12.00, '2020-10-01 00:00:00', '2030-10-01 00:00:00', NULL, 1, '2020-10-03 10:50:36', '2020-10-03 10:50:36'),
(6, 13, 2, 1000000, 12.00, '2020-10-01 00:00:00', '2030-10-01 00:00:00', NULL, 1, '2020-10-03 10:51:29', '2020-10-03 10:51:29');

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
(1, 'patel_consultancy', 3, '9878981', 1, 1, 1300, 1300, 'monthly', '4 years,3 months', NULL, 56.52173913043478, '2020-05-10 00:00:00', NULL, '2020-08-19 00:41:13', '2020-05-10 17:02:16', 1),
(2, 'patel_consultancy', 4, '123456', 3, 3, 1500, 4500, 'monthly', '1 years,0 months', NULL, 194.11764705882354, '2019-05-11 00:00:00', NULL, '2020-08-19 00:41:33', '2020-05-11 03:08:10', 1),
(3, 'patel_consultancy', 4, '123457', 4, 7, 1500, 1500, 'monthly', '1 years,0 months', NULL, 3, '2019-05-11 00:00:00', NULL, '2020-08-19 00:41:41', '2020-05-11 03:15:32', 1),
(4, 'patel_consultancy', 4, '123458', 5, 12, 1500, 1500, 'monthly', '1 years,0 months', NULL, 7.5, '2019-05-11 00:00:00', NULL, '2020-08-19 00:41:54', '2020-05-11 03:18:26', 1),
(5, 'patel_consultancy', 6, '1234569', 6, 3, 1500, 4500, 'monthly', '1 years,0 months', NULL, 144.11764705882354, '2019-05-11 00:00:00', NULL, '2020-08-19 00:42:00', '2020-05-11 05:31:48', 1),
(6, 'other', 13, '51515151', 8, 13, 2500, 0, 'monthly', '5 years,0 months', NULL, 0, '2020-01-12 00:00:00', NULL, '2020-08-19 00:59:34', '2020-08-18 17:38:23', 1),
(7, 'other', 13, '52525252', 9, 8, 1600, 0, 'monthly', '5 years,0 months', NULL, NULL, '2020-02-18 00:00:00', NULL, '2020-08-19 00:47:09', '2020-08-18 17:43:57', 1),
(8, 'other', 13, '52525252', 10, 8, 3000, 0, 'monthly', '5 years,0 months', NULL, NULL, '2020-08-18 00:00:00', NULL, '2020-08-19 00:48:20', '2020-08-18 17:47:52', 1),
(9, 'other', 13, '535353', 11, 1, 3000, 0, 'monthly', '5 years,0 months', NULL, NULL, '2020-03-18 00:00:00', NULL, '2020-08-19 00:59:57', '2020-08-18 17:49:03', 1),
(10, 'patel_consultancy', 13, '123456', 12, 13, 2000, 2000, 'monthly', '5 years,6 months', NULL, 9.30232558139535, '2020-08-18 00:00:00', NULL, NULL, '2020-08-18 18:02:15', 1),
(11, 'patel_consultancy', 13, '6525652', 14, 11, 1500, 3000, 'monthly', '5 years,0 months', NULL, 6.75, '2020-08-20 00:00:00', NULL, NULL, '2020-08-20 16:44:32', 1),
(12, 'patel_consultancy', 4, '123456789', 15, 13, 5000, 5000, 'monthly', '15 years,1 months', NULL, 19.23076923076923, '2020-08-23 00:00:00', NULL, NULL, '2020-08-23 10:12:35', 1);

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
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
-- Indexes for table `insurance_installment_mode_hist`
--
ALTER TABLE `insurance_installment_mode_hist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_sub_category`
--
ALTER TABLE `insurance_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `life_insurance_traditionals`
--
ALTER TABLE `life_insurance_traditionals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `life_insurance_ulips`
--
ALTER TABLE `life_insurance_ulips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `life_insusrance_traditional`
--
ALTER TABLE `life_insusrance_traditional`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `insurance_category`
--
ALTER TABLE `insurance_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_company`
--
ALTER TABLE `insurance_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `insurance_fields`
--
ALTER TABLE `insurance_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_field_details`
--
ALTER TABLE `insurance_field_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `insurance_installment_mode_hist`
--
ALTER TABLE `insurance_installment_mode_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `insurance_sub_category`
--
ALTER TABLE `insurance_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `life_insurance_traditionals`
--
ALTER TABLE `life_insurance_traditionals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `life_insurance_ulips`
--
ALTER TABLE `life_insurance_ulips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `life_insusrance_traditional`
--
ALTER TABLE `life_insusrance_traditional`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `main_slider`
--
ALTER TABLE `main_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `mutual_fund_nav_hist`
--
ALTER TABLE `mutual_fund_nav_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mutual_fund_type`
--
ALTER TABLE `mutual_fund_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mutual_fund_user`
--
ALTER TABLE `mutual_fund_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_benefits`
--
ALTER TABLE `policy_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `policy_master`
--
ALTER TABLE `policy_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `premium_master`
--
ALTER TABLE `premium_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_document`
--
ALTER TABLE `user_document`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `user_fund_type_annual_return`
--
ALTER TABLE `user_fund_type_annual_return`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_lamp_sum_investment`
--
ALTER TABLE `user_lamp_sum_investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
