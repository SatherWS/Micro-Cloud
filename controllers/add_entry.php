<?php
    include '../config/database.php';
   
    $database = new Database();
    $curs = $database->getConnection();
    
    if ($curs->connect_error) {
        die("Connection failed: " . $curs->connect_error);
    }

    // create journal entry
    if ($_POST['add-journal']) {
        $sql = "insert into journal(subject, message, rating) values (?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $subject = $_POST["jsubject"];
        $msg = nl2br($_POST["note"]);
        $rating = $_POST["rating"];
        $stmnt -> bind_param("sss", $subject, $msg, $rating);
        $stmnt -> execute();
        header("Location: ../views/logs.php");
    }

    // add task to todo list
    if ($_POST['add-task']) {
        $sql = "insert into TodoList(description, deadline, importance, time_due) values (?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject = $_POST["subs"]; 
            $end = $_POST["end-date"];
            $imprt = $_POST["importance"];
            $time = $_POST["time-due"];
            $stmnt -> bind_param("ssss", $subject, $end, $imprt, $time);
            $stmnt -> execute();
            header("Location: ../views/show-tasks.php");
        }
    }
    $curs -> close();
?>
