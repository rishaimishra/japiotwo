-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2020 at 09:21 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u814937503_japioapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `temp_data_connection`
--

CREATE TABLE `temp_data_connection` (
  `id` int(11) NOT NULL,
  `secured_code` varchar(254) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datasource_id` int(11) NOT NULL,
  `oauth2_response` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_data_connection`
--

INSERT INTO `temp_data_connection` (`id`, `secured_code`, `user_id`, `datasource_id`, `oauth2_response`, `created_at`) VALUES
(1, 'MV8y', 1, 2, '{\"access_token\":\"ya29.a0AfH6SMBvGaMkem-cRAZHPlB78AdC3COyiwpHkl1ZN-c8Cpgp4gZmwIarVhtFLstz5ySelLfrYB7k3T5yKSwWwIgAsatdy_EBFsEwT8ZX565ZVeaskL0S4kYYwQueeS1NgPq_MQf5DEY4tgGoiuVZ_x2K71_t54zLwK0\",\"expires_in\":3599,\"refresh_token\":\"1\\/\\/097TMbipUsxYNCgYIARAAGAkSNgF-L9IreaexaiVnWHf03_XC4lJapAv-hyztMgaNuhwSCOWv3u2sZyAQY5WPd02grO6xBj0htg\",\"scope\":\"https:\\/\\/www.googleapis.com\\/auth\\/analytics.readonly https:\\/\\/www.googleapis.com\\/auth\\/adwords https:\\/\\/www.googleapis.com\\/auth\\/analytics\",\"token_type\":\"Bearer\",\"created\":1595566566}', '2020-07-21 08:42:44'),
(2, 'MV8x', 1, 1, NULL, '2020-07-23 11:29:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `temp_data_connection`
--
ALTER TABLE `temp_data_connection`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `temp_data_connection`
--
ALTER TABLE `temp_data_connection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
