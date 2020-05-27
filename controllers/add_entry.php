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
        $rating = $_POST["rating"];
        $msg = nl2br($_POST["note"]);
        
        if ($_POST['omit']) {
            $data = array('subject'=> $subject, 'message' => $msg, 'rating' => null);
        }
        else {
            $data = array('subject'=> $subject,'message' => $msg, 'rating'=> $rating);
        }
        header("Location: ../views/categories.php?".http_build_query($data));
    }
    /*
    if ($_POST['category']) {
        $category = $_POST['category'];
        $sql = "insert into journal(subject, message, rating, category) values (?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ssss", $_GET['subject'], $_GET['message'], $_GET['rating'], $category);
        $stmnt -> execute();
        header("Location: ../views/logs.php");
    }
    */
    /*
    if ($_POST['add-category']) {
        $sql = "update journal set category = ? where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_GET['id'], $_POST['category']);
        $stmnt -> execute();
        header("Location: ../views/logs.php");
    }
    */

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
        header("location: ../views/polls.php");
    }

    /*
    // cast vote to selected poll
    if ( $_POST["ballot"]) {
        $sql = "INSERT INTO votes(topic_id, vote, username) VALUES(?, ?, ?)";
        $stmnt = $mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_GET["topic"],)
        if ( $insert ) {
            echo "Success! Row ID: {$db->insert_id}";
            header("location: ../views/polls.php");
        } 
    }
    */
    // chatroom if statement here

    $curs -> close();
?>
