-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2020 at 10:09 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `japioapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `plan_description` varchar(250) DEFAULT NULL,
  `valid_days` int(11) DEFAULT NULL,
  `stripe_price_id` varchar(200) DEFAULT NULL,
  `max_integrator_user` int(11) NOT NULL COMMENT 'maximum integrator users',
  `max_data_sources` int(11) DEFAULT NULL COMMENT 'maximum data sources are allowed in this plan',
  `max_business_users` int(11) DEFAULT NULL COMMENT 'maximum business users allowed in this plan',
  `only_for_teams` varchar(254) DEFAULT NULL COMMENT 'this plan will only be visible for the specific team(s), if the team id of the logged in user is in this column then show this plan',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `plan_name`, `parent_id`, `plan_description`, `valid_days`, `stripe_price_id`, `max_integrator_user`, `max_data_sources`, `max_business_users`, `only_for_teams`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Harmonize by Japioapp', 0, 'Fully connect and integrate your entire Enterprise', 365, 'prod_I6CMDgQm4s9Cru', -1, 120, 1500, NULL, 1, '2020-09-27 13:31:12', '2020-09-27 17:13:52'),
(2, 'Collaborate by Japio', 0, 'Cross-Department Collaboration', 30, 'prod_I6COOm7XpA0gcD', 6, 25, 300, NULL, 1, '2020-09-27 13:33:20', '2020-09-27 13:33:20'),
(3, 'Unify by Japio', 0, 'Single source of integration for your critical business process', 30, 'prod_I6CQS5pRz1vLEe', 125, 10, 4, NULL, 1, '2020-09-27 13:34:37', '2020-09-27 13:34:37'),
(4, 'Integrate-preneurs (Self-Service)', 0, 'Set your new business up for growth with a critical business process', 30, 'prod_I6Cbo6SAHFn8bG', 1, 3, 5, NULL, 1, '2020-09-27 13:45:38', '2020-09-27 13:45:38'),
(5, 'Blocks of Connectors', 1, NULL, 30, 'prod_I6DpB8Zxd8etKG', -1, 120, 1500, NULL, 1, '2020-09-27 15:01:50', '2020-09-27 15:01:50'),
(6, 'Blocks of Users', 1, NULL, 30, 'prod_I6DrpvLz8t2FeV', -1, 120, 1500, NULL, 1, '2020-09-27 15:03:37', '2020-09-27 15:03:37'),
(7, 'Blocks of Users', 1, NULL, 30, 'prod_I6DsIz5COXytwM', -1, 120, 1500, NULL, 1, '2020-09-27 15:05:07', '2020-09-27 15:05:07'),
(8, 'Blocks of Connectors', 1, NULL, 30, 'prod_I6Du476pXcSGhv', 6, 25, 300, NULL, 1, '2020-09-27 15:06:52', '2020-09-27 15:06:52'),
(9, 'Blocks of Users', 1, NULL, 30, 'prod_I6DxXEjmbYgMwx', 7, 25, 300, NULL, 1, '2020-09-27 15:10:17', '2020-09-27 15:10:17'),
(10, 'Blocks of Users', 1, NULL, 30, 'prod_I6E2iU5Hwp8VXL', 6, 25, 300, NULL, 1, '2020-09-27 15:14:31', '2020-09-27 15:14:31'),
(11, 'Integrator users', 1, NULL, 30, 'prod_I6E3MnbxR0XF4M', 5, 25, 300, NULL, 1, '2020-09-27 15:15:30', '2020-09-27 15:15:30'),
(12, 'Blocks of Connectors', 1, NULL, 30, 'prod_I6E4jrbplK8cbY', 4, 10, 125, NULL, 1, '2020-09-27 15:17:07', '2020-09-27 15:17:07'),
(13, 'Blocks of Users', 1, NULL, 30, 'prod_I6EBUzy2irJvmE', 5, 10, 125, NULL, 1, '2020-09-27 15:24:02', '2020-09-27 15:24:02'),
(14, 'Blocks of Users', 1, NULL, 30, 'prod_I6ECcA4XbypAUh', 4, 10, 125, NULL, 1, '2020-09-27 15:24:35', '2020-09-27 15:24:35'),
(15, 'Blocks of Users', 1, NULL, 30, 'prod_I6EFw49dDoT4NF', 5, 10, 125, NULL, 1, '2020-09-27 15:27:26', '2020-09-27 15:27:26'),
(16, 'Integrator users', 1, NULL, 30, 'prod_I6EFNP9mAa6Nyp', 6, 10, 125, NULL, 1, '2020-09-27 15:28:13', '2020-09-27 15:28:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
