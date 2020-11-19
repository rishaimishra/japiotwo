-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2020 at 10:35 PM
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
  `valid_title` varchar(255) DEFAULT NULL,
  `valid_days` int(11) DEFAULT NULL,
  `stripe_price_id` varchar(200) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `max_team_size` int(11) NOT NULL COMMENT 'maximum integrator users',
  `max_data_sources` int(11) DEFAULT NULL COMMENT 'maximum data sources are allowed in this plan',
  `max_business_users` int(11) DEFAULT NULL COMMENT 'maximum business users allowed in this plan',
  `only_for_teams` varchar(254) DEFAULT NULL COMMENT 'this plan will only be visible for the specific team(s), if the team id of the logged in user is in this column then show this plan',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `plan_name`, `parent_id`, `plan_description`, `valid_title`, `valid_days`, `stripe_price_id`, `currency`, `max_team_size`, `max_data_sources`, `max_business_users`, `only_for_teams`, `is_active`, `created_at`, `created_by`, `updated_at`, `update_by`) VALUES
(1, 'Monthly', 0, 'This is Monthly subscription', NULL, 30, 'prod_I3fsABOxUnT2n9', NULL, 4, 5, 6, NULL, 1, '2020-09-20 19:49:04', NULL, '2020-09-20 19:49:04', NULL),
(2, 'Addon', 1, 'This is addon subscription', NULL, 365, 'prod_I3g4gR7sNdfwNu', NULL, 6, 5, 5, NULL, 1, '2020-09-20 20:00:58', NULL, '2020-09-20 20:00:58', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
