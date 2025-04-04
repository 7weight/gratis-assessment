-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 04, 2025 at 02:33 AM
-- Server version: 5.7.44
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gratis`
--
CREATE DATABASE IF NOT EXISTS `gratis` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gratis`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `stock` varchar(50) NOT NULL,
  `vin` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `mfg` int(11) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `pkg` varchar(50) DEFAULT NULL,
  `miles` int(11) DEFAULT NULL,
  `engine` varchar(100) DEFAULT NULL,
  `drive` int(11) DEFAULT NULL,
  `c_ext` int(11) DEFAULT NULL,
  `c_int` int(11) DEFAULT NULL,
  `interior` int(11) DEFAULT NULL,
  `fuel` int(11) DEFAULT NULL,
  `cond` int(11) DEFAULT NULL,
  `details` text,
  `msrp` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `stock`, `vin`, `year`, `mfg`, `model`, `pkg`, `miles`, `engine`, `drive`, `c_ext`, `c_int`, `interior`, `fuel`, `cond`, `details`, `msrp`, `price`, `sale_price`, `type`, `active`, `created`, `updated`) VALUES
(1, '160656', '3GNKDCRJ5RS160656', 2023, 6, 'Blazer', 'EV', 2460, '', 1, 3, 2, 4, 3, 2, 'Preferred Equipment Group 1RS, 11.1 Axle Ratio, Wheels: 21\" Machined-Face Aluminum, Perforated Suede/Evotex Seat Trim, Ride & Handling Suspension, Radio: 17.7\" Diagonal Advanced Color LCD Display, Convenience & Driver Confidence Package, RS Convenience & Driver Confidence Package, 8-Way Power Driver Seat Adjuster, 6-Way Power Passenger Seat Adjuster, 2-Way Power Driver Lumbar Seat Adjuster, 2-Way Power Passenger Lumbar Seat Adjuster, Heated Wiper Park, Intersection Automatic Emergency Braking, Rear Camera Washer, Rear Camera Mirror', 0.00, 55090.00, 0.00, 2, 1, '2025-04-02 23:49:03', '2025-04-04 05:07:51'),
(2, '315205', '3GTPUAEK8RG315205', 2024, 11, 'Sierra', '1500', 7099, '2.7L I4 Turbocharged DOHC 16V LEV3-SULEV30 310hp', 1, 1, 1, 3, 1, 1, 'Preferred Equipment Group 1SA, 3.42 Rear Axle Ratio, Wheels: 17\" x 8\" Silver Painted Steel, Wheels: 17\" x 8\" Bright Silver Painted Aluminum, Front 40/20/40 Split-Bench Seat, Vinyl Seat Trim, Standard Suspension Package, Convenience Package, Pro Value Package, Radio: GMC Infotainment Audio System, Cruise Control', 48660.00, 48660.00, 44660.00, 3, 1, '2025-04-02 23:49:03', '2025-04-02 23:49:03'),
(3, '107903', '1GT10BDD4SU107903', 2025, 11, 'Hummer', 'EV', 499, '', 2, 1, 1, 1, 3, 1, 'Preferred Equipment Group 1SC, 13.26 Final Drive Ratio, Wheels: 22\" x 9.5\" Gloss Black Painted Aluminum, Premium Front Bucket Seats w/Center Console, Premium Leather-Alternative Seating Surfaces, Front & Rear Air Ride Adaptive Suspension, Radio: AM/FM Audio System, 12-Way Power Driver Seat Adjuster, 12-Way Power Passenger Seat Adjuster, Heated Driver & Front Passenger Seats, Ventilated Driver & Front Passenger Seats, Wireless Phone Projection, SiriusXM w/360L, Bose Premium 14-Speaker Surround Sound System', 98845.00, 98845.00, 95845.00, 2, 1, '2025-04-02 23:49:03', '2025-04-03 17:29:31'),
(4, '116753', '1G1ZD5ST1SF116753', 2025, 6, 'Malibu', '', 5, '1.5L DOHC', 1, 3, 1, 3, 1, 1, 'Preferred Equipment Group 1LT, 17\" Aluminum Wheels, Wheels: 19\" Black-Painted Aluminum, Premium Cloth Seat Trim, 8-Way Power Driver Seat Adjuster, Radio: Chevrolet Infotainment 3 System, Midnight Edition, Sports Edition, 6-Way Manual Front Passenger Seat Adjuster, Power Driver Lumbar Control Seat Adjuster, Nameplate Badge In Black, Front & Rear Black Bowties, Blacked-Out Grille w/Dark Chrome Surround, Heated Driver & Front Passenger Seats, Wrapped Steering Wheel, Wireless Apple CarPlay/Android Auto', NULL, 30190.00, 0.00, 1, 1, '2025-04-02 23:49:03', '2025-04-03 22:21:38'),
(11, '777770', 'abc123', 2023, 1, 'Tundress', 'Ltd', 900, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 75000.00, 73000.00, NULL, 0, '2025-04-03 20:45:47', '2025-04-03 22:33:27'),
(12, '777787', 'abc123', 2025, 1, 'Tundra', 'Limited', 900, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 59008.00, 57000.00, NULL, 1, '2025-04-04 05:11:04', '2025-04-04 06:29:35'),
(13, '777777', 'abc123', 2023, 6, 'Suburban', '1LZ', 900, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 81745.00, 0.00, NULL, 1, '2025-04-04 05:13:40', '2025-04-04 05:13:40'),
(14, '777760', 'abc123', 2024, 6, 'Silverado', 'EV', 450, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 75445.00, 0.00, NULL, 1, '2025-04-04 05:15:30', '2025-04-04 05:15:30'),
(15, '555777', '123459879', 2025, 6, 'TrailBlazer', '1LT', 456, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 29365.00, 0.00, NULL, 1, '2025-04-04 05:17:45', '2025-04-04 05:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `cond`
--

DROP TABLE IF EXISTS `cond`;
CREATE TABLE `cond` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cond`
--

INSERT INTO `cond` (`id`, `name`) VALUES
(3, 'certified'),
(1, 'new'),
(2, 'used');

-- --------------------------------------------------------

--
-- Table structure for table `c_ext`
--

DROP TABLE IF EXISTS `c_ext`;
CREATE TABLE `c_ext` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `c_ext`
--

INSERT INTO `c_ext` (`id`, `name`) VALUES
(2, 'black'),
(4, 'blue'),
(6, 'green'),
(3, 'red'),
(5, 'stone'),
(1, 'white');

-- --------------------------------------------------------

--
-- Table structure for table `c_int`
--

DROP TABLE IF EXISTS `c_int`;
CREATE TABLE `c_int` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `c_int`
--

INSERT INTO `c_int` (`id`, `name`) VALUES
(1, 'black'),
(5, 'graphite'),
(3, 'gray'),
(2, 'tan'),
(4, 'white');

-- --------------------------------------------------------

--
-- Table structure for table `drive`
--

DROP TABLE IF EXISTS `drive`;
CREATE TABLE `drive` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drive`
--

INSERT INTO `drive` (`id`, `name`) VALUES
(1, '2WD'),
(2, '4WD'),
(3, 'AWD');

-- --------------------------------------------------------

--
-- Table structure for table `fuel`
--

DROP TABLE IF EXISTS `fuel`;
CREATE TABLE `fuel` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fuel`
--

INSERT INTO `fuel` (`id`, `name`) VALUES
(2, 'diesel'),
(3, 'electric'),
(1, 'gas'),
(4, 'hybrid'),
(6, 'hydrogen'),
(5, 'natural gas');

-- --------------------------------------------------------

--
-- Table structure for table `incentives`
--

DROP TABLE IF EXISTS `incentives`;
CREATE TABLE `incentives` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `interior`
--

DROP TABLE IF EXISTS `interior`;
CREATE TABLE `interior` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `interior`
--

INSERT INTO `interior` (`id`, `name`) VALUES
(3, 'fabric'),
(1, 'leather'),
(4, 'suede'),
(2, 'vinyl');

-- --------------------------------------------------------

--
-- Table structure for table `mfg`
--

DROP TABLE IF EXISTS `mfg`;
CREATE TABLE `mfg` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mfg`
--

INSERT INTO `mfg` (`id`, `name`) VALUES
(8, 'BMW'),
(6, 'Chevrolet'),
(3, 'Ford'),
(11, 'GMC'),
(4, 'Honda'),
(5, 'Hyundai'),
(10, 'Kia'),
(9, 'Mercedes-Benz'),
(7, 'Nissan'),
(1, 'Toyota'),
(2, 'Volkswagen');

-- --------------------------------------------------------

--
-- Table structure for table `style`
--

DROP TABLE IF EXISTS `style`;
CREATE TABLE `style` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `style`
--

INSERT INTO `style` (`id`, `name`) VALUES
(5, 'coupe'),
(4, 'crossover'),
(1, 'sedan'),
(6, 'sportscar'),
(2, 'SUV'),
(3, 'truck');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usr_group` varchar(50) DEFAULT 'user',
  `avatar` varchar(200) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `usr_group`, `avatar`, `created_date`, `updated_date`, `active`) VALUES
(1, 'General', 'Akbar', 'akbar@gmail.com', '$2y$12$qir96QvFZSccy33PFOE4eO.xyj2PPm/wF6KNTlmIl1wiYwP1sDf5q', '1', 'akbar2.png', '2025-04-03 06:18:27', '2025-04-03 21:07:19', 1),
(2, 'Grant', 'Summerlin', 'grant@7weight.com', '$2y$12$qir96QvFZSccy33PFOE4eO.xyj2PPm/wF6KNTlmIl1wiYwP1sDf5q', '1', 'jawa.png', '2025-04-03 06:18:27', '2025-04-03 21:07:19', 1),
(3, 'Luke', 'Skytester', 'test@me.com', '$2y$12$A7te8FYxlFNSWzZs1VWD8euBs7ea6Pwq8Cg2piP6pAaQBbtX0ilOe', '1', 'luke.png', '2025-04-03 06:18:27', '2025-04-03 21:07:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_incentives`
--

DROP TABLE IF EXISTS `vehicle_incentives`;
CREATE TABLE `vehicle_incentives` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `incentive_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_photos`
--

DROP TABLE IF EXISTS `vehicle_photos`;
CREATE TABLE `vehicle_photos` (
  `id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `is_primary` tinyint(1) DEFAULT '0',
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle_photos`
--

INSERT INTO `vehicle_photos` (`id`, `car_id`, `stock`, `filename`, `alt_text`, `sort_order`, `is_primary`, `upload_date`) VALUES
(37, NULL, 107903, '107903-1.jpg', NULL, 1, 1, '2025-04-03 20:17:33'),
(38, NULL, 107903, '107903-2.jpg', NULL, 2, 0, '2025-04-03 20:17:33'),
(39, NULL, 107903, '107903-3.jpg', NULL, 3, 0, '2025-04-03 20:17:33'),
(40, NULL, 116753, '116753-1.jpg', NULL, 1, 1, '2025-04-03 20:17:33'),
(41, NULL, 116753, '116753-2.jpg', NULL, 2, 0, '2025-04-03 20:17:33'),
(42, NULL, 116753, '116753-3.jpg', NULL, 3, 0, '2025-04-03 20:17:33'),
(43, NULL, 160656, '160656-1.jpg', NULL, 1, 1, '2025-04-03 20:17:33'),
(44, NULL, 160656, '160656-2.jpg', NULL, 2, 0, '2025-04-03 20:17:33'),
(45, NULL, 160656, '160656-3.jpg', NULL, 3, 0, '2025-04-03 20:17:33'),
(46, NULL, 315205, '315205-1.jpg', NULL, 1, 1, '2025-04-03 20:17:33'),
(47, NULL, 315205, '315205-2.jpg', NULL, 2, 0, '2025-04-03 20:17:33'),
(48, NULL, 315205, '315205-3.jpg', NULL, 3, 0, '2025-04-03 20:17:33'),
(56, NULL, 777770, '777770-1.jpeg', NULL, 0, 0, '2025-04-03 20:45:47'),
(57, NULL, 777770, '777770-2.jpeg', NULL, 0, 0, '2025-04-03 20:45:47'),
(58, NULL, 777770, '777770-3.jpeg', NULL, 0, 1, '2025-04-03 20:45:47'),
(59, NULL, 777787, '777787-1.jpg', NULL, 0, 1, '2025-04-04 05:11:04'),
(60, NULL, 777787, '777787-2.jpg', NULL, 0, 0, '2025-04-04 05:11:04'),
(61, NULL, 777787, '777787-3.jpg', NULL, 0, 0, '2025-04-04 05:11:04'),
(62, NULL, 777777, '777777-1.jpg', NULL, 0, 1, '2025-04-04 05:13:40'),
(63, NULL, 777777, '777777-2.jpg', NULL, 0, 0, '2025-04-04 05:13:40'),
(64, NULL, 777777, '777777-3.jpg', NULL, 0, 0, '2025-04-04 05:13:40'),
(65, NULL, 777760, '777760-1.jpg', NULL, 0, 1, '2025-04-04 05:15:30'),
(66, NULL, 777760, '777760-2.jpg', NULL, 0, 0, '2025-04-04 05:15:30'),
(67, NULL, 777760, '777760-3.jpg', NULL, 0, 0, '2025-04-04 05:15:30'),
(68, NULL, 555777, '555777-1.jpg', NULL, 0, 1, '2025-04-04 05:17:45'),
(69, NULL, 555777, '555777-2.jpg', NULL, 0, 0, '2025-04-04 05:17:45'),
(70, NULL, 555777, '555777-3.jpg', NULL, 0, 0, '2025-04-04 05:17:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock` (`stock`),
  ADD KEY `mfg` (`mfg`),
  ADD KEY `drive` (`drive`),
  ADD KEY `c_ext` (`c_ext`),
  ADD KEY `c_int` (`c_int`),
  ADD KEY `interior` (`interior`),
  ADD KEY `fuel` (`fuel`),
  ADD KEY `cond` (`cond`);

--
-- Indexes for table `cond`
--
ALTER TABLE `cond`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `c_ext`
--
ALTER TABLE `c_ext`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `c_int`
--
ALTER TABLE `c_int`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `drive`
--
ALTER TABLE `drive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fuel`
--
ALTER TABLE `fuel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `incentives`
--
ALTER TABLE `incentives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interior`
--
ALTER TABLE `interior`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `mfg`
--
ALTER TABLE `mfg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicle_incentives`
--
ALTER TABLE `vehicle_incentives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `incentive_id` (`incentive_id`);

--
-- Indexes for table `vehicle_photos`
--
ALTER TABLE `vehicle_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cond`
--
ALTER TABLE `cond`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `c_ext`
--
ALTER TABLE `c_ext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `c_int`
--
ALTER TABLE `c_int`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `drive`
--
ALTER TABLE `drive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fuel`
--
ALTER TABLE `fuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `incentives`
--
ALTER TABLE `incentives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interior`
--
ALTER TABLE `interior`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mfg`
--
ALTER TABLE `mfg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `style`
--
ALTER TABLE `style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle_incentives`
--
ALTER TABLE `vehicle_incentives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_photos`
--
ALTER TABLE `vehicle_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`mfg`) REFERENCES `mfg` (`id`),
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`drive`) REFERENCES `drive` (`id`),
  ADD CONSTRAINT `cars_ibfk_3` FOREIGN KEY (`c_ext`) REFERENCES `c_ext` (`id`),
  ADD CONSTRAINT `cars_ibfk_4` FOREIGN KEY (`c_int`) REFERENCES `c_int` (`id`),
  ADD CONSTRAINT `cars_ibfk_5` FOREIGN KEY (`interior`) REFERENCES `interior` (`id`),
  ADD CONSTRAINT `cars_ibfk_6` FOREIGN KEY (`fuel`) REFERENCES `fuel` (`id`),
  ADD CONSTRAINT `cars_ibfk_7` FOREIGN KEY (`cond`) REFERENCES `cond` (`id`);

--
-- Constraints for table `vehicle_incentives`
--
ALTER TABLE `vehicle_incentives`
  ADD CONSTRAINT `vehicle_incentives_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `vehicle_incentives_ibfk_2` FOREIGN KEY (`incentive_id`) REFERENCES `incentives` (`id`);

--
-- Constraints for table `vehicle_photos`
--
ALTER TABLE `vehicle_photos`
  ADD CONSTRAINT `vehicle_photos_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
