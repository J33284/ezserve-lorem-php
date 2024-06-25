-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 09:34 AM
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
(1, 'bvrlisah@gmail.com', 'admin', '$argon2i$v=19$m=65536,t=4,p=1$R3N2T1VGVVR4MmpOUU1QcA$U+v9XIMxGB0xe5PW2Pqd2ZGo7wl8oBw+od03R30mGgA', 'admin', 1, '2023-10-26 21:01:34', '2023-10-26 21:01:34');

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
(33, 24, 'Lambunao Branch', 'Brgy. Poblacion, Ilawod Lambunao Iloilo', '10.719399858726684, 122.56068437780053', 0x6173736574732f75706c6f6164732f6272616e636865732f696c6f696c6f2d6c616d62756e616f2d706c617a612e6a7067),
(34, 24, 'Mina Branch', '20, Hibao-an Iloilo', '10.932929218923022, 122.55964905023576', 0x6173736574732f75706c6f6164732f6272616e636865732f4e65775f6c7563656e615f746f776e5f68616c6c2e4a5047);

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
  `business_permit` longblob NOT NULL,
  `sanitary` longblob NOT NULL,
  `tax` longblob NOT NULL,
  `busImage` longblob NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`businessCode`, `ownerID`, `busName`, `about`, `busType`, `house_building`, `street`, `barangay`, `city_municipality`, `province`, `region`, `phone`, `mobile`, `business_permit`, `sanitary`, `tax`, `busImage`, `status`) VALUES
