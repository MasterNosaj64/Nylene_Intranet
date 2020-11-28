-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2020 at 07:22 PM
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
(1, 'Jason Waid', 'Company1@Company1.com', '2020-11-11 00:00:00', '2222222222', '2222222222'),
(2, 'Redaet Daniel', 'Company@Company.com', '2020-11-11 00:00:00', '515-954-3232', '515-954-3232'),
(3, 'Lorne Waid', 'Company3@Company3.com', '2020-11-11 00:00:00', '5555555555', '5555555555'),
(4, 'Kaitlyn Breker', 'Company4@Company4.com', '2020-11-11 00:00:00', '888-999-9999', '888-999-9999'),
(5, 'Ali Syed', 'Company5@Company5.com', '2020-11-11 00:00:00', '5555555555', '5555555555'),
(6, 'Michael Rayner', 'Company6@Company6.com', '2020-11-11 00:00:00', '7777777777', '7777777777'),
(7, 'Alex Gendron', 'Company7@Company7.com', '2020-11-11 00:00:00', '1453438764', '1453438764'),
(8, 'Nick Wright', 'Company8@Company8.com', '2020-11-11 00:00:00', '525-858-8585', '525-858-8585'),
(9, 'Donald Sutherland', 'Company9@Company9.com', '2020-11-11 00:00:00', '145-784-9696', '145-784-9696'),
(10, 'James Bond', 'Company10@Company10.com', '2020-11-11 00:00:00', '613-787-8585', '613-787-8585'),
(11, 'Jeffrey Benoit', 'Company11@Company11.com', '2020-11-11 00:00:00', '613-787-1321', '613-787-1321'),
(12, 'Robert Takacs', 'Company12@Company12.com', '2020-11-11 00:00:00', '819-342-9795', '819-342-9795'),
(13, 'Redaet Daniel', 'redu@redfo.com', '2020-11-15 00:00:00', '2222222222', '2222222222'),
(14, 'Lorne Waid', 'lorne.waid@email.com', '2020-11-15 00:00:00', '3333333333', '3333333333');

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
