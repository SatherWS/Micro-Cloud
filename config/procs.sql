-- used for development
DROP PROCEDURE delete_project;

-- stored proc that deletes projects 
DELIMITER //
CREATE PROCEDURE delete_project (IN proj VARCHAR(200))
BEGIN
    DELETE FROM journal WHERE team_name = proj;
    DELETE FROM sub_tasks WHERE team_name = proj;
    DELETE FROM todo_list WHERE team_name = proj;
    DELETE FROM members WHERE team_name = proj;
    DELETE FROM categories WHERE team_name = proj;
    DELETE FROM teams WHERE team_name = proj;
END //
DELIMITER ;

-- TODO: CREATE PROCS FOR COMMENTS BELOW

-- stored proc that deletes logged in user

-- stored proc that deletes members from projects