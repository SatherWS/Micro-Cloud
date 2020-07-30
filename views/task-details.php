<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
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
    <?php
        include("./components/header.php");
        include ("../config/database.php");
        $database = new Database();
        $curs = $database->getConnection();

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
            $sql = "select * from todo_list where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
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
    <div class="svg-bg">
        <div class="todo-flex mr2rem">    
            <div class="review">
                <h3 id="logs-title">Task ID #<?php echo $_GET['task'];?></h3>
            </div>
            <div class="todo-flex">
                <form action="./task-details.php" method="post" class="mr2rem">
                    <button class="add-btn" type="submit" name="edit" value="<?php echo $_GET['task']; ?>"><i class="fa fa-edit"></i>Edit Task</button>
                </form>
                <form action="./task-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this task?');">
                    <button class="add-btn" type='submit' name='delete' value="<?php echo $_GET['task']; ?>"><i class='fa fa-close'></i>Delete</button>
                </form>
            </div>
        </div>
    </div>
    <div class="log-container">
        <form action="../controllers/edit_entry.php" method="post" class="task-auto">
            <?php
                if ($_GET['task'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h2>Task: ".$row['title']."</h2>";
                        echo "<p>".$row["description"]."</p>";
                        echo "<h3>Deadline: ".$row['deadline']." at ".$row["time_due"]."</h3>";
                        echo "<h3>Importance: ".$row['importance']."</h3>";
                        echo "<h4>STATUS: ".$row['status']."</h4>";
                    }
                }
                if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h2>Editing: ".$row['description']."</h2>";
                        echo "<lable>Edit Description</lable><br>";
                        echo "<input class='spc-n' id='form-control' name='edited'value='".$row['description']."'><br><br>";
                        echo "<lable>Change Deadline</lable><br>";
                        echo "<input type='date' name='end-date' class='spc-n' id='form-control'><br><br>";
                        echo "<lable>Change Time Due</lable><br>";
                        echo "<input type='time' name='time-due' class='spc-n' id='form-control'><br><br>";
                        echo "<label>Change Importance Level</label><br>";
                        echo "<select name='importance' class='spc-n' id='form-control'>";
                        echo "<option value='none' selected disabled hidden> Rank Importance</option>";
                        echo "<option value='Low'>Low Importance</option>";
                        echo "<option value='Medium'>Medium Importance</option>";
                        echo "<option value='High'>High Importance</option></select><br><br>";
                    }
                }
            ?>
            <label>Change Status</label><br>
            <select name="change-status" class='spc-n' id="form-control">
                <option value="none" selected disabled hidden> 
                    Update Status
                </option>
                <option value="COMPLETED">COMPLETED</option> 
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="STUCK">STUCK</option>
                <option value="DISTRACTED">DISTRACTED</option>
            </select>
            <br><br>
            <button class="attach" type="submit" name="modtask" value="<?php echo $_GET['task'];?>">
                Update Task
            </button>
        </form>
    </div>
    <script src="../static/main.js"></script>
</body>
</html>
