<?php
    include_once '../config/database.php';
    $database = new Database();
    $curs = $database->getConnection();

    if ($curs->connect_error) {
        die("Connection failed: " . $curs->connect_error);
    }

    $sql = "update journal set message = ? where id = ?";
    mysqli_query($curs, $sql);
    
    if ($_POST['edit']) {
        $stmnt = mysqli_prepare($curs, $sql);
        $journal_edit = $_POST['edited'];
        $stmnt -> bind_param("ss", $journal_edit, $_POST['edit']);
        $stmnt -> execute();
        header("Location: ./views/journal-details.php?journal=".$_POST['edit']);
        echo $_POST['edit'];
    }
         
    if ($_POST['delete']) {
        $sql = "delete from todolist where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./views/show-tasks.php");
    }

    if ($_POST['change-status']) {
        $id = $_POST['task-id'];
        $sql = "update todolist set status = ? where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST['change-status'], $id);
        $stmnt -> execute();
        header("Location: ./views/task-details.php?task=".$id);
    }
    $curs -> close();

?>