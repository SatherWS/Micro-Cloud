**Version 2 Deployment**
Move post categories to project categories and include a few image classifiers.

Compile SASS code 
`sass --watch infile.scss:outfile.css`

Backup MYSQL Database
`mysqldump --add-drop-table -u<username> -p<password> swoop > /var/www/html/config/swoop_localdata.sql`

Enable PHP Error Messages, Do Not Use in Prod
```
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```