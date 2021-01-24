<?php 
    include_once('../config/database.php');
    include("../libs/Parsedown.php");
    include("../models/comment.php");
    session_start();

    // TODO: MOVE PHP ELEMENTS TO CONTROLLERS 
    $database = new Database();
    $pd = new Parsedown();
    $curs = $database->getConnection();
    

    function getAttachments($curs, $id)
    {   
        $ret = "";
        $sql = "select file_name, file_type, file_path from file_storage where article_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        
        if ($stmnt -> execute())
            return true;
        else
            return false;
    }
    
    $file_link = "";

    if (isset($_GET['journal'])) 
    {
        $id = $_GET['journal'];
        
        $sql = "select * from journal where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $row = mysqli_fetch_assoc($results);

        if (getAttachments($curs, $id)) 
        {
            $title = $row["subject"];
            $file_link .= "<a href='./file-storage.php?article=$id&title=$title'>";
            $file_link .= "View Attached Files</a>";
        }
        
        if ($row["creator"] == $_SESSION["unq_user"]) 
        {
            $show_editor = true;
            $read_only = false;
        }
        else
            $read_only = true;
    }


    if (isset($_POST['edit'])) 
    {
        $id = $_POST['edit'];
        $sql = "select * from journal where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $show_editor = false;

        $html = "";
        if (mysqli_num_rows($results) > 0) 
        {
            while($row = mysqli_fetch_assoc($results)) 
            {
                $html .= "<div class='log-container editor'>";
                $html .= "<input type='text' value='".$row["subject"]."' name='jsubs' class='edit-subs' tabindex=2>";
                $html .= "<textarea name='edited' cols='100' rows='14' class='edit-field' tabindex=3>".$row['message']."</textarea>";
                $html .= "<input type='hidden' name='edit' value='".$row['id']."'></div>";
            }
        }
    }

    if (isset($_POST['delete'])) 
    {
        $sql = "delete from file_storage where article_id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();

        $sql = "delete from journal where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./logs.php");
    }
    // TODO: MOVE ALL ABOVE THIS TO CONTROLLERS 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/mini_nav.css">
    <link rel="stylesheet" href="../static/code-highlight.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <title>Swoop | Viewing an article</title>
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            tex2jax: {
                inlineMath: [ ['$','$'], ["\\(","\\)"] ],
                processEscapes: true,
                skipTags: ["script","noscript","style","textarea","pre","code"]
            }
        });
    </script>
    <script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML"></script>
</head>
<body>
<?php include("./components/header.php");?>
<div class="svg-bg">
    <div class="todo-flex">
        <?php
            if ($show_editor)
                include("./components/note-headers/edit_post.php");

            else if (!$show_editor && !$read_only)    
                include("./components/note-headers/save_post.php");

            else if (!$show_editor && $read_only)
                echo "<h4 class='ml2rem'></h4>";
        ?>
    </div>    
</div>

<form action="../controllers/edit_entry.php" method="post" id="editor" enctype="multipart/form-data">
    <?php
    /*  display article in plain text or inside a textarea depending on button click
        raw data is stored in the database and decoded with nl2br function
    */
    if (isset($row)) 
    {
        $id = $row['id'];

        // detail view that displays to all user types 
        echo "<div class='log-details'>";
        echo "<h1 class='padb'>".$row['subject']."</h1>";
        echo "<small>Author: ".$row['creator']."</small><br>";
        echo "<small>Project: ".$row['team_name']."</small><br>";
        echo "<small>Posted: ".$row['date_created']."</small><br>";
        
        if ($file_link != "" && !$read_only) {
            echo $file_link;
        }
        $md = $pd -> text($row['message']);
        echo $md;
    
        echo "</div>";
    }


    if (!$read_only && !isset($_POST["edit"])) 
    {
        // File and image upload form
        echo "<div class='topnav2' id='item-container'>";
        echo "<a class='choice active' onclick='changeActive(0)' href='#choice' id='mobile'>Insert an image file</a>";
        echo "<a class='choice' onclick='changeActive(1)' href='#choice'>Attach an approved file</a>";
        echo "</div>";
        echo "<input type='hidden' value='$id' name='article_assoc'>";

        // image upload form section
        echo "<div class='todo-flex r-cols upload-forms'>";
        echo "<section>";
        echo "<br>Select an image to add to the article:<br>";
        echo "<input type='file' name='imageToUpload' id='imageToUpload'>";
        echo "</section>";

        echo "<section>";
        echo "<input type='submit' value='Image Upload' name='img-upload' class='add-btn-2'>";
        echo "</section>";
        echo "</div>";

        // file upload form section
        echo "<div class='todo-flex r-cols upload-forms' style='display:none;'>";
        echo "<section>";
        echo "<br><span>Attach a relevant file to this article:</span><br>";
        echo "<input type='file' name='fileToUpload' id='fileToUpload'>";
        echo "</section>";

        echo "<section>";
        echo "<input type='submit' value='File Upload' name='file-upload' class='add-btn-2'>";
        echo "</section>";

        echo "</div>";
    }

    if ($_POST['edit'] && mysqli_num_rows($results) > 0) 
        echo $html;
?>
</form>
<!-- Comment form -->
<?php
    if (!isset($_SESSION["unq_user"]))
        $user = "guest";
    else
        $user = $_SESSION["unq_user"];
?>
<div class="comment-area">
    <form method="post" action="../models/comment.php" id="comments">
        <div class="log-details">
            <textarea name="comment" cols="30" rows="10" placeholder="Commenting as <?php echo $user;?>"></textarea>
            <input type="hidden" name="art_id" value="<?php echo $_GET['journal'];?>">
            <input type="submit" value="Post Comment" class="add-btn-2">
        </div>
    </form>
    <br>
    <div class="log-details">
        <?php
            $comments = new Comments();
            $comm_lst = $comments -> showComments($curs, $_GET["journal"]);

            while ($row = mysqli_fetch_assoc($comm_lst)) {
                echo "<div class='uline'></div>";
                echo "<p><b>".$row["user_email"]."</b></p>";
                echo "<p>".$row["comment"]."</p>";
                echo "<small>".$row["date_created"]."</small><br><br>";
            }
        ?>
    </div>
</div>

<script>
    function triggerForm() {
        document.getElementById("editor").submit();
    }

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

    function showIcons() {
        return 0;
    }
</script>
<script src="../static/main.js"></script>
</body>
</html>
