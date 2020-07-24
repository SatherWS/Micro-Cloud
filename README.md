<p align="center">
  <img src="https://github.com/SatherWS/Consciencec/blob/master/static/logo.png">
</p>

## Project Details
This GitHub repository contains source code for project management software. It's a intranet web application to be used for task delegation, task management, general note taking and more. This project is currently a work in progress, in the future this site may be publically hosted.

## TODO before deployment
- [X] Adjust note editing textarea for mobile viewing
- [X] Fix file path errors in bonus apps
- [X] Move mood rating system to bonus apps
- [X] Implement user authentication
- [ ] Integrate data into gantt chart 
- [X] Improve analytics UI 
- [X] Remove repeat task option
- [X] Change index.php to dashboard.php
- [X] Move imgs dir to static folder (or delete entirely)
- [X] Fix drop down hover nav
- [X] Implement user teams
- [X] Assign tasks to users
- [ ] Implement user options (add/drop teams, accept/deny invites)
- [ ] Remove bonus apps (do last)
- [ ] Design landing page (mobirise)
- [X] Create authentication dir change login and signup to php scripts
- [ ] Implement error messages (login, signup and team creation/joining)
- [ ] Write cron jobs to send email alerts regarding tasks
- [X] Fix bug: only able to post when private checkbox is clicked
- [X] Fix bug: journal category creates a new team (really bad)
- [X] Fix bug: minor display issue when posts are selected in dashboard
- [X] Improve dashboard and create task UI on mobile

### How to run locally
1. Install lamp stack server emulator, I used ampps 
2. Set mysql system environment variable in order to use mysql cli
3. Clone repo into ampps `cd C://Program Files/Ampps/www/` then run `git clone <repo url>`
4. In MYSQL shell run `source /path/to/repo/config/ddl_config.sql` to create the database schema
5. Open browser to 127.0.0.1/<repo-name>
  
