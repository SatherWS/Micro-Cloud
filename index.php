<?php
    session_start();
    include_once("./config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select * from teams";
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
        $html .= "<form action='./controllers/join_team.php' method='post'>";
        $html .= "<div class='todo-flex r-cols'>";
        $html .= "<div><h1>".$row["team_name"]."</h1>";
        $html .= "<input type='hidden' value='".$row["team_name"]."' name='teamname'>";
        $html .= "<p>Admin: ".$row["admin"]."</p>";
        $html .= "<p>Date Created: ".$row["date_created"]."</p><br>";
        $html .= "<h4><button type='submit' class='add-btn-2'>Join Project</button></h4></div></form>";
        
        // vote control
        $html .= "<form method='post'>";
        $html .= "<div class='vote-control'>";
        $html .= "<button type='submit' name='upvote' value='$id'>";
        $html .= "  <span class='vote'> </span>";
        $html .= "</button>";
        $html .= "<p class='text-center'>".$row["rating"]."</p>";
        $html .= "<button type='submit' name='downvote' value='$id'>";
        $html .= "  <span class='vote2'> </span>";
        $html .= "</button></div></div>";
        $html .= "</form>";

        $html .= "<div class='settings-flex r-cols'>";
        $html .= "<p><b>Project Tags</b></p>";
        $html .= "<div class='img-type'>";
        $html .= "<img src='https://38.media.tumblr.com/587f48c6548e640f943b7c8c6e3f40de/tumblr_mz8yzmi1XJ1ru39xmo1_500.gif'>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "<div class='uline'></div>";
    }
?>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./favicon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Swoop.Team</title>
</head>
<body>
    <?php 
        if (isset($_SESSION["unq_user"]))
            include("./views/components/index-headers/user_nav.php");
        else
            include("./views/components/index-headers/nonuser_nav.php");
    ?>
    <article class="svg-bg">
        <h2 class="cta-header ml2rem">A free project collaboration platform</h2>
    </article>
    <div class="dash-grid">
        <?php include("./views/components/sidebar.php");?>
        <section class="proj-feed">
            <?php echo $html;?>
        </section>
    </div>

    <script src="./static/main.js"></script>
    <script>
        for (const btn of document.querySelectorAll('.vote')) {
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
