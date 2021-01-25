<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }

    include_once "../config/database.php";
    $db = new Database();

    $curs = $db -> getConnection();
    $html = "";

    // article view mode
    $content = "";

    // task view mode
    if (isset($_POST["task-view"]))
    {
        $html .= "<form method='post'>";
        $html .= "<button class='add-btn' type='submit' value='".$_SESSION["team"]."'>";
        $html .= "<h3>View Articles</h3>";
        $html .= "</button></form>";
        $sql = "select * from todo_list where team_name = ? order by date_created desc";

        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();

        while ($row = mysqli_fetch_assoc($results)) {
            $id = $row["id"];
            $content .= "<div onclick='openTask($id)' class='activity'><div class='todo-flex r-cols'>";
            $content .= "<div><h2>Task: ".$row["title"]."</h2>";
            $content .= "<p><b>Deadline:</b> ".$row["time_due"]." ".$row["deadline"]."</p>";
            $content .= "<p><b>Posted:</b> ".$row["date_created"]."</p></div>";
            $content .= "<div><p><b>Assignee:</b> ".$row["assignee"]."</p>";
            $content .= "<p><b>Creator:</b> ".$row["creator"]."</p></div></div>";
            $content .= "<div class='todo-flex r-cols'>";
            $content .= "<p class='activity-item'>".$row["description"]."</p>";
            $content .= "<div><p><b>Status:</b> ".$row["status"]."</p></div></div></div>";
        }
    }
    else {
        $html = "";
        $html .= "<form method='post'>";
        $html .= "<button class='add-btn' type='submit' name='task-view' value='".$_SESSION["team"]."'>";
        $html .= "<h3>View Tasks</h3>";
        $html .= "</button></form>";
        
        $sql = "select * from journal where team_name = ? order by date_created desc";

        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
    
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $content .= "<div onclick='openArticle($id)' class='activity'>";
                $content .= "<h2>".$row["subject"]."</h2>";
                $content .= "<div class='todo-flex r-cols'>";
                $content .= "<div><p><b>Date Created: </b>".$row["date_created"]."</p></div>";
                $content .= "<div><p><b>Creator: </b>".$row["creator"]."</p></div>";
                $content .= "</div></div>";
            }
        }
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
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Swoop | Dashboard</title>
</head>
<body class="todo-bg-test">
    <?php include("./components/header.php");?>
    <?php include("./components/modals/modal.php");?>

    <div class="todo-bg-test">
        <div class="svg-bg">
            <div class="todo-flex">
                <p class="welcome"><?php echo $_SESSION["team"];?></p>
                <p class="welcome"><?php echo $_SESSION["unq_user"];?></p>
            </div>
        </div>
        <div class="dash-grid r-col" id="main">
            <main class="dash-ui">
                <div class="grid-container">
                    <a class="dash-item" href="./create-journal.php">
                        <i class="fa fa-pencil spc-1"></i>
                        <br>
                        <span class="sup-text">New Article</span>
                    </a>
                    <a class="dash-item" href="./create-task.php">
                        <i class="fa fa-list-ol spc-1"></i>
                        <br>
                        <span class="sup-text">Create Task</span> 
                    </a>
                    <a class="dash-item" href="./file-storage.php">
                        <i class="fa fa-database spc-1"></i>
                        <br>
                    <span class="sup-text">Storage</span> 
                    </a>
                    <a class="dash-item" href="./analytics.php">
                        <i class="fa fa-line-chart spc-1"></i>
                        <br>
                    <span class="sup-text">Analytics</span> 
                    </a>
                </div>
                <div class="todo-flex r-cols">
                    <h1 class="intro-header"><?php echo $_SESSION["team"];?> Articles</h1>
                    <?php echo $html;?>
                </div>
                <div>
                    <?php echo $content;?>
                </div>
                <section>
                <!-- extra spacing -->
                <br><br><br><br><br><br>
                </section>
            </main>
            <?php include("./components/sidebar.php");?>
        </div>
    </div>

    <script src="../static/main.js"></script>
    <script src="../static/modal.js"></script>
    <script>
        function myFunction(x) {
            if (x.matches) { // If media query matches
                hideSideBar();
            }
        }   

        var x = window.matchMedia("(max-width: 822px)");
        myFunction(x); // Call listener function at run time
        x.addListener(myFunction); // Attach listener function on state changes

        var x = window.matchMedia("(max-width: 750px)");
        check_mediaq(x);
        x.addListener(check_mediaq);


        function openArticle(id) {
            window.location='./journal-details.php?journal='+id;
        }
        function openTask(id) {
            window.location='./task-details.php?task='+id;
        }
        
        // this needs to be included in every page that has the side bar team modal
        function validateTextarea() {
            var x = document.getElementById("txt-area");
            var y = document.getElementsByName("radio");
            //var z = document.getElementById("pounds");
            if (y[0].checked) 
            {
                x.style.display = "block";
                z.style.display = "block";
            }
            else if (y[1].checked) 
            {
                x.style.display = "None";
                z.style.display = "None";
            }
        }
    </script>
</body>
</html>
