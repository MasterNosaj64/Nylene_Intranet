<?php
/*
 * FileName: TCPDF_getHTML.php
 * Version Number: 1.0
 * Date Modified: 12/15/2020
 * Author: Jason Waid
 * Purpose:
 * All functions for handling and creating html data for TCPDF Forms
 */
include '../Database/Customer.php';
include '../Database/Company.php';
include '../Database/Employee.php';
include '../Database/connect.php';

/*
 * Function: create_EmployeeHTML
 * Purpose:
 * Creates Employee HTML elements
 * returns a string containing the HTML mark up for the first page of quote forms
 * This portion of the first page is for Quoted by
 */
function create_EmployeeHTML($employee_id)
{

    // database connection
    $db_conn = getDBConnection();

    // Employee objects used to populate employee data for into pages
    $employeeObj = new Employee($db_conn);
    $employeeObj = $employeeObj->searchById($employee_id);
    $db_conn->close();

    // Here we get the name, email and phone of the employee who did the quote
    $employeeName = $employeeObj->getName();
    $employeePhone = $employeeObj->getWork_Phone();
    $employeeEmail = $employeeObj->getEmployee_Email();

    // Quoted by html mark up
    $content = "";

    $content .= '<div>
        <h2>Quoted by:</h2>
        ' . $employeeName . '<br>' . $employeePhone . '<br><a href="mailto:' . $employeeEmail . '">' . $employeeEmail . '</a>
    </div>';

    return $content;
}

/*
 * Function: create_CompanyHTML
 * Purpose:
 * Creates Company HTML elements
 * returns a string containing the HTML mark up used for forms
 * This portion is for the company data on the first page of forms
 */
function create_CompanyHTML($company_id)
{

    // create db connection and get the company in question
    $db_conn = getDBConnection();
    $companyObj = new Company($db_conn);
    $companyObj = $companyObj->searchId($company_id);
    $db_conn->close();

    // Here we get all of the data members for the comapny that we'll be using for the company data in on the first page
    $companyName = $companyObj->getName();
    $companyAddressStreet = $companyObj->getBillingAddressStreet();
    $companyAddressCity = $companyObj->getBillingAddressCity();
    $companyAddressState = $companyObj->getBillingAddressState();
    $companyAddressCountry = $companyObj->getBillingAddressCountry();
    $companyAddressPostalCode = $companyObj->getBillingAddressPostalCode();
    $companyEmail = $companyObj->getEmail();

    // The html markup we'll be passing into TCPDF
    $content = "";

    $content .= '
    <div>' . $companyName . '<br>' . $companyAddressStreet . '<br>' . $companyAddressCity . ', ' . $companyAddressState . '<br>' . $companyAddressPostalCode . '<br>' . $companyAddressCountry . '<br><a href="' . $companyEmail . '">' . $companyEmail . '</a>
    </div>';

    return $content;
}

/*
 * Function: create_CustomerHTML
 * Purpose:
 * Creates Customer HTML elements
 * returns a string containing the HTML mark up
 * This portion is for the customer data that is shown on the first page of quote forms
 */
function create_CustomerHTML($customer_id)
{

    // create the database connection and get the customer in question
    $db_conn = getDBConnection();
    $customerObj = new Customer($db_conn);
    $customerObj = $customerObj->searchById($customer_id);
    $db_conn->close();

    // here we get all the data members we'll be using for the customer portion of the first page on quote forms
    $customerName = $customerObj->getName();
    $customerPhone = $customerObj->getPhone();
    $customerEmail = $customerObj->getEmail();

    // the html markup we'll be giving to TCPDF
    $content = "";

    $content .= '
    
    <div><h2>Quoted to:</h2>' . $customerName . '<br>' . $customerPhone . '<br><a href="mailto:' . $customerEmail . '">' . $customerEmail . '</a></div>
    </div>';

    return $content;
}

/*
 * Function: create_QuoteIntroHTML
 * Purpose:
 * Creates intro HTML elements
 * returns a string containing the HTML mark up
 * This portion is just for the "on behalf of nylene" messge seen on quote forms
 */
function create_QuoteIntroHTML($customer_id)
{

    // get the db and the customer in question
    $db_conn = getDBConnection();
    $customerObj = new Customer($db_conn);
    $customerObj = $customerObj->searchById($customer_id);

    // ion this case we only need the customer's name
    $customerName = $customerObj->getName();
    $db_conn->close();

    // the html mark up we'll be giving to TCPDF
    $content = "";

    $content .= '
    
    <p>Dear ' . $customerName . ',</p>
    <p>On behalf of Nylene, I am pleased to provide the following pricing confirmation:</p>';

    return $content;
}

/*
 * Function: create_QuoteOutroHTML
 * Purpose:
 * Creates Outro HTML elements
 * returns a string containing the HTML mark up
 * This portion follows the table of form details, appears before all of the terms and conditions.
 */
