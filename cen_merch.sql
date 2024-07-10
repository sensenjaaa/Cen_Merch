-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2023 at 09:31 AM
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
-- Database: `cen merch`
--
CREATE DATABASE IF NOT EXISTS `cen merch` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cen merch`;

-- --------------------------------------------------------

--
-- Table structure for table `add to cart`
--

CREATE TABLE `add to cart` (
  `cartId` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `merch_id` int(11) NOT NULL,
  `merch_name` varchar(40) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `size` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add to cart`
--

INSERT INTO `add to cart` (`cartId`, `student_id`, `merch_id`, `merch_name`, `order_amount`, `price`, `total_price`, `size`) VALUES
(130, 12345679, 3, 'SHIRT3', 1, 400, 400, 'N/A'),
(131, 12345679, 6, 'TOTEBAG1', 2, 300, 600, 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(2, 'usera', '$2y$10$Jsqo7Da.TeP2nWkcpz8UgeFgCMzX5mwG3lG6RgyXGKXWRlDTee9l.'),
(3, 'usera', '$2y$10$3t3Yn/u6HS9GYlMV1mZQUuwd43WRRFBhsUu8k7IlmQDUpMeeW9D9a'),
(5, 'usera', '$2y$10$ygZoKccNzxtHzlycxPqyROQNAHfugMUE7NgTqSJWvfRkOzJaJAeqC');

-- --------------------------------------------------------

--
-- Table structure for table `customer's information`
--

CREATE TABLE `customer's information` (
  `student_id` int(10) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `middle_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `school_email` varchar(40) NOT NULL,
  `street_address` varchar(40) NOT NULL,
  `baranggay_address` varchar(40) NOT NULL,
  `city_address` varchar(40) NOT NULL,
  `province_address` varchar(40) NOT NULL,
  `zip_code` int(4) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer's information`
--

INSERT INTO `customer's information` (`student_id`, `first_name`, `middle_name`, `last_name`, `school_email`, `street_address`, `baranggay_address`, `city_address`, `province_address`, `zip_code`, `contact_no`, `password`) VALUES
(12345677, 'Alyssa', 'Pitero', 'Merjilla', 'ajpmerjilla@slsu.edu.ph', 'Santa', 'Sto. Cristo', 'Sariaya', 'Quezon', 4323, 2147483647, '$2y$10$pXJNvGxgFz0OgLcyIBKYROxd1X2iMNvabxKDzd1jk1G7M7yY6PaUm'),
(12345678, 'Alyssa', 'Pitero', 'Merjilla', 'ajpmerjilla@slsu.edu.ph', 'Santa', 'Sto. Cristo', 'Sariaya', 'Quezon', 4323, 2147483647, '$2y$10$iQEiW8lNfEYkC8uE9V3BDe5kBIcdWAkgkCH0kbQZEcEK0jymrNLg2'),
(12345679, 'Alyssa', 'Pitero', 'Merjilla', 'ajpmerjilla@slsu.edu.ph', 'Santa', 'Sto. Cristo Sa', 'Sariaya', 'Quezon', 4323, 2147483647, '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `merchandise details`
--

CREATE TABLE `merchandise details` (
  `merch_id` int(10) NOT NULL,
  `merch_name` varchar(40) NOT NULL,
  `price` int(10) NOT NULL,
  `stock_available` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchandise details`
--

INSERT INTO `merchandise details` (`merch_id`, `merch_name`, `price`, `stock_available`) VALUES
(1, 'SHIRT1', 400, 69),
(2, 'SHIRT2', 400, 69),
(3, 'SHIRT3', 400, 69),
(4, 'SHIRT4', 400, 69),
(5, 'SHIRT5', 400, 69),
(6, 'TOTEBAG1', 300, 69),
(7, 'TOTEBAG2', 160, 69),
(8, 'TOTEBAG3', 320, 69),
(9, 'LANYARD1', 100, 69),
(10, 'LANYARD2', 110, 69);

-- --------------------------------------------------------

--
-- Table structure for table `order details`
--

CREATE TABLE `order details` (
  `order_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `merch_id` int(10) NOT NULL,
  `merch_name` varchar(40) NOT NULL,
  `order_amount` int(10) NOT NULL,
  `ordered_date` datetime NOT NULL DEFAULT current_timestamp(),
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order details`
--

INSERT INTO `order details` (`order_id`, `student_id`, `merch_id`, `merch_name`, `order_amount`, `ordered_date`, `price`) VALUES
(108, 12345679, 3, 'SHIRT3', 2, '2023-12-29 15:53:25', 400);

-- --------------------------------------------------------

--
-- Table structure for table `order status`
--

CREATE TABLE `order status` (
  `order_status` int(11) NOT NULL DEFAULT 0,
  `order_id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `merch_id` int(10) NOT NULL,
  `ordered_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expected_arrival` date DEFAULT (current_timestamp() + interval 7 day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order status`
--

INSERT INTO `order status` (`order_status`, `order_id`, `student_id`, `merch_id`, `ordered_date`, `expected_arrival`) VALUES
(0, 108, 12345679, 3, '2023-12-29 15:53:26', '2024-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `payment method`
--

CREATE TABLE `payment method` (
  `student_id` int(10) NOT NULL,
  `payment_method` varchar(40) NOT NULL,
  `total_price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment method`
--

INSERT INTO `payment method` (`student_id`, `payment_method`, `total_price`) VALUES
(12345679, 'CashonHand', 400),
(12345679, 'CashonHand', 800);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add to cart`
--
ALTER TABLE `add to cart`
  ADD PRIMARY KEY (`cartId`),
  ADD UNIQUE KEY `merch_id` (`merch_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `customer's information`
--
ALTER TABLE `customer's information`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `merchandise details`
--
ALTER TABLE `merchandise details`
  ADD PRIMARY KEY (`merch_id`);

--
-- Indexes for table `order details`
--
ALTER TABLE `order details`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order status`
--
ALTER TABLE `order status`
  ADD KEY `order details` (`order_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add to cart`
--
ALTER TABLE `add to cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order details`
--
ALTER TABLE `order details`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add to cart`
--
ALTER TABLE `add to cart`
  ADD CONSTRAINT `add to cart_ibfk_1` FOREIGN KEY (`merch_id`) REFERENCES `merchandise details` (`merch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `add to cart_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `customer's information` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order details`
--
ALTER TABLE `order details`
  ADD CONSTRAINT `order details_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `customer's information` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order details_ibfk_2` FOREIGN KEY (`merch_id`) REFERENCES `merchandise details` (`merch_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
