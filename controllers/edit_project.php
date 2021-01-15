<?php
    include ("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();

    if (isset($_POST["edit_project"]))
    {
        echo "updating project";
    }
?>