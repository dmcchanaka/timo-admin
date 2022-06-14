-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2022 at 03:14 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timo_attendance_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) DEFAULT NULL,
  `sur_name` varchar(255) DEFAULT NULL,
  `u_code` varchar(255) DEFAULT NULL,
  `u_tp_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-active, 1-delete',
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `sur_name`, `u_code`, `u_tp_id`, `username`, `password`, `status`, `added_date`) VALUES
(1, 'admin', 'admin', 'admin', 1, 'admin', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(2, 'Natalie', 'Heinrich', 'eCKO', 2, 'Natalie', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(3, 'Karin', 'Hopp', 'EqOV', 2, 'Karin', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(4, 'Arno', 'Siefkes', 'poiV', 2, 'Arno', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(5, 'Melanie', 'Lohmeyer', 'XPFU', 2, 'Melanie', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(6, 'Adenike', 'Adesokan', 'pSjS', 2, 'Adenike', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(7, 'Maike', 'Beckmann', 'LPWl', 2, 'Maike', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(8, 'Gina', 'Berends', 'JzvY', 2, 'Gina', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(9, 'Aleta', 'Diehm', 'YIZN', 2, 'Aleta', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(10, 'Irma', 'Hubert-Schneider', 'CZXX', 2, 'Irma', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(11, 'Ina', 'Junker', 'YhDA', 2, 'Ina', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(12, 'Christina', 'Ohl', 'HBsn', 2, 'Christina', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(13, 'Stefan', 'Papenhusen', 'kQSA', 2, 'Stefan', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(14, 'Imke', 'Petersen', 'BRNN', 2, 'Imke', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(15, 'Hilke', 'Saathoff', 'MHRa', 2, 'Hilke', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(16, 'Marina', 'Timmermann', 'NSDC', 2, 'Marina', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(17, 'Edda', 'Weerts', 'AFbD', 2, 'Edda', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(18, 'Melissa', 'Aden', 'NlNB', 2, 'Melissa', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(19, 'Carina', 'Bayersdorf', 'IRBY', 2, 'Carina', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(20, 'Michelle', 'Dahlmann', 'rBtD', 2, 'Michelle', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(21, 'Franziska', 'Hilbrands', 'CiHQ', 2, 'Franziska', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(22, 'Elena', 'Ertus', 'RJXe', 2, 'Elena', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(23, 'Milena', 'Gernand', 'VWyz', 2, 'Milena', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(24, 'Conny', 'Helmers', 'FXdL', 2, 'Conny', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(25, 'Maren', 'Hoppe', 'FeHN', 2, 'Maren', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(26, 'Chirista', 'Klock', 'QuEI', 2, 'Chirista', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(27, 'Sarah', 'Kloppenburg', 'gCuY', 2, 'Sarah', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(28, 'Aylin', 'Klostermann', 'wMRM', 2, 'Aylin', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(29, 'Sandra', 'Wiechers', 'aFbB', 2, 'Sandra', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(30, 'Lena', 'Schmidt', 'PuYH', 2, 'Lena', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(31, 'Stefanie', 'Schmidt', 'ehkK', 2, 'Stefanie', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(32, 'Vanessa', 'Teske', 'CmMu', 2, 'Vanessa', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(33, 'Rena', 'Woldenga', 'EHCp', 2, 'Rena', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(34, 'Jule', 'Stiekel', 'uJdm', 2, 'Jule', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(35, 'Luca', 'Siefken', 'nsQM', 2, 'Luca', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(36, 'Majd', 'Talal', 'FbaE', 2, 'Majd', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(37, 'Bahar', 'Suerer', 'YgQm', 2, 'Bahar', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(38, 'Anja', 'Schaefe', 'ypOU', 2, 'Anja', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(39, 'Mariella', 'Baumann', 'QVCQ', 2, 'Mariella', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(40, 'Fenja', 'Eilers', 'yIvu', 2, 'Fenja', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(41, 'Julia', 'Schmidt', 'OVDQ', 2, 'Julia', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(42, 'Frauke', 'Buhr', 'HIOI', 2, 'Frauke', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(43, 'Gosia', 'Kowzan', 'BFWh', 2, 'Gosia', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(44, 'Cordula', 'Mueller', 'tUVL', 2, 'Cordula', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(45, 'Anja', 'Schaa', 'KyMO', 2, 'Anja', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(46, 'Susann', 'Schalles', 'xdbq', 2, 'Susann', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(47, 'Somaye', 'Sepehri', 'UIQK', 2, 'Somaye', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(48, 'Sabine', 'Boeden', 'DOFG', 2, 'Sabine', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(49, 'Silvia', 'Fremy', 'HyNl', 2, 'Silvia', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(50, 'Elisabeth', 'Schoon', 'qVAP', 2, 'Elisabeth', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(51, 'Juliane', 'Wilken', 'zPyp', 2, 'Juliane', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(52, 'Johanne', 'Waldecker', 'VAdS', 2, 'Johanne', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(53, 'Amke', 'Groen', 'HMGT', 2, 'Amke', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(54, 'Janine', 'Hauser', 'hRHO', 2, 'Janine', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(55, 'Paul', 'Eisel', 'yKJT', 2, 'Paul', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(56, 'Timo', 'Kaan', 'zOMG', 2, 'Timo', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(57, 'Max', 'Haversath', 'kwNa', 2, 'Max', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(58, 'Andreas', 'Hecht', 'MQKo', 2, 'Andreas', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(59, 'Gerhard', 'Diekena', 'dfHN', 2, 'Gerhard', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(60, 'Stephan', 'Watermeyer', 'kQqP', 2, 'Stephan', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39'),
(61, 'Cathrin', 'Campo', 'IrIB', 2, 'Cathrin', '202cb962ac59075b964b07152d234b70', 0, '2022-06-08 14:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_attendance`
--

