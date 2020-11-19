-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2020 at 01:01 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `data_sources`
--

CREATE TABLE `data_sources` (
  `id` int(11) NOT NULL,
  `name` varchar(254) NOT NULL,
  `description` text,
  `api_url` text NOT NULL,
  `oauth2_url` text,
  `callback_token_field` varchar(254) NOT NULL,
  `client_credentials` text,
  `input_credentials` text,
  `connection_img` varchar(254) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_sources`
--

INSERT INTO `data_sources` (`id`, `name`, `description`, `api_url`, `oauth2_url`, `callback_token_field`, `client_credentials`, `input_credentials`, `connection_img`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Google Ads', NULL, '', 'https://accounts.google.com/o/oauth2/v2/auth?response_type=code&access_type=offline&client_id=322722302859-lunltpnv554tb281c256echsocqpvqfs.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fconnect%2Fcallback&state&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fadwords', 'code', '{\"env\": \"test\", \"test\": {\"clientId\": \"322722302859-lunltpnv554tb281c256echsocqpvqfs.apps.googleusercontent.com\", \"userAgent\": \"YOUR-NAME\", \"clientSecret\": \"3d6swWg6S0FaHzdREb9aJnj9\", \"refreshToken\": \"REFRESH-TOKEN\", \"developerToken\": \"YOUR-DEV-TOKEN\", \"clientCustomerId\": \"CLIENT-CUSTOMER-ID\"}, \"oAuth2\": {\"scope\": \"https://www.googleapis.com/auth/adwords\", \"redirectUri\": \"http://localhost:8000/connect/callback\", \"authorizationUri\": \"https://accounts.google.com/o/oauth2/v2/auth\", \"tokenCredentialUri\": \"https://www.googleapis.com/oauth2/v4/token\"}, \"production\": {\"clientId\": \"322722302859-lunltpnv554tb281c256echsocqpvqfs.apps.googleusercontent.com\", \"userAgent\": \"YOUR-NAME\", \"clientSecret\": \"3d6swWg6S0FaHzdREb9aJnj9\", \"refreshToken\": \"REFRESH-TOKEN\", \"developerToken\": \"YOUR-DEV-TOKEN\", \"clientCustomerId\": \"OE_F9Ck27TMayWrJgrX61Q\"}}', '{\"developerToken\": {\"placeholder\": \"Kindly Enter Your developer token\"}, \"clientCustomerId\": {\"placeholder\": \"Enter Your Google Customer Id\"}}', 'img\\connection\\google_ads.png', 1, '2020-06-27 23:15:04', NULL);

-- --------------------------------------------------------
--
-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0b998e9fc7d9f8f9b497c407ece3028c76fc7170ca5061f72312da0b15dc1f8d66cdc54f92979deb', 1, 1, 'authToken', '[]', 0, '2020-06-25 02:21:55', '2020-06-25 02:21:55', '2021-06-25 07:51:55'),
('20194bd1560fa34309c1e4b21d327297653c58291c7e21b13b6c0a3dc37462025da22badd772c903', 1, 1, 'authToken', '[]', 0, '2020-06-25 02:22:03', '2020-06-25 02:22:03', '2021-06-25 07:52:03'),
('262aca4026af49eceb8e5e78a3a7fdd28ee44b8b08c0288d73f7fa124749c2deaca9bb0854368d3c', 1, 1, 'authToken', '[]', 0, '2020-06-25 02:21:38', '2020-06-25 02:21:38', '2021-06-25 07:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'MNtsOBeaYLNCjEh6dOSBTjCxXR7rJEkP3Xi7YPeA', 'http://localhost', 1, 0, 0, '2020-06-25 01:15:43', '2020-06-25 01:15:43'),
(2, NULL, 'Laravel Password Grant Client', 'FmNXGvZiQUdCx8kz7Dj7jqhkoIw4JLUI65lPPlgL', 'http://localhost', 0, 1, 0, '2020-06-25 01:15:44', '2020-06-25 01:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-06-25 01:15:44', '2020-06-25 01:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(200) NOT NULL,
  `plan_description` varchar(250) NOT NULL,
  `valid_title` varchar(255) NOT NULL,
  `valid_days` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `max_team_size` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `update_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `plan_name`, `plan_description`, `valid_title`, `valid_days`, `price`, `max_team_size`, `is_active`, `created_at`, `created_by`, `updated_at`, `update_by`) VALUES
(1, 'Free', 'ONLY 11', 'Free', 30, '0', 2, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'Monthly', 'ONLY 22', 'Monthly', 30, '200', 3, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 'Quarterly', 'ONLY 223', 'Quarterly', 90, '500', 7, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, '6 months', 'ONLY 224', '6 months', 180, '800', 17, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 'Yearly', 'ONLY 225', 'Yearly', 365, '1300', 40, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `website` varchar(150) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `plan_id` int(11) NOT NULL DEFAULT '1',
  `plan_valid_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `update_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `company_name`, `website`, `email_address`, `is_active`, `plan_id`, `plan_valid_date`, `created_at`, `created_by`, `updated_at`, `update_by`) VALUES
