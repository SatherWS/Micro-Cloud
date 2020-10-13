<?php
    include ("../config/database.php");
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select *,  date_format(date_created, '%m-%d-%y') as st, date_format(deadline, '%m-%d-%y') as dt from todo_list where team_name = ? order by deadline desc";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt ->  bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $result = $stmnt -> get_result();
    $filter = $_POST['s-status'];

    if (isset($_POST['s-status'])) {
        $sql = "select *,  date_format(deadline, '%m-%d-%Y') as dt, date_format(date_created, '%m-%d-%Y') as st from todo_list where status = ? and team_name = ? order by deadline desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST['s-status'], $_SESSION["team"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();

        if ($_POST["s-status"] == 'SHOW ALL') {
            $sql = "select *, date_format(deadline, '%m-%d-%Y') as dt, date_format(date_created, '%m-%d-%Y') as st from todo_list where team_name = ? order by deadline desc";
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
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <?php include("./components/header.php");?>
    <?php include("./components/modals/modal.php");?>
    <div class="svg-bg">
        <div class="todo-flex">
            <p class="welcome"><?php echo $_SESSION["team"];?></p>
            <p class="welcome"><?php echo $_SESSION["unq_user"];?></p>
        </div>
    </div>
    <div class="dash-grid r-cols" id="main">
        <?php include("./components/sidebar.php");?>
        <div class="log-container">
            <div class="todo-flex">
                <?php echo "<h3>$total TOTAL TASKS $filter</h3>";?>
                <section class="todo-flex">
                    <form method="POST">
                        <select class="main-selector mr2rem" name="s-status" id="myselect" onchange="this.form.submit()">
                            <option value="none" selected disabled hidden>Search by Status</option>
                            <option value="SHOW ALL">SHOW ALL</option>
                            <option value="NOT STARTED">NOT STARTED</option>
                            <option value="IN PROGRESS">IN PROGRESS</option>
                            <option value="STUCK">STUCK</option>
                            <option value="COMPLETED">COMPLETED</option>
                        </select>
                    </form>
                    <div class="add-btn">
                        <h3>
                            <a href="./create-task.php">
                                <span>Add Task</span>
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h3>
                    </div>
                </section>
            </div>
            <form action="../edit_entry.php" method="post" id="tasks">
                <table class="data task-tab">
                    <tr class="tbl-head">
                        <th>DEADLINE</th>
                        <th>TITLE</th>
                        <th>STATUS</th>
                        <th>ASSIGNED TO</th>
                        <th class="text-center">IMPORTANCE</th>
                        <th>DATE CREATED</th>
                    </tr>
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $id = $row["id"];
                                echo "<tr onclick='getTask($id)'><td>".$row["dt"]."</td>";
                                echo "<td>".$row["title"]."</td>";
                                echo "<td>".$row["status"]."</td>";
                                echo "<td>".$row["assignee"]."</td>";
                                echo "<td class='text-center'>".$row["importance"]."</td>";
                                echo "<td>".$row["st"]."</td></tr>";
                            }
                        }
                    ?>
                </table>
            </form>
        </div>        
    </div>
    <script>
        function getTask(id) {
            window.location = "./task-details.php?task="+id;
        }
    </script>
    <script src="../static/main.js"></script>
    <script src="../static/modal.js"></script>
</body>
</html>
