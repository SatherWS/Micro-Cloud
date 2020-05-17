<?php
    include "../config/database.php";
    $database = new Database();
    $curs = $database->getConnection();

    $sql = "insert into messages(name, msg) values(?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $user = $_POST["username"];
    $msg = $_POST["message"];
    $stmnt -> bind_param("ss", $user, $msg);
?>