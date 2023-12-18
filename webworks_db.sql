-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 05:41 AM
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
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `email`, `username`, `password`, `usertype`, `status`, `created`, `updated`) VALUES
(1, 'bvrlisah@gmail.com', 'Admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', 1, '2023-10-26 21:01:34', '2023-10-26 21:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branchCode` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `branchName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `coordinates` varchar(100) NOT NULL,
  `branchImage` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `businessCode` int(11) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `busName` varchar(100) NOT NULL,
  `about` varchar(500) NOT NULL,
  `busType` varchar(100) NOT NULL,
  `house_building` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `permits` longblob NOT NULL,
  `busImage` longblob NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `businesstypes`
--

CREATE TABLE `businesstypes` (
  `typeCode` int(11) NOT NULL,
  `typeName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `businesstypes`
--

INSERT INTO `businesstypes` (`typeCode`, `typeName`) VALUES
(7, 'Photography'),
(8, 'Catering'),
(9, 'Funeral Services'),
(10, 'Flower Shop');

-- --------------------------------------------------------

--
-- Table structure for table `business_owner`
--

CREATE TABLE `business_owner` (
  `ownerID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `verification_code` varchar(200) NOT NULL,
  `number` varchar(30) NOT NULL,
  `ownerAddress` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_owner`
--

INSERT INTO `business_owner` (`ownerID`, `fname`, `lname`, `birthday`, `email`, `verification_code`, `number`, `ownerAddress`, `username`, `password`, `usertype`, `status`, `created`, `updated`) VALUES
(28, 'Jose ', 'Puga', '1985-10-21', 'bvrlisah@gmail.com', '025232', '09452781051', '', 'JosePuga', '$argon2i$v=19$m=65536,t=4,p=1$dlYzVWM3ZTB6WHlZMjRkWQ$uXqRlJ7A6I70lW8qQnKYcYYzWPRRsc4LhSqouUXAgDU', 'business owner', 1, '2023-12-18 01:51:48', '2023-12-18 01:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryCode` int(11) NOT NULL,
  `packCode` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `verification_code` int(100) NOT NULL,
  `number` varchar(30) NOT NULL,
  `ownerAddress` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `fname`, `lname`, `birthday`, `email`, `verification_code`, `number`, `ownerAddress`, `username`, `password`, `usertype`, `status`, `created`, `updated`) VALUES
(15, 'Jireh', 'Nieves', '2001-02-13', 'bvrlisah@gmail.com', 558955, '09452781051', '', 'Jireh', '$argon2i$v=19$m=65536,t=4,p=1$dnRva3NXSXZkMzRIeGZELw$psmL3JC0LIOnWT+8hezkEwc2QkQlXNoZTR0kfKTvE80', 'client', 1, '2023-12-17 16:55:20', '2023-12-17 16:55:20');

-- --------------------------------------------------------

--
-- Table structure for table `custom_package`
--

CREATE TABLE `custom_package` (
  `customCode` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL,
  `serviceName` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `price` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `packCode` int(11) NOT NULL,
  `packName` varchar(50) NOT NULL,
  `branchCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `sourceID` varchar(100) NOT NULL,
  `amount` int(200) NOT NULL,
  `paymentDate` date DEFAULT current_timestamp(),
  `businessName` varchar(100) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `serviceCode` int(11) NOT NULL,
  `categoryCode` int(11) NOT NULL,
  `serviceName` varchar(100) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `price` bigint(255) NOT NULL,
  `stocks` int(255) NOT NULL,
  `itemImage` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherID` int(255) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `code` varchar(200) NOT NULL,
  `discount` int(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `cond` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`branchCode`),
  ADD KEY `businessCode` (`businessCode`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`businessCode`),
  ADD KEY `ownerID` (`ownerID`);

--
-- Indexes for table `businesstypes`
--
ALTER TABLE `businesstypes`
  ADD PRIMARY KEY (`typeCode`);

--
-- Indexes for table `business_owner`
--
ALTER TABLE `business_owner`
  ADD PRIMARY KEY (`ownerID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryCode`),
  ADD KEY `packCode` (`packCode`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `custom_package`
--
ALTER TABLE `custom_package`
  ADD PRIMARY KEY (`customCode`),
  ADD KEY `clientID` (`clientID`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`packCode`),
  ADD KEY `branchCode` (`branchCode`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`serviceCode`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherID`),
  ADD KEY `businessCode` (`businessCode`);

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
  MODIFY `branchCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `businessCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `businesstypes`
--
ALTER TABLE `businesstypes`
  MODIFY `typeCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `business_owner`
--
ALTER TABLE `business_owner`
  MODIFY `ownerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `custom_package`
--
ALTER TABLE `custom_package`
  MODIFY `customCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `serviceCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucherID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `businessCode` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`);

--
-- Constraints for table `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `ownerID` FOREIGN KEY (`ownerID`) REFERENCES `business_owner` (`ownerID`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `packCode` FOREIGN KEY (`packCode`) REFERENCES `package` (`packCode`);

--
-- Constraints for table `custom_package`
--
ALTER TABLE `custom_package`
  ADD CONSTRAINT `clientID` FOREIGN KEY (`clientID`) REFERENCES `client` (`clientID`);

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `branchCode` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);

--
-- Constraints for table `voucher`
--
ALTER TABLE `voucher`
  ADD CONSTRAINT `voucher_ibfk_1` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
