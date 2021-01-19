<?php
    include_once("../config/database.php");

    $db = new Database();
    $curs = $db -> getConnection();

    function cleanArticle($curs, $id, $md) {
        $sql = "update journal set message = replace(message, ?, '') where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $md, $id);
        $stmnt -> execute();
    }

    if (isset($_POST["img-id"])) {
        
        // sudo rm ../uploads/images/$id/$filename
        $sql = "select file_path, article_id from file_storage where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST["img-id"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $data = mysqli_fetch_assoc($results);

        if (unlink($data["file_path"])) {
            $sql = "delete from file_storage where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_POST["img-id"]);
            $stmnt -> execute();
            $md = "![uploaded image](".$data["file_path"].")";
            
            cleanArticle($curs, $data["article_id"], $md);
        }
        header("Location: ../views/file-storage.php");
    }
?>