<?php
/*
*   This controller script handles the creation of tasks and user posts.
*   TODO: Split this script into 2-3 controller modules.
*   Author: Colin Sather
*/
session_start();
if (!isset($_SESSION["unq_user"])){
    header("Location: ../authentication/login.php");
}
include ('../config/database.php');
$database = new Database();
$curs = $database->getConnection();

if ($curs->connect_error) {
    die("Connection failed: " . $curs->connect_error);
}

// create journal entry (journals = articles)
if (isset($_POST['add-journal'])) 
{
    $subject = $_POST["jsubject"];
    $msg = $_POST["note"];
    $sql = "insert into journal(subject, message, creator, team_name) values (?, ?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("ssss", $subject, $msg, $_SESSION["unq_user"], $_SESSION["team"]);
    $stmnt -> execute();
    header("Location: ../views/logs.php");
}

// add task to todo list table
if (isset($_POST['add-task'])) 
{
    $sql = "insert into todo_list(title, assignee, description, deadline, importance, creator, team_name) values (?, ?, ?, ?, ?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("sssssss", $_POST["title"], $_POST["assignee"], $_POST["descript"], $_POST["end-date"], $_POST["importance"], $_SESSION["unq_user"], $_SESSION["team"]);
    $stmnt -> execute();
    header("Location: ../views/show-tasks.php");
}

// helper functions for create/join projects
function projectCheck($curs, $project) 
{
    $sql = "select team_name from teams where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("s", $project);
    if ($stmnt->execute())
        return true;
    else
        return false;
}

function getAdmin($curs, $project) 
{
    $sql = "select admin from teams where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("s", $project);
    $stmnt->execute();
    $result = $stmnt->get_result();
    $set = mysqli_fetch_assoc($result);
    return $set["admin"];
}

function associateMember($curs, $team, $user)
{
    $sql = "insert into members(team_name, email) values (?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    //$stmnt->bind_param("ss", $_POST["teamname"], $_SESSION["unq_user"]);
    $stmnt -> bind_param("ss", $team, $user);
    if ($stmnt->execute())
        return true;
    else
        return false;
}

# Main execution section

// join or create project (TODO: possibly move to auth_user)
if (isset($_POST["send-project"])) 
{
    if ($_POST["radio"] == "create") 
    {
        $sql = "insert into teams(team_name, description, admin) values (?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_POST["teamname"], $_POST["description"], $_SESSION["unq_user"]);
        if ($stmnt -> execute()) 
        {
            associateMember($curs, $_POST["teamname"], $_SESSION["unq_user"]);
            addWiki($curs, $_POST["teamname"]);
            $_SESSION["team"] = $_POST["teamname"];
            header("Location: ../views/dashboard.php");
        }
        else 
            header("Location: ../views/dashboard.php?error=unable to add user to project");
    }

    else if ($_POST["radio"] == "join" && projectCheck($curs, $_POST["teamname"])) 
    {
        $admin = getAdmin($curs, $_POST["teamname"]);
        $sql = "insert into invites(team_name, sender, receiver) values(?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("sss", $_POST["teamname"], $_SESSION["unq_user"], $admin);
        
        if ($stmnt->execute()) 
            header("Location: ../views/dashboard.php?msg=Request sent to the admin of ".$_POST["teamname"]);
        else 
            header("Location: ../views/dashboard.php?error=Request did not send to ".$_POST["teamname"]);
    }
}

// joining a project from the index page
if (isset($_POST["index-join"]))
{
    $admin = getAdmin($curs, $_POST["teamname"]);
    $sql = "insert into invites(team_name, sender, receiver) values(?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("sss", $_POST["teamname"], $_SESSION["unq_user"], $admin);
    
    if ($stmnt->execute()) 
        header("Location: ../views/dashboard.php?msg=Request sent to the admin of ".$_POST["teamname"]);
    else 
        header("Location: ../views/dashboard.php?error=Request did not send to ".$_POST["teamname"]);
}
$curs -> close();
?>
