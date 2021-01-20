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
	$results = $stmnt -> get_result();
	$row = mysqli_fetch_row($results);
	
	$task_name = $row[0];
	$descript = $row[1];
	$deadline = $row[2];

	$at_format = substr($exec_date, 5, 2).substr($exec_date, 8, 2).substr($exec_date, 2, 2);
	$script_path = "/var/www/html/controllers/email_sender.php";

	exec("echo $script_path '$assignee' '$task_name' '$descript' '$deadline' | at $exec_time $at_format");
	
	echo "Command Executed!<br>";
	echo "echo $script_path '$assignee' '$task_name' '$deadline' | at $exec_time $at_format";
	header("Location: ../views/task-details.php?task=$id");
?>
