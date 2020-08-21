<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include("./components/task-editor.php");
    $editor = new TaskEditor();

    // TODO: MOVE BELOW THIS TO CONTROLLERS v
    include("../config/database.php");
    $database = new Database();
    $curs = $database->getConnection();

    if (isset($_GET['task'])) {
        $id = $_GET['task'];
        $sql = "select * from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $show_editor = true;
    }

    if (isset($_POST['edit'])) {
        $id = $_POST['edit'];
        $sql = "select *, date(date_created) from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $row = mysqli_fetch_assoc($results);
        $show_editor = false;
    }

    if ($_POST['delete']) {
        $sql = "delete from todo_list where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./show-tasks.php");
    }
    // TODO: MOVE ALL ABOVE THIS TO CONTROLLERS ^
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <title>Task Details</title>
</head>
<body>
    <?php include("./components/header.php"); ?>
    <div class="svg-bg">
        <div class="todo-flex btn-spcing">    
            <?php
                if ($show_editor)
                    include("./components/task-headers/edit_task.php");
                else
                    include("./components/task-headers/save_task.php");
            ?>
        </div>
    </div>
    <div class="task-panel">
        <form action="../controllers/edit_entry.php" method="post" class="task-auto" id="editor2">
            <div class="inner-task-panel">
            <?php
                if ($_GET['task'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<div class='todo-flex r-cols'><div>";
                        echo "<h2>Task: ".$row['title']."</h2>";
                        echo "<p>".$row["description"]."</p>";
                        echo "<p><b>Status:</b> ".$row['status']."</p>";
                        echo "<p><b>Assigned To:</b> ".$row['assignee']."</p>";
                        echo "<p><b>Importance:</b> ".$row['importance']."</p>";
                        echo "<p><b>Created:</b> ".$row['date_created']."</p>";
                        echo "<p><b>Deadline:</b> ".$row['deadline']."</p></div>";
                        echo "<div><h3><a href='#' class='add-btn'>Create Sub Task</a></h3></div></div>";
                    }
                }
                // Task editting view render
                if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
                    echo $editor->create_editor($row);
                }
            ?>
            </div>
        </form>
    </div>
    <script>
    function triggerForm2() {
        document.getElementById("editor2").submit();
    }
    </script>
    <script src="../static/main.js"></script>
</body>
</html>
