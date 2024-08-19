-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 09:27 PM
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
-- Database: `mcut-complaints`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `campus` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cnic` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `complaint_detail` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Solved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `campus`, `program`, `student_id`, `name`, `cnic`, `email`, `phone`, `complaint_detail`, `submission_date`, `status`) VALUES
(1, 'DG Khan Campus', 'BS Civil Engineering Technology', '2022-mcut-245', 'ibkhanib', '3210288855127', 'ibmughal29003003@gmail.com', '03323322218', 'vfkvfknvnvnvsvnsofk', '2024-08-09 13:02:49', 'Solved'),
(12, 'DG Khan Campus', 'BS Chemical Engineering Technology', '2022-mcut-040', 'ibk', '3210288855122', 'h8392016@gmail.com', '03323322210', 'vknvmc,nv', '2024-08-11 10:03:35', 'Solved'),
(13, 'DG Khan Campus', 'BS Petrochemical Engineering Technology', '2022-mcut-000', 'kkakaka', '3210282555129', 'ibmughal990@gmail.com', '03323322219', 'fsdnv,mfv sfkjvnfjklnvl', '2024-08-11 11:01:46', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
