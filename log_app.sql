-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 05:23 PM
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
-- Database: `log_app`
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
(1, 'admin', '$2y$10$ygLWV0U4uANrYpV1T9qSo.8FjyYQ1UldTFXqDnUPyTmwMS62XT39m', 1),
(2, 'johndoe', '$2y$10$GagRg9Lv1dYwXkPzDO9N7uH/LbYixZiEmpjaRIbyVQqgPuo4JYmUy', 0),
(3, 'janedoe', '$2y$10$ModvmipqVh5/fuNizZL2DeuZawuUcjEiAV3d.jBcNxxe/OWSQC0DG', 0),
(4, 'rein', '$2y$10$kfkvVo4vpiTvmSMvpwD5IOWvRrg4UQEmi2E2/6j7jCr4Nrbju6NNu', 1),
(6, 'aldwin', '$2y$10$svBSvtSxDstb.0hWeIzxdOeqNcg65UNJJDsCPJMssu5NMswYulY5q', 0);

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
(1, 'Rein', '22-0365-457', 1, '2024-07-15 14:25:28', NULL, '2024-07-15 20:34:43'),
(7, 'Ariel', '22-0365-453', 1, '2024-07-17 22:09:29', '2024-07-17 22:11:29', '2024-07-16 20:09:01'),
(9, 'Rein', '', 1, '2024-06-17 15:22:54', NULL, '2024-06-17 15:22:52'),
(10, 'John', '', 1, '2024-07-18 14:38:14', NULL, '2024-07-18 14:38:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lab_log`
--
ALTER TABLE `lab_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
