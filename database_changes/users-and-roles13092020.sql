-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2020 at 05:20 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fransic`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(254) NOT NULL,
  `description` text,
  `permitted_urls` text COMMENT 'all permitted urls in json format',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `permitted_urls`, `active`, `created_at`, `updated_at`) VALUES
(1, 'administrator', NULL, NULL, 1, '2020-09-12 05:29:00', NULL),
(2, 'team_administrator', NULL, NULL, 1, '2020-09-12 04:11:00', NULL),
(3, 'business_users', NULL, NULL, 1, '2020-09-12 04:07:26', NULL),
(4, 'integrator_users', NULL, NULL, 1, '2020-09-12 05:24:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stripe_customer_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `subscription_plans_id` int(11) DEFAULT '1',
  `valid_date` date DEFAULT NULL,
  `invite_by_id` int(11) DEFAULT NULL,
  `teams_id` int(11) NOT NULL,
  `role_id` int(50) NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `stripe_customer_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_active`, `subscription_plans_id`, `valid_date`, `invite_by_id`, `teams_id`, `role_id`, `position`, `pro_img`, `created_at`, `updated_at`) VALUES
(1, 'cus_HfcGpn4y02tjzD', 'Administrator Japio', 'admin@japio.com', NULL, '$2y$10$8J0WffJARo5rkhrNRGY/OeoiHdReQlOWbpcI/ELbkgpmzgpzpa91.', NULL, 1, 5, '2020-09-17', 1, 0, 1, 'Admin', 'img/profile_img/1ae01b8eb68533fa6c2d667da0a0609d.jpg', '2020-06-25 02:21:35', '2020-07-18 14:28:26'),
(10, NULL, 'Amarjit Kumar', 'amarjit@metricoidtech.com', NULL, '$2y$10$DEeRrYUAouTLnA20kGOgtO2n0XFewCNkl1NVPSsND/w1Zq2PX0sW.', NULL, 1, 3, '2020-10-18', 1, 1, 2, 'Manager', 'img/profile_img/aabb88eb597047ef823cc8165711f7ab.jpg', '2020-07-13 11:04:42', '2020-07-31 18:59:23'),
(11, NULL, 'Francis Kanneh', 'francis@japio.com', NULL, '$2y$10$DEeRrYUAouTLnA20kGOgtO2n0XFewCNkl1NVPSsND/w1Zq2PX0sW.', NULL, 1, 1, '2020-09-14', 1, 11, 3, 'CEO', NULL, '2020-08-31 16:12:22', '2020-08-31 16:12:22'),
(13, NULL, 'Integrator Users', 'itegrator@gmail.com', NULL, '$2y$10$DEeRrYUAouTLnA20kGOgtO2n0XFewCNkl1NVPSsND/w1Zq2PX0sW.', NULL, 1, 4, NULL, NULL, 12, 4, NULL, NULL, '2020-09-12 00:37:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
