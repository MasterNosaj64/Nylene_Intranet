-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2020 at 07:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `calendar_id` int(11) NOT NULL,
  `event_date` date DEFAULT NULL,
  `start_time` varchar(50) DEFAULT NULL,
  `event_name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `mandatory_attendance` varchar(50) DEFAULT NULL,
  `event_visibility` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'karan', 'http://kjkhjg.com', 'kjghk', '', '', '', '', 'kjghk', 'kjhk', 'kjhkj', 'kjhkjh', 'kjk', '', '', '', '', 1, '2020-11-17', NULL, 1),
(2, 'Madhav', 'http://hhhh.com', 'kjg', 'kjhhk', 'kjhkj', 'kjkhkjh', 'khkjhkjh', 'kjg', 'kjhhk', 'kjhkj', 'kjkhkjh', 'khkjhkjh', '', '', '', '', 1, '2020-11-17', NULL, 1),
(3, 'Anubhav', 'http://kaksha.com', 'kjh', 'kjh', 'kjh', 'kjh', 'kjh', 'kjh', 'kjh', 'kjh', 'kjh', 'kjh', 'Anubhav', 'oooo', 'ooo', 'ooo@o.com', 2, '2020-11-20', NULL, 2),
(4, 'Madhav', 'http://madhav.com', 'xdgf', 'jhgj', 'lkhj', 'lkjl', 'lkkjl', 'xdgf', 'jhgj', 'lkhj', 'lkjl', 'lkkjl', 'Madhav', 'madhav', 'madhav', 'madhav@gmail.com', 1, '2020-11-24', NULL, 1),
(5, 'Wessex', 'http://Wessex.com', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'abc', 'Wessex', 'steel', 'Wessex', 'Wessex@gmail.com', 2, '2020-11-24', NULL, 2),
(6, 'Ooraa', 'http://ooraa.com', '83 wessex ', 'ottawa', 'ON', 'K3G6P7', 'Canada', '83 wessex ', 'ottawa', 'ON', 'K3G6P7', 'Canada', 'debt solution', 'debt', 'debt ', 'oora@debt.com', 2, '2020-11-24', NULL, 2),
(7, 'SRA', 'https://sra.com', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra', 'sra@gmail.com', 2, '2020-11-25', NULL, 2),
(8, 'kjkh', 'http://lkuk', 'kkjjj', 'kjhkj', 'kjhk', 'kjh', 'kjjh', 'kkjjj', 'kjhkj', 'kjhk', 'kjh', 'kjjh', 'lklkjh', 'lkj', 'lkj', 'lkj@gmail.com', 1, '2020-11-30', NULL, 1),
(9, 'hjhhh', 'http://kkjh.com', 'kjkjbh', 'kjh', 'kjhkjh', 'kgkjjh', 'kjkjh', 'kjkjbh', 'kjh', 'kjhkjh', 'kgkjjh', 'kjkjh', 'hhhhh', 'jhhjhh', 'uuhkjkhk', 'jhkjh@gmail.com', 4, '2020-11-30', NULL, 4);

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
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `credit_application_business_form`
--

CREATE TABLE `credit_application_business_form` (
  `credit_application_business_id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `company_address` varchar(250) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `time_current_address` varchar(25) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `date_business_commenced` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `nylene_representative` varchar(50) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `order_pending` int(11) DEFAULT NULL,
  `order_amount` varchar(10) DEFAULT NULL,
  `business_email` varchar(50) DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `account_number` varbinary(150) DEFAULT NULL,
  `bank_address` varchar(100) DEFAULT NULL,
  `bank_email` varchar(100) DEFAULT NULL,
  `bank_contact_name` varchar(50) DEFAULT NULL,
  `bank_fax` varchar(50) DEFAULT NULL,
  `bank_phone` varchar(50) DEFAULT NULL,
  `ref1_company_name` varchar(100) DEFAULT NULL,
  `ref1_company_phone` varchar(100) DEFAULT NULL,
  `ref1_company_contact_name` varchar(50) DEFAULT NULL,
  `ref1_company_fax` varchar(100) DEFAULT NULL,
  `ref1_company_address` varchar(150) DEFAULT NULL,
  `ref1_company_email` varchar(100) DEFAULT NULL,
  `ref2_company_name` varchar(100) DEFAULT NULL,
  `ref2_company_phone` varchar(100) DEFAULT NULL,
  `ref2_company_contact_name` varchar(50) DEFAULT NULL,
  `ref2_company_fax` varchar(100) DEFAULT NULL,
  `ref2_company_address` varchar(150) DEFAULT NULL,
  `ref2_company_email` varchar(100) DEFAULT NULL,
  `ref3_company_name` varchar(100) DEFAULT NULL,
  `ref3_company_phone` varchar(100) DEFAULT NULL,
  `ref3_company_contact_name` varchar(50) DEFAULT NULL,
  `ref3_company_fax` varchar(100) DEFAULT NULL,
  `ref3_company_address` varchar(150) DEFAULT NULL,
  `ref3_company_email` varchar(100) DEFAULT NULL,
  `got_signature` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'Karan karan', 'karan@gmail.com', '2020-11-17 00:00:00', '', ''),
