CREATE TABLE employee(
    employee_id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) DEFAULT NULL,
    last_name VARCHAR(50) DEFAULT NULL,
    title VARCHAR(50) DEFAULT NULL,
    department VARCHAR(50) DEFAULT NULL,
    work_phone VARCHAR(50) DEFAULT NULL,
    reports_to INT,
    date_entered VARCHAR(50) DEFAULT NULL,
    date_modified VARCHAR(50) DEFAULT NULL,
    modified_by INT,
    username VARCHAR(50) DEFAULT NULL,
    STATUS VARCHAR(50) DEFAULT NULL,
    employee_email VARCHAR(50) DEFAULT NULL,
	password VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY(employee_id)
) DEFAULT CHARSET = utf8;

CREATE TABLE interaction(
    interaction_id INT NOT NULL AUTO_INCREMENT,
    company_id INT,
	customer_id INT,
    employee_id INT,
	reason VARCHAR(50) DEFAULT NULL,
    comments VARCHAR(1024) DEFAULT NULL,
    date_created DATE,
	status VARCHAR(15) NOT NULL,
	follow_up_type VARCHAR(50),
	follow_up_date DATE,
    PRIMARY KEY(interaction_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE marketing_request_form(
    requester_name VARCHAR(50) NULL DEFAULT NULL,
    marketing_request_id INT NOT NULL AUTO_INCREMENT,
    sales_territory VARCHAR(50) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    market_segment VARCHAR(50) DEFAULT NULL,
    email VARCHAR(250) DEFAULT NULL,
    request_date DATE DEFAULT NULL,
    name_project_or_piece VARCHAR(250) DEFAULT NULL,
    type_of_project VARCHAR(250) DEFAULT NULL,
    brochure INT(50) NULL DEFAULT NULL,
    ppt INT(50) NULL DEFAULT NULL,
    fact_sheet INT(50) NULL DEFAULT NULL,
    video INT(50) NULL DEFAULT NULL,
    direct_mail INT(50) NULL DEFAULT NULL,
    web INT(50) NULL DEFAULT NULL,
    page INT(50) NULL DEFAULT NULL,
    section INT(50) NULL DEFAULT NULL,
    blog INT(50) NULL DEFAULT NULL,
    landing_page INT(50) NULL DEFAULT NULL,
    updt INT(50) NULL DEFAULT NULL,
    graphic INT(50) NULL DEFAULT NULL,
    tradeshow INT(50) NULL DEFAULT NULL,
    promotional_item INT(50) NULL DEFAULT NULL,
    print_aid INT(50) NULL DEFAULT NULL,
    press_release INT(50) NULL DEFAULT NULL,
    other_type_of_project TEXT NULL DEFAULT NULL,
    is_project_new INT DEFAULT NULL,
    if_piece_new VARCHAR(250) DEFAULT NULL,
    target_audiance VARCHAR(250) DEFAULT NULL,
    prospective_customers INT(50) NULL DEFAULT NULL,
    engineers INT(50) NULL DEFAULT NULL,
    procurement_managers INT(50) NULL DEFAULT NULL,
    current_customers INT(50) NULL DEFAULT NULL,
    plant_managers INT(50) NULL DEFAULT NULL,
    other_audience TEXT NULL DEFAULT NULL,
    audiance_personal_info VARCHAR(250) DEFAULT NULL,
    purpose VARCHAR(250) DEFAULT NULL,
    key_message VARCHAR(250) DEFAULT NULL,
    supporting_info VARCHAR(250) DEFAULT NULL,
    needed_photography VARCHAR(250) DEFAULT NULL,
    is_photography_needed VARCHAR(250) DEFAULT NULL,
    estimated_quantity VARCHAR(250) DEFAULT NULL,
    means_of_delivery VARCHAR(250) DEFAULT NULL,
    date_needed DATE DEFAULT NULL,
    available_budget VARCHAR(250) DEFAULT NULL,
    cost_center_number VARCHAR(250) DEFAULT NULL,
    PRIMARY KEY(marketing_request_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE distributor_quote_form(
    distributor_quote_id INT NOT NULL AUTO_INCREMENT,
    quote_date DATE DEFAULT NULL,
    quote_num VARCHAR(50) DEFAULT NULL,
    product_name VARCHAR(50) DEFAULT NULL,
    payment_terms VARCHAR(50) DEFAULT NULL,
    product_desc VARCHAR(50) DEFAULT NULL,
    ltl_quantities VARCHAR(50) DEFAULT NULL,
    annual_vol VARCHAR(50) DEFAULT NULL,
    special_terms VARCHAR(50) DEFAULT NULL,
    OEM VARCHAR(50) DEFAULT NULL,
    application VARCHAR(50) DEFAULT NULL,
    truck_load INT DEFAULT NULL,
	range40up VARCHAR(50) DEFAULT NULL,
    range2240 VARCHAR(50) DEFAULT NULL,
    range1122 VARCHAR(50) DEFAULT NULL,
    range610 VARCHAR(50) DEFAULT NULL,
    range24 VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY(distributor_quote_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE tl_quote(
    tl_quote_id INT NOT NULL AUTO_INCREMENT,
    quote_date DATE DEFAULT NULL,
    quote_num VARCHAR(50) DEFAULT NULL,
    product_name VARCHAR(50) DEFAULT NULL,
    payment_terms VARCHAR(50) DEFAULT NULL,
    product_desc VARCHAR(50) DEFAULT NULL,
    ltl_quantities VARCHAR(50) DEFAULT NULL,
    annual_vol VARCHAR(50) DEFAULT NULL,
    special_terms VARCHAR(50) DEFAULT NULL,
    OEM VARCHAR(50) DEFAULT NULL,
    application VARCHAR(50) DEFAULT NULL,
    truck_load INT DEFAULT NULL,
    range40plus VARCHAR(50) DEFAULT NULL,
	range2240 VARCHAR(50) DEFAULT NULL,
    range1022 VARCHAR(50) DEFAULT NULL,
    range610 VARCHAR(50) DEFAULT NULL,
    range46 VARCHAR(50) DEFAULT NULL,
    range24 VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY(tl_quote_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE ltl_quote(
    ltl_quote_id INT NOT NULL AUTO_INCREMENT,
    quote_date DATE DEFAULT NULL,
    quote_num VARCHAR(50) DEFAULT NULL,
    product_name VARCHAR(50) DEFAULT NULL,
    payment_terms VARCHAR(50) DEFAULT NULL,
    product_desc VARCHAR(50) DEFAULT NULL,
    ltl_quantities VARCHAR(50) DEFAULT NULL,
    annual_vol VARCHAR(50) DEFAULT NULL,
    special_terms VARCHAR(50) DEFAULT NULL,
    OEM VARCHAR(50) DEFAULT NULL,
    application VARCHAR(50) DEFAULT NULL,
    truck_load INT DEFAULT NULL,
    range1522 VARCHAR(50) DEFAULT NULL,
    range1121 VARCHAR(50) DEFAULT NULL,
    range510 VARCHAR(50) DEFAULT NULL,
    range25 VARCHAR(50) DEFAULT NULL,
    range12 VARCHAR(50) DEFAULT NULL,
    range5 VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY(ltl_quote_id)
) DEFAULT CHARSET = utf8; 

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
  `response_date` date DEFAULT NULL,
  `prod_rec` int(50) DEFAULT NULL,
  `stock_prod_qty` int(50) DEFAULT NULL,
  `other_doc` varchar(50) DEFAULT NULL,
  `sds` int(50) DEFAULT NULL,
  `coa` int(50) DEFAULT NULL,
  `sample_qty` varchar(50) DEFAULT NULL,
  `sample_req_date` date DEFAULT NULL,
  `data_sheet` int(50) DEFAULT NULL,
  `sample_price` varchar(50) DEFAULT NULL,
  `sample_frt` varchar(50) DEFAULT NULL,
  `other_contact_1` varchar(50) DEFAULT NULL,
  `other_contact_2` varchar(50) DEFAULT NULL,
  `other_contact_3` varchar(50) DEFAULT NULL,
  `other_contact_4` varchar(50) DEFAULT NULL,
   PRIMARY KEY(sample_form_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE credit_application_business_form(
credit_application_business_id INT NOT NULL AUTO_INCREMENT,
company_name VARCHAR(100) DEFAULT NULL,
company_address VARCHAR(250) DEFAULT NULL,
contact_name VARCHAR(50) DEFAULT NULL,
time_current_address VARCHAR(25) DEFAULT NULL,
title VARCHAR(25) DEFAULT NULL,
date_business_commenced DATE DEFAULT NULL,
phone VARCHAR(15) DEFAULT NULL,
nylene_representative VARCHAR(50) DEFAULT NULL,
fax VARCHAR(100) DEFAULT NULL,
order_pending INT DEFAULT NULL,
order_amount VARCHAR(10) DEFAULT NULL,
business_email VARCHAR(50) DEFAULT NULL,
bank_name VARCHAR(50) DEFAULT NULL,
account_number VARBINARY(150) DEFAULT NULL,
bank_address VARCHAR(100) DEFAULT NULL,
bank_email  VARCHAR(100) DEFAULT NULL,
bank_contact_name VARCHAR(50) DEFAULT NULL,
bank_fax VARCHAR(50) DEFAULT NULL,
bank_phone VARCHAR(50) DEFAULT NULL,
ref1_company_name VARCHAR(100) DEFAULT NULL,
ref1_company_phone VARCHAR(100) DEFAULT NULL,
ref1_company_contact_name VARCHAR(50) DEFAULT NULL,
ref1_company_fax VARCHAR(100) DEFAULT NULL,
ref1_company_address VARCHAR(150) DEFAULT NULL,
ref1_company_email VARCHAR(100) DEFAULT NULL, 
ref2_company_name VARCHAR(100) DEFAULT NULL,
ref2_company_phone VARCHAR(100) DEFAULT NULL,
ref2_company_contact_name VARCHAR(50) DEFAULT NULL,
ref2_company_fax VARCHAR(100) DEFAULT NULL,
ref2_company_address VARCHAR(150) DEFAULT NULL,
ref2_company_email VARCHAR(100) DEFAULT NULL, 
ref3_company_name VARCHAR(100) DEFAULT NULL,
ref3_company_phone VARCHAR(100) DEFAULT NULL,
ref3_company_contact_name VARCHAR(50) DEFAULT NULL,
ref3_company_fax VARCHAR(100) DEFAULT NULL,
ref3_company_address VARCHAR(150) DEFAULT NULL,
ref3_company_email VARCHAR(100) DEFAULT NULL,
got_signature INT DEFAULT NULL,
credit_date DATE DEFAULT NULL,
PRIMARY KEY(credit_application_business_id)
) DEFAULT CHARSET = utf8;

CREATE TABLE `company`(
    `company_id` INT NOT NULL AUTO_INCREMENT,
	`company_name` VARCHAR(255) DEFAULT NULL,
    `website` VARCHAR(255) DEFAULT NULL,
    `billing_address_street` VARCHAR(150) DEFAULT NULL,
    `billing_address_city` VARCHAR(100) DEFAULT NULL,
    `billing_address_state` VARCHAR(100) DEFAULT NULL,
    `billing_address_postalcode` VARCHAR(20) DEFAULT NULL,
    `billing_address_country` VARCHAR(255) DEFAULT NULL,
    `shipping_address_street` VARCHAR(150) DEFAULT NULL,
    `shipping_address_city` VARCHAR(100) DEFAULT NULL,
    `shipping_address_state` VARCHAR(100) DEFAULT NULL,
    `shipping_address_postalcode` VARCHAR(20) DEFAULT NULL,
    `shipping_address_country` VARCHAR(255) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `type` VARCHAR(50) DEFAULT NULL,
    `industry` VARCHAR(50) DEFAULT NULL,
    `company_email` VARCHAR(100) DEFAULT NULL,
    `assigned_to` int ,
    `date_created` DATE NOT NULL,
    `date_modified` DATE DEFAULT NULL,
    `created_by` int,
    PRIMARY KEY(company_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE `customer`(
    `customer_id` INT NOT NULL AUTO_INCREMENT,
    `customer_name` VARCHAR(255) DEFAULT NULL,
	`customer_email` VARCHAR(255) DEFAULT NULL,
    `date_created` DATETIME NOT NULL,
    `customer_phone` VARCHAR(100) DEFAULT NULL,
		customer_fax VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY(customer_id)
) DEFAULT CHARSET = utf8; 

CREATE TABLE `company_relational_customer`(
    `company_id` INT NOT NULL,
    `customer_id` INT NOT NULL
) DEFAULT CHARSET = utf8; 

CREATE TABLE interaction_relational_form(
    `interaction_id` INT NOT NULL,
    `form_id` INT NOT NULL,
    form_type INT NOT NULL
) DEFAULT CHARSET = utf8; 

CREATE TABLE form_code_table(
    form_name VARCHAR(50) NOT NULL,
    form_number INT NOT NULL
) DEFAULT CHARSET = utf8;

CREATE TABLE calendar(
    calendar_id INT NOT NULL AUTO_INCREMENT,
    event_date DATE DEFAULT NULL,
    start_time VARCHAR(50) DEFAULT NULL,
    event_name VARCHAR(50) DEFAULT NULL,
    description VARCHAR(100) DEFAULT NULL,
    date_created DATE DEFAULT NULL,
	date_modified DATE DEFAULT NULL,
	employee_id INT NOT NULL,
	modified_by INT DEFAULT NULL,
    mandatory_attendance VARCHAR(50) DEFAULT NULL,
	event_visibility VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY(calendar_id)
) DEFAULT CHARSET = utf8; 

 ALTER TABLE employee Add CONSTRAINT FK_modified_by FOREIGN KEY (modified_by) REFERENCES employee(employee_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;
 ALTER TABLE employee Add CONSTRAINT FK_reports_to FOREIGN KEY (reports_to) REFERENCES employee(employee_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;
 ALTER TABLE interaction Add CONSTRAINT FK_company_id FOREIGN KEY (company_id) REFERENCES company(company_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;
 ALTER TABLE interaction Add CONSTRAINT FK_employee_id FOREIGN KEY (employee_id) REFERENCES employee(employee_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;
	
ALTER TABLE calendar Add CONSTRAINT FK_calendar_created_by FOREIGN KEY (employee_id) REFERENCES employee(employee_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;

  ALTER TABLE company Add CONSTRAINT Fk_created_by FOREIGN KEY (created_by) REFERENCES employee(employee_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;
   ALTER TABLE company Add CONSTRAINT FK_assigned_to FOREIGN KEY (assigned_to) REFERENCES employee(employee_id) ON DELETE CASCADE
    ON UPDATE RESTRICT;

  
  ALTER TABLE company_relational_customer Add CONSTRAINT FK_company_id_customer_company FOREIGN KEY (company_id) REFERENCES company(company_id) ON DELETE CASCADE
  ;
  ALTER TABLE company_relational_customer Add CONSTRAINT FK_customer_id_customer_company FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
   ;
  ALTER TABLE interaction_relational_form Add CONSTRAINT FK_interaction_id FOREIGN KEY (interaction_id) REFERENCES interaction(interaction_id) ON DELETE CASCADE
  ;
  
  INSERT INTO  form_code_table
VALUES ("sample_form", 1);
  INSERT INTO  form_code_table
VALUES ("ltl_quote", 2);
  INSERT INTO  form_code_table
VALUES ("tl_quote", 3);
  INSERT INTO  form_code_table
VALUES ("distributor_quote_form", 4);
  INSERT INTO  form_code_table
VALUES ("marketing_request_form", 5);
 INSERT INTO form_code_table
VALUES ("credit_application_business_form", 6);


ALTER TABLE `sample_form`
  MODIFY `sample_form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

-- Employee Data
INSERT INTO `employee` (`employee_id`, `first_name`, `last_name`, `title`, `department`, `work_phone`, `reports_to`, `date_entered`, `date_modified`, `modified_by`, `username`, `STATUS`, `employee_email`, `password`) VALUES
(9, 'admin', 'admin', 'admin', 'admin', NULL, 9, NULL, '2020/12/08', 9, 'admin', '0', 'admin@nylene.com', '$2y$10$sMIU1N9.NvqwlHFZIy4u4On9UVQMTahliRlbdI0BF0OPFACRFHn7e'),
(10, 'Supervisor', '1', 'supervisor', '', '1234567890', 9, '2020-12-08', '2020/12/08', 9, 'supervisor1', '0', 'Supervisor1@nylene.com', '$2y$10$eLqbr2UySwK9mDSUV0fqlujywNO53UXzcqqoFe2CfDIX0uI36yNPK'),
(11, 'Supervisor', '2', 'supervisor', '', '1111111111', 9, '2020-12-08', '2020-12-08', 9, 'supervisor2', '0', 'supervisor2@nylene.com', '$2y$10$qRwKOIRjEnrj8QIqNOaVaOfziFt82ezBQ0So.A75uXR/FJQjlfljO'),
(12, 'SalesRep', '1', 'sales_rep', '', '1234567890', 10, '2020-12-08', '2020-12-08', 9, 'salesrep1', '0', 'salesrep1@nylene.com', '$2y$10$dl9zsTIQqxLfj.G/e8OPhu7ztECy6uR3SiePgVR1tDfG1dsi.uNxS'),
(13, 'SalesRep', '2', 'sales_rep', '', '123456789', 11, '2020-12-08', '2020-12-08', 9, 'salesrep2', '0', 'salesrep2@nylene.com', '$2y$10$x/6moexNFeStqULt3mZiYui4MOYx.aTmjH5Zf7gdDpYtdyOybnt3O'),
(14, 'IndeSalesRep', 'IndeSalesRep', 'ind_rep', '', '1234567890', 11, '2020-12-08', '2020-12-08', 9, 'indesalesrep', '0', 'indesalesrep@nylene.com', '$2y$10$7sEQAfA78iSqmbw/0A2yCOczvChSuK9BnnMmngRWS20AB.y1s0Gge');

-- Company Data
INSERT INTO `company` (`company_id`, `company_name`, `website`, `billing_address_street`, `billing_address_city`, `billing_address_state`, `billing_address_postalcode`, `billing_address_country`, `shipping_address_street`, `shipping_address_city`, `shipping_address_state`, `shipping_address_postalcode`, `shipping_address_country`, `description`, `type`, `industry`, `company_email`, `assigned_to`, `date_created`, `date_modified`, `created_by`) VALUES
(2, 'Spencers', 'http://www.Spencers.com', '286 Gendron', 'Magog', 'Quebec', 'S5E2W4', 'Canada', '286 Gendron', 'Magog', 'Quebec', 'S5E2W4', 'Canada', '', '', '', 'info@spencers.com', 12, '2020-11-11', '2020-11-29', 12),
(3, 'Valley Fields', 'http://www.valleyfields.org', '234 Fake Street', 'Ottawa', 'Ontario', 'K1G3B7', 'Canada', '234 Fake Street', 'Ottawa', 'Ontario', 'K1G3B7', 'Canada', '', '', '', 'info@valleyfields.com', 10, '2020-11-11', '2020-11-29', 10),
(4, 'Algonquin College', 'https://www.algonquincollege.com', '1385 Woodroffe Ave', 'Ottawa', 'Ontario', 'K2G1V8', 'Canada', '1385 Woodroffe Ave', 'Ottawa', 'Ontario', 'K2G1V8', 'Canada', '', '', '', 'info@algonquin.com', 10, '2020-11-11', '2020-11-29', 10),
(5, 'Weggers', 'http://weg.com', '2531 Views Drive', 'Montreal', 'Quebec', 'J1A0R4', 'Canada', '2531 Views Drive', 'Montreal', 'Quebec', 'J1A0R4', 'Canada', '', '', '', 'info@weggers.com', 12, '2020-11-11', '2020-12-05', 12),
(6, 'Treasure Trove', 'http://treasuretrove.com', '182 Larry Avenue', 'Lennoxville', 'Quebec', 'J1Q3R5', 'Canada', '182 Larry Avenue', 'Lennoxville', 'Quebec', 'J1Q3R5', 'Canada', '', '', '', 'info@treasuretrove.com', 14, '2020-11-11', '2020-11-29', 14),
(7, 'Canopy Molds', 'http://canopymolds.ca', '693 Street Lane', 'Kanata', 'Ontario', 'K1Q5E3', 'Canada', '693 Street Lane', 'Kanata', 'Ontario', 'K1Q5E3', 'Canada', '', '', '', 'info@canopymolds.com', 13, '2020-11-11', '2020-11-29', 13),
(8, 'Bliss Molds', 'http://www.blissmolds.com', '321 Port Drive', 'Toronto', 'Ontario', 'K6L5W4', 'Canada', '321 Port Drive', 'Toronto', 'Ontario', 'K6L5W4', 'Canada', '', '', '', 'info@blissmolds.com', 13, '2020-11-11', '2020-11-29', 13),
(9, 'Zack\'s Molds', 'http://zacksmolds.com', '124 Tacker Street', 'Edmonton', 'Alberta', 'K1R6E', 'Canada', '124 Tacker Street', 'Edmonton', 'Alberta', 'K1R6E', 'Canada', '', '', '', 'info@zacksmolds.com', 14, '2020-11-11', '2020-11-29', 14),
(10, 'Harold &amp; Kumar Co.', 'http://haroldandkumarco.com', '29 Poor Lane', 'New York', 'New York', 'K1A5E3', 'United States', '29 Poor Lane', 'New York', 'New York', 'K1A5E3', 'United States', '', '', '', 'info@haroldandkumarco.com', 9, '2020-11-11', '2020-11-29', 9),
(11, 'Nelson Inc.', 'http://www.Nelson.com', '48 Cat Street', 'Stanstead', 'Quebec', 'J1X0M9', 'Canada', '48 cat', 'Stanstead', 'Quebec', 'J1X0M9', 'Canada', '', '', '', 'JoanJones@Nelson.com', 10, '2020-11-11', '2020-11-29', 10),
(12, 'Blue Trail', 'http://www.bluetrail.com', '43 Dog Street', 'Morden', 'Manatoba', 'A2E1U6', 'Canada', '43 Dog Street', 'Morden', 'Manatoba', 'A2E1U6', 'Canada', '', '', '', 'info@bluetrail.com', 11, '2020-11-11', '2020-11-29', 11),
(13, 'Vegetarians United', 'http://www.vegitariansunited.org', '2543 Yaris Drive', 'Kingston', 'Ontario', 'K1W9R3', 'Canada', '2543 Yaris Drive', 'Kingston', 'Ontario', 'K1W9R3', 'Canada', '', '', '', 'info@vegitariansunited.com', 12, '2020-11-11', '2020-11-29', 12),
(14, 'Albert Molds', 'http://albertmolds.com', '24 junction street', 'Edmonton', 'Alberta', 'K1S8B7', 'Canada', '24 junction street', 'Edmonton', 'Alberta', 'K1S8B7', 'Canada', '', '', '', 'info@albertmolds.com', 13, '2020-11-11', '2020-11-29', 13),
(15, 'ascot', 'http://www.ascot.com', '7 ascot', 'Newport', 'Vermont', 'J1S9E3', 'United States', '7 ascot', 'Newport', 'Vermont', 'J1S9E3', 'United States', '', '', '', 'info@ascot.com', 14, '2020-11-11', '2020-11-29', 14);

--Customer Relational Company Data
INSERT INTO `company_relational_customer` (`company_id`, `customer_id`) VALUES
(14, 7),
(4, 5),
(15, 19),
(8, 21),
(12, 9),
(7, 1),
(10, 15),
(11, 10),
(2, 16),
(6, 17),
(3, 11),
(13, 4),
(5, 3),
(9, 14),
(15, 6),
(12, 6),
(2, 8),
(2, 2),
(4, 13),
(4, 12),
(11, 18),
(12, 18),
(5, 20),
(9, 22);

--Customer Data
INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `date_created`, `customer_phone`, `customer_fax`) VALUES
(1, 'Eliot Moose', 'eliotm@spencers.com', '2020-11-11 00:00:00', '8195648484', '4685497947'),
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
(16, 'James Daniel', 'mrjehdoubleu@gmail.com', '2020-11-29 00:00:00', '8193429795', '1111111111'),
(17, 'Jason Waid', 'jwaid@spencers.com', '2020-11-29 00:00:00', '8198469898', ''),
(18, 'Todd Rivet', 'trivet@spencers.com', '2020-11-29 00:00:00', '7894651345', ''),
(19, 'Bob Hascal', 'bobhascal@albertmolds.com', '2020-11-29 00:00:00', '8194589598', '8194845656'),
(20, 'Zack Snyder', 'zacksnyder@ascot.com', '2020-11-29 00:00:00', '5474659834', '5463165945'),
(21, 'Brandon Bailey', 'bbailey@bluetrail.com', '2020-11-29 00:00:00', '8196133310', ''),
(22, 'Zoe Hope', 'zhope@vegetariansunited.com', '2020-11-29 00:00:00', '6136489575', '');

