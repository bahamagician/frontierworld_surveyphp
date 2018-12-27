-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2018 at 03:55 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `frontierworld_survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `guest_ratings_comments`
--

CREATE TABLE `guest_ratings_comments` (
  `guest_id` int(11) NOT NULL,
  `ratings` tinyint(4) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscriptions`
--

CREATE TABLE `newsletter_subscriptions` (
  `guest_id` int(10) UNSIGNED NOT NULL,
  `updates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prelim_guest_Info`
--

CREATE TABLE `prelim_guest_Info` (
  `guest_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guest_ratings_comments`
--
ALTER TABLE `guest_ratings_comments`
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `newsletter_subscriptions`
--
ALTER TABLE `newsletter_subscriptions`
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `prelim_guest_Info`
--
ALTER TABLE `prelim_guest_Info`
  ADD PRIMARY KEY (`guest_id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prelim_guest_Info`
--
ALTER TABLE `prelim_guest_Info`
  MODIFY `guest_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `newsletter_subscriptions`
--
ALTER TABLE `newsletter_subscriptions`
  ADD CONSTRAINT `newsletter_subscriptions_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `prelim_guest_Info` (`guest_id`);

