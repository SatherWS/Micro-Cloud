<?php
    include_once("./config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    $sql = "select * from teams";
    $result = mysqli_query($curs, $sql);

    function show_projects($r) {
        $html = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= $row["team_name"]."<br>";
        }
        return $html;
    }

    echo show_projects($result);
?>