function create_QuoteOutroHTML($employee_id)
{

    // get database connection and the employee
    $db_conn = getDBConnection();
    $employeeObj = new Employee($db_conn);
    $employeeObj = $employeeObj->searchById($employee_id);
    $db_conn->close();

    // get their name and title for the "signature"
    $employeeName = $employeeObj->getName();
    $employeeTitle = $employeeObj->getTitle();

    // the html markup to be used in TCPDF
    $content = "";

    $content .= '
    <div>
        <div>Prices quoted are based on the current economic conditions and supplier reserves the right to evaluate the pricing in the case of any significant changes in the cost of the components of the product.
        </div>
        <div>Lead time of this product is 4 to 6 weeks. Customer is to supply an accurate 90 day rolling forecast.
        </div>
        <div>Purchase orders should include: Nylene product number, packaging type and release quantity, credit terms, required ship date, 
        specifications and approvals required, customer part number if required, and any other special instructions.
        </div>
        <p>Please review this information and let me know if there are any questions.</p>
        <p>We thank you for your business.</p>
        <p><span>' . $employeeName . '</span></p>
        <p><br>' . $employeeTitle . '</p>
</div>
';

    return $content;
}

/*
 * Function: create_QuoteTermsAndConditionsHTML
 * Purpose:
 * Creates Terms And Conditions HTML elements
 * returns a string containing the HTML mark up
 * This portion is all of the terms and conditions that are seen in the quote forms
 */
