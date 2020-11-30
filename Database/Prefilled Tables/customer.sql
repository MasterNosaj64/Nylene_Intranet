-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2020 at 04:42 AM
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
-- Database: `nylene`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `customer_phone` varchar(100) DEFAULT NULL,
  `customer_fax` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `date_created`, `customer_phone`, `customer_fax`) VALUES
(1, 'Eliot Moose', 'eliotm@spencers.com', '2020-11-11 00:00:00', '8195648484', ''),
(2, 'Redaet Daniel', 'redd@spencers.com', '2020-11-11 00:00:00', '8194658485', ''),
(3, 'Lorne Waid', 'lwaid@valleyfields.com', '2020-11-11 00:00:00', '6136465252', ''),
(4, 'Kaitlyn Breker', 'kbreker@valleyfields.com', '2020-11-11 00:00:00', '8196453165', ''),
(5, 'Ali Syed', 'alisyed@algonquincollege.com', '2020-11-11 00:00:00', '6139895646', '6475659594'),
(6, 'Michael Rayner', 'michaelrayner6@algonquincollege.com', '2020-11-11 00:00:00', '6478985646', '6479856465'),
(7, 'Alex Gendron', 'alexg@weggers.com', '2020-11-11 00:00:00', '4586453521', ''),
(8, 'Nick Wright', 'nwright@ttrove.com', '2020-11-11 00:00:00', '8468459595', ''),
(9, 'Donald Sutherland', 'dsutherland@canopymolds.com', '2020-11-11 00:00:00', '6478616495', ''),
(10, 'James Bond', 'jbond@blissmolds.com', '2020-11-11 00:00:00', '6478951546', '6479564959'),
(11, 'Jeffrey Benoit', 'jbenoit@zacksmolds.com', '2020-11-11 00:00:00', '8194567858', ''),
(12, 'Robert Takacs', 'rtackacs@zacksmolds.com', '2020-11-11 00:00:00', '8195468494', ''),
(13, 'Redaet Daniel', 'redu@haroldandkumarco.com', '2020-11-15 00:00:00', '6479856495', ''),
(14, 'Lorne Waid', 'lorne.waid@nelson.com', '2020-11-15 00:00:00', '8198469795', '8196459795'),
(15, 'Greg Savage', 'gsavage@spencers.com', '2020-11-29 00:00:00', '8198439795', ''),
(16, 'Redaet Daniel', 'mrjehdoubleu@gmail.com', '2020-11-29 00:00:00', '8193429795', '1111111111'),
(17, 'Jason Waid', 'jwaid@spencers.com', '2020-11-29 00:00:00', '8198469898', ''),
(18, 'Todd Rivet', 'trivet@spencers.com', '2020-11-29 00:00:00', '7894651345', ''),
(19, 'Bob Hascal', 'bobhascal@albertmolds.com', '2020-11-29 00:00:00', '8194589598', '8194845656'),
(20, 'Zack Snyder', 'zacksnyder@ascot.com', '2020-11-29 00:00:00', '5474659834', '5463165945'),
(21, 'Brandon Bailey', 'bbailey@bluetrail.com', '2020-11-29 00:00:00', '8196133310', ''),
(22, 'Zoe Hope', 'zhope@vegetariansunited.com', '2020-11-29 00:00:00', '6136489575', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
