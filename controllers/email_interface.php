<?php
include_once("../config/database.php");

$db = new Database();
$curs = $db -> getConnection();

$id = $_POST["taskid"];
$id = 53;

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

$task_name = $row[0];
$descript = $row[1];
$deadline = $row[2];

$at_format = substr($exec_date, 5, 2).substr($exec_date, 8, 2).substr($exec_date, 2, 2);
$script_path = "/var/www/html/controllers/email_sender.php";

// execute at-job
echo file_put_contents("test.txt","Hello World. Fuck you!");
$at_exec = "echo '$script_path' '$assignee' '$task_name' '$descript' '$deadline' | at $exec_time $at_format";
exec($at_exec);


// error log
exec("echo 'Command Executed!\n' > /var/uploads/at-logs.txt");
exec("echo $at_exec >> /var/uploads/at-logs.txt");
header("Location: ../views/task-details.php?task=$id");
?>
