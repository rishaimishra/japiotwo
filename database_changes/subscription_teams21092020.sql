-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2020 at 10:34 PM
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
(1, '[\"10\",\"11\"]', 1, 1, '30', '2020-09-20 14:19:04', '2020-09-20 19:49:04');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;