<?php

/*
 * Template Name: DIST-Quote
 * Version: 1.2.2 
 
 * Description: Focus Gravity providing a classic layout which epitomises Gravity Forms Print Preview. It's the familiar layout you've come to love. Through the Template tab you can control the PDF header and footer, change the background color or image, and show or hide the form title, page names, HTML fields and the Section Break descriptions.
 * Author: Gravity PDF
 * Author URI: https://gravitypdf.com
 * Group: Core
 * License: GPLv2
 * Required PDF Version: 4.0-alpha
 * Tags: Header, Footer, Background, Optional HTML Fields, Optional Page Fields, Combined Row, Alternate Colors
 */


/*
 * All Gravity PDF 4.x templates have access to the following variables:
 *
 * $form (The current Gravity Form array)
 * $entry (The raw entry data)
 * $form_data (The processed entry data stored in an array)
 * $settings (the current PDF configuration)
 * $fields (an array of Gravity Form fields which can be accessed with their ID number)
 * $config (The initialised template config class – eg. /config/focus-gravity.php)
 * $gfpdf (the main Gravity PDF object containing all our helper classes)
 * $args (contains an array of all variables - the ones being described right now - passed to the template)
 */

/*
 * Load up our template-specific appearance settings
 */
$misc = GPDFAPI::get_misc_class();

$accent_colour             = ( ! empty( $settings['focusgravity_accent_colour'] ) ) ? $settings['focusgravity_accent_colour'] : '#e3e3e3';
$accent_contrast_colour    = $misc->get_contrast( $accent_colour );
$secondary_colour          = ( ! empty( $settings['focusgravity_secondary_colour'] ) ) ? $settings['focusgravity_secondary_colour'] : '#eaf2fa';
$secondary_contrast_colour = $misc->get_contrast( $secondary_colour );

$label_format = ( ! empty( $settings['focusgravity_label_format'] ) ) ? $settings['focusgravity_label_format'] : 'combined_label';

?>

<!-- Include styles needed for the PDF -->
<style>
*
{
    border: 0;
    box-sizing: content-box;
    font-family: "Roboto", "sans-serif";
    font-size: inherit;
    font-style: inherit;
    font-weight: inherit;
    line-height: 15px;
    list-style: disc;
    margin-top: 5px;
    margin-right: 5px;
    margin-left: 5px;
    margin-bottom: 5px;
    padding-top: 3px;
    padding-right: 3px;
    padding-left: 3px;
    padding-bottom: 3px;
    text-decoration: none;
    vertical-align: top;
    color: #000000;
}

/* content editable */
	
ul {
    list-style: disc; /* Remove HTML bullets */
    padding: 0;
    margin: 0;
    font-style: inherit;
    font-weight: inherit;
    line-height: inherit;
    font-size: 10px;
}

li {
    font-style: inherit;
    font-weight: inherit;
    line-height: 16px;
    color: #000D5E;
    font-size: inherit;
}

li::before {
  content: "•"; /* Insert content that looks like bullets */
  padding-right: 8px;
  color: red; /* Or a color you prefer */
}
	
	





/* table */

table { font-size: 60%; table-layout: fixed; width: 100%; }

	
table {
    border-collapse: separate;
    border-spacing: 2px;
    border-style: none;
    border-color: #000000;
    font-size: 9px;
}
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th {
    background: #DCDFEB;
	color: white;
    border-color: #BBC4E5;
}
td { border-color: #DCDFEB; color: blue; }

/* page */
	
	

html {
    font: 12px/1 'Open Sans', sans-serif;
    overflow: auto;
    padding: 0.5in;
	color:black;
}
html { background: #999; cursor: default; }

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 50%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }


article address { float: left; font-size: 125%; font-weight: bold; }



table.meta th { width: 50%; }
table.meta td { width: 50%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th {
    font-weight: 500;
    text-align: center;
    color: #22337C;
}

table.inventory td:nth-child(1) { width: 16.6%; }
table.inventory td:nth-child(2) { width: 16.6%; }
table.inventory td:nth-child(3) { width: 16.6%; }
table.inventory td:nth-child(4) { width: 16.6%; }
table.inventory td:nth-child(5) { width: 16.6%; }

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }





@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 30px; }
    .signature {
    font-family: font-family: "signature2", signature2, sans-serif;
    color: #0B255F;
    font-size: 20px;
    line-height: inherit;
}
body,td,th {
    font-size: 11px;
    color: #000000;
    font-weight: normal;
}

