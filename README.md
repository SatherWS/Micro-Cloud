<p align="center">
  <img src="https://github.com/SatherWS/Consciencec/blob/master/imgs/consciencec-logo.png">
</p>

## Project Details
This GitHub repository contains source code for project management software. It's a intranet web application to be used for task delegation, task management, general note taking and more. This project is currently a work in progress, in the future this site may be publically hosted.

## TODO 
- [X] Adjust note editing textarea for mobile viewing
- [X] Fix file path errors in bonus apps
- [X] Move mood rating system to bonus apps
- [X] Implement user authentication
- [ ] Integrate data into gantt chart 
- [ ] Improve analytics UI 
- [X] Remove repeat task option
- [X] Change index.php to dashboard.php
- [X] Move imgs dir to static folder (or delete entirely)
- [X] Fix drop down hover nav

Tasks for online version
- [X] Implement user teams
- [X] Assign tasks to users
- [ ] Implement user options (add/drop teams, invite users)
- [ ] Remove bonus apps (do last)
- [ ] Design landing page (mobirise)
- [X] Create authentication dir change login and signup to php scripts
- [ ] Implement error messages (login, signup and team creation/joining)
- [ ] Write cron jobs to send email alerts regarding tasks

### Notes to self
#### Join by username
```
select journal.subject, journal.creator, todo_list.creator, todo_list.title
from journal
inner join todo_list on journal.creator =  todo_list.creator;
```

#### Join by team
```
select journal.subject, journal.creator, todo_list.creator, todo_list.title
from journal
inner join todo_list on journal.team_name =  todo_list.team_name;
```

### Calculating Usage
Get size in mb for particular table
```
SELECT (data_length+index_length)/power(1024,2) tablesize_mb
FROM information_schema.tables
WHERE table_schema='lhapps' and table_name='journal';
```

Get size in gb for particular database
```
mysql> select table_schema "DB name (table_schema)", 
sum((data_length+index_length)/1024/1024/1024) AS "DB size in GB" from 
information_schema.tables group by table_schema;
```