(22, 28, 'Puga Funeral Home', 'In times of loss, finding solace in a compassionate and dedicated funeral home is paramount. At Puga Funeral, we understand the delicate nature of saying farewell to a loved one, and we strive to provide support and comfort when it\'s needed most.', 'Funeral Services', '', '', 'Brgy. Tolicuran', 'Iloilo City', 'Iloilo', '6', '330-39-13', '09831837281', 0x6173736574732f75706c6f6164732f3430303831383438355f3637383239373836343430393538355f333334383734323732383439303230313730375f6e2e6a7067, '', '', 0x6173736574732f75706c6f6164732f627573696e6573732f564746535f44726578656c5f48696c6c2d3134382d7765622e6a706567, 1),
(24, 31, 'Bahay Kusina De Tangra', 'Bahay Kusina De Tangra Catering & Eatery seamlessly blends the rich heritage of Tangra-style Filipino cuisine with a versatile business model that caters to diverse culinary needs. Our eatery, adorned with cultural nuances, provides a welcoming ambiance for patrons seeking an authentic dining experience. The menu boasts a tantalizing array of Tangra specialties, carefully curated to offer a fusion of bold flavors and traditional culinary techniques. From sizzling stir-fries to delectable dim su', 'Catering', '20', '7th Street', 'Poblacion Ilawod', 'Lambunao', 'Iloilo', '6', '09452781051', '09452781023', 0x6173736574732f75706c6f6164732f494354203133392d2047726f757020436173652053747564792023332e706466, '', '', 0x6173736574732f75706c6f6164732f627573696e6573732f527251384b446f2e77656270, 1),
(49, 28, 'Funeral', '', 'Funeral Services', '20', '', 'Tolarucan', 'Mina', 'Iloilo', '6', '3202917', '09637283627', 0x6173736574732f75706c6f6164732f627573696e6573735f7065726d69742e6a7067, 0x6173736574732f75706c6f6164732f7461785f7065726d69742e6a7067, 0x6173736574732f75706c6f6164732f73616e69746172795f7065726d69742e6a7067, '', 0);

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
(31, 'Jose', 'Cruz', '1962-04-21', 'bvrlisah@gmail.com', '674098', '09452781051', '', 'JoseCruz', '$argon2i$v=19$m=65536,t=4,p=1$YmFZeFR2MEVkSGZISDliRw$V1oQeymaudv39k35OzPNEjLVTTQCJHodnIpHsTF15wQ', '', 'business owner', 0x6173736574732f75706c6f6164732f70726f66696c652f6a6f73652072697a7a2e61766966, 1, '2024-01-05 04:05:52', '2024-01-05 04:05:52'),
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
(33, 'Alisah', 'Bolivar', '2001-07-01', 'bvrlisah@gmail.com', 84770, '09564200614', '', 'Client', '$argon2i$v=19$m=65536,t=4,p=1$QmJZV1Q2ZWpzaHdkZVVTSA$KKnFD31AJWee/MJU4xsBWCKuS4ZguDglxFnIhZ31JEk', 'Alisah12345$', 'client', 0x6173736574732f75706c6f6164732f70726f66696c652f636c69656e742069636f6e2e706e67, 1, '2024-01-30 05:32:27', '2024-01-30 05:32:27'),
(39, 'Emma', 'Bolivar', '1999-01-23', 'officialwebworks@gmail.com', 146428, '09203633104', '', 'emma12345', '$argon2i$v=19$m=65536,t=4,p=1$U3hPRE53WkRFV2VzbTNXZg$GoQKfGmvxR5KpDl7KHNVes71hHtPUWfz0QBN1QSOAvE', 'Emma12345!', 'client', '', 1, '2024-06-23 11:27:10', '2024-06-23 11:27:10');

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
(30, 33, 'Pork Menu'),
(31, 33, 'Chicken Menu'),
(32, 33, 'Beef Menu'),
(33, 33, 'Fish Menu'),
(34, 33, 'Sofdrinks'),
(35, 33, 'Vegetable Dishes'),
(36, 33, 'Fried Side Dish'),
(37, 32, 'Wooden Casket');

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
  `custom_itemImage` longblob NOT NULL,
  `availability` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_items`
--

INSERT INTO `custom_items` (`itemCode`, `customCategoryCode`, `itemName`, `description`, `price`, `custom_itemImage`, `availability`) VALUES
(37, 30, 'Pork Menudo', '', 55, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(38, 30, 'Pork Afritada', '', 50, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(39, 30, 'Pork Sweet and Sour', '', 60, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(40, 30, 'Crispy Pata', '', 90, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(41, 30, 'Pork Adobo', '', 50, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(42, 31, 'Chicken Lollipop', '', 40, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(43, 31, 'Buttered Chicken', '', 45, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(44, 31, 'Fried Chicken', '', 45, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(45, 32, 'Beef Frita', '', 80, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(46, 32, 'Kare-Kare', '', 60, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(47, 32, 'Beef Nilaga', '', 45, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(48, 33, 'Fried Fish', '', 40, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(49, 33, 'Fish Sinigang', '', 40, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(50, 34, 'Royal', '12oz', 20, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(51, 34, 'Sprite', '12oz', 20, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(52, 34, 'Coke', '1 liter', 40, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(53, 35, 'Pinakbet', '', 50, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(54, 35, 'Ginisang Ampalaya', '', 60, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(55, 35, 'Ensaladang Talong', '', 45, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(56, 36, 'Lumpiang Shanghai', '', 60, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(57, 36, 'Fried Tofu', '', 50, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(58, 36, 'Dynamite Lumpia', '', 45, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f, 0),
(59, 37, 'Mahogany ', 'Length: 72 inches to 84 inches (183 cm to 213 cm).\r\nWidth: 22 inches to 28 inches (56 cm to 71 cm).', 100000, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f57696e6463726573745f5f536f6c69645f353537656263343564353566342e6a7067, 0),
(60, 37, 'Oak', 'Length: 72 inches to 84 inches (183 cm to 213 cm).\r\nWidth: 22 inches to 28 inches (56 cm to 71 cm).', 100000, 0x6173736574732f75706c6f6164732f637573746f6d2d7061636b616765732f6f616b2e77656270, 0);

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
  `optionLimit` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemCode`, `packCode`, `itemName`, `description`, `quantity`, `unit`, `price`, `imageName`, `itemImage`, `userInput`, `optionLimit`) VALUES
(354, 275, '3 Main Dish', '3 main dish of your choice', 0, '', 0, '', 'assets/uploads/packages/420045990_917586769805131_1358493736596732913_n.jpg', 'enable', 3),
(355, 275, '2 Side Dish', '2 side dish of your choice', 0, '', 0, '', 'assets/uploads/packages/420038104_1413551699238034_7737994293452447082_n.jpg', 'enable', 2),
(356, 275, 'Softdrinks', '1L of softdrinks of your choice', 0, '', 0, '', 'assets/uploads/packages/softdrinks.jpg', 'enable', 1),
(357, 275, 'Utensils', 'Includes spoon, fork, serving spoon, glasses', 0, '', 0, '', 'assets/uploads/packages/cutlery.jpg', 'disable', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_option`
--

CREATE TABLE `item_option` (
  `optionCode` int(11) NOT NULL,
  `itemCode` int(11) NOT NULL,
  `customCategoryCode` int(11) NOT NULL,
  `optionName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_option`
--

INSERT INTO `item_option` (`optionCode`, `itemCode`, `customCategoryCode`, `optionName`) VALUES
(68, 354, 30, 'Pork Menu'),
(69, 354, 33, 'Fish Menu'),
(70, 354, 31, 'Chicken Menu'),
(75, 356, 34, 'Sofdrinks'),
(76, 355, 35, 'Vegetable Dish'),
(77, 355, 36, 'Fried Side Dish');

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `orderListID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `transID` int(11) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `quantity` int(255) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `price` bigint(255) NOT NULL,
  `variation` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`orderListID`, `clientID`, `businessCode`, `transID`, `itemName`, `description`, `quantity`, `unit`, `price`, `variation`) VALUES
