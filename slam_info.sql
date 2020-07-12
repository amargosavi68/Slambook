-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2020 at 01:20 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slambook`
--

-- --------------------------------------------------------

--
-- Table structure for table `slam_info`
--

CREATE TABLE `slam_info` (
  `sender_user_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `moments` varchar(100) NOT NULL,
  `past` varchar(100) NOT NULL,
  `marooned` varchar(100) NOT NULL,
  `holiday` varchar(100) NOT NULL,
  `dreamcity` varchar(50) NOT NULL,
  `creaziest` varchar(200) NOT NULL,
  `life` varchar(100) NOT NULL,
  `bestthing` varchar(300) NOT NULL,
  `fantasy` varchar(200) NOT NULL,
  `bestfriends` varchar(300) NOT NULL,
  `thoughts` varchar(500) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
