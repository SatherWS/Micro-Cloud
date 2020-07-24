<?php
/*
*   This controller script handles the creation of tasks and user posts.
*   Note: Lines 52 and below may need to removed if site is hosted, since it belongs to bonus apps.
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
    $priv = "T";
    
    // check if check box is posted, if true mark journal as private
    // TODO: Add team id to posts and tasks
    if (isset($_POST['omit'])) {
        $sql = "insert into journal(subject, message, category, creator, team_name, is_private) values (?, ?, ?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        // set journal to private 
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
if ($_POST['add-task']) {
    $sql = "insert into todo_list(title, assignee, description, deadline, time_due, importance, creator, team_name) values (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("ssssssss", $_POST["title"], $_POST["assignee"], $_POST["descript"], $_POST["end-date"], $_POST["time-due"], $_POST["importance"], $_SESSION["unq_user"], $_SESSION["team"]);
    $stmnt -> execute();
    header("Location: ../views/create-task.php");
}

// TODO: MOVE TO BONUS APPS CONTROLLERS -----
// add chatroom to database
if ($_POST['add-chatroom']) {
    $sql = "insert into chatroom(subject, creator) values(?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("ss", $_POST["room"], $_POST["username"]);
    $stmnt -> execute();
    header("Location: ../views/bonus_apps/join-chat.php");
}

$curs -> close();
?>
