-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2020 at 10:11 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `japio`
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
  `stripe_prod_id` varchar(200) DEFAULT NULL,
  `max_team_size` int(11) NOT NULL DEFAULT '1' COMMENT 'this is a temp column, need to remove after making the changes as per new pricing plans',
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

INSERT INTO `subscription_plans` (`id`, `plan_name`, `parent_id`, `plan_description`, `valid_days`, `stripe_prod_id`, `max_team_size`, `max_integrator_user`, `max_data_sources`, `max_business_users`, `only_for_teams`, `is_active`, `created_at`, `updated_at`) VALUES
(0, 'Free Trial', 0, NULL, 14, NULL, 1, 1, 10, 0, NULL, 1, '2020-09-30 00:00:00', '2020-09-30 00:00:00'),
(1, 'Harmonize by Japio', 0, 'Fully connect and integrate your entire Enterprise', 365, 'prod_I6CMDgQm4s9Cru', 1, -1, 120, 1500, NULL, 1, '2020-09-27 13:31:12', '2020-09-27 17:13:52'),
(2, 'Collaborate by Japio', 0, 'Cross-Department Collaboration', 365, 'prod_I6COOm7XpA0gcD', 1, 5, 25, 300, NULL, 1, '2020-09-27 13:33:20', '2020-09-30 19:45:04'),
(3, 'Unify by Japio', 0, 'Single source of integration for your critical business process', 365, 'prod_I6CQS5pRz1vLEe', 1, 3, 10, 125, NULL, 1, '2020-09-27 13:34:37', '2020-09-30 19:46:48'),
(4, 'Integrate-preneurs (Self-Service)', 0, 'Set your new business up for growth with a critical business process', 365, 'prod_I6Cbo6SAHFn8bG', 1, 1, 3, 5, NULL, 1, '2020-09-27 13:45:38', '2020-09-30 19:47:53'),
(5, 'Blocks of Connectors', 1, NULL, 365, 'prod_I6DpB8Zxd8etKG', 1, 0, 25, 0, NULL, 1, '2020-09-27 15:01:50', '2020-10-01 11:14:25'),
(23, 'Blocks of Connectors', 1, 'Fully connect and integrate your entire Enterprise', 365, 'prod_I7oHv6Dz2yNKmK', 1, -1, 120, 150, NULL, 1, '2020-10-01 20:46:08', '2020-10-01 20:46:08'),
(25, 'Blocks of Users', 1, 'Fully connect and integrate your entire Enterprise', 365, 'prod_I7oR0vC9Xi7U58', 1, -1, 120, 150, NULL, 1, '2020-10-01 20:55:54', '2020-10-01 20:55:54'),
(29, 'Blocks of Users', 1, 'Cross-Department Collaboration', 365, 'prod_I7oh6IlNs28WZc', 1, 5, 25, 300, NULL, 1, '2020-10-01 21:11:48', '2020-10-01 21:11:48'),
(30, 'Blocks of Connectors', 1, 'Cross-Department Collaboration', 365, 'prod_I7ok3OSCIilH1J', 1, 6, 25, 3000, NULL, 1, '2020-10-01 21:14:49', '2020-10-01 21:14:49'),
(32, 'Integrator users', 1, 'Cross-Department Collaboration', 365, 'prod_I7orr5ZLDGIUbP', 1, 8, 25, 300, NULL, 1, '2020-10-01 21:21:27', '2020-10-01 21:21:27'),
(34, 'Blocks of Connectors', 1, 'Single source of integration for your critical business process', 365, 'prod_I7p0JxZTUkwH2z', 1, 4, 10, 125, NULL, 1, '2020-10-01 21:31:16', '2020-10-01 21:31:16'),
(35, 'Blocks of Users', 1, 'Single source of integration for your critical business process', 365, 'prod_I7p7UbQaB9JY5j', 1, 5, 10, 125, NULL, 1, '2020-10-01 21:37:39', '2020-10-01 21:37:39'),
(36, 'Integrator users', 1, 'Single source of integration for your critical business process', 365, 'prod_I7p85EdBBTZXt9', 1, 7, 10, 125, NULL, 1, '2020-10-01 21:38:57', '2020-10-01 21:38:57');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
