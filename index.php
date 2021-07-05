<?php
session_start();
    include_once("./config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    
    $html = "";
    $project_count = 0;
    $limit = 5;

    $sql = "select count(*) from teams";
    $result = mysqli_query($curs, $sql);
    $data = mysqli_fetch_assoc($result);
    $project_count = $data["count(*)"];

    $sql = "select * from teams order by rating desc limit ?";
    $stmnt = mysqli_prepare($curs, $sql);
    
    if (isset($_GET["more-projects"])) {
        $stmnt -> bind_param("s", $project_count);
    }
    else
        $stmnt -> bind_param("s", $limit);
    
    $stmnt -> execute();
    $result = $stmnt -> get_result();

    if (isset($_POST["upvote"])) 
    {
        $vote = "update teams set rating = rating + 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["upvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }
    
    if (isset($_POST["downvote"])) 
    {
        $vote = "update teams set rating = rating - 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["downvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }

    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) 
    {   
        $count += 1;
        // brief description of project's content
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

        // link to join a project
        $html .= "<div class='settings-flex r-cols align-center'>";
        $html .= "<a href='./controllers/add_entry.php?index-join=$id'>Want to join this project?</a>";

        // links for project tasks and articles
        $html .= "<div class='todo-flex r-cols index-btns'>";
        $html .= "<h4 class='mr-5'><a href='./views/show-journals.php?project=".$row["team_name"]."'class='add-btn-2'>Read Articles</a></h4>";
        $html .= "<h4><a href='./views/show-tasks.php?project=".$row["team_name"]."' class='add-btn-2'>Project Tasks</a></h4>";

        $html .= "</div></div></section>";
        $html .= "<div class='uline'></div>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/style.css">
    <link rel="stylesheet" href="./static/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./favicon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Swoop CTMS</title>
</head>
<body>
    <?php include("./views/components/index_nav.php");?>
    <article class="svg-bg">
	<div class="todo-flex r-cols search-area">
		<form action="./views/results.php" method="post" class="w-90">
	            <div class="srch-section">
                	<input type="text" placeholder="Search" class="search-field" name="query">
        	        <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
	            </div>
        	</form>
		<div class="todo-flex auth-btns">
		    <?php
			if (!isset($_SESSION["unq_user"])) {
		    		echo "<div class='add-btn mr-5'>";
				echo "<a href='authentication/login.php' class='add-btn'>Login</a>";
				echo "</div>";

		    		echo "<div class='add-btn'>";
				echo "<a href='authentication/register.php' class='add-btn'>Register</a>";
				echo "</div>";
			}
			else {
				echo "<div></div>";
				echo "<div class='add-btn'>";
				echo "<a href='controllers/logout.php' class='add-btn'>Logout</a>";
				echo "</div>";
			}
		     ?>
		</div>
	</div>
    </article>
    <main>
        <div class="intro-head">
            <h1 class="main-title">Content & Task Management System</h1>
            <p>Swoop is a open source platform for content and task management. All the code for this website is free to use, modify and distribute.
	    With this website users can write articles using Markdown syntax, create tasks for their teams and store files in a public cloud.
	    <p>Only interested in our Markdown editor? <a href='#'>Check out our desktop app YAM Editor (coming soon)!</a></p>
            </br>
        </div>
        <section class="proj-feed">
            <h2><?php printf($project_count); ?> projects are hosted on this instance</h2>
            <div class="uline"></div>
            <?php echo $html;?>
            <br><br>
            <h3 class='mr-5 text-center'><a href='./index.php?more-projects=5' class='add-btn-2'>Show All Projects</a></h3>
            <br><br>
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
            <p><a class="footer-link git" href='https://github.com/ColinSather/Swoop.Team'> 
            <i class="fa fa-github"></i> View our source code</a></p>
        </div>
    </div>
    <script src="./static/main.js"></script>
    <script>
        for (const btn of document.querySelectorAll('.vote')) 
        {
            btn.addEventListener('click', event => {
                event.target.classList.toggle('on');
            });
        }
        for (const btn of document.querySelectorAll('.vote2')) {
            btn.addEventListener('click', event => {
                event.target.classList.toggle('on');
            });
        }
    </script>
</body>
</html>
