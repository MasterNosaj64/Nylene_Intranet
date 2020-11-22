<link rel="stylesheet" href="../CSS/form.css">

<form method="post" action=jasonTestFile.php name="convertToPdf">
	<table>

		<tr>
			<td>Form Type</td>
			<td><select id="selection" required name="formType">
					<option value="0"></option>
					<option value="6">Credit Business Application</option>
					<option value="4">Distributor Quote</option>
					<option value="2">Light Truckload Quote</option>
					<option value="5">Marketing Request</option>
					<option value="1">Sample Request</option>
					<option value="3">Truckload Quote</option>
			</select></td>
		</tr>
		<tr>
			<td>Form ID:</td>
			<td><input type="text" name="formID" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="submit" /></td>
		</tr>


	</table>
</form>

<?php

// Include the main TCPDF library (search for installation path).
require_once ('../TCPDF/tcpdf.php');


class TCPDF_NYLENE extends TCPDF
{
    // Page header override
    public function Header()
    {
        // Logo
        // Image Fix
        // Images in header not showing after the 1st page is a known bug, used file_get_contents to convert file to a string
        //https://stackoverflow.com/questions/52662271/tcpdf-header-image-only-displays-on-first-page/56681901#56681901
        $this->Image('@'.file_get_contents('../Graphics/nylene_form_logo.png'), 15, 7.5, 65, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        $this->SetFont('helvetica', '', 10);
        
        // Nylene Address
        $this->writeHTMLCell(0, 0, 85, 12.5, "200 McNab St,<br>Arnprior, ON<br> K7S 2C7", 0, 2);
        $this->writeHTMLCell(0, 0, 15, 25, "", array(
            'B' => array(
                'width' => 1,
                'cap' => 'butt',
                'join' => 'miter',
                'dash' => 0,
                'color' => array(
                    0,
                    0,
                    0
                )
            )
        ), 2);
    }
}


if (isset($_POST['submit'])) {

    

    // create new PDF document obj
    $pdf_obj = new TCPDF_NYLENE('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf_obj->SetCreator(PDF_CREATOR);
    $pdf_obj->SetAuthor("Jason Waid");
    $pdf_obj->SetTitle("Export to PDF TEST");
    $pdf_obj->SetSubject("Testing");

    // set default header data
    // $pdf_obj->SetHeaderData($img_PATH, 40, "Form TEST", PDF_HEADER_STRING);

    // Header and Footer Fonts
    $pdf_obj->setHeaderFont(Array(
        PDF_FONT_NAME_MAIN,
        '',
        PDF_FONT_SIZE_MAIN
    ));
    $pdf_obj->setFooterFont(array(
        PDF_FONT_NAME_DATA,
        '',
        PDF_FONT_SIZE_DATA
    ));

    // set default monospaced font
    $pdf_obj->SetDefaultMonospacedFont('helvetica');

    // set margins
    $pdf_obj->SetMargins(PDF_MARGIN_LEFT, '30', PDF_MARGIN_RIGHT);
    $pdf_obj->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf_obj->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf_obj->setPrintHeader(true);
    $pdf_obj->setPrintFooter(true);

    // set image scale factor
    $pdf_obj->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set auto page breaks
    $pdf_obj->SetAutoPageBreak(True, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf_obj->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // add a page
    $pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

    // set font
    $pdf_obj->SetFont('helvetica', 'B', 20);

    $pdf_obj->Write(0, 'Test Conv to PDF', '', 0, 'L', true, 0, false, false, 0);
    $content = '';

    $content .= '<style>
.form-table {
  border-collapse: collapse;
  margin: 0 0;
  font-size: 20px;
  width: 100%;
  border-radius: 5px 5px 0 0;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  transition: max-height 0.2s ease-out;
}

.form-table thead tr {
	font-size: 20px;
  background-color: rgb(65,95,142);
  color: #ffffff;
  text-align: left;
  font-weight: bold;
  text-align: center;
}

.form-table th{
	 padding: 12px 15px
}
.form-table td {
	 font-size: 20px;
  padding: 6px 15px;
}

.form-table tbody tr {
  border-bottom: 1px solid #dddddd;
}


.form-table tbody tr:nth-of-type(even) {
  background-color: rgb(223, 223, 223);
}



</style>';

    $content = <<<EOF
    		<table class="form-table" border="1">
    			<thead style="text-align: center;">
    				<tr>
    					<th colspan="2">TL Quote Form</th>
    				</tr>
    			</thead>
    			<tr>
    				<td><label for="quote_date"> Date </label></td>
    				<td>11/21/2020</td>
    			</tr>
    			<tr>
    				<td><label for="quote_num"> Quote Name/Number </label></td>
    				<td>ABDJA5854</td>
    			</tr>
            </table>
            <table class="form-table" border="1">
    			<thead>
    				<tr>
    					<th colspan="2">- Employee Information -</th>
    				</tr>
    			</thead>
    			<tr>
    				<td><label for="first_name"> First Name </label></td>
    				<td>Jason</td>
    			</tr>
    			<tr>
    				<td><label for="last_name"> Last Name </label></td>
    				<td>Waid</td>
    			</tr>
    			<tr>
    				<td><label for="nyleneCompany"> Nylene Company </label></td>
    				<td>Nylene</td>
    			</tr>
    			<tr>
    				<td><label for="work_phone"> Nylene Phone </label></td>
    				<td>0123456789</td>
    			</tr>
    			<tr>
    				<td><label for="employee_email"> Your Email </label></td>
    				<td>test@test.com</td>
    			</tr>
    			<tr>
    				<td><label for="title"> Your Title </label></td>
    				<td>BOSS</td>
    			</tr>
                </table>
                <table class="form-table" border="1">
    			<thead>
    				<tr>
    					<th colspan="2">- Customer Information -</th>
    				</tr>
    			</thead>
    			<tr>
    				<td><label for="company_name"> Customer Company </label></td>
    				<td>Company Test Name</td>
    			</tr>
    			<tr>
    				<td><label for="customer_name"> Customer Name </label></td>
    				<td>Billy Bob</td>
    			</tr>
    			<tr>
    				<td><label for="customer_phone"> Customer Phone </label></td>
    				<td>0123456789</td>
    			</tr>
    			<tr>
    				<td><label for="customer_email"> Customer Email </label></td>
    				<td>test@test.com</td>
    			</tr>
                </table>
                <table class="form-table" border="1">
    			<thead>
    				<tr>
    					<th colspan="2">- Product Information -</th>
    				</tr>
    			</thead>
    			<tr>
    				<td><label for="product_name"> Product Name </label></td>
    				<td>Product name</td>
    			</tr>
    			<tr>
    				<td><label for="product_desc"> Description </label></td>
    				<td>Product Description</td>
    			</tr>
    			<tr>
    				<td><label for="annual_vol"> Est. Annual Volume </label></td>
    				<td>100</td>
    			</tr>
    			<tr>
    				<td><label for="OEM"> OEM </label></td>
    				<td>Test</td>
    			</tr>
    			<tr>
    				<td><label for="application"> Application </label></td>
    				<td>Test</td>
    			</tr>
    			<tr>
    				<td><label for="truck_load"> TL Price </label></td>
    				<td>100</td>
    			</tr>
                </table>
                <table class="form-table" border="1">
    			<thead>
    				<tr>
    					<th colspan="2">- Terms -</th>
    				</tr>
    			</thead>
    			<tr>
    				<td>Payment terms are USD $ Funds, Net</td>
    				<td>TEST</td>
    			</tr>
    			<tr>
    				<td>LTL quantities are</td>
    				<td>1234</td>
    			</tr>
    			<tr>
    				<td><label for="special_terms"> Special terms and conditions </label></td>
    				<td>1523</td>
    			</tr>
    			<tr>
    				<td>40,000 lb.+</td>
    				<td>range40plus</td>
    			</tr>
    			<tr>
    				<td>22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box</td>
    				<td>range2240</td>
    			</tr>
    			<tr>
    				<td>11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box</td>
    				<td>range1022</td>
    			</tr>
    			<tr>
    				<td>6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box</td>
    				<td>range610</td>
    			</tr>
    			<tr>
    				<td>4,400 - 6,599 lb. bags, 3,000 - 5,999 lb. box</td>
    				<td>range46</td>
    			</tr>
    			<tr>
    				<td>2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box</td>
    				<td>range24</td>
    			</tr>
    		</table>
    EOF;

    // set font
    $pdf_obj->SetFont('helvetica', '', 12);

    // output the HTML content
    $pdf_obj->writeHTML($content, true, false, true, false, '');

    // add a page
    $pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

    // Terms and conditions
    $terms .= "";

    $terms .= <<<EOF
            <p style="font-size:30px; text-align: center;">
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
    					obtained, all such advice being given and accepted at Buyer*s risk.</div>

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

    // set font
    $pdf_obj->SetFont('helvetica', '', 8);

    // output the HTML content
    $pdf_obj->writeHTML($terms, true, false, true, false, '');

    // reset pointer to the last page
    $pdf_obj->lastPage();

    ob_end_clean();

    $pdf_obj->Output("test.pdf", "I");
}
?>