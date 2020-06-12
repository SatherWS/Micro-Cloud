<?php
    include ('../config/database.php');
   
    $database = new Database();
    $curs = $database->getConnection();
    
    if ($curs->connect_error) {
        die("Connection failed: " . $curs->connect_error);
    }

    // create journal entry
    if ($_POST['add-journal']) {
        $subject = $_POST["jsubject"];
        $category = $_POST["category"];
        $rating = $_POST["rating"];
        $msg = nl2br($_POST["note"]);
        
        if ($_POST['omit']) {
            //$data = array('subject'=> $subject, 'message' => $msg, 'rating' => null);
            $sql = "insert into journal(subject, message, category) values (?, ?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("sss", $subject, $msg, $category);
            $stmnt -> execute();
        }
        else {
            //$data = array('subject'=> $subject,'message' => $msg, 'rating'=> $rating);
            $sql = "insert into journal(subject, message, rating, category) values (?, ?, ?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("ssss", $subject, $msg, $rating, $category);
            $stmnt -> execute();
        }
        header("Location: ../views/logs.php");        
    }

    // add task to todo list
    if ($_POST['add-task']) {
        echo $_POST['add-task'];
        $sql = "insert into todolist(description, deadline, importance, time_due) values (?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $subject = $_POST["subs"]; 
        $end = $_POST["end-date"];
        $imprt = $_POST["importance"];
        $time = $_POST["time-due"];
        $stmnt -> bind_param("ssss", $subject, $end, $imprt, $time);
        $stmnt -> execute();
        header("Location: ../views/show-tasks.php");
    }

    // add voting topic to table of polls
    if ($_POST["topic"] && $_POST["admin"]) {
        $sql = "insert into polls(admin, topic) values (?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST['admin'], $_POST['topic']);
        $stmnt -> execute();
        header("Location: ../views/polls.php");
    }

    // add chatroom to database
    if ($_POST['add-chatroom']) {
        $sql = "insert into chatroom(subject, creator) values(?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST["room"], $_POST["username"]);
        $stmnt -> execute();
        header("Location: ../views/join-chat.php");
    }

    $curs -> close();
?>
