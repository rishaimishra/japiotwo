-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2020 at 12:12 AM
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
-- Table structure for table `subscription_prices`
--

CREATE TABLE `subscription_prices` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `is_addon` int(11) DEFAULT NULL,
  `price_type` enum('monthly','quarterly','halfyearly','yearly') DEFAULT NULL,
  `stripe_price_id` varchar(150) DEFAULT NULL,
  `price` varchar(150) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_prices`
--

INSERT INTO `subscription_prices` (`id`, `plan_id`, `is_addon`, `price_type`, `stripe_price_id`, `price`, `currency`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'monthly', 'price_1HVzy6Ac4hatmiCIEMpnZapy', '6250', 'USD', '2020-09-27 08:01:12', '2020-09-27 08:01:12'),
(2, 2, NULL, 'monthly', 'price_1HW00AAc4hatmiCIukPgt7hJ', '1420', 'USD', '2020-09-27 08:03:20', '2020-09-27 08:03:20'),
(3, 3, NULL, 'monthly', 'price_1HW01PAc4hatmiCIblyoqADs', '600', 'USD', '2020-09-27 08:04:37', '2020-09-27 08:04:37'),
(4, 4, NULL, 'monthly', 'price_1HW0C5Ac4hatmiCIbngQgpio', '167', 'USD', '2020-09-27 08:15:39', '2020-09-27 08:15:39'),
(5, 5, 1, 'monthly', 'price_1HW1NpAc4hatmiCIXsd1Ndr7', '1250', 'USD', '2020-09-27 09:31:51', '2020-09-27 09:31:51'),
(6, 7, 1, 'monthly', 'price_1HW1R0Ac4hatmiCIaF8WJPpG', '1000', 'USD', '2020-09-27 09:35:07', '2020-09-27 09:35:07'),
(7, 8, 2, 'monthly', 'price_1HW1ShAc4hatmiCI4toxZugV', '1300', 'USD', '2020-09-27 09:36:53', '2020-09-27 09:36:53'),
(8, 10, 2, 'monthly', 'price_1HW1a6Ac4hatmiCItgF9tilZ', '1000', 'USD', '2020-09-27 09:44:32', '2020-09-27 09:44:32'),
(9, 11, 2, 'monthly', 'price_1HW1b3Ac4hatmiCIyrycC2Nj', '200', 'USD', '2020-09-27 09:45:31', '2020-09-27 09:45:31'),
(10, 12, 3, 'monthly', 'price_1HW1ccAc4hatmiCIcd8DJf63', '1400', 'USD', '2020-09-27 09:47:07', '2020-09-27 09:47:07'),
(11, 15, 3, 'monthly', 'price_1HW1mbAc4hatmiCIs7nlBKju', '750', 'USD', '2020-09-27 09:57:27', '2020-09-27 09:57:27'),
(12, 16, 3, 'monthly', 'price_1HW1nMAc4hatmiCI9wG0kKfH', '200', 'USD', '2020-09-27 09:58:14', '2020-09-27 09:58:14'),
(14, 1, NULL, 'yearly', 'price_1HWy2UAc4hatmiCI7zErxu15', '75000', 'USD', '2020-09-30 00:12:49', '2020-09-30 00:12:49'),
(15, 2, NULL, 'yearly', 'price_1HXBEYAc4hatmiCIgZXKI3bi', '17000', 'USD', '2020-09-30 14:15:05', '2020-09-30 14:15:05'),
(16, 3, NULL, 'yearly', 'price_1HXBGFAc4hatmiCId1L3beLQ', '7200', 'USD', '2020-09-30 14:16:49', '2020-09-30 14:16:49'),
(17, 4, NULL, 'yearly', 'price_1HXBJTAc4hatmiCIC6i1PRqZ', '1999', 'USD', '2020-09-30 14:20:10', '2020-09-30 14:20:10'),
(19, 23, 1, 'yearly', 'price_1HXYfCAc4hatmiCIfauczgOS', '15000', 'USD', '2020-10-01 15:16:09', '2020-10-01 15:16:09'),
(20, 25, 1, 'yearly', 'price_1HXYoeAc4hatmiCI0o8UMzlO', '12000', 'USD', '2020-10-01 15:25:55', '2020-10-01 15:25:55'),
(23, 29, 2, 'yearly', 'price_1HXZ42Ac4hatmiCIYTmEaQWU', '12000', 'USD', '2020-10-01 15:41:49', '2020-10-01 15:41:49'),
(24, 30, 2, 'yearly', 'price_1HXZ6wAc4hatmiCI1FpC39VQ', '15600', 'USD', '2020-10-01 15:44:49', '2020-10-01 15:44:49'),
(25, 32, 2, 'yearly', 'price_1HXZDNAc4hatmiCIyIb4YYAi', '2400', 'USD', '2020-10-01 15:51:28', '2020-10-01 15:51:28'),
(27, 34, 3, 'yearly', 'price_1HXZMrAc4hatmiCINTHdryp0', '16800', 'USD', '2020-10-01 16:01:16', '2020-10-01 16:01:16'),
(28, 35, 3, 'yearly', 'price_1HXZT2Ac4hatmiCIjB64LXJB', '9000', 'USD', '2020-10-01 16:07:39', '2020-10-01 16:07:39'),
(29, 36, 3, 'yearly', 'price_1HXZUJAc4hatmiCIKD6CLBnq', '2400', 'USD', '2020-10-01 16:08:58', '2020-10-01 16:08:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscription_prices`
--
ALTER TABLE `subscription_prices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscription_prices`
--
ALTER TABLE `subscription_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
