<?php
    include("../config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select * from todo_list";
    $result = mysqli_query($curs, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        $html = "<div class='scroll-item'>";
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