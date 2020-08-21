<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swoop.Team | Login</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../favicon.png" >
</head>
<body class="todo-bg">
    <nav class="topnav" id="myTopnav">
    <div class="index-nav parent-nav">
        <ul>
            <li>
                <a href="../index.html" class="active">Swoop.Team</a>
                <i class="fa fa-wifi"></i>
            </li>
        </ul>
    </div>
    </nav>
    <form action="../controllers/auth_user.php" method="post" class="spc-pt">
        <div class="form-container">
            <div class="todo-panel">
                <div class="inner-panel">
                    <h1>Login Form</h1>
                    <h3 class="sub-heading">Welcome back</h3>
                    <div class="flex-subs">
                        <label>Email:</label><br>
                        <input type="text" name="email" placeholder="Enter your email address" class="spc-n login-comp" required>
                        <br><br>
                        <label>Password:</label><br>
                        <input type="password" name="pswd" placeholder="Enter your password" class="spc-n login-comp" required>
                    </div>
                    <p>Don't have an account? <a href="./register.php">Sign up here.</a></p>
                    <br>
                    <input name="auth_user" class="spc-n" type="submit" id="form-control2">
                    <?php
                        if (isset($_GET["error"])) {
                            include("./error.php");
                            $err = new AuthenticationError();
                            echo $err->login_error();
                        }
                    ?>
                </div>
            </div>
        </div>
    </form>
</body>
</html>