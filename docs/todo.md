### Bugs
  - [X] Index hide button screws up the view (high)
  - [X] Journal details doesn't display data (high)
  - [ ] Display issue: cannot accept or deny invites on mobile devices (high)
  - [ ] ' character in project names creates problems (low)
  - [X] After 2 subtasks are created the main task renders twice (high)
  - [ ] Cannot add assignee to tasks if initially null (med)
  
### Access restriction tasks
- [X] Restrict access for users to only view posts and tasks by their teams or themselves
  - [ ] Use random number references in each post/task
  - [ ] Check if $_SESSION["unq_user"] is in post/task's team_name/project

### TODO (Version 2.1.0)
- [ ] Reset forgotten passwords via email
- [ ] Make usernames unique to prevent email spamming
- [ ] Write cron jobs to send email alerts regarding tasks
- [ ] Make it easier for user to embed links, images and more
- [ ] Activate and implement task percentage slider
- [ ] Comment module on all posts
- [X] add user to team
- [ ] remove user from team
- [ ] delete account (WIP)
- [ ] quit team
- [X] delete team
- [ ] edit team (name, admin, etc.)
- [ ] Confirm from user before deleting a project, account or team member(team)
- [ ] Organize static directory
- [ ] Implement search bar (create separate page w/ search result. UI tab toggles results to tags, projects or users)
- [ ] Implement hashtags (in progress)

### TODO (Version 2.0.0)
My goal is to deploy this version soon.

- [ ] Remove post categories page
- [ ] Implement wiki page editor in the dashboard (in progress)
- [X] Disable task percentage slider
- [X] URL Link to current page instead of dashboard after team is changed
- [X] Allow sub task editing
- [X] Make delete sub task button
- [X] Allow admins to accept requests to join a team
- [X] Add sub tasks modal
- [X] Implement upvote downvote system
- [X] Make non logged in / logged in user sidebars (In Progress 9/15)
- [X] Create search bar in home page
- [X] Either drop the ratings table or rating column from teams table
  
### TODO Version 1.2.1
- [X] Confirm before deleting task, post or user
- [X] Create admin user options (team creator)
- [X] Analytics range selector
- [X] Fix bugs in invites section
- [X] Implement join team modal checkbox
- [X] Allow admins to accept or deny requests to join a project
- [X] Adjust note editing text area for mobile viewing
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
