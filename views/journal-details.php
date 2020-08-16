<?php 
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    // TODO: MOVE THIS TO CONTROLLERS v
    include_once('../config/database.php');
    $database = new Database();
    $curs = $database->getConnection();
    $show_editor = true;

    function check_permissions($curs, $user, $id) {
        $sql = "select is_private, creator from journal where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("s", $id);
        $stmnt->execute();
        $result = $stmnt->get_result();
        $row = mysqli_fetch_assoc($result);
        if ($user != $row["creator"] && $row["is_private"] == "private") {
            return false;
        }
        if ($user == $row["creator"] || $row["is_private"] == "public") {
            return true;
        }
    }

    if (isset($_GET['journal'])) {
        $id = $_GET['journal'];
        $sql = "select * from journal where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $show_editor = false;
    }

    if (isset($_POST['edit'])) {
        $id = $_POST['edit'];
        $sql = "select * from journal where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
    }

    if (isset($_POST['delete'])) {
        $sql = "delete from journal where id = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST['delete']);
        $stmnt -> execute();
        header("Location: ./logs.php");
    }
    // TODO: MOVE THIS TO CONTROLLERS ^
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <title>Swoop | Post</title>
</head>
<body>
<?php include("./components/header.php"); ?>
<div class="svg-bg">
        <div class="todo-flex r-cols">
            <?php
            if (check_permissions($curs, $_SESSION["unq_user"], $_GET["journal"])) {
                if ($show_editor) {
                    include("./components/note-headers/save_post.php");
                }
                else {
                    include("./components/note-headers/edit_post.php");
                }
            }
            else {
                echo "<div class='svg-bg'><h3 id='logs-title' class='full-screen'>READ ONLY</h3></div>";
            }
            ?>
        </div>    
</div>
<form action="../controllers/edit_entry.php" method="post" id="editor">
    <?php
    // display journal entry in plain text or inside a textarea
    // raw data is stored in lhapps database and decoded with nl2br() function
        if ($_GET['journal'] && mysqli_num_rows($results) > 0) {
            while($row = mysqli_fetch_assoc($results)) {
                echo "<div class='log-details'>";
                echo "<div class='detail-topper'>";
                echo "<div><h1 class='padb'>".$row['subject']."</h1>";
                echo "<small>Author: ".$row['creator']."</small><br>";
                echo "<small>Author: ".$row['is_private']."</small><br>";
                echo "<small>Posted: ".$row['date_created']."</small><br>";
                echo "<small>Category: ".$row['category']."</small>";
                echo "<p class='message-p'>".nl2br($row['message'])."</p>";
                echo "</div>";
            }
        }

        if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
            while($row = mysqli_fetch_assoc($results)) {
                echo "<div class='log-container editor'>";
                //echo "<button class='badge'>Add Link</button>";
                //echo "<button class='badge'>Add Table</button>";
                //echo "<button class='badge'>Insert Media</button>";
                echo "<textarea name='edited' cols='100' rows='14' class='edit-field'>".$row['message']."</textarea>";
                echo "<input type='hidden' name='edit' value='".$row['id']."'></div>";
            }
        }
    ?>
</form>
<script>
    function triggerForm() {
        document.getElementById("editor").submit();
    }
</script>
<script src="../static/main.js"></script>
</body>
</html>
