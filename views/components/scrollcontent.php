<?php
    include("../config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select *, date_format(deadline, '%M %D %Y') as d from todo_list order by deadline desc";
    $result = mysqli_query($curs, $sql);
    $html = "";

    while($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $html .= "<div class='scroll-item' onclick='getTask($id)'>";
        $html .= "<div class='row-c2'><h3>".$row["title"]."</h3>";
        $html .= "<h3>".$row["importance"]."</h3></div>";
        $html .= "<p>".$row["description"]."</p>";
        $html .= "<h4>Deadline is ".$row["d"].", ".$row["time_due"]."</h4>";
        $html .= "<h4>Created on ".$row["date_created"]."</h4></div>";
    }
    echo $html;
?>

<div class='scroll-item'>
    <h3></h3>
    <h4></h4>
    <p></p>
</div>