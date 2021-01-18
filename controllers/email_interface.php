<?php
	include_once("../config/database.php");

	$db = new Database();
	$curs = $db -> getConnection();

	$assignee = $_POST["assignee"];
	$exec_datetime = $_POST['remind-date'].' '.$_POST['remind-time'];
	$id = $_POST["taskid"];

	// get scheduled task
	$sql = "select title, deadline from todo_list where id = ?";
	$stmnt = mysqli_prepare($curs, $sql);
	$stmnt -> bind_param("s", $id);
	$stmnt -> execute();
	$results = $stmnt -> get_result();
	$row = mysqli_fetch_row($results);
	
	$task_name = $row[0];
	$deadline = $row[1];

	echo $task_name."\n";
	echo $exec_datetime."\n";
	echo $assignee."\n";
	echo $deadline."\n";

	$sql = "insert into reminders(assignee, task_name, deadline, exec_time) values (?, ?, ?, ?)";
	$stmnt = mysqli_prepare($curs, $sql);
	$stmnt -> bind_param("ssss", $assignee, $task_name, $deadline, $exec_datetime);
	$stmnt -> execute();

	$exec_date = $_POST['remind-date'];
	$at_format = substr($exec_date, 5, 2).substr($exec_date, 8, 2).substr($exec_date, 2, 2);

	exec("at ".$_POST["remind-time"]." ".$at_format." -f /var/www/html/controllers/email_sender.php");
	echo "<br>";
	echo "at ".$_POST["remind-time"]." ".$at_format." -f /var/www/html/controllers/email_sender.php"
	
	/*
	// attempt 1 at shell script creator
	exec("echo '#!/usr/bin/sh' > /var/www/html/models/scheduler/test-job.sh");
	exec("echo  '<?php' >> /var/www/html/models/scheduler/test-job.sh");
	exec("echo '$path  $assignee' >> /var/www/html/models/scheduler/test-job.sh");
	exec("echo '?>' >> /var/www/html/models/scheduler/test-job.sh");
	exec("chmod u+x /var/www/html/models/scheduler/test-job.sh");
	header("Location: ../views/task-details.php?task=$id");

	// attempt 2 at shell script creator
	echo file_put_contents("/var/www/html/models/scheduler/test-script.sh", "#!/usr/bin/sh");
	$shell_script = fopen("/var/www/html/models/scheduler/test-script.sh", "w") or die("Unable to open file!");
	$code = "\n";
	$code .= "<?php \n";
	$code .= $path." ".$assignee;
	$code .= "?>";
	fwrite($shell_script, $code);
	fclose($shell_script);
	*/


?>
