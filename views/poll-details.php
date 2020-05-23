<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast a Vote</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body class="todo-bg">
    <?php
        include("./components/header.php");
        include("../controllers/add_entry.php");
    ?>
    <form action="../controllers/add_entry.php" method="post" class="app"  id="post-journal">
        <div class="form-container">
            
            <div class="todo-panel">
                <h1>Question: </h1>
                <input type="text" class="form-control" placeholder="Enter Your Name">
                <p>cast your vote below</p>
                <button type="submit" name="ballot" value="yes" class="btn btn-primary">Yes</button>
                <button type="submit" name="ballot" value="no" class="no btn btn-primary">No</button>
                <button type="submit" name="ballot" value="maybe" class="maybe btn btn-primary">Maybe</button>
            </div>
            <div></div>
            <div></div>
        </div>
    </form>
    <script src="../static/main.js"></script>
</body>
</html>