<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast a Vote!</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg">
    <?php
        include("./components/header.php");
        include("../controllers/add_entry.php");  
    ?>
    <form action="../controllers/add_entry.php" method="post" class="app"  id="post-journal">
        <div class="form-container">
            <div></div>
            <div class="todo-panel">
                <h1>Journal Application</h1>
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