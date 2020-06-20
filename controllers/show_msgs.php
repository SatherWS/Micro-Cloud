<?php
/*
* Script executes continually to display new messages
*/
	include_once '../config/database.php';
	$database = new Database();
	$curs = $database->getConnection();

	if ($curs->connect_error) {
		die("Connection failed: " . $curs->connect_error);
	}
	$sql = "SELECT name,msg,time_submitted FROM messages where room_id = ? order by time_submitted desc;";
	mysqli_query($curs, $sql);
	$stmnt = mysqli_prepare($curs, $sql);
	$stmnt -> bind_param("s", $_GET["room"]);
	$stmnt -> execute();
	$results = $stmnt -> get_result();

	while($row = mysqli_fetch_assoc($results))
	{
		echo "<h3>".$row['name']."</h3>";
		echo "<p>".$row['msg']."</p>";
		echo "<p>".$row['time_submitted']."</p>";
	}
?>
