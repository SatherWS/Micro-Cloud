<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");

    $db = new Database();
    $curs = $db -> getConnection();

    $sql = "select journal.id, file_storage.article_id, file_storage.id as img_id, journal.team_name,journal.subject, journal.creator, file_storage.file_path, file_storage.file_name, file_storage.file_class,file_storage.file_type, file_storage.date_created from journal inner join file_storage on journal.id = file_storage.article_id or journal.team_name = substring_index(file_storage.file_class, ' ', -1) where journal.team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $result = $stmnt -> get_result();

    $project_imgs = "";
    $project_files = "";

    while ($row = mysqli_fetch_assoc($result))
    {
	$general_upload = explode(" ", $row["file_class"]);

	if ($row["file_class"] == "file" || $general_upload[0]." ".$general_upload[1] == "general file")
        {
            $project_files .= "<tr>";
            $project_files .= "<td><p><a href='".$row["file_path"]."' download>";
            $project_files .= $row["file_name"].".".$row["file_type"]."</a></p></td>";
            $project_files .= "<td><a href='./journal-details.php?journal=".$row["id"]."'>";
            $project_files .= $row["subject"]."</a></td>";
            $project_files .= "<td>".$row["creator"]."</td>";
            $project_files .= "<td>".$row["date_created"]."</td>";
            $project_files .= "</tr>";
        }

        if ($row["file_class"] == "image" || $general_upload[0]." ".$general_upload[1] == "general image") 
        {
            $project_imgs .= "<br><div class='uline-lite'></div><br>";
            $project_imgs .= "<div class='todo-flex r-cols'>";
            $project_imgs .= "<div>";
            $project_imgs .= "<h3>".$row["file_name"].".".$row["file_type"]."</h3>";
            $project_imgs .= "<p><a href='".$row["file_path"]."' download>Download: ";
            $project_imgs .= $row["file_name"].".".$row["file_type"]."</a></p>";
            $project_imgs .= "<p><a href='./journal-details.php?journal=".$row["article_id"]."'>Related Article: ".$row["subject"]."</a></p>";
            $project_imgs .= "<p>Creator: ".$row["creator"]."</p>";
            $project_imgs .= "<p>Date Posted: ".$row["date_created"]."</p>";
            $project_imgs .= "<form method='post' action='../controllers/delete_image.php'>";
            $project_imgs .= "<input type='submit' value='Delete Image' name='delete-img' class='add-btn'>";
            $project_imgs .= "<input type='hidden' value='".$row["img_id"]."' name='img-id' />";
            $project_imgs .= "</form>";
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
                $images .= "<h3>".$row["file_name"].".".$row["file_type"]."</h3>";
                $images .= "<p><a href='".$row["file_path"]."' download>Download: ";
                $images .= $row["file_name"].".".$row["file_type"]."</a></p>";
                $images .= "<p><a href='./journal-details.php?journal=".$row["article_id"]."'>Related Article: ".$row["subject"]."</a></p>";
                $images .= "<p>Creator: ".$row["creator"]."</p>";
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
    <link rel="stylesheet" href="../static/mini_nav.css">
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
                <form method="post" action="../controllers/upload_data.php" enctype="multipart/form-data" class="inner-nav2">
                    <div class='mt-0 topnav2' id='item-container'>
                        <a class='choice active' onclick='changeActive(0)' href='#choice' id='mobile'>Upload an image file</a>
                        <a class='choice' onclick='changeActive(1)' href='#choice'>Upload an approved file</a>
                    </div>
                        <input type='hidden' value='$id' name='article_assoc'>

                        <div class='todo-flex r-cols upload-forms flex-end'>
                        <section>
                            <br>Upload an image:<br>
                            <input type='file' name='imageToUpload' id='imageToUpload'>
                        </section>

                        <section>
                            <input type='submit' value='Image Upload' name='img-upload' class='add-btn-2'>
                            </section>
                        </div>

                    <div class='todo-flex r-cols upload-forms flex-end' style='display:none;'>
                        <section>
                            <br><span>Upload a file:</span><br>
                            <input type='file' name='fileToUpload' id='fileToUpload'>
                        </section>

                        <section>
                            <input type='submit' value='File Upload' name='file-upload' class='add-btn-2'>
                        </section>
		    </div>
		<br>
		</form>
                <?php 
                    if (isset($_GET["title"]) && isset($_GET["article"]))
                        include("./components/article-files.php");
                ?>
                <h2 class="ml2rem">Project files & images: <?php echo $_SESSION["team"];?></h2>
                <div class="settings-space">
                    <div class="settings-panel">
                        <h3>All Files Uploaded</h3>
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
                        <h3>All Images Uploaded</h3>
                        <?php echo $project_imgs;?>
                    </div>
                </div>
            </div>

            <?php include("./components/sidebar.php");?>
        </div>
    </div>
    <script src="../static/main.js"></script>
    <script src="../static/modal.js"></script>
    <script>
        function changeActive(selected) {
            var choices = document.getElementsByClassName("choice");
            var forms = document.getElementsByClassName("upload-forms");
            
            for (var i = 0; i < choices.length; i++) {
                if (i != selected) {
                    choices[i].style.borderBottom = "none";
                    forms[i].style.display = "none";
                }
                else {
                    choices[i].style.borderBottom = "3px solid #4c4177";
                    forms[i].style.display = "flex";
                }
            }
        }
    </script>
</body>
</html>