.cut1 {	border-width: 1px;
	display: block;
	font-size: .8rem;
	padding: 0.25em 0.5em;	
	float: left;
	text-align: center;
	width: 0.6em;
}
.cut1 {
    background: #9AF;
    box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
    background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
    border-radius: 0.5em;
    border-color: #FFFFFF;
    color: white;
    cursor: pointer;
    font-weight: bold;
    text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}
.cut1 {opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut1 {-webkit-transition: opacity 100ms ease-in; }
.cut1 {display: none; }
table.meta1 {
    border: 0px none #FFFFFF;
    margin: 0 0 3em;
 
}
.cut11 {border-width: 1px;
	display: block;
	font-size: .8rem;
	padding: 0.25em 0.5em;	
	float: left;
	text-align: center;
	width: 0.6em;
}
.cut11 {
    background: #9AF;
    box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
    background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
    border-radius: 0.5em;
    border-color: #FFFFFF;
    color: #FFF;
    cursor: pointer;
    font-weight: bold;
    text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}
.cut11 {opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut11 {-webkit-transition: opacity 100ms ease-in; }
.cut11 {display: none; }
	
	/* Create two equal columns that floats next to each other */



.clearfix:after {  content: "";
  display: table;
  clear: both;
}
h2.name {  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}
#company {  float: right;
  text-align: right;
}
#logo {  float: left;
  margin-top: 8px;
}
#client {  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}
#details {  margin-bottom: 50px;
}
#invoice {  float: right;
  text-align: right;
}
	
	
header {
  padding: 10px 0;
  margin-bottom: 10px;
  border-bottom: 1px solid #022472;
}

#logo {
  float: left;
  margin-top: 0px;
}

#logo img {
  height: 50px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 10px;
}

#client {
    padding-left: 6px;
    border-left: 6px solid #AB0635;
    float: left;
    border-top-color: #AB0635;
    border-bottom-color: #AB0635;
    border-right-color: #AB0635;
}

#client .to {
    color: #000000;
}

h2.name {
    font-size: 1.4em;
    font-weight: normal;
    margin: 0;
    color: black;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0B4782;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #000B62;
}
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}
#notices {
    padding-left: 6px;
    border-left: 6px solid #0B4782;
    margin-bottom: 0px;
    margin-top: 0px;
    padding-bottom: 4px;
    padding-top: 5px;
}
</style>

<!-- Output our HTML markup -->
    <header class="clearfix"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <div id="logo">
    <img src="https://www.nylene.com/NYLENE-LOGO-WEB.png" alt="" width="181" height="51">
      </div>
      <div id="company">
        <h2 class="name">Quoted by:</h2>
        <div>{created_by:display_name}</div>
        <div>{Your Phone Number:97}</div>
        <div><a href="mailto:{created_by:user_email}">{created_by:user_email}</a></div>
      </div>
      </div>
    </header>
    <main>
    <div id="details">
      <div id="client">
          <div class="to">QUOTED TO:</div>
          <h2 class="name">{Customer Contact Name (First):72.3} {Customer Contact Name (Last):72.6}</h2>
          <div class="address">{Company Name:14}<br>
          {Company Phone:44}          </div>
          <div class="email"><a href="mailto:john@example.com">{Email:74}</a></div>
        </div>
        <div id="invoice">
          <h1>QUOTE #: {created_by:ID}-{entry_id}</h1>
          <div class="date">Date Issued: {date_created}</div>
          
      </div>
      </div>
		
		<p>Dear {Customer Contact Name (First):72.3},</p>
	<p>On behalf of Nylene, I am pleased to provide the following pricing confirmation:</p>
		<table class="inventory">
  <thead>
					<tr>
					<th width="17%" align="left">NYLENE GRADE:</th>
					<td width="33%" class="date"><a class="cut"></a>{Nylene Grade:70}</td>
					<th width="17%" align="left">SHIP TO LOCATION:</th>
					<td width="33%"><a class="cut"></a>{Ship to Address for this Contact (Street Address):137.1}</td>
	</tr>
	</thead><thead>
					<tr>
					  <th align="left">DESCRIPTION:</th>
					<td class="date"><a class="cut"></a>{Description:75}</td>
					<th align="left">OEM:</th>
					<td><a cldss="cut"></a>{OEM:77}</td>
	  </tr>
				</thead>
				<tbody>
					<tr>
				<th align="left" alig="left">EST. ANNUAL VOLUME</th>
						<td class="date">{Est. Annual Volume LBS:18}</td>
					  <th align="left">APPLICATION:</th>
						<td>{Application:78}</td>
				  </tr>
				</tbody>
		  </table>
