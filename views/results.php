<?php
    session_start();
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    if ($_GET["filter"] == "articles")
        $sql = "select * from journal where subject like '%".$_POST["query"]."%' order by date_created desc";
    
    else if ($_GET["filter"] == "users")
        $sql = "select * from users where username like '%".$_POST["query"]."%' order by date_created desc";
    
    else
        $sql = "select * from teams where team_name like '%".$_POST["query"]."%' order by date_created desc";
    $result = mysqli_query($curs, $sql);
    $html = "";

    if (isset($_POST["upvote"])) 
    {
        $vote = "update teams set rating = rating + 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["upvote"]);
        $stmnt->execute();
        header("Location: ./results.php");
    }
    
    if (isset($_POST["downvote"])) 
    {
        $vote = "update teams set rating = rating - 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["downvote"]);
        $stmnt->execute();
        header("Location: ./results.php");
    }

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $id = $row["team_name"];
        $html .= "<section class='project-entry'><div class='todo-flex'>";
        $html .= "<div id='proj-container'><h1>".$row["team_name"]."</h1>";
        $html .= "<p>".$row["description"]."</p>";
        $html .= "<input type='hidden' value='".$row["team_name"]."' name='teamname'>";
        $html .= "<p>Admin: ".$row["admin"]."</p>";
        $html .= "<p>Date Created: ".$row["date_created"]."</p></div>";
        
        // vote control buttons
        $html .= "<form method='post'>";
        $html .= "<div class='vote-control'>";
        $html .= "<button type='submit' name='upvote' value='$id'>";
        $html .= "<span class='vote'> </span>";
        $html .= "</button>";
        $html .= "<p class='text-center'>".$row["rating"]."</p>";
        $html .= "<button type='submit' name='downvote' value='$id'>";
        $html .= "<span class='vote2'> </span>";
        $html .= "</button></div></div>";
        $html .= "</form>";

        $html .= "<div class='settings-flex r-cols align-center'>";
        $html .= "<form class='blockzero' action='../controllers/add_entry.php' method='post'>";
        $html .= "<input class='send-req' type='hidden' name='teamname' value='".$row["team_name"]."'>";
        $html .= "<button type='submit' name='index-join'>Want to join this project?</button>";
        $html .= "</form>";

        // project links
        $html .= "<div class='todo-flex r-cols index-btns'>";
        $html .= "<h4><button><a href='./logs.php?project=".$row["team_name"]."'class='add-btn-2'>Read Articles</a></button></h4>";
        $html .= "<h4><button><a href='./show-tasks.php?project=".$row["team_name"]."' class='add-btn-2'>Project Tasks</a></button></h4>";

        $html .= "</div></div></section>";
        $html .= "<div class='uline'></div>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./favicon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Swoop.Team</title>
</head>
<body>
    <?php include("./components/header.php");?>
    <article class="svg-bg">
	<div class="todo-flex r-cols search-area">
	<form method="post" class="w-90">
            <div class="srch-section">
                <input type="text" placeholder="Search" class="search-field" name="query">
                <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </form>
	<div class="todo-flex r-cols">
        <?php
			if (!isset($_SESSION["unq_user"])) {
                echo "<div class='add-btn mr-5'>";
				echo "<a href='../authentication/login.php' class='add-btn'>Login</a>";
				echo "</div>";

                echo "<div class='add-btn'>";
				echo "<a href='../authentication/register.php' class='add-btn'>Register</a>";
				echo "</div>";
			}
			else {
				echo "<div></div>";
				echo "<div class='add-btn'>";
				echo "<a href='../controllers/logout.php' class='add-btn'>Logout</a>";
				echo "</div>";
			}
        ?>
	</div>

	</div>
    </article>
    <main>
        <section class="proj-feed">
            <div class="todo-flex r-cols">
                <div class="dropdown">
                    <p><a href="../authentication/register.php" class="dropbtn">REGISTER</a></p>
                </div>
                <p><a href="../index.php">HOME</a></p>
            </div>
            
            <div class="uline"></div>
            <?php
                echo $html;
            ?>
        </section>
    </main>
    <div class="col-container">
        <div class="col">
            <h2>KNOWLEDGE BASE</h2>
            <p><a class="footer-link" href="#">About this project</a></p>
            <p><a class="footer-link" href="#">How to articles</a></p>
            <p><a class="footer-link" href="https://colinsather.github.io">&copy;2021 Colin Sather</a></p>
        </div>
        <div class="col text-right">
            <h2>LINKS</h2>
            <p><a class="footer-link git" href='#'> 
            <i class="fa fa-github"></i> View our source code</a></p>
        </div>
    </div>
    <script src="../static/main.js"></script>
</body>
</html>
