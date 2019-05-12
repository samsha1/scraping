Assignment for webscraping to Collect list of Architecture Firms from Architecture.com

Before Running the script, configure your env.php with BASE_URL AND START_URL. See .env.example.php for env.php format.

Also, Download phpQuery from:(https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/phpquery/phpQuery-0.9.5.386.zip) to query DOM elements. After Extracting zip, keep all files & folder inside new directory 'phpQuery/'. i.e. 'phpQuery/cli','phpQuery/api-refernce', 'phpQuery/demo.php' etc. 

If you get any dom error, install php-dom with following command: 
1. sudo apt-get update.
2. sudo apt-get install php-dom

Run the script with 'php scrape_job.php' command in your terminal.

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



