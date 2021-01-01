<?php 
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    // TODO: MOVE ALL BELOW THIS TO CONTROLLERS v
    include_once('../config/database.php');
    $database = new Database();
    $curs = $database->getConnection();

    if (isset($_GET['journal'])) {
        $id = $_GET['journal'];
        $sql = "select * from journal where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $row = mysqli_fetch_assoc($results);
        if ($row["creator"] == $_SESSION["unq_user"]) {
            $show_editor = true;
            $read_only = false;
        }
        else
            $read_only = true;
    }

    if (isset($_POST['edit'])) {
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
		        $html .= "<input type='text' value='".$row["subject"]."' name='jsubs' class='edit-subs'>";
                $html .= "<div class='text-left todo-flex'><div><button class='add-btn art-ops' type='submit' name='img-upload' value='".$row['id']. "'><i class='fa fa-image'></i>Upload Image</button>";
                $html .= "<button class='add-btn art-ops' type='submit' name='file-upload' value='".$row['id']. "'><i class='fa fa-file-o'></i>Attach A File</button></div>";
                $html .= "<button class='add-btn art-ops' type='submit' name='edit' value='".$row['id']. "'><i class='fa fa-info-circle'></i>Markdown Help</button></div>";
                $html .= "<textarea name='edited' cols='100' rows='14' class='edit-field'>".$row['message']."</textarea>";
                $html .= "<input type='hidden' name='edit' value='".$row['id']."'></div>";
            }
        }
    }

    if (isset($_POST['delete'])) {
        $sql = "delete from journal where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./logs.php");
    }
    // TODO: MOVE ALL ABOVE THIS TO CONTROLLERS ^
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <title>Swoop | Post</title>
</head>
<body>
<?php include("./components/header.php");?>
<div class="svg-bg sticky">
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
    // display article in plain text or inside a textarea depending on button click
    // raw data is stored in the database and decoded with nl2br function
        if (isset($row)) 
        {
            echo "<div class='log-details'>";
            echo "<h1 class='padb'>".$row['subject']."</h1>";
            echo "<small>Author: ".$row['creator']."</small><br>";
            echo "<small>Posted: ".$row['date_created']."</small><br>";
            echo "<p class='message-p'>".nl2br($row['message'])."</p>";
            echo "</div>";
        }

        if ($_POST['edit'] && mysqli_num_rows($results) > 0) 
        {
            echo $html;
        }
    ?>
</form>
<!--
<br>
<form action="../controllers/add_comment.php">
    <div class="log-details">
        <textarea name="comment" cols="30" rows="10"></textarea>
        <input type="submit" value="Send Comment">
    </div>
</form>
-->
<script>
    function triggerForm() {
        document.getElementById("editor").submit();
    }
</script>
<script src="../static/main.js"></script>
<script src="../static/modal.js"></script>
</body>
</html>
