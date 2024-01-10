-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 08:11 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salairinch`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', 'admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `email`, `mobile`, `subject`, `status`, `time`) VALUES
(1, 'Raj Vaibhav Jain', 'mayurarora8@gmail.com', '8949501313', 'Kitchen Plumbing', '1', '2023-03-16 14:29:04'),
(2, 'Raj Vaibhav Jain', 'mayurarora8@gmail.com', '8888888888', 'Kitchen Plumbing', '1', '2023-03-16 14:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `time` varchar(20) NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `description`, `image`, `status`, `time`) VALUES
(41, 'Home Appliances', 'home appliances', 'category/image_2023_03_23_21_07_05.png', 1, '2023-03-23 11:32:46'),
(42, 'Mobile & Computer', 'mobile & computer', 'category/image_2023_03_23_21_08_14.jpeg', 1, '2023-03-23 11:37:23'),
(44, 'Painter & Interior', 'painter & interior', 'category/image_2023_03_23_21_08_33.jpeg', 1, '2023-03-23 11:41:35'),
(45, 'Plumber', 'plumber', 'category/image_2023_03_23_20_55_36.jpeg', 0, '2023-03-23 11:43:56'),
(46, 'Carpenter', 'carpenter', 'category/image_2023_03_23_20_55_55.jpeg', 0, '2023-03-23 11:49:23'),
(47, 'Online Services', 'online services', 'category/image_2023_03_23_11_52_23_8178.octet-stream', 0, '2023-03-23 11:52:23'),
(48, 'Event Planner', 'event planner', 'category/image_2023_03_23_20_56_06.jpeg', 0, '2023-03-23 11:55:02'),
(49, 'Beauty', 'beauty', 'category/image_2023_03_23_20_56_17.jpeg', 0, '2023-03-23 11:57:17'),
(50, 'Medical', 'medical', 'category/image_2023_03_23_20_56_26.jpeg', 0, '2023-03-23 11:59:23'),
(51, 'Transport', 'transport', 'category/image_2023_03_23_20_56_39.jpeg', 0, '2023-03-23 12:01:49'),
(52, 'Vedic', 'vedic', 'category/image_2023_03_23_20_56_51.jpeg', 0, '2023-03-23 12:03:55'),
(53, 'Legal Services', 'legal services', 'category/image_2023_03_23_20_56_56.jpeg', 0, '2023-03-23 12:06:36'),
(54, 'Tax', 'tax', 'category/image_2023_03_23_20_57_03.jpeg', 0, '2023-03-23 12:08:11'),
(55, 'Packers and Movers', 'packers and movers', 'category/image_2023_03_23_20_57_09.jpeg', 0, '2023-03-23 12:10:59'),
(56, 'Rent And Lease', 'rent and lease', 'category/image_2023_03_23_20_57_24.jpeg', 0, '2023-03-23 12:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `name`, `email`, `mobile`, `message`, `status`, `time`) VALUES
(1, 'Ayushi bohra', 'rajvaibhavjain@gmail.com', '8949501313', 'Hello', '1', '2023-03-04 22:09:16'),
(2, 'Raj Vaibhav Jain', 'rajvaibhavjain@gmail.com', '8888888888', 'Hello', '1', '2023-03-16 14:15:45'),
(3, 'Raj Vaibhav Jain', 'mayurarora8@gmail.com', '1234567890', 'adsdada', '1', '2023-03-16 14:20:29'),
(4, 'test', 'test@gmai.com', '6767676767', 'test msg', '1', '2023-03-31 23:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `subcategory`, `name`, `email`, `mobile`, `address`, `time`) VALUES
(1, '1', '2', '3', 'vfvfvfvff', '4', '23456789');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `time` varchar(20) NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `slug`, `value`, `status`, `time`) VALUES
(1, 'email', 'salairinchservices@gmail.com', 1, '2023-03-06 14:40:57'),
(2, 'mobile', '7808480553', 1, '2023-03-06 14:41:18'),
(3, 'address', 'Gandhi path,ashok cinema road,<br>saharsa-852201', 1, '2023-03-06 14:41:18');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `time` varchar(20) NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `categoryid`, `title`, `description`, `image`, `status`, `time`) VALUES
(30, 41, 'TV', 'We are providing tv  service at reasonable price. just  you can book your any tv repair service at schedule time ', 'subcategory/image_2023_03_24_01_03_37.jpeg', 1, '2023-03-23 12:38:40'),
(31, 41, 'AC', 'ac', 'subcategory/image_2023_03_24_01_04_39.jpeg', 1, '2023-03-23 13:48:26'),
(32, 41, 'Refrigerator', 'refrigerator', 'subcategory/image_2023_03_24_01_04_22.jpeg', 1, '2023-03-23 13:50:00'),
(33, 41, 'Washing Machine', 'washing machine', 'subcategory/image_2023_03_24_01_04_54.jpeg', 1, '2023-03-23 13:51:29'),
(34, 41, 'Geyser', 'geyser', 'subcategory/image_2023_03_24_01_05_10.jpeg', 1, '2023-03-23 13:52:48'),
(35, 41, 'Mixer Grinder', 'mixer grinder', 'subcategory/image_2023_03_24_01_05_25.jpeg', 1, '2023-03-23 13:54:05'),
(36, 42, 'Mobile Phone Repair', 'mobile phone repair', 'subcategory/image_2023_03_24_01_07_58.jpeg', 1, '2023-03-23 14:06:33'),
(37, 42, 'Computer Repair ', 'computer repair ', 'subcategory/image_2023_03_24_01_08_19.jpeg', 1, '2023-03-23 14:08:55'),
(38, 42, 'Laptop Repair', 'laptop repair', 'subcategory/image_2023_03_24_01_08_38.jpeg', 1, '2023-03-23 14:11:00'),
(39, 42, 'Projector Repair', 'projector repair', 'subcategory/image_2023_03_24_01_08_59.jpeg', 1, '2023-03-23 14:12:24'),
(40, 44, 'Paint', 'paint', 'subcategory/image_2023_03_24_01_10_29.jpeg', 1, '2023-03-23 14:16:00'),
(41, 44, 'Sealing', 'sealing', 'subcategory/image_2023_03_23_21_47_47.jpeg', 1, '2023-03-23 14:23:33'),
(42, 44, 'Interior', 'interior', 'subcategory/image_2023_03_24_01_11_06.jpeg', 1, '2023-03-23 14:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `otp` varchar(20) NOT NULL,
  `otp_expiry` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`id`, `name`, `email`, `mobile`, `otp`, `otp_expiry`, `time`) VALUES
(1, 'iqbal', 'iqbal@email.com', '9191919191', '893764', 'ss', 'current_timestamp()'),
(7, '', '', '9789797979', '261871', '2023-03-15 10:53:46', '2023-03-15 10:48:46'),
(8, '', '', '8949501313', '406737', '2023-04-01 11:21:43', '2023-04-01 11:16:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
