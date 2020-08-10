<?php
    include_once '../config/database.php';
    $database = new Database();
    $curs = $database->getConnection();

    if ($curs->connect_error) {
        die("Connection failed: " . $curs->connect_error);
    }
    
    if ($_POST['edit']) {
        $sql = "update journal set message = ? where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $journal_edit = str_replace("\'" , "'", $journal_edit);
        $journal_edit = $_POST['edited'];

        $stmnt -> bind_param("ss", $journal_edit, $_POST['edit']);
        $stmnt -> execute();
        header("Location: ../views/journal-details.php?journal=".$_POST['edit']);
    }
         
    if ($_POST['delete']) {
        $sql = "delete from todo_list where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ../views/show-tasks.php");
    }

    if (isset($_POST['modtask'])) {
        $id = $_POST['modtask'];
        $sql = "update todo_list set title=?, description=?, deadline=?, importance=?, status=? where id=?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ssssss", $_POST["title"], $_POST["description"], $_POST["end-date"], $_POST["importance"], $_POST['change-status'], $id);
        $stmnt -> execute();
        header("Location: ../views/task-details.php?task=".$id);
    }
    $curs -> close();

