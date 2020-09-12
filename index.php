<?php
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
    if (isset($POST["downvote"])) {
        $vote = "update teams set rating = rating - 1 where team_name = ?";
        $stmnt = mysqli_prepare($curs, $vote);
        $stmnt->bind_param("s", $_POST["downvote"]);
        $stmnt->execute();
        header("Location: ./index.php");
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["team_name"];
        $html .= "<form method='post'>";
        $html .= "<div class='index-spc todo-flex r-cols'>";
        $html .= "<div><h1>".$row["team_name"]."</h1>";
        $html .= "<p>Admin: ".$row["admin"]."</p>";
        $html .= "<p>Date Created: ".$row["date_created"]."</p>";
        $html .= "<br><h4><a href='#' class='add-btn-2'>Join Project</a></h4></div>";
        $html .= "<div class='vote-control'>";
        $html .= "<button type='submit' name='upvote' value='$id'>";
        $html .= "  <span class='vote'> </span>";
        $html .= "</button>";
        $html .= "<p class='text-center'>".$row["rating"]."</p>";
        $html .= "<button type='submit' name='downvote' value='$id'>";
        $html .= "<span class='vote2'> </span>";
        $html .= "</button></div></div>";
        $html .= "<div class='uline'></div>";
        $html .= "</form>";
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
    <nav class="topnav" id="myTopnav">
        <div class="index-nav parent-nav">
            <ul>
                <li>
                    <a href="#" class="active">Swoop.Team</a>
                    <i class="fa fa-wifi"></i>
                </li>
            </ul>
            <ul class="topnav-list">
                <li>
                    <a href="./authentication/login.php">Login</a>
                </li>
                <li>
                    <a href="./authentication/signup.php">Register</a>
                </li>
                <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                    <i class="fa fa-bars"></i>
                </a>
            </ul>
        </div>
    </nav>
    <article class="svg-bg">
        <h2 class="cta-header text-center">A free collaboration platform that values privacy.</h2>
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