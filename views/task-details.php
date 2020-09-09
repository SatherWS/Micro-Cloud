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

    // csather TODO: optimize this piece, may not be necessary to always run join command
    if (isset($_GET['task'])) {
        $id = $_GET['task'];
        //$sql = "select todo_list.*, sub_tasks.* from todo_list right join sub_tasks on todo_list.id=sub_tasks.task_id where todo_list.id = ?";
        $sql = "select * from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $show_editor = true;
        $sql = "select * from sub_tasks where task_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        if ($stmnt -> execute())
            $results2 = $stmnt -> get_result();
    }

    if (isset($_POST['edit'])) {
        $id = $_POST['edit'];
        // edit main task
        $sql = "select *, date(date_created) from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $row = mysqli_fetch_assoc($results);
        // edit sub tasks
        /*
        $sql = "select * from sub_tasks where task_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        if ($stmnt -> execute()) {
            $results = $stmnt -> get_result();
            $row2 = $stmnt->get_result();
        }
        */
        $show_editor = false;
    }

    if (isset($_POST['delete'])) {
        $sql = "delete from sub_tasks where task_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt-> bind_param("s", $_POST['delete']);
        $stmnt->execute();
        $sql = "delete from todo_list where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./show-tasks.php");
    }
    // TODO: MOVE ALL ABOVE THIS TO CONTROLLERS ^
    // Creator and assignee selector elements
    function team_mates($curs, $team) {
        $selector = "<label>Change Assignee</label><br>";
        $selector .= "<select name='change-assignee' class='spc-n' required>";
        $selector2 = "<label>Change Creator</label><br>";
        $selector2 .= "<select name='change-creator' class='spc-n' required>";

        // TODO: Set value of assignee and creator to current assignee/creator.
        //       Let the values of the other options be each member of the team.

        $sql = "select distinct assignee, creator from todo_list where team_name = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("s", $team);
        $stmnt->execute();
        $result = $stmnt->get_result();
        while ($row = mysqli_fetch_assoc($result)) {
            $selector .= "<option value='".$row["assignee"]."'>".$row["assignee"]."</option>";
            $selector2 .= "<option value='".$row["creator"]."'>".$row["creator"]."</option>";
        }
        $selector .= "</select><br><br>";
        $selector2 .= "</select>";
        $selectors = $selector.=$selector2;
        return $selectors;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <title>Task Details</title>
</head>
<body>
    <?php include("./components/header.php");?>
    <?php include("./components/modals/subtask_modal.php");?>
    <div class="svg-bg sticky">
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
                        echo "<h2>Main Task: ".$row['title']."</h2>";
                        echo "<p>".$row["description"]."</p>";
                        echo "<div class='todo-flex align-initial r-cols'>";
                        echo "<div><p><b>Status:</b> ".$row['status']."</p>";
                        echo "<p><b>Start Date:</b> ".$row['date_created']."</p>";
                        echo "<p><b>End Date:</b> ".$row['deadline']."</p></div>";
                        echo "<div><p><b>Importance:</b> ".$row['importance']."</p>";
                        echo "<p><b>Assigned To:</b> ".$row['assignee']."</p>";
                        echo "<p><b>Created By:</b> ".$row['creator']."</p></div></div>";
                        echo "<br><h5 class='text-right'><a href='#subModal' class='add-btn-2' id='myBtn'>";
                        echo "Add Sub Task</a>";
                        echo "</h5>";
                    }
                }
                if (isset($results2)) {
                    while ($row = mysqli_fetch_assoc($results2)) {
                        echo "<br><div class='uline'></div>";
                        echo "<br><h3>Sub Task: ".$row["title"]."</h3>";
                        echo "<p>".$row["descript"]."</p>";
                        echo "<div class='todo-flex align-initial r-cols'>";
                        echo "<div><p><b>Status:</b> ".$row['status']."</p>";
                        echo "<p><b>Start Date:</b> ".$row['date_created']."</p>";
                        echo "<p><b>End Date:</b> ".$row['deadline']."</p></div>";
                        echo "<div><p><b>Importance:</b> ".$row['importance']."</p>";
                        echo "<p><b>Assigned To:</b> ".$row['assignee']."</p>";
                        echo "<p><b>Created By:</b> ".$row['creator']."</p></div></div>";
                    }
                }
                // Task editting view render
                $form = "";
                if (isset($_POST['edit']) && mysqli_num_rows($results) > 0) {
                    $form .= $editor->create_editor($row);
                    //$form .= create_selector($curs, $_SESSION["team"]);
                    $form .= "</div></div>";
                    $form .= $editor->additionals($row);
                    /*
                    if (isset($row2))
                        $form .= $editor->create_editor($row2);
                    */
                    echo $form;
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
    <script src="../static/modal.js"></script>
</body>
</html>
