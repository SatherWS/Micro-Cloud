<p align="center">
  <img src="https://github.com/SatherWS/Consciencec/blob/master/static/logo.png">
</p>

## Project Details
This GitHub repository contains source code for project management software. It's a intranet web application to be used for task delegation, task management, general note taking and more. This project is currently a work in progress, in the future this site may be publicly hosted.

### How to run it in Windows Subsystem for Linux
Using WSL is beneficial because it is a local development environment that is practically identical to the production environment. [Read more about this WSL configuration here.](https://syllasource.com/wsl-lamp-stack-for-local-development.html)

### How to run locally using web server emulation software
1. Install LAMP stack server emulator (AMPPS, MAMP, XAMPP)
2. Set MYSQL system environment variable in order to use MYSQL CLI
3. Clone repo into /www or /htdocs `cd C://Program Files/Ampps/www/` then run `git clone <repo url>`
4. In MYSQL shell run `source /path/to/repo/config/ddl_config.sql` to create the database schema
5. Open browser to 127.0.0.1/swoop.team
   
## Change Log
  * 9/9/2020 Worked on standardizing the UI
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

### Bugs
  - [ ] Display issue: cannot accept or deny invites on mobile devices 8/23/2020
  - [ ] ' character in project names creates problems 8/23/2020
  - [X] After 2 subtasks are created the main task renders twice.
  - [ ] Cannot add assignee to tasks if initially null 
  
### Access restriction tasks
- [X] Restrict access for users to only view posts and tasks by their teams or themselves
  - [ ] Use random number references in each post/task
  - [ ] Check if $_SESSION["unq_user"] is in post/task's team_name/project

### TODO XX/XX/XXXX (Version 2.1.0)
- [ ] Write cron jobs to send email alerts regarding tasks
- [ ] Add comments to tasks and posts if not private
- [ ] Implement more user options
  - [X] add user to team
  - [ ] remove user from team
  - [ ] delete account 
  - [ ] quit team
  - [ ] delete team

### TODO 09/02/2020 (Version 2.0.0)
- [X] URL Link to current page instead of dashboard after team is changed
- [ ] Allow sub task editing
- [ ] Disable prompt for resubmitting the dash selector form
- [ ] Create URL input modal for embedding links and images in posts
- [X] Allow admins to accept requests to join a team
- [X] Add sub tasks modal
- [ ] Reset forgotten passwords via email
  
### Version 1.2.1 Completed Tasks
- [X] Confirm before deleting task, post or user
- [X] Create admin user options (team creator)
- [X] Analytics range selector
- [X] Fix bugs in invites section
- [X] Implement join team modal checkbox
- [X] Allow admins to accept or deny requests to join a project
- [X] Adjust note editing textarea for mobile viewing
- [X] Fix file path errors in bonus apps
- [X] Move mood rating system to bonus apps
- [X] Implement user authentication
- [X] Integrate data into gantt chart 
- [X] Improve analytics UI
- [X] Remove repeat task option
- [X] Change index.php to dashboard.php
- [X] Fix drop down hover nav
- [X] Implement user teams
- [X] Assign tasks to users
- [X] Remove bonus apps and shared_drives.php, and upload scripts
- [X] Design landing page (mobirise)
- [X] Create authentication dir change login and signup to php scripts
- [X] Login error messages
- [X] Signup error messages (team dne, team cannot be created, user already exists)
- [X] Fix bug: only able to post when private checkbox is clicked
- [X] Fix bug: journal category creates a new team (really bad)
- [X] Fix bug: minor display issue when posts are selected in dashboard
- [X] Improve dashboard and create task UI on mobile
- [X] Make activity items clickable in dash
  