function create_QuoteTermsAndConditionsHTML()
{

    // terms and conditions html markup to be used in tcpdf
    $content = "";

    $content .= <<<EOF
                <p style="font-size:20px; text-align: center;">
        	<strong>TERMS AND CONDITIONS OF SALE</strong>
        </p>
        <table border="0" cellspacing="5" cellpadding="5">
        	<tbody>
        		<tr>
        			<td width="41%" align="left" valign="top">
        				<div>1. Weights of all shipments shall be determined at the point of
        					shipment by ascertaining the gross and tare weight of each
        					container. Claims on account of weight are allowable only when all
        					of the following conditions are met. (1) When the variation exceeds
        					the following amounts: (a) for all shipments except bulk rail cars
        					and trucks, one-half percent (0.5%) of the entire contents; (b) for
        					bulk rail cars and trucks, one percent (1%) of the entire contents.
        					(2) When made within ten (10) days of receipt at destination. (3)
        					For bulk rail car shipments, when supported by certified railroad
        					scale tickets. (4) When buyer proves to satisfaction of the seller
        					that the container in question was emptied in it entirety.</div>
        					
        				<div>2. Shipments shall not be diverted nor reconsigned except with
        					consent of Seller.</div>
        					
        				<div>3. Seller makes no warranty of any kind, express or implied,
        					except that the goods shall be of processable quality; that is, of
        					fair average quality in the trade and within the description
        					herein. Any affirmation of fact or promise made by Seller shall not
        					be deemed to create an express warranty that the goods shall
        					conform to the affirmation or promise; any description of the goods
        					is for the sole purpose of identifying them and shall not be deemed
        					to create an express warranty that the goods shall conform to such
        					description; any sample or model is for illustrative purposes only
        					and shall not be deemed to create an express warranty that the
        					goods shall conform to the sample or model; and no affirmation,
        					promise or description of sample or model shall be deemed to be
        					part of the basis for the bargain. The Buyer assumes all risk and
        					liability resulting from the use of the material and/or equipment,
        					whether used singly or in combination with other products. SELLER
        					GIVES NO WARRANTY, EXPRESS OR IMPLIED, AS TO DESCRIPTION, QUALITY,
        					MERCHANTABILITY, FITNESS FOR ANY PARTICULAR PURPOSE, PRODUCTIVENESS
        					OR ANY OTHER MATTER OF ANY GOODS WHICH THE SELLER SHALL SUPPLY.
        					SELLER SHALL IN NO WAY BE RESPONSIBLE FOR THEIR PROPER USE AND
        					SERVICE, AND THE BUYER HEREBY WAIVES ALL RIGHTS OF REFUSAL AND
        					RETURN OF GOODS. Seller shall in no way be deemed or held to be
        					obligated, liable or accountable upon or under any guarantees or
        					warranties, express or implied whether by operation of law or
        					otherwise, in any manner or form beyond the express agreements
        					herein set forth. Seller shall not be liable for normal
        					manufacturing defects or for customary variations from
        					specifications.</div>
        					
        				<div>4. Orders are accepted based on inspection and acceptance by
        					the buyer at the factory. If Buyer does not wish to inspect the
        					material, the Manufacturer will, on request, furnish a certified
        					report to Buyer that the material was inspected and tested in the
        					usual manner according to the companys guidelines, which may be
        					revised from time to time, and was found to have met the physical
        					property requirements typical of this product. If requested, a
        					sample of the material covered by the certified report will also be
        					furnished. After material has been approved and released for
        					shipment from the factory, further claims, if any, are limited to
        					those covered by Sellers standard warranty. After receipt of the
        					goods, Buyer shall inspect them within 24 hour and either accept or
        					reject them. If the goods are rejected, written notice must be
        					given to Seller so that such notice will be received no later than
        					48 hours after Buyers receipt of the goods. Should any such
        					materials prove defective due to manufacturing faults or fail to
        					meet the written specifications of the goods, Buyer shall notify
        					Seller immediately, stating full particulars in support of its
        					claim; and Seller shall either replace the goods upon return of the
        					unsatisfactory material or, at its option, adjust the matter fairly
        					and promptly or refund the purchase price without further
        					responsibility. Buyer shall not return the goods unless authorized
        					to do so by Seller. Under no circumstances shall Seller be liable
        					for consequential or other damages, losses or expenses in
        					connection with or by reason of the use of or inability to use
        					materials purchased for any purpose. If Buyer accepts the goods
        					tendered, such acceptance shall be deemed a complete discharge of
        					all of Seller's obligations, and after such acceptances, Buyer
        					shall have no remedy against Seller nor the right to revoke such
        					acceptance for any reason. All claims for damages to packaging,
        					errors or shortages must be made by Buyer in writing within two
        					days from the time the shipment is examined by Buyer, but not later
        					than 30 days after the goods are delivered. Failure to make such
        					claim within the stated period shall constitute an irrevocable
        					acceptance of the goods and an admission that they fully comply
        					with all of the terms, conditions and specifications of this
        					agreement. All claims relating to the processable quality of the
        					goods as that term is defined in paragraph 3 hereof shall be made
        					by Buyer in writing within 30 days after Buyers receipt of the
        					goods. Failure to make such claim within this period shall
        					constitute an irrevocable acceptance of the goods and an admission
        					that they fully comply with all of the terms, conditions and
        					specifications of this agreement.</div>
        					
        				<div>5. The Buyer shall reimburse the Seller for all taxes, excises
        					or other charges which the Seller may be required to pay to any
        					Governmental Authority (Federal, Provincial, or Local) upon the
        					sale, production or transportation of the commodities sold
        					hereunder. Seller shall under no circumstances be responsible for
        					any of the above, even if it is due to warranty claims or if it
        					replaces detective material and/or equipment. 6. No claim of any
        					kind shall be allowed in amount greater than the purchase price of
        					the goods in respect of which such damages are claimed. No charge
        					or expense incident to any claims will be allowed unless approved
        					in writing by Sellers authorized representative. Goods shall not be
        					returned to Seller without Sellers authorization. No claim shall be
        					allowable after goods or equipment has been installed or used or
        					processed in any manner or in any way altered from the form
        					delivered, except for laboratory quantities necessary to ascertain
        					quality.</div>
        					
        			</td>
        			<td width="59%" align="left" valign="top">
                        <div>6. No claim of any kind shall be allowed in amount greater than
        					the purchase price of the goods in respect of which such damages
        					are claimed. No charge or expense incident to any claims will be
        					allowed unless approved in writing by Sellers authorized
        					representative. Goods shall not be returned to Seller without
        					Sellers authorization. No claim shall be allowable after goods or
        					equipment has been installed or used or processed in any manner or
        					in any way altered from the form delivered, except for laboratory
        					quantities necessary to ascertain quality.</div>
        					
                            <div>7. Additional charges may apply if goods or materials are
        					shipped in a non-standard form of transportation. These charges
        					shall be agreed to by Buyer prior to such shipment.
        				</div>
        				
        				<div>8. Seller shall have the right, in addition to all others it
        					may possess, at any time, for credit reasons or because of Buyers
        					default or defaults, to withhold shipments in whole or in part and
        					to recall goods in transit, retake same, and repossess all goods
        					which may be stored with Seller for Buyer*s account without the
        					necessity of taking any other proceedings, and Buyer consents that
        					all of the merchandise so recalled, retaken or repossessed shall
        					become Seller*s absolute property, provided that Buyer be given
        					credit therefore. The remedies reserved to Seller by the terms and
        					conditions of this Invoice shall be cumulative and in addition to
        					all other or further remedies provided by law. No waiver by Seller
        					of any breach, default or violation of any of the terms or
        					conditions hereof shall constitute a waiver of any subsequent
        					breach, default or violation of the same or other term or
        					condition.</div>
        					
        				<div>9. Except as otherwise agreed to in writing, the parties
        					recognize and consent to the jurisdiction over them of the Courts
        					of the State of New York, for all purposes hereunder. Except as
        					otherwise agreed to in writing, the relationship between the
        					parties shall be governed by the terms of document only and by the
        					laws of the State of New York without giving effect to the conflict
        					of laws provision thereof.</div>
        					
        				<div>10. Seller will not be liable for any delay in the performance
        					of orders or contracts or in the delivery or shipment of goods or
        					for any damages suffered by Buyer if such delay is directly or
        					indirectly caused by or in any manner arises from fires, floods,
        					accidents, civil unrest, acts of G-d, war, governmental
        					interference or embargo strikes, labor difficulties, shortage of
        					labor, fuel, power, materials or supplies, transportation delays or
        					any other causes (whether or not similar in nature to any of these
        					herein above specified) beyond its control.</div>
        					
        				<div>11. Special orders. If any materials shall be manufactured and
        					/ or sold by Seller to meet Buyer*s particular specifications or
        					requirements and such material or goods are not part of Sellers
        					standard product line offered by it to the trade generally in the
        					usual course of Sellers business, Buyer shall defend, protect and
        					hold harmless Seller against all suits at law or in equity and from
        					all damages, claims and demands for actual or alleged infringement
        					of domestic or foreign patents, and shall defend any suit or
        					actions which may be brought against Seller for any alleged
        					infringement because of the manufacture and/or sale of the material
        					covered thereby.</div>
        					
        				<div>12. Fitting up charges. Fitting up charges to Buyer cover part
        					of the necessary tools and fixtures required for the particular
        					work. Such tools and fixtures remain Seller's sole property and are
        					retained in Seller*s possession for use exclusively in filling
        					orders for Buyer. There will be no additional charge for upkeep or
        					replacement, but if, at any time, a period of two years has elapsed
        					since the receipt of any order from Buyer requiring the use of such
        					tools and fixtures, Seller may thereafter make any such use or
        					disposition of such tools and fixtures as Seller desired, without
        					any accounting to Buyer for such use or disposition of the proceeds
        					thereof.</div>
        					
        				<div>13. It is further understood and agreed between Buyer and
        					Seller that if the material and/or equipment sold is manufactured
        					especially for the Buyer and if suspended or terminated by the
        					Buyer for any reason, Buyer will take delivery of and make payment
        					for such material and/or equipment as has been completed and such
        					as is in process on the date notice to the Seller of the suspension
        					or termination is received from Buyer. If Buyer for any reason
        					cannot or does not accept delivery of such material, buyer will
        					make payment as though delivery has been made and Seller will store
        					such material for Buyer*s account at Buyer's expense.</div>
        					
        				<div>14. This agreement is not assignable or transferable by Buyer,
        					in whole or in part, except with the written consent of Seller.</div>
        					
        				<div>15. Technical advice. Upon buyers request, Seller shall furnish
        					such technical advice as it has available in reference to the use
        					of the goods sold. It is expressly understood that any technical
        					advice furnished by Seller is provided without payment or other
        					consideration. Moreover, since Seller is not controlling or
        					supervising the subsequent manufacture, fabrication or installation
        					of its products or their use after sale, Seller assumes no
        					obligation or liability for the advice given or the results
        					obtained, all such advice being given and accepted at Buyer's risk.</div>
        					
        				<div>16. These terms and conditions shall supersede any provisions,
        					terms and conditions contained in any Purchase Order or other
        					writing Buyer may give or receive and the rights of the parties
        					shall be governed exclusively by the provisions, terms and
        					conditions hereof. Seller makes no representations or warranties
        					except such as are expressly contained herein.</div>
        					
        				<div>17. No modification of the terms hereof shall have any force
        					and effect unless in writing and signed by an executive officer of
        					the corporation. Salesmen and sales representatives are not
        					executive officers and have no authority to whatsoever to modify or
        					alter the terms hereof.</div>
        					
        				<div>18. In the event of the failure of the buyer to make payment
        					for the goods shipped, the Buyer shall be obligated to pay to the
        					Seller, interest on all unpaid amounts due at the rate of one and
        					one half (1-1/2) percent per month until the entire amount is paid
        					in full, in addition to all other remedies. In the event the buyer
        					defaults in failing to make any payment required to be made
        					hereunder, the seller shall be entitled to recover all of the costs
        					and expenses in recovering any unpaid amounts and interest due
        					thereon, including reasonable legal fees.</div>
        					
        				<div>19. Unless otherwise indicated, all monetary amounts are in United States of America currency.
                        <br>
        				</div>
        				<p>
        					<br>
        				</p>
        				<p></p>
        				<p>
        					<br>
        				</p>
        				<p>
        					<br>
        				</p>
        				<p>&nbsp;</p>
        				<p>
        					<br>
        				</p>
        				<p>
        					<br> <br>
        				</p></td>
        		</tr>
        	</tbody>
        </table>
    EOF;

    return $content;
}

