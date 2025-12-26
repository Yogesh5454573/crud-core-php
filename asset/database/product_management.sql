-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 12:36 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(20) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `sub_category_name` varchar(250) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_details` varchar(255) NOT NULL,
  `product_color` varchar(255) NOT NULL,
  `product_price` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_name`, `sub_category_name`, `product_name`, `product_details`, `product_color`, `product_price`) VALUES
(1, 'Samsung', 'samsung1', 'Lana Wong', 'Alias incidunt expl', 'Green', 772),
(2, 'Apple', 'iphone', 'Knox England', 'Provident ipsum inc', 'Green', 14),
(3, 'Apple', 'iphone', 'Octavia Vazquez', 'Repudiandae eligendi', 'Green', 847),
(4, 'Apple', 'iphone', 'Irma Bean', 'Dignissimos qui solu', 'Black', 277),
(5, 'Samsung', 'samsung1', 'TaShya Macdonald', 'Voluptatem Beatae s', 'Black', 490),
(6, 'Apple', 'iphone', 'Ila Sheppard', 'Non ut ipsam volupta', 'Green', 639),
(7, 'Samsung', 'samsung1', 'Asher Andrews', 'Consectetur ea in ne', 'Red', 991);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(20) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `c_description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category_name`, `c_description`) VALUES
(1, 'Apple', 'Apple is Good'),
(2, 'Samsung', 'vfsuv');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_categories`
--

CREATE TABLE `tbl_sub_categories` (
  `id` int(20) NOT NULL,
  `category_id` int(20) NOT NULL,
  `sub_category_name` varchar(250) NOT NULL,
  `s_c_description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sub_categories`
--

INSERT INTO `tbl_sub_categories` (`id`, `category_id`, `sub_category_name`, `s_c_description`) VALUES
(1, 1, 'iphone', 'dvgcvs'),
(2, 2, 'samsung1', 'vbfshbjv');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_categories`
--
ALTER TABLE `tbl_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_sub_categories`
--
ALTER TABLE `tbl_sub_categories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
