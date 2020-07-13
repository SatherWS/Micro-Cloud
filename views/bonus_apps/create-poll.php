<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./templates/head.php");?>
</head>
<body class="todo-bg">
    <?php
        include("./templates/nav.php");
        include("../controllers/add_entry.php");  
    ?>
    <form action="../controllers/add_entry.php" method="post" class="app"  id="post-journal">
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