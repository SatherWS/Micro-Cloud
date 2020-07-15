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
        $msg = $_POST["note"];
        
        // check if check box is posted
        if (isset($_POST['omit'])) {
            $sql = "insert into journal(subject, message, category) values (?, ?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("sss", $subject, $msg, $category);
            $stmnt -> execute();
        }
        else {
            $sql = "insert into journal(subject, message, rating, category) values (?, ?, ?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("ssss", $subject, $msg, $rating, $category);
            $stmnt -> execute();
        }
        header("Location: ../views/logs.php");        
    }

    // add task to todo list
    if ($_POST['add-task']) {
        $sql = "insert into todo_list(title, description, deadline, time_due, importance) values (?, ?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sssss", $_POST["title"], $_POST["descript"], $_POST["end-date"], $_POST["time-due"], $_POST["importance"]);
        $stmnt -> execute();
        header("Location: ../views/create-task.php");
        //header("Location: ../views/show-tasks.php");
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
