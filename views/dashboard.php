<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    require "../controllers/parse_interface.php";
    include_once "../config/database.php";
    $db = new Database();
    $wk = new Wiki();

    $curs = $db -> getConnection();
    $html = "";
    $articles = "";

    $sql = "select * from journal where team_name = ? order by date_created desc";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {
            $id = $row["id"];
            $articles .= "<div onclick='panelLinkP($id)' class='activity'><div class='todo-flex r-cols'>";
            $articles .= "<div><h2>Post: ".$row["subject"]."</h2>";
            $articles .= "<p><b>Category: </b>".$row["category"]."</p>";
            $articles .= "<p><b>Category: </b>".$row["date_created"]."</p></div>";
            $articles .= "<div><p><b>Creator: </b>".$row["creator"]."</p>";
            $articles .= "<p><b>Status: </b>".$row["is_private"]."</p></div></div>";
            // TODO: close p tag if substring contains an iframe tag (video, img etc)
            //$html .= "<p class='activity-item'>".substr($row["message"], 0, 175)."</p></div>";
            $articles .= "<a href='./journal-details.php?journal=$id'>Read Post</a></div>";
            
        }
    }

    // old code, currently scraping wiki page 12/26/20
    function updateWiki($curs, $team, $content)
    {
        $sql = "update wikis set content = ? where team_name = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $content, $team);
        $stmnt -> execute();
    }
    if (isset($_POST["edit-wiki"]))
    {
        $html .= "<button onclick='triggerForm()' class='add-btn' type='submit' name='save-wiki' value='".$_SESSION["team"]."'>";
        $html .= "<h3><i class='fa fa-save'></i>Save Edit</h3>";
        $html .= "</button>";
        //$articles .= "<br><textarea name='content' id='wiki-txt-area'></textarea>";
    }
    else {
        $html = "";
        $html .= "<button onclick='triggerForm()' class='add-btn' type='submit' name='edit-wiki' value='".$_SESSION["team"]."'>";
        $html .= "<h3><i class='fa fa-edit'></i>Edit Wiki</h3>";
        $html .= "</button>";
        $html .= "<input type='hidden' name='edit-wiki' value='".$row['id']."'>";
        //$articles = $wk -> getWiki($curs, $_SESSION["team"]);
    }
    if (isset($_POST["save-wiki"]))
        updateWiki($curs, $_SESSION["team"], $_POST["content"]);
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
            <main>
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
                    <a class="dash-item" href="./analytics.php">
                        <i class="fa fa-line-chart spc-1"></i>
                        <br>
                    <span class="sup-text">Analytics</span> 
                    </a>
                    <a class="dash-item" href="./settings.php">
                        <i class="fa fa-gear spc-1"></i>
                        <br>
                    <span class="sup-text">Settings</span> 
                    </a>
                </div>
                <div class="todo-flex r-cols">
                    <h1 class="intro-header"><?php echo $_SESSION["team"];?> Wiki Page</h1>
                    <?php echo $html;?>
                </div>
                <div>
                    <?php echo $articles;?>
                </div>
                <section>
                <!-- extra spacing -->
                <br><br><br><br><br><br>
                </section>
            </main>
            <?php include("./components/sidebar.php");?>
        </div>
    </div>
    <script>
        function triggerForm() {
            document.getElementById("wiki-editor").submit();
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
    <script src="../static/main.js"></script>
    <script src="../static/modal.js"></script>
</body>
</html>