<table cellspacing="5" class="inventory">
	  <thead>
					<tr>
					  <th width="16%">TRUCKLOAD,<br>
				      40,000 LB. +</th>
						<th width="16%">22,000 - 39,999 LB.<br>
					    BAGS</th>
						<th width="16%">11,000 - 21,999 LB.<br>
					    BAGS</th>
						<th width="16%">6,600 - 10,999 LB.<br>
					    BAGS</th>
						<th width="16%">2,200 – 6,599 LB.<br>
					    BAGS</th>
					
		</tr>
  </thead><thead>
					<tr>
					  <th width="16%">TRUCKLOAD,<br>
					    40,000 LB. +</th>
						<th>21,000 - 39,999 LB<br>

					    BOXES</th>
						<th>10,500 - 20,999 LB.<br>

				      BOXES</th>
						<th>6,000 - 10,499 LB.<br>
					    BOXES</th>
						<th>1,500 – 5,999 LB.<br>
					    BOXES</th>
						
	</tr>
				</thead>
				<tbody>
					<tr>
						<td align="center">{DIS-1:55}lbs.</td>  
						<td align="center">{DIS-2:61} lbs.</td>
						<td align="center">{DIS-3:56} lbs.</td>
						<td align="center">{DIS-4:65} lbs.</td>
						<td align="center">{DIS-5:100} lbs.</td>
						
				  </tr>
				</tbody>
	</table>
<div id="notices">
  <div class="notice">
    Prices quoted price is based on the current economic conditions and supplier reserves the right to evaluate the pricing in the case of any significant changes in the cost of the components of the product.
  </div>
</div>
<div id="notices">
  <div class="notice">
    Lead time of this product is 4 to 6 weeks. Customer is to supply an accurate 90 day rolling forecast.
  </div>
</div><div id="notices">
  <div class="notice">
    Payment terms are USD $ Funds, Net {Payment Terms:79}{Custom Payment Terms:91}.
  </div>
</div>
	<div id="notices">
  <div class="notice">
    Manufactured at {Manufacturer:80}.
  </div>
</div>
<div id="notices">
  <div class="notice">
   TL Quantities are {Shipped Quantities:81}{Custom Shipped Quantities:92}.
  </div>
</div>
		
	<div id="notices">
  <div class="notice">
    Special terms and conditions: {Special Terms:82}.
  </div>
	</div>
		
	<div id="notices">
  <div class="notice">
    Purchase orders should include: Nylene product number, packaging type and release quantity, credit terms, required ship date, 
    specifications and approvals required, customer part number if required, and any other special instructions
  </div>
	</div>
                        <p>Please review this information and let me know if there are any questions.                        </p>
                        <p>                        We thank you for your business.</p>
            <p><span class="signature">{created_by:display_name}</span></p>
                        <p>                        {created_by:display_name}<br>
                        {Title:96}</p>

				
			</table>

			<!-- Basic Page Break -->
	
