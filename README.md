<p align="center">
  <img src="https://github.com/colinsather/Swoop.Team/master/static/logo.png">
</p>

___
## Project Details
Swoop CTMS is a content and task management system. The task management part of the system is able to perform task delegation and send automated/timed email reminders to yourself about task deadlines. The content management part of the application allows users to write articles using [the markdown document formatting language.](https://www.markdownguide.org/cheat-sheet/) Swoop's article editing interface allows users to embed images from web URLs or upload images directly from their hard drives. Swoop CTMS also provides a form of cloud storage by giving users the option to link various types of files to their articles.

#### Accepted file and image formats
| Images | Other accepted files |
| ------ | ----------- |
| gif    | zip         |
| jpg    | txt & pdf       |
| png    | doc & docx   |
| jpeg   | xlsx & xlsm   |

___
## Creating your own instance of Swoop CTMS
All of our code is open source which allows users to run their own instances of this application. This is useful because certain people prefer to use this application for personal use only and keep all their tasks and articles not publicly accessible from our website. This also enables organizations to use this as an internal projects and or content management system. In the future I may write some shell scripts that aid in installing the dependencies needed.

#### Installation process
Swoop runs on the [LAMP stack](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29) so we will need to install some software onto our Linux server. The following LAMP stack installation steps are for Debian based operating systems but, any distribution will do.
```
# TODO: Recreate installation steps on a VM

# Apache web server installation

# MYSQL database installation

# PHP and Python installation
```

##### Database configuration
After you've installed MYSQL we will need to launch a MYSQL shell and create the Swoop database.
```
mysql -u root -p
Enter password: 

create database swoop;
use swoop;
source /var/www/html/config/dev/ddl_config.sql
# type 'exit' or strike Ctrl Z
```
After the database has been created we will need to connect to it using the file located in `/html/config/database.php` and change a single line of code.

```
<?php
    class Database {
        private $hostname = "localhost";
        private $database = "swoop";
        private $user = "root";     // change these two lines
        private $password = "toor"; // to match your MYSQL credentials
    ...
```
##### Final step
Last of all you will need to `git clone` [Swoop's source code](https://github.com/ColinSather/Swoop.Team) into your Apache web server's `/var/www/` directory and rename the directory to `html` to overwrite the default Apache configuration.
___
## Processes for local development of Swoop CTMS
#### How to run Swoop CTMS in Windows Subsystem for Linux
Using WSL is beneficial because one can set up a local LAMP development environment that is practically identical to the production environment. [Read more about this WSL configuration here.](https://syllasource.com/wsl-lamp-stack-for-local-development.html)

#### How to run locally using web server emulation software (recomended for beginners)
1. Install LAMP stack server emulator (AMPPS, MAMP, XAMPP)
2. Set MYSQL system environment variable in order to use MYSQL CLI
3. Clone repo into /www or /htdocs `cd C://Program Files/Ampps/www/` then run `git clone <repo url>`
4. In MYSQL shell run `source /path/to/repo/config/ddl_config.sql` to create the database schema
5. Open browser to 127.0.0.1/swoop.team