<?php
    if (!isset($_GET["token"]))
        header("Location: ../index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swoop.Team | Reset password</title>
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
                <a href="../index.php" class="active">Swoop.Team</a>
                <i class="fa fa-wifi"></i>
            </li>
        </ul>
    </div>
    </nav>
    <form class="spc-pt" id="reset-form" action="../controllers/password_reset.php">
        <div class="form-container">
            <div class="todo-panel">
                <div class="inner-panel">
                    <h1>Change Password</h1>
                    <div class="flex-subs">
                        <label>New password:</label><br>
                        <input type="password" name="pswd_1" id="pswd_1" placeholder="Enter your new password" class="spc-n login-comp" required>
                        <br><br>
                        <label>Repeat new password:</label><br>
                        <input type="password" name="pswd_2" id="pswd_2" placeholder="Repeat your password" class="spc-n login-comp" required>
                    </div>
                    <br>
                    <button type="button" class="spc-n" id="form-control2" name="changer" onclick="checkPasswords()">Reset Password</button>                   
                    <?php
                        if (isset($_GET["error"])) {
                            include("./error.php");
                            $err = new AuthenticationError();
                            echo $err->login_error();
                        }
                    ?>
                    <p id="result-msg"></p>
                </div>
            </div>
        </div>
    </form>
    <script>
        function checkPasswords() {
            var p1 = document.getElementById("pswd_1").value;
            var p2 = document.getElementById("pswd_2").value;
            var result = document.getElementById("result-msg");
            var form = document.getElementById("reset-form");

            if (p1 != p2)
                result.innerHTML = "ERROR: passwords must match";
            else
                form.submit();  
        }
    </script>
</body>
</html>