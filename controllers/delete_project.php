<?php
    include_once ("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $proj = $_POST["project"];

    $sql = "call delete_project(?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $proj);
    if ($stmnt -> execute())
        header("Location: ../views/settings.php?msg= $proj has been deleted.");
    else
        header("Location: ../views/settings.php?error= $proj has not been deleted.");
?>