(15, 33, 24, 148, '3 Main Dish', '3 main dish of your choice', 0, '', 0, 'Pork Menudo, Pork Afritada, Pork Sweet and Sour'),
(16, 33, 24, 148, '2 Side Dish', '2 side dish of your choice', 0, '', 0, 'Pinakbet, Ginisang Ampalaya'),
(17, 33, 24, 148, 'Softdrinks', '1L of softdrinks of your choice', 0, '', 0, 'Sprite'),
(18, 33, 24, 148, 'Utensils', 'Includes spoon, fork, serving spoon, glasses', 0, '', 0, ''),
(19, 33, 24, 149, '3 Main Dish', '3 main dish of your choice', 0, '', 0, 'Pork Afritada, Pork Sweet and Sour, Pork Adobo'),
(20, 33, 24, 149, '2 Side Dish', '2 side dish of your choice', 0, '', 0, 'Pinakbet, Ensaladang Talong'),
(21, 33, 24, 149, 'Softdrinks', '1L of softdrinks of your choice', 0, '', 0, 'Royal'),
(22, 33, 24, 149, 'Utensils', 'Includes spoon, fork, serving spoon, glasses', 0, '', 0, ''),
(23, 33, 24, 150, '3 Main Dish', '3 main dish of your choice', 0, '', 0, 'Pork Menudo, Crispy Pata, Fried Fish'),
(24, 33, 24, 150, '2 Side Dish', '2 side dish of your choice', 0, '', 0, 'Pinakbet, Lumpiang Shanghai'),
(25, 33, 24, 150, 'Softdrinks', '1L of softdrinks of your choice', 0, '', 0, 'Royal'),
(26, 33, 24, 150, 'Utensils', 'Includes spoon, fork, serving spoon, glasses', 0, '', 0, ''),
(27, 33, 24, 151, '3 Main Dish', '3 main dish of your choice', 0, '', 0, 'Pork Menudo, Crispy Pata, Fried Fish'),
(28, 33, 24, 151, '2 Side Dish', '2 side dish of your choice', 0, '', 0, 'Pinakbet, Lumpiang Shanghai'),
(29, 33, 24, 151, 'Softdrinks', '1L of softdrinks of your choice', 0, '', 0, 'Royal'),
(30, 33, 24, 151, 'Utensils', 'Includes spoon, fork, serving spoon, glasses', 0, '', 0, '');

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
(275, 33, 'Bahay Kusina(Basic Package)', '*includes food waiter/ attendant *regular setup *utensils', 'per pax', 320);

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE `permits` (
  `permitID` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `permitType` varchar(100) NOT NULL,
  `permitFile` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permits`
--

INSERT INTO `permits` (`permitID`, `businessCode`, `permitType`, `permitFile`) VALUES
(2, 49, 'BIR', 0x6173736574732f75706c6f6164732f7065726d6974732f7461785f7065726d69742e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `businessCode` int(11) NOT NULL,
  `branchCode` int(11) NOT NULL,
  `busName` varchar(255) NOT NULL,
  `branchName` varchar(255) NOT NULL,
  `packName` varchar(255) NOT NULL,
  `transNo` varchar(100) NOT NULL,
  `clientName` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobileNumber` bigint(255) NOT NULL,
  `totalAmount` int(200) NOT NULL,
  `paymentDate` date DEFAULT current_timestamp(),
  `paymentMethod` varchar(50) NOT NULL,
  `pickupDate` varchar(100) NOT NULL,
  `deliveryDate` datetime NOT NULL,
  `deliveryAddress` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transID`, `clientID`, `businessCode`, `branchCode`, `busName`, `branchName`, `packName`, `transNo`, `clientName`, `email`, `mobileNumber`, `totalAmount`, `paymentDate`, `paymentMethod`, `pickupDate`, `deliveryDate`, `deliveryAddress`, `status`) VALUES
(148, 33, 24, 33, 'Bahay Kusina De Tangra', 'Lambunao Branch', 'Package 1', 'EzServe_16949267915461166920', 'Alisah Bolivar', 'bvrlisah@gmail.com', 9564200614, 134, '2024-04-18', 'On-site payment', '2024-04-20', '0000-00-00 00:00:00', '', 'paid'),
(149, 33, 24, 33, 'Bahay Kusina De Tangra', 'Lambunao Branch', 'Bahay Kusina(Basic Package)', 'EzServe_59940062314607052806', 'Alisah Bolivar', 'bvrlisah@gmail.com', 9564200614, 1820, '2024-04-26', 'On-site payment', '2024-05-03', '0000-00-00 00:00:00', '', 'unpaid'),
(150, 33, 24, 33, 'Bahay Kusina De Tangra', 'Lambunao Branch', 'Bahay Kusina(Basic Package)', 'EzServe_23413268571245122387', 'Alisah Bolivar', 'bvrlisah@gmail.com', 9564200614, 0, '2024-06-03', 'On-site payment', '2024-06-26', '0000-00-00 00:00:00', '', 'unpaid'),
(151, 33, 24, 33, 'Bahay Kusina De Tangra', 'Lambunao Branch', 'Bahay Kusina(Basic Package)', 'EzServe_16311668638345880987', 'Alisah Bolivar', 'bvrlisah@gmail.com', 9564200614, 0, '2024-06-03', 'On-site payment', '', '2024-06-03 09:20:00', 'Javellana Street, San Pedro, Jaro, Iloilo City, Western Visayas, 5000, Philippines', 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherID` int(255) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `businessCode` int(11) DEFAULT NULL,
  `branchCode` int(11) DEFAULT NULL,
  `packCode` int(11) NOT NULL,
  `voucherCode` varchar(200) NOT NULL,
  `voucherType` varchar(100) NOT NULL,
  `min_spend` int(100) NOT NULL,
  `discountValue` int(100) NOT NULL,
  `discountType` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `creationDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucherID`, `ownerID`, `businessCode`, `branchCode`, `packCode`, `voucherCode`, `voucherType`, `min_spend`, `discountValue`, `discountType`, `startDate`, `endDate`, `creationDate`) VALUES
