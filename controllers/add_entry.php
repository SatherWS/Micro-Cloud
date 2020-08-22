<?php
/*
*   This controller script handles the creation of tasks and user posts.
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

// create journal entry
if ($_POST['add-journal']) {
    $subject = $_POST["jsubject"];
    $category = $_POST["category"];
    $msg = $_POST["note"];
    $priv = "public";
    
    // check if check box is posted, if true mark journal as private
    if (isset($_POST['omit'])) {
        $sql = "insert into journal(subject, message, category, creator, team_name, is_private) values (?, ?, ?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ssssss", $subject, $msg, $category, $_SESSION["unq_user"], $_SESSION["team"], $priv);
        $stmnt -> execute();
    }
    else {
        // set journal to public
        $sql = "insert into journal(subject, message, category, creator, team_name) values (?, ?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sssss", $subject, $msg, $category, $_SESSION["unq_user"], $_SESSION["team"]);
        $stmnt -> execute();
    }
    header("Location: ../views/logs.php");        
}

// add task to todo list
if (isset($_POST['add-task'])) {
    $sql = "insert into todo_list(title, assignee, description, deadline, importance, creator, team_name) values (?, ?, ?, ?, ?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("sssssss", $_POST["title"], $_POST["assignee"], $_POST["descript"], $_POST["end-date"], $_POST["importance"], $_SESSION["unq_user"], $_SESSION["team"]);
    $stmnt -> execute();
    header("Location: ../views/show-tasks.php");
}

// helper functions for create/join projects
function projectCheck($curs, $project) {
    $sql = "select team_name from teams where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->prepare("s", $project);
    if ($stmnt->execute())
        return true;
    else
        return false;
}

// join or create project
if (isset($_POST["send-project"])) {
    if ($_POST["radio"] == "create") {
        $sql = "insert into teams(team_name, admin) values (?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("ss", $_POST["teamname"], $_SESSION["unq_user"]);
        $stmnt->execute();
        $sql = "insert into members(team_name, email) values (?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("ss", $_POST["teamname"], $_SESSION["unq_user"]);
        if ($stmnt->execute()) {
            $_SESSION["team"] = $_POST["teamname"];
            header("Location: ../views/dashboard.php");
        }
    }
    else if ($_POST["radio"] == "join" && projectCheck($curs, $_POST["teamname"])) {
        $sql = "insert into invites(team_name, email) values (?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("ss", $_POST["teamname"], $_SESSION["unq_user"]);
        if ($stmnt->execute()) {
            $_SESSION["team"] = $_POST["teamname"];
        }
    }
}
$curs -> close();
?>
