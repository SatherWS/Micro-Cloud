<p align="center">
  <img src="https://github.com/SatherWS/Consciencec/blob/master/static/logo.png">
</p>

## Project Details
This GitHub repository contains source code for project management software. Swoop.Team is a web based project management tool that is able to perform task delegation, task management and wiki page development. The live version of this site is currently running version 1.1.0 version 2.0 will be released soon.

### How to run ST in Windows Subsystem for Linux
Using WSL is beneficial because one can set up a local LAMP development environment that is practically identical to the production environment. [Read more about this WSL configuration here.](https://syllasource.com/wsl-lamp-stack-for-local-development.html)

### How to run locally using web server emulation software
1. Install LAMP stack server emulator (AMPPS, MAMP, XAMPP)
2. Set MYSQL system environment variable in order to use MYSQL CLI
3. Clone repo into /www or /htdocs `cd C://Program Files/Ampps/www/` then run `git clone <repo url>`
4. In MYSQL shell run `source /path/to/repo/config/ddl_config.sql` to create the database schema
5. Open browser to 127.0.0.1/swoop.team

### Other Documents
  * [TODO List and Bugs](./docs/todo.md)
  * [Misc. Notes](./notes/notes.md)

### Credits
   
## Change Log (rewrite/delete this)
  * 9/18/2020 Had to re clone the code base and lost some work...
  * 9/11/2020 Worked on sub task section and began implementing the new landing page
  * 9/9/2020 Worked on standardizing the UI and implement assignee selector for sub tasks
  * 9/2/2020 Implemented subtasks and set up local WSL dev environment to match prod
  * 8/24/2020 Changed date_created field to current_date instead of datetime, allows for easier editing
  * 8/24/2020 Implemented basic side nav show/hide toggle
  * 8/24/2020 Decided only admins can permit or deny new members in their projects
  * 8/23/2020 Working on admin settings panel, will build subtask modal next
  * 8/21/2020 Made sidebar component
  * 8/21/2020 Implemented add project modal, currently only creates projects
  * 8/20/2020 Refactoring dashboard.php currently struggling, code is not very manageable 
  * 8/17/2020 Only the creator of the post is allowed to edit (duh)
  * 8/17/2020 Improved task editing UI
  * 8/16/2020 Fixed user invites
  * 8/16/2020 Almost implemented public and private post editing (re-plan approach)

