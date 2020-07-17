<html>
<head>
	<?php 
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL); 
		include("./templates/head.php");
	?>
	<script>
		function loaddata() {
			$.ajax({
				url: "./controllers/show_msgs.php?room="+<?php echo $_GET['room'] ?>,
				success: function (response) {
					$( '#display_info' ).html(response);
				}
			});
			// recursive call to set timeout function
			setTimeout(loaddata, 1000);
		}
		loaddata();
	</script>
	<link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
	<?php 
		include("./templates/nav.php");
		include_once ('../../config/database.php');
        $database = new Database();
		$curs = $database->getConnection();
		
		if (isset($_POST['msg'])) {
			$sql = "insert into messages(name, msg, room_id) values(?, ?, ?)";
			$stmnt = mysqli_prepare($curs, $sql);
			$stmnt -> bind_param("sss", $_SERVER["REMOTE_ADDR"], $_POST["msg"], $_GET["room"]);
			$stmnt -> execute();
		}
	?>
	<div class="svg-bg">
        <div class="log-header">  
			<div>
				<h3 id="logs-title">Chatroom <?php echo $_GET["room"];?></h3>
			</div>
			<div class="add-btn">
				
				<a href="./join-chat.php">
					<i class="fa fa-arrow-circle-left"></i>
					Exit Room
				</a>
			</div>
		</div>
	</div>
	<div class="log-container">
		<div id="display_info" ></div>
	</div>
	<form method="post" class="fixed-bottom">
        <div class="input-group sender-style">
            <input type="text" name="msg" class="form-control" id="send-msg" placeholder="Enter you message here..." required>
            <span class="input-group-btn">
                <button type="submit" class="attach">Send Message</button>
            </span>
        </div>
    </form>
	<script src="../../static/main.js"></script>	 
</body>
</html>