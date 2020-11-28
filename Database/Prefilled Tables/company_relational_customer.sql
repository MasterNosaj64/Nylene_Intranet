-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2020 at 07:34 PM
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
-- Table structure for table `company_relational_customer`
--

CREATE TABLE `company_relational_customer` (
  `company_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_relational_customer`
--

INSERT INTO `company_relational_customer` (`company_id`, `customer_id`) VALUES
(2, 1),
(2, 2),
(3, 3),
(3, 4),
(4, 5),
(4, 6),
(5, 7),
(6, 8),
(7, 9),
(8, 10),
(9, 11),
(9, 12),
(10, 13),
(11, 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_relational_customer`
--
ALTER TABLE `company_relational_customer`
  ADD KEY `FK_company_id_customer_company` (`company_id`),
  ADD KEY `FK_customer_id_customer_company` (`customer_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_relational_customer`
--
ALTER TABLE `company_relational_customer`
  ADD CONSTRAINT `FK_company_id_customer_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_customer_id_customer_company` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
