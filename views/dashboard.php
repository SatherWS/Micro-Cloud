<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $html = "";

    // TODO: MOVE THIS TO MODELS SINCE ITS DATA RELATED
    // select all tasks by team
    if ($_POST["options-a"] == "all_tasks" || $_SERVER["REQUEST_METHOD"] != "POST") {
        $sql = "select * from todo_list where team_name = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        while ($row = mysqli_fetch_assoc($results)) {
            $id = $row["id"];
            $html .= "<div onclick='panelLinkTD($id)' class='activity'><div class='todo-flex r-cols'>";
            $html .= "<div><h2>Task: ".$row["title"]."</h2>";
            $html .= "<p><b>Deadline:</b> ".$row["time_due"]." ".$row["deadline"]."</p>";
            $html .= "<p><b>Posted:</b> ".$row["date_created"]."</p></div>";
            $html .= "<div><p><b>Assignee:</b> ".$row["assignee"]."</p>";
            $html .= "<p><b>Creator:</b> ".$row["creator"]."</p></div></div>";
            $html .= "<div class='todo-flex r-cols'>";
            $html .= "<p class='activity-item'>".$row["description"]."</p>";
            $html .= "<div><p><b>Status:</b> ".$row["status"]."</p></div></div></div>";
        }
    }

    // select all posts by team
    if ($_POST["options-a"] == "all_posts") {
        $sql = "select * from journal where team_name = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $html .= "<div onclick='panelLinkP($id)' class='activity'><div class='todo-flex r-cols'>";
                $html .= "<div><h2>Post: ".$row["subject"]."</h2>";
                $html .= "<p><b>Category: </b>".$row["category"]."</p>";
                $html .= "<p><b>Category: </b>".$row["date_created"]."</p></div>";
                $html .= "<div><p><b>Creator: </b>".$row["creator"]."</p>";
                $html .= "<p><b>Status: </b>".$row["is_private"]."</p></div></div>";
                $html .= "<p class='activity-item'>".substr($row["message"], 0, 75)."</p></div>";
            }
        }
    }

    // notes posted by current user
    if ($_POST["options-a"] == "created_posts") {
        $sql = "select * from journal where creator = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["unq_user"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $html .= "<div onclick='panelLinkP($id)' class='activity'><div class='todo-flex r-cols'>";
                $html .= "<div><h2>Post: ".$row["subject"]."</h2>";
                $html .= "<p><b>Category: </b>".$row["category"]."</p>";
                $html .= "<p><b>Category: </b>".$row["date_created"]."</p></div>";
                $html .= "<div><p><b>Creator: </b>".$row["creator"]."</p>";
                $html .= "<p><b>Status: </b>".$row["is_private"]."</p></div></div>";
                $html .= "<p class='activity-item'>".substr($row["message"], 0, 75)."</p></div>";
            }
        }
    }

    // tasks assigned to current user
    if ($_POST["options-a"] == "my_tasks") {
        $sql = "select * from todo_list where assignee = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["unq_user"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $html .= "<div onclick='panelLinkTD($id)' class='activity'><div class='todo-flex r-cols'>";
                $html .= "<div><h2>Task: ".$row["title"]."</h2>";
                $html .= "<p><b>Deadline:</b> ".$row["time_due"]." ".$row["deadline"]."</p>";
                $html .= "<p><b>Posted:</b> ".$row["date_created"]."</p></div>";
                $html .= "<div><p><b>Assignee:</b> ".$row["assignee"]."</p>";
                $html .= "<p><b>Creator:</b> ".$row["creator"]."</p></div></div>";
                $html .= "<div class='todo-flex r-cols'>";
                $html .= "<p class='activity-item'>".$row["description"]."</p>";
                $html .= "<div><p><b>Status:</b> ".$row["status"]."</p></div></div></div>";
            }
        }
    }

    // tasks created by current user
    if ($_POST["options-a"] == "created_tasks") {
        $sql = "select * from todo_list where creator = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["unq_user"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $html .= "<div onclick='panelLinkTD($id)' class='activity'><div class='todo-flex r-cols'>";
                $html .= "<div><h2>Task: ".$row["title"]."</h2>";
                $html .= "<p><b>Deadline:</b> ".$row["time_due"]." ".$row["deadline"]."</p>";
                $html .= "<p><b>Posted:</b> ".$row["date_created"]."</p></div>";
                $html .= "<div><p><b>Assignee:</b> ".$row["assignee"]."</p>";
                $html .= "<p><b>Creator:</b> ".$row["creator"]."</p></div></div>";
                $html .= "<div class='todo-flex r-cols'>";
                $html .= "<p class='activity-item'>".$row["description"]."</p>";
                $html .= "<div><p><b>Status:</b> ".$row["status"]."</p></div></div></div>";
            }
        }
    }
    // TODO: MOVE ABOVE TO MODELS SINCE ITS DATA RELATED
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamswoop | Dashboard</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <div class="todo-bg">
    <?php include("./components/header.php");?>
    <main>
        <div class="home-intro">
            <h1 class="intro-header">Welcome <?php echo $_SESSION["user"];?></h1>
            <h2>Team: <?php echo $_SESSION["team"];?></h2>
        </div>
        <div class="grid-container">
            <div>
                <a class="dash-item" href="./create-task.php">
                    <i class="fa fa-list-ol spc-1"></i>
                    <br>
                   <span class="sup-text">Create Task</span> 
                </a>
            </div>
            <div>
                <a class="dash-item" href="./create-journal.php">
                    <i class="fa  fa-pencil spc-1"></i>
                    <br>
                    <span class="sup-text">Create Post</span>
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
                <a class="dash-item" href="./settings.php">
                    <i class="fa fa-gear spc-1"></i>
                    <br>
                   <span class="sup-text">Settings</span> 
                </a>
            </div>   
        </div>
        <div class="todo-flex r-cols">
            <h1 class="intro-header">My Team's Activity</h1>
            <form method="POST">
                <select class="main-selector" name="options-a" id="myselect" onchange="this.form.submit()">
                    <option value="none" selected disabled hi   dden>Activity Filter</option>
                    <option value="all_tasks">All Tasks</option>
                    <option value="all_posts">All Posts</option>
                    <option value="created_posts">Posts Created</option>
                    <option value="my_tasks">Assigned Tasks</option>
                    <option value="created_tasks">Tasks Created</option>
                </select>
            </form>
        </div>
        <?php echo $html;?>
    </main>
    </div>
    <script>
    function panelLinkP(id) {
        window.location='./journal-details.php?journal='+id;
    }
    function panelLinkTD(id) {
        window.location='./task-details.php?task='+id;
    }
    // event listener for preventing x-axis scrolling
    /*
    var scrollEventHandler = function() {
        window.scroll(0, window.pageYOffset)
    }

    window.addEventListener("scroll", scrollEventHandler, false);
    */  
    </script>
    <script src="../static/main.js"></script>
</body>
</html>
