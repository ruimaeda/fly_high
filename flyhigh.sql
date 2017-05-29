-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 5 月 29 日 02:36
-- サーバのバージョン： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flyhigh`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country_code` int(11) NOT NULL,
  `country_area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `delete_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `country_styles`
--

CREATE TABLE `country_styles` (
  `country_style_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `sale_text` text CHARACTER SET utf8 NOT NULL,
  `sale_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sale_category` varchar(255) CHARACTER SET utf8 NOT NULL,
  `picture_path` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sale_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `styles`
--

CREATE TABLE `styles` (
  `style_id` int(11) NOT NULL,
  `style_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nick_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `age` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `income` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_purpose` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_budget` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_period` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_country` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_time` varchar(100) CHARACTER SET utf8 NOT NULL,
  `know_flyhigh` varchar(100) CHARACTER SET utf8 NOT NULL,
  `demand` text CHARACTER SET utf8 NOT NULL,
  `delete_flag` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_countries`
--

CREATE TABLE `user_countries` (
  `user_country_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_sales`
--

CREATE TABLE `user_sales` (
  `user_sale_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `country_styles`
--
ALTER TABLE `country_styles`
  ADD PRIMARY KEY (`country_style_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`style_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_countries`
--
ALTER TABLE `user_countries`
  ADD PRIMARY KEY (`user_country_id`);

--
-- Indexes for table `user_sales`
--
ALTER TABLE `user_sales`
  ADD PRIMARY KEY (`user_sale_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country_styles`
--
ALTER TABLE `country_styles`
  MODIFY `country_style_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `styles`
--
ALTER TABLE `styles`
  MODIFY `style_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_countries`
--
ALTER TABLE `user_countries`
  MODIFY `user_country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_sales`
--
ALTER TABLE `user_sales`
  MODIFY `user_sale_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
