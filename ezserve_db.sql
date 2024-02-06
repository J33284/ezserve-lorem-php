-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2024 at 03:38 AM
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
-- Database: `ezserve_db`
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
(33, 24, 'Lambunao Branches', 'Brgy. Poblacion, Ilawod Lambunao Iloilo', '10.719399858726684, 122.56068437780053', 0x6173736574732f75706c6f6164732f6272616e636865732f747269616e676c652e706e67),
(34, 24, 'Mina Branches', '20, Hibao-an Iloilo', '10.932929218923022, 122.55964905023576', 0x6173736574732f75706c6f6164732f6272616e636865732f746f70706e672e636f6d2d676f6c642d676c69747465722d706e672d3135303378313030352e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `businessCode` int(11) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `busName` varchar(100) NOT NULL,
  `about` varchar(1000) NOT NULL,
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
(24, 31, 'Bahay Kusina De Tangra', 'Bahay Kusina De Tangra Catering & Eatery seamlessly blends the rich heritage of Tangra-style Filipino cuisine with a versatile business model that caters to diverse culinary needs. Our eatery, adorned with cultural nuances, provides a welcoming ambiance for patrons seeking an authentic dining experience. The menu boasts a tantalizing array of Tangra specialties, carefully curated to offer a fusion of bold flavors and traditional culinary techniques. From sizzling stir-fries to delectable dim su', 'Catering', '20', '7th Street', 'Poblacion Ilawod', 'Lambunao', 'Iloilo', '6', '09452781051', '09452781023', 0x6173736574732f75706c6f6164732f494354203133392d2047726f757020436173652053747564792023332e706466, 0x6173736574732f75706c6f6164732f627573696e6573732f527251384b446f2e77656270, 1);

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
  `repassword` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `profileImage` longblob NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_owner`
--

INSERT INTO `business_owner` (`ownerID`, `fname`, `lname`, `birthday`, `email`, `verification_code`, `number`, `ownerAddress`, `username`, `password`, `repassword`, `usertype`, `profileImage`, `status`, `created`, `updated`) VALUES
(28, 'Jose ', 'Puga', '1985-10-21', 'lalalaamb@gmail.com', '462081', '09452781051', '', 'JosePuga', '$argon2i$v=19$m=65536,t=4,p=1$dlYzVWM3ZTB6WHlZMjRkWQ$uXqRlJ7A6I70lW8qQnKYcYYzWPRRsc4LhSqouUXAgDU', '', 'business owner', '', 1, '2023-12-18 01:51:48', '2023-12-18 01:51:48'),
(31, 'Ma Gloria', 'Hinolan', '1962-04-21', 'magloria@gmail.com', '674098', '09452781051', '', 'magloria', '$argon2i$v=19$m=65536,t=4,p=1$QU9DTDM2RFBjSml3QUxWaw$2eEPbJIUBT/BeDWIV+6Oyy/h4D0V5xuo0IE1/1zLNHU', '', 'business owner', 0x6173736574732f75706c6f6164732f70726f66696c652f3432303139303633355f313633393331323735363539393133305f363532363538353830363837383230303335325f6e2e6a7067, 1, '2024-01-05 04:05:52', '2024-01-05 04:05:52'),
(42, 'ALISAH MAE', 'BOLIVAR', '2001-07-01', 'bvrlisah@gmail.com', '610792', '09452781051', '', 'Alisah12', '$argon2i$v=19$m=65536,t=4,p=1$NEJuLndIcUtrQi81OFRVRQ$aHSySuU/oGvmsxHGyijGN0jyGPetKvX5wl2BjOLx91k', '@123asdA', 'business owner', '', 1, '2024-01-23 07:01:42', '2024-01-23 07:01:42');

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
  `repassword` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `profileImage` longblob NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `fname`, `lname`, `birthday`, `email`, `verification_code`, `number`, `ownerAddress`, `username`, `password`, `repassword`, `usertype`, `profileImage`, `status`, `created`, `updated`) VALUES
(18, 'Vianney', 'Sobrevega', '2002-01-02', 'vianneysobrevega@gmail.com', 113308, '09452781051', 'pasil', 'vianney', '$argon2i$v=19$m=65536,t=4,p=1$bktGSURMZkFMRklkSWZ3eA$FGYsvzu3j5f7Qvtt3ZTs5PEk5crEQ3mELiGWu6sps2w', '', 'client', '', 1, '2024-01-08 14:52:35', '2024-01-08 14:52:35'),
(20, 'Alisah Mae', 'Bolivar', '2001-07-01', 'bvrlisa@gmail.com', 284725, '09452781051', '', 'alisahMae', '$argon2i$v=19$m=65536,t=4,p=1$UnZGVGRkVS9uQTdjd0dXaw$odR1DIjLN87DEas4ba/fqPKTy/9k05ahvQK01jIxQtI', '12345', 'client', '', 1, '2024-01-23 01:05:06', '2024-01-23 01:05:06'),
(33, 'Alisah', 'Bolivar', '2001-07-01', 'bvrlisah@gmail.com', 84770, '09564200614', '', 'Client', '$argon2i$v=19$m=65536,t=4,p=1$QmJZV1Q2ZWpzaHdkZVVTSA$KKnFD31AJWee/MJU4xsBWCKuS4ZguDglxFnIhZ31JEk', 'Alisah12345$', 'client', '', 1, '2024-01-30 05:32:27', '2024-01-30 05:32:27');

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
(23, 33, 'Pork Menu'),
(24, 33, 'Chicken Menu'),
(25, 33, 'Seafoods'),
(26, 33, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `custom_items`
--

CREATE TABLE `custom_items` (
  `itemCode` int(11) NOT NULL,
  `customCategoryCode` int(11) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` int(200) NOT NULL,
  `custom_itemImage` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_items`
--

INSERT INTO `custom_items` (`itemCode`, `customCategoryCode`, `itemName`, `description`, `price`, `custom_itemImage`) VALUES
(26, 23, 'Pork Afritada', '', 100, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f343338383832313136303833383131323475706c6f61645f313630383338313037353835302e706e67),
(27, 23, 'Pork Embutido', '', 20, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f34646434666161396338363061313135613661393239633137333733623665372e6a7067),
(28, 24, 'Chicken Curry', '', 50, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f5f66616e6172745f5f315f796561725f616e6e69766572736172795f62795f616b656d6f6e6f5f6466357462336e2d333530742e6a7067),
(29, 25, 'Shrimp', '', 79, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f66316638376566623162616538656630376162383437396465626664363837642e706e67),
(30, 26, 'Royal', '12 oz', 20, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f766c63736e61702d323032322d30382d30392d31376832306d3434733132352e706e67);

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemCode` int(11) NOT NULL,
  `packCode` int(11) NOT NULL,
  `itemName` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `price` bigint(255) NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `itemImage` varchar(255) NOT NULL,
  `userInput` varchar(20) NOT NULL,
  `stocks` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemCode`, `packCode`, `itemName`, `description`, `quantity`, `unit`, `price`, `imageName`, `itemImage`, `userInput`, `stocks`) VALUES
(354, 275, '3 Main Dish', '3 main dish of your choice (see menu)', 0, '', 0, '', 'assets/uploads/packages/420045990_917586769805131_1358493736596732913_n.jpg', 'enable', 0),
(355, 275, '2 Side Dish', '2 side dish of your choice (see menu)', 0, '', 0, '', 'assets/uploads/packages/420038104_1413551699238034_7737994293452447082_n.jpg', 'enable', 0),
(356, 275, 'Softdrinks', '1L of softdrinks of your choice', 0, '', 0, '', 'assets/uploads/packages/softdrinks.jpg', 'enable', 0),
(357, 275, 'Utensils', 'Includes spoon, fork, serving spoon, glasses', 0, '', 0, '', 'assets/uploads/packages/cutlery.jpg', 'enable', 0),
(363, 286, 'Coffin', 'Solid Mahogany', 1, 'box', 100000, '', 'assets/uploads/packages/5.Mahogany.jpg', 'enable', 0),
(364, 286, 'Flowers', '', 1, 'bundle', 200, '', 'assets/uploads/packages/305398834_446716360809741_7457097433161130092_n.jpg', 'enable', 0),
(367, 289, '3 Main Dishes', '3 Main dishes of your choice', 0, '', 0, '', 'assets/uploads/packages/420045990_917586769805131_1358493736596732913_n.jpg', 'enable', 0),
(368, 289, '1 side dish', '1 side dish of your choice', 0, '', 0, '', 'assets/uploads/packages/420038104_1413551699238034_7737994293452447082_n.jpg', 'enable', 0),
(369, 289, 'Rice', '', 0, '', 0, '', 'assets/uploads/packages/rice.jpg', 'enable', 0),
(370, 289, 'Salad', '', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(371, 289, 'SoftDrinks', '', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(372, 289, '', '', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(373, 290, '4 Main Dishes', '4 main dishes of your choice', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(374, 290, '2 Side Dish', '2 side dish of your choice', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(375, 290, 'Rice', '', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(376, 290, 'Salad', '', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0),
(377, 290, 'Softdrinks', 'Softdrinks of your choice', 0, '', 0, '', 'assets/uploads/packages/', 'enable', 0);

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
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `orderListID` int(11) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `quantity` int(255) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `price` bigint(255) NOT NULL,
  `custom` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `packCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `packName` varchar(50) NOT NULL,
  `packDesc` varchar(300) NOT NULL,
  `pricingType` varchar(50) NOT NULL,
  `amount` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`packCode`, `branchCode`, `packName`, `packDesc`, `pricingType`, `amount`) VALUES
