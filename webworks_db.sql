-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 11:41 AM
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

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branchCode`, `businessCode`, `branchName`, `address`, `coordinates`, `branchImage`) VALUES
(32, 22, 'Mina Branch', 'Mina Iloilo Province', '10.93052940811921, 122.57529571652414', 0x6173736574732f75706c6f6164732f6272616e636865732f564746535f44726578656c5f48696c6c2d3134382d7765622e6a706567),
(33, 24, 'Lambunao', 'Brgy. Poblacion, Ilawod Lambunao Iloilo', '11.054889732037514, 122.47451036671974', 0x6173736574732f75706c6f6164732f6272616e636865732f564746535f44726578656c5f48696c6c2d3134382d7765622e6a706567);

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
(22, 28, 'Puga Funeral Home', 'In times of loss, finding solace in a compassionate and dedicated funeral home is paramount. At Puga Funeral, we understand the delicate nature of saying farewell to a loved one, and we strive to provide support and comfort when it\'s needed most.', 'Funeral Services', '', '', 'Brgy. Tolicuran', 'Iloilo City', 'Iloilo', '6', '330-39-13', '09831837281', 0x6173736574732f75706c6f6164732f3430303831383438355f3637383239373836343430393538355f333334383734323732383439303230313730375f6e2e6a7067, 0x6173736574732f75706c6f6164732f627573696e6573732f564746535f44726578656c5f48696c6c2d3134382d7765622e6a706567, 1),
(23, 28, 'Puga Photography Services', '', 'Photography', '', '', 'Tolicuran', 'Mina', 'Iloilo ', '6', '320-39-12', '0928372672', 0x6173736574732f75706c6f6164732f3430303831383438355f3637383239373836343430393538355f333334383734323732383439303230313730375f6e2e6a7067, 0x6173736574732f75706c6f6164732f627573696e6573732f564746535f44726578656c5f48696c6c2d3134382d7765622e6a706567, 1),
(24, 31, 'Bahay Kusina De Tangra', '', 'Catering', '20', '7th Street', 'Poblacion Ilawod', 'Lambunao', 'Iloilo', '6', '09452781051', '09452781023', 0x6173736574732f75706c6f6164732f494354203133392d2047726f757020436173652053747564792023332e706466, 0x6173736574732f75706c6f6164732f627573696e6573732f564746535f44726578656c5f48696c6c2d3134382d7765622e6a706567, 1);

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
(28, 'Jose ', 'Puga', '1985-10-21', 'bvrlisah@gmail.com', '462081', '09452781051', '', 'JosePuga', '$argon2i$v=19$m=65536,t=4,p=1$dlYzVWM3ZTB6WHlZMjRkWQ$uXqRlJ7A6I70lW8qQnKYcYYzWPRRsc4LhSqouUXAgDU', 'business owner', 1, '2023-12-18 01:51:48', '2023-12-18 01:51:48'),
(31, 'Ma Gloria', 'Hinolan', '1962-04-21', 'jirehsevein@gmail.com', '674098', '09452781051', '', 'magloria', '$argon2i$v=19$m=65536,t=4,p=1$QU9DTDM2RFBjSml3QUxWaw$2eEPbJIUBT/BeDWIV+6Oyy/h4D0V5xuo0IE1/1zLNHU', 'business owner', 1, '2024-01-05 04:05:52', '2024-01-05 04:05:52');

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
(103, 95, 'Clothes'),
(104, 95, 'Flowers'),
(105, 96, 'Clothes'),
(106, 97, 'Pork Menu'),
(107, 97, 'Chicken Menu');

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
(15, 'Jireh', 'Nieves', '2001-02-13', 'bvrlisah@gmail.com', 450980, '09452781051', '', 'Jireh', '$argon2i$v=19$m=65536,t=4,p=1$dnRva3NXSXZkMzRIeGZELw$psmL3JC0LIOnWT+8hezkEwc2QkQlXNoZTR0kfKTvE80', 'client', 1, '2023-12-17 16:55:20', '2023-12-17 16:55:20');

-- --------------------------------------------------------

--
-- Table structure for table `custom_category`
--

CREATE TABLE `custom_category` (
  `customCategoryCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `categoryName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_category`
--

INSERT INTO `custom_category` (`customCategoryCode`, `branchCode`, `categoryName`) VALUES
(5, 32, 'Flowers'),
(6, 32, 'Casket'),
(7, 33, 'Chicken Menu'),
(8, 33, 'Pork Menu');

-- --------------------------------------------------------

--
-- Table structure for table `custom_items`
--

