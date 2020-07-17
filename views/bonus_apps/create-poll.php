<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./templates/head.php");?>
</head>
<body class="todo-bg">
    <?php
        include("./templates/nav.php");
        include("../../config/database.php");

        $db = new Database();
        $curs = $db->getConnection();
        // add voting topic to table of polls
        if ($_POST["topic"] && $_POST["admin"]) {
            $sql = "insert into polls(admin, topic) values (?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("ss", $_POST['admin'], $_POST['topic']);
            $stmnt -> execute();
            header("Location: ./polls.php");
        }  
    ?>
    <form method="post" class="app"  id="post-journal">
        <div class="form-container">
            <div></div>
            <div class="todo-panel">
                <h1>Create New Ballot</h1>
                <h3>Username: <?php echo $_SERVER['REMOTE_ADDR'];?></h3>
                <input type="text" name="topic" placeholder="Create Topic to Vote On" id="form-control" class="spc-n" required>
                <input type="hidden" name="admin" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" required>
                <br><br>
                <input class="spc-n spc-m" type="submit">
            </div>
            <div></div>
        </div>
    </form>
    <script src="../static/main.js"></script>
</body>
</html>