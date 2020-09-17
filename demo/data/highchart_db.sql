-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2018 at 07:16 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.2.4-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `highchart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `factor_list`
--

CREATE TABLE `factor_list` (
  `id` int(11) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `source` varchar(250) NOT NULL,
  `occurance_date` date NOT NULL,
  `target_chart_visibility` enum('y','n') NOT NULL DEFAULT 'n',
  `timeline_chart_visibility` enum('y','n') NOT NULL DEFAULT 'n',
  `addedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `addedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factor_list`
--

INSERT INTO `factor_list` (`id`, `sector_id`, `case_id`, `title`, `description`, `rank_id`, `source`, `occurance_date`, `target_chart_visibility`, `timeline_chart_visibility`, `addedOn`, `addedBy`) VALUES
(1, 3, 1, 'Drug', 'Extreme addiction of drug', 3, 'information collected from friend and family member', '2018-01-09', 'y', 'y', '2018-05-08 16:43:52', 0),
(2, 3, 1, 'Alcohol', 'Extreme addiction of Alcohol', 5, 'information collected from friend and family member', '2018-01-09', 'y', 'y', '2018-05-08 16:43:52', 0),
(3, 1, 1, 'especially unfair treatment', 'especially unfair treatment', 3, 'information collected from friend and family member', '2017-11-01', 'y', 'y', '2018-05-08 16:43:52', 0),
(4, 6, 1, 'dfd', 'fdfdfd', 4, 'dfdf', '2018-05-08', 'y', 'y', '2018-05-08 04:58:41', 1),
(5, 7, 1, 'ghghg', 'hghg', 5, 'ghgh', '2018-05-01', 'n', 'y', '2018-05-08 05:04:07', 1),
(6, 2, 1, 'threat a person to kill', 'threat a person to kill', 2, 'police report', '2018-05-07', 'y', 'y', '2018-05-08 05:12:42', 1),
(7, 7, 1, 'aaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', 10, 'aaaaaa', '2018-05-07', 'y', 'n', '2018-05-08 05:38:15', 1),
(8, 7, 1, 'aaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', 10, 'aaaaaa', '2018-05-07', 'y', 'n', '2018-05-08 05:39:04', 1),
(9, 5, 1, 'sdsds', 'sdsdsd', 10, 'sdsds', '2018-05-14', 'y', 'n', '2018-05-08 05:41:03', 1),
(10, 5, 1, 'sdsds', 'sdsdsd', 10, 'sdsds', '2018-05-14', 'y', 'n', '2018-05-08 05:41:26', 1),
(11, 2, 1, 'changed by Manish', 'ghghg', 10, 'ghgh', '2018-05-02', 'y', 'n', '2018-05-08 05:41:54', 1),
(12, 2, 1, 'changed by Manish', 'ghghg', 10, 'ghgh', '2018-05-02', 'y', 'n', '2018-05-08 05:42:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_name` varchar(250) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sector`
--

INSERT INTO `sector` (`id`, `sector_name`, `created_on`) VALUES
(1, 'Grievance', '2018-05-08 00:00:00'),
(2, 'History of violence', '2018-05-08 00:00:00'),
(3, 'Health', '2018-05-08 00:00:00'),
(4, 'Status', '2018-05-08 00:00:00'),
(5, 'Misc', '2018-05-08 00:00:00'),
(6, 'Relations', '2018-05-08 00:00:00'),
(7, 'Target', '2018-05-08 00:00:00'),
(8, 'Threat', '2018-05-08 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `factor_list`
--
ALTER TABLE `factor_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `factor_list`
--
ALTER TABLE `factor_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
