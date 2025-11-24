-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 11:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classic`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `original_price` int(11) DEFAULT NULL,
  `sales_price` int(11) DEFAULT NULL,
  `remaining_qty` int(11) DEFAULT NULL,
  `brand_id` varchar(255) NOT NULL,
  `offer_status` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) NOT NULL,
  `units` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `feature` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `backend_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `slug`, `original_price`, `sales_price`, `remaining_qty`, `brand_id`, `offer_status`, `category_id`, `units`, `description`, `feature`, `image`, `images`, `status`, `backend_price`, `created_at`, `updated_at`) VALUES
(1, 'Pre Filter', 'pre-filter', NULL, 250, NULL, '1', NULL, '1', 'qty', '<p>sadhvsvc sjdvhsdjchvv sjdvcbsjdhc</p>', '<p>sdjcvsdvbnscdc</p>', '1737820797.jpg', '[\"1737820797_476ba8b84a339fbdff1ab4dceb5a275c.jpg\"]', 'on', NULL, '2025-01-25 15:59:57', '2025-01-25 15:59:57'),
(2, 'Filter pipe', 'filter-pipe', NULL, 300, NULL, '1', NULL, '1', 'meter', '<p>sdhgcshgvcsx</p>', '<p>sdmnbvjsdhvb</p>', '1737820845.jpg', '[]', 'on', NULL, '2025-01-25 16:00:45', '2025-01-25 16:00:45'),
(3, 'sdcsd', 'sdcsd', NULL, 123, NULL, '1', NULL, '1', 'ltr', '<p>SDFBSJDFHV</p>', '<p>skjdbfsdhv</p>', '1737821113.jpg', '[]', 'on', NULL, '2025-01-25 16:05:13', '2025-01-25 16:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `accessories_device_purchase`
--

CREATE TABLE `accessories_device_purchase` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `accessories_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accessory_stocks`
--

CREATE TABLE `accessory_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `stock_in` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `stock_alert` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisemments`
--

CREATE TABLE `advertisemments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `page` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `expire_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisemments`
--

INSERT INTO `advertisemments` (`id`, `title`, `button_text`, `link`, `page`, `position`, `image`, `description`, `expire_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Cupidatat velit est', NULL, 'https://www.zatipakyty.co.uk', 'Home Page', '1', '1679290504.jpg', NULL, '2023-07-20 05:56:33', 'on', '2023-03-19 23:50:04', '2023-07-20 00:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `amcs`
--

CREATE TABLE `amcs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amcs`
--

INSERT INTO `amcs` (`id`, `title`, `year`, `price`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gold Amc', '3', 2000.00, 'Gold Amc with 3 years time periods', '', 'on', '2025-11-18 06:31:52', '2025-11-18 12:42:10'),
(2, 'Silver Amc', '1', 1000.00, 'Silver Amc with 1 years time periods', '', 'on', '2025-11-18 06:32:37', '2025-11-18 06:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `amc_accessories`
--

CREATE TABLE `amc_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amc_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amc_assign_accessories`
--

CREATE TABLE `amc_assign_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amc_assign_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amc_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amc_customers`
--

CREATE TABLE `amc_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amc_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `landline` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `sales` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `payment_status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `payment_method` enum('cash','online','cheque','multiple') DEFAULT NULL,
  `cash_amount` decimal(10,2) DEFAULT 0.00,
  `cash_receipt` varchar(255) DEFAULT NULL,
  `online_amount` decimal(10,2) DEFAULT 0.00,
  `online_receipt` varchar(255) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT 0.00,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_receipt` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amc_customers`
--

INSERT INTO `amc_customers` (`id`, `customer_id`, `amc_id`, `branch_id`, `customer_name`, `user_name`, `contact`, `landline`, `product_name`, `email`, `address`, `sales`, `type`, `image`, `date`, `last_date`, `amount`, `payment_status`, `payment_method`, `cash_amount`, `cash_receipt`, `online_amount`, `online_receipt`, `cheque_amount`, `cheque_number`, `cheque_receipt`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 12, 'Serena Mccullough', 'DHNSERENAMCCULLOUGH', '1336252300', '1829514929', 'Wayne Burke', 'dixotyji@mailinator.com', 'Nisi qui eaque quaer', '27', 'outsider', NULL, '1993-08-18', '2025-11-19', '2000.00', 'paid', NULL, 2000.00, 'CR7.png', 0.00, NULL, 0.00, NULL, NULL, 'esfgh', 'complete', '2025-11-19 05:28:42', '2025-11-19 06:17:04'),
(2, 2, 2, 12, NULL, 'DHNJOELHOPPER', NULL, NULL, NULL, NULL, NULL, '17', 'register', NULL, '1992-11-22', '2025-11-20', '1000.00', 'paid', NULL, 0.00, NULL, 1000.00, 'IMG_01.jpg', 0.00, NULL, NULL, 'gh', 'queue', '2025-11-19 05:31:55', '2025-11-20 05:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `bikes`
--

CREATE TABLE `bikes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `bikenumber` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bikes`
--

INSERT INTO `bikes` (`id`, `branch_id`, `name`, `model`, `bikenumber`, `created_by`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '12', 'MT-15', 'V3', 'MH47BA2781', '1', 'on', NULL, '2025-06-15 10:46:17', '2025-06-15 10:46:17'),
(2, '13', 'FZ', 'V3', 'MH47BA7242', '1', 'on', NULL, '2025-06-15 10:48:45', '2025-06-15 10:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `bike_services`
--

CREATE TABLE `bike_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bike_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `service_center` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `km` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Test', 'test', '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; transition: all 0.4s ease-in-out 0s; color: rgb(114, 114, 114); font-family: Ubuntu, sans-serif;\">In today\'s digital age, establishing a robust online presence is no longer an option – it\'s a necessity for businesses looking to succeed and thrive. One of the key avenues to achieve this is through a well-designed website and a strategically developed mobile app. Let\'s delve into how leveraging these digital tools can elevate your business and drive growth.</p><div class=\"blog-video-area\" style=\"margin: 0px 0px 50px; padding: 0px; color: rgb(114, 114, 114); font-family: Ubuntu, sans-serif;\"><div class=\"video-title\" style=\"margin: 0px 0px 26px; padding: 0px;\"><h3 class=\"title\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; font-weight: var(--tj-fw-bold); line-height: 1.3; font-size: var(--tj-fs-h3); font-family: var(--tj-ff-heading); transition: all 0.4s ease-in-out 0s;\">Proinmauris risus turpos or nare filis aptent nisl</h3><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; transition: all 0.4s ease-in-out 0s;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas.</p></div><div class=\"row video-box\" style=\"margin-top: calc(-1 * var(--bs-gutter-y)); margin-right: calc(-.5 * var(--bs-gutter-x)); margin-bottom: 15px; margin-left: calc(-.5 * var(--bs-gutter-x)); padding: 0px; --bs-gutter-x: 1.5rem; --bs-gutter-y: 0;\"><div class=\"col-lg-6\" style=\"margin-top: var(--bs-gutter-y); margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: calc(var(--bs-gutter-x) * .5); padding-bottom: 0px; padding-left: calc(var(--bs-gutter-x) * .5); flex-basis: auto; width: 440px; max-width: 100%;\"><div class=\"video-image\" style=\"margin: 0px; padding: 0px; position: relative;\"><img src=\"http://127.0.0.1:8000/frontend/images/blog/blog-8.jpg\" alt=\"Image\" style=\"margin: 0px; padding: 0px; transition: all 0.4s ease-in-out 0s; max-width: 100%; border-radius: 20px; width: 416px;\"><div class=\"video-play\" style=\"margin: 0px; padding: 0px; position: absolute; top: 167.891px; left: 208px; transform: translate(-50%, -50%); width: 70px; height: 70px; line-height: 80px; border-radius: 50%; display: inline-block; text-align: center; background: linear-gradient(90deg, var(--tj-color-theme-secondary) 0%, var(--tj-color-theme-primary) 100%);\"><a class=\"venobox popup-videos-button\" data-autoplay=\"true\" data-vbtype=\"video\" href=\"https://www.youtube.com/watch?v=ADmQTw4qqTY\" style=\"margin: 0px; padding: 0px; color: inherit; transition: all 0.4s ease-in-out 0s; outline: none; border: none; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; display: inline-block;\"><span class=\"fa-sharp fa-solid fa-play\" style=\"margin: 0px; padding: 0px; -webkit-font-smoothing: antialiased; display: var(--fa-display,inline-block); font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-variant-position: normal; line-height: 1; text-rendering: auto; font-family: &quot;Font Awesome 6 Pro&quot;; font-weight: 900; color: var(--tj-color-common-white); font-size: 30px;\"></span></a></div></div></div><div class=\"col-lg-6\" style=\"margin-top: var(--bs-gutter-y); margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: calc(var(--bs-gutter-x) * .5); padding-bottom: 0px; padding-left: calc(var(--bs-gutter-x) * .5); flex-basis: auto; width: 440px; max-width: 100%;\"><div class=\"video-content\" style=\"margin: 0px; padding: 0px;\"><h4 class=\"title\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; font-weight: var(--tj-fw-bold); line-height: 1.3; font-size: var(--tj-fs-h4); font-family: var(--tj-ff-heading); transition: all 0.4s ease-in-out 0s;\">Roise Capital Faster &amp; Segoticite On Your Own Trems</h4><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; transition: all 0.4s ease-in-out 0s;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas.</p><div class=\"check-list\" style=\"margin: 15px 0px 0px; padding: 0px;\"><ul style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; list-style: none;\"><li style=\"margin: 0px 0px 10px; padding: 0px; transition: all 0.4s ease-in-out 0s; color: var(--tj-color-light-3); font-weight: var(--tj-fw-sbold); font-family: var(--tj-ff-body);\"><span class=\"fa-light fa-angle-right\" style=\"margin: 0px 5px 0px 0px; padding: 0px; -webkit-font-smoothing: antialiased; display: inline-block; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-variant-position: normal; line-height: 18px; text-rendering: auto; font-family: &quot;Font Awesome 6 Pro&quot;; font-weight: var(--tj-fw-sbold); width: 18px; height: 18px; font-size: 12px; text-align: center; border-radius: 50%; color: var(--tj-color-common-white); background: var(--tj-color-light-3);\"></span>&nbsp;- 100% Better Result</li><li style=\"margin: 0px 0px 10px; padding: 0px; transition: all 0.4s ease-in-out 0s; color: var(--tj-color-light-3); font-weight: var(--tj-fw-sbold); font-family: var(--tj-ff-body);\"><span class=\"fa-light fa-angle-right\" style=\"margin: 0px 5px 0px 0px; padding: 0px; -webkit-font-smoothing: antialiased; display: inline-block; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-variant-position: normal; line-height: 18px; text-rendering: auto; font-family: &quot;Font Awesome 6 Pro&quot;; font-weight: var(--tj-fw-sbold); width: 18px; height: 18px; font-size: 12px; text-align: center; border-radius: 50%; color: var(--tj-color-common-white); background: var(--tj-color-light-3);\"></span>&nbsp;- Budget Friend Service</li><li style=\"margin: 0px; padding: 0px; transition: all 0.4s ease-in-out 0s; color: var(--tj-color-light-3); font-weight: var(--tj-fw-sbold); font-family: var(--tj-ff-body);\"><span class=\"fa-light fa-angle-right\" style=\"margin: 0px 5px 0px 0px; padding: 0px; -webkit-font-smoothing: antialiased; display: inline-block; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-variant-position: normal; line-height: 18px; text-rendering: auto; font-family: &quot;Font Awesome 6 Pro&quot;; font-weight: var(--tj-fw-sbold); width: 18px; height: 18px; font-size: 12px; text-align: center; border-radius: 50%; color: var(--tj-color-common-white); background: var(--tj-color-light-3);\"></span>&nbsp;- Happy Customers</li></ul></div></div></div></div><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; transition: all 0.4s ease-in-out 0s;\">\"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish.</p></div>', '1679382416.jpg', 'on', '2023-03-21 01:21:56', '2024-03-18 21:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `booking_services`
--

CREATE TABLE `booking_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `service_date` varchar(255) NOT NULL,
  `service_time` time NOT NULL,
  `message` text DEFAULT NULL,
  `method` varchar(255) NOT NULL DEFAULT 'cash',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_services`
--

INSERT INTO `booking_services` (`id`, `service_id`, `vendor_id`, `user_id`, `name`, `phone`, `email`, `address`, `service_date`, `service_time`, `message`, `method`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, NULL, 'Prince', '+1 (116) 379-2919', 'pakifipidu@mailinator.com', 'Eaque enim reprehend', 'शनि, साउन १९, २०८१', '23:28:00', 'sdmhnfgiskjmxf aksjfh bajsdxfbcjASbd jaszn bc', 'cash', 'complete', '2024-07-31 04:43:27', '2024-08-04 01:07:37'),
(2, 6, NULL, NULL, 'Sushil Kunwar', '9004992036', 'minbogati13579@gmail.com', 'Dhangadhi, kailali, nepal', 'शुक्र, साउन ३२, २०८१', '15:15:00', 'msngbdfjsf wejjgfbwu jdgfcbesjhf wuyshfgb sujhfsefhgsebjfhm sjhfg wejhcg', 'cash', 'accept', '2024-07-31 23:45:21', '2024-08-01 06:56:14');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `branch_code`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Dhangadhi', 'DHN', '9805672203', 'dhangadhi@classicro.com.np', 'Sahid Gate Road, Taranagar', 'on', '2024-11-11 05:59:39', '2025-10-07 11:43:13'),
(13, 'Butwal Branch', 'CBTL', '1234567890', 'butwalbranch@classicro.com.np', 'Sukkhanagar, butwal, Nepal', 'on', '2025-02-18 15:15:36', '2025-10-07 11:43:38'),
(14, 'Manigram', NULL, '6789054321', 'manigram@classicro.com', 'Butwal manigram', 'on', '2025-08-28 10:28:04', '2025-08-28 10:28:04'),
(15, 'Kathmandu', 'CKTM', '5678901232', 'kathmandu@classicro.com.np', 'Kalupool kathmandu', 'on', '2025-09-12 08:15:51', '2025-10-07 11:43:55'),
(16, 'Achham', 'AXM', '4234343543', 'zuqaj@mailinator.com', 'Achham Nepal', 'on', '2025-10-07 11:19:40', '2025-10-07 11:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Aqua', 'aqua', '1734074809.png', 'Ad cupiditate aut qu', 'on', '2024-12-13 07:26:49', '2025-01-25 15:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `closing_balances`
--

CREATE TABLE `closing_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `closing_balances`
--

INSERT INTO `closing_balances` (`id`, `amount`, `date`, `status`, `created_at`, `updated_at`) VALUES
(2, 3000.00, '2025-06-22', 'deposited', '2025-06-22 08:28:20', '2025-06-22 08:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `logo` varchar(255) NOT NULL,
  `footer_logo` varchar(255) NOT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `introduction` longtext DEFAULT NULL,
  `vision` longtext DEFAULT NULL,
  `mission` longtext DEFAULT NULL,
  `map` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `company_name`, `company_email`, `company_phone`, `company_address`, `logo`, `footer_logo`, `favicon`, `image`, `footer_text`, `introduction`, `vision`, `mission`, `map`, `facebook`, `instagram`, `twitter`, `youtube`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(4, 'Classic Enterprises', 'info@classicro.com', '+977-9865877255', 'Butwal, Kailali, Nepal', '1650869331.png.png', '1650869331.png.png', '1650462329.jpg.jpg', 'test.jpeg.jpg', '<p><span style=\"color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 12.8px;\">CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.</span><small style=\"box-sizing: inherit; font-size: 10.24px; color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\"></small><small style=\"box-sizing: inherit; font-size: 10.24px; color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\"></small><span style=\"color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 12.8px;\">​​​​​​​CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.</span><br></p>', '<span style=\"color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 12.8px;\">CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.</span><small style=\"box-sizing: inherit; font-size: 10.24px; color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\"></small><small style=\"box-sizing: inherit; font-size: 10.24px; color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\"></small><span style=\"color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 12.8px;\">​​​​​​​CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.</span><br>', '<span style=\"color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 12.8px;\">CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.</span>', '<span style=\"color: rgb(0, 0, 0); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">CLASSIC ENTERPRISES-Born for Water Purifier Machine sales and service as well Interior Decoration.</span>', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0024661677794!2d85.32180441407107!3d27.71721013166748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19be5848a26d%3A0xa6ac3390cc5de11c!2sFlight%20Nepal!5e0!3m2!1sen!2snp!4v16', 'https://www.facebook.com/flytoworldwide', 'https://www.instagram.com/solutionidesigngraphic/', 'https://www.twitter.com/solutionidesigngraphic/', 'https://www.youtube.com/channel/UCX5UDhpV1JLITv_-SjjNuNg', 'handy man service', 'All Service Provider in On Site', '[{\"value\":\"electician\"},{\"value\":\"plumbers\"},{\"value\":\"cleaners\"}]', '2022-03-12 23:57:31', '2024-08-15 01:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `converted_by` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `exchange_amount` int(11) DEFAULT 0,
  `total_amount` int(11) DEFAULT 0,
  `paid_amount` int(11) DEFAULT 0,
  `due_amount` int(11) DEFAULT 0,
  `amc` varchar(255) NOT NULL DEFAULT 'no',
  `amc_date` varchar(255) DEFAULT NULL,
  `ticket_status` varchar(255) DEFAULT NULL,
  `payment_status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `payment_method` enum('cash','online','cheque','multiple') DEFAULT NULL,
  `cash_amount` decimal(10,2) DEFAULT 0.00,
  `cash_receipt` varchar(255) DEFAULT NULL,
  `online_amount` decimal(10,2) DEFAULT 0.00,
  `online_receipt` varchar(255) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT 0.00,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_receipt` varchar(255) DEFAULT NULL,
  `gifted` tinyint(1) NOT NULL DEFAULT 0,
  `customer_type` varchar(255) DEFAULT NULL,
  `sales_type` varchar(255) DEFAULT NULL,
  `installation_category` varchar(255) DEFAULT NULL,
  `install_date` timestamp NULL DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `assign_to` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text DEFAULT NULL,
  `warranty_in` date DEFAULT NULL,
  `warranty_out` date DEFAULT NULL,
  `warranty_lifetime` tinyint(1) NOT NULL DEFAULT 0,
  `product_document` varchar(255) DEFAULT NULL,
  `warranty_card` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `lead_id`, `branch_id`, `created_by`, `converted_by`, `user_name`, `exchange_amount`, `total_amount`, `paid_amount`, `due_amount`, `amc`, `amc_date`, `ticket_status`, `payment_status`, `payment_method`, `cash_amount`, `cash_receipt`, `online_amount`, `online_receipt`, `cheque_amount`, `cheque_number`, `cheque_receipt`, `gifted`, `customer_type`, `sales_type`, `installation_category`, `install_date`, `status`, `assign_to`, `message`, `warranty_in`, `warranty_out`, `warranty_lifetime`, `product_document`, `warranty_card`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 76, 12, 1, 16, 'DHNAKEEMGATES', 0, 14999, 0, 14999, 'yes', '2025-11-19 09:49:58', 'queue', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'indoor', 'counter_sales', 'industrial', '2025-11-08 18:15:00', 'installation_assign', 16, 'AAJH HAMI AAUDAINAN', NULL, NULL, 0, 'LOGO.png', 'GANESH KUNWAR.png', NULL, '2023-11-09 06:35:44', '2025-11-19 04:04:58'),
(2, 77, 12, 1, 17, 'DHNJOELHOPPER', 0, 14999, 0, 14999, 'yes', '2025-11-19 11:16:55', 'assign', 'paid', 'multiple', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'indoor', 'counter_sales', 'commercial', '2025-11-10 18:15:00', 'installation_assign', 17, 'sfdsdf', NULL, NULL, 0, 'CR7.png', 'IMG_01.jpg', NULL, '2025-11-09 10:33:30', '2025-11-20 06:57:56'),
(3, 79, 12, 1, 17, 'DHNNICHOLECANTU', 0, 14999, 14999, 0, 'no', NULL, 'queue', 'paid', 'online', NULL, NULL, 14999.00, 'CR7.png', NULL, NULL, NULL, 0, 'indoor', 'wholeseller', 'retailler', '2025-11-10 18:15:00', 'installation_report', 16, 'DASF', NULL, NULL, 0, 'hero3.jpg', 'LOGO GK.png', NULL, '2025-11-10 07:02:31', '2025-11-18 15:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `customer_accessories`
--

CREATE TABLE `customer_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `accessory_qty` int(11) NOT NULL,
  `accessory_price` int(11) NOT NULL,
  `accessory_total` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_accessories`
--

INSERT INTO `customer_accessories` (`id`, `lead_id`, `branch_id`, `accessory_id`, `customer_id`, `created_by`, `accessory_qty`, `accessory_price`, `accessory_total`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(11, 61, 12, 1, 13, 1, 1, 250, 250, NULL, NULL, '2025-10-30 12:25:51', '2025-10-30 12:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `customer_notes`
--

CREATE TABLE `customer_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_notes`
--

INSERT INTO `customer_notes` (`id`, `lead_id`, `customer_id`, `note`, `created_at`, `updated_at`) VALUES
(35, 31, NULL, 'Aliquam atque sit n', '2025-10-19 05:17:30', '2025-10-19 05:17:30'),
(36, 32, NULL, 'Iusto exercitation v', '2025-10-19 05:18:03', '2025-10-19 05:18:03'),
(37, 33, NULL, 'Et anim debitis anim', '2025-10-19 05:18:46', '2025-10-19 05:18:46'),
(38, 34, NULL, 'Magnam nisi saepe qu', '2025-10-19 06:11:49', '2025-10-19 06:11:49'),
(39, 34, 11, 'SDFDS', '2025-10-19 06:16:06', '2025-10-19 06:16:06'),
(40, 34, 11, 'Assign to Sushil', '2025-10-19 06:17:38', '2025-10-19 06:17:38'),
(41, 34, 11, 'njhvfgh', '2025-10-19 06:23:57', '2025-10-19 06:23:57'),
(42, 31, 12, 'ghgdx', '2025-10-19 06:40:56', '2025-10-19 06:40:56'),
(43, 31, 12, 'min', '2025-10-19 07:33:41', '2025-10-19 07:33:41'),
(44, 31, 12, 'FSFSF', '2025-10-19 07:37:33', '2025-10-19 07:37:33'),
(45, 33, 13, 'nbgfdfgh', '2025-10-19 08:04:50', '2025-10-19 08:04:50'),
(46, 33, 13, 'Sushil', '2025-10-19 08:08:47', '2025-10-19 08:08:47'),
(47, 33, 13, 'jbhbj', '2025-10-19 08:55:12', '2025-10-19 08:55:12'),
(48, 32, 14, 'ghdxfcgh', '2025-10-19 12:18:23', '2025-10-19 12:18:23'),
(49, 35, NULL, 'Quae autem tempor au', '2025-10-22 08:09:00', '2025-10-22 08:09:00'),
(50, 32, 14, 'ghdxfcgh', '2025-10-22 08:54:40', '2025-10-22 08:54:40'),
(51, 32, 14, 'BHBHDBHBC', '2025-10-22 09:09:42', '2025-10-22 09:09:42'),
(52, 35, 1, 'BSHVHSVH', '2025-10-22 09:23:17', '2025-10-22 09:23:17'),
(53, 35, 1, 'BSHVHSVH', '2025-10-22 09:23:39', '2025-10-22 09:23:39'),
(54, 35, 1, 'nnHVHVd', '2025-10-22 09:24:59', '2025-10-22 09:24:59'),
(55, 36, NULL, 'Minima vel velit ven', '2025-10-26 04:02:58', '2025-10-26 04:02:58'),
(56, 36, 2, 'gdfhfhnh', '2025-10-26 04:12:02', '2025-10-26 04:12:02'),
(57, 37, NULL, 'edwdqwd', '2025-10-26 09:38:40', '2025-10-26 09:38:40'),
(58, 37, 3, 'fdfgdfgfdgfdftthf', '2025-10-26 09:42:49', '2025-10-26 09:42:49'),
(59, 37, 3, 'fhgfghfghfghgf', '2025-10-26 09:44:11', '2025-10-26 09:44:11'),
(60, 38, NULL, 'jkhfuydvyu', '2025-10-26 12:47:18', '2025-10-26 12:47:18'),
(61, 38, 4, 'jggvj', '2025-10-26 12:48:51', '2025-10-26 12:48:51'),
(62, 38, 4, 'Assign to mIn', '2025-10-26 12:49:44', '2025-10-26 12:49:44'),
(63, 38, 4, 'bhgcgh', '2025-10-26 12:51:06', '2025-10-26 12:51:06'),
(64, 39, NULL, 'Est nostrud eos eo', '2025-10-26 13:23:07', '2025-10-26 13:23:07'),
(65, 39, 5, 'fdb', '2025-10-26 13:23:34', '2025-10-26 13:23:34'),
(66, 39, 5, 'fdb', '2025-10-26 13:23:51', '2025-10-26 13:23:51'),
(67, 39, 5, 'vbbnm', '2025-10-26 13:28:11', '2025-10-26 13:28:11'),
(68, 40, NULL, 'greterteert', '2025-10-26 13:33:26', '2025-10-26 13:33:26'),
(69, 40, 6, 'fjyjtyjyut', '2025-10-26 13:37:40', '2025-10-26 13:37:40'),
(70, 40, 6, 'hold due to rainging', '2025-10-26 13:40:03', '2025-10-26 13:40:03'),
(71, 40, 6, 'hold due to raingingjjjjjjjjjj', '2025-10-26 13:40:37', '2025-10-26 13:40:37'),
(72, 40, 6, 'hold due to raingingjjjjjjjjjj', '2025-10-26 13:41:53', '2025-10-26 13:41:53'),
(73, 40, 6, 'hold due to raingingjjjjjjjjjj', '2025-10-26 13:42:04', '2025-10-26 13:42:04'),
(74, 40, 6, 'sfgdgtgtgrd', '2025-10-26 13:44:36', '2025-10-26 13:44:36'),
(75, 40, 6, 'ffdgd', '2025-10-26 13:56:20', '2025-10-26 13:56:20'),
(76, 41, NULL, 'Qui facilis fugiat l', '2025-10-26 14:19:42', '2025-10-26 14:19:42'),
(77, 42, NULL, 'efweewerwe', '2025-10-27 08:14:08', '2025-10-27 08:14:08'),
(78, 43, NULL, 'edsfsadfsdfdgfd', '2025-10-27 08:21:03', '2025-10-27 08:21:03'),
(79, 43, 7, 'vnghjhjghjg', '2025-10-27 08:24:18', '2025-10-27 08:24:18'),
(80, 43, 7, 'vnghjhjghjg', '2025-10-27 08:30:34', '2025-10-27 08:30:34'),
(81, 44, NULL, 'fhjhghg', '2025-10-27 08:39:18', '2025-10-27 08:39:18'),
(82, 44, 8, 'ghjhjkhjjhjhjkhhh', '2025-10-27 08:43:56', '2025-10-27 08:43:56'),
(83, 44, 8, 'ghjhjkhjjhjhjkhhh', '2025-10-27 08:52:07', '2025-10-27 08:52:07'),
(84, 44, 8, 'cfhfghfghfg', '2025-10-27 09:01:21', '2025-10-27 09:01:21'),
(85, 45, NULL, 'Pariatur At enim ad', '2025-10-28 15:09:58', '2025-10-28 15:09:58'),
(86, 45, 1, 'DASFDDF', '2025-10-28 15:13:43', '2025-10-28 15:13:43'),
(87, 45, 1, 'DASFDDF', '2025-10-28 15:13:53', '2025-10-28 15:13:53'),
(88, 45, 1, 'SADA', '2025-10-28 15:29:23', '2025-10-28 15:29:23'),
(89, 46, NULL, 'tyyyrrrrrrr', '2025-10-29 05:53:40', '2025-10-29 05:53:40'),
(90, 46, 2, 'ffhfhfhbdf', '2025-10-29 05:54:41', '2025-10-29 05:54:41'),
(91, 46, 2, 'ffhfhfhbdf', '2025-10-29 05:54:54', '2025-10-29 05:54:54'),
(92, 48, NULL, 'rgdddddddddddddddd', '2025-10-29 10:18:13', '2025-10-29 10:18:13'),
(93, 48, 3, 'thryrtyrryrtyrtytryytr', '2025-10-29 10:19:00', '2025-10-29 10:19:00'),
(94, 48, 3, 'thryrtyrryrtyrtytryytr', '2025-10-29 10:19:27', '2025-10-29 10:19:27'),
(95, 48, 3, 'yghhgjhgyhjghgjgjgjgjgjg', '2025-10-29 10:22:07', '2025-10-29 10:22:07'),
(96, 51, NULL, '55yyyyyyyyyyyyyyyyyy', '2025-10-29 10:33:25', '2025-10-29 10:33:25'),
(97, 51, 4, 'gfjgjfjfgjfg', '2025-10-29 10:34:55', '2025-10-29 10:34:55'),
(98, 51, 4, 'gfjgjfjfgjfg', '2025-10-29 10:36:03', '2025-10-29 10:36:03'),
(99, 52, NULL, 'fdgddddddf', '2025-10-29 10:49:19', '2025-10-29 10:49:19'),
(100, 52, 5, 'dffgdgddddddddddddddddd', '2025-10-29 10:50:11', '2025-10-29 10:50:11'),
(101, 52, 5, 'dffgdgddddddddddddddddd', '2025-10-29 10:50:49', '2025-10-29 10:50:49'),
(102, 54, NULL, 'ddferfefer', '2025-10-29 10:59:26', '2025-10-29 10:59:26'),
(103, 55, NULL, 'ythrturturturtur', '2025-10-29 11:01:25', '2025-10-29 11:01:25'),
(104, 55, 6, 'ffhdfdfgdgdgdgdfgdfgddgddf', '2025-10-29 11:04:38', '2025-10-29 11:04:38'),
(105, 55, 6, 'ffhdfdfgdgdgdgdfgdfgddgddf          v cv', '2025-10-29 11:08:31', '2025-10-29 11:08:31'),
(106, 55, 6, 'tfyrtfhfgdgfrer', '2025-10-29 11:14:00', '2025-10-29 11:14:00'),
(107, 56, NULL, 'Magna aperiam qui co', '2025-10-29 12:08:51', '2025-10-29 12:08:51'),
(108, 56, 7, 'DFSF', '2025-10-29 12:09:11', '2025-10-29 12:09:11'),
(109, 42, 8, 'DACDD', '2025-10-29 13:34:44', '2025-10-29 13:34:44'),
(110, 42, 8, 'DACDD', '2025-10-29 13:34:56', '2025-10-29 13:34:56'),
(111, 42, 8, 'GSDFSDF', '2025-10-29 13:35:56', '2025-10-29 13:35:56'),
(112, 57, NULL, 'sfweseretertert', '2025-10-29 18:35:12', '2025-10-29 18:35:12'),
(113, 57, 9, 'bdffgdfgdfgdf', '2025-10-29 18:35:58', '2025-10-29 18:35:58'),
(114, 57, 9, 'bdffgdfgdfgdf', '2025-10-29 18:37:19', '2025-10-29 18:37:19'),
(115, 57, 9, 'sddgsdgsdgsdvs', '2025-10-29 18:38:59', '2025-10-29 18:38:59'),
(116, 58, NULL, 'kdhsdukhaskjasa', '2025-10-30 08:58:44', '2025-10-30 08:58:44'),
(117, 58, 10, 'gnkdgfxgjkldfgldgv', '2025-10-30 09:01:40', '2025-10-30 09:01:40'),
(118, 58, 10, 'gnkdgfxgjkldfgldgv', '2025-10-30 09:04:15', '2025-10-30 09:04:15'),
(119, 58, 10, 'ddsufhsufhaks', '2025-10-30 09:06:47', '2025-10-30 09:06:47'),
(120, 59, NULL, 'Consequuntur eum qui', '2025-10-30 10:05:27', '2025-10-30 10:05:27'),
(121, 59, 11, 'DDC', '2025-10-30 10:06:12', '2025-10-30 10:06:12'),
(122, 59, 11, 'DDC', '2025-10-30 10:08:46', '2025-10-30 10:08:46'),
(123, 59, 11, 'SDSDDS', '2025-10-30 10:09:45', '2025-10-30 10:09:45'),
(124, 60, NULL, 'ertetweewtewtewet', '2025-10-30 10:24:48', '2025-10-30 10:24:48'),
(125, 60, 12, 'fghfghdfhdf', '2025-10-30 10:34:57', '2025-10-30 10:34:57'),
(126, 61, NULL, 'dgdrfgdgsdgssfsd', '2025-10-30 10:55:26', '2025-10-30 10:55:26'),
(127, 60, 12, 'fghfghdfhdf', '2025-10-30 11:01:03', '2025-10-30 11:01:03'),
(128, 60, 12, 'dgerterte', '2025-10-30 11:49:08', '2025-10-30 11:49:08'),
(129, 61, 13, 'zfsdvsdfvsdfvs sgsgdfgd', '2025-10-30 12:25:51', '2025-10-30 12:25:51'),
(130, 63, NULL, 'xsdfsddddddddddddddddd', '2025-10-30 13:07:20', '2025-10-30 13:07:20'),
(131, 63, 14, 'fdftrtttttttttttttttty', '2025-10-30 13:09:46', '2025-10-30 13:09:46'),
(132, 63, 14, 'fdftrtttttttttttttttty', '2025-10-30 13:17:58', '2025-10-30 13:17:58'),
(133, 64, NULL, 'dffffffffffffsg', '2025-10-31 11:07:29', '2025-10-31 11:07:29'),
(134, 64, 15, 'gvbbbbbbbbbbbbbbbbbbbbbb', '2025-10-31 11:12:41', '2025-10-31 11:12:41'),
(135, 64, 15, 'gvbbbbbbbbbbbbbbbbbbbbbb', '2025-10-31 11:18:50', '2025-10-31 11:18:50'),
(136, 63, 14, 'ffbfhfh', '2025-10-31 11:20:00', '2025-10-31 11:20:00'),
(137, 65, NULL, 'fgggggggggggggg', '2025-10-31 11:32:09', '2025-10-31 11:32:09'),
(138, 65, 16, 'bfdfthdddddddddddddddddd', '2025-10-31 11:51:58', '2025-10-31 11:51:58'),
(139, 65, 16, 'bfdfthdddddddddddddddddd', '2025-10-31 12:06:17', '2025-10-31 12:06:17'),
(140, 67, NULL, 'sdgdfggggggggggggd', '2025-10-31 12:15:46', '2025-10-31 12:15:46'),
(141, 67, 17, 'gffffffffffffffffff', '2025-10-31 12:16:45', '2025-10-31 12:16:45'),
(142, 37, 18, 'DDAS', '2025-10-31 12:07:06', '2025-10-31 12:07:06'),
(143, 68, NULL, 'Id in eveniet et co', '2025-10-31 12:08:51', '2025-10-31 12:08:51'),
(144, 68, 19, 'DSD', '2025-10-31 12:10:09', '2025-10-31 12:10:09'),
(145, 69, NULL, 'Consequatur minima e', '2025-10-31 12:12:52', '2025-10-31 12:12:52'),
(146, 70, NULL, 'Mollit unde maiores', '2025-11-02 05:02:06', '2025-11-02 05:02:06'),
(147, 70, 20, 'ADSSVS', '2025-11-02 05:04:37', '2025-11-02 05:04:37'),
(148, 70, 20, 'ADSSVS', '2025-11-02 05:06:33', '2025-11-02 05:06:33'),
(149, 70, 20, 'hgcfcvhb', '2025-11-02 05:12:53', '2025-11-02 05:12:53'),
(150, 71, NULL, 'Commodo reprehenderi', '2025-11-02 05:16:28', '2025-11-02 05:16:28'),
(151, 71, NULL, 'Commodo reprehenderi', '2025-11-02 05:17:22', '2025-11-02 05:17:22'),
(152, 68, 19, 'DSD', '2025-11-02 06:25:07', '2025-11-02 06:25:07'),
(153, 68, 19, 'ghcfc', '2025-11-02 06:25:56', '2025-11-02 06:25:56'),
(154, 68, 19, 'ghcfc', '2025-11-02 06:25:58', '2025-11-02 06:25:58'),
(155, 68, 19, 'jkhvgch', '2025-11-02 06:27:21', '2025-11-02 06:27:21'),
(156, 68, 19, 'jkhvgch', '2025-11-02 06:27:23', '2025-11-02 06:27:23'),
(157, 68, 19, 'jkhvgch', '2025-11-02 06:27:25', '2025-11-02 06:27:25'),
(158, 68, 19, 'DSFAD', '2025-11-02 06:34:12', '2025-11-02 06:34:12'),
(159, 71, 21, 'SFDDFS', '2025-11-04 06:32:53', '2025-11-04 06:32:53'),
(160, 71, 21, 'SFDDFS', '2025-11-04 06:33:08', '2025-11-04 06:33:08'),
(161, 71, 21, 'nj hn', '2025-11-04 06:34:05', '2025-11-04 06:34:05'),
(162, 72, NULL, 'Est ex magnam inven', '2025-11-04 08:39:48', '2025-11-04 08:39:48'),
(163, 73, NULL, 'Consequuntur rem pra', '2025-11-04 08:40:46', '2025-11-04 08:40:46'),
(164, 74, NULL, 'Dolores anim repudia', '2025-11-04 08:41:18', '2025-11-04 08:41:18'),
(165, 72, 22, 'SDASAds', '2025-11-04 09:17:55', '2025-11-04 09:17:55'),
(166, 73, 23, 'DSA', '2025-11-04 09:26:47', '2025-11-04 09:26:47'),
(167, 74, 24, 'SASAD', '2025-11-04 09:39:52', '2025-11-04 09:39:52'),
(168, 75, NULL, 'Necessitatibus aliqu', '2025-11-05 05:03:02', '2025-11-05 05:03:02'),
(169, 75, 25, 'sdfgdf', '2025-11-07 11:13:50', '2025-11-07 11:13:50'),
(170, 75, 25, 'sdfgdf', '2025-11-07 11:16:46', '2025-11-07 11:16:46'),
(171, 75, 25, 'wff', '2025-11-07 11:19:13', '2025-11-07 11:19:13'),
(172, 69, 26, 'Tempora molestiae do', '2025-11-07 11:33:10', '2025-11-07 11:33:10'),
(173, 76, NULL, 'Ut fuga Optio recu', '2025-11-09 06:35:16', '2025-11-09 06:35:16'),
(174, 76, 1, 'njhgbn', '2025-11-09 06:35:44', '2025-11-09 06:35:44'),
(175, 76, 1, 'njhgbn', '2025-11-09 06:35:57', '2025-11-09 06:35:57'),
(176, 76, 1, '.hgtfrgyhjkl', '2025-11-09 06:36:39', '2025-11-09 06:36:39'),
(177, 77, NULL, 'Dolorem nihil culpa', '2025-11-09 10:32:56', '2025-11-09 10:32:56'),
(178, 77, 2, 'Qui excepturi sit cu', '2025-11-09 10:33:30', '2025-11-09 10:33:30'),
(179, 78, NULL, 'Aliquam in molestiae', '2025-11-09 10:53:55', '2025-11-09 10:53:55'),
(180, 79, NULL, 'Voluptatum blanditii', '2025-11-10 07:01:49', '2025-11-10 07:01:49'),
(181, 79, 3, 'Qui vero exercitatio', '2025-11-10 07:02:31', '2025-11-10 07:02:31'),
(182, 76, 1, 'AAJH HAMI AAUDAINAN', '2025-11-10 11:25:00', '2025-11-10 11:25:00'),
(183, 79, 3, 'Qui vero exercitatio', '2025-11-11 04:34:36', '2025-11-11 04:34:36'),
(184, 79, 3, 'DASF', '2025-11-11 04:35:32', '2025-11-11 04:35:32'),
(185, 77, 2, 'Qui excepturi sit cu', '2025-11-11 06:27:01', '2025-11-11 06:27:01'),
(186, 77, 2, 'sfdsdf', '2025-11-11 06:27:45', '2025-11-11 06:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `cash_amount` int(11) DEFAULT NULL,
  `cash_receipt` varchar(255) DEFAULT NULL,
  `online_amount` int(11) DEFAULT NULL,
  `online_receipt` varchar(255) DEFAULT NULL,
  `cheque_amount` int(11) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_receipt` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`id`, `lead_id`, `branch_id`, `customer_id`, `created_by`, `paid_amount`, `payment_method`, `cash_amount`, `cash_receipt`, `online_amount`, `online_receipt`, `cheque_amount`, `cheque_number`, `cheque_receipt`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(19, 70, 12, 20, 17, 35000, 'online', 0, NULL, 35000, 'David.png', 0, NULL, NULL, 'paid', NULL, '2025-11-02 05:12:53', '2025-11-02 05:12:53'),
(20, 68, 12, 19, 16, 112993, 'online', 0, NULL, 112993, 'Flooring.png', 0, NULL, NULL, 'paid', NULL, '2025-11-02 06:27:21', '2025-11-02 06:27:21'),
(21, 68, 12, 19, 16, 112993, 'online', 0, NULL, 112993, 'Flooring.png', 0, NULL, NULL, 'paid', NULL, '2025-11-02 06:27:23', '2025-11-02 06:27:23'),
(22, 68, 12, 19, 16, 112993, 'online', 0, NULL, 112993, 'Flooring.png', 0, NULL, NULL, 'paid', NULL, '2025-11-02 06:27:25', '2025-11-02 06:27:25'),
(23, 68, 12, 19, 16, 112993, 'cheque', 0, NULL, 0, 'Flooring.png', 112993, '8456765736', 'Flooring.png', 'paid', NULL, '2025-11-02 06:34:12', '2025-11-02 06:34:12'),
(24, 79, 12, 3, 17, 14999, 'online', 0, NULL, 14999, 'CR7.png', 0, NULL, NULL, 'paid', NULL, '2025-11-11 04:35:32', '2025-11-11 04:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `customer_products`
--

CREATE TABLE `customer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_total` int(11) NOT NULL,
  `exchange` varchar(255) NOT NULL DEFAULT 'no',
  `total_exchange` decimal(10,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_products`
--

INSERT INTO `customer_products` (`id`, `lead_id`, `branch_id`, `product_id`, `customer_id`, `created_by`, `product_price`, `product_qty`, `product_total`, `exchange`, `total_exchange`, `remarks`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(76, 60, 12, 2, 12, 1, 20000, 1, 20000, 'no', 0.00, 'fghfghdfhdf', 'installation_queue', NULL, '2025-10-30 10:34:57', '2025-10-30 10:34:57'),
(77, 61, 12, 1, 13, 1, 14999, 1, 14999, 'no', 0.00, 'zfsdvsdfvsdfvs sgsgdfgd', 'installation_queue', NULL, '2025-10-30 12:25:51', '2025-10-30 12:25:51'),
(78, 63, 12, 2, 14, 1, 50000, 1, 50000, 'no', 0.00, 'fdftrtttttttttttttttty', 'installation_queue', NULL, '2025-10-30 13:09:46', '2025-10-30 13:09:46'),
(79, 64, 14, 2, 15, 1, 50000, 1, 50000, 'no', 0.00, 'gvbbbbbbbbbbbbbbbbbbbbbb', 'installation_queue', NULL, '2025-10-31 11:12:41', '2025-10-31 11:12:41'),
(80, 65, 14, 1, 16, 1, 50000, 1, 50000, 'no', 0.00, 'bfdfthdddddddddddddddddd', 'installation_queue', NULL, '2025-10-31 11:51:58', '2025-10-31 11:51:58'),
(81, 67, 14, 2, 17, 1, 50000, 1, 50000, 'no', 0.00, 'gffffffffffffffffff', 'installation_queue', NULL, '2025-10-31 12:16:45', '2025-10-31 12:16:45'),
(82, 37, 15, 1, 18, 1, 14999, 5, 74995, 'no', 0.00, 'DDAS', 'installation_queue', NULL, '2025-10-31 12:07:06', '2025-10-31 12:07:06'),
(83, 37, 15, 2, 18, 1, 16999, 5, 84995, 'no', 0.00, 'DDAS', 'installation_queue', NULL, '2025-10-31 12:07:06', '2025-10-31 12:07:06'),
(84, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', 0.00, 'DSD', 'installation_queue', '2025-11-02 06:25:56', '2025-10-31 12:10:09', '2025-11-02 06:25:56'),
(85, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', 0.00, 'DSD', 'installation_queue', '2025-11-02 06:25:56', '2025-10-31 12:10:09', '2025-11-02 06:25:56'),
(86, 70, 12, 1, 20, 1, 10000, 4, 40000, 'yes', 5000.00, 'ADSSVS', 'installation_queue', '2025-11-02 05:12:53', '2025-11-02 05:04:36', '2025-11-02 05:12:53'),
(87, 70, 12, 1, 20, 1, 10000, 4, 40000, 'no', NULL, 'hgcfcvhb', 'installation_queue', NULL, '2025-11-02 05:12:53', '2025-11-02 05:12:53'),
(88, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', NULL, 'ghcfc', 'installation_queue', '2025-11-02 06:25:58', '2025-11-02 06:25:56', '2025-11-02 06:25:58'),
(89, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', NULL, 'ghcfc', 'installation_queue', '2025-11-02 06:25:58', '2025-11-02 06:25:56', '2025-11-02 06:25:58'),
(90, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', NULL, 'ghcfc', 'installation_queue', '2025-11-02 06:27:21', '2025-11-02 06:25:58', '2025-11-02 06:27:21'),
(91, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', NULL, 'ghcfc', 'installation_queue', '2025-11-02 06:27:21', '2025-11-02 06:25:58', '2025-11-02 06:27:21'),
(92, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', NULL, 'jkhvgch', 'installation_queue', '2025-11-02 06:27:23', '2025-11-02 06:27:21', '2025-11-02 06:27:23'),
(93, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', NULL, 'jkhvgch', 'installation_queue', '2025-11-02 06:27:23', '2025-11-02 06:27:21', '2025-11-02 06:27:23'),
(94, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', NULL, 'jkhvgch', 'installation_queue', '2025-11-02 06:27:25', '2025-11-02 06:27:23', '2025-11-02 06:27:25'),
(95, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', NULL, 'jkhvgch', 'installation_queue', '2025-11-02 06:27:25', '2025-11-02 06:27:23', '2025-11-02 06:27:25'),
(96, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', NULL, 'jkhvgch', 'installation_queue', '2025-11-02 06:34:12', '2025-11-02 06:27:25', '2025-11-02 06:34:12'),
(97, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', NULL, 'jkhvgch', 'installation_queue', '2025-11-02 06:34:12', '2025-11-02 06:27:25', '2025-11-02 06:34:12'),
(98, 68, 12, 1, 19, 1, 14999, 3, 44997, 'no', NULL, 'DSFAD', 'installation_queue', NULL, '2025-11-02 06:34:12', '2025-11-02 06:34:12'),
(99, 68, 12, 2, 19, 1, 16999, 4, 67996, 'no', NULL, 'DSFAD', 'installation_queue', NULL, '2025-11-02 06:34:12', '2025-11-02 06:34:12'),
(100, 71, 12, 1, 21, 1, 14999, 1, 14999, 'no', 0.00, 'SFDDFS', 'installation_queue', '2025-11-04 06:34:05', '2025-11-04 06:32:53', '2025-11-04 06:34:05'),
(101, 71, 12, 1, 21, 1, 14999, 1, 14999, 'no', NULL, 'nj hn', 'installation_queue', NULL, '2025-11-04 06:34:05', '2025-11-04 06:34:05'),
(102, 72, 12, 1, 22, 1, 14999, 1, 14999, 'no', 0.00, 'SDASAds', 'installation_queue', NULL, '2025-11-04 09:17:55', '2025-11-04 09:17:55'),
(103, 73, 12, 1, 23, 1, 14999, 1, 14999, 'no', 0.00, 'DSA', 'installation_queue', NULL, '2025-11-04 09:26:47', '2025-11-04 09:26:47'),
(104, 74, 12, 1, 24, 1, 14999, 1, 14999, 'no', 0.00, 'SASAD', 'installation_queue', NULL, '2025-11-04 09:39:52', '2025-11-04 09:39:52'),
(105, 75, 12, 1, 25, 1, 14999, 1, 14999, 'no', 0.00, 'sdfgdf', 'installation_queue', '2025-11-07 11:19:13', '2025-11-07 11:13:50', '2025-11-07 11:19:13'),
(106, 75, 12, 1, 25, 1, 14999, 1, 14999, 'no', NULL, 'wff', 'installation_queue', NULL, '2025-11-07 11:19:13', '2025-11-07 11:19:13'),
(107, 69, 12, 1, 26, 1, 512, 537, 274944, 'no', 0.00, 'Tempora molestiae do', 'installation_queue', NULL, '2025-11-07 11:33:10', '2025-11-07 11:33:10'),
(108, 76, 12, 1, 1, 1, 14999, 1, 14999, 'no', 0.00, 'njhgbn', 'installation_queue', '2025-11-09 06:36:39', '2025-11-09 06:35:44', '2025-11-09 06:36:39'),
(109, 76, 12, 1, 1, 1, 14999, 1, 14999, 'no', NULL, '.hgtfrgyhjkl', 'installation_queue', NULL, '2025-11-09 06:36:39', '2025-11-09 06:36:39'),
(110, 77, 12, 1, 2, 1, 14999, 1, 14999, 'no', 0.00, 'Qui excepturi sit cu', 'installation_queue', '2025-11-11 06:27:45', '2025-11-09 10:33:30', '2025-11-11 06:27:45'),
(111, 79, 12, 1, 3, 1, 14999, 1, 14999, 'no', 0.00, 'Qui vero exercitatio', 'installation_queue', NULL, '2025-11-10 07:02:31', '2025-11-10 07:02:31'),
(112, 77, 12, 1, 2, 1, 14999, 1, 14999, 'no', NULL, 'sfdsdf', 'installation_queue', NULL, '2025-11-11 06:27:45', '2025-11-11 06:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tickets`
--

CREATE TABLE `customer_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amc_customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `landline` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `install_date` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `support_type` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `amc` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `assign_to` varchar(255) DEFAULT NULL,
  `prdouct_name` varchar(255) DEFAULT NULL,
  `service_charge` decimal(10,2) DEFAULT 0.00,
  `amount` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `due_amount` decimal(10,2) DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `payment_status` enum('unpaid','paid') DEFAULT 'unpaid',
  `payment_method` enum('cash','online','cheque','multiple') DEFAULT NULL,
  `cash_amount` decimal(10,2) DEFAULT 0.00,
  `cash_receipt` varchar(255) DEFAULT NULL,
  `online_amount` decimal(10,2) DEFAULT 0.00,
  `online_receipt` varchar(255) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT 0.00,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_receipt` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_tickets`
--

INSERT INTO `customer_tickets` (`id`, `customer_id`, `amc_customer_id`, `user_name`, `customer_name`, `contact`, `landline`, `address`, `email`, `branch_id`, `install_date`, `type`, `support_type`, `service_type`, `priority`, `amc`, `warranty`, `assign_to`, `prdouct_name`, `service_charge`, `amount`, `total_amount`, `paid_amount`, `due_amount`, `payment_date`, `payment_status`, `payment_method`, `cash_amount`, `cash_receipt`, `online_amount`, `online_receipt`, `cheque_amount`, `cheque_number`, `cheque_receipt`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'DHNSERENAMCCULLOUGH', 'Serena Mccullough', '1336252300', '1829514929', 'Nisi qui eaque quaer', 'dixotyji@mailinator.com', 12, '2025-11-19', 'amc', 'normal_service', 'free', 'high', 'in', 'out', '17', NULL, NULL, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'free', 'complete', '2025-11-19 05:29:20', '2025-11-19 06:17:04'),
(2, 2, 2, 'DHNJOELHOPPER1', 'Joel Hopper', '1795735422', '1932964831', 'Libero vero repellen', 'Cijywewine@mailinator.com', 12, '2025-11-19', 'amc', 'location_shifting', 'paid', 'low', 'in', 'in', '16', NULL, 4500.00, 550.00, 5050.00, 0.00, 5050.00, NULL, 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfddfg', 'complete', '2025-11-19 05:32:29', '2025-11-19 05:53:45'),
(3, NULL, NULL, 'DHNBOBEEN', 'Bobeen', '5455465654', NULL, 'Sdfrdfgdfgfd', 'Ganeshkunwarnp2003@gmail.com', 12, '2025-11-20', 'outsider', 'maintenance', 'free', 'high', 'out', 'out', '17', NULL, 0.00, 250.00, 250.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gfghfh', 'complete', '2025-11-19 11:13:56', '2025-11-20 09:11:06'),
(4, 2, NULL, 'DHNJOELHOPPER1', 'Joel Hopper', '1795735422', '1932964831', 'Libero vero repellen', 'Cijywewine@mailinator.com', 12, '2025-11-19', 'register', 'normal_service', 'paid', 'high', 'in', 'in', '17', NULL, 1000.00, 2000.00, 3000.00, 3000.00, 0.00, NULL, 'paid', 'online', NULL, NULL, 3000.00, 'LOGO.png', NULL, NULL, NULL, 'hfufyu', 'complete', '2025-11-19 11:18:37', '2025-11-19 11:26:10'),
(5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'register', 'maintenance', NULL, 'high', 'in', 'in', '21', NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, NULL, 'AAJH HAMI AAUDAINAN', 'assign', '2025-11-20 04:53:52', '2025-11-20 07:12:59'),
(6, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'amc', 'normal_service', NULL, 'medium', 'in', 'in', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'unpaid', NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, NULL, 'sdfg', 'queue', '2025-11-20 05:04:12', '2025-11-20 05:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer_ticket_accessories`
--

CREATE TABLE `customer_ticket_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `accessory_qty` int(11) NOT NULL,
  `accessory_price` int(11) NOT NULL,
  `accessory_total` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_ticket_accessories`
--

INSERT INTO `customer_ticket_accessories` (`id`, `ticket_id`, `branch_id`, `accessory_id`, `customer_id`, `created_by`, `accessory_qty`, `accessory_price`, `accessory_total`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(29, 3, 12, 1, 3, 1, 1, 250, 250, NULL, NULL, '2025-11-20 09:11:06', '2025-11-20 09:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `customer_ticket_payments`
--

CREATE TABLE `customer_ticket_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `cash_amount` int(11) DEFAULT NULL,
  `cash_receipt` varchar(255) DEFAULT NULL,
  `online_amount` int(11) DEFAULT NULL,
  `online_receipt` varchar(255) DEFAULT NULL,
  `cheque_amount` int(11) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_receipt` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposite_amounts`
--

CREATE TABLE `deposite_amounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'deposited',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposite_amounts`
--

INSERT INTO `deposite_amounts` (`id`, `amount`, `bank_name`, `image`, `date`, `status`, `created_at`, `updated_at`) VALUES
(3, 3000.00, 'A', '1750580262.jpg', '2025-06-22', 'deposited', '2025-06-22 08:32:42', '2025-06-22 08:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `device_purchases`
--

CREATE TABLE `device_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_purchase_accessories`
--

CREATE TABLE `device_purchase_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_purchase_machineries`
--

CREATE TABLE `device_purchase_machineries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `machinery_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emis`
--

CREATE TABLE `emis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in months',
  `interest_rate` decimal(5,2) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emi_customers`
--

CREATE TABLE `emi_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `emi_plan_id` bigint(20) UNSIGNED NOT NULL,
  `down_payment` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `monthly_pay` decimal(10,2) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emi_payments`
--

CREATE TABLE `emi_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emi_customers_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emi_systems`
--

CREATE TABLE `emi_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `downpayment_percentage` varchar(255) NOT NULL,
  `interest_rate` varchar(255) NOT NULL,
  `duration_month` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `company_doj` varchar(255) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_advance_pays`
--

CREATE TABLE `employee_advance_pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` longtext DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_allowances`
--

CREATE TABLE `employee_allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `type` enum('fixed','percentage') NOT NULL DEFAULT 'fixed',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendances`
--

CREATE TABLE `employee_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance_requests`
--

CREATE TABLE `employee_attendance_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `request_type` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_commissions`
--

CREATE TABLE `employee_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `type` enum('fixed','percentage') NOT NULL DEFAULT 'fixed',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_funds`
--

CREATE TABLE `employee_funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `month` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_loans`
--

CREATE TABLE `employee_loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_payslips`
--

CREATE TABLE `employee_payslips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `month` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance_pay` varchar(255) DEFAULT NULL,
  `sales_insentive` varchar(255) DEFAULT NULL,
  `service_insentive` varchar(255) DEFAULT NULL,
  `allowance` varchar(255) DEFAULT NULL,
  `fund` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_salaries`
--

CREATE TABLE `employee_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_sale_insentives`
--

CREATE TABLE `employee_sale_insentives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `insentive_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'fixed',
  `date` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_services`
--

CREATE TABLE `employee_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE `exchanges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exchanges`
--

INSERT INTO `exchanges` (`id`, `lead_id`, `branch_id`, `customer_id`, `item_name`, `item_amount`, `created_at`, `updated_at`) VALUES
(1, 36, 12, 2, 'Preee Filteerrr', 1999.00, '2025-10-26 04:12:02', '2025-10-26 04:12:02'),
(2, 45, 12, 1, 'Preee Filteerrr', 5000.00, '2025-10-28 15:13:43', '2025-10-28 15:13:43'),
(3, 70, 12, 20, 'VFSVSFSF', 5000.00, '2025-11-02 05:04:36', '2025-11-02 05:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `mode` varchar(255) NOT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_category_id`, `title`, `amount`, `date`, `mode`, `branch_id`, `created_by`, `description`, `receipt`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(32, 1, 'FGFSD', '3000', '2025-11-02', 'petty cash', '12', '1', 'DFSFV', '', 'on', NULL, '2025-11-02 07:35:50', '2025-11-02 07:35:50'),
(33, 5, 'HBSDHVHF', '2000', '2025-11-02', 'petty cash', '12', '1', 'KDHCYUDCBN', '', 'on', NULL, '2025-11-02 07:36:17', '2025-11-02 07:36:17'),
(34, 5, 'Et nihil est molesti', 'Dicta minim occaecat', '2025-11-04', 'petty cash', '12', '1', 'Et doloribus dolorum', '', 'on', NULL, '2025-11-04 04:03:42', '2025-11-04 04:03:42'),
(35, 1, 'Nostrum eum ad quibu', '1000', '2025-12-04', 'petty cash', '12', '1', 'Quod nisi eu elit s', '', 'on', NULL, '2025-11-04 04:04:39', '2025-11-04 04:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `title`, `slug`, `image`, `branch_id`, `created_by`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sit et totam asperi', 'sit-et-totam-asperi', '1734933375.png', '12', '1', 'Laborum Quis nobis', 'on', NULL, '2024-12-19 15:25:21', '2025-06-08 10:50:12'),
(3, 'Praesentium dolorem', 'praesentium-dolorem', '1734622354.png', '12', '1', 'Perspiciatis possim', 'off', NULL, '2024-12-19 15:32:34', '2025-06-07 08:18:52'),
(4, 'Mollitia nemo quae e', 'mollitia-nemo-quae-e', '1734930272.webp', '12', '1', 'Ea incididunt quia sit.', 'on', NULL, '2024-12-23 05:04:32', '2024-12-23 05:04:32'),
(5, 'Office Rent', 'office-rent', '', '12', '1', NULL, 'on', NULL, '2025-06-10 09:52:18', '2025-06-10 09:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `status`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'सरभिस साथी के हो?', 'on', '<div style=\"line-height: 19px;\"><div style=\"\">सरभिस साथी एक घरेलु सरभिस प्रदायक हो जसले प्लम्बिङ, बिद्युत मर्मत,</div><div style=\"\">                                        एसी मर्मत, सुताइ, फर्निचर मर्मत, र घर सफाई जस्ता विभिन्न प्रकारका सेवाहरू प्रदान</div><div style=\"\">                                        गर्दछ।</div></div>', '2023-03-20 00:53:19', '2024-07-29 01:03:47'),
(3, 'सरभिस साथीको शुल्क कस्तो हुन्छ ?', 'on', '<div style=\"line-height: 19px;\"><div style=\"\">सरभिस साथीको शुल्क सरभिस प्रकार, कामको परिमाण, र स्थान अनुसार</div><div style=\"\">                                        फरक-फरक हुन सक्छ। विस्तृत जानकारीको लागि, तपाईँले सरभिस साथीको वेबसाइट वा ग्राहक</div><div style=\"\">                                        सरभिस सम्पर्क गर्न सक्नुहुन्छ।</div></div>', '2024-07-28 23:25:55', '2024-07-29 01:04:35'),
(4, 'सरभिस साथीको सरभिस कसरी बुक गर्न सकिन्छ?', 'on', '<div style=\"line-height: 19px;\"><div style=\"\">तपाईँ सरभिस साथीको सरभिस अनलाइन मार्फत बुक गर्न सक्नुहुन्छ। सरभिस</div><div style=\"\">                                        साथीको वेबसाइटमा जानुहोस् र आफूलाई आवश्यक सरभिस चयन गरी बुकिङ प्रक्रिया पूरा</div><div style=\"\">                                        गर्नुहोस्। साथै, तपाईँ फोन मार्फत पनि सरभिस बुक गर्न सक्नुहुन्छ।</div></div>', '2024-07-29 00:05:46', '2024-07-29 01:04:59'),
(5, 'सरभिस साथीलाई कामपछि कसरी भुक्तान गर्नुपर्छ ?', 'on', '<div style=\"line-height: 19px;\"><div style=\"\">काम पूरा भएपछि भुक्तान गर्दा, पहिलो चरणमा कामको सन्तोषजनक निरीक्षण</div><div style=\"\">                                        गर्नुहोस् र सेवा साथीबाट एक विस्तृत चालान प्राप्त गर्नुहोस्।</div><div style=\"\">                                        भुक्तान नगद, चेक, क्रेडिट/डेबिट कार्ड, वा बैंक ट्रान्सफर मार्फत गर्न सकिन्छ।</div></div>', '2024-07-29 01:05:24', '2024-07-29 01:05:24'),
(6, 'सरभिस साथीका प्राविधिकहरू कति समयमा आइपुग्छन् ?', 'on', '<div style=\"line-height: 19px;\"><div style=\"\"> सरभिस साथीका प्राविधिकहरू प्रायः बुकिङ गरेको समय अनुसार २ घण्टा</div><div style=\"\">                                        भित्र आइपुग्छन्। आपतकालीन सेवाहरूका लागि तुरुन्त सरभिस उपलब्ध गराउन सकिन्छ।</div></div>', '2024-07-29 01:05:52', '2024-07-29 01:05:52'),
(7, 'के सरभिस साथीको सबै सेवाहरूमा ग्यारेन्टी उपलब्ध हुन्छ??', 'on', '<div style=\"line-height: 19px;\"><div style=\"\">हो, सरभिस साथीले सबै सेवाहरूमा गुणस्तरीय कामको ग्यारेन्टी प्रदान</div><div style=\"\">                                        गर्दछ। यदि तपाईँलाई कुनै पनि समस्या भएमा, सरभिस साथी तुरुन्त समाधान गर्न प्रतिबद्ध</div><div style=\"\">                                        छ।</div></div>', '2024-07-29 01:06:15', '2024-07-29 01:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machinery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `accessory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `opening_quantity` int(11) NOT NULL DEFAULT 0,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `landline` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` longtext NOT NULL,
  `message` longtext DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `lead_source` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `sales_type` varchar(255) DEFAULT NULL,
  `installation_category` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `lead_type` varchar(255) NOT NULL DEFAULT 'cold',
  `followups` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'non_convert',
  `is_refere` varchar(255) DEFAULT NULL,
  `refer_by` varchar(255) DEFAULT NULL,
  `refer_contact` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `mobile`, `landline`, `email`, `address`, `message`, `branch_id`, `lead_source`, `staff_id`, `sales_type`, `installation_category`, `created_by`, `lead_type`, `followups`, `status`, `is_refere`, `refer_by`, `refer_contact`, `deleted_at`, `created_at`, `updated_at`) VALUES
(60, 'Sudip chaudhary', '5897832035', '5879523455', 'Sasjfjkdf@gmail.com', 'Thrtytryryrtytr', 'ertetweewtewtewet', '12', 'counter', NULL, NULL, 'retailler', '1', 'hot', '2025-01-09 05:23:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-30 10:24:48', '2025-10-30 11:49:08'),
(61, 'Nabin Thapa', '0224586666', '5452000366', 'dfdgdg@gmail.com', 'Sukhanagar', 'dgdrfgdgsdgssfsd', '12', 'instagram', NULL, NULL, 'retailler', '1', 'hot', '2025-01-09 05:23:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-30 10:55:26', '2025-10-30 12:25:51'),
(62, 'Althea Hewitt', '1348255116', '1435232940', 'netyq@mailinator.com', 'Nostrud eaque sit cu', 'Aliquip a temporibus', NULL, 'whatsapp', NULL, 'wholeseller', 'commercial', '1', 'hot', '1970-01-19 00:00:00', 'non_convert', NULL, NULL, NULL, NULL, '2025-10-30 12:21:22', '2025-10-30 12:21:22'),
(63, 'Ddssgsd', '8995256330', '2578452120', 'Fgdhdhdhyxbzbab@gmail.com', 'Sukhanagar', 'xsdfsddddddddddddddddd', '12', 'facebook', NULL, NULL, 'retailler', '1', 'hot', '2025-01-09 05:23:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-30 13:07:20', '2025-10-31 11:20:00'),
(64, 'basu bhusal', '2587413690', '5989001458', 'bhusalhsjd@gmail.com', 'Sukhanagar', 'dffffffffffffsg', '14', 'staff', '23', NULL, 'retailler', '1', 'hot', '2025-01-09 05:23:00', 'convert', 'staff', NULL, NULL, NULL, '2025-10-31 11:07:29', '2025-10-31 11:12:41'),
(65, 'sanjaya thapa', '2587922222', '0025548996', 'jhasdbs@gmail.com', 'dffgdfgdf', 'fgggggggggggggg', '14', 'instagram', NULL, NULL, 'retailler', '1', 'hot', '2025-01-09 05:23:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-31 11:32:09', '2025-10-31 11:51:58'),
(67, 'Nabin Thapa', '2579523333', '0226789999', 'hjfshdfs@gmail.com', 'Sukhanagar', 'sdgdfggggggggggggd', '14', 'whatsapp', NULL, NULL, 'retailler', '1', 'hot', '2025-01-09 05:23:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-31 12:15:46', '2025-10-31 12:16:45'),
(68, 'Kaden Matthews', '1515495355', '1168571932', 'Solylaqeb@mailinator.com', 'Exercitation exceptu', 'Id in eveniet et co', '12', 'facebook', NULL, 'wholeseller', 'commercial', '1', 'hot', '2013-02-20 00:00:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-31 12:08:50', '2025-11-02 06:25:56'),
(69, 'Halla Reilly', '1334789899', '1308406150', 'kacosymis@mailinator.com', 'Fugit suscipit aut', 'Consequatur minima e', '12', 'facebook', NULL, 'counter_sales', 'retailler', '1', 'hot', '2025-10-31 17:57:00', 'convert', NULL, NULL, NULL, NULL, '2025-10-31 12:12:52', '2025-11-07 11:33:10'),
(70, 'Hamish Bartlett', '1493192680', '1262151632', 'Nyheba@mailinator.com', 'Qui eum ut corrupti', 'Mollit unde maiores', '12', 'counter', NULL, 'retailler', 'retailler', '1', 'hot', '2016-08-20 00:00:00', 'convert', NULL, NULL, NULL, NULL, '2025-11-02 05:02:06', '2025-11-02 05:12:53'),
(71, 'Darryl Galloway', '1126651646', '1978738840', NULL, 'Vel minim voluptatem', 'Commodo reprehenderi', '12', 'staff', '23', 'retailler', 'retailler', '1', 'hot', '2025-07-06 13:10:00', 'convert', NULL, NULL, NULL, NULL, '2025-11-02 05:16:28', '2025-11-04 06:32:53'),
(72, 'bobeen', '1559831227', '1942347130', 'hyvepahucu@mailinator.com', 'Autem fuga Ab dolor', 'Est ex magnam inven', '12', 'staff', '16', 'retailler', 'industrial', '1', 'hot', '2025-07-06 13:10:00', 'convert', 'staff', NULL, NULL, NULL, '2025-11-04 08:39:48', '2025-11-04 09:17:55'),
(73, 'Arjit', '1496517448', '1538764278', 'qupog@mailinator.com', 'Exercitationem atque', 'Consequuntur rem pra', '12', 'customer', NULL, 'wholeseller', 'commercial', '1', 'hot', '2025-07-06 13:10:00', 'convert', 'customer', '19', NULL, NULL, '2025-11-04 08:40:46', '2025-11-04 09:26:47'),
(74, 'Janna Walton', '1654587657', '1398116859', 'rojyca@mailinator.com', 'Achham, Chaurpati', 'Dolores anim repudia', '12', 'customer', NULL, 'counter_sales', 'retailler', '1', 'hot', '2025-07-06 13:10:00', 'convert', 'manual', 'Ganesh Bahadur Kunwar', '9761109545', NULL, '2025-11-04 08:41:18', '2025-11-04 09:39:52'),
(75, 'Vanna Leonard', '1747222922', '1649692789', 'Kohyjaf@mailinator.com', 'Culpa sit et Nam pr', 'Necessitatibus aliqu', '12', 'counter', NULL, 'wholeseller', 'commercial', '1', 'hot', '1988-08-19 00:00:00', 'convert', NULL, NULL, NULL, NULL, '2025-11-05 05:03:02', '2025-11-07 11:19:13'),
(76, 'Akeem Gates', '1335245651', '1458964624', 'Lylukimym@mailinator.com', 'Aut quisquam accusan', 'Ut fuga Optio recu', '12', 'counter', NULL, 'counter_sales', 'industrial', '1', 'hot', '2025-07-06 13:10:00', 'convert', NULL, NULL, NULL, NULL, '2025-11-09 06:35:16', '2025-11-09 06:36:39'),
(77, 'Joel Hopper', '1795735422', '1932964831', 'Cijywewine@mailinator.com', 'Libero vero repellen', 'Dolorem nihil culpa', '12', 'whatsapp', NULL, 'counter_sales', 'commercial', '1', 'hot', '1996-10-19 00:00:00', 'convert', NULL, NULL, NULL, NULL, '2025-11-09 10:32:55', '2025-11-11 06:27:45'),
(78, 'Priscilla Meyers', '1231365357', '1224305454', 'xipyhy@mailinator.com', 'Quo unde omnis repel', 'Aliquam in molestiae', '12', 'counter', NULL, 'wholeseller', 'commercial', '1', 'hot', '2025-07-06 13:10:00', 'non_convert', NULL, NULL, NULL, NULL, '2025-11-09 10:53:55', '2025-11-09 10:53:55'),
(79, 'Nichole Cantu', '1425589705', '1704109753', 'Cymexag@mailinator.com', 'Eum et molestiae exc', 'Voluptatum blanditii', '12', 'whatsapp', NULL, 'wholeseller', 'retailler', '1', 'hot', '1982-05-19 00:00:00', 'convert', NULL, NULL, NULL, NULL, '2025-11-10 07:01:49', '2025-11-11 04:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `lead_responses`
--

CREATE TABLE `lead_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` varchar(255) NOT NULL,
  `followups` datetime DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_responses`
--

INSERT INTO `lead_responses` (`id`, `lead_id`, `followups`, `branch_id`, `created_by`, `message`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(50, '19', '2025-07-06 13:10:00', '12', '1', 'DDAD', 'on', NULL, '2025-10-16 10:09:58', '2025-10-16 10:09:58'),
(51, '20', '2025-10-16 16:01:00', '12', '1', 'SFS', 'on', NULL, '2025-10-16 10:16:21', '2025-10-16 10:16:21'),
(52, '21', '2025-10-16 16:20:00', '12', '1', 'Aspernatur similique', 'on', NULL, '2025-10-16 10:35:38', '2025-10-16 10:35:38'),
(53, '22', '2003-12-20 00:00:00', '12', '1', 'Esse nisi mollit omn', 'on', NULL, '2025-10-16 11:29:28', '2025-10-16 11:29:28'),
(54, '23', '2025-10-16 17:57:00', '12', '1', 'Retail Installation category', 'on', NULL, '2025-10-16 12:12:49', '2025-10-16 12:12:49'),
(55, '24', '2013-01-20 00:00:00', '12', '1', 'Ad enim enim ducimus', 'on', NULL, '2025-10-16 12:28:41', '2025-10-16 12:28:41'),
(56, '25', '2012-11-20 00:00:00', '12', '1', 'Ullamco cupidatat cu', 'on', NULL, '2025-10-17 04:00:08', '2025-10-17 04:00:08'),
(57, '26', '2025-10-17 10:16:00', '12', '1', 'Odit sed aliquid aut', 'on', NULL, '2025-10-17 04:31:22', '2025-10-17 04:31:22'),
(58, '27', '2025-07-06 13:10:00', '12', '1', 'FDSFDXSA', 'on', NULL, '2025-10-17 07:34:58', '2025-10-17 07:34:58'),
(59, '29', '2024-08-20 00:00:00', '12', '1', 'Dignissimos eos offi', 'on', NULL, '2025-10-17 10:08:17', '2025-10-17 10:08:17'),
(60, '30', '2015-01-20 00:00:00', '12', '1', 'Veritatis ex do quid', 'on', NULL, '2025-10-17 10:26:25', '2025-10-17 10:26:25'),
(61, '31', '2008-03-20 00:00:00', '12', '1', 'Aliquam atque sit n', 'on', NULL, '2025-10-19 05:17:30', '2025-10-19 05:17:30'),
(62, '32', '2025-07-06 13:10:00', '12', '1', 'Iusto exercitation v', 'on', NULL, '2025-10-19 05:18:03', '2025-10-19 05:18:03'),
(63, '33', '2025-07-06 17:10:00', '12', '1', 'Et anim debitis anim', 'on', NULL, '2025-10-19 05:18:46', '2025-10-19 05:18:46'),
(64, '34', '2025-10-19 11:56:00', '12', '1', 'Magnam nisi saepe qu', 'on', NULL, '2025-10-19 06:11:49', '2025-10-19 06:11:49'),
(65, '35', '2008-12-20 00:00:00', '12', '1', 'Quae autem tempor au', 'on', NULL, '2025-10-22 08:09:00', '2025-10-22 08:09:00'),
(66, '36', '2025-07-06 13:10:00', '12', '1', 'Minima vel velit ven', 'on', NULL, '2025-10-26 04:02:58', '2025-10-26 04:02:58'),
(67, '37', '2025-01-09 05:23:00', '15', '1', 'edwdqwd', 'on', NULL, '2025-10-26 09:38:40', '2025-10-26 09:38:40'),
(68, '38', '2025-07-06 13:10:00', '12', '1', 'jkhfuydvyu', 'on', NULL, '2025-10-26 12:47:18', '2025-10-26 12:47:18'),
(69, '39', '2025-07-06 13:10:00', '12', '1', 'Est nostrud eos eo', 'on', NULL, '2025-10-26 13:23:07', '2025-10-26 13:23:07'),
(70, '40', '2025-01-09 05:23:00', '12', '1', 'greterteert', 'on', NULL, '2025-10-26 13:33:26', '2025-10-26 13:33:26'),
(71, '41', '2025-07-06 13:10:00', '12', '1', 'Qui facilis fugiat l', 'on', NULL, '2025-10-26 14:19:42', '2025-10-26 14:19:42'),
(72, '42', '2025-01-09 05:23:00', '12', '1', 'efweewerwe', 'on', NULL, '2025-10-27 08:14:08', '2025-10-27 08:14:08'),
(73, '43', '2025-01-09 05:23:00', '12', '1', 'edsfsadfsdfdgfd', 'on', NULL, '2025-10-27 08:21:03', '2025-10-27 08:21:03'),
(74, '44', '2025-01-09 05:23:00', '12', '1', 'fhjhghg', 'on', NULL, '2025-10-27 08:39:18', '2025-10-27 08:39:18'),
(75, '45', '2025-07-06 13:10:00', '12', '1', 'Pariatur At enim ad', 'on', NULL, '2025-10-28 15:09:58', '2025-10-28 15:09:58'),
(76, '46', '2025-01-09 05:23:00', '15', '1', 'tyyyrrrrrrr', 'on', NULL, '2025-10-29 05:53:40', '2025-10-29 05:53:40'),
(77, '48', '2025-01-09 05:23:00', '16', '1', 'rgdddddddddddddddd', 'on', NULL, '2025-10-29 10:18:13', '2025-10-29 10:18:13'),
(78, '51', '2025-01-09 05:23:00', '16', '1', '55yyyyyyyyyyyyyyyyyy', 'on', NULL, '2025-10-29 10:33:25', '2025-10-29 10:33:25'),
(79, '52', '2025-01-09 05:23:00', '16', '1', 'fdgddddddf', 'on', NULL, '2025-10-29 10:49:19', '2025-10-29 10:49:19'),
(80, '54', '2025-01-09 05:23:00', '16', '1', 'ddferfefer', 'on', NULL, '2025-10-29 10:59:26', '2025-10-29 10:59:26'),
(81, '55', '2025-01-09 05:23:00', '16', '1', 'ythrturturturtur', 'on', NULL, '2025-10-29 11:01:25', '2025-10-29 11:01:25'),
(82, '56', '2025-07-06 13:10:00', '12', '1', 'Magna aperiam qui co', 'on', NULL, '2025-10-29 12:08:51', '2025-10-29 12:08:51'),
(83, '57', '2025-01-09 05:23:00', '12', '1', 'sfweseretertert', 'on', NULL, '2025-10-29 18:35:11', '2025-10-29 18:35:11'),
(84, '58', '2025-01-09 05:23:00', '12', '1', 'kdhsdukhaskjasa', 'on', NULL, '2025-10-30 08:58:44', '2025-10-30 08:58:44'),
(85, '59', '1982-04-19 00:00:00', '12', '1', 'Consequuntur eum qui', 'on', NULL, '2025-10-30 10:05:27', '2025-10-30 10:05:27'),
(86, '60', '2025-01-09 05:23:00', '12', '1', 'ertetweewtewtewet', 'on', NULL, '2025-10-30 10:24:48', '2025-10-30 10:24:48'),
(87, '61', '2025-01-09 05:23:00', '12', '1', 'dgdrfgdgsdgssfsd', 'on', NULL, '2025-10-30 10:55:26', '2025-10-30 10:55:26'),
(88, '62', '1970-01-19 00:00:00', NULL, '1', 'Aliquip a temporibus', 'on', NULL, '2025-10-30 12:21:22', '2025-10-30 12:21:22'),
(89, '63', '2025-01-09 05:23:00', '12', '1', 'xsdfsddddddddddddddddd', 'on', NULL, '2025-10-30 13:07:20', '2025-10-30 13:07:20'),
(90, '64', '2025-01-09 05:23:00', '14', '1', 'dffffffffffffsg', 'on', NULL, '2025-10-31 11:07:29', '2025-10-31 11:07:29'),
(91, '65', '2025-01-09 05:23:00', '14', '1', 'fgggggggggggggg', 'on', NULL, '2025-10-31 11:32:09', '2025-10-31 11:32:09'),
(92, '67', '2025-01-09 05:23:00', '14', '1', 'sdgdfggggggggggggd', 'on', NULL, '2025-10-31 12:15:46', '2025-10-31 12:15:46'),
(93, '68', '2013-02-20 00:00:00', '12', '1', 'Id in eveniet et co', 'on', NULL, '2025-10-31 12:08:51', '2025-10-31 12:08:51'),
(94, '69', '2025-10-31 17:57:00', '12', '1', 'Consequatur minima e', 'on', NULL, '2025-10-31 12:12:52', '2025-10-31 12:12:52'),
(95, '70', '2016-08-20 00:00:00', '12', '1', 'Mollit unde maiores', 'on', NULL, '2025-11-02 05:02:06', '2025-11-02 05:02:06'),
(96, '71', '2025-07-06 13:10:00', '12', '1', 'Commodo reprehenderi', 'on', NULL, '2025-11-02 05:16:28', '2025-11-02 05:16:28'),
(97, '72', '2025-07-06 13:10:00', '12', '1', 'Est ex magnam inven', 'on', NULL, '2025-11-04 08:39:48', '2025-11-04 08:39:48'),
(98, '73', '2025-07-06 13:10:00', '12', '1', 'Consequuntur rem pra', 'on', NULL, '2025-11-04 08:40:46', '2025-11-04 08:40:46'),
(99, '74', '2025-07-06 13:10:00', '12', '1', 'Dolores anim repudia', 'on', NULL, '2025-11-04 08:41:18', '2025-11-04 08:41:18'),
(100, '75', '1988-08-19 00:00:00', '12', '1', 'Necessitatibus aliqu', 'on', NULL, '2025-11-05 05:03:02', '2025-11-05 05:03:02'),
(101, '76', '2025-07-06 13:10:00', '12', '1', 'Ut fuga Optio recu', 'on', NULL, '2025-11-09 06:35:16', '2025-11-09 06:35:16'),
(102, '77', '1996-10-19 00:00:00', '12', '1', 'Dolorem nihil culpa', 'on', NULL, '2025-11-09 10:32:56', '2025-11-09 10:32:56'),
(103, '78', '2025-07-06 13:10:00', '12', '1', 'Aliquam in molestiae', 'on', NULL, '2025-11-09 10:53:55', '2025-11-09 10:53:55'),
(104, '79', '1982-05-19 00:00:00', '12', '1', 'Voluptatum blanditii', 'on', NULL, '2025-11-10 07:01:49', '2025-11-10 07:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `message` text DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `title`, `employee_id`, `leave_type_id`, `branch_id`, `start_date`, `end_date`, `message`, `approved_by`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'hjgvhgvh', 1, 1, 1, '2024-12-31', '2024-12-31', NULL, NULL, 'accept', NULL, '2024-12-31 12:51:37', '2025-01-01 06:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration_type` varchar(255) NOT NULL,
  `leaves` varchar(255) NOT NULL DEFAULT '0',
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `title`, `duration_type`, `leaves`, `branch_id`, `created_by`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sick Leaves', 'yearly', '10', '12', '1', 'this is test', 'on', NULL, '2024-12-30 08:29:46', '2024-12-31 03:39:29');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `perform` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `log_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `branch_id`, `perform`, `url`, `log_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 'Super AdminAdded Petty cash2025-09-16 12:22:14', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-09-16 06:37:14', '2025-09-16 06:37:14'),
(2, 24, 15, 'Sandesh Bogati Petty cash Requested 2025-09-16 14:51:06', 'http://127.0.0.1:8000/pettycash-request', NULL, NULL, '2025-09-16 09:06:06', '2025-09-16 09:06:06'),
(3, 24, 15, 'Sandesh Bogati Petty cash Requested 2025-09-17 17:51:24', 'http://127.0.0.1:8000/pettycash-request', NULL, NULL, '2025-09-17 12:06:24', '2025-09-17 12:06:24'),
(4, 1, 15, 'Super Admin ServiceCategory Create: Tgg at 2025-09-23 08:41:56', 'http://127.0.0.1:8000/services_category', NULL, NULL, '2025-09-23 02:56:56', '2025-09-23 02:56:56'),
(5, 20, 13, 'ASDFG Petty cash Requested 2025-09-25 16:48:20', 'http://127.0.0.1:8000/pettycash-request', NULL, NULL, '2025-09-25 11:03:20', '2025-09-25 11:03:20'),
(6, 1, 12, 'Super Admin Convert Lead to Client: Winifred Cabrera-hot Lead -classic_customer at 2025-09-25 16:51:05', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-09-25 11:06:05', '2025-09-25 11:06:05'),
(7, 1, 15, 'Super Admin created. hot lead: Julie West at 2025-09-25 18:08:33', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-09-25 12:23:33', '2025-09-25 12:23:33'),
(8, 1, 15, 'Super Admin Convert Lead to Client: Julie West-hot Lead -retailler at 2025-09-25 18:08:58', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-09-25 12:23:58', '2025-09-25 12:23:58'),
(9, 1, 13, 'Super Admin Convert Lead to Client: Sigourney Larsen-hot Lead -wholeseller at 2025-10-05 09:59:35', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-05 04:14:35', '2025-10-05 04:14:35'),
(10, 1, 13, 'Super Admin Assign Lead to : ASDFG at 2025-10-05 10:00:14', 'http://127.0.0.1:8000/installation-assignstore/9', NULL, NULL, '2025-10-05 04:15:14', '2025-10-05 04:15:14'),
(11, 1, 12, 'Super Admin created. hot lead: Abdul Barker at 2025-10-07 10:57:07', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 05:12:07', '2025-10-07 05:12:07'),
(12, 1, 12, 'Super Admin created. hot lead: Lana Richards at 2025-10-07 11:24:04', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 05:39:04', '2025-10-07 05:39:04'),
(13, 1, 12, 'Super Admin Convert Lead to Client: Lana Richards-hot Lead -classic_customer at 2025-10-07 11:24:32', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 05:39:32', '2025-10-07 05:39:32'),
(14, 1, 12, 'Super Admin created. hot lead: Branden Puckett at 2025-10-07 11:33:56', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 05:48:56', '2025-10-07 05:48:56'),
(15, 1, 12, 'Super Admin Convert Lead to Client: Branden Puckett-hot Lead -wholeseller at 2025-10-07 11:40:39', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 05:55:39', '2025-10-07 05:55:39'),
(16, 1, 12, 'Super Admin Assign Lead to : Ganesh Kunwar at 2025-10-07 11:55:44', 'http://127.0.0.1:8000/installation-assignstore/11', NULL, NULL, '2025-10-07 06:10:44', '2025-10-07 06:10:44'),
(17, 1, 12, 'Super Admin Convert Lead Into Client : Branden Puckettttt at 2025-10-07 12:18:18', 'http://127.0.0.1:8000/installation-store/11', NULL, NULL, '2025-10-07 06:33:18', '2025-10-07 06:33:18'),
(18, 1, 12, 'Super Admin created. hot lead: Hedy Burch at 2025-10-07 15:29:09', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 09:44:09', '2025-10-07 09:44:09'),
(19, 1, 12, 'Super Admin Convert Lead to Client: Hedy Burch-hot Lead -retailler at 2025-10-07 15:40:35', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 09:55:35', '2025-10-07 09:55:35'),
(20, 1, 12, 'Super Admin Convert Lead to Client: Hedy Burch-hot Lead -retailler at 2025-10-07 15:40:37', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 09:55:37', '2025-10-07 09:55:37'),
(21, 1, 12, 'Super Admin created. hot lead: Calista Goodwin at 2025-10-07 15:41:07', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 09:56:07', '2025-10-07 09:56:07'),
(22, 1, 12, 'Super Admin Convert Lead to Client: Calista Goodwin-hot Lead -retailler at 2025-10-07 15:41:48', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 09:56:48', '2025-10-07 09:56:48'),
(23, 1, 12, 'Super Admin created. hot lead: Linus David at 2025-10-07 15:43:57', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 09:58:57', '2025-10-07 09:58:57'),
(24, 1, 12, 'Super Admin Convert Lead to Client: Linus David-hot Lead -classic_customer at 2025-10-07 15:46:18', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 10:01:18', '2025-10-07 10:01:18'),
(25, 1, 12, 'Super Admin created. hot lead: Medge Rios at 2025-10-07 15:49:43', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 10:04:43', '2025-10-07 10:04:43'),
(26, 1, 12, 'Super Admin Convert Lead to Client: Medge Rios-hot Lead -wholeseller at 2025-10-07 15:50:09', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 10:05:09', '2025-10-07 10:05:09'),
(27, 1, 12, 'Super Admin created. hot lead: Ainsley Schroeder at 2025-10-07 15:52:23', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 10:07:23', '2025-10-07 10:07:23'),
(28, 1, 12, 'Super Admin Convert Lead to Client: Ainsley Schroeder-hot Lead -retailler at 2025-10-07 15:54:14', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 10:09:14', '2025-10-07 10:09:14'),
(29, 1, 12, 'Super Admin created. hot lead: Cameron Battle at 2025-10-07 16:07:56', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 10:22:56', '2025-10-07 10:22:56'),
(30, 1, 12, 'Super Admin Convert Lead to Client: Cameron Battle-hot Lead -classic_customer at 2025-10-07 16:09:26', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 10:24:26', '2025-10-07 10:24:26'),
(31, 1, 12, 'Super Admin created. hot lead: Mark Cline at 2025-10-07 16:17:25', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 10:32:25', '2025-10-07 10:32:25'),
(32, 1, 12, 'Super Admin Convert Lead to Client: Mark Cline-hot Lead -wholeseller at 2025-10-07 16:22:13', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 10:37:13', '2025-10-07 10:37:13'),
(33, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-07 16:23:11', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-10-07 10:38:11', '2025-10-07 10:38:11'),
(34, 1, 12, 'Super Admin Convert Lead Into Client : Mark Cline at 2025-10-07 16:26:11', 'http://127.0.0.1:8000/installation-store/1', NULL, NULL, '2025-10-07 10:41:11', '2025-10-07 10:41:11'),
(35, 1, 12, 'Super AdminCreate Branch :Achham at 2025-10-07 17:04:41', 'http://127.0.0.1:8000/branches', NULL, NULL, '2025-10-07 11:19:41', '2025-10-07 11:19:41'),
(36, 1, 12, 'Super Admin created. hot lead: Xerxes Thomas at 2025-10-07 17:06:31', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 11:21:31', '2025-10-07 11:21:31'),
(37, 1, 12, 'Super AdminUpdate Branch :Dhangadhi at 2025-10-07 17:28:13', 'http://127.0.0.1:8000/branches/12', NULL, NULL, '2025-10-07 11:43:13', '2025-10-07 11:43:13'),
(38, 1, 12, 'Super AdminUpdate Branch :Butwal Branch at 2025-10-07 17:28:38', 'http://127.0.0.1:8000/branches/13', NULL, NULL, '2025-10-07 11:43:38', '2025-10-07 11:43:38'),
(39, 1, 12, 'Super AdminUpdate Branch :Kathmandu at 2025-10-07 17:28:55', 'http://127.0.0.1:8000/branches/15', NULL, NULL, '2025-10-07 11:43:55', '2025-10-07 11:43:55'),
(40, 1, 13, 'Super Admin Convert Lead to Client: Xerxes Thomas-hot Lead -wholeseller at 2025-10-07 17:31:39', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 11:46:39', '2025-10-07 11:46:39'),
(41, 1, 13, 'Super Admin Assign Lead to : ASDFG at 2025-10-07 17:32:01', 'http://127.0.0.1:8000/installation-assignstore/2', NULL, NULL, '2025-10-07 11:47:01', '2025-10-07 11:47:01'),
(42, 1, 13, 'Super Admin Convert Lead Into Client : Xerxes Thomas at 2025-10-07 17:52:50', 'http://127.0.0.1:8000/installation-store/2', NULL, NULL, '2025-10-07 12:07:50', '2025-10-07 12:07:50'),
(43, 1, 13, 'Super Admin Assign Lead to : Rudra Thata at 2025-10-07 17:54:10', 'http://127.0.0.1:8000/installation-assignstore/2', NULL, NULL, '2025-10-07 12:09:10', '2025-10-07 12:09:10'),
(44, 1, 13, 'Super Admin Convert Lead Into Client : Xerxes Thomas at 2025-10-07 17:55:24', 'http://127.0.0.1:8000/installation-store/2', NULL, NULL, '2025-10-07 12:10:24', '2025-10-07 12:10:24'),
(45, 1, 13, 'Super Admin created. warm lead: Wyatt Hobbs at 2025-10-07 17:57:17', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-07 12:12:17', '2025-10-07 12:12:17'),
(46, 1, 13, 'Super Admin Convert Lead to Client: Wyatt Hobbs-warm Lead -retailler at 2025-10-07 17:57:55', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-07 12:12:55', '2025-10-07 12:12:55'),
(47, 1, 13, 'Super Admin Assign Lead to : Rudra Thata at 2025-10-07 17:58:05', 'http://127.0.0.1:8000/installation-assignstore/3', NULL, NULL, '2025-10-07 12:13:05', '2025-10-07 12:13:05'),
(48, 1, 13, 'Super Admin Convert Lead Into Client : Wyatt Hobbs at 2025-10-07 18:00:34', 'http://127.0.0.1:8000/installation-store/3', NULL, NULL, '2025-10-07 12:15:34', '2025-10-07 12:15:34'),
(49, 1, 13, 'Super Admin Convert Lead Into Client : Wyatt Hobbscc at 2025-10-07 18:03:51', 'http://127.0.0.1:8000/installation-store/3', NULL, NULL, '2025-10-07 12:18:51', '2025-10-07 12:18:51'),
(50, 1, 13, 'Super Admin Convert Lead Into Client : Wyatt Hobbscc at 2025-10-07 18:08:26', 'http://127.0.0.1:8000/installation-store/3', NULL, NULL, '2025-10-07 12:23:26', '2025-10-07 12:23:26'),
(51, 1, 12, 'Super Admin created. hot lead: Judah Pugh at 2025-10-08 14:41:05', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-08 08:56:05', '2025-10-08 08:56:05'),
(52, 1, 12, 'Super Admin Convert Lead to Client: Judah Pugh-hot Lead -wholeseller at 2025-10-08 14:43:05', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-08 08:58:05', '2025-10-08 08:58:05'),
(53, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-08 14:43:29', 'http://127.0.0.1:8000/installation-assignstore/4', NULL, NULL, '2025-10-08 08:58:29', '2025-10-08 08:58:29'),
(54, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-08 14:49:46', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-10-08 09:04:46', '2025-10-08 09:04:46'),
(55, 1, 12, 'Super Admin created. hot lead: Kessie Snyder at 2025-10-08 15:07:33', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-08 09:22:33', '2025-10-08 09:22:33'),
(56, 1, 12, 'Super Admin Convert Lead to Client: Kessie Snyder-hot Lead -classic_customer at 2025-10-08 15:07:58', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-08 09:22:58', '2025-10-08 09:22:58'),
(57, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-08 15:10:08', 'http://127.0.0.1:8000/installation-assignstore/5', NULL, NULL, '2025-10-08 09:25:08', '2025-10-08 09:25:08'),
(58, 1, 12, 'Super Admin Convert Lead Into Client : Kessie Snyder at 2025-10-08 15:22:38', 'http://127.0.0.1:8000/installation-store/5', NULL, NULL, '2025-10-08 09:37:38', '2025-10-08 09:37:38'),
(59, 1, 12, 'Super Admin updated user: Ganesh Kunwar (kunwarganesh20003@gmail.com) at 2025-10-09 13:45:31', 'http://127.0.0.1:8000/users/19', NULL, NULL, '2025-10-09 08:00:31', '2025-10-09 08:00:31'),
(60, 1, 15, 'Super Admin created. hot lead: Reed Burris at 2025-10-13 09:29:49', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 03:44:49', '2025-10-13 03:44:49'),
(61, 1, 15, 'Super Admin Convert Lead to Client: Reed Burris-hot Lead -counter_sales at 2025-10-13 09:34:04', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-13 03:49:04', '2025-10-13 03:49:04'),
(62, 1, 15, 'Super Admin Assign Lead to : Sandesh Bogati at 2025-10-13 09:36:53', 'http://127.0.0.1:8000/installation-assignstore/6', NULL, NULL, '2025-10-13 03:51:53', '2025-10-13 03:51:53'),
(63, 1, 15, 'Super Admin Convert Lead Into Client : Reed Burris at 2025-10-13 09:51:12', 'http://127.0.0.1:8000/installation-store/6', NULL, NULL, '2025-10-13 04:06:12', '2025-10-13 04:06:12'),
(64, 1, 15, 'Super Admin created. hot lead: Lee Barker at 2025-10-13 10:21:25', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 04:36:25', '2025-10-13 04:36:25'),
(65, 1, 15, 'Super Admin Convert Lead to Client: Iona Wong-hot Lead -counter_sales at 2025-10-13 10:21:51', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-13 04:36:51', '2025-10-13 04:36:51'),
(66, 1, 15, 'Super Admin Assign Lead to : miiiin bbbbb at 2025-10-13 10:25:12', 'http://127.0.0.1:8000/installation-assignstore/7', NULL, NULL, '2025-10-13 04:40:12', '2025-10-13 04:40:12'),
(67, 1, 15, 'Super Admin Convert Lead Into Client : Iona Wong at 2025-10-13 10:46:00', 'http://127.0.0.1:8000/installation-store/7', NULL, NULL, '2025-10-13 05:01:00', '2025-10-13 05:01:00'),
(68, 1, 15, 'Super Admin Convert Lead Into Client : Iona Wong at 2025-10-13 10:56:47', 'http://127.0.0.1:8000/installation-store/7', NULL, NULL, '2025-10-13 05:11:47', '2025-10-13 05:11:47'),
(69, 1, 15, 'Super Admin created. warm lead: Ursa Maynard at 2025-10-13 11:10:53', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 05:25:53', '2025-10-13 05:25:53'),
(70, 19, 12, 'Ganesh Kunwar created. hot lead: Ezra Willis at 2025-10-13 11:48:34', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 06:03:34', '2025-10-13 06:03:34'),
(71, 19, 12, 'Ganesh Kunwar created. hot lead: Blaze Buckner at 2025-10-13 12:03:31', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 06:18:31', '2025-10-13 06:18:31'),
(72, 1, 12, 'Super Admin Role Updated Receptionist at 2025-10-13 14:51:35', 'http://127.0.0.1:8000/roles/9', NULL, NULL, '2025-10-13 09:06:35', '2025-10-13 09:06:35'),
(73, 1, 12, 'Super Admin updated user: Ganesh Kunwar (kunwarganesh20003@gmail.com) at 2025-10-13 14:55:09', 'http://127.0.0.1:8000/users/19', NULL, NULL, '2025-10-13 09:10:09', '2025-10-13 09:10:09'),
(74, 1, 12, 'Super Admin Role Updated Receptionist at 2025-10-13 14:58:33', 'http://127.0.0.1:8000/roles/9', NULL, NULL, '2025-10-13 09:13:34', '2025-10-13 09:13:34'),
(75, 1, 12, 'Super Admin Role Updated Receptionist at 2025-10-13 15:00:13', 'http://127.0.0.1:8000/roles/9', NULL, NULL, '2025-10-13 09:15:13', '2025-10-13 09:15:13'),
(76, 20, 13, 'ASDFG created. hot lead: dsfsdfDSFD at 2025-10-13 15:02:09', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 09:17:09', '2025-10-13 09:17:09'),
(77, 20, 13, 'ASDFG Convert Lead to Client: dsfsdfDSFD-hot Lead -counter_sales at 2025-10-13 15:14:19', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-13 09:29:19', '2025-10-13 09:29:19'),
(78, 20, 13, 'ASDFG Assign Lead to : Rudra Thata at 2025-10-13 15:14:55', 'http://127.0.0.1:8000/installation-assignstore/8', NULL, NULL, '2025-10-13 09:29:55', '2025-10-13 09:29:55'),
(79, 20, 13, 'ASDFG created. warm lead: Ganesh Kunwar at 2025-10-13 16:34:03', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 10:49:03', '2025-10-13 10:49:03'),
(80, 20, 13, 'ASDFG created warm lead: SDTFS at 2025-10-13 16:39:18', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 10:54:18', '2025-10-13 10:54:18'),
(81, 20, 13, 'ASDFG created warm lead: DFFDF at 2025-10-13 16:40:24', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 10:55:24', '2025-10-13 10:55:24'),
(82, 20, 13, 'ASDFG created warm lead: SUDIP at 2025-10-13 16:43:17', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-13 10:58:17', '2025-10-13 10:58:17'),
(83, 20, 13, 'ASDFG Updated. warm lead: SUDIP at 2025-10-13 16:47:16', 'http://127.0.0.1:8000/leads/6', NULL, NULL, '2025-10-13 11:02:16', '2025-10-13 11:02:16'),
(84, 20, 13, 'ASDFG Convert Lead to Client: SUDIP-warm Lead -retailler at 2025-10-13 16:50:13', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-13 11:05:13', '2025-10-13 11:05:13'),
(85, 20, 13, 'ASDFG Convert Lead to Client: SDTFS-warm Lead -retailler at 2025-10-13 17:05:41', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-13 11:20:41', '2025-10-13 11:20:41'),
(86, 20, 13, 'ASDFG Assign Lead to : Rudra Thata at 2025-10-13 17:11:44', 'http://127.0.0.1:8000/installation-assignstore/2', NULL, NULL, '2025-10-13 11:26:44', '2025-10-13 11:26:44'),
(87, 20, 13, 'ASDFG Assign Lead to : ASDFG at 2025-10-13 17:36:32', 'http://127.0.0.1:8000/installation-assignstore/2', NULL, NULL, '2025-10-13 11:51:32', '2025-10-13 11:51:32'),
(88, 20, 13, 'ASDFG Convert Lead Into Client : SDTFS at 2025-10-13 17:41:43', 'http://127.0.0.1:8000/installation-store/2', NULL, NULL, '2025-10-13 11:56:43', '2025-10-13 11:56:43'),
(89, 20, 13, 'ASDFG Convert Lead to Client: DFFDF-warm Lead -counter_sales at 2025-10-13 18:05:59', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-13 12:20:59', '2025-10-13 12:20:59'),
(90, 20, 13, 'ASDFG Assign Lead to : new user btl at 2025-10-13 18:06:19', 'http://127.0.0.1:8000/installation-assignstore/3', NULL, NULL, '2025-10-13 12:21:19', '2025-10-13 12:21:19'),
(91, 20, 13, 'ASDFG Convert Lead Into Client : DFFDF at 2025-10-13 18:07:36', 'http://127.0.0.1:8000/installation-store/3', NULL, NULL, '2025-10-13 12:22:36', '2025-10-13 12:22:36'),
(92, 20, 13, 'ASDFG Convert Lead Into Client : DFFDF at 2025-10-13 18:11:40', 'http://127.0.0.1:8000/installation-store/3', NULL, NULL, '2025-10-13 12:26:40', '2025-10-13 12:26:40'),
(93, 1, 13, 'Super Admin Assign Lead to : Rudra Thata at 2025-10-14 16:16:39', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-10-14 10:31:39', '2025-10-14 10:31:39'),
(94, 1, 12, 'Super Admin created. hot lead: Odysseus Ayers at 2025-10-15 11:06:25', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-15 05:21:25', '2025-10-15 05:21:25'),
(95, 1, 12, 'Super Admin created. hot lead: Cally Valenzuela at 2025-10-15 15:27:13', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-15 09:42:13', '2025-10-15 09:42:13'),
(96, 1, 12, 'Super Admin Added Petty cash 2025-10-15 15:29:14', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-10-15 09:44:14', '2025-10-15 09:44:14'),
(97, 1, 12, 'Super Admin delete user: Ganesh Kunwar (kunwarganesh20003@gmail.com) at 2025-10-15 15:35:24', 'http://127.0.0.1:8000/users/19', NULL, NULL, '2025-10-15 09:50:24', '2025-10-15 09:50:24'),
(98, 1, 12, 'Super Admin created user: Ganesh Kunwar (kunwarganesh20003@gmail.com) at 2025-10-15 15:36:17', 'http://127.0.0.1:8000/users', NULL, NULL, '2025-10-15 09:51:17', '2025-10-15 09:51:17'),
(99, 27, 12, 'Ganesh Kunwar Petty cash Requested 2025-10-15 15:37:48', 'http://127.0.0.1:8000/pettycash-request', NULL, NULL, '2025-10-15 09:52:48', '2025-10-15 09:52:48'),
(100, 1, 12, 'Super Admin Added Petty cash 2025-10-15 15:41:46', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-10-15 09:56:46', '2025-10-15 09:56:46'),
(101, 27, 12, 'Ganesh Kunwar Petty cash Requested 2025-10-15 15:42:17', 'http://127.0.0.1:8000/pettycash-request', NULL, NULL, '2025-10-15 09:57:17', '2025-10-15 09:57:17'),
(102, 1, 12, 'Super Admin Added Petty cash 2025-10-15 16:29:25', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-10-15 10:44:25', '2025-10-15 10:44:25'),
(103, 27, 12, 'Ganesh Kunwar Petty cash Requested 2025-10-15 16:30:07', 'http://127.0.0.1:8000/pettycash-request', NULL, NULL, '2025-10-15 10:45:07', '2025-10-15 10:45:07'),
(104, 1, 12, 'Super Admin Convert Lead to Client: Nigel Salazar-hot Lead -counter_sales at 2025-10-15 17:02:50', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-15 11:17:50', '2025-10-15 11:17:50'),
(105, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-15 17:03:07', 'http://127.0.0.1:8000/installation-assignstore/4', NULL, NULL, '2025-10-15 11:18:07', '2025-10-15 11:18:07'),
(106, 1, 12, 'Super Admin Convert Lead to Client: Odysseus Ayers-hot Lead -counter_sales at 2025-10-15 17:11:25', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-15 11:26:25', '2025-10-15 11:26:25'),
(107, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-15 17:11:51', 'http://127.0.0.1:8000/installation-assignstore/5', NULL, NULL, '2025-10-15 11:26:51', '2025-10-15 11:26:51'),
(108, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-15 17:12:20', 'http://127.0.0.1:8000/installation-assignstore/5', NULL, NULL, '2025-10-15 11:27:20', '2025-10-15 11:27:20'),
(109, 1, 12, 'Super Admin Convert Lead Into Client : Odysseus Ayers at 2025-10-15 17:17:09', 'http://127.0.0.1:8000/installation-store/5', NULL, NULL, '2025-10-15 11:32:09', '2025-10-15 11:32:09'),
(110, 1, 12, 'Super Admin Convert Lead Into Client : Odysseus Ayers at 2025-10-15 17:20:26', 'http://127.0.0.1:8000/installation-store/5', NULL, NULL, '2025-10-15 11:35:26', '2025-10-15 11:35:26'),
(111, 1, 12, 'Super Admin Convert Lead Into Client : Odysseus Ayers at 2025-10-15 17:21:54', 'http://127.0.0.1:8000/installation-store/5', NULL, NULL, '2025-10-15 11:36:54', '2025-10-15 11:36:54'),
(112, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-15 17:24:59', 'http://127.0.0.1:8000/installation-assignstore/5', NULL, NULL, '2025-10-15 11:39:59', '2025-10-15 11:39:59'),
(113, 1, 12, 'Super Admin Convert Lead Into Client : Odysseus Ayers at 2025-10-15 17:28:27', 'http://127.0.0.1:8000/installation-store/5', NULL, NULL, '2025-10-15 11:43:27', '2025-10-15 11:43:27'),
(114, 1, 12, 'Super Admin created.  lead: Cally Valenzuela at 2025-10-15 20:53:30', 'http://127.0.0.1:8000/leads/14', NULL, NULL, '2025-10-15 15:08:30', '2025-10-15 15:08:30'),
(115, 1, 12, 'Super Admin created.  lead: Cally Valenzuela at 2025-10-15 20:57:19', 'http://127.0.0.1:8000/leads/14', NULL, NULL, '2025-10-15 15:12:19', '2025-10-15 15:12:19'),
(116, 1, 12, 'Super Admin Convert Lead to Client: Cally Valenzuela-hot Lead -wholeseller at 2025-10-16 10:27:31', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 04:42:31', '2025-10-16 04:42:31'),
(117, 1, 13, 'Super Admin Added Petty cash 2025-10-16 12:57:03', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-10-16 07:12:03', '2025-10-16 07:12:03'),
(118, 1, 13, 'Super Admin created. hot lead: Cole Bailey at 2025-10-16 13:30:52', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 07:45:52', '2025-10-16 07:45:52'),
(119, 1, 12, 'Super Admin Convert Lead to Client: Cole Bailey-hot Lead -counter_sales at 2025-10-16 13:37:43', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 07:52:43', '2025-10-16 07:52:43'),
(120, 1, 12, 'Super Admin created. hot lead: XSDCD at 2025-10-16 13:59:50', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 08:14:50', '2025-10-16 08:14:50'),
(121, 1, 12, 'Super Admin created. hot lead: KUNWAR GANESH at 2025-10-16 15:20:08', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 09:35:08', '2025-10-16 09:35:08'),
(122, 1, 12, 'Super Admin Update.  lead: KUNWAR GANESH at 2025-10-16 15:20:51', 'http://127.0.0.1:8000/leads/17', NULL, NULL, '2025-10-16 09:35:51', '2025-10-16 09:35:51'),
(123, 1, 12, 'Super Admin created. hot lead: KUNWAR GANESH at 2025-10-16 15:23:29', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 09:38:29', '2025-10-16 09:38:29'),
(124, 1, 12, 'Super Admin Update.  lead: KUNWAR GANESH at 2025-10-16 15:27:41', 'http://127.0.0.1:8000/leads/18', NULL, NULL, '2025-10-16 09:42:41', '2025-10-16 09:42:41'),
(125, 1, 12, 'Super Admin Convert Lead to Client: KUNWAR GANESH-hot Lead - at 2025-10-16 15:28:16', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 09:43:16', '2025-10-16 09:43:16'),
(126, 1, 12, 'Super Admin Convert Lead to Client: KUNWAR GANESH-hot Lead - at 2025-10-16 15:36:22', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 09:51:22', '2025-10-16 09:51:22'),
(127, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-16 15:38:24', 'http://127.0.0.1:8000/installation-assignstore/9', NULL, NULL, '2025-10-16 09:53:24', '2025-10-16 09:53:24'),
(128, 1, 12, 'Super Admin Convert Lead Into Client : KUNWAR GANESH at 2025-10-16 15:49:26', 'http://127.0.0.1:8000/installation-store/9', NULL, NULL, '2025-10-16 10:04:26', '2025-10-16 10:04:26'),
(129, 1, 12, 'Super Admin Convert Lead Into Client : KUNWAR GANESH at 2025-10-16 15:52:02', 'http://127.0.0.1:8000/installation-category-store/9', NULL, NULL, '2025-10-16 10:07:02', '2025-10-16 10:07:02'),
(130, 1, 12, 'Super Admin created. hot lead: Ganesh Kunwar at 2025-10-16 15:54:58', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 10:09:58', '2025-10-16 10:09:58'),
(131, 1, 12, 'Super Admin Convert Lead to Client: Ganesh Kunwar-hot Lead -counter_sales at 2025-10-16 15:56:17', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 10:11:17', '2025-10-16 10:11:17'),
(132, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-16 15:56:50', 'http://127.0.0.1:8000/installation-assignstore/10', NULL, NULL, '2025-10-16 10:11:50', '2025-10-16 10:11:50'),
(133, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-16 15:57:35', 'http://127.0.0.1:8000/installation-assignstore/10', NULL, NULL, '2025-10-16 10:12:35', '2025-10-16 10:12:35'),
(134, 1, 12, 'Super Admin Convert Lead Into Client : Ganesh Kunwar at 2025-10-16 15:58:08', 'http://127.0.0.1:8000/installation-store/10', NULL, NULL, '2025-10-16 10:13:08', '2025-10-16 10:13:08'),
(135, 1, 12, 'Super Admin created. hot lead: min bogati at 2025-10-16 16:01:21', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 10:16:21', '2025-10-16 10:16:21'),
(136, 1, 12, 'Super Admin Convert Lead to Client: min bogati-hot Lead - at 2025-10-16 16:05:19', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 10:20:19', '2025-10-16 10:20:19'),
(137, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-16 16:06:28', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-10-16 10:21:28', '2025-10-16 10:21:28'),
(138, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-16 16:09:56', 'http://127.0.0.1:8000/installation-category-assignstore/1', NULL, NULL, '2025-10-16 10:24:56', '2025-10-16 10:24:56'),
(139, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-16 16:10:13', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-10-16 10:25:13', '2025-10-16 10:25:13'),
(140, 1, 12, 'Super Admin Assign Lead to : Ganesh Kunwar at 2025-10-16 16:13:14', 'http://127.0.0.1:8000/installation-category-assignstore/1', NULL, NULL, '2025-10-16 10:28:14', '2025-10-16 10:28:14'),
(141, 1, 12, 'Super Admin Convert Lead Into Client : Min bogati at 2025-10-16 16:14:02', 'http://127.0.0.1:8000/installation-category-store/1', NULL, NULL, '2025-10-16 10:29:02', '2025-10-16 10:29:02'),
(142, 1, 12, 'Super Admin created. hot lead: Carly Graham at 2025-10-16 16:20:38', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 10:35:38', '2025-10-16 10:35:38'),
(143, 1, 12, 'Super Admin Convert Lead to Client: Carly Graham-hot Lead -retailler at 2025-10-16 16:41:18', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 10:56:18', '2025-10-16 10:56:18'),
(144, 1, 12, 'Super Admin created. hot lead: Kelsey Castaneda at 2025-10-16 17:14:28', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 11:29:28', '2025-10-16 11:29:28'),
(145, 1, 12, 'Super Admin Convert Lead to Client: Kelsey Castaneda-hot Lead -retailler at 2025-10-16 17:17:35', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 11:32:35', '2025-10-16 11:32:35'),
(146, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-16 17:53:28', 'http://127.0.0.1:8000/installation-assignstore/3', NULL, NULL, '2025-10-16 12:08:28', '2025-10-16 12:08:28'),
(147, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-16 17:54:37', 'http://127.0.0.1:8000/installation-assignstore/3', NULL, NULL, '2025-10-16 12:09:37', '2025-10-16 12:09:37'),
(148, 1, 12, 'Super Admin Convert Lead Into Client : Kelsey Castaneda at 2025-10-16 17:56:23', 'http://127.0.0.1:8000/installation-store/3', NULL, NULL, '2025-10-16 12:11:23', '2025-10-16 12:11:23'),
(149, 1, 12, 'Super Admin created. hot lead: Rohit Mishra at 2025-10-16 17:57:49', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 12:12:49', '2025-10-16 12:12:49'),
(150, 1, 12, 'Super Admin Convert Lead to Client: Rohit Mishra-hot Lead - at 2025-10-16 17:58:29', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 12:13:29', '2025-10-16 12:13:29'),
(151, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-16 17:59:10', 'http://127.0.0.1:8000/installation-category-assignstore/4', NULL, NULL, '2025-10-16 12:14:10', '2025-10-16 12:14:10'),
(152, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-16 18:02:56', 'http://127.0.0.1:8000/installation-category-assignstore/4', NULL, NULL, '2025-10-16 12:17:56', '2025-10-16 12:17:56'),
(153, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-16 18:03:23', 'http://127.0.0.1:8000/installation-category-assignstore/4', NULL, NULL, '2025-10-16 12:18:23', '2025-10-16 12:18:23'),
(154, 1, 12, 'Super Admin Convert Lead Into Client : Rohit Mishra at 2025-10-16 18:04:07', 'http://127.0.0.1:8000/installation-category-store/4', NULL, NULL, '2025-10-16 12:19:07', '2025-10-16 12:19:07'),
(155, 1, 12, 'Super Admin created. hot lead: Rina Campos at 2025-10-16 18:13:41', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-16 12:28:41', '2025-10-16 12:28:41'),
(156, 1, 12, 'Super Admin Convert Lead to Client: Rina Campos-hot Lead -counter_sales at 2025-10-16 18:19:01', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-16 12:34:01', '2025-10-16 12:34:01'),
(157, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-16 18:23:33', 'http://127.0.0.1:8000/installation-assignstore/5', NULL, NULL, '2025-10-16 12:38:33', '2025-10-16 12:38:33'),
(158, 1, 12, 'Super Admin Convert Lead Into Client : Rina Campos at 2025-10-16 18:27:14', 'http://127.0.0.1:8000/installation-store/5', NULL, NULL, '2025-10-16 12:42:14', '2025-10-16 12:42:14'),
(159, 1, 12, 'Super Admin created. hot lead: Gillian Moody at 2025-10-17 09:45:08', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-17 04:00:08', '2025-10-17 04:00:08'),
(160, 1, 12, 'Super Admin Convert Lead to Client: Gillian Moody-hot Lead -counter_sales at 2025-10-17 09:57:23', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-17 04:12:23', '2025-10-17 04:12:23'),
(161, 1, 12, 'Super Admin created. hot lead: Chastity Hawkins at 2025-10-17 10:16:22', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-17 04:31:22', '2025-10-17 04:31:22'),
(162, 1, 12, 'Super Admin Convert Lead to Client: Chastity Hawkins-hot Lead -counter_sales at 2025-10-17 10:17:32', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-17 04:32:32', '2025-10-17 04:32:32'),
(163, 1, 12, 'Super Admin created. hot lead: Ganesh Kunwar at 2025-10-17 13:19:58', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-17 07:34:58', '2025-10-17 07:34:58'),
(164, 1, 12, 'Super Admin Convert Lead to Client: Ganesh Kunwar-hot Lead - at 2025-10-17 13:23:12', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-17 07:38:12', '2025-10-17 07:38:12'),
(165, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-17 13:34:28', 'http://127.0.0.1:8000/installation-category-assignstore/8', NULL, NULL, '2025-10-17 07:49:28', '2025-10-17 07:49:28'),
(166, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-17 13:36:41', 'http://127.0.0.1:8000/installation-category-assignstore/8', NULL, NULL, '2025-10-17 07:51:41', '2025-10-17 07:51:41'),
(167, 1, 12, 'Super Admin Convert Lead Into Client : Ganesh Kunwar at 2025-10-17 13:41:09', 'http://127.0.0.1:8000/installation-category-store/8', NULL, NULL, '2025-10-17 07:56:09', '2025-10-17 07:56:09'),
(168, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-17 14:41:06', 'http://127.0.0.1:8000/installation-category-assignstore/7', NULL, NULL, '2025-10-17 08:56:06', '2025-10-17 08:56:06'),
(169, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-17 15:50:18', 'http://127.0.0.1:8000/installation-assignstore/6', NULL, NULL, '2025-10-17 10:05:18', '2025-10-17 10:05:18'),
(170, 1, 12, 'Super Admin created. hot lead: Jamal Weiss at 2025-10-17 15:53:17', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-17 10:08:17', '2025-10-17 10:08:17'),
(171, 1, 12, 'Super Admin Convert Lead to Client: Jamal Weiss-hot Lead -retailler at 2025-10-17 15:54:12', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-17 10:09:12', '2025-10-17 10:09:12'),
(172, 1, 12, 'Super Admin created. hot lead: Macaulay Jenkins at 2025-10-17 16:11:25', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-17 10:26:25', '2025-10-17 10:26:25'),
(173, 1, 12, 'Super Admin Convert Lead to Client: Macaulay Jenkins-hot Lead -counter_sales at 2025-10-17 16:12:06', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-17 10:27:06', '2025-10-17 10:27:06'),
(174, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-17 16:18:12', 'http://127.0.0.1:8000/installation-category-assignstore/10', NULL, NULL, '2025-10-17 10:33:12', '2025-10-17 10:33:12'),
(175, 1, 12, 'Super Admin Convert Lead Into Client : Macaulay Jenkins at 2025-10-17 16:24:25', 'http://127.0.0.1:8000/installation-store/10', NULL, NULL, '2025-10-17 10:39:25', '2025-10-17 10:39:25'),
(176, 1, 12, 'Super Admin Convert Lead Into Client : Chastity Hawkins at 2025-10-17 16:26:37', 'http://127.0.0.1:8000/installation-category-store/7', NULL, NULL, '2025-10-17 10:41:37', '2025-10-17 10:41:37'),
(177, 1, 12, 'Super Admin created. hot lead: Nina Kane at 2025-10-19 11:02:30', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-19 05:17:30', '2025-10-19 05:17:30'),
(178, 1, 12, 'Super Admin created. hot lead: Clarke Bond at 2025-10-19 11:03:03', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-19 05:18:03', '2025-10-19 05:18:03'),
(179, 1, 12, 'Super Admin created. hot lead: Alea Oneill at 2025-10-19 11:03:46', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-19 05:18:46', '2025-10-19 05:18:46'),
(180, 1, 12, 'Super Admin created. hot lead: Demetrius Parrish at 2025-10-19 11:56:49', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-19 06:11:49', '2025-10-19 06:11:49'),
(181, 1, 12, 'Super Admin Convert Lead to Client: Demetrius Parrish-hot Lead -retailler at 2025-10-19 12:01:06', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-19 06:16:06', '2025-10-19 06:16:06'),
(182, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-19 12:02:38', 'http://127.0.0.1:8000/installation-assignstore/11', NULL, NULL, '2025-10-19 06:17:38', '2025-10-19 06:17:38'),
(183, 1, 12, 'Super Admin Convert Lead Into Client : Demetrius Parrish at 2025-10-19 12:08:57', 'http://127.0.0.1:8000/installation-store/11', NULL, NULL, '2025-10-19 06:23:57', '2025-10-19 06:23:57'),
(184, 1, 12, 'Super Admin Convert Lead to Client: Nina Kane-hot Lead -counter_sales at 2025-10-19 12:25:56', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-19 06:40:56', '2025-10-19 06:40:56'),
(185, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-19 13:18:41', 'http://127.0.0.1:8000/installation-assignstore/12', NULL, NULL, '2025-10-19 07:33:41', '2025-10-19 07:33:41'),
(186, 1, 12, 'Super Admin Convert Lead Into Client : Nina Kane at 2025-10-19 13:22:33', 'http://127.0.0.1:8000/installation-store/12', NULL, NULL, '2025-10-19 07:37:33', '2025-10-19 07:37:33'),
(187, 1, 12, 'Super Admin Convert Lead to Client: Alea Oneill-hot Lead -wholeseller at 2025-10-19 13:49:50', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-19 08:04:50', '2025-10-19 08:04:50'),
(188, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-19 13:53:47', 'http://127.0.0.1:8000/installation-category-assignstore/13', NULL, NULL, '2025-10-19 08:08:47', '2025-10-19 08:08:47'),
(189, 1, 12, 'Super Admin Convert Lead Into Client : Alea Oneill at 2025-10-19 14:40:12', 'http://127.0.0.1:8000/installation-category-store/13', NULL, NULL, '2025-10-19 08:55:12', '2025-10-19 08:55:12'),
(190, 1, 12, 'Super Admin Convert Lead to Client: Clarke Bond-hot Lead -retailler at 2025-10-19 18:03:23', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-19 12:18:23', '2025-10-19 12:18:23'),
(191, 1, 12, 'Super Admin created. hot lead: Quinn Ross at 2025-10-22 13:54:00', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-22 08:09:00', '2025-10-22 08:09:00'),
(192, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-22 14:39:40', 'http://127.0.0.1:8000/installation-assignstore/14', NULL, NULL, '2025-10-22 08:54:40', '2025-10-22 08:54:40'),
(193, 1, 12, 'Super Admin Convert Lead Into Client : Clarke Bond at 2025-10-22 14:54:42', 'http://127.0.0.1:8000/installation-store/14', NULL, NULL, '2025-10-22 09:09:42', '2025-10-22 09:09:42'),
(194, 1, 12, 'Super Admin Convert Lead to Client: Quinn Ross-hot Lead -counter_sales at 2025-10-22 15:08:17', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-22 09:23:17', '2025-10-22 09:23:17'),
(195, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-22 15:08:39', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-10-22 09:23:39', '2025-10-22 09:23:39'),
(196, 1, 12, 'Super Admin Convert Lead Into Client : Quinn Ross at 2025-10-22 15:09:59', 'http://127.0.0.1:8000/installation-store/1', NULL, NULL, '2025-10-22 09:24:59', '2025-10-22 09:24:59'),
(197, 1, 12, 'Super Admin created. hot lead: Quemby Blevins at 2025-10-26 09:47:58', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-26 04:02:58', '2025-10-26 04:02:58'),
(198, 1, 12, 'Super Admin Convert Lead to Client: Quemby Blevins-hot Lead -counter_sales at 2025-10-26 09:57:02', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-26 04:12:02', '2025-10-26 04:12:02'),
(199, 1, 15, 'Super Admin created. hot lead: suman gautam at 2025-10-26 10:38:40', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-26 09:38:40', '2025-10-26 09:38:40'),
(200, 1, 15, 'Super Admin Assign Lead to : miiiin bbbbb at 2025-10-26 10:42:49', 'https://mamubag.com.np/installation-category-assignstore/3', NULL, NULL, '2025-10-26 09:42:49', '2025-10-26 09:42:49'),
(201, 1, 15, 'Super Admin Convert Lead Into Client : Suman gautam at 2025-10-26 10:44:11', 'https://mamubag.com.np/installation-category-store/3', NULL, NULL, '2025-10-26 09:44:11', '2025-10-26 09:44:11'),
(202, 1, 12, 'Super Admin Added Petty cash 2025-10-26 13:41:36', 'https://mamubag.com.np/pettycash-addcash', NULL, NULL, '2025-10-26 12:41:36', '2025-10-26 12:41:36'),
(203, 27, 12, 'Ganesh Kunwar Petty cash Requested 2025-10-26 13:43:14', 'https://mamubag.com.np/pettycash-request', NULL, NULL, '2025-10-26 12:43:14', '2025-10-26 12:43:14'),
(204, 1, 12, 'Super Admin created. hot lead: Ganesh Bahadur Kunwar at 2025-10-26 13:47:18', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-26 12:47:18', '2025-10-26 12:47:18'),
(205, 1, 12, 'Super Admin Convert Lead to Client: Ganesh Bahadur Kunwar-hot Lead - at 2025-10-26 13:48:51', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-26 12:48:51', '2025-10-26 12:48:51'),
(206, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-26 13:49:44', 'https://mamubag.com.np/installation-category-assignstore/4', NULL, NULL, '2025-10-26 12:49:44', '2025-10-26 12:49:44'),
(207, 1, 12, 'Super Admin Convert Lead Into Client : Ganesh Bahadur Kunwar at 2025-10-26 13:51:06', 'https://mamubag.com.np/installation-category-store/4', NULL, NULL, '2025-10-26 12:51:06', '2025-10-26 12:51:06'),
(208, 1, 12, 'Super Admin created. hot lead: Camille Lewis at 2025-10-26 14:23:07', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-26 13:23:07', '2025-10-26 13:23:07'),
(209, 1, 12, 'Super Admin Convert Lead to Client: Camille Lewis-hot Lead -retailler at 2025-10-26 14:23:34', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-26 13:23:34', '2025-10-26 13:23:34'),
(210, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-26 14:23:51', 'https://mamubag.com.np/installation-assignstore/5', NULL, NULL, '2025-10-26 13:23:51', '2025-10-26 13:23:51'),
(211, 1, 12, 'Super Admin Convert Lead Into Client : Camille Lewis at 2025-10-26 14:28:11', 'https://mamubag.com.np/installation-store/5', NULL, NULL, '2025-10-26 13:28:11', '2025-10-26 13:28:11'),
(212, 1, 12, 'Super Admin created. hot lead: sushil malla at 2025-10-26 14:33:26', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-26 13:33:26', '2025-10-26 13:33:26'),
(213, 1, 12, 'Super Admin Convert Lead to Client: sushil malla-hot Lead - at 2025-10-26 14:37:40', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-26 13:37:40', '2025-10-26 13:37:40'),
(214, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-26 14:40:37', 'https://mamubag.com.np/installation-category-assignstore/6', NULL, NULL, '2025-10-26 13:40:37', '2025-10-26 13:40:37'),
(215, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-26 14:41:53', 'https://mamubag.com.np/installation-category-assignstore/6', NULL, NULL, '2025-10-26 13:41:53', '2025-10-26 13:41:53'),
(216, 1, 12, 'Super Admin Assign Lead to : Ganesh Kunwar at 2025-10-26 14:42:04', 'https://mamubag.com.np/installation-category-assignstore/6', NULL, NULL, '2025-10-26 13:42:04', '2025-10-26 13:42:04'),
(217, 1, 12, 'Super Admin Convert Lead Into Client : Sushil malla at 2025-10-26 14:44:36', 'https://mamubag.com.np/installation-category-store/6', NULL, NULL, '2025-10-26 13:44:36', '2025-10-26 13:44:36'),
(218, 1, 12, 'Super Admin Convert Lead Into Client : Sushil malla at 2025-10-26 14:56:20', 'https://mamubag.com.np/installation-category-store/6', NULL, NULL, '2025-10-26 13:56:20', '2025-10-26 13:56:20'),
(219, 1, 12, 'Super Admin created. warm lead: Walker Shields at 2025-10-26 15:19:42', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-26 14:19:42', '2025-10-26 14:19:42'),
(220, 1, 12, 'Super Admin created. hot lead: jeevan neupane at 2025-10-27 09:14:08', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-27 08:14:08', '2025-10-27 08:14:08'),
(221, 1, 12, 'Super Admin created. hot lead: jamuna thapa at 2025-10-27 09:21:03', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-27 08:21:03', '2025-10-27 08:21:03'),
(222, 1, 12, 'Super Admin Convert Lead to Client: jamuna thapa-hot Lead - at 2025-10-27 09:24:18', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-27 08:24:18', '2025-10-27 08:24:18'),
(223, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-27 09:30:34', 'https://mamubag.com.np/installation-category-assignstore/7', NULL, NULL, '2025-10-27 08:30:34', '2025-10-27 08:30:34'),
(224, 1, 12, 'Super Admin created. hot lead: rudra thapa at 2025-10-27 09:39:18', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-27 08:39:18', '2025-10-27 08:39:18'),
(225, 1, 12, 'Super Admin Convert Lead to Client: rudra thapa-hot Lead - at 2025-10-27 09:43:56', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-27 08:43:56', '2025-10-27 08:43:56'),
(226, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-27 09:52:07', 'https://mamubag.com.np/installation-category-assignstore/8', NULL, NULL, '2025-10-27 08:52:07', '2025-10-27 08:52:07'),
(227, 1, 12, 'Super Admin Convert Lead Into Client : Rudra thapa at 2025-10-27 10:01:21', 'https://mamubag.com.np/installation-category-store/8', NULL, NULL, '2025-10-27 09:01:21', '2025-10-27 09:01:21'),
(228, 1, 12, 'Super Admin Slider Update: Our Popular Services at 2025-10-28 09:45:28', 'https://mamubag.com.np/sliders/4', NULL, NULL, '2025-10-28 08:45:28', '2025-10-28 08:45:28'),
(229, 1, 12, 'Super Admin Slider Update: Trustworthy & Efficient at 2025-10-28 09:46:17', 'https://mamubag.com.np/sliders/3', NULL, NULL, '2025-10-28 08:46:17', '2025-10-28 08:46:17'),
(230, 1, 12, 'Super Admin created. hot lead: Kimberly Lowe at 2025-10-28 16:09:58', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-28 15:09:58', '2025-10-28 15:09:58'),
(231, 1, 12, 'Super Admin Convert Lead to Client: Kimberly Lowe-hot Lead -counter_sales at 2025-10-28 16:13:43', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-28 15:13:43', '2025-10-28 15:13:43'),
(232, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-28 16:13:53', 'https://mamubag.com.np/installation-assignstore/1', NULL, NULL, '2025-10-28 15:13:53', '2025-10-28 15:13:53'),
(233, 1, 12, 'Super Admin Convert Lead Into Client : Kimberly Lowe at 2025-10-28 16:29:23', 'https://mamubag.com.np/installation-store/1', NULL, NULL, '2025-10-28 15:29:23', '2025-10-28 15:29:23'),
(234, 1, 15, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-29 06:53:40', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 05:53:40', '2025-10-29 05:53:40'),
(235, 1, 15, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-29 06:54:41', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 05:54:41', '2025-10-29 05:54:41'),
(236, 1, 15, 'Super Admin Assign Lead to : Sandesh Bogati at 2025-10-29 06:54:54', 'https://mamubag.com.np/installation-category-assignstore/2', NULL, NULL, '2025-10-29 05:54:54', '2025-10-29 05:54:54'),
(237, 1, 16, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-29 11:18:13', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 10:18:13', '2025-10-29 10:18:13'),
(238, 1, 16, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-29 11:19:00', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 10:19:00', '2025-10-29 10:19:00'),
(239, 1, 16, 'Super Admin Assign Lead to : Sybil Gould at 2025-10-29 11:19:27', 'https://mamubag.com.np/installation-category-assignstore/3', NULL, NULL, '2025-10-29 10:19:27', '2025-10-29 10:19:27'),
(240, 1, 16, 'Super Admin Convert Lead Into Client : Nabin Thapa at 2025-10-29 11:22:07', 'https://mamubag.com.np/installation-category-store/3', NULL, NULL, '2025-10-29 10:22:07', '2025-10-29 10:22:07'),
(241, 1, 16, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-29 11:33:25', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 10:33:25', '2025-10-29 10:33:25'),
(242, 1, 16, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-29 11:34:55', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 10:34:55', '2025-10-29 10:34:55'),
(243, 1, 16, 'Super Admin Assign Lead to : Sybil Gould at 2025-10-29 11:36:03', 'https://mamubag.com.np/installation-category-assignstore/4', NULL, NULL, '2025-10-29 10:36:03', '2025-10-29 10:36:03'),
(244, 1, 16, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-29 11:49:19', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 10:49:19', '2025-10-29 10:49:19'),
(245, 1, 16, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-29 11:50:11', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 10:50:11', '2025-10-29 10:50:11'),
(246, 1, 16, 'Super Admin Assign Lead to : Sybil Gould at 2025-10-29 11:50:49', 'https://mamubag.com.np/installation-category-assignstore/5', NULL, NULL, '2025-10-29 10:50:49', '2025-10-29 10:50:49'),
(247, 1, 16, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-29 11:59:26', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 10:59:26', '2025-10-29 10:59:26'),
(248, 1, 16, 'Super Admin created. hot lead: jharna thapa at 2025-10-29 12:01:25', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 11:01:25', '2025-10-29 11:01:25'),
(249, 1, 16, 'Super Admin Convert Lead to Client: jharna thapa-hot Lead - at 2025-10-29 12:04:38', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 11:04:38', '2025-10-29 11:04:38'),
(250, 1, 16, 'Super Admin Assign Lead to : Sybil Gould at 2025-10-29 12:08:31', 'https://mamubag.com.np/installation-category-assignstore/6', NULL, NULL, '2025-10-29 11:08:31', '2025-10-29 11:08:31'),
(251, 1, 16, 'Super Admin Convert Lead Into Client : Jharna thapa at 2025-10-29 12:14:00', 'https://mamubag.com.np/installation-category-store/6', NULL, NULL, '2025-10-29 11:14:00', '2025-10-29 11:14:00'),
(252, 1, 12, 'Super Admin created. hot lead: Cara French at 2025-10-29 13:08:51', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 12:08:51', '2025-10-29 12:08:51'),
(253, 1, 12, 'Super Admin Convert Lead to Client: Cara French-hot Lead -retailler at 2025-10-29 13:09:11', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 12:09:11', '2025-10-29 12:09:11'),
(254, 1, 12, 'Super Admin Convert Lead to Client: jeevan neupane-hot Lead - at 2025-10-29 14:34:44', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 13:34:44', '2025-10-29 13:34:44'),
(255, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-29 14:34:56', 'https://mamubag.com.np/installation-category-assignstore/8', NULL, NULL, '2025-10-29 13:34:56', '2025-10-29 13:34:56'),
(256, 1, 12, 'Super Admin Convert Lead Into Client : Jeevan neupane at 2025-10-29 14:35:56', 'https://mamubag.com.np/installation-category-store/8', NULL, NULL, '2025-10-29 13:35:56', '2025-10-29 13:35:56'),
(257, 1, 12, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-29 19:35:12', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-29 18:35:12', '2025-10-29 18:35:12'),
(258, 1, 12, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-29 19:35:58', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-29 18:35:58', '2025-10-29 18:35:58'),
(259, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-29 19:37:19', 'https://mamubag.com.np/installation-category-assignstore/9', NULL, NULL, '2025-10-29 18:37:19', '2025-10-29 18:37:19'),
(260, 1, 12, 'Super Admin Convert Lead Into Client : Nabin Thapa at 2025-10-29 19:38:59', 'https://mamubag.com.np/installation-category-store/9', NULL, NULL, '2025-10-29 18:38:59', '2025-10-29 18:38:59'),
(261, 1, 12, 'Super Admin created. hot lead: salim miya at 2025-10-30 09:58:44', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-30 08:58:44', '2025-10-30 08:58:44'),
(262, 1, 12, 'Super Admin Convert Lead to Client: salim miya-hot Lead - at 2025-10-30 10:01:40', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-30 09:01:40', '2025-10-30 09:01:40'),
(263, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-30 10:04:15', 'https://mamubag.com.np/installation-category-assignstore/10', NULL, NULL, '2025-10-30 09:04:15', '2025-10-30 09:04:15');
INSERT INTO `logs` (`id`, `user_id`, `branch_id`, `perform`, `url`, `log_date`, `status`, `created_at`, `updated_at`) VALUES
(264, 1, 12, 'Super Admin Convert Lead Into Client : Salim miya at 2025-10-30 10:06:47', 'https://mamubag.com.np/installation-category-store/10', NULL, NULL, '2025-10-30 09:06:47', '2025-10-30 09:06:47'),
(265, 1, 12, 'Super Admin Task maintenance Created: at 2025-10-30 10:13:22', 'https://mamubag.com.np/supportdashboard/store', NULL, NULL, '2025-10-30 09:13:22', '2025-10-30 09:13:22'),
(266, 1, 12, 'Super Admin Amc Assign at 2025-10-30 10:13:43', 'https://mamubag.com.np/supportdashboard/assignstore/12', NULL, NULL, '2025-10-30 09:13:43', '2025-10-30 09:13:43'),
(267, 1, 12, 'Super Admin created. hot lead: Kuame Davidson at 2025-10-30 11:05:27', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-30 10:05:27', '2025-10-30 10:05:27'),
(268, 1, 12, 'Super Admin Convert Lead to Client: Kuame Davidson-hot Lead -retailler at 2025-10-30 11:06:12', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-30 10:06:12', '2025-10-30 10:06:12'),
(269, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-10-30 11:08:46', 'https://mamubag.com.np/installation-assignstore/11', NULL, NULL, '2025-10-30 10:08:46', '2025-10-30 10:08:46'),
(270, 1, 12, 'Super Admin Convert Lead Into Client : Kuame Davidson at 2025-10-30 11:09:45', 'https://mamubag.com.np/installation-store/11', NULL, NULL, '2025-10-30 10:09:45', '2025-10-30 10:09:45'),
(271, 1, 12, 'Super Admin created. hot lead: sudip chaudhary at 2025-10-30 11:24:48', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-30 10:24:48', '2025-10-30 10:24:48'),
(272, 1, 12, 'Super Admin Convert Lead to Client: sudip chaudhary-hot Lead - at 2025-10-30 11:34:57', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-30 10:34:57', '2025-10-30 10:34:57'),
(273, 1, 12, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-30 11:55:26', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-30 10:55:26', '2025-10-30 10:55:26'),
(274, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-10-30 12:01:03', 'https://mamubag.com.np/installation-category-assignstore/12', NULL, NULL, '2025-10-30 11:01:03', '2025-10-30 11:01:03'),
(275, 1, 12, 'Super Admin Convert Lead Into Client : Sudip chaudhary at 2025-10-30 12:49:08', 'https://mamubag.com.np/installation-category-store/12', NULL, NULL, '2025-10-30 11:49:08', '2025-10-30 11:49:08'),
(276, 1, 12, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-30 13:25:51', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-30 12:25:51', '2025-10-30 12:25:51'),
(277, 1, 12, 'Super Admin created. hot lead: ddssgsd at 2025-10-30 14:07:20', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-30 13:07:20', '2025-10-30 13:07:20'),
(278, 1, 12, 'Super Admin Convert Lead to Client: ddssgsd-hot Lead - at 2025-10-30 14:09:46', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-30 13:09:46', '2025-10-30 13:09:46'),
(279, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-10-30 14:17:58', 'https://mamubag.com.np/installation-category-assignstore/14', NULL, NULL, '2025-10-30 13:17:58', '2025-10-30 13:17:58'),
(280, 1, 14, 'Super Admin created. hot lead: basu bhusal at 2025-10-31 12:07:29', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-31 11:07:29', '2025-10-31 11:07:29'),
(281, 1, 14, 'Super Admin Convert Lead to Client: basu bhusal-hot Lead - at 2025-10-31 12:12:41', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-31 11:12:41', '2025-10-31 11:12:41'),
(282, 1, 14, 'Super Admin Assign Lead to : suresh bhatt at 2025-10-31 12:18:50', 'https://mamubag.com.np/installation-category-assignstore/15', NULL, NULL, '2025-10-31 11:18:50', '2025-10-31 11:18:50'),
(283, 1, 14, 'Super Admin Convert Lead Into Client : Ddssgsd at 2025-10-31 12:20:00', 'https://mamubag.com.np/installation-category-store/14', NULL, NULL, '2025-10-31 11:20:00', '2025-10-31 11:20:00'),
(284, 1, 14, 'Super Admin created. hot lead: sanjaya thapa at 2025-10-31 12:32:09', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-31 11:32:09', '2025-10-31 11:32:09'),
(285, 1, 14, 'Super Admin Convert Lead to Client: sanjaya thapa-hot Lead - at 2025-10-31 12:51:58', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-31 11:51:58', '2025-10-31 11:51:58'),
(286, 1, 14, 'Super Admin Assign Lead to : suresh bhatt at 2025-10-31 13:06:17', 'https://mamubag.com.np/installation-category-assignstore/16', NULL, NULL, '2025-10-31 12:06:17', '2025-10-31 12:06:17'),
(287, 1, 14, 'Super Admin created. hot lead: Nabin Thapa at 2025-10-31 13:15:46', 'https://mamubag.com.np/leads', NULL, NULL, '2025-10-31 12:15:46', '2025-10-31 12:15:46'),
(288, 1, 14, 'Super Admin Convert Lead to Client: Nabin Thapa-hot Lead - at 2025-10-31 13:16:45', 'https://mamubag.com.np/lead-convert/store', NULL, NULL, '2025-10-31 12:16:45', '2025-10-31 12:16:45'),
(289, 1, 12, 'Super Admin Convert Lead to Client: Aspen Townsend-hot Lead - at 2025-10-31 17:52:06', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-31 12:07:06', '2025-10-31 12:07:06'),
(290, 1, 12, 'Super Admin created. hot lead: Kaden Matthews at 2025-10-31 17:53:51', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-31 12:08:51', '2025-10-31 12:08:51'),
(291, 1, 12, 'Super Admin Convert Lead to Client: Kaden Matthews-hot Lead -wholeseller at 2025-10-31 17:55:09', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-10-31 12:10:09', '2025-10-31 12:10:09'),
(292, 1, 12, 'Super Admin created. hot lead: Honorato Hays at 2025-10-31 17:57:52', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-10-31 12:12:52', '2025-10-31 12:12:52'),
(293, 1, 12, 'Super Admin created. hot lead: Hamish Bartlett at 2025-11-02 10:47:06', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-02 05:02:06', '2025-11-02 05:02:06'),
(294, 1, 12, 'Super Admin Convert Lead to Client: Hamish Bartlett-hot Lead -retailler at 2025-11-02 10:49:36', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-02 05:04:36', '2025-11-02 05:04:36'),
(295, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-02 10:51:33', 'http://127.0.0.1:8000/installation-assignstore/20', NULL, NULL, '2025-11-02 05:06:33', '2025-11-02 05:06:33'),
(296, 1, 12, 'Super Admin Convert Lead Into Client : Hamish Bartlett at 2025-11-02 10:57:53', 'http://127.0.0.1:8000/installation-store/20', NULL, NULL, '2025-11-02 05:12:53', '2025-11-02 05:12:53'),
(297, 1, 12, 'Super Admin created. hot lead: Darryl Galloway at 2025-11-02 11:01:28', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-02 05:16:28', '2025-11-02 05:16:28'),
(298, 1, 12, 'Super Admin Update.  lead: Darryl Galloway at 2025-11-02 11:02:22', 'http://127.0.0.1:8000/leads/71', NULL, NULL, '2025-11-02 05:17:22', '2025-11-02 05:17:22'),
(299, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-02 12:10:07', 'http://127.0.0.1:8000/installation-assignstore/19', NULL, NULL, '2025-11-02 06:25:07', '2025-11-02 06:25:07'),
(300, 1, 12, 'Super Admin Convert Lead Into Client : Kaden Matthews at 2025-11-02 12:10:56', 'http://127.0.0.1:8000/installation-store/19', NULL, NULL, '2025-11-02 06:25:56', '2025-11-02 06:25:56'),
(301, 1, 12, 'Super Admin Convert Lead Into Client : Kaden Matthews at 2025-11-02 12:10:58', 'http://127.0.0.1:8000/installation-store/19', NULL, NULL, '2025-11-02 06:25:58', '2025-11-02 06:25:58'),
(302, 1, 12, 'Super Admin Convert Lead Into Client : Kaden Matthews at 2025-11-02 12:12:21', 'http://127.0.0.1:8000/installation-store/19', NULL, NULL, '2025-11-02 06:27:21', '2025-11-02 06:27:21'),
(303, 1, 12, 'Super Admin Convert Lead Into Client : Kaden Matthews at 2025-11-02 12:12:23', 'http://127.0.0.1:8000/installation-store/19', NULL, NULL, '2025-11-02 06:27:23', '2025-11-02 06:27:23'),
(304, 1, 12, 'Super Admin Convert Lead Into Client : Kaden Matthews at 2025-11-02 12:12:25', 'http://127.0.0.1:8000/installation-store/19', NULL, NULL, '2025-11-02 06:27:25', '2025-11-02 06:27:25'),
(305, 1, 12, 'Super Admin Convert Lead Into Client : Kaden Matthews at 2025-11-02 12:19:12', 'http://127.0.0.1:8000/installation-store/19', NULL, NULL, '2025-11-02 06:34:12', '2025-11-02 06:34:12'),
(306, 1, 12, 'Super Admin Added Petty cash 2025-11-02 13:09:05', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 07:24:05', '2025-11-02 07:24:05'),
(307, 1, 12, 'Super Admin Added Petty cash 2025-11-02 13:20:24', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 07:35:24', '2025-11-02 07:35:24'),
(308, 1, 12, 'Super Admin Added Petty cash 2025-11-02 13:22:12', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 07:37:12', '2025-11-02 07:37:12'),
(309, 1, 12, 'Super Admin Added Petty cash 2025-11-02 13:49:25', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 08:04:25', '2025-11-02 08:04:25'),
(310, 1, 12, 'Super Admin Added Petty cash 2025-11-02 13:53:52', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 08:08:52', '2025-11-02 08:08:52'),
(311, 1, 12, 'Super Admin Added Petty cash 2025-11-02 13:57:49', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 08:12:49', '2025-11-02 08:12:49'),
(312, 1, 12, 'Super Admin Added Petty cash 2025-11-02 15:21:58', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-02 09:36:58', '2025-11-02 09:36:58'),
(313, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-03 12:20:24', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-03 06:35:24', '2025-11-03 06:35:24'),
(314, 1, 12, 'Super Admin Amc Assign at 2025-11-03 15:51:00', 'http://127.0.0.1:8000/supportdashboard/assignstore/13', NULL, NULL, '2025-11-03 10:06:00', '2025-11-03 10:06:00'),
(315, 1, 12, 'Super Admin Amc Completed at 2025-11-03 16:10:23', 'http://127.0.0.1:8000/supportdashboard/completestore/13', NULL, NULL, '2025-11-03 10:25:23', '2025-11-03 10:25:23'),
(316, 1, 12, 'Super Admin OutSideTask Create for: Jada Bryant at 2025-11-03 17:12:50', 'http://127.0.0.1:8000/outsidersupportdashboard/store', NULL, NULL, '2025-11-03 11:27:50', '2025-11-03 11:27:50'),
(317, 1, 12, 'Super Admin OutSideTask of Jada Bryant Assign:Min Bogati at 2025-11-03 17:13:45', 'http://127.0.0.1:8000/outsidersupportdashboard/assignstore/7', NULL, NULL, '2025-11-03 11:28:45', '2025-11-03 11:28:45'),
(318, 1, 12, 'Super Admin OutSideTask of Jada Bryant Completed at 2025-11-03 17:26:21', 'http://127.0.0.1:8000/outsidersupportdashboard/completestore/7', NULL, NULL, '2025-11-03 11:41:21', '2025-11-03 11:41:21'),
(319, 1, 12, 'Super Admin OutSideTask Create for: Marvin Hoover at 2025-11-03 17:31:59', 'http://127.0.0.1:8000/outsidersupportdashboard/store', NULL, NULL, '2025-11-03 11:46:59', '2025-11-03 11:46:59'),
(320, 1, 12, 'Super Admin OutSideTask of Marvin Hoover Assign:Sushil Kunwar at 2025-11-03 17:32:34', 'http://127.0.0.1:8000/outsidersupportdashboard/assignstore/8', NULL, NULL, '2025-11-03 11:47:34', '2025-11-03 11:47:34'),
(321, 1, 12, 'Super Admin OutSideTask of Marvin Hoover Completed at 2025-11-03 17:33:39', 'http://127.0.0.1:8000/outsidersupportdashboard/completestore/8', NULL, NULL, '2025-11-03 11:48:39', '2025-11-03 11:48:39'),
(322, 1, 12, 'Super Admin OutSideTask Create for: Ruby Little at 2025-11-03 17:51:40', 'http://127.0.0.1:8000/outsidersupportdashboard/store', NULL, NULL, '2025-11-03 12:06:40', '2025-11-03 12:06:40'),
(323, 1, 12, 'Super Admin OutSideTask of Ruby Little Assign:Sushil Kunwar at 2025-11-03 17:51:53', 'http://127.0.0.1:8000/outsidersupportdashboard/assignstore/9', NULL, NULL, '2025-11-03 12:06:53', '2025-11-03 12:06:53'),
(324, 1, 12, 'Super Admin OutSideTask of Ruby Little Completed at 2025-11-03 17:52:44', 'http://127.0.0.1:8000/outsidersupportdashboard/completestore/9', NULL, NULL, '2025-11-03 12:07:44', '2025-11-03 12:07:44'),
(325, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-03 18:32:10', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-03 12:47:10', '2025-11-03 12:47:10'),
(326, 1, 12, 'Super Admin Amc Assign at 2025-11-03 18:32:29', 'http://127.0.0.1:8000/supportdashboard/assignstore/14', NULL, NULL, '2025-11-03 12:47:29', '2025-11-03 12:47:29'),
(327, 1, 12, 'Super Admin Amc Completed at 2025-11-03 18:33:01', 'http://127.0.0.1:8000/supportdashboard/completestore/14', NULL, NULL, '2025-11-03 12:48:01', '2025-11-03 12:48:01'),
(328, 1, 12, 'Super Admin Task maintenance Created: at 2025-11-03 18:38:14', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-03 12:53:14', '2025-11-03 12:53:14'),
(329, 1, 12, 'Super Admin Amc Assign at 2025-11-03 18:38:37', 'http://127.0.0.1:8000/supportdashboard/assignstore/15', NULL, NULL, '2025-11-03 12:53:37', '2025-11-03 12:53:37'),
(330, 1, 12, 'Super Admin Added Petty cash 2025-11-04 09:46:54', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-04 04:01:54', '2025-11-04 04:01:54'),
(331, 1, 12, 'Super Admin created Amc: Ut hic possimus mol at 2025-11-04 10:34:42', 'http://127.0.0.1:8000/amc', NULL, NULL, '2025-11-04 04:49:42', '2025-11-04 04:49:42'),
(332, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-04 10:49:12', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-04 05:04:12', '2025-11-04 05:04:12'),
(333, 1, 12, 'Super Admin Amc Assign at 2025-11-04 10:50:23', 'http://127.0.0.1:8000/supportdashboard/assignstore/16', NULL, NULL, '2025-11-04 05:05:23', '2025-11-04 05:05:23'),
(334, 1, 12, 'Super Admin Convert Lead to Client: Darryl Galloway-hot Lead -retailler at 2025-11-04 12:17:53', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-04 06:32:53', '2025-11-04 06:32:53'),
(335, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-04 12:18:08', 'http://127.0.0.1:8000/installation-assignstore/21', NULL, NULL, '2025-11-04 06:33:08', '2025-11-04 06:33:08'),
(336, 1, 12, 'Super Admin Convert Lead Into Client : Darryl Galloway at 2025-11-04 12:19:05', 'http://127.0.0.1:8000/installation-store/21', NULL, NULL, '2025-11-04 06:34:05', '2025-11-04 06:34:05'),
(337, 1, 12, 'Super Admin created. hot lead: bobeen at 2025-11-04 14:24:48', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-04 08:39:48', '2025-11-04 08:39:48'),
(338, 1, 12, 'Super Admin created. hot lead: Arjit at 2025-11-04 14:25:46', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-04 08:40:46', '2025-11-04 08:40:46'),
(339, 1, 12, 'Super Admin created. hot lead: Janna Walton at 2025-11-04 14:26:18', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-04 08:41:18', '2025-11-04 08:41:18'),
(340, 1, 12, 'Super Admin Convert Lead to Client: bobeen-hot Lead -retailler at 2025-11-04 15:02:55', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-04 09:17:55', '2025-11-04 09:17:55'),
(341, 1, 12, 'Super Admin Convert Lead to Client: Arjit-hot Lead -wholeseller at 2025-11-04 15:11:47', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-04 09:26:47', '2025-11-04 09:26:47'),
(342, 1, 12, 'Super Admin Convert Lead to Client: Janna Walton-hot Lead -counter_sales at 2025-11-04 15:24:52', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-04 09:39:52', '2025-11-04 09:39:52'),
(343, 1, 12, 'Super Admin Added Petty cash 2025-11-04 17:21:29', 'http://127.0.0.1:8000/pettycash-addcash', NULL, NULL, '2025-11-04 11:36:29', '2025-11-04 11:36:29'),
(344, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-05 10:40:32', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-05 04:55:32', '2025-11-05 04:55:32'),
(345, 1, 12, 'Super Admin created. hot lead: Vanna Leonard at 2025-11-05 10:48:02', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-05 05:03:02', '2025-11-05 05:03:02'),
(346, 1, 12, 'Super Admin assigned AMC: Silver AMC to Customer:  (ID: 22) at 2025-11-05 11:05:57', 'http://127.0.0.1:8000/amcassign', NULL, NULL, '2025-11-05 05:20:57', '2025-11-05 05:20:57'),
(347, 1, 12, 'Super Admin created Amc: Silver AMC at 2025-11-05 12:12:58', 'http://127.0.0.1:8000/amc/1/edit', NULL, NULL, '2025-11-05 06:27:58', '2025-11-05 06:27:58'),
(348, 1, 12, 'Super Admin created Amc: Silver AMC at 2025-11-05 12:14:50', 'http://127.0.0.1:8000/amc/1/edit', NULL, NULL, '2025-11-05 06:29:50', '2025-11-05 06:29:50'),
(349, 1, 12, 'Super Admin created Amc: Silver AMC at 2025-11-05 12:15:47', 'http://127.0.0.1:8000/amc/1/edit', NULL, NULL, '2025-11-05 06:30:47', '2025-11-05 06:30:47'),
(350, 1, 12, 'Super Admin created Amc: Dolores sint ut eum at 2025-11-05 12:30:20', 'http://127.0.0.1:8000/amc', NULL, NULL, '2025-11-05 06:45:20', '2025-11-05 06:45:20'),
(351, 1, 12, 'Super Admin created Amc: Gold Amc at 2025-11-05 12:32:27', 'http://127.0.0.1:8000/amc', NULL, NULL, '2025-11-05 06:47:27', '2025-11-05 06:47:27'),
(352, 1, 12, 'Super Admin created Amc: Dolores sint ut eum at 2025-11-05 12:32:44', 'http://127.0.0.1:8000/amc', NULL, NULL, '2025-11-05 06:47:44', '2025-11-05 06:47:44'),
(353, 1, 12, 'Super Admin delete AMC Gold Amc at 2025-11-05 12:33:38', 'http://127.0.0.1:8000/amc/4', NULL, NULL, '2025-11-05 06:48:38', '2025-11-05 06:48:38'),
(354, 1, 12, 'Super Admin delete AMC Dolores sint ut eum at 2025-11-05 12:33:43', 'http://127.0.0.1:8000/amc/5', NULL, NULL, '2025-11-05 06:48:43', '2025-11-05 06:48:43'),
(355, 1, 12, 'Super Admin created Amc: Dolores sint ut eum at 2025-11-05 12:34:56', 'http://127.0.0.1:8000/amc/3', NULL, NULL, '2025-11-05 06:49:56', '2025-11-05 06:49:56'),
(356, 1, 12, 'Super Admin created Amc: Gold at 2025-11-05 12:35:13', 'http://127.0.0.1:8000/amc/2', NULL, NULL, '2025-11-05 06:50:13', '2025-11-05 06:50:13'),
(357, 1, 12, 'Super Admin created Amc: Gold at 2025-11-05 12:35:30', 'http://127.0.0.1:8000/amc/2', NULL, NULL, '2025-11-05 06:50:30', '2025-11-05 06:50:30'),
(358, 1, 12, 'Super Admin delete AMC Dolores sint ut eum at 2025-11-05 12:35:39', 'http://127.0.0.1:8000/amc/3', NULL, NULL, '2025-11-05 06:50:39', '2025-11-05 06:50:39'),
(359, 1, 12, 'Super Admin created Amc: Gold Amc at 2025-11-05 12:35:46', 'http://127.0.0.1:8000/amc/2', NULL, NULL, '2025-11-05 06:50:46', '2025-11-05 06:50:46'),
(360, 1, 12, 'Super Admin Convert Lead to Client: Vanna Leonard-hot Lead -wholeseller at 2025-11-07 16:58:50', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-07 11:13:50', '2025-11-07 11:13:50'),
(361, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-07 17:01:46', 'http://127.0.0.1:8000/installation-assignstore/25', NULL, NULL, '2025-11-07 11:16:46', '2025-11-07 11:16:46'),
(362, 1, 12, 'Super Admin Convert Lead Into Client : Vanna Leonard at 2025-11-07 17:04:13', 'http://127.0.0.1:8000/installation-store/25', NULL, NULL, '2025-11-07 11:19:13', '2025-11-07 11:19:13'),
(363, 1, 12, 'Super Admin Convert Lead to Client: Halla Reilly-hot Lead -counter_sales at 2025-11-07 17:18:10', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-07 11:33:10', '2025-11-07 11:33:10'),
(364, 1, 12, 'Super Admin created. hot lead: Akeem Gates at 2025-11-09 12:20:16', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-09 06:35:16', '2025-11-09 06:35:16'),
(365, 1, 12, 'Super Admin Convert Lead to Client: Akeem Gates-hot Lead -counter_sales at 2025-11-09 12:20:44', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-09 06:35:44', '2025-11-09 06:35:44'),
(366, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-09 12:20:57', 'http://127.0.0.1:8000/installation-assignstore/1', NULL, NULL, '2025-11-09 06:35:57', '2025-11-09 06:35:57'),
(367, 1, 12, 'Super Admin Convert Lead Into Client : Akeem Gates at 2025-11-09 12:21:39', 'http://127.0.0.1:8000/installation-store/1', NULL, NULL, '2025-11-09 06:36:39', '2025-11-09 06:36:39'),
(368, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-09 15:40:09', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-09 09:55:09', '2025-11-09 09:55:09'),
(369, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-09 15:48:39', 'http://127.0.0.1:8000/supportdashboard/store', NULL, NULL, '2025-11-09 10:03:39', '2025-11-09 10:03:39'),
(370, 1, 12, 'Super Admin created. hot lead: Harrison Fitzpatrick at 2025-11-09 16:17:56', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-09 10:32:56', '2025-11-09 10:32:56'),
(371, 1, 12, 'Super Admin Convert Lead to Client: Joel Hopper-hot Lead -counter_sales at 2025-11-09 16:18:30', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-09 10:33:30', '2025-11-09 10:33:30'),
(372, 1, 12, 'Super Admin Task maintenance Created: at 2025-11-09 16:20:16', 'http://127.0.0.1:8000/registercustomet-ticket/store', NULL, NULL, '2025-11-09 10:35:16', '2025-11-09 10:35:16'),
(373, 1, 12, 'Super Admin created. hot lead: Priscilla Meyers at 2025-11-09 16:38:55', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-09 10:53:55', '2025-11-09 10:53:55'),
(374, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-10 12:16:06', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-10 06:31:06', '2025-11-10 06:31:06'),
(375, 1, 12, 'Super Admin created. hot lead: Cynthia Joyner at 2025-11-10 12:46:49', 'http://127.0.0.1:8000/leads', NULL, NULL, '2025-11-10 07:01:49', '2025-11-10 07:01:49'),
(376, 1, 12, 'Super Admin Convert Lead to Client: Nichole Cantu-hot Lead -wholeseller at 2025-11-10 12:47:31', 'http://127.0.0.1:8000/lead-convert/store', NULL, NULL, '2025-11-10 07:02:31', '2025-11-10 07:02:31'),
(377, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-10 12:50:53', 'http://127.0.0.1:8000/outsidercustomer-ticket/store', NULL, NULL, '2025-11-10 07:05:53', '2025-11-10 07:05:53'),
(378, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-10 16:28:51', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-10 10:43:51', '2025-11-10 10:43:51'),
(379, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-11 10:19:36', 'http://127.0.0.1:8000/installation-category-assignstore/3', NULL, NULL, '2025-11-11 04:34:36', '2025-11-11 04:34:36'),
(380, 1, 12, 'Super Admin Convert Lead Into Client : Nichole Cantu at 2025-11-11 10:20:32', 'http://127.0.0.1:8000/installation-category-store/3', NULL, NULL, '2025-11-11 04:35:32', '2025-11-11 04:35:32'),
(381, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-11 10:40:17', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-11 04:55:17', '2025-11-11 04:55:17'),
(382, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-11 10:41:22', 'http://127.0.0.1:8000/registercustomer-assignstore/2', NULL, NULL, '2025-11-11 04:56:22', '2025-11-11 04:56:22'),
(383, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-11 12:12:01', 'http://127.0.0.1:8000/installation-assignstore/2', NULL, NULL, '2025-11-11 06:27:01', '2025-11-11 06:27:01'),
(384, 1, 12, 'Super Admin Convert Lead Into Client : Joel Hopper at 2025-11-11 12:12:45', 'http://127.0.0.1:8000/installation-store/2', NULL, NULL, '2025-11-11 06:27:45', '2025-11-11 06:27:45'),
(385, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-11 16:57:53', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-11 11:12:53', '2025-11-11 11:12:53'),
(386, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-11 17:05:28', 'http://127.0.0.1:8000/registercustomer-assignstore/1', NULL, NULL, '2025-11-11 11:20:28', '2025-11-11 11:20:28'),
(387, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-12 10:12:51', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-12 04:27:51', '2025-11-12 04:27:51'),
(388, 1, 12, 'Super Admin Task maintenance Created: at 2025-11-12 10:19:13', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-12 04:34:13', '2025-11-12 04:34:13'),
(389, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-12 10:25:05', 'http://127.0.0.1:8000/registercustomer-assignstore/2', NULL, NULL, '2025-11-12 04:40:05', '2025-11-12 04:40:05'),
(390, 1, 12, 'Super Admin Outsider Customer Ticket  Created: at 2025-11-12 11:00:43', 'http://127.0.0.1:8000/outsidercustomer-ticket/customer-create', NULL, NULL, '2025-11-12 05:15:43', '2025-11-12 05:15:43'),
(391, 1, 12, 'Super Admin Task location_shifting Created: at 2025-11-12 11:19:42', 'http://127.0.0.1:8000/outsidercustomer-ticket/store/4', NULL, NULL, '2025-11-12 05:34:42', '2025-11-12 05:34:42'),
(392, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-12 11:46:42', 'http://127.0.0.1:8000/outsidercustomer-assignstore/4', NULL, NULL, '2025-11-12 06:01:42', '2025-11-12 06:01:42'),
(393, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-12 11:59:47', 'http://127.0.0.1:8000/registercustomer-assignstore/3', NULL, NULL, '2025-11-12 06:14:47', '2025-11-12 06:14:47'),
(394, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-13 14:03:19', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-13 08:18:19', '2025-11-13 08:18:19'),
(395, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-13 14:04:00', 'http://127.0.0.1:8000/registercustomer-ticket/assignstore/5', NULL, NULL, '2025-11-13 08:19:00', '2025-11-13 08:19:00'),
(396, 1, 12, 'Super Admin Outsider Customer Ticket  Created: at 2025-11-13 16:55:25', 'http://127.0.0.1:8000/outsidercustomer-ticket/customer-create', NULL, NULL, '2025-11-13 11:10:25', '2025-11-13 11:10:25'),
(397, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-13 16:55:45', 'http://127.0.0.1:8000/outsidercustomer-ticket/ticket/store/6', NULL, NULL, '2025-11-13 11:10:45', '2025-11-13 11:10:45'),
(398, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-13 16:57:24', 'http://127.0.0.1:8000/outsidercustomer-ticket/assignstore/6', NULL, NULL, '2025-11-13 11:12:24', '2025-11-13 11:12:24'),
(399, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-13 17:22:55', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-13 11:37:55', '2025-11-13 11:37:55'),
(400, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-14 16:20:20', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-14 10:35:20', '2025-11-14 10:35:20'),
(401, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-11-14 16:41:41', 'http://127.0.0.1:8000/amccustomer-ticket/assignstore/8', NULL, NULL, '2025-11-14 10:56:41', '2025-11-14 10:56:41'),
(402, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-16 10:34:02', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-16 04:49:02', '2025-11-16 04:49:02'),
(403, 1, 13, 'Super Admin Role Updated Super Admin at 2025-11-16 15:44:01', 'http://127.0.0.1:8000/roles/6', NULL, NULL, '2025-11-16 09:59:01', '2025-11-16 09:59:01'),
(404, 1, 13, 'Super Admin Role Updated Super Admin at 2025-11-16 15:44:37', 'http://127.0.0.1:8000/roles/6', NULL, NULL, '2025-11-16 09:59:37', '2025-11-16 09:59:37'),
(405, 1, 13, 'Super Admin Role Updated Super Admin at 2025-11-16 15:45:38', 'http://127.0.0.1:8000/roles/6', NULL, NULL, '2025-11-16 10:00:38', '2025-11-16 10:00:38'),
(406, 1, 13, 'Super Admin Role Updated Super Admin at 2025-11-16 15:46:39', 'http://127.0.0.1:8000/roles/6', NULL, NULL, '2025-11-16 10:01:39', '2025-11-16 10:01:39'),
(407, 1, 13, 'Super Admin Role Updated Super Admin at 2025-11-16 15:47:17', 'http://127.0.0.1:8000/roles/6', NULL, NULL, '2025-11-16 10:02:17', '2025-11-16 10:02:17'),
(408, 1, 13, 'Super Admin Outsider Customer Ticket  Created: at 2025-11-16 16:28:48', 'http://127.0.0.1:8000/outsidercustomer-ticket/customer-create', NULL, NULL, '2025-11-16 10:43:48', '2025-11-16 10:43:48'),
(409, 1, 13, 'Super Admin Task maintenance Created: at 2025-11-16 16:29:30', 'http://127.0.0.1:8000/outsidercustomer-ticket/ticket/store/2', NULL, NULL, '2025-11-16 10:44:30', '2025-11-16 10:44:30'),
(410, 1, 13, 'Super Admin Assign Lead to : Rudra Thata at 2025-11-16 16:30:02', 'http://127.0.0.1:8000/outsidercustomer-ticket/assignstore/2', NULL, NULL, '2025-11-16 10:45:02', '2025-11-16 10:45:02'),
(411, 1, 12, 'Super Admin changed AMC status: Silver AMC from on to off at 2025-11-18 11:45:52', 'http://127.0.0.1:8000/amc/status/1', NULL, NULL, '2025-11-18 06:00:52', '2025-11-18 06:00:52'),
(412, 1, 12, 'Super Admin created Amc: Gold Amc at 2025-11-18 18:26:57', 'http://127.0.0.1:8000/amc/1', NULL, NULL, '2025-11-18 12:41:57', '2025-11-18 12:41:57'),
(413, 1, 12, 'Super Admin created Amc: Gold Amc at 2025-11-18 18:27:10', 'http://127.0.0.1:8000/amc/1', NULL, NULL, '2025-11-18 12:42:10', '2025-11-18 12:42:10'),
(414, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 19:10:41', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-18 13:25:41', '2025-11-18 13:25:41'),
(415, 1, 12, 'Super Admin Outsider Customer Ticket  Created: at 2025-11-18 19:11:09', 'http://127.0.0.1:8000/outsidercustomer-ticket/customer-create', NULL, NULL, '2025-11-18 13:26:09', '2025-11-18 13:26:09'),
(416, 1, 12, 'Super Admin Task location_shifting Created: at 2025-11-18 19:11:22', 'http://127.0.0.1:8000/outsidercustomer-ticket/ticket/store/5', NULL, NULL, '2025-11-18 13:26:22', '2025-11-18 13:26:22'),
(417, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 19:25:05', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 13:40:05', '2025-11-18 13:40:05'),
(418, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 19:26:18', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 13:41:18', '2025-11-18 13:41:18'),
(419, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 19:46:28', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 14:01:28', '2025-11-18 14:01:28'),
(420, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 19:47:46', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 14:02:46', '2025-11-18 14:02:46'),
(421, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 20:30:56', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 14:45:56', '2025-11-18 14:45:56'),
(422, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 20:35:26', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 14:50:26', '2025-11-18 14:50:26'),
(423, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-18 20:38:53', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 14:53:53', '2025-11-18 14:53:53'),
(424, 1, 12, 'Super Admin Task location_shifting Created: at 2025-11-18 20:39:23', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-18 14:54:23', '2025-11-18 14:54:23'),
(425, 1, 12, 'Super Admin Task maintenance Created: at 2025-11-18 20:51:22', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-18 15:06:22', '2025-11-18 15:06:22'),
(426, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-19 11:14:20', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-19 05:29:20', '2025-11-19 05:29:20'),
(427, 1, 12, 'Super Admin Task location_shifting Created: at 2025-11-19 11:17:30', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-19 05:32:30', '2025-11-19 05:32:30'),
(428, 1, 12, 'Super Admin Assign Lead to : Min Bogati at 2025-11-19 11:35:00', 'http://127.0.0.1:8000/amccustomer-ticket/assignstore/2', NULL, NULL, '2025-11-19 05:50:00', '2025-11-19 05:50:00'),
(429, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-19 11:35:53', 'http://127.0.0.1:8000/amccustomer-ticket/assignstore/1', NULL, NULL, '2025-11-19 05:50:53', '2025-11-19 05:50:53'),
(430, 1, 12, 'Super Admin Outsider Customer Ticket  Created: at 2025-11-19 16:58:56', 'http://127.0.0.1:8000/outsidercustomer-ticket/customer-create', NULL, NULL, '2025-11-19 11:13:56', '2025-11-19 11:13:56'),
(431, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-19 17:03:37', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-19 11:18:37', '2025-11-19 11:18:37'),
(432, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-19 17:05:38', 'http://127.0.0.1:8000/registercustomer-ticket/assignstore/4', NULL, NULL, '2025-11-19 11:20:38', '2025-11-19 11:20:38'),
(433, 1, 12, 'Super Admin Task maintenance Created: at 2025-11-20 10:38:52', 'http://127.0.0.1:8000/registercustomer-ticket/store', NULL, NULL, '2025-11-20 04:53:52', '2025-11-20 04:53:52'),
(434, 1, 12, 'Super Admin Task normal_service Created: at 2025-11-20 10:49:12', 'http://127.0.0.1:8000/amccustomer-ticket/store', NULL, NULL, '2025-11-20 05:04:12', '2025-11-20 05:04:12'),
(435, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-20 12:42:56', 'http://127.0.0.1:8000/registercustomer-ticket/assignstore/5', NULL, NULL, '2025-11-20 06:57:56', '2025-11-20 06:57:56'),
(436, 1, 12, 'Super Admin Assign Lead to : new user dhng at 2025-11-20 12:57:59', 'http://127.0.0.1:8000/registercustomer-ticket/assignstore/5', NULL, NULL, '2025-11-20 07:12:59', '2025-11-20 07:12:59'),
(437, 1, 12, 'Super Admin Task maintenance Created: at 2025-11-20 14:48:14', 'http://127.0.0.1:8000/outsidercustomer-ticket/ticket/store/3', NULL, NULL, '2025-11-20 09:03:14', '2025-11-20 09:03:14'),
(438, 1, 12, 'Super Admin Assign Lead to : Sushil Kunwar at 2025-11-20 14:48:31', 'http://127.0.0.1:8000/outsidercustomer-ticket/assignstore/3', NULL, NULL, '2025-11-20 09:03:31', '2025-11-20 09:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `machineries`
--

CREATE TABLE `machineries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `original_price` int(11) DEFAULT NULL,
  `sales_price` int(11) DEFAULT NULL,
  `remaining_qty` int(11) DEFAULT NULL,
  `brand_id` varchar(255) NOT NULL,
  `offer_status` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) NOT NULL,
  `units` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `feature` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `backend_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machineries`
--

INSERT INTO `machineries` (`id`, `name`, `slug`, `original_price`, `sales_price`, `remaining_qty`, `brand_id`, `offer_status`, `category_id`, `units`, `description`, `feature`, `image`, `images`, `status`, `backend_price`, `created_at`, `updated_at`) VALUES
(1, 'Aqua Grand +', 'aqua-grand', NULL, 14999, NULL, '1', NULL, '1', 'Qty', '<p>sjdvsjhdvj</p>', '<p>sjdhvcsjcv</p>', '1737820653.jpg', '[\"1737820653_476ba8b84a339fbdff1ab4dceb5a275c.jpg\"]', 'off', NULL, '2025-01-25 15:57:33', '2025-06-30 11:47:35'),
(2, 'Aqua Smart', 'aqua-smart', NULL, 16999, NULL, '1', NULL, '1', 'Qty', '<p>fbdfhvbsjdhb</p>', '<p>sbjdhvsdhvbc</p>', '1737820722.png', '[\"1737820722_baba.jpeg\"]', 'on', NULL, '2025-01-25 15:58:42', '2025-01-25 15:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `machinery_stocks`
--

CREATE TABLE `machinery_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machinery_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `stock_in` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `stock_alert` int(11) NOT NULL DEFAULT 2,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_08_18_164334_create_blogs_table', 1),
(7, '2022_08_19_114056_create_advertisemments_table', 2),
(8, '2022_08_18_112449_create_faqs_table', 3),
(9, '2022_08_21_143255_create_sliders_table', 4),
(10, '2022_08_18_132042_create_teams_table', 5),
(11, '2022_08_19_102600_create_testimonials_table', 6),
(12, '2023_03_20_111716_create_permission_tables', 7),
(13, '2022_08_19_160037_create_vacancies_table', 8),
(14, '2023_03_21_080104_create_company_profiles_table', 9),
(18, '2023_06_02_160335_create_service_categories_table', 11),
(20, '2023_06_15_172726_create_why_us_table', 13),
(21, '2023_06_17_174840_create_galleries_table', 14),
(24, '2023_05_20_190550_create_services_table', 16),
(32, '2024_07_29_094425_create_subscribers_table', 19),
(33, '2024_07_31_093305_create_booking_services_table', 20),
(34, '2024_04_29_054317_create_students_table', 21),
(35, '2024_05_05_101210_create_student_fees_table', 21),
(36, '2024_08_02_052419_create_levels_table', 22),
(37, '2024_08_21_044140_create_branches_table', 23),
(39, '2014_10_12_000000_create_users_table', 24),
(40, '2024_08_21_054701_create_employees_table', 25),
(41, '2024_08_25_101053_create_employee_salaries_table', 26),
(43, '2024_08_25_101909_create_employee_commissions_table', 26),
(44, '2024_08_25_101930_create_employee_loans_table', 26),
(46, '2024_08_25_101801_create_employee_allowances_table', 27),
(48, '2024_09_01_103636_create_employee_sale_insentives_table', 28),
(49, '2024_09_09_111404_create_employee_advance_pays_table', 29),
(50, '2024_08_25_110917_create_employee_funds_table', 30),
(51, '2024_09_15_042545_create_employee_services_table', 31),
(54, '2024_09_13_094843_create_employee_payslips_table', 32),
(56, '2024_10_01_043335_create_employee_attendances_table', 33),
(58, '2024_10_01_043401_create_employee_attendance_requests_table', 34),
(62, '2024_12_11_143135_create_brands_table', 35),
(63, '2024_12_11_143155_create_products_table', 35),
(66, '2024_12_13_125238_create_product_categories_table', 35),
(68, '2024_12_19_121329_create_expense_categories_table', 36),
(70, '2023_07_12_172257_create_expenses_table', 37),
(71, '2024_12_23_212113_create_leave_types_table', 38),
(75, '2024_12_23_205738_create_leaves_table', 39),
(83, '2025_01_07_114535_create_lead_responses_table', 41),
(92, '2025_01_21_214239_create_customer_accessories_table', 42),
(93, '2025_01_21_214536_create_customer_products_table', 42),
(95, '2024_12_11_150308_create_machineries_table', 43),
(96, '2024_12_13_124148_create_accessories_table', 43),
(100, '2025_04_24_110951_create_emi_systems_table', 46),
(101, '2025_05_13_174647_create_machinery_stocks_table', 47),
(102, '2025_05_13_174659_create_accessory_stocks_table', 48),
(103, '2025_05_13_184111_create_product_stocks_table', 49),
(104, '2025_06_08_121519_create_petty_cashes_table', 50),
(105, '2025_06_08_152441_create_petty_cashes_table', 51),
(106, '2025_06_09_103054_create_petty_cash_requests_table', 52),
(107, '2025_06_09_124926_create_petty_cash_requests_table', 53),
(108, '2025_06_09_135642_create_petty_cash_requests_table', 54),
(114, '2025_06_12_130732_create_bikes_table', 60),
(115, '2025_06_12_130748_create_petrols_table', 60),
(116, '2025_06_12_171140_create_petrols_table', 61),
(117, '2025_06_12_171926_create_petrols_table', 62),
(118, '2025_06_15_115545_create_petrols_table', 63),
(120, '2025_06_15_160239_create_bikes_table', 65),
(121, '2025_06_16_112952_create_bike_services_table', 66),
(122, '2025_06_16_150508_create_bike_services_table', 67),
(123, '2025_06_19_113648_create_payments_table', 68),
(124, '2025_06_20_140813_create_payment_verifications_table', 69),
(125, '2025_06_20_150524_create_payment_verifieds_table', 70),
(126, '2025_06_22_115958_create_closing_balances_table', 71),
(127, '2025_06_22_131618_create_deposite_amounts_table', 72),
(128, '2025_06_22_132723_create_deposite_amounts_table', 73),
(129, '2025_06_23_122348_create_tasks_table', 74),
(130, '2025_06_24_132258_create_task_messages_table', 75),
(131, '2025_06_24_162442_create_tasks_table', 76),
(132, '2025_06_24_194814_create_tasks_table', 77),
(133, '2025_06_25_124938_create_task_service_items_table', 78),
(134, '2025_06_25_181428_create_task_service_items_table', 79),
(135, '2025_06_26_132533_create_out_side_tasks_table', 80),
(136, '2025_06_26_153507_create_out_side_tasks_table', 81),
(137, '2025_06_26_154438_create_out_side_tasks_table', 82),
(138, '2025_06_26_155002_create_out_side_tasks_table', 83),
(139, '2025_06_26_171738_create_out_side_tasks_table', 84),
(140, '2025_06_26_183824_create_outer_service_items_table', 85),
(141, '2025_06_26_190329_create_payment_verifications_table', 86),
(142, '2025_06_26_191633_create_outer_service_items_table', 87),
(143, '2025_06_26_192507_create_payment_verifieds_table', 88),
(144, '2025_06_27_115421_add_customer_type_to_payment_verifications_table', 89),
(145, '2025_06_09_054842_create_suppliers_table', 90),
(146, '2025_06_10_143150_create_device_purchases_table', 90),
(147, '2025_06_10_143220_create_device_purchase_accessories_table', 90),
(148, '2025_06_10_143229_create_device_purchase_machineries_table', 90),
(149, '2025_06_10_143238_create_inventories_table', 90),
(150, '2025_06_11_134132_create_accessories_device_purchase_table', 90),
(151, '2025_06_19_093434_create_sales_table', 90),
(152, '2025_06_19_093522_create_sales_accessories_table', 90),
(153, '2025_06_19_093533_create_sales_machineries_table', 90),
(154, '2025_06_21_074943_create_stock_transfers_table', 90),
(155, '2025_06_21_074957_create_stock_transfer_machineries_table', 90),
(156, '2025_06_21_075006_create_stock_transfe_accessories_table', 90),
(157, '2025_06_24_073431_create_emi_s_table', 90),
(158, '2025_06_24_130801_create_emi_customers_table', 90),
(159, '2025_06_27_165329_create_emi_payments_table', 90),
(160, '2025_06_30_150928_create_technical_tools_table', 91),
(161, '2025_06_30_155730_create_stock_issues_table', 92),
(162, '2025_06_30_160651_create_technical_tools_table', 92),
(163, '2025_06_30_172047_create_technical_tools_table', 93),
(164, '2025_06_30_183251_create_stock_issues_table', 94),
(165, '2025_06_30_183553_create_stock_issue_machineries_table', 94),
(166, '2025_06_30_183603_create_stock_issue_accessories_table', 94),
(167, '2025_06_30_183611_create_stock_issue_technical_tools_table', 94),
(168, '2025_07_06_135003_add_assign_to_and_message_to_customers_table', 95),
(169, '2025_07_07_213226_add_payment_fields_to_petrols_table', 95),
(170, '2025_07_07_213545_create_petrol_pumps_table', 95),
(171, '2025_07_09_130544_create_service_centers_table', 95),
(172, '2025_07_09_144357_add_payment_fields_to_bike_services_table', 95),
(173, '2025_07_13_164914_make_month_nullable_in_petty_cash_adds_table', 95),
(174, '2025_07_13_172002_make_month_nullable_in_petty_cash_request_table', 95),
(175, '2025_07_15_113910_add_installation_category_to_leads_table', 95),
(176, '2025_07_15_154722_add_installation_category_to_customers_table', 95),
(177, '2025_07_16_160819_add_amc_and_warranty_to_tasks_table', 95),
(178, '2025_07_16_163422_add_amc_and_warranty_to_out_side_tasks_table', 95),
(180, '2025_07_17_145610_create_amc_accessories_table', 96),
(181, '2025_07_19_005140_create_amc_assigns_table', 96),
(182, '2025_07_28_172904_create_amc_assign_accessories_table', 96),
(183, '2025_07_29_223621_add_gifted_to_customers_table', 96),
(184, '2025_07_31_161410_add_warranty_fields_to_customers', 96),
(185, '2025_08_01_152459_add_exchange_to_customer_products_table', 96),
(186, '2025_08_01_154303_create_exchanges_table', 96),
(187, '2025_09_15_110151_create_logs_table', 97),
(188, '2025_06_11_112049_create_petty_cash_adds_table', 98),
(189, '2025_06_15_125147_create_petty_cash_transactions_table', 99),
(190, '2025_06_09_233238_create_petty_cash_transfers_table', 100),
(191, '2025_09_19_115351_add_branch_id_to_amc_assigns_table', 100),
(201, '2025_10_07_165734_add_branch_code_to_branches_table', 103),
(202, '2025_01_06_124644_create_leads_table', 104),
(204, '2025_01_21_220649_create_customer_payments_table', 106),
(206, '2025_10_10_113222_create_contacts_table', 108),
(207, '2025_10_14_160351_create_user_details_table', 108),
(208, '2025_10_16_170335_create_customer_notes_table', 108),
(210, '2025_10_26_095028_create_skims_table', 110),
(212, '2025_11_03_174743_create_outsider_paymentverifications_table', 112),
(218, '2025_01_17_150045_create_customers_table', 115),
(227, '2025_11_10_165831_create_ticket_notes_table', 117),
(230, '2025_11_11_172208_create_customer_ticket_payments_table', 119),
(231, '2025_11_11_175359_create_customer_ticket_accessories_table', 119),
(233, '2025_07_17_133625_create_amcs_table', 121),
(237, '2025_11_10_091557_create_customer_tickets_table', 122),
(238, '2025_11_10_090855_create_amc_customers_table', 123);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(6, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 3),
(8, 'App\\Models\\User', 6),
(8, 'App\\Models\\User', 7),
(8, 'App\\Models\\User', 8),
(8, 'App\\Models\\User', 10),
(8, 'App\\Models\\User', 11),
(8, 'App\\Models\\User', 15),
(8, 'App\\Models\\User', 16),
(8, 'App\\Models\\User', 18),
(8, 'App\\Models\\User', 23),
(8, 'App\\Models\\User', 24),
(8, 'App\\Models\\User', 26),
(9, 'App\\Models\\User', 12),
(9, 'App\\Models\\User', 13),
(9, 'App\\Models\\User', 14),
(9, 'App\\Models\\User', 17),
(9, 'App\\Models\\User', 20),
(9, 'App\\Models\\User', 21),
(9, 'App\\Models\\User', 22),
(9, 'App\\Models\\User', 25),
(9, 'App\\Models\\User', 27);

-- --------------------------------------------------------

--
-- Table structure for table `outer_service_items`
--

CREATE TABLE `outer_service_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outer_service_items`
--

INSERT INTO `outer_service_items` (`id`, `task_id`, `name`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(1, 4, 'Pre Filter', 1, 250.00, '2025-06-26 13:47:26', '2025-06-26 13:47:26'),
(2, 5, 'Filter pipe', 1, 300.00, '2025-06-27 06:56:27', '2025-06-27 06:56:27'),
(3, 3, 'Filter pipe', 1, 300.00, '2025-06-27 07:13:11', '2025-06-27 07:13:11'),
(4, 3, 'Pre Filter', 1, 250.00, '2025-06-27 07:13:11', '2025-06-27 07:13:11'),
(5, 6, 'Pre Filter', 1, 250.00, '2025-06-27 07:30:53', '2025-06-27 07:30:53'),
(6, 7, 'Pre Filter', 1, 250.00, '2025-11-03 11:41:21', '2025-11-03 11:41:21'),
(7, 8, 'Pre Filter', 1, 250.00, '2025-11-03 11:48:39', '2025-11-03 11:48:39'),
(8, 8, 'Filter pipe', 1, 300.00, '2025-11-03 11:48:39', '2025-11-03 11:48:39'),
(9, 8, 'sdcsd', 1, 123.00, '2025-11-03 11:48:39', '2025-11-03 11:48:39'),
(10, 9, 'Pre Filter', 1, 250.00, '2025-11-03 12:07:44', '2025-11-03 12:07:44'),
(11, 9, 'Filter pipe', 1, 300.00, '2025-11-03 12:07:44', '2025-11-03 12:07:44'),
(12, 9, 'sdcsd', 1, 123.00, '2025-11-03 12:07:44', '2025-11-03 12:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `outsider_paymentverifications`
--

CREATE TABLE `outsider_paymentverifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `remaining_amount` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `customer_type` varchar(255) NOT NULL DEFAULT 'classic',
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `message` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outsider_paymentverifications`
--

INSERT INTO `outsider_paymentverifications` (`id`, `customer_id`, `branch_id`, `total_amount`, `paid_amount`, `remaining_amount`, `payment_method`, `payment_date`, `customer_type`, `status`, `message`, `receipt`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '9', '12', 1673, 1000, 673, 'online', '2025-11-03', 'classic', 'on', 'DDCSFd', NULL, 'Super Admin', '2025-11-03 12:07:44', '2025-11-03 12:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `out_side_tasks`
--

CREATE TABLE `out_side_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `product` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `support_type` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `priority` varchar(255) NOT NULL,
  `amc` enum('in','out') DEFAULT NULL,
  `warranty` enum('in','out') DEFAULT NULL,
  `assign_to` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `service_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'create',
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `out_side_tasks`
--

INSERT INTO `out_side_tasks` (`id`, `customer_id`, `name`, `branch_id`, `product`, `contact`, `email`, `date`, `support_type`, `service_type`, `priority`, `amc`, `warranty`, `assign_to`, `address`, `home_address`, `payment_method`, `service_charge`, `amount`, `paid_amount`, `message`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Ganesh Kunwar', '12', 'fdgfg', '454523535', 'super@super.com', '2025-06-26', 'normal_service', 'free', 'high', NULL, NULL, 'Min Bogati', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'done', 'complete', '1', '2025-06-26 11:48:36', '2025-06-26 13:05:05'),
(2, NULL, 'Editor', '13', 'ggty', '4467446667', 'kunwarganesh2003@gmail.com', '2025-06-26', 'maintenance', 'free', 'high', NULL, NULL, 'Rudra Thata', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'dsdffreeee', 'complete', '1', '2025-06-26 12:21:28', '2025-06-26 13:19:30'),
(3, NULL, 'Ganesh Kunwar', '12', 'fdgfg', '54554656546', 'super@super.com', '2025-06-26', 'maintenance', 'paid', 'high', NULL, NULL, 'Ganesh Kunwar', NULL, NULL, 'cash', 200.00, 750.00, 750.00, 'Payment Done', 'complete', '1', '2025-06-26 12:27:21', '2025-06-27 07:13:11'),
(4, NULL, 'Editor', '12', 'dfdfsdfsd', '42343243', 'minbogati@gmail.com', '2025-06-26', 'normal_service', 'paid', 'medium', NULL, NULL, 'Min Bogati', 'sadsfd', NULL, 'cash', 200.00, 450.00, 450.00, 'done', 'complete', '1', '2025-06-26 12:31:24', '2025-06-26 13:47:26'),
(5, NULL, 'Ganesh Kunwar', '12', 'ASDFG', '4467446667', 'kunwarganesh2003@gmail.com', '2025-06-27', 'location_shifting', 'paid', 'high', NULL, NULL, 'Min Bogati', 'ASDFG', 'FDSSA', 'online', 200.00, 500.00, 500.00, 'HYTRE', 'complete', '1', '2025-06-27 06:54:00', '2025-06-27 06:56:27'),
(6, NULL, 'Akash', '13', 'Filter Pipe', '54554656546', 'abhishek@gmail.com', '2025-06-27', 'normal_service', 'paid', 'high', NULL, NULL, 'Rudra Thata', 'Dhangadhi taranagar', 'Attariya', 'cash', 300.00, 550.00, 550.00, 'done', 'complete', '1', '2025-06-27 07:29:14', '2025-06-27 07:30:53'),
(7, NULL, 'Jada Bryant', '12', 'Voluptate voluptates', 'Qui cupiditate sint', 'wuvyv@mailinator.com', '1973-08-14', 'location_shifting', 'paid', 'low', 'out', 'out', 'Min Bogati', 'Ipsa quaerat nobis', 'Dicta dolor veniam', 'cash', 2000.00, 2250.00, 10000.00, 'DCSD', 'complete', '1', '2025-11-03 11:27:50', '2025-11-03 11:41:21'),
(8, NULL, 'Marvin Hoover', '12', 'Et cumque minim quis', 'Culpa ullam voluptat', 'dekic@mailinator.com', '1987-08-11', 'normal_service', 'paid', 'high', 'in', 'in', 'Sushil Kunwar', 'Sit cumque quas cons', 'Cumque odit esse fa', 'online', 500.00, 1173.00, 5000.00, 'XDVSFD', 'complete', '1', '2025-11-03 11:46:59', '2025-11-03 11:48:39'),
(9, NULL, 'Ruby Little', '12', 'Adipisicing nihil ex', 'Consectetur minima e', 'kuqabyxer@mailinator.com', '2022-09-25', 'maintenance', 'paid', 'high', 'in', 'in', 'Sushil Kunwar', 'Rerum quae irure qua', 'Deserunt mollitia do', 'online', 1000.00, 1673.00, 1000.00, 'DDCSFd', 'complete', '1', '2025-11-03 12:06:40', '2025-11-03 12:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `name`, `amount`, `payment_method`, `payment_date`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Amit Kumar', 3500, 'cash', '2025-06-19', 'on', 'First payment received.', '2025-06-19 06:13:39', '2025-06-19 06:13:39'),
(2, 'Karan', 2500, 'cash', '2025-06-20', 'on', 'Done', '2025-06-22 06:11:14', '2025-06-22 06:11:14'),
(3, 'Aniket', 3000, 'cash', '2025-06-19', 'on', 'Payment Complete', '2025-06-22 10:21:33', '2025-06-22 10:21:44'),
(4, 'Min Bogati', 2000, 'online', '2025-06-20', 'verify', 'Verified via modal', '2025-06-20 10:59:02', '2025-06-20 10:59:02'),
(5, 'min bogati', 5000, 'cash', '2025-06-21', 'on', 'Done', '2025-06-23 10:40:26', '2025-06-21 10:40:26'),
(6, 'Aman', 2500, 'cash', '2025-06-22', 'on', 'Complete', '2025-06-23 17:56:22', '2025-06-22 17:56:22'),
(7, 'Btl Ladki', 500, 'cash', '2025-06-26', 'verify', 'Verify', '2025-06-26 07:07:01', '2025-06-26 07:07:01'),
(8, 'Lead Payment', 450, 'cash', '2025-06-26', 'verify', NULL, '2025-06-26 13:56:30', '2025-06-26 13:56:30'),
(9, 'Lead Payment', 500, 'online', '2025-06-27', 'verify', 'perfect', '2025-06-27 07:11:34', '2025-06-27 07:11:34'),
(10, 'Lead Payment', 750, 'cash', '2025-06-27', 'verify', 'Verified', '2025-06-27 07:15:08', '2025-06-27 07:15:08'),
(11, 'Akash', 550, 'cash', '2025-06-27', 'verify', 'Done', '2025-06-27 07:31:41', '2025-06-27 07:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `payment_verifications`
--

CREATE TABLE `payment_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `lead_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `remaining_amount` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `message` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `customer_type` varchar(255) NOT NULL DEFAULT 'classic',
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_verifications`
--

INSERT INTO `payment_verifications` (`id`, `customer_id`, `lead_id`, `branch_id`, `total_amount`, `paid_amount`, `remaining_amount`, `payment_method`, `payment_date`, `status`, `message`, `receipt`, `customer_type`, `created_by`, `created_at`, `updated_at`) VALUES
(11, '19', '68', '12', 5550, 3000, 2550, NULL, '2025-11-03', 'on', 'bvgychnb', NULL, 'classic', 'Super Admin', '2025-11-03 12:48:01', '2025-11-03 12:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `payment_verifieds`
--

CREATE TABLE `payment_verifieds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `lead_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `remaining_amount` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `message` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_verifieds`
--

INSERT INTO `payment_verifieds` (`id`, `customer_id`, `lead_id`, `branch_id`, `total_amount`, `paid_amount`, `remaining_amount`, `payment_method`, `date`, `status`, `message`, `receipt`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '1', NULL, '12', 450, 450, 0, NULL, '2025-06-26', 'verify', NULL, NULL, NULL, '2025-06-26 13:56:30', '2025-06-26 13:56:30'),
(2, '5', NULL, '12', 500, 500, 0, NULL, '2025-06-27', 'verify', NULL, NULL, NULL, '2025-06-27 07:11:34', '2025-06-27 07:11:34'),
(3, '3', NULL, '12', 750, 750, 0, NULL, '2025-06-27', 'verify', NULL, NULL, NULL, '2025-06-27 07:15:08', '2025-06-27 07:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'edit_own_profile', 'web', '2022-08-04 03:34:28', '2022-08-04 03:34:28'),
(2, 'access_user_management', 'web', '2022-08-04 03:34:28', '2022-08-04 03:34:28'),
(72, 'access_settings', 'web', '2022-08-04 03:34:29', '2022-08-04 03:34:29'),
(94, 'access_sliders', 'web', '2023-03-21 05:28:39', '2023-03-21 05:28:43'),
(95, 'show_sliders', 'web', NULL, NULL),
(96, 'create_sliders', 'web', NULL, NULL),
(97, 'edit_sliders', 'web', NULL, NULL),
(98, 'delete_sliders', 'web', NULL, NULL),
(104, 'access_blogs', 'web', NULL, NULL),
(105, 'show_blogs', 'web', NULL, NULL),
(106, 'create_blogs', 'web', NULL, NULL),
(107, 'edit_blogs', 'web', NULL, NULL),
(108, 'delete_blogs', 'web', NULL, NULL),
(109, 'access_advertisements', 'web', NULL, NULL),
(110, 'show_advertisements', 'web', NULL, NULL),
(111, 'create_advertisements', 'web', NULL, NULL),
(112, 'edit_advertisements', 'web', NULL, NULL),
(113, 'delete_advertisements', 'web', NULL, NULL),
(114, 'access_teams', 'web', NULL, NULL),
(115, 'show_teams', 'web', NULL, NULL),
(116, 'create_teams', 'web', NULL, NULL),
(117, 'edit_teams', 'web', NULL, NULL),
(118, 'delete_teams', 'web', NULL, NULL),
(119, 'access_faqs', 'web', NULL, NULL),
(120, 'show_faqs', 'web', NULL, NULL),
(121, 'create_faqs', 'web', NULL, NULL),
(122, 'edit_faqs', 'web', NULL, NULL),
(123, 'delete_faqs', 'web', NULL, NULL),
(124, 'access_testimonials', 'web', NULL, NULL),
(125, 'show_testimonials', 'web', NULL, NULL),
(126, 'create_testimonials', 'web', NULL, NULL),
(127, 'edit_testimonials', 'web', NULL, NULL),
(128, 'delete_testimonials', 'web', NULL, NULL),
(129, 'access_vacancies', 'web', NULL, NULL),
(130, 'show_vacancies', 'web', NULL, NULL),
(131, 'create_vacancies', 'web', NULL, NULL),
(132, 'edit_vacancies', 'web', NULL, NULL),
(133, 'delete_vacancies', 'web', NULL, NULL),
(134, 'access_services', 'web', NULL, NULL),
(135, 'show_services', 'web', NULL, NULL),
(136, 'create_services', 'web', NULL, NULL),
(137, 'edit_services', 'web', NULL, NULL),
(138, 'delete_services', 'web', NULL, NULL),
(139, 'access_service_category', 'web', '2023-06-07 16:06:35', '2023-06-07 16:06:35'),
(140, 'show_service_category', 'web', '2023-06-07 16:06:35', '2023-06-07 16:06:35'),
(141, 'create_service_category', 'web', '2023-06-07 16:06:35', '2023-06-07 16:06:35'),
(142, 'edit_service_category', 'web', '2023-06-07 16:06:35', '2023-06-07 16:06:35'),
(143, 'delete_service_category', 'web', '2023-06-07 16:06:35', '2023-06-07 16:06:35'),
(144, 'access_branch', 'web', NULL, NULL),
(145, 'show_branch', 'web', NULL, NULL),
(146, 'create_branch', 'web', NULL, NULL),
(147, 'edit_branch', 'web', NULL, NULL),
(148, 'delete_branch', 'web', '2024-08-16 04:26:05', '2024-08-16 04:26:05'),
(149, 'access_pettycash', 'web', '2025-06-27 12:14:21', '2025-06-27 12:14:21'),
(150, 'show_pettycash', 'web', '2025-06-27 12:14:21', '2025-06-27 12:14:21'),
(151, 'create_pettycash', 'web', '2025-06-27 12:14:21', '2025-06-27 12:14:21'),
(152, 'edit_pettycash', 'web', '2025-06-27 12:14:21', '2025-06-27 12:14:21'),
(153, 'delete_pettycash', 'web', '2025-06-27 12:14:21', '2025-06-27 12:14:21'),
(154, 'access_ticket', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(155, 'show_ticket', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(156, 'create_ticket', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(157, 'edit_ticket', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(158, 'delete_ticket', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(159, 'access_finance', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(160, 'show_finance', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(161, 'create_finance', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(162, 'edit_finance', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(163, 'delete_finance', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(164, 'access_vehicle', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(165, 'show_vehicle', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(166, 'create_vehicle', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(167, 'edit_vehicle', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(168, 'delete_vehicle', 'web', '2025-06-27 12:20:08', '2025-06-27 12:20:08'),
(169, 'access_expense', 'web', '2025-06-27 12:35:43', '2025-06-27 12:35:43'),
(170, 'show_expense', 'web', '2025-06-27 12:35:43', '2025-06-27 12:35:43'),
(171, 'create_expense', 'web', '2025-06-27 12:35:43', '2025-06-27 12:35:43'),
(172, 'edit_expense', 'web', '2025-06-27 12:35:43', '2025-06-27 12:35:43'),
(173, 'delete_expense', 'web', '2025-06-27 12:35:43', '2025-06-27 12:35:43'),
(174, 'access_product', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(175, 'show_product', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(176, 'create_product', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(177, 'edit_product', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(178, 'delete_product', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(179, 'access_inventory', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(180, 'show_inventory', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(181, 'create_inventory', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(182, 'edit_inventory', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(183, 'delete_inventory', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(184, 'access_gallery', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(185, 'show_gallery', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(186, 'create_gallery', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(187, 'edit_gallery', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(188, 'delete_gallery', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(189, 'access_leave', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(190, 'show_leave', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(191, 'create_leave', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(192, 'edit_leave', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(193, 'delete_leave', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(194, 'access_inquiries', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(195, 'show_inquiries', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(196, 'create_inquiries', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(197, 'edit_inquiries', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(198, 'delete_inquiries', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(199, 'access_payroll', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(200, 'show_payroll', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(201, 'create_payroll', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(202, 'edit_payroll', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(203, 'delete_payroll', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(204, 'access_attandance', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(205, 'show_attandance', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(206, 'create_attandance', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(207, 'edit_attandance', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(208, 'delete_attandance', 'web', '2025-06-29 07:52:33', '2025-06-29 07:52:33'),
(209, 'access_attendance', 'web', '2025-06-29 07:55:11', '2025-06-29 07:55:11'),
(210, 'show_attendance', 'web', '2025-06-29 07:55:11', '2025-06-29 07:55:11'),
(211, 'create_attendance', 'web', '2025-06-29 07:55:11', '2025-06-29 07:55:11'),
(212, 'edit_attendance', 'web', '2025-06-29 07:55:11', '2025-06-29 07:55:11'),
(213, 'delete_attendance', 'web', '2025-06-29 07:55:11', '2025-06-29 07:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 28, 'auth_token', 'f6e3c84d78d7b88182c41a1193ae43b953e837ac91c46c3b6d02acb76ff650d0', '[\"*\"]', NULL, NULL, '2025-10-28 08:48:45', '2025-10-28 08:48:45'),
(2, 'App\\Models\\User', 29, 'auth_token', 'dc76c4e87b46ab0e97d93de37699e35094761ad49715c29e8c9a7371ae0eb50e', '[\"*\"]', NULL, NULL, '2025-10-28 09:40:12', '2025-10-28 09:40:12'),
(3, 'App\\Models\\User', 29, 'mobile_app_token', 'd2136788d350f0792c0dfeddd2c9a6efdaac1c3b6aad11c3395f4192a1aa55eb', '[\"*\"]', NULL, NULL, '2025-10-28 09:40:30', '2025-10-28 09:40:30'),
(4, 'App\\Models\\User', 29, 'mobile_app_token', '42aea0c2f7606a25259a3581adea8cf5d94a19118fdec29893100bde09f3c1bc', '[\"*\"]', NULL, NULL, '2025-10-28 09:56:23', '2025-10-28 09:56:23'),
(5, 'App\\Models\\User', 29, 'mobile_app_token', '03d32cb5a83154ea001d450770decfbf9325db154a3cdd2ba5cadc5e6469ffff', '[\"*\"]', NULL, NULL, '2025-10-28 09:56:34', '2025-10-28 09:56:34'),
(7, 'App\\Models\\User', 29, 'mobile_app_token', 'd7e687141a36124b9c0d0febb86b20d3b3d6a1c97a3fdabfbaff2d1f00ea3b64', '[\"*\"]', NULL, NULL, '2025-10-28 10:00:06', '2025-10-28 10:00:06'),
(8, 'App\\Models\\User', 29, 'mobile_app_token', 'ed25bbf978c918d3e7b2914d9b7bc65b8a5d3bf8cdf3d13bff3eec451c679316', '[\"*\"]', NULL, NULL, '2025-10-28 10:00:11', '2025-10-28 10:00:11'),
(9, 'App\\Models\\User', 29, 'mobile_app_token', '1435a7f717d25ca7ae689f4dd40cd95e7375d38ecbb21379a8145562bd92546b', '[\"*\"]', '2025-10-28 10:00:21', NULL, '2025-10-28 10:00:13', '2025-10-28 10:00:21'),
(12, 'App\\Models\\User', 29, 'mobile_app_token', 'da4e7bb5219bcf367adbc87ed87ad752940697be9d884b15376beea24529bc96', '[\"*\"]', '2025-10-28 10:27:47', NULL, '2025-10-28 10:27:43', '2025-10-28 10:27:47'),
(13, 'App\\Models\\User', 29, 'mobile_app_token', '007f0e622e919f62db1ba442d449afc9d0fe99d44549c20a2aa4b1372dca7d6c', '[\"*\"]', '2025-10-28 10:29:39', NULL, '2025-10-28 10:28:08', '2025-10-28 10:29:39'),
(21, 'App\\Models\\User', 30, 'mobile_app_token', '0da6b64fd307eef103e2a8a63a9cdf22632eb90e0a757ea6be7dca1faddf22ff', '[\"*\"]', '2025-10-28 10:47:43', NULL, '2025-10-28 10:47:38', '2025-10-28 10:47:43'),
(23, 'App\\Models\\User', 29, 'mobile_app_token', '03a13dd1684937c706ff27a96217a90e58f805eec9135076945c749581bd98f1', '[\"*\"]', NULL, NULL, '2025-10-28 14:15:57', '2025-10-28 14:15:57'),
(25, 'App\\Models\\User', 29, 'mobile_app_token', 'c9724dfedd1d374a372f75350830fa74d0570787e217e7557eb5c45edca3ad4f', '[\"*\"]', '2025-10-29 10:59:09', NULL, '2025-10-29 10:32:45', '2025-10-29 10:59:09'),
(28, 'App\\Models\\User', 29, 'mobile_app_token', 'a427746baec696a23068940beddc2d316fb5d1974d4560ebeffbdd9c3a2f9657', '[\"*\"]', NULL, NULL, '2025-10-29 11:22:35', '2025-10-29 11:22:35'),
(31, 'App\\Models\\User', 31, 'auth_token', '35e924f9320608ad4483130915b9dd47fef06471178372bf559e16182f8008ac', '[\"*\"]', NULL, NULL, '2025-10-29 11:29:12', '2025-10-29 11:29:12'),
(32, 'App\\Models\\User', 31, 'mobile_app_token', 'dfae0ca115b29a9919dcd6319a87abb478f7e21fee46a7435df8bfe755651cab', '[\"*\"]', NULL, NULL, '2025-10-29 11:29:36', '2025-10-29 11:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `petrols`
--

CREATE TABLE `petrols` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bike_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `petrol_pump` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `km` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petrols`
--

INSERT INTO `petrols` (`id`, `bike_id`, `amount`, `date`, `mode`, `cheque_number`, `petrol_pump`, `image`, `km`, `payment_type`, `message`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(9, '1', 500.00, '2025-06-15', 'petty cash', NULL, NULL, '1750011100.jpg', '250', NULL, 'Petrol for Bike', '1', 'on', '2025-06-15 18:26:40', '2025-06-15 18:26:40');

-- --------------------------------------------------------

--
-- Table structure for table `petrol_pumps`
--

CREATE TABLE `petrol_pumps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petty_cash_adds`
--

CREATE TABLE `petty_cash_adds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `month` varchar(255) DEFAULT NULL,
  `lm_remaining_cash` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining_cash` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `slug` varchar(255) NOT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `transfer_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petty_cash_adds`
--

INSERT INTO `petty_cash_adds` (`id`, `title`, `amount`, `date`, `month`, `lm_remaining_cash`, `remaining_cash`, `total_amount`, `slug`, `branch_id`, `created_by`, `requested_by`, `transfer_by`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(15, 'November', 8000.00, '2025-11-02', NULL, 13000.00, 0.00, 21000.00, 'november', '12', '1', NULL, NULL, 'on', NULL, '2025-11-02 09:36:58', '2025-11-04 04:03:42'),
(16, 'December', 0.00, '2025-12-04', NULL, 21000.00, 0.00, 21000.00, 'december', '12', '1', NULL, NULL, 'on', NULL, '2025-11-04 04:01:54', '2025-11-04 11:36:29'),
(17, 'SDASD', 0.00, '2025-11-04', NULL, 20000.00, 20000.00, 20000.00, 'sdasd', '12', '1', NULL, NULL, 'on', NULL, '2025-11-04 11:36:29', '2025-11-04 11:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `petty_cash_requests`
--

CREATE TABLE `petty_cash_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `requested_by` int(11) DEFAULT NULL,
  `transfer_by` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petty_cash_transactions`
--

CREATE TABLE `petty_cash_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total_cash_before` decimal(10,2) NOT NULL,
  `remaining_cash_after` decimal(10,2) NOT NULL,
  `message` text DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petty_cash_transactions`
--

INSERT INTO `petty_cash_transactions` (`id`, `branch_id`, `type`, `amount`, `total_cash_before`, `remaining_cash_after`, `message`, `reference_id`, `created_by`, `created_at`, `updated_at`) VALUES
(9, 12, '1', 3000.00, 10000.00, 7000.00, 'FGFSD: DFSFV', 32, 1, '2025-11-02 07:35:50', '2025-11-02 07:35:50'),
(10, 12, '5', 2000.00, 7000.00, 0.00, 'HBSDHVHF: KDHCYUDCBN', 33, 1, '2025-11-02 07:36:17', '2025-11-04 04:01:54'),
(11, 12, '1', 1000.00, 21000.00, 20000.00, 'Nostrum eum ad quibu: Quod nisi eu elit s', 35, 1, '2025-11-04 04:04:39', '2025-11-04 11:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `petty_cash_transfers`
--

CREATE TABLE `petty_cash_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `requested_by` int(11) DEFAULT NULL,
  `transfer_by` int(11) DEFAULT NULL,
  `transfer_method` varchar(255) NOT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `original_price` int(11) DEFAULT NULL,
  `sales_price` int(11) DEFAULT NULL,
  `remaining_qty` int(11) DEFAULT NULL,
  `brand_id` varchar(255) NOT NULL,
  `offer_status` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `feature` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `backend_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Filter', 'filter', '1734098593.webp', 'Culpa aut amet faci', 'on', '2024-12-13 13:58:53', '2025-01-25 15:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `stock_in` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `stock_alert` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(6, 'Super Admin', 'web', '2023-03-21 00:20:34', '2023-03-21 00:20:34'),
(8, 'Admin', 'web', '2024-08-20 06:00:28', '2024-08-20 06:00:28'),
(9, 'Receptionist', 'web', '2024-08-24 21:41:06', '2024-08-24 21:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 6),
(1, 8),
(2, 6),
(2, 8),
(72, 6),
(72, 8),
(72, 9),
(94, 6),
(94, 8),
(94, 9),
(95, 6),
(95, 8),
(95, 9),
(96, 6),
(96, 8),
(96, 9),
(97, 6),
(97, 8),
(97, 9),
(98, 6),
(98, 8),
(98, 9),
(104, 6),
(104, 8),
(104, 9),
(105, 6),
(105, 8),
(105, 9),
(106, 6),
(106, 8),
(106, 9),
(107, 6),
(107, 8),
(107, 9),
(108, 6),
(108, 8),
(108, 9),
(109, 6),
(109, 8),
(109, 9),
(110, 6),
(110, 8),
(110, 9),
(111, 6),
(111, 8),
(111, 9),
(112, 6),
(112, 8),
(112, 9),
(113, 6),
(113, 8),
(113, 9),
(114, 6),
(114, 8),
(114, 9),
(115, 6),
(115, 8),
(115, 9),
(116, 6),
(116, 8),
(116, 9),
(117, 6),
(117, 8),
(117, 9),
(118, 6),
(118, 8),
(118, 9),
(119, 6),
(119, 8),
(119, 9),
(120, 6),
(120, 8),
(120, 9),
(121, 6),
(121, 8),
(121, 9),
(122, 6),
(122, 8),
(122, 9),
(123, 6),
(123, 8),
(123, 9),
(124, 6),
(124, 8),
(124, 9),
(125, 6),
(125, 8),
(125, 9),
(126, 6),
(126, 8),
(126, 9),
(127, 6),
(127, 8),
(127, 9),
(128, 6),
(128, 8),
(128, 9),
(129, 6),
(129, 8),
(130, 6),
(130, 8),
(131, 6),
(131, 8),
(132, 6),
(132, 8),
(133, 6),
(133, 8),
(134, 6),
(134, 8),
(135, 6),
(135, 8),
(136, 6),
(136, 8),
(137, 6),
(137, 8),
(138, 6),
(138, 8),
(139, 6),
(139, 8),
(140, 6),
(140, 8),
(141, 6),
(141, 8),
(142, 6),
(142, 8),
(143, 6),
(143, 8),
(144, 6),
(145, 6),
(146, 6),
(147, 6),
(148, 6),
(149, 6),
(149, 8),
(149, 9),
(150, 6),
(150, 8),
(150, 9),
(151, 6),
(151, 8),
(151, 9),
(152, 6),
(152, 8),
(152, 9),
(153, 6),
(153, 8),
(153, 9),
(154, 6),
(155, 6),
(156, 6),
(157, 6),
(158, 6),
(159, 6),
(160, 6),
(161, 6),
(162, 6),
(163, 6),
(164, 6),
(165, 6),
(166, 6),
(167, 6),
(168, 6),
(169, 6),
(169, 8),
(170, 6),
(170, 8),
(171, 6),
(171, 8),
(172, 6),
(172, 8),
(173, 6),
(173, 8),
(174, 6),
(175, 6),
(176, 6),
(177, 6),
(178, 6),
(179, 6),
(180, 6),
(181, 6),
(182, 6),
(183, 6),
(184, 6),
(185, 6),
(186, 6),
(187, 6),
(188, 6),
(189, 6),
(190, 6),
(191, 6),
(192, 6),
(193, 6),
(194, 6),
(195, 6),
(196, 6),
(197, 6),
(198, 6),
(199, 6),
(200, 6),
(201, 6),
(202, 6),
(203, 6),
(209, 6),
(210, 6),
(211, 6),
(212, 6),
(213, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `landline` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `balance_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_accessories`
--

CREATE TABLE `sales_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_machineries`
--

CREATE TABLE `sales_machineries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `machinery_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `shortDescription` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'off',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `short_description` text NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'off',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `title`, `slug`, `icon`, `image`, `short_description`, `description`, `status`, `created_at`, `updated_at`) VALUES
(8, 'fgdfg', 'fgdfg', '1758596158.png', '1758596158.png', '<p>gfdghg</p>', '<p>gdgfdg</p>', 'on', '2025-09-23 02:55:58', '2025-09-23 02:55:58'),
(9, 'Tgg', 'tgg', '1758596216.png', '1758596216.jpg', 'gfgdfgdfg', 'dgdfgdfgfdg', 'on', '2025-09-23 02:56:56', '2025-09-23 02:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `service_centers`
--

CREATE TABLE `service_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skims`
--

CREATE TABLE `skims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `skim_item_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skims`
--

INSERT INTO `skims` (`id`, `lead_id`, `branch_id`, `customer_id`, `skim_item_name`, `created_at`, `updated_at`) VALUES
(1, 36, 12, 2, 'HeadPhone', '2025-10-26 04:12:02', '2025-10-26 04:12:02'),
(2, 42, 12, 8, 'HeadPhone', '2025-10-29 13:34:44', '2025-10-29 13:34:44'),
(3, 58, 12, 10, 'Celling Fan 1 Pcs', '2025-10-30 09:01:40', '2025-10-30 09:01:40'),
(4, 37, 15, 18, 'Laptop', '2025-10-31 12:07:06', '2025-10-31 12:07:06'),
(5, 68, 12, 19, 'Laptop', '2025-10-31 12:10:09', '2025-10-31 12:10:09'),
(6, 70, 12, 20, 'REETGG', '2025-11-02 05:04:36', '2025-11-02 05:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` longtext NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `link`, `image`, `status`, `short_description`, `description`, `created_at`, `updated_at`) VALUES
(3, 'Trustworthy & Efficient', 'https://www.hawixaco.biz', '1761624077.png', NULL, NULL, NULL, '2023-03-20 01:31:30', '2025-10-28 08:46:17'),
(4, 'Our Popular Services', 'https://txtformat.com/', '1761624011.png', 'on', NULL, NULL, '2024-07-26 04:46:25', '2025-10-28 08:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `stock_issues`
--

CREATE TABLE `stock_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_issues`
--

INSERT INTO `stock_issues` (`id`, `requested_by`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'dfg', 'pending', '2025-06-30 14:09:56', '2025-06-30 14:09:56'),
(2, 1, 'dfg', 'pending', '2025-06-30 14:12:39', '2025-06-30 14:12:39'),
(3, 1, 'dfg', 'accepted', '2025-06-30 14:16:06', '2025-07-01 06:18:55'),
(4, 1, 'dfg', 'rejected', '2025-06-30 14:17:11', '2025-07-01 06:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `stock_issue_accessories`
--

CREATE TABLE `stock_issue_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_issue_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_issue_accessories`
--

INSERT INTO `stock_issue_accessories` (`id`, `stock_issue_id`, `accessory_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, '2025-06-30 14:16:06', '2025-06-30 14:16:06'),
(2, 3, 3, 1, '2025-06-30 14:16:06', '2025-06-30 14:16:06'),
(3, 4, 1, 1, '2025-06-30 14:17:11', '2025-06-30 14:17:11'),
(4, 4, 3, 1, '2025-06-30 14:17:11', '2025-06-30 14:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `stock_issue_machineries`
--

CREATE TABLE `stock_issue_machineries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_issue_id` bigint(20) UNSIGNED NOT NULL,
  `machinery_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_issue_machineries`
--

INSERT INTO `stock_issue_machineries` (`id`, `stock_issue_id`, `machinery_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-06-30 14:09:56', '2025-06-30 14:09:56'),
(2, 2, 1, 1, '2025-06-30 14:12:39', '2025-06-30 14:12:39'),
(3, 3, 1, 1, '2025-06-30 14:16:06', '2025-06-30 14:16:06'),
(4, 4, 1, 1, '2025-06-30 14:17:11', '2025-06-30 14:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `stock_issue_technical_tools`
--

CREATE TABLE `stock_issue_technical_tools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_issue_id` bigint(20) UNSIGNED NOT NULL,
  `technical_tool_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_issue_technical_tools`
--

INSERT INTO `stock_issue_technical_tools` (`id`, `stock_issue_id`, `technical_tool_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 2, '2025-06-30 14:16:06', '2025-06-30 14:16:06'),
(2, 4, 2, 2, '2025-06-30 14:17:11', '2025-06-30 14:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_branch_id` bigint(20) UNSIGNED NOT NULL,
  `to_branch_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_date` date NOT NULL,
  `status` enum('pending','in_transit','completed','cancelled') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_accessories`
--

CREATE TABLE `stock_transfer_accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `serial_numbers` varchar(255) DEFAULT NULL,
  `condition` enum('new','used','refurbished','damaged') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_machineries`
--

CREATE TABLE `stock_transfer_machineries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `machinery_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `serial_numbers` varchar(255) DEFAULT NULL,
  `condition` enum('new','used','refurbished','damaged') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'minbogati13579@gmail.com', 'on', '2024-07-29 04:22:05', '2024-07-29 04:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `PAN` varchar(255) NOT NULL,
  `VAT` varchar(255) DEFAULT NULL,
  `discription` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `support_type` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `priority` varchar(255) NOT NULL,
  `amc` enum('in','out') DEFAULT NULL,
  `warranty` enum('in','out') DEFAULT NULL,
  `assign_to` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `service_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'create',
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `customer_id`, `support_type`, `service_type`, `priority`, `amc`, `warranty`, `assign_to`, `payment_method`, `service_charge`, `amount`, `paid_amount`, `message`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(13, '19', 'normal_service', 'paid', 'high', 'in', 'in', 'new user dhng', NULL, 500.00, 800.00, 0.00, 'SDCADa', 'complete', '1', '2025-11-03 06:35:24', '2025-11-03 10:25:23'),
(14, '19', 'normal_service', 'paid', 'high', 'in', 'in', 'Min Bogati', NULL, 5000.00, 5550.00, 0.00, 'bvgychnb', 'complete', '1', '2025-11-03 12:47:10', '2025-11-03 12:48:01'),
(15, '19', 'maintenance', NULL, 'high', 'in', 'out', 'Min Bogati', NULL, 0.00, 0.00, 0.00, 'JBXXHSVCHD', 'assign', '1', '2025-11-03 12:53:14', '2025-11-03 12:53:37'),
(16, '19', 'normal_service', NULL, 'high', 'out', 'out', 'Min Bogati', NULL, 0.00, 0.00, 0.00, 'bhgfvb', 'assign', '1', '2025-11-04 05:04:12', '2025-11-04 05:05:23'),
(17, '19', 'normal_service', NULL, 'medium', 'in', 'in', NULL, NULL, 0.00, 0.00, 0.00, 'DSFDDFxc', 'create', '1', '2025-11-05 04:55:32', '2025-11-05 04:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `task_messages`
--

CREATE TABLE `task_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_service_items`
--

CREATE TABLE `task_service_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `introduction` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `email`, `phone`, `designation`, `introduction`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Mac Alexixe', 'kesy@mailinator.com', '9812345670', 'Senior Plumber', '<div style=\"line-height: 19px;\"><div style=\"\">Handymen can tackle minor plumbing issues like unclogging</div><div style=\"\">                                                drains, fixing leaky pipes, installing.</div></div>', '1722141997.jpg', 'on', '2023-03-20 04:09:29', '2024-07-27 23:01:37'),
(3, 'Henry Joseph', 'herny@servicesathi.com', '6532148970', 'Junior Carpenter', '<div style=\"line-height: 19px;\"><div style=\"\">Handymen can tackle minor plumbing issues like unclogging</div><div style=\"\">                                                drains, fixing leaky pipes, installing.</div></div>', '1722143349.jpg', 'on', '2024-07-27 23:24:09', '2024-07-27 23:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `technical_tools`
--

CREATE TABLE `technical_tools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technical_tools`
--

INSERT INTO `technical_tools` (`id`, `tool_name`, `model_name`, `price`, `image`, `description`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Filter Pipe', 'S14', 299.00, '1751284818.jpg', 'Technical Tool', 15, 'on', '2025-06-30 12:15:18', '2025-06-30 12:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `message`, `status`, `image`, `created_at`, `updated_at`) VALUES
(2, 'What services does your company offer?', 'We specialize in a range of IT solutions including web development, IT training, digital marketing, and more. Whether you need a custom website, professional training for your team, or a comprehensive digital marketing strategy, we\'ve got you covered.<br>', 'on', '1679309452.jpg', '2023-03-20 05:05:52', '2024-03-01 10:46:43'),
(3, 'How experienced is your team?', '<p>Our team consists of seasoned professionals with years of experience in the IT industry. From expert developers and certified trainers to creative digital marketers, each member brings a wealth of knowledge and expertise to every project.<br></p>', 'on', '1710352005.png', '2024-03-01 10:48:04', '2024-03-13 12:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_notes`
--

CREATE TABLE `ticket_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_notes`
--

INSERT INTO `ticket_notes` (`id`, `ticket_id`, `note`, `created_at`, `updated_at`) VALUES
(33, NULL, 'AAJH HAMI AAUDAINAN', '2025-11-16 07:54:08', '2025-11-16 07:54:08'),
(34, NULL, '<p>SAFFDA</p>', '2025-11-16 10:43:48', '2025-11-16 10:43:48'),
(35, NULL, 'GDSDFDS', '2025-11-16 10:44:30', '2025-11-16 10:44:30'),
(36, NULL, 'Assign to Rudhra Thapa', '2025-11-16 10:45:02', '2025-11-16 10:45:02'),
(37, NULL, NULL, '2025-11-16 10:46:52', '2025-11-16 10:46:52'),
(38, 4, 'SDADS', '2025-11-18 13:25:41', '2025-11-18 13:25:41'),
(39, 5, '<p>FSDDSF</p>', '2025-11-18 13:26:09', '2025-11-18 13:26:09'),
(40, 5, 'SDAD', '2025-11-18 13:26:22', '2025-11-18 13:26:22'),
(41, NULL, 'BJSBDU', '2025-11-18 13:40:05', '2025-11-18 13:40:05'),
(42, NULL, 'NSDJBUAJB', '2025-11-18 13:41:18', '2025-11-18 13:41:18'),
(43, 9, 'JJDBU', '2025-11-18 14:01:28', '2025-11-18 14:01:28'),
(44, 10, 'BSJBS', '2025-11-18 14:02:46', '2025-11-18 14:02:46'),
(45, NULL, 'JNJDBSAJ', '2025-11-18 14:45:56', '2025-11-18 14:45:56'),
(46, NULL, 'KNSDJBNJ', '2025-11-18 14:50:26', '2025-11-18 14:50:26'),
(47, 3, 'FDSF', '2025-11-18 14:53:53', '2025-11-18 14:53:53'),
(48, 4, 'fdgngfds', '2025-11-18 14:54:23', '2025-11-18 14:54:23'),
(49, 5, 'jhx', '2025-11-18 15:06:22', '2025-11-18 15:06:22'),
(50, 1, 'DASDS', '2025-11-19 05:29:20', '2025-11-19 05:29:20'),
(51, 2, 'efgh', '2025-11-19 05:32:30', '2025-11-19 05:32:30'),
(52, 2, 'Assign to Min', '2025-11-19 05:50:00', '2025-11-19 05:50:00'),
(53, 1, 'Sushil', '2025-11-19 05:50:53', '2025-11-19 05:50:53'),
(54, 2, NULL, '2025-11-19 05:53:45', '2025-11-19 05:53:45'),
(55, 1, NULL, '2025-11-19 06:17:04', '2025-11-19 06:17:04'),
(56, 3, '<p>dfgdfg</p>', '2025-11-19 11:13:56', '2025-11-19 11:13:56'),
(57, 4, 'FDHGG', '2025-11-19 11:18:37', '2025-11-19 11:18:37'),
(58, 4, 'Assign to Sushil', '2025-11-19 11:20:38', '2025-11-19 11:20:38'),
(59, 4, NULL, '2025-11-19 11:26:10', '2025-11-19 11:26:10'),
(60, 5, 'SDAD', '2025-11-20 04:53:52', '2025-11-20 04:53:52'),
(61, 6, 'sdfg', '2025-11-20 05:04:12', '2025-11-20 05:04:12'),
(62, 5, 'Assign to Sushil', '2025-11-20 06:57:56', '2025-11-20 06:57:56'),
(63, 5, 'AAJH HAMI AAUDAINAN', '2025-11-20 07:00:06', '2025-11-20 07:00:06'),
(64, 5, 'AAJH HAMI AAUDAINAN', '2025-11-20 07:12:59', '2025-11-20 07:12:59'),
(65, 3, 'vuvh', '2025-11-20 09:03:14', '2025-11-20 09:03:14'),
(66, 3, 'vuvh', '2025-11-20 09:03:31', '2025-11-20 09:03:31'),
(67, 3, NULL, '2025-11-20 09:11:06', '2025-11-20 09:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role_id` varchar(255) DEFAULT NULL,
  `access_type` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `role_id`, `access_type`, `branch_id`, `created_by`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super@super.com', NULL, '$2y$10$ku6zpVY.tztIOhSWhYr97eKLzA0CiQch8AAYINhs8v1VWauOr.6OK', '1679394077.jpg', '6', NULL, NULL, NULL, 'on', NULL, '2023-03-18 23:58:14', '2023-03-21 04:36:17'),
(16, 'Min Bogati', 'min@classicro.com.np', NULL, '$2y$10$gG3gkXjptsm37/4xa9UC7OYXW282ZE0sq3ww13FAyepmXDz0Wo6f.', NULL, '8', 'Admin', '12', '1', 'on', NULL, '2024-11-11 05:59:39', '2025-09-15 02:50:42'),
(17, 'Sushil Kunwar', 'sushil@classicro.com.np', NULL, '$2y$10$QonvVqeS2JGX6KJ.2GQzG.AoQy7c/2lCWXFOhtGuIUZO4EYF.dcmW', '1731304876.png', '9', NULL, '12', '1', 'on', NULL, '2024-11-11 06:01:16', '2024-11-11 06:01:16'),
(18, 'Rudra Thata', 'btladmin@gmail.com', NULL, '$2y$10$YhsOx7639v.aNB0So.ovKutt.9KDHtuTME1ZymGg4o0VBImSfqUB2', NULL, '8', 'Admin', '13', '1', 'on', NULL, '2025-02-18 15:15:36', '2025-02-18 15:15:36'),
(20, 'ASDFG', 'kunwarganesh2003@gmail.com', NULL, '$2y$10$ozy3VDN8Z7qb8AknOXMtte2TUE9xJ8ShH0vRcpPWlz7gJ6fYX9M7C', '1749981787.jpg', '9', 'Receptionist', '13', '1', 'on', NULL, '2025-06-15 10:18:07', '2025-06-15 10:18:07'),
(21, 'new user dhng', 'cazidizyj@mailinator.com', NULL, '$2y$10$8kkoxmGBd4.L.4IIxKRYn.mq1NT6glYAF3UHnTJCC8j3vxeTDw2gm', '1756312800.jpg', '9', 'Receptionist', '12', '1', 'on', NULL, '2025-08-27 16:40:00', '2025-08-27 16:40:00'),
(22, 'new user btl', 'nucoqimuto@mailinator.com', NULL, '$2y$10$8HqMy6fr.TdMzrdOdUOySu0//o7DxHWZef826GqeOctA0rzH7KI8G', '1756312829.jpg', '9', 'Receptionist', '13', '1', 'on', NULL, '2025-08-27 16:40:29', '2025-08-27 16:40:29'),
(23, 'suresh bhatt', 'suresh@classicro.com.np', NULL, '$2y$10$fd0VTzGqzs0CN8iK.z2hVOS1oQ7kYQNFtXW5tYE5vnshMw187apJy', NULL, '8', 'Admin', '14', '1', 'on', NULL, '2025-08-28 10:28:05', '2025-08-28 10:28:05'),
(24, 'Sandesh Bogati', 'sandeshb@classicro.com.np', NULL, '$2y$10$7lcIuD.bCC41rYavFlRRBOHu2dEEld0Q.04snKFhqG.ui50PNPCD.', NULL, '8', 'Admin', '15', '1', 'on', NULL, '2025-09-12 08:15:51', '2025-09-12 08:15:51'),
(25, 'miiiin bbbbb', 'miiii@classicro.com.np', NULL, '$2y$10$0IJfhX3jg2Jiyi0HcDApSuVaxGKmX4.2AotDK.ndCNF5QDEjKDFxq', '1757665182.jpg', '9', 'Receptionist', '15', '24', 'on', NULL, '2025-09-12 08:19:42', '2025-09-12 08:19:42'),
(26, 'Sybil Gould', 'qigumo@mailinator.com', NULL, '$2y$10$Jrqbldrk9FWokD0tATLl5eeFjVyq2uQYKzaegwfan9a.jd3vHpnYG', NULL, '8', 'Admin', '16', '1', 'on', NULL, '2025-10-07 11:19:41', '2025-10-07 11:19:41'),
(27, 'Ganesh Kunwar', 'kunwarganesh20003@gmail.com', NULL, '$2y$10$wSK5whcFCG5CpbaCDWb2NuJvWTnEI3oUWemz9aL9is.2nuMj2.YO.', '1760521876.jpg', '9', 'Receptionist', '12', '1', 'on', NULL, '2025-10-15 09:51:17', '2025-10-15 09:51:17'),
(28, 'Brielle Garza', 'muvik@mailinator.com', NULL, '$2y$10$8QzEVDmBFCv.3VXHIGTJ9uITri8vsEqWi8HotkT4W4QXbbeYYEz7W', NULL, NULL, 'user', NULL, NULL, 'active', NULL, '2025-10-28 08:48:45', '2025-10-28 08:48:45'),
(29, 'Nepal', 'Nepal@gmail.com', NULL, '$2y$10$Yqar2I.d6sW.ntRvgOjJMODIAbkb7CUg5Wl4sf.J9C/Rm2v77MpKy', NULL, NULL, 'user', NULL, NULL, 'active', NULL, '2025-10-28 09:40:12', '2025-10-28 09:40:12'),
(30, 'Dhangadhi', 'Dhangadhi@gmail.com', NULL, '$2y$10$a64H5WcfEVYN2zqXhx6iQeHj1sgPLx6tJ1F6IxZmi50e1aiaDkuea', NULL, NULL, 'user', NULL, NULL, 'active', NULL, '2025-10-28 10:31:12', '2025-10-28 10:31:12'),
(31, 'nepali', 'nepali@gmail.com', NULL, '$2y$10$0U57qxp4a1QbNNxj2bm65e23GOAwd.koKwBSb.fYPCKnpD1R4f4CW', NULL, NULL, 'user', NULL, NULL, 'active', NULL, '2025-10-29 11:29:12', '2025-10-29 11:29:12'),
(32, 'bobin', 'bobin@gmail.com', NULL, '$2y$10$TOyANlhhFbC4Jk6gvrI5zuUcxuYQdnoaYda5QFbRkHV0iNo8dn4ZC', NULL, NULL, 'user', NULL, NULL, 'active', NULL, '2025-10-29 11:44:54', '2025-10-29 11:44:54'),
(33, 'aaa', 'aaa@gmail.com', NULL, '$2y$10$uXi0WAlekAuIIEid9oP8leAJsiK21cb7.dcrDnGBv.DUx8mxfm4cq', NULL, NULL, 'user', NULL, NULL, 'active', NULL, '2025-10-29 12:16:07', '2025-10-29 12:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `no_of_opening` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext NOT NULL,
  `expire_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacancies`
--

INSERT INTO `vacancies` (`id`, `title`, `no_of_opening`, `type`, `image`, `short_description`, `description`, `expire_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nam cumque sit recus', 16, 'full time', '1679384935.jpg', NULL, 'sdfg', '2023-03-21 07:52:07', 'on', '2023-03-21 01:52:02', '2023-03-21 02:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `why_us`
--

CREATE TABLE `why_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `why_us`
--

INSERT INTO `why_us` (`id`, `name`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Modern Design', 'noimage.jpg.jpg', 'on', '2023-06-16 13:13:28', '2023-06-17 11:55:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accessories_device_purchase`
--
ALTER TABLE `accessories_device_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accessories_device_purchase_device_purchase_id_foreign` (`device_purchase_id`),
  ADD KEY `accessories_device_purchase_accessories_id_foreign` (`accessories_id`),
  ADD KEY `accessories_device_purchase_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `accessory_stocks`
--
ALTER TABLE `accessory_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisemments`
--
ALTER TABLE `advertisemments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amcs`
--
ALTER TABLE `amcs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amc_accessories`
--
ALTER TABLE `amc_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amc_accessories_amc_id_foreign` (`amc_id`);

--
-- Indexes for table `amc_assign_accessories`
--
ALTER TABLE `amc_assign_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amc_assign_accessories_amc_assign_id_foreign` (`amc_assign_id`),
  ADD KEY `amc_assign_accessories_customer_id_foreign` (`customer_id`),
  ADD KEY `amc_assign_accessories_amc_id_foreign` (`amc_id`),
  ADD KEY `amc_assign_accessories_accessory_id_foreign` (`accessory_id`);

--
-- Indexes for table `amc_customers`
--
ALTER TABLE `amc_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `amc_customers_contact_unique` (`contact`),
  ADD UNIQUE KEY `amc_customers_landline_unique` (`landline`),
  ADD UNIQUE KEY `amc_customers_email_unique` (`email`),
  ADD KEY `amc_customers_customer_id_foreign` (`customer_id`),
  ADD KEY `amc_customers_amc_id_foreign` (`amc_id`);

--
-- Indexes for table `bikes`
--
ALTER TABLE `bikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bike_services`
--
ALTER TABLE `bike_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closing_balances`
--
ALTER TABLE `closing_balances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `closing_balances_date_unique` (`date`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_accessories`
--
ALTER TABLE `customer_accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_notes`
--
ALTER TABLE `customer_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_notes_lead_id_foreign` (`lead_id`),
  ADD KEY `customer_notes_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_products`
--
ALTER TABLE `customer_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_tickets`
--
ALTER TABLE `customer_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_ticket_accessories`
--
ALTER TABLE `customer_ticket_accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_ticket_payments`
--
ALTER TABLE `customer_ticket_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposite_amounts`
--
ALTER TABLE `deposite_amounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_purchases`
--
ALTER TABLE `device_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `device_purchases_branch_id_foreign` (`branch_id`),
  ADD KEY `device_purchases_created_by_foreign` (`created_by`);

--
-- Indexes for table `device_purchase_accessories`
--
ALTER TABLE `device_purchase_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_purchase_accessories_device_purchase_id_foreign` (`device_purchase_id`),
  ADD KEY `device_purchase_accessories_accessory_id_foreign` (`accessory_id`),
  ADD KEY `device_purchase_accessories_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `device_purchase_machineries`
--
ALTER TABLE `device_purchase_machineries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_purchase_machineries_device_purchase_id_foreign` (`device_purchase_id`),
  ADD KEY `device_purchase_machineries_machinery_id_foreign` (`machinery_id`),
  ADD KEY `device_purchase_machineries_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `emis`
--
ALTER TABLE `emis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emi_customers`
--
ALTER TABLE `emi_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emi_customers_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `emi_payments`
--
ALTER TABLE `emi_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emi_payments_emi_customers_id_foreign` (`emi_customers_id`),
  ADD KEY `emi_payments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `emi_systems`
--
ALTER TABLE `emi_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_advance_pays`
--
ALTER TABLE `employee_advance_pays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_attendance_requests`
--
ALTER TABLE `employee_attendance_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_commissions`
--
ALTER TABLE `employee_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_funds`
--
ALTER TABLE `employee_funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_loans`
--
ALTER TABLE `employee_loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_payslips`
--
ALTER TABLE `employee_payslips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_salaries`
--
ALTER TABLE `employee_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_sale_insentives`
--
ALTER TABLE `employee_sale_insentives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_services`
--
ALTER TABLE `employee_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exchanges_lead_id_foreign` (`lead_id`),
  ADD KEY `exchanges_branch_id_foreign` (`branch_id`),
  ADD KEY `exchanges_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_unique` (`machinery_id`,`accessory_id`,`branch_id`),
  ADD KEY `inventories_accessory_id_foreign` (`accessory_id`),
  ADD KEY `inventories_branch_id_foreign` (`branch_id`),
  ADD KEY `inventories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `leads_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `leads_email_unique` (`email`);

--
-- Indexes for table `lead_responses`
--
ALTER TABLE `lead_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machineries`
--
ALTER TABLE `machineries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machinery_stocks`
--
ALTER TABLE `machinery_stocks`
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
-- Indexes for table `outer_service_items`
--
ALTER TABLE `outer_service_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `outer_service_items_task_id_foreign` (`task_id`);

--
-- Indexes for table `outsider_paymentverifications`
--
ALTER TABLE `outsider_paymentverifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `out_side_tasks`
--
ALTER TABLE `out_side_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_verifications`
--
ALTER TABLE `payment_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_verifieds`
--
ALTER TABLE `payment_verifieds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `petrols`
--
ALTER TABLE `petrols`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petrol_pumps`
--
ALTER TABLE `petrol_pumps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petty_cash_adds`
--
ALTER TABLE `petty_cash_adds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petty_cash_requests`
--
ALTER TABLE `petty_cash_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `petty_cash_requests_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `petty_cash_transactions`
--
ALTER TABLE `petty_cash_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petty_cash_transfers`
--
ALTER TABLE `petty_cash_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `sales_created_by_foreign` (`created_by`);

--
-- Indexes for table `sales_accessories`
--
ALTER TABLE `sales_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_accessories_sale_id_foreign` (`sale_id`),
  ADD KEY `sales_accessories_accessory_id_foreign` (`accessory_id`);

--
-- Indexes for table `sales_machineries`
--
ALTER TABLE `sales_machineries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_machineries_sale_id_foreign` (`sale_id`),
  ADD KEY `sales_machineries_machinery_id_foreign` (`machinery_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_centers`
--
ALTER TABLE `service_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skims`
--
ALTER TABLE `skims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skims_lead_id_foreign` (`lead_id`),
  ADD KEY `skims_branch_id_foreign` (`branch_id`),
  ADD KEY `skims_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_issues`
--
ALTER TABLE `stock_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_issues_requested_by_foreign` (`requested_by`);

--
-- Indexes for table `stock_issue_accessories`
--
ALTER TABLE `stock_issue_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_issue_accessories_stock_issue_id_foreign` (`stock_issue_id`),
  ADD KEY `stock_issue_accessories_accessory_id_foreign` (`accessory_id`);

--
-- Indexes for table `stock_issue_machineries`
--
ALTER TABLE `stock_issue_machineries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_issue_machineries_stock_issue_id_foreign` (`stock_issue_id`),
  ADD KEY `stock_issue_machineries_machinery_id_foreign` (`machinery_id`);

--
-- Indexes for table `stock_issue_technical_tools`
--
ALTER TABLE `stock_issue_technical_tools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_issue_technical_tools_stock_issue_id_foreign` (`stock_issue_id`),
  ADD KEY `stock_issue_technical_tools_technical_tool_id_foreign` (`technical_tool_id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfers_from_branch_id_foreign` (`from_branch_id`),
  ADD KEY `stock_transfers_to_branch_id_foreign` (`to_branch_id`),
  ADD KEY `stock_transfers_created_by_foreign` (`created_by`),
  ADD KEY `stock_transfers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `stock_transfer_accessories`
--
ALTER TABLE `stock_transfer_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_accessories_stock_transfer_id_foreign` (`stock_transfer_id`),
  ADD KEY `stock_transfer_accessories_accessory_id_foreign` (`accessory_id`);

--
-- Indexes for table `stock_transfer_machineries`
--
ALTER TABLE `stock_transfer_machineries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_machineries_stock_transfer_id_foreign` (`stock_transfer_id`),
  ADD KEY `stock_transfer_machineries_machinery_id_foreign` (`machinery_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_messages`
--
ALTER TABLE `task_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_messages_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_service_items`
--
ALTER TABLE `task_service_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_service_items_task_id_foreign` (`task_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technical_tools`
--
ALTER TABLE `technical_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_notes`
--
ALTER TABLE `ticket_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_notes_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `why_us`
--
ALTER TABLE `why_us`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `accessories_device_purchase`
--
ALTER TABLE `accessories_device_purchase`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accessory_stocks`
--
ALTER TABLE `accessory_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisemments`
--
ALTER TABLE `advertisemments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `amcs`
--
ALTER TABLE `amcs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `amc_accessories`
--
ALTER TABLE `amc_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `amc_assign_accessories`
--
ALTER TABLE `amc_assign_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `amc_customers`
--
ALTER TABLE `amc_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bikes`
--
ALTER TABLE `bikes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bike_services`
--
ALTER TABLE `bike_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `closing_balances`
--
ALTER TABLE `closing_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_accessories`
--
ALTER TABLE `customer_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer_notes`
--
ALTER TABLE `customer_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customer_products`
--
ALTER TABLE `customer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `customer_tickets`
--
ALTER TABLE `customer_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_ticket_accessories`
--
ALTER TABLE `customer_ticket_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `customer_ticket_payments`
--
ALTER TABLE `customer_ticket_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `deposite_amounts`
--
ALTER TABLE `deposite_amounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `device_purchases`
--
ALTER TABLE `device_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_purchase_accessories`
--
ALTER TABLE `device_purchase_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_purchase_machineries`
--
ALTER TABLE `device_purchase_machineries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emis`
--
ALTER TABLE `emis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emi_customers`
--
ALTER TABLE `emi_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emi_payments`
--
ALTER TABLE `emi_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emi_systems`
--
ALTER TABLE `emi_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `employee_advance_pays`
--
ALTER TABLE `employee_advance_pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee_attendance_requests`
--
ALTER TABLE `employee_attendance_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_commissions`
--
ALTER TABLE `employee_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_funds`
--
ALTER TABLE `employee_funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_loans`
--
ALTER TABLE `employee_loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_payslips`
--
ALTER TABLE `employee_payslips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_salaries`
--
ALTER TABLE `employee_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_sale_insentives`
--
ALTER TABLE `employee_sale_insentives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_services`
--
ALTER TABLE `employee_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchanges`
--
ALTER TABLE `exchanges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `lead_responses`
--
ALTER TABLE `lead_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT for table `machineries`
--
ALTER TABLE `machineries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `machinery_stocks`
--
ALTER TABLE `machinery_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `outer_service_items`
--
ALTER TABLE `outer_service_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `outsider_paymentverifications`
--
ALTER TABLE `outsider_paymentverifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `out_side_tasks`
--
ALTER TABLE `out_side_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_verifications`
--
ALTER TABLE `payment_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_verifieds`
--
ALTER TABLE `payment_verifieds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `petrols`
--
ALTER TABLE `petrols`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `petrol_pumps`
--
ALTER TABLE `petrol_pumps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petty_cash_adds`
--
ALTER TABLE `petty_cash_adds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `petty_cash_requests`
--
ALTER TABLE `petty_cash_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `petty_cash_transactions`
--
ALTER TABLE `petty_cash_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `petty_cash_transfers`
--
ALTER TABLE `petty_cash_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_accessories`
--
ALTER TABLE `sales_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_machineries`
--
ALTER TABLE `sales_machineries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_centers`
--
ALTER TABLE `service_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skims`
--
ALTER TABLE `skims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_issues`
--
ALTER TABLE `stock_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_issue_accessories`
--
ALTER TABLE `stock_issue_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_issue_machineries`
--
ALTER TABLE `stock_issue_machineries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_issue_technical_tools`
--
ALTER TABLE `stock_issue_technical_tools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfer_accessories`
--
ALTER TABLE `stock_transfer_accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfer_machineries`
--
ALTER TABLE `stock_transfer_machineries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `task_messages`
--
ALTER TABLE `task_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_service_items`
--
ALTER TABLE `task_service_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `technical_tools`
--
ALTER TABLE `technical_tools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_notes`
--
ALTER TABLE `ticket_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `why_us`
--
ALTER TABLE `why_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories_device_purchase`
--
ALTER TABLE `accessories_device_purchase`
  ADD CONSTRAINT `accessories_device_purchase_accessories_id_foreign` FOREIGN KEY (`accessories_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accessories_device_purchase_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `accessories_device_purchase_device_purchase_id_foreign` FOREIGN KEY (`device_purchase_id`) REFERENCES `device_purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `amc_accessories`
--
ALTER TABLE `amc_accessories`
  ADD CONSTRAINT `amc_accessories_amc_id_foreign` FOREIGN KEY (`amc_id`) REFERENCES `amcs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `amc_assign_accessories`
--
ALTER TABLE `amc_assign_accessories`
  ADD CONSTRAINT `amc_assign_accessories_accessory_id_foreign` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amc_assign_accessories_amc_assign_id_foreign` FOREIGN KEY (`amc_assign_id`) REFERENCES `amc_assigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amc_assign_accessories_amc_id_foreign` FOREIGN KEY (`amc_id`) REFERENCES `amcs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amc_assign_accessories_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `amc_customers`
--
ALTER TABLE `amc_customers`
  ADD CONSTRAINT `amc_customers_amc_id_foreign` FOREIGN KEY (`amc_id`) REFERENCES `amcs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amc_customers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_notes`
--
ALTER TABLE `ticket_notes`
  ADD CONSTRAINT `ticket_notes_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `customer_tickets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
