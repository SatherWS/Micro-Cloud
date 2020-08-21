<p align="center">
  <img src="https://github.com/SatherWS/Consciencec/blob/master/static/logo.png">
</p>

## Project Details
This GitHub repository contains source code for project management software. It's a intranet web application to be used for task delegation, task management, general note taking and more. This project is currently a work in progress, in the future this site may be publicly hosted.

## Change Log
  * 8/20/2020 Refactoring dashboard.php currently struggling, code is not very manageable 
  * 8/17/2020 Only the creator of the post is allowed to edit (duh)
  * 8/17/2020 Improved task editing UI
  * 8/16/2020 Fixed user invites
  * 8/16/2020 Almost implemented public and private post editing (re-plan approach)

### How to run locally w/ Docker
1. Learn how to do this

### How to run locally w/o Docker
1. Install LAMP stack server emulator (AMPPS, MAMP, XAMPP)
2. Set MYSQL system environment variable in order to use MYSQL CLI
3. Clone repo into /www or /htdocs `cd C://Program Files/Ampps/www/` then run `git clone <repo url>`
4. In MYSQL shell run `source /path/to/repo/config/ddl_config.sql` to create the database schema
5. Open browser to 127.0.0.1/<repo-name>

### Post deployment tasks last updated 7/28/2020 
- [X] Confirm before deleting task, post or user
- [ ] Create admin user options (team creator)
- [X] Analytics range selector
- [ ] Write cron jobs to send email alerts regarding tasks
- [ ] Add comments to tasks and posts if not private
- [ ] Reset forgotten passwords via email
- [ ] Implement more user options
  - [X] add user to team
  - [ ] remove user to team
  - [ ] delete account
  - [ ] quit team
    
### Access restriction tasks
- [ ] Restrict access for users to only view posts and tasks by their teams or themselves
  - [ ] Use random number references in each post/task
  - [ ] Check if $_SESSION["unq_user"] is in post/task's team_name

### Previously completed tasks
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
  
