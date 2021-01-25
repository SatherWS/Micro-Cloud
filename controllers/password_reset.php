<?php
    include_once("../config/database.php");

    $db = new Database();
    $curs = $db -> getConnection();

    $sql = "insert into tokens(email, token) values (?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);

    $token = random_bytes(20);
    $stmnt -> bind_param("ss", $_POST["email"], bin2hex($token));

    if ($stmnt -> execute()) {
        exec("python3 send_token.py ".$_POST["email"]);
        header("Location: ../../index.php?msg='Password reset has been sent'");
    }
    else
        header("Location: ../../index.php?msg='There was a problem password reset has not been sent'")

?>