<?php
    if (!isset($_GET["token"]))
        header("Location: ../index.php");

    include_once("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $token = $_GET["token"];
    if (isset($_POST["changer"])) {
        echo $_POST["changer"];
        $sql = "select email from tokens where token = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $token);
        
        
    
        if ($stmnt -> execute()) {
            echo "passed";
            $results = $stmnt -> get_result();
            $row = mysqli_fetch_assoc($results); 
            echo $row["email"];
            $sql = "update users set pswd = ? where email = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            // encrypt newly created password
            $hash = password_hash($_POST["pswd_1"], PASSWORD_BCRYPT);
            $stmnt -> bind_param("ss", $hash, $row["email"]);
            $stmnt -> execute();

            $sql = "delete from tokens where email = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $row["email"]);
            $stmnt -> execute();
            header("Location: ../authentication/login.php");
                
        }
    }
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
    <form class="spc-pt" id="reset-form" method="post">
        <div class="form-container">
            <div class="todo-panel">
                <div class="inner-panel">
                    <h2>Password Reset</h2>
                    <div class="flex-subs">
                        <label>New password:</label><br>
                        <input type="password" name="pswd_1" id="pswd_1" placeholder="Enter your new password" class="spc-n login-comp" required>
                        <br><br>
                    </div>
                    <br>
                    <input type="submit" class="spc-n" id="form-control2" name="changer" value="Reset Password">
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
