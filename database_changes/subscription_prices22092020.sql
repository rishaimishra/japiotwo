-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2020 at 10:43 PM
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
(1, 1, NULL, 'monthly', 'prod_I42AzkLTrfmaox', '500', 'USD', '2020-09-21 13:21:12', '2020-09-21 13:21:12'),
(2, 2, 1, 'monthly', 'prod_I42BOy4iPXrpGH', '600', 'USD', '2020-09-21 13:21:49', '2020-09-21 13:21:49'),
(3, 5, 1, 'monthly', 'prod_I42EqJYVMhHIQb', '700', 'USD', '2020-09-21 13:25:09', '2020-09-21 13:25:09'),
(4, 8, 1, 'monthly', 'prod_I42rb8XwM7v1iV', '7000', 'USD', '2020-09-21 14:04:07', '2020-09-21 14:04:07');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
