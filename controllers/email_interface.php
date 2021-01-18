<?php
	$path = "/var/www/html/controllers/email_sender.php ";
	$assignee = $_POST["assignee"];
	$id = $_POST["taskid"];

	exec("php $path '$assignee ' '$id '");
	
	header("Location: ../views/task-details.php?task=$id");
	
	// Scheduler quick start
	// at 23:04 011821 -f ~/script.php
?>
