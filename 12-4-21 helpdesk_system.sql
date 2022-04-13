-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2022 at 10:37 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `userId`, `description`, `timestamp`) VALUES
(15, 3, 'User logged in.', '2022-02-19 12:45:17'),
(16, 3, 'User logged in.', '2022-02-19 12:47:06'),
(17, 3, 'User logged out.', '2022-02-19 12:49:21'),
(18, 4, 'User logged in.', '2022-02-19 12:49:27'),
(19, 4, 'User logged out.', '2022-02-19 12:53:38'),
(20, 4, 'User logged in.', '2022-02-21 09:43:38'),
(21, 4, 'New ticket created.', '2022-02-21 10:27:00'),
(22, 4, 'User logged in.', '2022-03-10 11:11:02'),
(23, 4, 'User logged out.', '2022-03-10 11:11:20'),
(24, 3, 'User logged in.', '2022-03-21 12:21:17'),
(25, 3, 'User logged out.', '2022-03-21 12:22:25'),
(26, 4, 'User logged in.', '2022-03-21 20:21:54'),
(27, 4, 'Password updated successfully.', '2022-03-21 20:22:07'),
(28, 4, 'User logged out.', '2022-03-21 20:22:15'),
(29, 4, 'User logged in.', '2022-03-21 20:22:17'),
(30, 4, 'User logged out.', '2022-03-21 20:22:18'),
(31, 4, 'User logged in.', '2022-04-12 13:25:25'),
(32, 4, 'User logged out.', '2022-04-12 13:26:00'),
(33, 4, 'User logged in.', '2022-04-12 13:39:12'),
(34, 4, 'User logged in.', '2022-04-12 17:06:45'),
(35, 4, 'Error updating password.', '2022-04-12 17:07:00'),
(36, 4, 'User logged out.', '2022-04-12 17:07:01'),
(37, 4, 'User logged in.', '2022-04-12 17:10:08'),
(38, 4, 'User logged out.', '2022-04-12 17:11:38'),
(39, 4, 'User logged in.', '2022-04-12 17:28:37'),
(40, 4, 'User logged out.', '2022-04-12 17:29:14'),
(41, 4, 'User logged in.', '2022-04-12 17:29:15'),
(42, 4, 'User logged out.', '2022-04-12 17:29:26'),
(43, 4, 'User logged in.', '2022-04-12 17:29:58'),
(44, 4, 'User logged out.', '2022-04-12 17:49:17'),
(45, 4, 'User logged in.', '2022-04-12 17:49:51'),
(46, 4, 'User logged out.', '2022-04-12 17:50:53'),
(47, 4, 'User logged in.', '2022-04-12 17:50:55'),
(48, 4, 'User logged out.', '2022-04-12 17:54:41'),
(49, 4, 'User logged in.', '2022-04-12 17:57:21'),
(50, 4, 'User logged out.', '2022-04-12 17:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticketId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `ticketId`, `userId`, `message`, `created`) VALUES
(11, 11, 4, 'Could you please give the email address.', '2022-02-16 12:27:18'),
(12, 12, 6, 'Software - Microsoft Word', '2022-02-16 12:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `priority` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Open',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `closed` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `userId`, `title`, `priority`, `category`, `description`, `status`, `created`, `closed`) VALUES
(11, 3, 'Password Reset', 'High', 'Account', 'Need password resetting to my email account.', 'Open', '2022-02-16 11:58:04', NULL),
(12, 6, 'Product Key Invalid', 'Medium', 'Software', 'Current product key to redeem software invalid. ', 'Open', '2022-02-16 12:29:28', NULL),
(13, 3, 'Mouse Unresponsive', 'High', 'Other', 'Mouse connected to PC isn\'t working.', 'Closed', '2022-02-16 12:30:19', '2022-02-16 12:32:26'),
(14, 4, 'Test title.', 'Low', 'Hardware', 'Low priority.', 'Open', '2022-02-18 10:07:25', NULL),
(15, 4, 'Another Low Ticket', 'Low', 'Account', 'Another Low Title.', 'Open', '2022-02-18 10:08:15', NULL),
(16, 4, 'Test Title', 'Low', 'Hardware', 'Test ticket for testing responsive table.', 'Open', '2022-02-21 10:27:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT 1,
  `last_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `password`, `permission`, `last_updated`) VALUES
(3, 'test@user.com', '$2y$12$TBoGtOmcOivrZtlTqRztKeYYEbjImdATgoMx.qgxtl8nJM7j2P.te', 0, NULL),
(4, 'test@admin.com', '$2y$12$aVaw8vQtFsWo2yN0BSWeYelncQfQAGeczwknLeIbnVx5IakBgp3fy', 2, '2021-12-20 23:06:48'),
(6, 'test@support.com', '$2y$12$TBoGtOmcOivrZtlTqRztKeYYEbjImdATgoMx.qgxtl8nJM7j2P.te', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userIdActivity` (`userId`) USING BTREE;

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_USER_ID` (`userId`),
  ADD KEY `FK_TICKET_ID` (`ticketId`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_TICKET_ID` FOREIGN KEY (`ticketId`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_USER_ID` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