<pagebreak/>
			<p><strong>TERMS AND CONDITIONS OF SALE</strong></p>
			<table border="0" cellspacing="5" cellpadding="5">
			  <tbody>
			    <tr>
			      <td width="41%" align="left" valign="top"><div class="notice">1. Weights of all shipments shall be determined at the point of shipment by 
			        ascertaining the gross and tare weight of each container. Claims on account of weight 
			        are allowable only when all of the following conditions are met. (1) When the variation 
			        exceeds the following amounts: (a) for all shipments except bulk rail cars and trucks, 
			        one-half percent (½%) of the entire contents; (b) for bulk rail cars and trucks, one 
			        percent (1%) of the entire contents. (2) When made within ten (10) days of receipt at 
			        destination. (3) For bulk rail car shipments, when supported by certified railroad scale 
			        tickets. (4) When buyer proves to satisfaction of the seller that the container in 
			        question was emptied in it entirety.</div>
			        <p><br>
			      </p>
			        <div class="notice">2. Shipments shall not be diverted nor reconsigned except with consent of Seller.</div>
			        <p><br>
			        </p>
			        <div class="notice">3. Seller makes no warranty of any kind, express or implied, except that the goods 
                      shall be of processable quality; that is, of fair average quality in the trade and within 
                      the description herein. Any affirmation of fact or promise made by Seller shall not be 
                      deemed to create an express warranty that the goods shall conform to the affirmation 
                      or promise; any description of the goods is for the sole purpose of identifying them 
                      and shall not be deemed to create an express warranty that the goods shall conform 
                      to such description; any sample or model is for illustrative purposes only and shall not 
                      be deemed to create an express warranty that the goods shall conform to the sample 
                      or model; and no affirmation, promise or description of sample or model shall be
                      deemed to be part of the basis for the bargain. The Buyer assumes all risk and liability 
                      resulting from the use of the material and/or equipment, whether used singly or in
                      combination with other products. SELLER GIVES NO WARRANTY, EXPRESS OR IMPLIED,
                      AS TO DESCRIPTION, QUALITY, MERCHANTABILITY, FITNESS FOR ANY PARTICULAR
                      PURPOSE, PRODUCTIVENESS OR ANY OTHER MATTER OF ANY GOODS WHICH THE
                      SELLER SHALL SUPPLY. SELLER SHALL IN NO WAY BE RESPONSIBLE FOR THEIR PROPER
                      USE AND SERVICE, AND THE BUYER HEREBY WAIVES ALL RIGHTS OF REFUSAL AND
                      RETURN OF GOODS. Seller shall in no way be deemed or held to be obligated, liable or
                      accountable upon or under any guarantees or warranties, express or implied whether
                      by operation of law or otherwise, in any manner or form beyond the express
                      agreements herein set forth. Seller shall not be liable for normal manufacturing
                      
                      
                    defects or for customary variations from specifications.</div> <p><br>
			      </p>
			        <div class="notice">4. Orders are accepted based on inspection and acceptance by the buyer at the
                      factory. If Buyer does not wish to inspect the material, the Manufacturer will, on
                      request, furnish a certified report to Buyer that the material was inspected and tested 
                      in the usual manner according to the companys guidelines, which may be revised from
                      time to time, and was found to have met the physical property requirements typical of 
                      this product. If requested, a sample of the material covered by the certified report will
                      also be furnished. After material has been approved and released for shipment from
                      the factory, further claims, if any, are limited to those covered by Sellers standard
                      warranty. 
                      After receipt of the goods, Buyer shall inspect them within 24 hour and either accept
                      or reject them. If the goods are rejected, written notice must be given to Seller so that
                      such notice will be received no later than 48 hours after Buyers receipt of the goods.
                      Should any such materials prove defective due to manufacturing faults or fail to meet
                      the written specifications of the goods, Buyer shall notify Seller immediately, stating
                      full particulars in support of its claim; and Seller shall either replace the goods upon
                      return of the unsatisfactory material or, at its option, adjust the matter fairly and
                      promptly or refund the purchase price without further responsibility. Buyer shall not
                      return the goods unless authorized to do so by Seller. Under no circumstances shall
                      Seller be liable for consequential or other damages, losses or expenses in connection
                      with or by reason of the use of or inability to use materials purchased for any purpose.
                      If Buyer accepts the goods tendered, such acceptance shall be deemed a complete
                      discharge of all of Seller's obligations, and after such acceptances, Buyer shall have no
                      remedy against Seller nor the right to revoke such acceptance for any reason.
                      All claims for damages to packaging, errors or shortages must be made by Buyer in
                      writing within two days from the time the shipment is examined by Buyer, but not
                      later than 30 days after the goods are delivered. Failure to make such claim within the
                      stated period shall constitute an irrevocable acceptance of the goods and an
                      admission that they fully comply with all of the terms, conditions and specifications of
                      this agreement. All claims relating to the processable quality of the goods as that term is defined in
                      paragraph 3 hereof shall be made by Buyer in writing within 30 days after Buyers
                      receipt of the goods. Failure to make such claim within this period shall constitute an      irrevocable acceptance of the goods and an admission that they fully comply with all
                    of the terms, conditions and specifications of this agreement.                    </div>
			       <p><br>
			      </p>
			        <div class="notice">5. The Buyer shall reimburse the Seller for all taxes, excises or other charges which
                      the Seller may be required to pay to any Governmental Authority (Federal, Provincial,
                      or Local) upon the sale, production or transportation of the commodities sold  
                      hereunder. Seller shall under no circumstances be responsible for any of the above,
                      even if it is due to warranty claims or if it replaces detective material and/or
                      equipment. 
                      6. No claim of any kind shall be allowed in amount greater than the purchase price
                      of the goods in respect of which such damages are claimed. No charge or expense
                      incident to any claims will be allowed unless approved in writing by Sellers authorized
                      representative. Goods shall not be returned to Seller without Sellers authorization. No
                      claim shall be allowable after goods or equipment has been installed or used or 
                      processed in any manner or in any way altered from the form delivered, except for
                  laboratory quantities necessary to ascertain quality.</div>
			      <p><br>
			        </p>

			        <div class="notice">6. No claim of any kind shall be allowed in amount greater than the purchase price of the goods in respect of which such damages are claimed. No charge or expense incident to any claims will be allowed unless approved in writing by Sellers authorized representative. Goods shall not be returned to Seller without Sellers authorization. No claim shall be allowable after goods or equipment has been installed or used or processed in any manner or in any way altered from the form delivered, except for laboratory quantities necessary to ascertain quality. </div>
			        <p><br>
			        </p>
		          <p>&nbsp;</p></td>
			      <td width="59%" align="left" valign="top"><div class="notice"><br>
			        7. Additional charges may apply if goods or materials are shipped in a non-standard
			        form of transportation. These charges shall be agreed to by Buyer prior to such
			        shipment.</div>  <p><br>
			      </p>
			        <div class="notice">8. Seller shall have the right, in addition to all others it may possess, at any time, for
                      credit reasons or because of Buyers default or defaults, to withhold shipments in
                      whole or in part and to recall goods in transit, retake same, and repossess all goods
                      which may be stored with Seller for Buyer*s account without the necessity of taking
                      any other proceedings, and Buyer consents that all of the merchandise so recalled,
                      retaken or repossessed shall become Seller*s absolute property, provided that Buyer
                      be given credit therefore. The remedies reserved to Seller by the terms and conditions 
                      of this Invoice shall be cumulative and in addition to all other or further remedies
                      provided by law. No waiver by Seller of any breach, default or violation of any of the
                      terms or conditions hereof shall constitute a waiver of any subsequent breach, default
                    or violation of the same or other term or condition.</div>
			        <p><br>
			      </p>
			        <div class="notice">9. Except as otherwise agreed to in writing, the parties recognize and consent to the
                      jurisdiction over them of the Courts of the State of New York, for all purposes
                      hereunder. Except as otherwise agreed to in writing, the relationship between the
                      parties shall be governed by the terms of document only and by the laws of the State
                    of New York without giving effect to the conflict of laws provision thereof.</div>  <p><br>
			      </p>
			        <div class="notice">10. Seller will not be liable for any delay in the performance of orders or contracts
                      or in the delivery or shipment of goods or for any damages suffered by Buyer if such
                      delay is directly or indirectly caused by or in any manner arises from fires, floods,
                      accidents, civil unrest, acts of G-d, war, governmental interference or embargo strikes,
                      labor difficulties, shortage of labor, fuel, power, materials or supplies, transportation
                      delays or any other causes (whether or not similar in nature to any of these herein
                    above specified) beyond its control.</div>
			        <p><br>
		            </p>
			        <div class="notice">11. Special orders. If any materials shall be manufactured and / or sold by Seller to
                      meet Buyer*s particular specifications or requirements and such material or goods are
                      not part of Sellers standard product line offered by it to the trade generally in the
                      usual course of Sellers business, Buyer shall defend, protect and hold harmless Seller
                      against all suits at law or in equity and from all damages, claims and demands for
                      actual or alleged infringement of domestic or foreign patents, and shall defend any
                      suit or actions which may be brought against Seller for any alleged infringement
                    because of the manufacture and/or sale of the material covered thereby.</div><p><br>
		            </p>
			        <div class="notice">12. Fitting up charges. Fitting up charges to Buyer cover part of the necessary tools
                      and fixtures required for the particular work. Such tools and fixtures remain Seller's
                      sole property and are retained in Seller*s possession for use exclusively in filling
                      orders for Buyer. There will be no additional charge for upkeep or replacement, but if,
                      at any time, a period of two years has elapsed since the receipt of any order from
                      Buyer requiring the use of such tools and fixtures, Seller may thereafter make any
                      such use or disposition of such tools and fixtures as Seller desired, without any
                    accounting to Buyer for such use or disposition of the proceeds thereof. </div>
			        <p><br>
                    </p>
                    <div class="notice">13. It is further understood and agreed between Buyer and Seller that if the
                      material and/or equipment sold is manufactured especially for the Buyer and if
                      suspended or terminated by the Buyer for any reason, Buyer will take delivery of and
                      make payment for such material and/or equipment as has been completed and such
                      as is in process on the date notice to the Seller of the suspension or termination is
                      received from Buyer. If Buyer for any reason cannot or does not accept delivery of 
                      such material, buyer will make payment as though delivery has been made and Seller
                    will store such material for Buyer*s account at Buyer's expense.</div>   <p><br>
                    </p>
                    <div class="notice">14. This agreement is not assignable or transferable by Buyer, in whole or in part,
                    except with the written consent of Seller.</div>
                    <p><br>
                    </p>
                    <div class="notice">15. Technical advice. Upon buyers request, Seller shall furnish such technical advice
                      as it has available in reference to the use of the goods sold. It is expressly understood
                      that any technical advice furnished by Seller is provided without payment or other
                      consideration. Moreover, since Seller is not controlling or supervising the subsequent
                      manufacture, fabrication or installation of its products or their use after sale, Seller
                      assumes no obligation or liability for the advice given or the results obtained, all such
                    advice being given and accepted at Buyer*s risk.</div>
			        <p><br>
			        </p>
			        <div class="notice">16. These terms and conditions shall supersede any provisions, terms and
                      conditions contained in any Purchase Order or other writing Buyer may give or receive 
                      and the rights of the parties shall be governed exclusively by the provisions, terms and
                      conditions hereof. Seller makes no representations or warranties except such as are 
                      expressly contained herein.                     </div>
			        <p><br>
                    </p>
                    <div class="notice">17. No modification of the terms hereof shall have any force and effect unless in 
                      writing and signed by an executive officer of the corporation. Salesmen and sales
                      representatives are not executive officers and have no authority to whatsoever to
                    modify or alter the terms hereof. </div>
                    <p><br>
                    </p>
                    <div class="notice">18. In the event of the failure of the buyer to make payment for the goods shipped,
                      the Buyer shall be obligated to pay to the Seller, interest on all unpaid amounts due at
                      the rate of one and one half (1-1/2) percent per month until the entire amount is paid
                      in full, in addition to all other remedies. In the event the buyer defaults in failing to
                      make any payment required to be made hereunder, the seller shall be entitled to
                      recover all of the costs and expenses in recovering any unpaid amounts and interest
                      due thereon, including reasonable legal fees.                    </div>
                    <p><br>
                    </p>
                    <div class="notice">19 Unless otherwise indicated, all monetary amounts are in United States of<br>
                    America currency.</div>
                    <p><br>
                    </p>
                    <p></p>
                    <p><br>
                    </p>
                    <p><br>
                    </p>
			        <p>&nbsp;</p>
			        <p><br>
			        </p>
			        <p><br>
                      <br>
		          </p></td>
		        </tr>
		      </tbody>
    </table>
