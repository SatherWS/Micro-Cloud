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
- [ ] Implement repeat task option

Tasks for online version
- [X] Implement user teams
- [X] Assign tasks to users

### Notes to self
#### Join by username
```
select journal.subject, journal.creator, todo_list.creator, todo_list.title
from journal
inner join todo_list on journal.creator =  todo_list.creator;
```

#### Join by team
