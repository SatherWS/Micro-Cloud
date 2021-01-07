<?php
    /*
    *   TODO: move php scripts at the top of views/dashboard.php to
    *   this file. It may look nicer.
    *   
    *   This is a work in progress
    */
    

/*  
        $html = "";

        // TODO: MOVE THIS TO MODELS SINCE ITS DATA RELATED

        // select all posts by team
        if ($_POST["options-a"] == "all_posts") {
            $sql = "select * from journal where team_name = ? order by date_created desc";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_SESSION["team"]);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            if (mysqli_num_rows($results) > 0) {
                while ($row = mysqli_fetch_assoc($results)) {
                    $id = $row["id"];
                    $html .= "<div onclick='panelLinkP($id)' class='activity'><div class='todo-flex r-cols'>";
                    $html .= "<div><h2>Post: ".$row["subject"]."</h2>";
                    $html .= "<p><b>Category: </b>".$row["category"]."</p>";
                    $html .= "<p><b>Category: </b>".$row["date_created"]."</p></div>";
                    $html .= "<div><p><b>Creator: </b>".$row["creator"]."</p>";
                    $html .= "<p><b>Status: </b>".$row["is_private"]."</p></div></div>";
                    $html .= "<a href='./journal-details.php?journal=$id'>Read Post</a></div>";
                    
                }
            }
        }

        // notes posted by current user
        if ($_POST["options-a"] == "created_posts") {
            $sql = "select * from journal where creator = ? order by date_created desc";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_SESSION["unq_user"]);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            if (mysqli_num_rows($results) > 0) {
                while ($row = mysqli_fetch_assoc($results)) {
                    $id = $row["id"];
                    $html .= "<div onclick='panelLinkP($id)' class='activity'><div class='todo-flex r-cols'>";
                    $html .= "<div><h2>Post: ".$row["subject"]."</h2>";
                    $html .= "<p><b>Category: </b>".$row["category"]."</p>";
                    $html .= "<p><b>Category: </b>".$row["date_created"]."</p></div>";
                    $html .= "<div><p><b>Creator: </b>".$row["creator"]."</p>";
                    $html .= "<p><b>Status: </b>".$row["is_private"]."</p></div></div>";
                    $html .= "<a href='./journal-details.php?journal=$id'>Read Post</a></div>";
                }
            }
        }
*/
class DashTasks {
    function getTasks($curs) {
        $html = "";
        // get tasks assigned to current user
        if ($_POST["options-a"] == "my_tasks") {
            $sql = "select * from todo_list where assignee = ? order by date_created desc";
        }
        // get tasks created by current user
        else if ($_POST["options-a"] == "created_tasks") {
            $sql = "select * from todo_list where creator = ? order by date_created desc";
        }
        else if ($_POST["options-a"] == "all_tasks" || $_SERVER["REQUEST_METHOD"] != "POST") {
            $sql = "select * from todo_list where team_name = ? order by date_created desc";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_SESSION["team"]);
        }
        else {
            $sql = "select * from todo_list where team_name = ? order by date_created desc";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_SESSION["unq_user"]);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
        }
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $html .= "<div onclick='panelLinkTD($id)' class='activity'><div class='todo-flex r-cols'>";
                $html .= "<div><h2>Task: ".$row["title"]."</h2>";
                $html .= "<p><b>Deadline:</b> ".$row["time_due"]." ".$row["deadline"]."</p>";
                $html .= "<p><b>Posted:</b> ".$row["date_created"]."</p></div>";
                $html .= "<div><p><b>Assignee:</b> ".$row["assignee"]."</p>";
                $html .= "<p><b>Creator:</b> ".$row["creator"]."</p></div></div>";
                $html .= "<div class='todo-flex r-cols'>";
                $html .= "<p class='activity-item'>".$row["description"]."</p>";
                $html .= "<div><p><b>Status:</b> ".$row["status"]."</p></div></div></div>";
            }
        }
        return $html;
    }
}
        

       /*
        // get all tasks by team, this is the default dashboard data
        if ($_POST["options-a"] == "all_tasks" || $_SERVER["REQUEST_METHOD"] != "POST") {
            $sql = "select * from todo_list where team_name = ? order by date_created desc";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_SESSION["team"]);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            while ($row = mysqli_fetch_assoc($results)) {
                $id = $row["id"];
                $html .= "<div onclick='panelLinkTD($id)' class='activity'><div class='todo-flex r-cols'>";
                $html .= "<div><h2>Task: ".$row["title"]."</h2>";
                $html .= "<p><b>Deadline:</b> ".$row["time_due"]." ".$row["deadline"]."</p>";
                $html .= "<p><b>Posted:</b> ".$row["date_created"]."</p></div>";
                $html .= "<div><p><b>Assignee:</b> ".$row["assignee"]."</p>";
                $html .= "<p><b>Creator:</b> ".$row["creator"]."</p></div></div>";
                $html .= "<div class='todo-flex r-cols'>";
                $html .= "<p class='activity-item'>".$row["description"]."</p>";
                $html .= "<div><p><b>Status:</b> ".$row["status"]."</p></div></div></div>";
            }
        }
        */
?>