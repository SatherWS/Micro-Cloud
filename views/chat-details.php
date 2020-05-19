<html>
<head>
	<link rel="stylesheet" href="../static/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		// In flask app change user_name to session variable
		function loaddata()
		{
		$.ajax({
			url: "../controllers/show-msgs.php?room="+<?php echo $_GET['room'] ?>,
			success: function (response) {
				$( '#display_info' ).html(response);
			}
		});
		// recursive call to set timeout function
		setTimeout(loaddata, 1000);
		}
		loaddata();
	</script>
</head>
<body>
	<?php include("../views/components/header.php");?>
	<div class="svg-bg">
        <div class="log-header">  
			<div>
				<h3 id="logs-title">Chatroom</h3>
			</div>
			<div>
				<a href="#">Exit Room</a>
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
                <button type="submit" class="btn btn-secondary">Send Message</button>
            </span>
        </div>
    </form>
	<script src="../static/main.js"></script>	 
</body>
</html>