<?php
require_once "../libs/Parsedown.php";
include_once "../config/database.php";

class Wiki 
{
    function getWiki($curs, $project)
    {
        $Parsedown = new Parsedown();
        $sql = "select content, last_edited from wikis where team_name = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $project);
        $stmnt -> execute();
        $result = $stmnt->get_result();
        $data = mysqli_fetch_assoc($result);
        return $Parsedown->text($data["content"]);
    }
}
?>