<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select or create a category</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg">
    <?php
        include("./components/header.php");
        include("./components/modal.php");
        include("../controllers/edit_entry.php");
        include_once("../config/database.php");

        $database = new Database();
        $curs = $database->getConnection();
        $sql = "select distinct category from journal where category is not null";
        $result = mysqli_query($curs, $sql);
    ?>
    <form method="post">
        <div class="cat-panel">
            <h1>Journal Categories</h1>
            <div>
                <a href="" class="date-btn">File View</a>
            </div>
        </div>
        
        <div class="cat-grid">
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($_GET['subject']) {
                            echo "<div>";
                            echo "<button type='submit' name='category' value='".$row["category"]."'>".$row["category"]."</button>";
                            echo "</div>";
                        }
                        else {
                            echo "<div>";
                            echo "<a href='./logs.php?category=".$row["category"]."'>".$row["category"]."</a>";
                            echo "</div>";
                        }
                    }
                }
            ?>
        </div>
    </form>
    <?php
        if ($_POST['category'] && $_GET['rating'] != null) {
            $category = $_POST['category'];
            $sql = "insert into journal(subject, message, rating, category) values (?, ?, ?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("ssss", $_GET['subject'], $_GET['message'], $_GET['rating'], $category);
            $stmnt -> execute();
            header("Location: ./logs.php");
        }
        if ($_POST['category'] && $_GET['rating'] == null) {
            $category = $_POST['category'];
            $sql = "insert into journal(subject, message, category) values (?, ?, ?)";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("sss", $_GET['subject'], $_GET['message'], $category);
            $stmnt -> execute();
            header("Location: ./logs.php");
        }
    ?>
    <script src="../static/modal.js"></script>
    <script src="../static/main.js"></script>
</body>
</html>