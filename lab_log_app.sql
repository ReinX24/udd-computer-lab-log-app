-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2024 at 05:42 AM
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
-- Database: `lab_log_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `master_account` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `username`, `password`, `master_account`) VALUES
(1, 'admin', '$2y$10$FxG1Mi027pJkaN.qiLoqkebC8n4i.vR/FSrA7mmqjBNXSH.blVqRK', 1),
(2, 'johndoe', '$2y$10$GagRg9Lv1dYwXkPzDO9N7uH/LbYixZiEmpjaRIbyVQqgPuo4JYmUy', 0),
(3, 'janedoe', '$2y$10$ModvmipqVh5/fuNizZL2DeuZawuUcjEiAV3d.jBcNxxe/OWSQC0DG', 0),
(4, 'rein', '$2y$10$kfkvVo4vpiTvmSMvpwD5IOWvRrg4UQEmi2E2/6j7jCr4Nrbju6NNu', 1),
(5, 'aldwin', '$2y$10$JKVTckeAbYNtHYf1qvGToO7ylrs9QM/pkA3SPVXNuH2f/ohoVLfPu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `is_edited` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `feedback`, `category`, `is_edited`, `created_at`) VALUES
(1, 'Rein', 'This is an example of a feedback!', 'miscellaneous', 0, '2024-06-05 21:59:10'),
(4, 'Anonymous', 'This is a sample feedback!', 'miscellaneous', 0, '2024-06-22 00:42:14'),
(5, 'Rein', 'Its aight', 'miscellaneous', 0, '2024-06-25 20:05:27'),
(6, 'John', 'Lorem ipsum I forgot the other parts of the text.', 'miscellaneous', 0, '2024-06-25 20:10:25'),
(7, 'John', 'Lorem ipsum I forgot the other parts of the text.', 'miscellaneous', 0, '2024-06-25 20:10:48'),
(8, 'John', 'More random text.', 'miscellaneous', 0, '2024-06-25 20:13:43'),
(9, 'Jane', 'Hooray!', 'miscellaneous', 0, '2024-06-25 20:14:20'),
(12, 'Anonymous', 'This is a feedback form.\r\n\r\nWith multiple sentences.\r\n\r\nWow', 'miscellaneous', 0, '2024-07-02 10:03:26'),
(14, 'Anonymous', 'This is some feedback text for the category of books.', 'books', 0, '2024-07-02 10:33:43'),
(15, 'Anonymous', 'This is feedback for staff.', 'staff', 0, '2024-07-02 20:07:47'),
(17, 'Anonymous', 'This is feedback for staff and this is edited.', 'staff', 1, '2024-07-02 20:08:48'),
(20, 'Anonymous', 'This is a misc feedback and it is edited.', 'facilities', 1, '2024-07-03 22:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `lab_log`
--

CREATE TABLE `lab_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `computer_number` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_log`
--

INSERT INTO `lab_log` (`id`, `name`, `student_id`, `computer_number`, `time_in`, `time_out`, `created_at`) VALUES
(1, 'Rein', NULL, 1, '2024-07-15 14:25:28', NULL, '2024-07-15 20:34:43'),
(2, 'John', '', 3, '2024-07-15 11:03:13', NULL, '2024-07-15 11:03:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_log`
--
ALTER TABLE `lab_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lab_log`
--
ALTER TABLE `lab_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;