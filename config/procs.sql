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
    DELETE FROM wikis WHERE team_name = proj;
    DELETE FROM teams WHERE team_name = proj;
END //
DELIMITER ;

-- stored proc that alters logged in user
DELIMITER //
CREATE PROCEDURE alter_account (IN email VARCHAR(75), IN user VARCHAR(75))
BEGIN
	-- TODO: set creator and or assignee of given task and sub to email var
	UPDATE teams SET email = email WHERE email = user;
	UPDATE journal SET creator = email WHERE email = user;
	UPDATE teams SET email = email WHERE email = user;
	UPDATE members SET email = email WHERE email = user;
	UPDATE users SET email = email WHERE email = user;
END //
DELIMITER ;

-- TODO: CREATE PROCS FOR COMMENTS BELOW

-- stored proc that deletes logged in user

-- stored proc that deletes members from projects