(275, 33, 'Package 1', '*includes food waiter/ attendant *regular setup *utensils', 'per pax', 320),
(286, 32, 'Funeral Package', 'Basic Funeral Package', 'per item', 0),
(289, 33, 'Package 2', '*includes food waiter/ attendant *regular setup *utensils', 'per pax', 350),
(290, 33, 'Package 3', '*includes food waiter/ attendant *regular setup *utensils', 'per pax', 400);

-- --------------------------------------------------------

--
-- Table structure for table `transact`
--

CREATE TABLE `transact` (
  `transID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `busName` varchar(255) NOT NULL,
  `branchName` varchar(255) NOT NULL,
  `packName` varchar(255) NOT NULL,
  `transCode` varchar(100) NOT NULL,
  `clientName` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobileNumber` bigint(255) NOT NULL,
  `totalAmount` int(200) NOT NULL,
  `paymentDate` date DEFAULT current_timestamp(),
  `itemList` varchar(10000) NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `pickupDate` varchar(100) NOT NULL,
  `deliveryDate` varchar(100) NOT NULL,
  `deliveryAddress` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transact`
--

INSERT INTO `transact` (`transID`, `clientID`, `businessCode`, `branchCode`, `busName`, `branchName`, `packName`, `transCode`, `clientName`, `email`, `mobileNumber`, `totalAmount`, `paymentDate`, `itemList`, `paymentMethod`, `pickupDate`, `deliveryDate`, `deliveryAddress`, `status`) VALUES
(130, 33, 24, 33, 'Bahay Kusina De Tangra', 'Lambunao Branches', 'Package 1', 'pay_sg3u8XQBpfHXynM5KCCCUjzu', 'Alisah Bolivar', 'bvrlisah@gmail.com', 9564200614, 320, '2024-02-05', '[\"3 Main Dish\", \"2 Side Dish\", \"Softdrinks\", \"Utensils\"]', 'gcash', '2024-03-01', '', '', 'paid'),
(131, 33, 24, 33, 'Bahay Kusina De Tangra', 'Lambunao Branches', 'Package 1', 'pay_sg3u8XQBpfHXynM5KCCCUjzu', 'Alisah Bolivar', 'bvrlisah@gmail.com', 9564200614, 320, '2024-02-05', '[\"3 Main Dish\", \"2 Side Dish\", \"Softdrinks\", \"Utensils\"]', 'gcash', '2024-03-01', '', '', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherID` int(255) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `packCode` int(11) NOT NULL,
  `voucherName` varchar(200) NOT NULL,
  `voucherCode` varchar(200) NOT NULL,
  `voucherType` varchar(100) NOT NULL,
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

INSERT INTO `voucher` (`voucherID`, `ownerID`, `businessCode`, `branchCode`, `packCode`, `voucherName`, `voucherCode`, `voucherType`, `min_spend`, `discountValue`, `discountType`, `startDate`, `endDate`, `redemptionStatus`, `creationDate`) VALUES
(243, 31, 24, 33, 0, '', 'Voucher', 'Gift Card', 0, 200, 'amount', '2024-02-01', '2024-03-08', 0, '2024-02-02'),
(244, 31, 24, 33, 275, '', 'Voucher 2', 'Specific Package', 0, 20, 'percentage', '2024-02-01', '2024-03-08', 0, '2024-02-02'),
(245, 31, 24, 33, 0, '', 'Voucher 3', 'Minimum Spend', 200, 200, 'amount', '2024-02-02', '2024-03-09', 0, '2024-02-02');

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
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemCode`),
  ADD KEY `packCode` (`packCode`);

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
-- Indexes for table `transact`
--
ALTER TABLE `transact`
  ADD PRIMARY KEY (`transID`),
  ADD KEY `client` (`clientID`),
  ADD KEY `businessCode` (`businessCode`),
  ADD KEY `branchCode` (`branchCode`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherID`),
  ADD KEY `businessCode` (`businessCode`),
  ADD KEY `branchCode` (`branchCode`),
  ADD KEY `packCode` (`packCode`),
  ADD KEY `ownerID` (`ownerID`);

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
  MODIFY `branchCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `ownerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `custom_category`
--
ALTER TABLE `custom_category`
  MODIFY `customCategoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `custom_items`
--
ALTER TABLE `custom_items`
  MODIFY `itemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `custom_item_details`
--
ALTER TABLE `custom_item_details`
  MODIFY `detailsCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `item_details`
--
ALTER TABLE `item_details`
  MODIFY `detailsCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `transact`
--
ALTER TABLE `transact`
  MODIFY `transID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucherID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

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
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`packCode`) REFERENCES `package` (`packCode`);

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
-- Constraints for table `transact`
--
ALTER TABLE `transact`
  ADD CONSTRAINT `transact_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `client` (`clientID`),
  ADD CONSTRAINT `transact_ibfk_2` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`),
  ADD CONSTRAINT `transact_ibfk_3` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);

--
-- Constraints for table `voucher`
--
ALTER TABLE `voucher`
  ADD CONSTRAINT `voucher_ibfk_1` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`),
  ADD CONSTRAINT `voucher_ibfk_2` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`),
  ADD CONSTRAINT `voucher_ibfk_3` FOREIGN KEY (`ownerID`) REFERENCES `business_owner` (`ownerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
