-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 10:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `djmtech`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `full_name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'John Doe', 'johndoe@test.com', '09123456789', 'aa', '2025-03-03 20:15:08'),
(2, 'Apple Bee', 'ianpepe99@gmail.com', '09123456789', 'Hello, I\'d like to...', '2025-03-03 20:21:35'),
(3, 'Apple Bee', 'ianpepe99@gmail.com', '09123456789', 'Hello, I\'d like to...', '2025-03-03 20:22:44'),
(4, 'Mango Jam', 'ianpepe99@gmail.com', '09123456789', 'Hello po, I\'d like to...', '2025-03-03 20:29:44'),
(5, 'Mango Jam', 'ianpepe99@gmail.com', '09123456789', 'Hello po, I\'d like to...', '2025-03-03 20:35:52'),
(6, 'Mango Jam', 'ianpepe99@gmail.com', '09123456789', 'Hello po, I\'d like to...', '2025-03-03 20:35:57'),
(7, 'Ross Test', 'ianpepe99@gmail.com', '09123456789', 'This is a sample message.', '2025-03-03 20:37:41'),
(8, 'Ross Test', 'ianpepe99@gmail.com', '09123456789', 'This is a sample message.', '2025-03-03 20:43:16'),
(9, 'Ross Test', 'ianpepe99@gmail.com', '09123456789', 'This is a sample message.', '2025-03-03 20:47:02'),
(10, 'Ross Tester', 'ianpepe99@gmail.com', '09123456781', 'aaaaaBBBCCCCDDDDD test', '2025-03-03 20:50:58'),
(11, 'Ross Tester', 'ianpepe99@gmail.com', '09123456781', 'aaaaaBBBCCCCDDDDD test', '2025-03-03 20:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `street_address` text NOT NULL,
  `barangay` text NOT NULL,
  `city` text NOT NULL,
  `province` text NOT NULL,
  `zip_code` char(4) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `street_address`, `barangay`, `city`, `province`, `zip_code`, `password`, `created_at`) VALUES
(6, 'A', 'B', 'ab@test.com', '09123456789', 'A', 'B', 'C', '', '', '$2y$10$T1mjBnGWIDooGHiicezPMeslscJo9S3/UzUwyFKK/ZutccMgaJtcO', '2025-02-22 11:10:37'),
(7, 'James', 'Bond', 'jbond@gmail.com', '09123456789', 'A', 'B', 'C', '', '', '$2y$10$/Vq9//obN8FfJ5gi2XwIl.eobGvulj/zukxLvaaKpJE7dgK2bjVjC', '2025-02-22 11:32:25'),
(8, 'Randall', 'Test', 'rtest@gmail.com', '09123456789', '123 Street St', 'Ugong', 'Valenzuela City', '', '', '$2y$10$8YNtdjtc4htDKhDObT6oAe186TrEtvjAPJx91bn35ljdZE2o5geKC', '2025-02-22 11:34:32'),
(9, 'John', 'Tester', 'jtester@gmail.com', '09123456789', '123 Tester St', 'Ugong', 'Valenzuela', '', '', '$2y$10$SmBRGc4KAym0kF8T4NJ4PeSux7b.p/jOQXBJfscoqTOwdsQRb8sza', '2025-02-22 11:42:15'),
(10, 'Franchesca', 'Cleofas', 'f.cleofas@testuser.com', '09123456789', '1234 Cutie St', 'Malanda', 'Valenzuela City', '', '', '$2y$10$hHN8/cf7H01ZNz4vx4mBSuHJYpXvF8P61yWLIiMdT0Vy38m/2oB8S', '2025-02-27 07:44:21'),
(11, 'AA', 'BB', 'testss@sample.com', '09123456789', 'AA', 'BB', 'CC', 'DD', '', '$2y$10$fVxLiH5tJQQfP1y5bGqqfO1qfxOjCjx2RjNdgjeXv7wtUS9H1laQ2', '2025-03-03 11:48:40'),
(12, 'Sponge', 'Bob', 'sbob@test.com', '09123456789', 'AA', 'BB', 'CC', 'DD', '0000', '$2y$10$AnV/gaQNSq67wvHxFDXhgOuWyk09I26ObWr1dAUcQYZ1J91aZvbuS', '2025-03-03 13:05:11'),
(13, 'Ian', 'Pepe', 'ianpepe99@gmail.com', '09123456789', 'AA', 'BB', 'CC', 'DD', '1234', '$2y$10$Wx6I0CJTiZ6u4sp60uu4duKytipPDRZzJR58khRDJqFSFvONVotua', '2025-03-03 17:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertoken`
--

CREATE TABLE `tbl_usertoken` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_usertoken`
--
ALTER TABLE `tbl_usertoken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_usertoken`
--
ALTER TABLE `tbl_usertoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_usertoken`
--
ALTER TABLE `tbl_usertoken`
  ADD CONSTRAINT `tbl_usertoken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
