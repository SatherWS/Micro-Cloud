<?php
    include("../config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select * from todo_list order by deadline desc";
    $result = mysqli_query($curs, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $html = "<div class='scroll-item' onclick='getTask($id)'>";
        $html .= "<h3>".$row["title"]."</h3>";
        $html .= "<h4>".$row["deadline"]."</h4>";
        $html .= "<p>".$row["description"]."</p></div>";
        echo $html;
    }
?>

<div class='scroll-item'>
    <h3></h3>
    <h4></h4>
    <p></p>
</div>