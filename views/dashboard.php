<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $html = "";

    if ($_POST["options-a"] == "all_posts") {
        $sql = "select * from journal where team_name = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $html .= "<div class='activity'><div class='todo-flex'>";
                $html .= "<div><h2>Post: ".$row["subject"]."</h2>";
                $html .= "<p>".$row["message"]."</p></div>";
                $html .= "<div><p>Created by ".$row["creator"]."</p>";
                //$html .= "<p>Assigned to ".$row["assignee"]."</p></div></div>";
                $html .= "<div class='todo-flex'>";
                $html .= "<p class='activity-item'>".$row["description"]."</p>";
                $html .= "<small>Posted: ".$row["date_created"]."</small></div></div>";
            }
        }
    }

    // select all tasks by team
    if ($_POST["options-a"] == "all_tasks" || $_SERVER["REQUEST_METHOD"] != "POST") {
        $sql = "select * from todo_list where team_name = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        while ($row = mysqli_fetch_assoc($results)) {
            $html .= "<div class='activity'><div class='todo-flex'>";
            $html .= "<div><h2>Task: ".$row["title"]."</h2>";
            $html .= "<h3>Deadline: ".$row["time_due"]." ".$row["deadline"]."</h3></div>";
            $html .= "<div><p>Created by ".$row["creator"]."</p>";
            $html .= "<p>Assigned to ".$row["assignee"]."</p></div></div>";
            $html .= "<div class='todo-flex'>";
            $html .= "<p class='activity-item'>".$row["description"]."</p>";
            $html .= "<small>Posted: ".$row["date_created"]."</small></div></div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamstoop | Dashboard</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg">
    <?php include("./components/header.php");?>
    <main>
        <div class="home-intro">
            <h1 class="intro-header">Welcome <?php echo $_SESSION["user"];?></h1>
            <h2>Team: <?php echo $_SESSION["team"];?></h2>
        </div>
        <div class="grid-container">
            <div>
                <a class="dash-item" href="./logs.php">
                    <i class="fa  fa-pencil spc-1"></i>
                    <br>
                    <span class="sup-text">View Notes</span>
                </a>
            </div>
            <div>
                <a class="dash-item" href="./show-tasks.php">
                    <i class="fa fa-list-ol spc-1"></i>
                    <br>
                   <span class="sup-text">View Tasks</span> 
                </a>
            </div>
            <div>
                <a class="dash-item" href="./analytics.php">
                    <i class="fa fa-line-chart spc-1"></i>
                    <br>
                   <span class="sup-text">Analytics</span> 
                </a>
            </div>
            <div>
                <a class="dash-item" href="./analytics.php">
                    <i class="fa fa-gear spc-1"></i>
                    <br>
                   <span class="sup-text">Settings</span> 
                </a>
            </div>   
        </div>
        <div class="todo-flex">
            <h1 class="intro-header">My Team's Activity</h1>
            <form method="POST">
            <!--            
                <select class="main-selector" name="teams-a" id="myselect" onchange="this.form.submit()">
                    <option value="show_all" selected>All Teams</option>
                    <option value="posts">placeholder 1</option>
                    <option value="tasks">placeholder 2</option>
                </select>
            -->
                <select class="main-selector" name="options-a" id="myselect" onchange="this.form.submit()">
                    <option value="none" selected disabled hi   dden>Activity Filter</option>
                    <option value="all_tasks">All Tasks</option>
                    <option value="all_posts">All Posts</option>
                    <option value="my_tasks">My Tasks</option>
                    <option value="created_tasks">Tasks Created</option>
                    <option value="created_posts">Posts Created</option>
                </select>
            </form>
        </div>
        <?php echo $html;?>
    </main>
    <script src="../static/main.js"></script>
</body>
</html>
