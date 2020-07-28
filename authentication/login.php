<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consciencec | Login</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <div class="todo-bg">
        <form action="../controllers/auth_user.php" method="post" class="spc-pt">
            <div class="form-container">
                <div class="todo-panel">
                    <h1>Login Here</h1>
                    <p>Welcome back, if you wish to return to the home page <a href="../index.html">click here.</a></p>
                    <div class="flex-subs">
                        <label>Email:</label><br>
                        <input type="text" name="email" placeholder="Enter your Email address" class="spc-n login-comp" required>
                        <br><br>
                        <label>Password:</label><br>
                        <input type="password" name="pswd" placeholder="Enter your password" class="spc-n login-comp" required>
                    </div>
                    <br>
                    <p>Don't have an account? <a href="./signup.php">Sign up here.</a></p>
                    <input name="auth_user" class="spc-n spc-m" type="submit" id="form-control2">
                    <?php
                        if (isset($_GET["error"])) {
                            include("./error.php");
                            $err = new AuthenticationError();
                            echo $err->login_error();
                        }
                    ?>
                </div>
            </div>
        </form>
    </div>    
</body>
</html>