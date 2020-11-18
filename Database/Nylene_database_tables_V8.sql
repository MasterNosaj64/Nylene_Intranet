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
    is_administrator INT DEFAULT FALSE,
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
    marketing_request_id INT NOT NULL AUTO_INCREMENT,
    sales_territory VARCHAR(50) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    market_segment VARCHAR(50) DEFAULT NULL,
    email VARCHAR(250) DEFAULT NULL,
    request_date DATE DEFAULT NULL,
    name_project_or_piece VARCHAR(250) DEFAULT NULL,
    type_of_project VARCHAR(250) DEFAULT NULL,
    is_project_new INT DEFAULT NULL,
    if_piece_new VARCHAR(250) DEFAULT NULL,
    target_audiance VARCHAR(250) DEFAULT NULL,
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

INSERT INTO `employee` (`employee_id`, `first_name`, `last_name`, `title`, `department`, `work_phone`, `reports_to`, `date_entered`, `date_modified`, `modified_by`, `username`, `is_administrator`, `STATUS`, `employee_email`, `password`) VALUES (NULL, 'admin', 'admin', 'admin', 'admin', NULL, NULL, NULL, NULL, NULL, 'admin', '1', NULL, NULL, 'admin');

ALTER TABLE `marketing_request_form` ADD `brochure` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `ppt` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `fact_sheet` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `video` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `direct_mail` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `web` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `page` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `section` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `blog` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `landing_page` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `updt` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `graphic` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `tradeshow` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `promotional_item` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `print_aid` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `press_release` INT(50) NULL DEFAULT NULL
ALTER TABLE `marketing_request_form` ADD `other_type_of_project` TEXT NULL DEFAULT NULL ;
ALTER TABLE `marketing_request_form` ADD `prospective_customers` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `engineers` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `procurement_managers` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `current_customers` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `plant_managers` INT(50) NULL DEFAULT NULL;
ALTER TABLE `marketing_request_form` ADD `other_audience` TEXT NULL DEFAULT NULL;