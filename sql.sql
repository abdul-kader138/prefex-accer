-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2018 at 08:36 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accerp_dev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltasktemplates_clients`
--

DROP TABLE IF EXISTS `tbltasktemplates_clients`;
CREATE TABLE `tbltasktemplates_clients` (
  `id` int(11) NOT NULL,
  `tblclients_userid` int(11) NOT NULL,
  `tbltemplate_task_id` int(11) NOT NULL,
  `period_end_dd` int(3) DEFAULT NULL,
  `period_end_mm` int(3) DEFAULT NULL,
  `assigned_to` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbltasktemplates_clients`
--
ALTER TABLE `tbltasktemplates_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tblclients_userid_2` (`tblclients_userid`,`tbltemplate_task_id`,`period_end_dd`,`period_end_mm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbltasktemplates_clients`
--
ALTER TABLE `tbltasktemplates_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2018 at 08:39 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accerp_dev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblstafftemplate_tasks_recurring`
--

CREATE TABLE `tblstafftemplate_tasks_recurring` (
  `id` int(11) NOT NULL,
  `tblstafftasks_id` int(11) NOT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
