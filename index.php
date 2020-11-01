<?php
    session_start();
    include_once("./config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select * from teams order by date_created desc";
    $result = mysqli_query($curs, $sql);
    $html = "";

    if (isset($_POST["upvote"])) {
        $vote = "update teams set rating = rating + 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["upvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }
    // TODO: Fix downvote issue and remove ratings table
    if (isset($_POST["downvote"])) {
        $vote = "update teams set rating = rating - 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["downvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["team_name"];
        $html .= "<div class='todo-flex'>";
        $html .= "<div id='proj-container'><h1>".$row["team_name"]."</h1>";
        $html .= "<p>".$row["description"]."</p>";
        $html .= "<input type='hidden' value='".$row["team_name"]."' name='teamname'>";
        $html .= "<p>Admin: ".$row["admin"]."</p>";
        $html .= "<p>Date Created: ".$row["date_created"]."</p><br></div>";
        
        // vote control
        $html .= "<form method='post'>";
        $html .= "<div class='vote-control'>";
        $html .= "<button type='submit' name='upvote' value='$id'>";
        $html .= "<span class='vote'> </span>";
        $html .= "</button>";
        $html .= "<p class='text-center'>".$row["rating"]."</p>";
        $html .= "<button type='submit' name='downvote' value='$id'>";
        $html .= "  <span class='vote2'> </span>";
        $html .= "</button></div></div>";
        $html .= "</form>";

        $html .= "<div class='settings-flex r-cols'>";
        $html .= "<div></div>";
        #$html .= "<p><b>Project Tags</b></p>";
        $html .= "<div class='todo-flex'>";
        $html .= "<h4><button><a href='#' class='add-btn-2'>Read Wiki Page</a></button></h4>";
        $html .= "<form class='blockzero' action='./controllers/join_team.php' method='post'>";
        $html .= "<h4><button type='submit' class='add-btn-2'>Join Project</button></h4></form></div>";
        //$html .= "<div class='img-type'>";
        //$html .= "<img src='https://38.media.tumblr.com/587f48c6548e640f943b7c8c6e3f40de/tumblr_mz8yzmi1XJ1ru39xmo1_500.gif'>";
        //$html .= "</div>";
        $html .= "</div>";
        $html .= "<div class='uline'></div>";
    }
?>
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
    <article class="svg-bg todo-flex r-cols">
	<h2 class="ml2rem">A free project collaboration platform.</h2>
        <div class="srch-section">
            <input type="text" placeholder="Search all projects" class="search-field">
            <input type="submit" value="Search" class="add-btn">
        </div>
    </article>
    <div class="dash-grid r-col" id="main">
        <section class="proj-feed">
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
