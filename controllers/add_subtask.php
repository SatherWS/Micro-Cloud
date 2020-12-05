<?php
/*
*   Component of script add_entry.php currently attempting to
*   refactor code into smaller components. 09/02/2020
*/

session_start();
if (!isset($_SESSION["unq_user"])){
    header("Location: ../authentication/login.php");
}
include ('../config/database.php');
$database = new Database();
$curs = $database->getConnection();

if ($curs->connect_error) {
    die("Connection failed: ".$curs->connect_error);
}

if (isset($_POST["add-subtask"])) {
    $sql = "insert into sub_tasks(title, descript, deadline, importance, assignee, creator, team_name, task_id) values (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("ssssssss", $_POST["st-title"], $_POST["st-desc"], 
                        $_POST["end-date"], $_POST["importance"], 
                        $_POST["assignee"], $_SESSION["unq_user"], 
                        $SESSION["team"], $_POST["mod-subtask"]
                    );
    $stmnt->execute();
    header("Location: ../views/task-details.php?task=".$_POST["mod-subtask"]);
}
?>