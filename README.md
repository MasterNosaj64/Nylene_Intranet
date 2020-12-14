# Nylene_Intranet
Team 8 Project

The Nylene Intranet is a website designed to be used on Nylene's Intranet to provide their sales employees a one stop shop to keep track of customer interactions.
These interactions range from basic inquiries to filled out forms for Quotes.

To serve this purpose, TCPDF has been integrated into the project to allow these forms to be exported.

~~~~~~~~~~~~Core Components~~~~~~~~~~~~~~~~~

Login Authentication
- Upon 3 failed login attempts the user will be permanetly locked out of the website untill a user with admin priveleges changes his status from LOCKED to 0
- The above is accomplished via the Admin Panel under edit user
    - Only the employees supervisor or site admin can do this

Nav Bar
- Every page upon login will have a navigation bar displayed at the top of the page.
- As a user travels through the Comapany - > Customers - > Interaction path, the nav bar will populate with buttons to go back to a previous view
- The Nav bar will also contain special Administrator options when a user with admin priveledges is detected

HomePage / Calendar
- The calendar is the first page loaded upon successful login
- Calendar shares User Level Role Hierarchy described below
- Calendar serves as a means of sharing events with a team of employees or keeping track of imprtant dates relating to interactions

Admin Panel
- User creation and editing take place under the Admin Panel found in the Nav Bar.
- Only Admins can make another Admin or supervisor
- Supervisors can edit fields for Sales Reps and Independant Sales Reps

Company
- Consisting of Search Company & Add Company, these options are immedietly availible via the Nav Bar
- Add Company will verify if the entry already exists, relying on an exact match of all entered fields
  - IE: it is possible to have two companies with the same name if something else is different
  - Editing a company will apply the same logic before updating the database.
- Search Company is the only path to a company in the website
- By default the site will load all companies visible to the logged in user
- The search function will allow any combination of up to 8 possible search criterias
  - To reset the search process back to default (all companies visible to user) click search while all search criterias are blank.
      - Using Clear Search button followed by clicking search is the easiest way to accomplish this
 
Customer
- Customers are shown on each Companies profile (search Company -> view)
- Although it is possible to traverse into View History while no Customers exist, it is not possible to submit an interaction until at least 1 customer exists, as Customer is a required field.
- Adding a customer will verify if the entered data already exists using exact matches
  - Editing a customer will use the same logic
  - This is handles on a global level, not on a per company basis.
  - IE: You cannot have the same customer (exact match for every field) anywhere on the site, this includes if it already exists for a different company
  
Interaction
- Every Interaction has a number of required fields
    - Reason
    - Follow Up Type
      - If Manual: Follow Up Date req
      - If Form Date: Form type req
    - Customer
    - Notes
- When viewing an interaction, any forms created with it will be visible by viewing the interaction
  - This includes editing it, and exporting to PDF
  - This also includes editing the interaction itself
- When applying edits, the notes will have a summary of changes appended to the Notes text field.

Form
- Forms are only visible by navigating to their respective interactions
    - This includes edit, view and export to PDF
      
TCPDF
- All Forms (except for Marketing Materials Request) have the ability to be exported to PDF
- The look of the PDF's can be changed by adjusting the source code found in TCPDF_Forms
- CSS must be inline, meaning CSS Style sheets will not work most of the time.
  - IE: <style> ....css code .... </style> will most likely not work
  - IE: <td style="text-align:center background-color:blue"> .... </td> is the best approach for consisten results.
  

~~~~~~~~~~~~~Relationship Breakdown~~~~~~~~~~~~~~

The wesite consists of a few key relationships that can be describes as follows...

Companies - > Customers&Interactions - > Forms

- Companies are the starting point when navigating the site.
    - Companies can have multiple correspondants (customers)
    - Companies can have multiple interactions, each must tied to 1 correspondant
    - Every interaction can have 1 form linked to it (optional)
    
Employees

- Every employee but report to a superior.
- The User Level Role Hierarchy is as follows:
      - Admin
      - Supervisor
      - Sales Rep | Independant Sales Rep
- Where every Supervisor Reports to Admin
- Where every Sales Rep | Independant Sales Rep reports to a Supervisor
- Company visibility in the tool is directly effected by a users role
      - Admins can view all companies
      - Supervisors can view all companies assigned to themselves or assigned to an employee who themselves, is assigned to them.
      - Sales Reps can see all companies assigned to members of their team (excluding their superiors)
      - Independant Sales Reps can only see companies assigned to them selves
      
Admin Panel

- Same user level role hierarchy described above applied to the admin panel
- Only an admin can create another Admin or Supervisor
- Supervisors can create or edit any Sales Rep | Independant Sales Rep
  
Calendar
- Calendar can have 2 types of relationships, all of which have User Level Roles effecting visibility.
- Generic Events
    - Events Visible to All (Admin/Supervisor Only)
    - Events Visible to Team (Admin/Supervisor Only)
    - Events only visible to themselves (All Roles)
- Interaction Events
  - Share the same user level roles
    - Can only be created based on follow up type when creating interaction
  - These Event type will have a link to the interaction they belong to as a shortcut
  
  Thank you for choosing Team 8 & Algonquin College,
  Dec 14th 2020
