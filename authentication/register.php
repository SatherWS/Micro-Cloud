<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swoop.Team | Sign Up</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <nav class="topnav" id="myTopnav">
    <div class="index-nav parent-nav">
        <ul>
            <li>
                <!-- Team Steep vs. Team Stoop -->
                <a href="../index.php" class="active">Swoop.Team</a>
                <i class="fa fa-wifi"></i>
            </li>
        </ul>
    </div>
    </nav>
    <div class="todo-bg">
        <form action="../controllers/auth_user.php" method="post" class="spc-pt">
            <div class="form-container">
                <div class="todo-panel">
                    <div class="inner-panel">
						<div class="text-center">
							<h1>Join Our Community</h1>
						</div>
                        <label>Email</label><br>
                        <input type="email" name="email" placeholder="Enter a valid email address" class="spc-n login-comp" required>
                        <br><br>
                        <label>Username</label><br>
                        <input type="text" name="usr" placeholder="Create a username" class="spc-n login-comp" required>
                        <br><br>
                        <label>Password</label><br>
                        <input type="password" name="pswd" placeholder="Create a password" class="spc-n login-comp" required>
                        <br>
                        <br>
						<div class="text-center">
                            <?php 
                                echo "<div class='error-msg'>";
                                echo "<p>".$_GET["error"]."</p></div>";
                            ?>
							<p>Already have an account? <a href="./login.php">Sign in here.</a></p>
							<input name="add_user" class="spc-n spc-m" type="submit" id="form-control2">
						</div>
                    </div>
                </div>
            </div>
        </form>
    </div>   
</body>
</html>