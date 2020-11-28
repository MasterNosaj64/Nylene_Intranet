-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2020 at 07:21 PM
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
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `billing_address_street` varchar(150) DEFAULT NULL,
  `billing_address_city` varchar(100) DEFAULT NULL,
  `billing_address_state` varchar(100) DEFAULT NULL,
  `billing_address_postalcode` varchar(20) DEFAULT NULL,
  `billing_address_country` varchar(255) DEFAULT NULL,
  `shipping_address_street` varchar(150) DEFAULT NULL,
  `shipping_address_city` varchar(100) DEFAULT NULL,
  `shipping_address_state` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode` varchar(20) DEFAULT NULL,
  `shipping_address_country` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `date_created` date NOT NULL,
  `date_modified` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `website`, `billing_address_street`, `billing_address_city`, `billing_address_state`, `billing_address_postalcode`, `billing_address_country`, `shipping_address_street`, `shipping_address_city`, `shipping_address_state`, `shipping_address_postalcode`, `shipping_address_country`, `description`, `type`, `industry`, `company_email`, `assigned_to`, `date_created`, `date_modified`, `created_by`) VALUES
(2, 'Company 1', 'http://ade.com', '286 Gendron', 'Magog', 'QC', 'Company1', 'Company1', 'Company 1', 'Company 1', 'Company 1', 'Company 1', 'Company 1', '', '', '', 'abc@email.com', 1, '2020-11-11', '2020-11-12', 1),
(3, 'Company 2', 'http://243fr.com', '234 Fake', 'Ottawa', 'ON', '', '', 'Company 2', 'Company 2', 'Company 2', 'Company 2', 'Company 2', '', '', '', 'zds@email.com', 1, '2020-11-11', NULL, 1),
(4, 'Company3', 'http://zas.com', '12 Bell', 'Sherbrooke', 'TX', '', '', 'Company3', 'Company3', 'Company3', 'Company3', 'Company3', '', '', '', 'dsh@email.com', 1, '2020-11-11', NULL, 1),
(5, 'Company4', 'http://weg6.com', '2531 view', 'Montreal', 'AB', '', '', 'Company4', 'Company4', 'Company4', 'Company4', 'Company4', '', '', '', '123@email.com', 1, '2020-11-11', NULL, 1),
(6, 'Company5', 'http://asw.com', '182 que', 'Lenoxville', 'NS', '', '', 'Company5', 'Company5', 'Company5', 'Company5', 'Company5', '', '', '', 'ewrt@email.com', 1, '2020-11-11', NULL, 1),
(7, 'Company6', 'http://xsw.com', '693 Street', 'Kanata', 'NWT', '', '', 'Company6', 'Company6', 'Company6', 'Company6', 'Company6', '', '', '', 'acrhg@email.com', 1, '2020-11-11', NULL, 1),
(8, 'Company7', 'http://12jyt.com', '321 Port', 'Nepean', 'V', '', '', 'Company7', 'Company7', 'Company7', 'Company7', 'Company7', '', '', '', '67fh@email.com', 1, '2020-11-11', NULL, 1),
(9, 'Company8', 'http://cd.com', '12 root', 'Hull', 'SK', '', '', 'Company8', 'Company8', 'Company8', 'Company8', 'Company8', '', '', '', 'd@email.com', 1, '2020-11-11', NULL, 1),
(10, 'Company9', 'http://csf.com', '29 poor', 'New York', 'MB', '', '', 'Company9', 'Company9', 'Company9', 'Company9', 'Company9', '', '', '', 'fs@email.com', 1, '2020-11-11', NULL, 1),
(11, 'Company10', 'http://hhjrt.com', '48 cat', 'Stanstead', 'Y', '', '', 'Company10', 'Company10', 'Company10', 'Company10', 'Company10', '', '', '', '1243trwer@email.com', 1, '2020-11-11', NULL, 1),
(12, 'Company11', 'http://cwf.com', '43 dog', 'Yukon', 'PEI', '', '', 'Company11', 'Company11', 'Company11', 'Company11', 'Company11', '', '', '', 'dsfe4@email.com', 1, '2020-11-11', NULL, 1),
(13, 'Company12', 'http://Company12.comcji', '2543 yaris', 'Calgary', 'WS', '', '', 'Company12', 'Company12', 'Company12', 'Company12', 'Company12', '', '', '', 'ffbd3@email.com', 1, '2020-11-11', NULL, 1),
(14, 'a', 'http://a.com', '3 a', 'Edmonton', 'NY', '', '', 'a', 'a', 'a', 'a', 'a', '', '', '', 'acew@email.com', 1, '2020-11-11', NULL, 1),
(15, 'ascot', 'http://ascot.com', '7 ascot', 'Newport', 'CA', '', '', 'ascot', 'ascot', 'ascot', 'ascot', 'ascot', '', '', '', '3gtd@email.com', 1, '2020-11-11', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `Fk_created_by` (`created_by`),
  ADD KEY `FK_assigned_to` (`assigned_to`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `FK_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
