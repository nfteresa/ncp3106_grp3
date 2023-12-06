-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 02:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stud_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `stud_info`
--

CREATE TABLE `stud_info` (
  `stud_id` int(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(20) NOT NULL,
  `student_number` bigint(11) NOT NULL,
  `program` varchar(50) NOT NULL,
  `current_year` varchar(50) NOT NULL,
  `ue_email` varchar(150) NOT NULL,
  `contact_number` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stud_info`
--

INSERT INTO `stud_info` (`stud_id`, `first_name`, `last_name`, `middle_initial`, `student_number`, `program`, `current_year`, `ue_email`, `contact_number`) VALUES
(54, 'dsada', 'dsadsad', 'a', 156156489498, 'CpE', '4th', 'dsadas@gmail.com', 9156821682),
(55, 'Neil', 'Francis', 'A', 20210106120, 'ME', '3rd', 'neil@gmail.com', 189848979879),
(56, 'fsaf', 'safa', 'a', 20210106120, 'CpE', '4th', 'dsada@gmail.com', 9156821682);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stud_info`
--
ALTER TABLE `stud_info`
  ADD PRIMARY KEY (`stud_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stud_info`
--
ALTER TABLE `stud_info`
  MODIFY `stud_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
