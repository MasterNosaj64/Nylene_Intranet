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
(2, 'Spencers', 'http://www.Spencers.com', '286 Gendron', 'Magog', 'Quebec', 'S5E2W4', 'Canada', '286 Gendron', 'Magog', 'Quebec', 'S5E2W4', 'Canada', '', '', '', 'info@spencers.com', 1, '2020-11-11', '2020-11-29', 1),
(3, 'Valley Fields', 'http://www.valleyfields.org', '234 Fake Street', 'Ottawa', 'Ontario', 'K1G3B7', 'Canada', '234 Fake Street', 'Ottawa', 'Ontario', 'K1G3B7', 'Canada', '', '', '', 'info@valleyfields.com', 1, '2020-11-11', '2020-11-29', 1),
(4, 'Algonquin College', 'https://www.algonquincollege.com', '1385 Woodroffe Ave', 'Ottawa', 'Ontario', 'K2G1V8', 'Canada', '1385 Woodroffe Ave', 'Ottawa', 'Ontario', 'K2G1V8', 'Canada', '', '', '', 'info@algonquin.com', 1, '2020-11-11', '2020-11-29', 1),
(5, 'Weggers', 'http://weg.com', '2531 Views Drive', 'Montreal', 'Quebec', 'J1A0R4', 'Canada', '2531 Views Drive', 'Montreal', 'Quebec', 'J1A0R4', 'Canada', '', '', '', 'into@weggers.com', 1, '2020-11-11', '2020-11-29', 1),
(6, 'Treasure Trove', 'http://treasuretrove.com', '182 Larry Avenue', 'Lennoxville', 'Quebec', 'J1Q3R5', 'Canada', '182 Larry Avenue', 'Lennoxville', 'Quebec', 'J1Q3R5', 'Canada', '', '', '', 'info@treasuretrove.com', 1, '2020-11-11', '2020-11-29', 1),
(7, 'Canopy Molds', 'http://canopymolds.ca', '693 Street Lane', 'Kanata', 'Ontario', 'K1Q5E3', 'Canada', '693 Street Lane', 'Kanata', 'Ontario', 'K1Q5E3', 'Canada', '', '', '', 'info@canopymolds.com', 1, '2020-11-11', '2020-11-29', 1),
(8, 'Bliss Molds', 'http://www.blissmolds.com', '321 Port Drive', 'Toronto', 'Ontario', 'K6L5W4', 'Canada', '321 Port Drive', 'Toronto', 'Ontario', 'K6L5W4', 'Canada', '', '', '', 'info@blissmolds.com', 1, '2020-11-11', '2020-11-29', 1),
(9, 'Zack\'s Molds', 'http://zacksmolds.com', '124 Tacker Street', 'Edmonton', 'Alberta', 'K1R6E', 'Canada', '124 Tacker Street', 'Edmonton', 'Alberta', 'K1R6E', 'Canada', '', '', '', 'info@zacksmolds.com', 1, '2020-11-11', '2020-11-29', 1),
(10, 'Harold &amp; Kumar Co.', 'http://haroldandkumarco.com', '29 Poor Lane', 'New York', 'New York', 'K1A5E3', 'United States', '29 Poor Lane', 'New York', 'New York', 'K1A5E3', 'United States', '', '', '', 'info@haroldandkumarco.com', 1, '2020-11-11', '2020-11-29', 1),
(11, 'Nelson Inc.', 'http://www.Nelson.com', '48 Cat Street', 'Stanstead', 'Quebec', 'J1X0M9', 'Canada', '48 cat', 'Stanstead', 'Quebec', 'J1X0M9', 'Canada', '', '', '', 'JoanJones@Nelson.com', 1, '2020-11-11', '2020-11-29', 1),
(12, 'Blue Trail', 'http://www.bluetrail.com', '43 Dog Street', 'Morden', 'Manatoba', 'A2E1U6', 'Canada', '43 Dog Street', 'Morden', 'Manatoba', 'A2E1U6', 'Canada', '', '', '', 'info@bluetrail.com', 1, '2020-11-11', '2020-11-29', 1),
(13, 'Vegetarians United', 'http://www.vegitariansunited.org', '2543 Yaris Drive', 'Kingston', 'Ontario', 'K1W9R3', 'Canada', '2543 Yaris Drive', 'Kingston', 'Ontario', 'K1W9R3', 'Canada', '', '', '', 'info@vegitariansunited.com', 1, '2020-11-11', '2020-11-29', 1),
(14, 'Albert Molds', 'http://albertmolds.com', '24 junction street', 'Edmonton', 'Alberta', 'K1S8B7', 'Canada', '24 junction street', 'Edmonton', 'Alberta', 'K1S8B7', 'Canada', '', '', '', 'info@albertmolds.com', 1, '2020-11-11', '2020-11-29', 1),
(15, 'ascot', 'http://www.ascot.com', '7 ascot', 'Newport', 'Vermont', 'J1S9E3', 'United States', '7 ascot', 'Newport', 'Vermont', 'J1S9E3', 'United States', '', '', '', 'info@ascot.com', 1, '2020-11-11', '2020-11-29', 1);

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
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
