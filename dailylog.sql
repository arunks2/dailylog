-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2016 at 07:42 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dailylog`
--

-- --------------------------------------------------------

--
-- Table structure for table `dk_activities`
--

CREATE TABLE IF NOT EXISTS `dk_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_text` text NOT NULL,
  `activity_date` datetime NOT NULL,
  `location` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dk_activities`
--

INSERT INTO `dk_activities` (`id`, `user_id`, `activity_text`, `activity_date`, `location`, `is_approved`, `is_active`) VALUES
(10, 1, 'Activity 1', '2016-01-06 08:27:54', '', 0, 1),
(11, 1, 'asdfsdaf', '2016-01-06 20:29:55', '', 0, 1),
(12, 1, 'activity 24', '2016-01-06 20:30:14', '', 0, 1),
(13, 1, 'askdjfl', '2016-01-06 20:30:52', '', 0, 1),
(14, 1, 'akfsjha', '2016-01-06 20:30:53', '', 0, 1),
(15, 1, 'asldjfajdhg', '2016-01-06 20:30:55', '', 0, 1),
(16, 1, 'Did yoga, morning brief', '2016-01-07 10:46:44', '', 1, 1),
(17, 1, 'Worked on Daily Log Application', '2016-01-07 12:01:55', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dk_comments`
--

CREATE TABLE IF NOT EXISTS `dk_comments` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dk_comments`
--

INSERT INTO `dk_comments` (`id`, `activity_id`, `user_id`, `comment_text`, `comment_date`, `is_active`) VALUES
(1, 10, 1, 'asdfkj', '2016-01-07 18:26:00', 0),
(2, 10, 1, 'asfd', '2016-01-06 00:00:00', 1),
(3, 16, 1, 'Wow!', '2016-01-07 11:57:36', 1),
(4, 16, 1, 'Hey there!', '2016-01-07 11:57:41', 1),
(5, 16, 1, 'Hey there!', '2016-01-07 11:58:17', 1),
(6, 16, 1, 'Comment here', '2016-01-07 11:58:58', 1),
(7, 16, 1, 'dsaf', '2016-01-07 11:59:04', 1),
(8, 17, 2, 'Work is going on good.', '2016-01-07 12:02:58', 1),
(9, 17, 1, 'Lets get this done!', '2016-01-07 12:06:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dk_users`
--

CREATE TABLE IF NOT EXISTS `dk_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dk_users`
--

INSERT INTO `dk_users` (`id`, `firstname`, `lastname`, `email`, `password`, `is_active`) VALUES
(1, 'Arun', 'Kumar', 'arun@designkarkhana.com', 'arun123', 1),
(2, 'Himanshu', 'Sukhwani', 'himanshu@designkarkhana.com', 'himanshu123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dk_activities`
--
ALTER TABLE `dk_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dk_comments`
--
ALTER TABLE `dk_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dk_users`
--
ALTER TABLE `dk_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dk_activities`
--
ALTER TABLE `dk_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `dk_comments`
--
ALTER TABLE `dk_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `dk_users`
--
ALTER TABLE `dk_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