CREATE TABLE `user_attendance` (
  `ua_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `u_code` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `ua_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-active,1-delete'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_attendance`
--

INSERT INTO `user_attendance` (`ua_id`, `u_id`, `u_code`, `year`, `month`, `ua_status`) VALUES
(1, 2, 'eCKO', 2022, 6, 0),
(2, 3, 'EqOV', 2022, 6, 0),
(3, 4, 'poiV', 2022, 6, 0),
(4, 5, 'XPFU', 2022, 6, 0),
(5, 6, 'pSjS', 2022, 6, 0),
(6, 7, 'LPWl', 2022, 6, 0),
(7, 8, 'JzvY', 2022, 6, 0),
(8, 9, 'YIZN', 2022, 6, 0),
(9, 10, 'CZXX', 2022, 6, 0),
(10, 11, 'YhDA', 2022, 6, 0),
(11, 12, 'HBsn', 2022, 6, 0),
(12, 13, 'kQSA', 2022, 6, 0),
(13, 14, 'BRNN', 2022, 6, 0),
(14, 15, 'MHRa', 2022, 6, 0),
(15, 16, 'NSDC', 2022, 6, 0),
(16, 17, 'AFbD', 2022, 6, 0),
(17, 18, 'NlNB', 2022, 6, 0),
(18, 19, 'IRBY', 2022, 6, 0),
(19, 20, 'rBtD', 2022, 6, 0),
(20, 21, 'CiHQ', 2022, 6, 0),
(21, 22, 'RJXe', 2022, 6, 0),
(22, 23, 'VWyz', 2022, 6, 0),
(23, 24, 'FXdL', 2022, 6, 0),
(24, 25, 'FeHN', 2022, 6, 0),
(25, 26, 'QuEI', 2022, 6, 0),
(26, 27, 'gCuY', 2022, 6, 0),
(27, 28, 'wMRM', 2022, 6, 0),
(28, 29, 'aFbB', 2022, 6, 0),
(29, 30, 'PuYH', 2022, 6, 0),
(30, 31, 'ehkK', 2022, 6, 0),
(31, 32, 'CmMu', 2022, 6, 0),
(32, 33, 'EHCp', 2022, 6, 0),
(33, 34, 'uJdm', 2022, 6, 0),
(34, 35, 'nsQM', 2022, 6, 0),
(35, 36, 'FbaE', 2022, 6, 0),
(36, 37, 'YgQm', 2022, 6, 0),
(37, 38, 'ypOU', 2022, 6, 0),
(38, 39, 'QVCQ', 2022, 6, 0),
(39, 40, 'yIvu', 2022, 6, 0),
(40, 41, 'OVDQ', 2022, 6, 0),
(41, 42, 'HIOI', 2022, 6, 0),
(42, 43, 'BFWh', 2022, 6, 0),
(43, 44, 'tUVL', 2022, 6, 0),
(44, 45, 'KyMO', 2022, 6, 0),
(45, 46, 'xdbq', 2022, 6, 0),
(46, 47, 'UIQK', 2022, 6, 0),
(47, 48, 'DOFG', 2022, 6, 0),
(48, 49, 'HyNl', 2022, 6, 0),
(49, 50, 'qVAP', 2022, 6, 0),
(50, 51, 'zPyp', 2022, 6, 0),
(51, 52, 'VAdS', 2022, 6, 0),
(52, 53, 'HMGT', 2022, 6, 0),
(53, 54, 'hRHO', 2022, 6, 0),
(54, 55, 'yKJT', 2022, 6, 0),
(55, 56, 'zOMG', 2022, 6, 0),
(56, 57, 'kwNa', 2022, 6, 0),
(57, 58, 'MQKo', 2022, 6, 0),
(58, 59, 'dfHN', 2022, 6, 0),
(59, 60, 'kQqP', 2022, 6, 0),
(60, 61, 'IrIB', 2022, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_attendance_details`
--

CREATE TABLE `user_attendance_details` (
  `utd_id` int(11) NOT NULL,
  `ua_id` int(11) DEFAULT NULL,
  `u_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_tme` time DEFAULT NULL,
  `night` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-no,1-yes',
  `illness` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-no,1-yes',
  `vacation` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-no,1-yes',
  `holiday` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-no,1-yes',
  `notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_attendance_details`
--

INSERT INTO `user_attendance_details` (`utd_id`, `ua_id`, `u_id`, `year`, `month`, `day`, `date`, `start_time`, `end_tme`, `night`, `illness`, `vacation`, `holiday`, `notes`) VALUES
(1, 1, 2, 2022, 6, 1, '2022-06-01', '10:00:00', '14:00:00', 0, 0, 0, 0, 'Comment1'),
(2, 1, 2, 2022, 6, 2, '2022-06-02', '08:00:00', '14:00:00', 0, 0, 0, 1, ''),
(3, 2, 3, 2022, 6, 6, '2022-06-06', '10:00:00', '14:00:00', 0, 0, 0, 0, 'Comment18'),
(4, 2, 3, 2022, 6, 7, '2022-06-07', '10:00:00', '20:00:00', 0, 0, 0, 1, ''),
(5, 4, 5, 2022, 6, 1, '2022-06-01', '19:00:00', '22:00:00', 1, 0, 0, 0, 'Comment12'),
(6, 4, 5, 2022, 6, 2, '2022-06-02', '08:10:00', '14:50:00', 0, 0, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `u_tp_id` int(11) NOT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '0-active, 1-delete',
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`u_tp_id`, `user_type`, `status`, `added_date`) VALUES
(1, 'admin', 0, '2022-06-08 14:50:00'),
(2, 'staff', 0, '2022-06-08 14:50:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `user_attendance`
--
ALTER TABLE `user_attendance`
  ADD PRIMARY KEY (`ua_id`);

--
-- Indexes for table `user_attendance_details`
--
ALTER TABLE `user_attendance_details`
  ADD PRIMARY KEY (`utd_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`u_tp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user_attendance`
--
ALTER TABLE `user_attendance`
  MODIFY `ua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `user_attendance_details`
--
ALTER TABLE `user_attendance_details`
  MODIFY `utd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `u_tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
