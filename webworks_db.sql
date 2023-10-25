-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 04:39 AM
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
-- Database: `webworks_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `username`, `password`, `usertype`) VALUES
(1, 'admin', 'admin12345', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branchCode` int(50) NOT NULL,
  `branchName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `coordinates` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `businessCode` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ownerName` varchar(100) NOT NULL,
  `ownerAddress` varchar(100) NOT NULL,
  `busName` varchar(100) NOT NULL,
  `busType` varchar(100) NOT NULL,
  `house_building` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `coordinates` varchar(100) NOT NULL,
  `permits` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`businessCode`, `userID`, `ownerName`, `ownerAddress`, `busName`, `busType`, `house_building`, `street`, `barangay`, `city_municipality`, `province`, `region`, `phone`, `mobile`, `coordinates`, `permits`) VALUES
(30, 25, 'Alisah', 'sdsad', 'asasd', '1', 'sad', 'JEREOS', '', 'ILOILO CITY (CAPITAL)', 'ILOILO', '6', '+639203633104', '09452781051', '12121212', 0x636f72652076616c75657320616e642068796769656e6520616e642073616e69746174696f6e2e646f6378);

-- --------------------------------------------------------

--
-- Table structure for table `email_verify`
--

CREATE TABLE `email_verify` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verification_code` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fname`, `lname`, `birthday`, `email`, `number`, `username`, `password`, `usertype`, `status`, `created`, `updated`) VALUES
(24, 'alisah', 'bolivar', '2001-07-01', 'bvrlisah@gmail.com', '09293475344', 'lorem', '827ccb0eea8a706c4c34a16891f84e7b', 'client', 1, '2023-10-20 03:30:44', '2023-10-20 03:30:44'),
(25, 'mae', 'bolivar', '2001-07-02', 'lalalaamb@gmail.com', '0929347534', 'ipsum', '827ccb0eea8a706c4c34a16891f84e7b', 'business owner', 1, '2023-10-20 03:32:25', '2023-10-20 03:32:25'),
(26, 'Jireh Antonette', 'Nieves', '2001-07-13', 'jireh@gmail.com', '09203633104', 'lily', '827ccb0eea8a706c4c34a16891f84e7b', 'client', 0, '2023-10-24 06:23:15', '2023-10-24 06:23:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branchCode`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`businessCode`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `email_verify`
--
ALTER TABLE `email_verify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branchCode` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `businessCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `email_verify`
--
ALTER TABLE `email_verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
