<?php
session_start();
include_once("../config/database.php");

$db = new Database();
$curs = $db -> getConnection();

$id = $_POST["taskid"];
$assignee = $_SESSION["unq_user"];

$exec_date = $_POST['remind-date'];
$exec_time = $_POST["remind-time"];
$exec_datetime = $exec_date.' '.$_POST['remind-time'];

// get scheduled task
$sql = "select title, description, deadline, status, creator from todo_list where id = ?";
$stmnt = mysqli_prepare($curs, $sql);
$stmnt -> bind_param("s", $id);

if ($stmnt -> execute() && isset($id)) {
    $results = $stmnt -> get_result();
    $row = mysqli_fetch_row($results);

    $task_name = escapeshellarg($row[0]);
    $descript = escapeshellarg($row[1]);
    $deadline = escapeshellarg($row[2]);
    $status = escapeshellarg($row[3]);
    $creator = escapeshellarg($row[4]);
    $task_id = escapeshellarg($id);

    // search for sub tasks
    $sql = "select title from sub_tasks where task_id = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $id);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    $subtasks = "";

    if (mysqli_num_rows($results) == 0)
        $subtasks = "";
    else {
        while ($row = mysqli_fetch_assoc($results)) {
            $subtasks .= $row["title"].",";
        }
        $subtasks = substr($subtasks, 0, -1);
        $subtasks = escapeshellarg($subtasks);
    }

    // date format for the 'at' command, python script path and its command line params
    $at_format = substr($exec_date, 5, 2).substr($exec_date, 8, 2).substr($exec_date, 2, 2);
    $script_path = "/var/www/html/controllers/smtp_interface.py";
    $cli_params = $assignee." ".$task_name."  ".$descript." ".$deadline." ".$status." ".$task_id." ".$creator;

    if ($subtasks != "")
        $cli_params .= " ".$subtasks;
    
    // execute the 'at' command
    $at_exec = "echo \"python3 $script_path  $cli_params \" | at $exec_time $at_format";
    exec($at_exec);
    echo "<br>";
    echo $at_exec;
    header("Location: ../views/task-details.php?task=$id");
}
else 
    header("Location: ../views/dashboard.php?error='unable to set reminder'");
?>