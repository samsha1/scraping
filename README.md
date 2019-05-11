Assignment for webscraping to Collect list of Architecture Firms from Architecture.com

Starting URL: https://find-an-architect.architecture.com/FAAPractices.aspx?display=50

Go through each of the pages here to collect the following information for each firm (where available).
1.Name
2.Address1 
3.Address2
4.Phone
5.Website
6.Email
7.About
8.Image_URL
9.Services (available in the detail page only -- example: https://find-an-architect.architecture.com/ArchitectPractices/51-Architecture/51-Architecture.aspx)

Using the following:
CURL instead of direct file_get_contents
phpQuery (https://code.google.com/archive/p/phpquery/) to query DOM elements.

Output expected:
Script to navigate through the site and write the data to a CSV file.
CSV file with the above details.