CREATE TABLE `custom_items` (
  `itemCode` int(11) NOT NULL,
  `customCategoryCode` int(11) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `quantity` int(200) NOT NULL,
  `price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_items`
--

INSERT INTO `custom_items` (`itemCode`, `customCategoryCode`, `itemName`, `description`, `quantity`, `price`) VALUES
(5, 7, 'Buttered Chicken', 'masarap na buttered Chicken', 1, 190),
(6, 8, 'Crispy Pata', 'Crispy na pata', 1, 390),
(7, 8, 'Patatim', 'pata na tim', 1, 290);

-- --------------------------------------------------------

--
-- Table structure for table `custom_item_details`
--

CREATE TABLE `custom_item_details` (
  `detailsCode` int(11) NOT NULL,
  `itemCode` int(11) NOT NULL,
  `detailName` varchar(200) NOT NULL,
  `detailValue` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemCode` int(11) NOT NULL,
  `categoryCode` int(11) NOT NULL,
  `itemName` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `price` bigint(255) NOT NULL,
  `itemImage` longblob NOT NULL,
  `stocks` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemCode`, `categoryCode`, `itemName`, `description`, `quantity`, `unit`, `price`, `itemImage`, `stocks`) VALUES
(106, 106, 'Pork Teriyaki', 'w/ Sesame Seeds', 1, '', 5000, '', 0),
(107, 106, 'Pork Sisig', 'for 50 pax', 1, '', 5000, '', 0),
(108, 107, 'Chicken Curry', 'for 50 pax', 1, '', 4500, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_details`
--

CREATE TABLE `item_details` (
  `detailsCode` int(11) NOT NULL,
  `itemCode` int(11) NOT NULL,
  `detailName` varchar(200) NOT NULL,
  `detailValue` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `packCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `packName` varchar(50) NOT NULL,
  `packDesc` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`packCode`, `branchCode`, `packName`, `packDesc`) VALUES
(95, 32, 'Full Package', 'Full Package Description'),
(96, 32, 'Basic Package', 'Basic Package Description'),
(97, 33, 'Birthday Package', 'for 50 pax');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `packCode` int(11) NOT NULL,
  `sourceID` varchar(100) NOT NULL,
  `clientName` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobileNumber` int(100) NOT NULL,
  `amount` int(200) NOT NULL,
  `paymentDate` date DEFAULT current_timestamp(),
  `businessName` varchar(100) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherID` int(255) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `packCode` int(11) NOT NULL,
  `voucherCode` varchar(200) NOT NULL,
  `cond` varchar(100) NOT NULL,
  `min_spend` int(100) NOT NULL,
  `discountValue` int(100) NOT NULL,
  `discountType` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `redemptionStatus` tinyint(4) NOT NULL,
  `creationDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucherID`, `businessCode`, `branchCode`, `packCode`, `voucherCode`, `cond`, `min_spend`, `discountValue`, `discountType`, `startDate`, `endDate`, `redemptionStatus`, `creationDate`) VALUES
(221, 24, 33, 0, 'bahaykusina', 'percentage', 0, 200, 'amount', '2024-01-24', '2024-01-30', 0, '2024-01-05');

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
-- Indexes for table `custom_category`
--
ALTER TABLE `custom_category`
  ADD PRIMARY KEY (`customCategoryCode`),
  ADD KEY `branchCode` (`branchCode`);

--
-- Indexes for table `custom_items`
--
ALTER TABLE `custom_items`
  ADD PRIMARY KEY (`itemCode`),
  ADD KEY `customCategoryCode` (`customCategoryCode`);

--
-- Indexes for table `custom_item_details`
--
ALTER TABLE `custom_item_details`
  ADD PRIMARY KEY (`detailsCode`),
  ADD KEY `itemCode` (`itemCode`);

--
-- Indexes for table `custom_package`
--
ALTER TABLE `custom_package`
  ADD PRIMARY KEY (`customCode`),
  ADD KEY `clientID` (`clientID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemCode`),
  ADD KEY `categoryCode` (`categoryCode`);

--
-- Indexes for table `item_details`
--
ALTER TABLE `item_details`
  ADD PRIMARY KEY (`detailsCode`),
  ADD KEY `itemCode` (`itemCode`);

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
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherID`),
  ADD KEY `businessCode` (`businessCode`),
  ADD KEY `branchCode` (`branchCode`),
  ADD KEY `packCode` (`packCode`);

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
  MODIFY `branchCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `businessCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `businesstypes`
--
ALTER TABLE `businesstypes`
  MODIFY `typeCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `business_owner`
--
ALTER TABLE `business_owner`
  MODIFY `ownerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `custom_category`
--
ALTER TABLE `custom_category`
  MODIFY `customCategoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `custom_items`
--
ALTER TABLE `custom_items`
  MODIFY `itemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `custom_item_details`
--
ALTER TABLE `custom_item_details`
  MODIFY `detailsCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `custom_package`
--
ALTER TABLE `custom_package`
  MODIFY `customCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `item_details`
--
ALTER TABLE `item_details`
  MODIFY `detailsCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucherID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

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
-- Constraints for table `custom_category`
--
ALTER TABLE `custom_category`
  ADD CONSTRAINT `custom_category_ibfk_2` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);

--
-- Constraints for table `custom_items`
--
ALTER TABLE `custom_items`
  ADD CONSTRAINT `custom_items_ibfk_1` FOREIGN KEY (`customCategoryCode`) REFERENCES `custom_category` (`customCategoryCode`);

--
-- Constraints for table `custom_item_details`
--
ALTER TABLE `custom_item_details`
  ADD CONSTRAINT `custom_item_details_ibfk_1` FOREIGN KEY (`itemCode`) REFERENCES `custom_items` (`itemCode`);

--
-- Constraints for table `custom_package`
--
ALTER TABLE `custom_package`
  ADD CONSTRAINT `clientID` FOREIGN KEY (`clientID`) REFERENCES `client` (`clientID`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `categoryCode` FOREIGN KEY (`categoryCode`) REFERENCES `category` (`categoryCode`);

--
-- Constraints for table `item_details`
--
ALTER TABLE `item_details`
  ADD CONSTRAINT `itemCode` FOREIGN KEY (`itemCode`) REFERENCES `items` (`itemCode`);

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `branchCode` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);

--
-- Constraints for table `voucher`
--
ALTER TABLE `voucher`
  ADD CONSTRAINT `voucher_ibfk_1` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`),
  ADD CONSTRAINT `voucher_ibfk_2` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
