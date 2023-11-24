-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 03:39 AM
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
(1, 'bvrlisah@gmail.com', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', 1, '2023-10-26 21:01:34', '2023-10-26 21:01:34');

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

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branchCode`, `businessCode`, `branchName`, `address`, `coordinates`, `branchImage`) VALUES
(6, 5, 'Puga Funeral (Mina Branch)', 'Mina,Iloilo', '10.93010757608374, 122.57405593125402', 0x6173736574732f75706c6f6164732f6272616e636865732f5757372e706e67),
(10, 11, 'Jereos Branch', 'Jereos Lapaz', '10.723704105713022, 122.57359924027696', 0x6173736574732f75706c6f6164732f6272616e636865732f52756e6e6572205b31393230c397313038305d2e6a666966),
(11, 5, 'Janiuay Branches', 'Janiuay Iloilo Province', '10.999772093429714, 122.4238781447832', 0x6173736574732f75706c6f6164732f6272616e636865732f5757372e706e67);

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

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`businessCode`, `ownerID`, `busName`, `about`, `busType`, `house_building`, `street`, `barangay`, `city_municipality`, `province`, `region`, `phone`, `mobile`, `permits`, `busImage`, `status`) VALUES
(5, 2, 'Puga Funeral Services', 'Puga Funeral Parlor: Honoring Lives, Supporting Families  At Puga Funeral Parlor, we understand the delicate and emotional nature of saying farewell to a loved one. With a legacy of compassion and professionalism, we stand as a pillar of support for grieving families during their most challenging times.', 'Funeral Services', '12', 'JEREOS', 'Jereos', 'ILOILO CITY (CAPITAL)', 'ILOILO', '6', '09452781052', '09452781051', 0x6173736574732f75706c6f6164732f62616a616a2e706e67, 0x6173736574732f75706c6f6164732f627573696e6573732f5757372e706e67, 1),
(11, 2, 'Alisah Photography Services', 'Premium Photography', 'Photography', '45', 'Bulong', 'Norte', 'Iloilo', 'Iloilo', '6', '09647384566', '09837465327', 0x6173736574732f75706c6f6164732f52756e6e6572205b31393230c397313038305d2e6a666966, 0x6173736574732f75706c6f6164732f627573696e6573732f3336305f465f3536323939333132325f653770476b655938794d66584a63526d636c736f496a744f6f56444467496c682e6a7067, 1);

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

INSERT INTO `business_owner` (`ownerID`, `fname`, `lname`, `birthday`, `email`, `number`, `ownerAddress`, `username`, `password`, `usertype`, `status`, `created`, `updated`) VALUES
(2, 'Alisah Mae', 'Bolivar', '0001-01-07', 'bvrlisah@gmail.com', '09452781051', '28 Dayot Subdivision Jereos Street La Paz, Iloilo City', 'Owner', '827ccb0eea8a706c4c34a16891f84e7b', 'business owner', 1, '2023-10-26 09:03:03', '2023-10-26 09:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryCode` int(11) NOT NULL,
  `packCode` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryCode`, `packCode`, `categoryName`) VALUES
(38, 27, 'Casket'),
(39, 27, 'Floral Arrangements'),
(44, 27, 'Transportation');

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

INSERT INTO `client` (`clientID`, `fname`, `lname`, `birthday`, `email`, `number`, `ownerAddress`, `username`, `password`, `usertype`, `status`, `created`, `updated`) VALUES
(1, 'Jireh', 'NIevs', '2001-12-01', 'lalalaamb@gmail.com', '09452781051', '', 'jireh', '827ccb0eea8a706c4c34a16891f84e7b', 'client', 0, '2023-10-25 08:51:53', '2023-10-25 08:51:53'),
(2, 'Jireh  Antonette', 'Nieves', '2001-12-02', 'jirehsevein@gmail.com', '09452781052', 'Lapuz', 'User', '827ccb0eea8a706c4c34a16891f84e7b', 'client', 1, '2023-10-25 08:59:20', '2023-10-25 08:59:20');

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
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `packCode` int(11) NOT NULL,
  `packName` varchar(50) NOT NULL,
  `branchCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`packCode`, `packName`, `branchCode`) VALUES
(27, 'Funeral Package: \"Basic Services\"', 6);

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
  `color` varchar(100) NOT NULL,
  `price` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`serviceCode`, `categoryCode`, `serviceName`, `Description`, `quantity`, `color`, `price`) VALUES
(26, 38, 'Premium Solid Wood Casket', ' Handcrafted from mahogany, lined with satin, and adorned with elegant brass handles.', 1, 'Mahogany', 120000),
(27, 39, 'Full Floral Package', 'A selection of fresh flowers including lilies, roses, and carnations for casket adornment and venue ', 1, 'Assorted', 5000),
(32, 44, ' Hearse Rental', 'Elegant and well-maintained hearse for dignified transportation to the final resting place.', 1, 'Black', 10000);

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
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`serviceCode`);

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
  MODIFY `branchCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `businessCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `businesstypes`
--
ALTER TABLE `businesstypes`
  MODIFY `typeCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `business_owner`
--
ALTER TABLE `business_owner`
  MODIFY `ownerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `custom_package`
--
ALTER TABLE `custom_package`
  MODIFY `customCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `serviceCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
