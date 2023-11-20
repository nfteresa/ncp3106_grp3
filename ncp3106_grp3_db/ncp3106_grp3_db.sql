-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 12:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ncp3106_grp3_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(255) NOT NULL,
  `student_number` text NOT NULL,
  `payment` int(255) NOT NULL,
  `event_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_info`
--

CREATE TABLE `event_info` (
  `event_id` int(255) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `event_description` text NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `registration_fee` float NOT NULL,
  `venue` text NOT NULL,
  `oic` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_info`
--

INSERT INTO `event_info` (`event_id`, `event_name`, `event_description`, `event_type`, `date`, `start_time`, `end_time`, `registration_fee`, `venue`, `oic`) VALUES
(1, 'Salsal kila Sal', 'salsalan', 'salsalan', '2014-05-21', '05:00:00', '17:00:00', 200, 'Kila Sal', 'Sal'),
(2, 'Salsal kila Sal2', 'salsalan', 'salsalan', '2023-11-10', '07:37:00', '19:48:00', 500, 'Kila Sal', 'Sal');

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int(255) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `middle_initial` varchar(10) NOT NULL,
  `student_number` text NOT NULL,
  `program` varchar(255) NOT NULL,
  `current_year` varchar(5) NOT NULL,
  `ue_email` text NOT NULL,
  `contact_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `first_name`, `last_name`, `middle_initial`, `student_number`, `program`, `current_year`, `ue_email`, `contact_number`) VALUES
(6, 'Angelo Ian Miguel', 'Daniel', 'R', '20140143426', 'BS CpE', '3rd', 'daniel.angeloianmiguel@gmail.com', '09568699913'),
(7, 'Zejirah Gavin', 'Gregorio', 'S', '20140143426', 'BS CpE', '3rd', 'gregorio.zejirahgavin@gmail.com', '09776931716');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_info`
--
ALTER TABLE `event_info`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_info`
--
ALTER TABLE `event_info`
  MODIFY `event_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