(292, 31, 24, 33, 0, 'VZIMDEUNI0W', 'Gift Card', 0, 100, 'amount', '2024-04-16', '2024-05-11', '2024-04-16'),
(299, 31, 24, 33, 0, 'XM3BU3YDUU', 'Gift Card', 0, 58, 'percentage', '2024-04-16', '2024-05-11', '2024-04-16'),
(301, 31, NULL, NULL, 0, 'ZT5S7BIE91', 'Minimum Spend', 200, 2, 'percentage', '2024-04-16', '2024-05-11', '2024-04-16');

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
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemCode`),
  ADD KEY `packCode` (`packCode`);

--
-- Indexes for table `item_option`
--
ALTER TABLE `item_option`
  ADD PRIMARY KEY (`optionCode`),
  ADD KEY `customCategoryCode` (`customCategoryCode`),
  ADD KEY `itemCode` (`itemCode`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`orderListID`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`packCode`),
  ADD KEY `branchCode` (`branchCode`);

--
-- Indexes for table `permits`
--
ALTER TABLE `permits`
  ADD PRIMARY KEY (`permitID`),
  ADD KEY `businessCode` (`businessCode`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transID`),
  ADD KEY `client` (`clientID`),
  ADD KEY `businessCode` (`businessCode`),
  ADD KEY `branchCode` (`branchCode`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherID`),
  ADD UNIQUE KEY `voucherCode` (`voucherCode`),
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
  MODIFY `businessCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `businesstypes`
--
ALTER TABLE `businesstypes`
  MODIFY `typeCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `business_owner`
--
ALTER TABLE `business_owner`
  MODIFY `ownerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `custom_category`
--
ALTER TABLE `custom_category`
  MODIFY `customCategoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `custom_items`
--
ALTER TABLE `custom_items`
  MODIFY `itemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `item_option`
--
ALTER TABLE `item_option`
  MODIFY `optionCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `orderListID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `permits`
--
ALTER TABLE `permits`
  MODIFY `permitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucherID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

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
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`packCode`) REFERENCES `package` (`packCode`);

--
-- Constraints for table `item_option`
--
ALTER TABLE `item_option`
  ADD CONSTRAINT `item_option_ibfk_2` FOREIGN KEY (`itemCode`) REFERENCES `items` (`itemCode`);

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `branchCode` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);

--
-- Constraints for table `permits`
--
ALTER TABLE `permits`
  ADD CONSTRAINT `permits_ibfk_1` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `client` (`clientID`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`businessCode`) REFERENCES `business` (`businessCode`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`branchCode`) REFERENCES `branches` (`branchCode`);

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
