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

?>
