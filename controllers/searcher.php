<?php
    session_start();
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db->getConnection();

    $sql = "select * from teams where team_name like '%".$_POST["query"]."%' order by date_created desc";
    $result = mysqli_query($curs, $sql);
    $html = "";

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
        $html .= "<form class='blockzero' action='./controllers/add_entry.php' method='post'>";
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