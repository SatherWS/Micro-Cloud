<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");

    $db = new Database();
    $curs = $db -> getConnection();

    if (isset($_GET["article"]))
    {
        $sql = "select * from file_storage where article_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_GET["article"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swoop | File Storage</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/checkmarks.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg">
    <?php include("./components/header.php");?>
    <main>
        <div class="cat-panel">
            <h3>Files Uploaded</h3>
            <?php
                $files = "";
                $images = "";
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row["file_class"] == "file") {
                        $files .= "<p><a href='".$row["file_path"]."' download>";
                        $files .= $row["file_name"]."</a></p>";
                    }
                    
                    if ($row["file_class"] == "image") {
                        $images .= "<p><a href='".$row["file_path"]."' download>";
                        $images .= $row["file_name"]."</a></p>";
                    }
                }
                echo $html;
            ?>
        </div>
        <div class="cat-panel">
            <h3>Images Uploaded</h3>
            <?php echo $images;?>
        </div>
    </main>
    <script src="../static/main.js"></script>
</body>
</html>