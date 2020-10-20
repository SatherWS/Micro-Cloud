<?php
    include_once ("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnetion();

    $sql = "call delete_project(?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_POST["project"]);
    if ($stmnt -> execute())
        header("Location: ../views/settings.php?msg='project has been deleted.'");
    else
        header("Location: ../views/settings.php?error='project has not been deleted.'");
?>