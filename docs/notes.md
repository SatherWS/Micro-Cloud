'**Version 2 Deployment**
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
10/17/2020

Installed composer in order to get better markdown parser.

`sudo apt install curl php-cli php-mbstring git unzip`

`curl -sS https://getcomposer.org/installer -o composer-setup.php`

Installed Parsedown via composer.

`composer require erusev/parsedown`

NOT USING COMPOSER

## Analytics section
In the future I want to use something other than google charts, possibly matplotlib instead.

- [Use this tool for rendering in web browser](https://mpld3.github.io/quickstart.html#general-functions)
- [Reference this post when using WSL](https://stackoverflow.com/questions/43397162/show-matplotlib-plots-and-other-gui-in-ubuntu-wsl1-wsl2)
