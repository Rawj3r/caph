-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 09:16 AM
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
-- Database: `caph`
--

-- --------------------------------------------------------

--
-- Table structure for table `caphusers`
--

CREATE TABLE `caphusers` (
  `user_id` int(128) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  `ProfilePicUrl` varchar(255) DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `EmailConfirmed` int(1) DEFAULT NULL,
  `PasswordHash` varchar(255) DEFAULT NULL,
  `SecurityStamp` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(255) DEFAULT NULL,
  `PhoneNumberConfirmed` int(1) DEFAULT NULL,
  `TwoFactorEnabled` int(1) DEFAULT NULL,
  `LockoutEndDateUtc` datetime DEFAULT NULL,
  `LockoutEnabled` int(1) DEFAULT NULL,
  `AccessFailedCount` int(11) DEFAULT NULL,
  `UserName` varchar(256) DEFAULT NULL,
  `HireDate` datetime DEFAULT NULL,
  `LastModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CompanyId` int(13) DEFAULT NULL,
  `IdNumber` varchar(255) DEFAULT NULL,
  `Address1` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `ProvinceId` varchar(255) DEFAULT NULL,
  `PostalCode` varchar(255) DEFAULT NULL,
  `HomeNumber` varchar(255) DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `IsManager` int(11) DEFAULT NULL,
  `ManagerId` int(11) DEFAULT NULL,
  `JobTitle` varchar(255) DEFAULT NULL,
  `EmployeeType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `caphusers`
--

INSERT INTO `caphusers` (`user_id`, `Name`, `Surname`, `ProfilePicUrl`, `Email`, `EmailConfirmed`, `PasswordHash`, `SecurityStamp`, `PhoneNumber`, `PhoneNumberConfirmed`, `TwoFactorEnabled`, `LockoutEndDateUtc`, `LockoutEnabled`, `AccessFailedCount`, `UserName`, `HireDate`, `LastModified`, `CompanyId`, `IdNumber`, `Address1`, `City`, `ProvinceId`, `PostalCode`, `HomeNumber`, `DateOfBirth`, `IsManager`, `ManagerId`, `JobTitle`, `EmployeeType`) VALUES
(1, 'Lorem Ipsum', 'simply ', 'dummy ', 'demo@gmail.com', 1, NULL, NULL, NULL, 0, 0, NULL, 0, 0, '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL),
(2, 'sdds', 'sd', NULL, 'sd', NULL, 'ssdadsa', 'oj', 'qwed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
(3, 'Mane', 'Nkosi', NULL, 'mane@gmail.com', NULL, '1e9fa2c011900df8ac4266a5975653ef904e5d830ef8c0c0c61b7963d5fb9aa9', 'URIKqsAAPlsZvgtwRmbF', '012355656', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL),
(4, 'Mane', 'Nkosi', NULL, 'mane1@gmail.com', NULL, 'c47c27afd5c28335732895ab75b410ed1359d2664412dc69ef6fe32ec8c0744d', 'bbWR932QGevZp3930m4x', '012355656', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(5, 'Mane', 'Nkosi', NULL, 'mane2@gmail.com', NULL, 'cd943e31ceae919b77d96b46f20ea3305e70acaf3f154c66f83fdd1a17936b24', 'abUOo9ypuayT0Cazm6ns', '012355656', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-02-22 12:11:10', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
(6, 'Mane', 'Nkosi', NULL, 'emp@gmail.com', NULL, NULL, NULL, '012355656', NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-01 00:00:00', '2018-02-22 14:34:35', 1, '9454544566', '15 Maskhane diskfreespace', 'popularised', '3', '45', '5496264', '0000-00-00 00:00:00', 3, 2, 'Stripper', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `CompanyId` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Address1` varchar(255) DEFAULT NULL,
  `Address2` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `ProvinceId` varchar(255) DEFAULT NULL,
  `PostalCode` varchar(255) DEFAULT NULL,
  `CompanyType` int(11) NOT NULL,
  `NumberOfEmployees` int(11) NOT NULL,
  `ContactUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`CompanyId`, `Name`, `Address1`, `Address2`, `City`, `ProvinceId`, `PostalCode`, `CompanyType`, `NumberOfEmployees`, `ContactUserId`) VALUES
(1, 'Microsoft', '1500', NULL, 'Bryanston', '3', '007', 0, 78, 4);

-- --------------------------------------------------------

--
-- Table structure for table `company_information`
--

CREATE TABLE `company_information` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(65) NOT NULL,
  `type` varchar(65) NOT NULL,
  `size` varchar(65) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(65) NOT NULL,
  `province` varchar(65) NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_information`
--

INSERT INTO `company_information` (`id`, `user_id`, `company_name`, `type`, `size`, `address`, `city`, `province`, `timestamps`) VALUES
(1, 13, 'Discovery', 'private', '100', '2906 racecourse view, lakefield', 'Benoni', 'Gauteng', '2017-09-26 11:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplications`
--

CREATE TABLE `leaveapplications` (
  `LeaveApplicationId` int(11) NOT NULL,
  `LeaveId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Reason` text,
  `LeaveType` int(11) NOT NULL,
  `Approved` int(11) DEFAULT NULL,
  `Approver` int(11) NOT NULL,
  `DisapprovalReason` text,
  `CompanyId` int(11) NOT NULL,
  `ApproverName` text,
  `ApproverUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_granted`
--

CREATE TABLE `leave_granted` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_granted`
--

INSERT INTO `leave_granted` (`id`, `user_id`, `leave_id`, `start_date`, `end_date`, `timestamps`) VALUES
(1, 13, 3, '2017-09-14', '2017-09-15', '2017-09-26 14:06:57'),
(2, 13, 2, '2017-10-23', '2017-10-27', '2017-09-26 14:15:26'),
(3, 13, 2, '2017-09-10', '2017-09-13', '2017-09-26 14:28:52'),
(4, 5, 1, '2018-02-09', '2018-02-10', '2018-02-08 08:13:23'),
(5, 5, 1, '2018-02-11', '2018-02-12', '2018-02-08 08:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `leave_information`
--

CREATE TABLE `leave_information` (
  `leave_id` int(11) NOT NULL,
  `leave_name` varchar(200) NOT NULL,
  `min_days` int(255) NOT NULL,
  `max_days` int(255) NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_information`
--

INSERT INTO `leave_information` (`leave_id`, `leave_name`, `min_days`, `max_days`, `timestamps`) VALUES
(1, 'Annual', 1, 1, '2017-09-26 11:36:18'),
(2, 'Sick', 30, 30, '2017-09-26 11:38:19'),
(3, 'Maternity', 120, 120, '2017-09-26 11:41:00'),
(4, 'Family', 3, 3, '2017-09-26 11:41:00'),
(5, 'Unpaid', 0, 0, '2017-09-26 11:42:06'),
(6, 'Study', 0, 0, '2017-09-26 11:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `leave_request`
--

CREATE TABLE `leave_request` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `status` varchar(225) NOT NULL DEFAULT 'pending',
  `comments` text NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_request`
--

INSERT INTO `leave_request` (`request_id`, `user_id`, `leave_id`, `from_date`, `to_date`, `status`, `comments`, `timestamps`) VALUES
(1, 13, 1, '2017-09-28', '2017-09-29', 'approved', 'asdajsdhkh assjkhdkash dkash dkjashdkhakjdh aksdh kahsdkjh kdashdkh kdsjhkd adasda ', '2017-09-27 10:13:59'),
(2, 13, 6, '2017-10-04', '2017-10-06', 'declined', 'skjsldfj flskdjf lsdjflk sjfldkjlks djflksjldfj lsdkjflsdkjf klsdjfklj sldkfjl sfs d', '2017-09-27 10:14:39'),
(3, 5, 1, '2018-03-07', '2018-04-07', 'approved', 'No comment I just want to play my XBOX without the headaches of deadlines', '2018-02-07 15:27:35'),
(4, 5, 1, '2018-02-07', '2018-07-08', 'approved', '', '2018-02-07 15:59:16'),
(5, 5, 1, '2018-03-12', '2018-02-12', 'pending', '', '2018-02-12 07:31:34'),
(6, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-12 07:31:59'),
(7, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-12 07:48:08'),
(8, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-12 07:48:10'),
(9, 5, 1, '2018-05-14', '2018-03-12', 'pending', '', '2018-02-12 07:48:47'),
(10, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-12 07:50:44'),
(11, 5, 1, '2018-04-12', '0000-00-00', 'pending', '', '2018-02-12 07:51:00'),
(12, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-13 13:57:15'),
(13, 5, 1, '2018-12-13', '0000-00-00', 'pending', '', '2018-02-13 13:57:21'),
(14, 5, 1, '2018-04-13', '2018-03-13', 'pending', '', '2018-02-13 13:57:32'),
(15, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-13 13:59:50'),
(16, 5, 1, '2018-01-13', '0000-00-00', 'pending', '', '2018-02-13 13:59:54'),
(17, 5, 1, '0000-00-00', '0000-00-00', 'pending', '', '2018-02-13 14:01:21'),
(18, 5, 3, '2018-06-13', '0000-00-00', 'pending', '', '2018-02-13 14:01:28'),
(19, 5, 5, '2019-05-13', '2020-04-15', 'pending', '', '2018-02-13 14:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `person_information`
--

CREATE TABLE `person_information` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(65) NOT NULL,
  `second_name` varchar(65) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(65) NOT NULL,
  `race` varchar(65) NOT NULL,
  `sa_passport` varchar(65) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(65) NOT NULL,
  `province` varchar(65) NOT NULL,
  `person_number` varchar(65) NOT NULL,
  `tax_number` varchar(65) NOT NULL,
  `role` varchar(65) NOT NULL,
  `is_admin` varchar(65) NOT NULL,
  `date_hired` date NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person_information`
--

INSERT INTO `person_information` (`id`, `user_id`, `first_name`, `second_name`, `date_of_birth`, `gender`, `race`, `sa_passport`, `phone`, `address`, `city`, `province`, `person_number`, `tax_number`, `role`, `is_admin`, `date_hired`, `timestamps`) VALUES
(29, 13, 'Thabang', 'Mangope', '2017-09-21', 'Male', 'African', '9012225377080', '0739880253', '2906 Racecourse view, Lakefield', 'Benoni', 'Gauteng', '1234567889', '1231321398', 'iOS Developer', 'Admin', '2017-09-30', '2017-09-25 09:30:25'),
(30, 3, 'Test ', 'Test', '2017-10-24', 'Male', 'African', '9105195786085', '+27636077912', '123 the place JHB', 'Johannesburg', 'Gauteng', '12345', '655463543', 'Developer', '', '2017-11-24', '2017-11-24 12:57:13'),
(31, 5, 'Roger', 'Nkosi', '2015-10-01', 'Male', 'African', '9105195786085', '+27636077912', '123 The Place, PTA', 'Johannesburg', 'Gauteng', '12345', '655463543', 'Developer', '', '2017-11-24', '2017-12-01 08:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `ProvinceId` int(11) NOT NULL,
  `Abbreviation` varchar(8) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`ProvinceId`, `Abbreviation`, `Name`) VALUES
(1, 'EC', 'Eastern Cape'),
(2, 'FS', 'Free State'),
(3, 'GAU', 'Gauteng'),
(4, 'KZN', 'KwaZulu-Natal'),
(5, 'LIM', 'Limpopo'),
(6, 'MPU', 'Mpumalanga'),
(7, 'NW', 'North West'),
(8, 'NC', 'Northern Cape'),
(9, 'WC', 'Western Cape');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Name` varchar(256) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timelines`
--

CREATE TABLE `timelines` (
  `TimelineId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `LeaveType` varchar(60) DEFAULT NULL,
  `Notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `session_id` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'stores session cookie id to prevent session concurrency',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `user_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s deletion status',
  `user_account_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s account type (basic, premium, etc)',
  `user_has_avatar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if user has a local avatar, 0 if not',
  `user_remember_me_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `user_creation_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the creation of user''s account',
  `user_suspension_timestamp` bigint(20) DEFAULT NULL COMMENT 'Timestamp till the end of a user suspension',
  `user_last_login_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of user''s last login',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attempts',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_provider_type` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `session_id`, `user_name`, `user_password_hash`, `user_email`, `user_active`, `user_deleted`, `user_account_type`, `user_has_avatar`, `user_remember_me_token`, `user_creation_timestamp`, `user_suspension_timestamp`, `user_last_login_timestamp`, `user_failed_logins`, `user_last_failed_login`, `user_activation_hash`, `user_password_reset_hash`, `user_password_reset_timestamp`, `user_provider_type`) VALUES
(4, '0cf0f7d1f9b5f5b0b64b3b7ba76ae856', 'Winnie', '$2y$10$GXRRWrEn5QnyS.Fy2Kx2BejB6pKtl7f3Hkj0TN63h3gxvo8/Tv.h2', 'winniem@pluritone.co.za', 1, 0, 1, 0, NULL, 1511767592, NULL, 1512128967, 0, NULL, NULL, NULL, NULL, 'DEFAULT'),
(5, '827hlt5105p40cm4quddd3u1up', 'roger', '$2y$10$uwOgOtDrHjKmumLpoaMQ6efA9sqdttgdKuQTzRXfZ74seywVAf.ru', 'rogermphile1991@gmail.com', 1, 0, 7, 1, NULL, 1512115534, NULL, 1518530201, 0, NULL, NULL, '039e05bb625302d9a7e6798036be7d15cc6a0054', 1518519372, 'DEFAULT'),
(13, NULL, 'daddffd', '$2y$10$.gBE7ZacHo5QdX5uk0vjBuSDDuki5IJwzf5KPuJvX6LKZGHp5n8DG', 'john@gmail.com', 0, 0, 1, 0, NULL, 1518444000, NULL, NULL, 0, NULL, '2b4bbe21dc57803f666babc9a3b8777689c535c8', NULL, NULL, 'DEFAULT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caphusers`
--
ALTER TABLE `caphusers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`CompanyId`);

--
-- Indexes for table `company_information`
--
ALTER TABLE `company_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaveapplications`
--
ALTER TABLE `leaveapplications`
  ADD PRIMARY KEY (`LeaveApplicationId`);

--
-- Indexes for table `leave_granted`
--
ALTER TABLE `leave_granted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_information`
--
ALTER TABLE `leave_information`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `person_information`
--
ALTER TABLE `person_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`ProvinceId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `timelines`
--
ALTER TABLE `timelines`
  ADD PRIMARY KEY (`TimelineId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caphusers`
--
ALTER TABLE `caphusers`
  MODIFY `user_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `CompanyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `company_information`
--
ALTER TABLE `company_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `leaveapplications`
--
ALTER TABLE `leaveapplications`
  MODIFY `LeaveApplicationId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_granted`
--
ALTER TABLE `leave_granted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `leave_information`
--
ALTER TABLE `leave_information`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `leave_request`
--
ALTER TABLE `leave_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `person_information`
--
ALTER TABLE `person_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `ProvinceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timelines`
--
ALTER TABLE `timelines`
  MODIFY `TimelineId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=14;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
