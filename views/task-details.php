<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include("../config/database.php");
    include("./components/task-editor.php");
    $database = new Database();
    $curs = $database->getConnection();
    $editor = new TaskEditor();

    if ($_GET['task']) {
        $id = $_GET['task'];
        $sql = "select * from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
    }

    if ($_POST['edit']) {
        $id = $_POST['edit'];
        $sql = "select *, date(date_created) from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $row = mysqli_fetch_assoc($results);
    }

    if ($_POST['delete']) {
        $sql = "delete from todo_list where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./show-tasks.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <?php include("./components/header.php"); ?>
    <div class="svg-bg">
        <div class="todo-flex btn-spcing">    
            <form action="./task-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this task?');">
                <button class="add-btn" type='submit' name='delete' value="<?php echo $_GET['task']; ?>"><i class='fa fa-close'></i>Delete Task</button>
            </form>
            <form action="./task-details.php" method="post">
                <button class="add-btn" type="submit" name="edit" value="<?php echo $_GET['task']; ?>"><i class="fa fa-edit"></i>Edit Task</button>
            </form>
        </div>
    </div>
    <div class="task-panel">
        <form action="../controllers/edit_entry.php" method="post" class="task-auto">
            <div class="inner-task-panel">
            <?php
                if ($_GET['task'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h2>Task: ".$row['title']."</h2>";
                        echo "<p>".$row["description"]."</p>";
                        echo "<p><b>Status:</b> ".$row['status']."</p>";
                        echo "<p><b>Created:</b> ".$row['date_created']."</p>";
                        echo "<p><b>Deadline:</b> ".$row['deadline']."</p>";
                        echo "<p><b>Importance:</b> ".$row['importance']."</p>";
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
    <script src="../static/main.js"></script>
</body>
</html>
