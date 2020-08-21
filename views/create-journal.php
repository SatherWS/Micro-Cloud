<?php 
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");
    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select distinct category from journal where category is not null and team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("s", $_SESSION["team"]);
    $stmnt->execute();
    $result = $stmnt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal App</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <div class="todo-bg">
    <?php include("./components/header.php");?>
    <form action="../controllers/add_entry.php" method="post" class="app"  id="post-journal">
        <div class="form-container">
            <div class="todo-panel">
                <h1>Create New Note</h1>
                <div class="flex-subs">
                    <input type="text" name="jsubject" placeholder="Type Subject of Entry" id="form-control" class="spc-n j-title-field" required>
                    <input type="text" name="category" placeholder="Enter Subject's Category" list="categoryList" class="spc-n cat-list">
                    <datalist id="categoryList">
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row["category"]."'>";
                            }
                        }
                    ?>
                    </datalist>
                </div>
                <br>
                <textarea rows="7" placeholder="Write your post here..." name="note"></textarea>
                <!-- TODO: change to share with all of Swoop instead of team only
                <label class="container">
                    <input type="checkbox" name="omit">
                    <span class="checkmark"></span>
                    Allow others to edit
                </label>
                -->
                <br><br>
                <div class="sec-2">
                    <input name="add-journal" class="spc-n spc-m" type="submit" id="form-control2">
                </div>
            </div>
        </div>
    </form>
    </div>
    <script src="../static/main.js"></script>
</body>
</html>
