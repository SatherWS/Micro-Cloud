<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast a Vote!</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        include("./components/header.php");
        include("../controllers/add_entry.php");  
    ?>

    <h1>Create New Poll</h1>
    <form method="post" action="../controllers/add_entry.php">
        <input type="text" name="topic" class="form-control" placeholder="Enter Poll Topic">
        <br>
        <input type="text" name="admin" class="form-control" placeholder="Enter Your Name">
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <script src="../static/main.js"></script>
</body>
</html>