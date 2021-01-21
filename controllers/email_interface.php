<?php
include_once("../config/database.php");

$db = new Database();
$curs = $db -> getConnection();

$id = $_POST["taskid"];
$assignee = $_POST["assignee"];
$exec_date = $_POST['remind-date'];
$exec_time = $_POST["remind-time"];

$exec_datetime = $exec_date.' '.$_POST['remind-time'];

// get scheduled task
$sql = "select title, description, deadline from todo_list where id = ?";
$stmnt = mysqli_prepare($curs, $sql);
$stmnt -> bind_param("s", $id);
$stmnt -> execute();

// TODO: add conditionals
$results = $stmnt -> get_result();
$row = mysqli_fetch_row($results);

$task_name = escapeshellarg($row[0]);
$descript = escapeshellarg($row[1]);
$deadline = escapeshellarg($row[2]);

$at_format = substr($exec_date, 5, 2).substr($exec_date, 8, 2).substr($exec_date, 2, 2);
$script_path = "/var/www/html/controllers/smtp_interface.py";

// execute the at-job
$at_exec = "echo \"python $script_path $assignee $task_name $descript $deadline \" | at $exec_time $at_format";
exec($at_exec);
header("Location: ../views/task-details.php?task=$id");
?>