(2, 'Madhav Madhav', 'jhkjghgh@gmail.com', '2020-11-17 00:00:00', '', ''),
(3, 'Anubhav Anubhav', 'Anubhav@h.com', '2020-11-20 00:00:00', '098789898798', '98879'),
(4, 'Madhav Madhav', 'madhav@gmail.com', '2020-11-24 00:00:00', '6138598555', 'hjgjhg'),
(5, 'Shubham Sachdeva', 'shubham@gmail.com', '2020-11-24 00:00:00', '6138648634', 'jhghgjbnjv'),
(6, 'Rajan Vivek', 'Rajan@gmail.com', '2020-11-24 00:00:00', '6161611111', 'tttt'),
(7, 'sra sra', 'sra@gmail.com', '2020-11-25 00:00:00', '88888899141', 'hhhhh');

-- --------------------------------------------------------

--
-- Table structure for table `distributor_quote_form`
--

CREATE TABLE `distributor_quote_form` (
  `distributor_quote_id` int(11) NOT NULL,
  `quote_date` date DEFAULT NULL,
  `quote_num` varchar(50) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `payment_terms` varchar(50) DEFAULT NULL,
  `product_desc` varchar(50) DEFAULT NULL,
  `ltl_quantities` varchar(50) DEFAULT NULL,
  `annual_vol` varchar(50) DEFAULT NULL,
  `special_terms` varchar(50) DEFAULT NULL,
  `OEM` varchar(50) DEFAULT NULL,
  `application` varchar(50) DEFAULT NULL,
  `truck_load` int(11) DEFAULT NULL,
  `range40up` varchar(50) DEFAULT NULL,
  `range2240` varchar(50) DEFAULT NULL,
  `range1122` varchar(50) DEFAULT NULL,
  `range610` varchar(50) DEFAULT NULL,
  `range24` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distributor_quote_form`
--

INSERT INTO `distributor_quote_form` (`distributor_quote_id`, `quote_date`, `quote_num`, `product_name`, `payment_terms`, `product_desc`, `ltl_quantities`, `annual_vol`, `special_terms`, `OEM`, `application`, `truck_load`, `range40up`, `range2240`, `range1122`, `range610`, `range24`) VALUES
(1, '2020-11-17', 'dqwe', 'dwdw', '', '', '', '0', ' N/A', '', '', 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `work_phone` varchar(50) DEFAULT NULL,
  `reports_to` int(11) DEFAULT NULL,
  `date_entered` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL,
  `employee_email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `first_name`, `last_name`, `title`, `department`, `work_phone`, `reports_to`, `date_entered`, `date_modified`, `modified_by`, `username`, `STATUS`, `employee_email`, `password`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', NULL, NULL, NULL, NULL, NULL, 'admin', '0', NULL, 'admin'),
(2, 'Madhav', 'Madhav', 'admin', 'Madhav', '6138598575', 1, '2020-11-18', '2020-11-18', 1, 'madhav', '0', 'madhav@gmail.com', '$2y$10$kii6YU8w9nqSJFVR7XCGhexz5ePUS9.tzaRDblu1C6EoX3kc42/Qu'),
(3, 'Admin', 'Admin', 'admin', 'nylene', '123456789', 2, '2020-11-21', '2020-11-21', 2, 'Admin1', '0', 'admin@gmail.com', '$2y$10$Hnf8Hg0jJW74ycdYWIlL3eumQjQVE8057xaKSJJ/NFOletnlUoReK'),
(4, 'Manager', 'Manager', 'supervisor', 'nylene', '123456789', 2, '2020-11-21', '2020-11-21', 2, 'Manager', '0', 'manager@gmail.com', '$2y$10$BTU1o0Lfg/YBeMTOijWuxua5y5gOuIs76oH80N8IqKk3tDTHZl4ea'),
(5, 'Independent', 'Independent', 'ind_rep', 'nylene', '123456789', 2, '2020-11-21', '2020/11/21', NULL, 'Independent', '0', 'independent', '$2y$10$Cals0CZ9DM7b2Dm/hKg.rObDg63Ccjl8KvRoiPfdzDvt82Z2AKK12'),
(6, 'Member', 'Member', 'sales_rep', 'nylene', '123456789', 2, '2020-11-21', '2020-11-21', 2, 'Member', '0', 'member@gmail.com', '$2y$10$WFdj.txZ9wEMyXTvo8I5W.6Zin4pqmxNMcJypVWpcAeH2keRzzS2m'),
(7, 'Vivek ', 'Shridher', 'sales_rep', 'tax', '8888889914', 4, '2020-11-25', '2020-11-25', 4, 'vivek', '0', 'vivek@gmail.com', '$2y$10$i7FTehCbvk84gmb4YGVygu9WAGgXeONEbSNQyupAuSURd.K63x2Rq');

-- --------------------------------------------------------

--
-- Table structure for table `form_code_table`
--

CREATE TABLE `form_code_table` (
  `form_name` varchar(50) NOT NULL,
  `form_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `form_code_table`
--

INSERT INTO `form_code_table` (`form_name`, `form_number`) VALUES
('sample_form', 1),
('ltl_quote', 2),
('tl_quote', 3),
('distributor_quote_form', 4),
('marketing_request_form', 5),
('credit_application_business_form', 6);

-- --------------------------------------------------------

--
-- Table structure for table `interaction`
--

CREATE TABLE `interaction` (
  `interaction_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `comments` varchar(1024) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `follow_up_type` varchar(50) DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interaction`
--

INSERT INTO `interaction` (`interaction_id`, `company_id`, `customer_id`, `employee_id`, `reason`, `comments`, `date_created`, `status`, `follow_up_type`, `follow_up_date`) VALUES
(1, 1, 1, 1, 'Marketing Request', 'testing', '2020-11-17', '', '', '0000-00-00'),
(2, 2, 2, 1, 'Marketing Request', 'testttt', '2020-11-17', '', '', '0000-00-00'),
(3, 2, 2, 1, 'Distributor Quote', 'test\r\n', '2020-11-17', '', '', '0000-00-00'),
(4, 2, 2, 1, 'Distributor Quote', 'testtttttttt', '2020-11-17', '', '', '0000-00-00'),
(5, 2, 2, 1, 'Sample', 'dfdfdfdfdfdfdfdfdfdfdfdfdfdffdf', '2020-11-17', '', '', '0000-00-00'),
(6, 2, 2, 1, 'Sample', 'testtt\r\n', '2020-11-18', '', NULL, NULL),
(7, 3, 3, 2, 'Marketing Request', 'jkjkhk', '2020-11-20', '', '', '0000-00-00'),
(8, 3, 3, 2, 'Sample', 'tessssssst\r\n', '2020-11-24', '', '', '0000-00-00'),
(9, 5, 5, 2, 'Sample', 'test sample', '2020-11-24', 'open', 'interaction', '2020-12-24'),
(10, 6, 6, 2, 'Sample', 'testing ', '2020-11-24', 'open', 'interaction', '2020-12-24'),
(11, 5, 5, 2, 'Sample', 'please', '2020-11-24', 'open', 'interaction', '2020-12-24'),
(12, 5, 5, 2, 'Sample', 'jkhkjh', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(13, 5, 5, 2, 'Sample', 'lkjlkj', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(14, 5, 5, 2, 'Sample', 'oiu', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(15, 5, 5, 2, 'Sample', 'hhhhh', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(16, 5, 5, 2, 'Sample', 'hshshsh', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(17, 5, 5, 2, 'Sample', 'hhhh', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(18, 7, 7, 2, 'Sample', 'testtttttttttttttttsample', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(19, 7, 7, 2, 'Sample', 'final test\r\n', '2020-11-25', 'open', 'interaction', '2020-12-25'),
(20, 5, 5, 2, 'Sample', '29-11(5:22)', '2020-11-29', 'open', 'interaction', '2020-12-29'),
(21, 5, 5, 2, 'Sample', '29-11(5:34)', '2020-11-29', 'open', 'interaction', '2020-12-29'),
(22, 5, 5, 2, 'Sample', '29-11(8:12)', '2020-11-29', 'open', 'interaction', '2020-12-29'),
(23, 5, 5, 2, 'Sample', '269-11(8:32)', '2020-11-29', 'open', 'interaction', '2020-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `interaction_relational_form`
--

CREATE TABLE `interaction_relational_form` (
  `interaction_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `form_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interaction_relational_form`
--

INSERT INTO `interaction_relational_form` (`interaction_id`, `form_id`, `form_type`) VALUES
(3, 1, 4),
(6, 33, 1),
(7, 1, 5),
(6, 34, 1),
(9, 35, 1),
(9, 0, 1),
(9, 0, 1),
(10, 36, 1),
(10, 0, 1),
(10, 0, 1),
(11, 37, 1),
(11, 0, 1),
(11, 0, 1),
(12, 38, 1),
(13, 39, 1),
(14, 40, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(14, 0, 1),
(15, 41, 1),
(15, 0, 1),
(16, 42, 1),
(16, 0, 1),
(17, 43, 1),
(18, 44, 1),
(18, 0, 1),
(18, 0, 1),
(18, 0, 1),
(18, 0, 1),
(19, 45, 1),
(19, 0, 1),
(19, 0, 1),
(19, 0, 1),
(16, 0, 1),
(16, 0, 1),
(20, 46, 1),
(20, 0, 1),
(20, 0, 1),
(21, 47, 1),
(21, 0, 1),
(22, 48, 1),
(23, 49, 1),
(23, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ltl_quote`
--

CREATE TABLE `ltl_quote` (
  `ltl_quote_id` int(11) NOT NULL,
  `quote_date` date DEFAULT NULL,
  `quote_num` varchar(50) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `payment_terms` varchar(50) DEFAULT NULL,
  `product_desc` varchar(50) DEFAULT NULL,
  `ltl_quantities` varchar(50) DEFAULT NULL,
  `annual_vol` varchar(50) DEFAULT NULL,
  `special_terms` varchar(50) DEFAULT NULL,
  `OEM` varchar(50) DEFAULT NULL,
  `application` varchar(50) DEFAULT NULL,
  `truck_load` int(11) DEFAULT NULL,
  `range1522` varchar(50) DEFAULT NULL,
  `range1121` varchar(50) DEFAULT NULL,
  `range510` varchar(50) DEFAULT NULL,
  `range25` varchar(50) DEFAULT NULL,
  `range12` varchar(50) DEFAULT NULL,
  `range5` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_request_form`
--

CREATE TABLE `marketing_request_form` (
  `marketing_request_id` int(11) NOT NULL,
  `sales_territory` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `market_segment` varchar(50) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `name_project_or_piece` varchar(250) DEFAULT NULL,
  `type_of_project` varchar(250) DEFAULT NULL,
  `is_project_new` int(11) DEFAULT NULL,
  `if_piece_new` varchar(250) DEFAULT NULL,
  `target_audiance` varchar(250) DEFAULT NULL,
  `audiance_personal_info` varchar(250) DEFAULT NULL,
  `purpose` varchar(250) DEFAULT NULL,
  `key_message` varchar(250) DEFAULT NULL,
  `supporting_info` varchar(250) DEFAULT NULL,
  `needed_photography` varchar(250) DEFAULT NULL,
  `is_photography_needed` varchar(250) DEFAULT NULL,
  `estimated_quantity` varchar(250) DEFAULT NULL,
  `means_of_delivery` varchar(250) DEFAULT NULL,
  `date_needed` date DEFAULT NULL,
  `available_budget` varchar(250) DEFAULT NULL,
  `cost_center_number` varchar(250) DEFAULT NULL,
  `requester_name` varchar(50) DEFAULT NULL,
  `brochure` int(50) DEFAULT NULL,
  `ppt` int(50) DEFAULT NULL,
  `fact_sheet` int(50) DEFAULT NULL,
  `video` int(50) DEFAULT NULL,
  `direct_mail` int(50) DEFAULT NULL,
  `web` int(50) DEFAULT NULL,
  `page` int(50) DEFAULT NULL,
  `section` int(50) DEFAULT NULL,
  `blog` int(50) DEFAULT NULL,
  `landing_page` int(50) DEFAULT NULL,
  `updt` int(50) DEFAULT NULL,
  `graphic` int(50) DEFAULT NULL,
  `tradeshow` int(50) DEFAULT NULL,
  `promotional_item` int(50) DEFAULT NULL,
  `print_aid` int(50) DEFAULT NULL,
  `press_release` int(50) DEFAULT NULL,
  `other_type_of_project` text DEFAULT NULL,
  `prospective_customers` int(50) DEFAULT NULL,
  `engineers` int(50) DEFAULT NULL,
  `procurement_managers` int(50) DEFAULT NULL,
  `current_customers` int(50) DEFAULT NULL,
  `plant_managers` int(50) DEFAULT NULL,
  `other_audience` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marketing_request_form`
--

INSERT INTO `marketing_request_form` (`marketing_request_id`, `sales_territory`, `phone`, `market_segment`, `email`, `request_date`, `name_project_or_piece`, `type_of_project`, `is_project_new`, `if_piece_new`, `target_audiance`, `audiance_personal_info`, `purpose`, `key_message`, `supporting_info`, `needed_photography`, `is_photography_needed`, `estimated_quantity`, `means_of_delivery`, `date_needed`, `available_budget`, `cost_center_number`, `requester_name`, `brochure`, `ppt`, `fact_sheet`, `video`, `direct_mail`, `web`, `page`, `section`, `blog`, `landing_page`, `updt`, `graphic`, `tradeshow`, `promotional_item`, `print_aid`, `press_release`, `other_type_of_project`, `prospective_customers`, `engineers`, `procurement_managers`, `current_customers`, `plant_managers`, `other_audience`) VALUES
(1, 'jhfj', 'jghk', 'anubhav', 'jg@kjh.omug', '2020-12-02', 'kjlk', 'lkjlkj', 0, '', NULL, 'nnhg', 'jhgjhg', 'kjjhkjkh', 'kjhkjh', 'lkklkhjhjl', 'Yes', 'ljknnkj', 'kjhkjh', '2020-12-05', 'iiuoi', 'oiuoiuoiu', 'anubhav', 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, '', 1, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sample_form`
--

CREATE TABLE `sample_form` (
  `sample_form_id` int(11) NOT NULL,
  `date_submitted` date DEFAULT NULL,
  `m_code` varchar(50) DEFAULT NULL,
  `customer_code` varchar(50) DEFAULT NULL,
  `credit_app_submitted` int(50) DEFAULT NULL,
  `business_case` varchar(1000) DEFAULT NULL,
  `match_sample_sub` int(50) DEFAULT NULL,
  `match_data_sheet` int(50) DEFAULT NULL,
  `match_description` int(50) DEFAULT NULL,
  `material_description` varchar(1000) NOT NULL,
  `customer_proc` varchar(50) DEFAULT NULL,
  `customer_supplier` varchar(50) DEFAULT NULL,
  `finished_good_app` varchar(50) DEFAULT NULL,
  `annual_vol` varchar(50) DEFAULT NULL,
  `current_resin_system` varchar(50) DEFAULT NULL,
  `target_price` varchar(50) DEFAULT NULL,
  `melt_reqs` varchar(50) DEFAULT NULL,
  `current_filler_sys` varchar(50) DEFAULT NULL,
  `colors` varchar(50) DEFAULT NULL,
  `known_additives` varchar(50) DEFAULT NULL,
  `ul_reqs` varchar(50) DEFAULT NULL,
  `uv_reqs` varchar(50) DEFAULT NULL,
  `auto_reqs` varchar(50) DEFAULT NULL,
  `fda_reqs` varchar(50) DEFAULT NULL,
  `color_specs` varchar(50) DEFAULT NULL,
  `response_date` varchar(50) DEFAULT NULL,
  `prod_rec` int(50) DEFAULT NULL,
  `stock_prod_qty` int(50) DEFAULT NULL,
  `other_doc` varchar(50) DEFAULT NULL,
  `sds` int(50) DEFAULT NULL,
  `coa` int(50) DEFAULT NULL,
  `sample_qty` varchar(50) DEFAULT NULL,
  `sample_req_date` varchar(50) DEFAULT NULL,
  `data_sheet` int(50) DEFAULT NULL,
  `sample_price` varchar(50) DEFAULT NULL,
  `sample_frt` varchar(50) DEFAULT NULL,
  `other_contact_1` varchar(50) DEFAULT NULL,
  `other_contact_2` varchar(50) DEFAULT NULL,
  `other_contact_3` varchar(50) DEFAULT NULL,
  `other_contact_4` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sample_form`
--

INSERT INTO `sample_form` (`sample_form_id`, `date_submitted`, `m_code`, `customer_code`, `credit_app_submitted`, `business_case`, `match_sample_sub`, `match_data_sheet`, `match_description`, `material_description`, `customer_proc`, `customer_supplier`, `finished_good_app`, `annual_vol`, `current_resin_system`, `target_price`, `melt_reqs`, `current_filler_sys`, `colors`, `known_additives`, `ul_reqs`, `uv_reqs`, `auto_reqs`, `fda_reqs`, `color_specs`, `response_date`, `prod_rec`, `stock_prod_qty`, `other_doc`, `sds`, `coa`, `sample_qty`, `sample_req_date`, `data_sheet`, `sample_price`, `sample_frt`, `other_contact_1`, `other_contact_2`, `other_contact_3`, `other_contact_4`) VALUES
(33, '2020-11-17', 'A-Auto', '2', 0, 'jkkjhkjhk', 1, 0, 0, 'jhkjhkjh', 'lkjlkj', 'lkjlkj', 'lkjlkj', 'lkjlkj', 'llkjlkj', 'llkljlkj', 'lklkjl', '0', 'lkjlkjl', 'lkjlkj', 'llkjlkj', 'lkjlkj', 'lkjlkjl', 'lkjlkj', 'llkjlkj', '0000-00-00', 0, 1, '', 1, 0, '0', '0000-00-00', 1, '1777', '77777', 'kjh', 'kjh', 'kjh', 'kjhkjh'),
(34, '2020-11-17', '', '', 0, '', 1, 0, 0, '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0000-00-00', 0, 1, '', 1, 0, '0', '0000-00-00', 1, '', '', '', '', '', ''),
(35, '2020-11-23', NULL, '5', 0, NULL, 1, 1, 0, 'kjjggkh', 'makakaka', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '0000-00-00', 1, 1, '', 1, 1, '', '0', 0, '', '', NULL, NULL, NULL, NULL),
(36, '2020-11-23', NULL, '6', 0, 'dddddddd', 0, 0, 1, 'hard', '1', '', '2', '3', '4', '5', '6', NULL, '8', '9', '11', '10', '12', '13', '14', '2020', 1, 0, '15', 1, 1, '16', '0', 1, '17', '18', NULL, NULL, NULL, NULL),
(37, '2020-11-23', NULL, '5', 0, '', 1, 1, 1, '2', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(38, '2020-11-24', 'A-Auto', '5', 0, '1', 1, 1, 1, '2', '3', '4', '5', '6', '7', '8', '9', '0', '11', '12', '14', '13', '15', '16', '17', '2020', 1, 1, '18', 1, 1, '19', '2020', 1, '20', '21', '22', '23', '24', '25'),
(39, '2020-11-24', 'A-Auto', '5', 0, '1', 1, 1, 1, '2', '3', '4', '5', '6', '7', '8', '9', NULL, '11', '12', '14', '13', '15', '16', '17', '2020', 1, 1, '18', 1, 1, '19', '2020', 1, '20', '21', '22', '23', '24', '25'),
(40, '2020-11-24', NULL, '5', 0, '', 1, 1, 1, '2', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(41, '2020-11-24', NULL, '5', 0, '', 0, 0, 0, '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 0, 0, '', 0, 0, '', '0', 0, '', '', NULL, NULL, NULL, NULL),
(42, '2020-11-24', NULL, '5', 0, 'khjhjkhjkjhkhjk', 1, 1, 1, '2', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(43, '2020-11-24', 'A-Auto', '5', 0, '1', 1, 1, 1, '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '13', '15', '16', '17', '2020', 1, 1, '18', 1, 1, '19', '2020', 1, '20', '21', '22', '23', '24', '25'),
(44, '2020-11-24', NULL, '7', 0, '', 1, 1, 1, 'b', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(45, '2020-11-24', NULL, '7', 1, '', 1, 1, 1, 'b', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(46, '2020-11-28', NULL, '5', 0, 'aaaa', 1, 1, 1, 'b', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(47, '2020-11-28', NULL, '5', 1, '', 1, 1, 1, 'b', 'c1', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '2020', 1, 1, '', 1, 1, '', '0', 1, '', '', NULL, NULL, NULL, NULL),
(48, '2020-11-29', 'A-Auto', '5', 1, 'a', 1, 1, 1, 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'n', 'm', 'o', 'p', 'q', '2020', 1, 1, 'r', 1, 1, '0', '2020', 1, 't', 'u', 'v', 'w', 'x', 'y'),
(49, '2020-11-29', NULL, '5', 1, 'a ', 1, 1, 1, 'b', ' c', 'd', 'e', 'f', ' g', 'h ', ' i', NULL, ' k', ' l', ' n', 'm', ' ojj', 'p', ' q', '2020', 1, 1, ' r', 1, 1, ' 0', '2020', 1, ' t', ' u', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tl_quote`
--

CREATE TABLE `tl_quote` (
  `tl_quote_id` int(11) NOT NULL,
  `quote_date` date DEFAULT NULL,
  `quote_num` varchar(50) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `payment_terms` varchar(50) DEFAULT NULL,
  `product_desc` varchar(50) DEFAULT NULL,
  `ltl_quantities` varchar(50) DEFAULT NULL,
  `annual_vol` varchar(50) DEFAULT NULL,
  `special_terms` varchar(50) DEFAULT NULL,
  `OEM` varchar(50) DEFAULT NULL,
  `application` varchar(50) DEFAULT NULL,
  `truck_load` int(11) DEFAULT NULL,
  `range40plus` varchar(50) DEFAULT NULL,
  `range2240` varchar(50) DEFAULT NULL,
  `range1022` varchar(50) DEFAULT NULL,
  `range610` varchar(50) DEFAULT NULL,
  `range46` varchar(50) DEFAULT NULL,
  `range24` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`calendar_id`),
  ADD KEY `FK_calendar_created_by` (`employee_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `Fk_created_by` (`created_by`),
  ADD KEY `FK_assigned_to` (`assigned_to`);

--
-- Indexes for table `company_relational_customer`
--
ALTER TABLE `company_relational_customer`
  ADD KEY `FK_company_id_customer_company` (`company_id`),
  ADD KEY `FK_customer_id_customer_company` (`customer_id`);

--
-- Indexes for table `credit_application_business_form`
--
ALTER TABLE `credit_application_business_form`
  ADD PRIMARY KEY (`credit_application_business_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `distributor_quote_form`
--
ALTER TABLE `distributor_quote_form`
  ADD PRIMARY KEY (`distributor_quote_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `FK_modified_by` (`modified_by`),
  ADD KEY `FK_reports_to` (`reports_to`);

--
-- Indexes for table `interaction`
--
ALTER TABLE `interaction`
  ADD PRIMARY KEY (`interaction_id`),
  ADD KEY `FK_company_id` (`company_id`),
  ADD KEY `FK_employee_id` (`employee_id`);

--
-- Indexes for table `interaction_relational_form`
--
ALTER TABLE `interaction_relational_form`
  ADD KEY `FK_interaction_id` (`interaction_id`);

--
-- Indexes for table `ltl_quote`
--
ALTER TABLE `ltl_quote`
  ADD PRIMARY KEY (`ltl_quote_id`);

--
-- Indexes for table `marketing_request_form`
--
ALTER TABLE `marketing_request_form`
  ADD PRIMARY KEY (`marketing_request_id`);

--
-- Indexes for table `sample_form`
--
ALTER TABLE `sample_form`
  ADD PRIMARY KEY (`sample_form_id`);

--
-- Indexes for table `tl_quote`
--
ALTER TABLE `tl_quote`
  ADD PRIMARY KEY (`tl_quote_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `calendar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `credit_application_business_form`
--
ALTER TABLE `credit_application_business_form`
  MODIFY `credit_application_business_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `distributor_quote_form`
--
ALTER TABLE `distributor_quote_form`
  MODIFY `distributor_quote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `interaction`
--
ALTER TABLE `interaction`
  MODIFY `interaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ltl_quote`
--
ALTER TABLE `ltl_quote`
  MODIFY `ltl_quote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketing_request_form`
--
ALTER TABLE `marketing_request_form`
  MODIFY `marketing_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sample_form`
--
ALTER TABLE `sample_form`
  MODIFY `sample_form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tl_quote`
--
ALTER TABLE `tl_quote`
  MODIFY `tl_quote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `FK_calendar_created_by` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `FK_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `company_relational_customer`
--
ALTER TABLE `company_relational_customer`
  ADD CONSTRAINT `FK_company_id_customer_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_customer_id_customer_company` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `FK_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_reports_to` FOREIGN KEY (`reports_to`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `interaction`
--
ALTER TABLE `interaction`
  ADD CONSTRAINT `FK_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `interaction_relational_form`
--
ALTER TABLE `interaction_relational_form`
  ADD CONSTRAINT `FK_interaction_id` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`interaction_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
