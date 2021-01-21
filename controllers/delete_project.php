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
    
    if (isset($_POST["delete_project"])) {
        $proj = $_POST["project"];
        $sql = "call delete_project(?)";
    }

    else if (isset($_POST["delete_acct"])) {
        $proj = $_POST["account"];
        $sql = "call delete_account(?)";
    }

    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $proj);
    
    if (isset($_POST["delete_project"])) 
    {   
        if ($stmnt -> execute()) {
            $_SESSION["team"] = getNextSesh($curs, $_SESSION["unq_user"]);
            header("Location: ../views/settings.php?msg=$proj has been deleted.");
        }
        else
            header("Location: ../views/settings.php?error=$proj has not been deleted.");
    }
    
    if (isset($_POST["delete_acct"])) 
    {   
        if ($stmnt -> execute()) {
            session_destroy();
            header("Location: ../../index.php");
        }
        else
            header("Location: ../views/settings.php?error=$proj has not been deleted.");
    }
?>