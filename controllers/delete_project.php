<?php
    session_start();
    include_once ("../config/database.php");

    function getNextSesh($curs, $email)
    {
        $sql = "select team_name from members where email = ? limit 1";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $email);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $data = mysqli_fetch_assoc($results);
        if (mysqli_num_rows($results) > 0) 
            return $data["team_name"];
    }

    $db = new Database();
    $curs = $db -> getConnection();
    $proj = $_POST["project"];

    $sql = "call delete_project(?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $proj);
    if ($stmnt -> execute()) 
    {   
        $_SESSION["team"] = getNextSesh($curs, $_SESSION["unq_user"]);
        header("Location: ../views/settings.php?msg=$proj has been deleted.");
    }
    else
        header("Location: ../views/settings.php?error=$proj has not been deleted.");
?>