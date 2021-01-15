<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");

    $db = new Database();
    $curs = $db -> getConnection();

    $sql = "select journal.id, file_storage.article_id, journal.team_name, journal.subject, journal.creator, file_storage.file_path, file_storage.file_name, file_storage.file_class, file_storage.file_type, file_storage.date_created from journal inner join file_storage on journal.id = file_storage.article_id where journal.team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $result = $stmnt -> get_result();

    $project_imgs = "";
    $project_files = "";

    while ($row = mysqli_fetch_assoc($result))
    {
        if ($row["file_class"] == "file") 
        {
            $project_files .= "<tr>";
            $project_files .= "<td><p><a href='".$row["file_path"]."' download>";
            $project_files .= $row["file_name"].".".$row["file_type"]."</a></p></td>";
            $project_files .= "<td>".$row["subject"]."</td>";
            $project_files .= "<td>".$row["creator"]."</td>";
            $project_files .= "<td>".$row["date_created"]."</td>";
            $project_files .= "</tr>";
        }

        if ($row["file_class"] == "image") 
        {
            $project_imgs .= "<br><div class='uline'></div><br>";
            $project_imgs .= "<div class='todo-flex r-cols'>";
            $project_imgs .= "<div>";
            $project_imgs .= "<p><a href='".$row["file_path"]."' download>Download: ";
            $project_imgs .= $row["file_name"].".".$row["file_type"]."</a></p>";
            $project_imgs .= "<p>Related Article: ".$row["subject"]."</p>";
            $project_imgs .= "<p>Creator: ".$row["creator"]."</p>";
            $project_imgs .= "</div>";
            $project_imgs .= "<div>";
            $project_imgs .= "<img src='".$row["file_path"]."'>";
            $project_imgs .= "</div>";
            $project_imgs .= "</div>";
        }   

    }

    if (isset($_GET["article"]) && isset($_GET["title"]))
    {
        $sql = "select * from file_storage where article_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_GET["article"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();

        $images = "";
        $files = "";
    
        while ($row = mysqli_fetch_assoc($result)) 
        {
            if ($row["file_class"] == "file") 
            {
                $files .= "<tr>";
                $files .= "<td><p><a href='".$row["file_path"]."' download>";
                $files .= $row["file_name"].".".$row["file_type"]."</a></p></td>";
                $files .= "<td>".$_GET["title"]."</td>";
                $files .= "<td>".$row["date_created"]."</td>";
                $files .= "</tr>";
            }
            
            if ($row["file_class"] == "image") 
            {
                $images .= "<br><div class='uline'></div><br>";
                $images .= "<div class='todo-flex r-cols'>";
                $images .= "<div>";
                $images .= "<p><a href='".$row["file_path"]."' download>Download: ";
                $images .= $row["file_name"].".".$row["file_type"]."</a></p>";
                $images .= "<p><a href='./journal-details.php?journal=".$_GET["article"]."'>Article Link: ".$_GET["title"]."</a></p>";
                $images .= "</div>";
                $images .= "<div>";
                $images .= "<img src='".$row["file_path"]."'>";
                $images .= "</div>";
                $images .= "</div>";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swoop | File Storage</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="../static/checkmarks.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg-test">
    <?php include("./components/header.php");?>
    <?php include("./components/modals/modal.php");?>
    <div class="todo-bg-test">
        <div class="svg-bg">
            <div class="todo-flex">
                <p class="welcome"><?php echo $_SESSION["team"];?></p>
                <p class="welcome"><?php echo $_SESSION["unq_user"];?></p>
            </div>
        </div>
        <div class="dash-grid r-cols" id="main">
            <div>
                <?php 
                    if (isset($_GET["title"]) && isset($_GET["article"]))
                        include("./components/article-files.php");
                ?>
                <h2 class="ml2rem">Project files: <?php echo $_SESSION["team"];?></h2>
                <div class="settings-space">
                    <div class="settings-panel">
                        <h3>All Files uploaded</h3>
                        <table class="data journal-tab">
                            <tr class="tbl-head">
                                <th>FILENAME</th>
                                <th>ARTICLE</th>
                                <th>AUTHOR</th>
                                <th>DATE SUBMITTED</th>
                            </tr>
                            <?php echo $project_files;?>
                        </table>
                    </div>
                </div>
                <div class="settings-space">
                    <div class="settings-panel">
                        <h3>All Images uploaded</h3>
                        <?php echo $project_imgs;?>
                    </div>
                </div>
            </div>

            <?php include("./components/sidebar.php");?>
        </div>
    </div>
    <script src="../static/main.js"></script>
    <script src="../static/modal.js"></script>
</body>
</html>