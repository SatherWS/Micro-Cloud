<?php
    include_once("../config/database.php");

    $db = new Database();
    $curs = $db -> getConnection();

    if (isset($_POST["send-reset"])) {
        $sql = "insert into tokens(email, token) values (?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $token = random_bytes(20);
        $token = bin2hex($token);
        $reciever = $_POST["email"];

        $stmnt -> bind_param("ss", $reciever, $token);
        $script_path = "/var/www/html/controllers/send_token.py";

        if ($stmnt -> execute()) {
            exec("python3 $script_path $reciever $token");
            header("Location: ../index.php?msg='Password reset has been sent'");
        }
        else
            header("Location: ../index.php?msg='There was a problem password reset has not been sent'");
    }
    
    else if (isset($_POST["changer"])) {
        $sql = "select email from tokens where token = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_GET["token"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
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
            }
        }
    }
?>