<?php
    session_start();
    include_once("./config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select * from teams order by date_created desc";
    $result = mysqli_query($curs, $sql);

    $html = "";
    $project_count = 0;

    if (isset($_POST["upvote"])) {
        $vote = "update teams set rating = rating + 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["upvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }
    
    if (isset($_POST["downvote"])) {
        $vote = "update teams set rating = rating - 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["downvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $project_count = $row["count(*)"];
        $id = $row["team_name"];
        $html .= "<section class='project-entry'><div class='todo-flex'>";
        $html .= "<div id='proj-container'><h1>".$row["team_name"]."</h1>";
        $html .= "<p>".$row["description"]."</p>";
        $html .= "<input type='hidden' value='".$row["team_name"]."' name='teamname'>";
        $html .= "<p>Admin: ".$row["admin"]."</p></div>";
        
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

        $html .= "<div class='settings-flex r-cols'>";
        $html .= "<p>Date Created: ".$row["date_created"]."</p>";

        // project links
        $html .= "<div class='todo-flex r-cols index-btns'>";
        $html .= "<h4><button><a href='./views/logs.php?project=".$row["team_name"]."'class='add-btn-2'>Read Articles</a></button></h4>";
        $html .= "<h4><button><a href='./views/show-tasks.php?project=".$row["team_name"]."' class='add-btn-2'>Project Tasks</a></button></h4>";
        //$html .= "<form class='blockzero' action='./controllers/join_team.php' method='post'>";
        $html .= "<h4><button><a href='#' class='add-btn-2'>Join Project</a></button></h4>";
        $html .= "</div></div></section>";
        $html .= "<div class='uline'></div>";
    }

    $project_count = mysqli_num_rows($result);
    mysqli_free_result($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/style.css">
    <link rel="stylesheet" href="./static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./favicon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Swoop.Team</title>
</head>
<body>
    <?php 
        include("./views/components/modals/modal.php");
        if (isset($_SESSION["unq_user"]))
            include("./views/components/index-headers/user_nav.php");
        else
            include("./views/components/index-headers/nonuser_nav.php");
    ?>
    <article class="svg-bg dash-grid r-cols">
        <form action="" method="post">
            <div class="srch-section">
                <input type="text" placeholder="Search" class="search-field">
                <input type="submit" value="Search" class="add-btn">
            </div>
        </form>
        <div></div>
    </article>
    <div class="dash-grid r-col" id="main">
        <section class="proj-feed">
            <h1 class="main-title">Swoop Project Management</h1>
            <p>Most of the projects posted on this platform are either hardware or software related but, projects of any kind are highly encouraged. If you are interested in the source code of this website, <a href='#'>click here.</a></p>
            <br></br>
            <h2><?php printf($project_count); ?> projects hosted on this instance</h2>
            <div class="uline"></div>
                <?php echo $html;?>
        </section>
        <?php include("./views/components/sidebar.php");?>
    </div>

    <script src="./static/main.js"></script>
    <script src="./static/modal.js"></script>
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
    <script>
    // copy pasta from w3schools customize for h1 tags inside div#proj-container
    function myFunction() 
    {
        var input, filter, ul, li, a, i;
        input = document.getElementById("mySearch");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myMenu");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) 
        {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) 
            {
                li[i].style.display = "";
            } 
            else 
            {
                li[i].style.display = "none";
            }
        }
    }
    </script>
</body>
</html>
