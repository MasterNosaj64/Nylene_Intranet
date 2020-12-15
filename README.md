# Nylene_Intranet
Team 8 Project

The Nylene Intranet is a website designed to be used on Nylene's Intranet to provide their sales employees a one stop shop to keep track of customer interactions.
These interactions range from basic inquiries to filled out forms for Quotes.

To serve this purpose, TCPDF has been integrated into the project to allow these forms to be exported.

<h2>Core Components</h2>

<h3>Login Authentication</h3>
<ul>
<li>Upon 3 failed login attempts the user will be permanetly locked out of the website untill a user with admin priveleges changes his status from LOCKED to 0</li>
<li>The above is accomplished via the Admin Panel under edit user</li>
<li>Only the employees supervisor or site admin can do this</li>
</ul>
<h3>Nav Bar</h3>
<ul>
<li>Every page upon login will have a navigation bar displayed at the top of the page</li>
<li>As a user travels through the Comapany <li>> Customers <li>> Interaction path, the nav bar will populate with buttons to go back to a previous view</li>
<li>The Nav bar will also contain special Administrator options when a user with admin priveledges is detected</li>
</ul>

<h3>HomePage / Calendar</h3>
<ul>
<li>The calendar is the first page loaded upon successful login</li>
<li>Calendar shares User Level Role Hierarchy described below</li>
<li>Calendar serves as a means of sharing events with a team of employees or keeping track of imprtant dates relating to interactions</li>
</ul>

<h3>Admin Panel</h3>
<ul>
<li>User creation and editing take place under the Admin Panel found in the Nav Bar</li>
<li>Only Admins can make another Admin or supervisor</li>
<li>Supervisors can edit fields for Sales Reps and Independant Sales Reps</li>
</ul>
<h3>Company</h3>
<ul>
<li>Consisting of Search Company & Add Company, these options are immedietly availible via the Nav Bar</li>
<li>Add Company will verify if the entry already exists, relying on an exact match of all entered fields</li>
	<ul>
    <li>IE: it is possible to have two companies with the same name if something else is different</li>
    <li>Editing a company will apply the same logic before updating the database</li>
	</ul>
<li>Search Company is the only path to a company in the website</li>
<li>By default the site will load all companies visible to the logged in user</li>
<li>he search function will allow any combination of up to 8 possible search criterias</li>
	<ul>
    <li>To reset the search process back to default (all companies visible to user) click search while all search criterias are blank</li>
    <li>Using Clear Search button followed by clicking search is the easiest way to accomplish this</li>
	</ul>
</ul> 
<h3>Customer</h3>
<ul>
<li>Customers are shown on each Companies profile (search Company -> view)</li>
<li>Although it is possible to traverse into View History while no Customers exist, it is not possible to submit an interaction until at least 1 customer exists, as Customer is a required field</li>
<li>Adding a customer will verify if the entered data already exists using exact matches</li>
	<ul>
    <li>Editing a customer will use the same logic</li>
    <li>This is handles on a global level, not on a per company basis</li>
    <li>IE: You cannot have the same customer (exact match for every field) anywhere on the site, this includes if it already exists for a different company</li>
	</ul>
</ul>  
<h3>Interaction</h3>
<ul>
<li>Every Interaction has a number of required fields</li>
	<ul>
    <li>Reason</li>
    <li>Follow Up Type</li>
		<ul>
        <li>If Manual: Follow Up Date req</li>
        <li>If Form Date: Form type req</li>
        <li>Customer</li>
        <li>Notes</li>
		</ul>
	</ul>
<li>When viewing an interaction, any forms created with it will be visible by viewing the interaction</li>
	<ul>
    <li>This includes editing it, and exporting to PDF</li>
    <li>This also includes editing the interaction itself</li>
	</ul>
<li>When applying edits, the notes will have a summary of changes appended to the Notes text field</li>
</ul>
<h3>Form</h3>
<ul>
<li>Forms are only visible by navigating to their respective interactions</li>
	<ul>
    <li>This includes edit, view and export to PDF</li>
	</ul>
</ul>      
<h3>TCPDF</h3>
<ul>
<li>All Forms (except for Marketing Materials Request) have the ability to be exported to PDF</li>
<li>The look of the PDF's can be changed by adjusting the source code found in TCPDF_Forms</li>
<li>CSS must be inline, meaning CSS Style sheets will not work most of the time</li>
	<ul>
    <li>IE: <style> ....css code .... </style> will most likely not work</li>
    <li>IE: <td style="text-align:center background-color:blue"> .... </td> is the best approach for consisten results</li>
	</ul>
</ul>  

<h2>Relationship Breakdown</h2>

The wesite consists of a few key relationships that can be describes as follows...

<h3>Companies - > Customers&Interactions - > Forms</h3>
<ul>
<li>Companies are the starting point when navigating the site</li>
	<ul>
    <li>Companies can have multiple correspondants (customers)</li>
    <li>Companies can have multiple interactions, each must tied to 1 correspondant</li>
    <li>Every interaction can have 1 form linked to it (optional)</li>
	</ul>
</ul>    
<h3>Employees</h3>
<ul>
<li>Every employee but report to a superior</li>
<li>The User Level Role Hierarchy is as follows:</li>
	<ul>
    <li>Admin</li>
    <li>Supervisor</li>
    <li>Sales Rep | Independant Sales Rep</li>
	</ul>
<li>Where every Supervisor Reports to Admin</li>
<li>Where every Sales Rep | Independant Sales Rep reports to a Supervisor</li>
<li>Company visibility in the tool is directly effected by a users role</li>
	<ul>
    <li>Admins can view all companies</li>
    <li>Supervisors can view all companies assigned to themselves or assigned to an employee who themselves, is assigned to them</li>
    <li>Sales Reps can see all companies assigned to members of their team (excluding their superiors)</li>
    <li>Independant Sales Reps can only see companies assigned to them selves</li>
	</ul>
</ul>     
<h3>Admin Panel</h3>
<ul>
<li>Same user level role hierarchy described above applied to the admin panel</li>
<li>Only an admin can create another Admin or Supervisor</li>
<li>Supervisors can create or edit any Sales Rep | Independant Sales Rep</li>
</ul>
  
<h3>Calendar</h3>
<ul>
<li>Calendar can have 2 types of relationships, all of which have User Level Roles effecting visibility</li>
<li>Generic Events</li>
	<ul>
    <li>Events Visible to All (Admin/Supervisor Only)</li>
    <li>Events Visible to Team (Admin/Supervisor Only)</li>
    <li>Events only visible to themselves (All Roles)</li>
	</ul>
<li>Interaction Events</li>
	<ul>
    <li>Share the same user level roles</li>
    <li>Can only be created based on follow up type when creating interaction</li>
    <li>This event type will have a link to the interaction they belong to as a shortcut</li>
	</ul>
</ul>
    
    Thank you for choosing Team 8 & Algonquin College, Dec 14th 2020
