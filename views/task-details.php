<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="topnav" id="myTopnav">
        <ul>
            <li>
                <a href="../index.html" class="active">Micro Cloud</a>
                <i class="fa fa-mixcloud"></i>
            </li>
            <li>
                <a href="#">User Stats</a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Todo App</a>
                <div class="dropdown-content">
                    <a href="../todo-list.html">Add Task</a>
                    <a href="./show-tasks.php">Manage Tasks</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Journal App</a>
                <div class="dropdown-content">
                    <a href="../journal.html">Create Entry</a>
                    <a href="./logs.php">All Entries</a>
                </div>
            </li>
            <li style="float:right"><a href="#">Donate</a></li>
            <li style="float:right"><a href="#">Login</a></li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </nav>
    <?php
        include "../config/database.php";
        $database = new Database();
        $curs = $database->getConnection();

        if ($_GET['task']) {
            $id = $_GET['task'];
            $sql = "select * from todolist where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
        }

        if ($_POST['edit']) {
            $id = $_POST['edit'];
            $sql = "select * from todolist where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
        }

        if ($_POST['delete']) {
            $sql = "delete from todolist where id = ?";
            mysqli_query($curs, $sql);
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_POST['delete']);
            $stmnt -> execute();
            header("Location: ./show-tasks.php");
        }
    ?>
    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h2 id="logs-title">Task ID #<?php echo $_GET['task'];?></h2>
            </div>
            <div class="add-log">
                <form action="./task-details.php" method="post">
                    <button type="submit" name="edit" value="<?php echo $_GET['task']; ?>"><i class="fa fa-edit"></i>Edit Task</button>
                    <button type='submit' name='delete' value="<?php echo $_GET['task']; ?>"><i class='fa fa-close'></i>Delete Task</button>
                </form>
            </div>
        </div>
    </div>
    <div class="log-container">
        <form action="../controllers/edit_entry.php" method="post">
            <?php
                if ($_GET['task'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h3>Task: ".$row['description']."</h3>";
                        echo "<h3>Deadline: ".$row['deadline']." at ".$row["time_due"]."</h3>";
                        echo "<h3>Importance: ".$row['importance']."</h3>";
                        echo "<h4>STATUS: ".$row['status']."</h4>";
                    }
                }
                if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h3>Editing: ".$row['description']."</h3>";
                        echo "<lable>Edit Description</lable><br>";
                        echo "<input class='spc-n' id='form-control' name='edited'value='".$row['description']."'><br><br>";
                        echo "<lable>Change Deadline</lable><br>";
                        echo "<input type='date' name='end-date' id='edit-drop' class='spc-n' required>";
                        echo "<input type='time' name='time-due' class='spc-n' required><br><br>";
                        echo "<label>Change Importance Level</label><br>";
                        echo "<select id='edit-drop' name='importance' class='spc-n' required>";
                        echo "<option value='none' selected disabled hidden> Rank Importance</option>";
                        echo "<option value='Low'>Low Importance</option>";
                        echo "<option value='Medium'>Medium Importance</option>";
                        echo "<option value='High'>High Importance</option></select>";
                        echo "<input type='submit' value='Edit Task'>";

                    }
                }
            ?>
            <br>
            <select name="change-status" class='spc-n'>
                <option value="none" selected disabled hidden> 
                    Update Status
                </option>
                <option value="COMPLETED">COMPLETED</option> 
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="STUCK">STUCK</option>
                <option value="DISTRACTED">DISTRACTED</option>
            </select>
            <br><br>
            <button class="attach" type="submit" name="task-id" value="<?php echo $_GET['task']?>" id="update">
                Update Task
            </button>
            <button>
                <a href="./show-tasks.php">Go Back</a>
            </button>
        </form>
    </div>
</body>
</html>