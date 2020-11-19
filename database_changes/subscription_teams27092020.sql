-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2020 at 07:30 PM
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
-- Table structure for table `subscription_teams`
--

CREATE TABLE `subscription_teams` (
  `id` int(11) NOT NULL,
  `team_id` varchar(150) NOT NULL,
  `plan_id` int(50) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_valid` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_teams`
--

INSERT INTO `subscription_teams` (`id`, `team_id`, `plan_id`, `is_active`, `is_valid`, `created_at`, `updated_at`) VALUES
(1, '[\"10\",\"12\"]', 1, 1, '30', '2020-09-27 08:01:12', '2020-09-27 17:13:52'),
(2, '[\"10\",\"12\"]', 2, 1, '30', '2020-09-27 08:03:20', '2020-09-27 13:33:20'),
(3, '[\"10\",\"12\"]', 3, 1, '30', '2020-09-27 08:04:37', '2020-09-27 13:34:37'),
(4, '[\"10\",\"12\"]', 4, 1, '30', '2020-09-27 08:15:38', '2020-09-27 13:45:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscription_teams`
--
ALTER TABLE `subscription_teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscription_teams`
--
ALTER TABLE `subscription_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
