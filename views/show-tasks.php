<?php
    include ("../config/database.php");
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }

    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select * from todo_list where team_name = ? order by date_created desc";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt ->  bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $result = $stmnt -> get_result();
    $filter = $_POST['s-status'];

    if (isset($_POST['s-status'])) {
        $sql = "select * from todo_list where status = ? and team_name = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST['s-status'], $_SESSION["team"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();

        if ($_POST["s-status"] == 'SHOW ALL') {
            $sql = "select * from todo_list where team_name = ? order by deadline desc";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_SESSION["team"]);
            $stmnt -> execute();
            $result = $stmnt -> get_result();
        }
    }
    $total = mysqli_num_rows($result)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Tasks</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <?php include("./components/header.php"); ?>
    <div class="svg-bg">
        <div class="todo-flex">
            <div class="add-btn">
                <h3 class="ml2rem">
                    <a href="./create-task.php">
                        <span>Add Task</span>
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </h3>
            </div>
            <form method="POST" class="mr2rem">
                <select class="main-selector mr2rem" name="s-status" id="myselect" onchange="this.form.submit()">
                    <option value="none" selected disabled hidden>Filter by Status</option>
                    <option value="SHOW ALL">SHOW ALL</option>
                    <option value="NOT STARTED">NOT STARTED</option>
                    <option value="IN PROGRESS">IN PROGRESS</option>
                    <option value="STUCK">STUCK</option>
                    <option value="COMPLETED">COMPLETED</option>
                </select>
            </form>
        </div>
    </div>
    <div class="log-container">
        <?php echo "<h3>$total TASKS $filter</h3>";?>
        <form action="../edit_entry.php" method="post" id="tasks">
            <table class="data task-tab">
                <tr class="tbl-head">
                    <th>TITLE</th>
                    <th>STATUS</th>
                    <th>ASSIGNED TO</th>
                    <th>TEAM</th>
                    <th>IMPORTANCE</th>
                    <th>DATE CREATED</th>
                    <th>DUE DATE</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            echo "<tr onclick='getTask($id)'><td>".$row["title"]."</td>";
                            echo "<td>".$row["status"]."</td>";
                            echo "<td>".$row["assignee"]."</td>";
                            echo "<td>".$row["team_name"]."</td>";
                            echo "<td>".$row["importance"]."</td>";
                            echo "<td>".$row["date_created"]."</td>";
                            echo "<td>".$row["deadline"]."</td>";
                            echo "<td>".$row["time_due"]."</td></tr>";
                        }
                    }
                    else {
                        echo "<p>0 Results</p>";
                    }
                    $curs->close();
                ?>
            </table>
        </form>
    </div>
    <script>
        function getTask(id) {
            window.location = "./task-details.php?task="+id;
        }
    </script>
    <script src="../static/main.js"></script>
</body>
</html>