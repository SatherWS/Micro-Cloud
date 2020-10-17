-- Use a stored proc to delete projects 
DELIMITER ;;
CREATE PROCEDURE delete_project (proj VARCHAR(8), vklasor INT)
    DELETE FROM journal WHERE team_name = proj;
    DELETE FROM sub_tasks WHERE team_name = proj;
    DELETE FROM todo_list WHERE team_name = proj;
    DELETE FROM members WHERE team_name = proj;
    DELETE FROM teams WHERE team_name = proj;
