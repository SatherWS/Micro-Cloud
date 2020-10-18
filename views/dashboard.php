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

    if (isset($_POST["edit-wiki"]))
    {
        $html .= "<button class='add-btn' type='submit' name='save-wiki' value='".$_SESSION["team"]."'>";
        $html .= "<h3><i class='fa fa-save'></i>Save Edit</h3>";
        $html .= "</button>";
        //$wiki -> setWiki($_POST["edit-wiki"]);
    }
    else {
        $html = "";
        $html .= "<button class='add-btn' type='submit' name='edit-wiki' value='".$_SESSION["team"]."'>";
        $html .= "<h3><i class='fa fa-edit'></i>Edit Wiki</h3>";
        $html .= "</button>";
        $wiki = $wk -> getWiki($curs, $_SESSION["team"]);
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
            <?php include("./components/sidebar.php");?>
            <main>
                <div class="grid-container">
                    <a class="dash-item" href="./create-journal.php">
                        <i class="fa fa-pencil spc-1"></i>
                        <br>
                        <span class="sup-text">Write Post</span>
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
                    <form method="post">
                        <?php echo $html;?>
                    </form>
                </div>
                <?php echo $wiki ?>
                <section>
                <!-- extra spacing -->
                <br><br><br><br><br><br>
                </section>
            </main>
        </div>
    </div>
    <script>
        function validateTextarea() {
            var x = document.getElementById("txt-area");
            var y = document.getElementsByName("radio");
            var z = document.getElementById("pounds");
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
