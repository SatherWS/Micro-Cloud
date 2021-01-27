<?php
    session_start();
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $user = "";
    
    if (!isset($_SESSION["unq_user"])) {
        $user = "guest";
    }
    else {
        $user = $_SESSION["unq_user"];
    }
    
    if (isset($_POST["comment"])) {
        $id = $_POST["art_id"];
        $sql = "insert into comments(comment, user_email, article_id) values (?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_POST["comment"], $user, $id);
        $stmnt -> execute();
        header("Location: ../views/journal-details.php?journal=$id");
    }

    class Comments {
        public function showComments($curs, $art_id) {
            $sql = "select * from comments where article_id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $art_id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            return $results;
        }
    }
?>