(1, 'ABCD', 'abcd.com', 'pankajcse41983@gmail.com', 1, 1, '2020-07-17', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_subscription_mapping`
--

CREATE TABLE `team_subscription_mapping` (
  `id` int(11) NOT NULL,
  `teams_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_subscription_id` int(11) NOT NULL,
  `receipt_url` varchar(255) NOT NULL,
  `valid_till` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_subscription_mapping`
--

INSERT INTO `team_subscription_mapping` (`id`, `teams_id`, `user_id`, `user_subscription_id`, `receipt_url`, `valid_till`, `is_current`, `is_active`, `created_at`, `created_by`, `update_at`, `update_by`) VALUES
(1, 1, 1, 1, '', '2020-07-31', 1, 1, '2020-07-15 12:15:44', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-manager,2-non manager, 3- Admin',
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_img1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `subscription_plans_id` int(11) DEFAULT '1',
  `valid_date` date DEFAULT NULL,
  `invite_by_id` int(11) NOT NULL,
  `teams_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role_id`, `position`, `pro_img`, `pro_img1`, `is_active`, `subscription_plans_id`, `valid_date`, `invite_by_id`, `teams_id`, `created_at`, `updated_at`) VALUES
(1, 'pankaj gupta', '1@1.1', NULL, '$2y$10$8J0WffJARo5rkhrNRGY/OeoiHdReQlOWbpcI/ELbkgpmzgpzpa91.', NULL, 1, 'fffffff', 'img/profile_img/c4664cfa5a99b5cf8cbf545931a6dc32.jpeg', NULL, 1, 3, '2020-07-07', 1, 1, '2020-06-25 02:21:35', '2020-07-10 02:35:22'),
(2, 'j u', 'pankaj1cse1983@gmail.com', NULL, '$2y$10$IN5cWT58uVYObuejVddEz.zLO/4IYjUuJ1IXOaPgWla0L7U95HeE.', NULL, 2, '', NULL, NULL, 1, NULL, NULL, 1, 1, '2020-07-05 08:20:04', '2020-07-05 08:20:04'),
(3, 'pankaj gupta', 'pankajcse41983@gmail.com', NULL, '$2y$10$dv4qorsPBjFN1xkR8X4Gaux3pmKIAsgDX1zGFLu0cP.yFoxb3nNKO', NULL, 2, 'pankaj', NULL, NULL, 1, 1, '2020-07-31', 1, 0, '2020-07-15 06:54:50', '2020-07-15 06:54:50'),
(4, 'pankaj gupta', 'pankajcse1983@gmail.com', NULL, '$2y$10$x54qDcU6ZTqdJeSyTVlpmuixNP60lmx..XiIH9QVRcMsutW0g3ZbK', NULL, 2, '11', NULL, NULL, 1, 1, '2020-07-31', 1, 1, '2020-07-15 07:01:28', '2020-07-15 07:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `user_connectors`
--

CREATE TABLE `user_connectors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_connector` int(11) NOT NULL,
  `connector_type` enum('data_source','dataware_house','visualisation_tool','') NOT NULL,
  `connection_status` tinyint(4) NOT NULL,
  `connection_response` text NOT NULL,
  `token` text NOT NULL,
  `input_credentials` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_invitation`
--

CREATE TABLE `user_invitation` (
  `id` int(11) NOT NULL,
  `invite_by` int(11) NOT NULL,
  `invitation_code` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_acepted` tinyint(1) NOT NULL DEFAULT '0',
  `teams_id` int(11) NOT NULL,
  `subscription_plans_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_created_id` int(11) DEFAULT NULL,
  `created_md5_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_invitation`
--

INSERT INTO `user_invitation` (`id`, `invite_by`, `invitation_code`, `email_id`, `name`, `is_active`, `is_acepted`, `teams_id`, `subscription_plans_id`, `created_at`, `modified_at`, `updated_at`, `users_created_id`, `created_md5_id`) VALUES
(1, 1, '32770', 'pankajcse41983@gmail.com', 'pankaj gupta', 1, 1, 1, 1, '2020-07-15 12:09:49', '2020-07-15 17:39:49', '2020-07-15 12:24:50', 3, 'c4ca4238a0b923820dcc509a6f75849b'),
(3, 1, '83488', 'pankajcse1983@gmail.com', 'pankaj gupta', 1, 1, 1, 1, '2020-07-15 12:30:15', '2020-07-15 18:00:15', '2020-07-15 12:31:28', 4, 'eccbc87e4b5ce2fe28308fd9f2a7baf3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_sources`
--
ALTER TABLE `data_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_sources_02072020`
--
--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `team_subscription_mapping`
--
ALTER TABLE `team_subscription_mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_connectors`
--
ALTER TABLE `user_connectors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_invitation`
--
ALTER TABLE `user_invitation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_sources`
--
ALTER TABLE `data_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--


-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `teams_old`
--
ALTER TABLE `teams_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `team_subscription_mapping`
--
ALTER TABLE `team_subscription_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_connectors`
--
ALTER TABLE `user_connectors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_invitation`
--
ALTER TABLE `user_invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
