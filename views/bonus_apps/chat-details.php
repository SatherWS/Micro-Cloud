<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../static/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		function loaddata() {
			$.ajax({
				url: "../controllers/show_msgs.php?room="+<?php echo $_GET['room'] ?>,
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
		include("./components/header.php");
		include_once ('../config/database.php');
        $database = new Database();
		$curs = $database->getConnection();
		
		if ($_POST['msg']) {
			$sql = "insert into messages(name, msg, room_id) values(?, ?, ?)";
			$stmnt = mysqli_prepare($curs, $sql);
			$stmnt -> bind_param("sss", $_SERVER["REMOTE_ADDR"], $_POST["msg"], $_GET["room"]);
			$stmnt -> execute();
		}
	?>
	<div class="svg-bg">
        <div class="log-header">  
			<div>
				<h3 id="logs-title">Chatroom</h3>
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
	<script src="../static/main.js"></script>	 
</body>
</html>