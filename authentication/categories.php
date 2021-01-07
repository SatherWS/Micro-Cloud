<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include("../controllers/edit_entry.php");
    include_once("../config/database.php");

    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select distinct cat_name from categories";
    $result = mysqli_query($curs, $sql);

    if (isset($_POST["create-cat"])) {
        $ins = "insert into categories(cat_name, team_name) values (?, ?)";
        $stmnt2 = mysqli_prepare($curs, $ins);
        $stmnt2 -> bind_param("ss", $_POST["cat-name"], $_SESSION["team"]);
        $stmnt2 -> execute();
    }
    if (isset($_POST["team_category"])) {
        $sql = "alter table teams set category = ?";
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select or create a category</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/checkmarks.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg">
    <nav class="topnav" id="myTopnav">
        <div class="index-nav parent-nav">
            <ul>
                <li>
                    <a href="../index.php" class="active">Swoop.Team</a>
                    <i class="fa fa-wifi"></i>
                </li>
            </ul>
        </div>
    </nav>
    <div class="cat-panel todo-flex">
        <h2 class="text-center">Select or create categories for your project</h2>
        <p>multiple categories may be selected.</p>
    </div>
    <div class="cat-panel">
        <form method="post" class="text-center">
            <div class="todo-flex">
                <input type="text" class="spc-n" name="cat-name" placeholder="Create New Category" required="">
                <input type="submit" value="Create Category" name="create-cat">
            </div>
        </form>
        <form method="post">
            <div class="cat-grid">
                <?php
                    $html = "";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $html .= "<label class='container'>".$row["cat_name"];
                        $html .= "<input type='checkbox'>";
                        $html .= "<span class='checkmark'></span></label>";
                    }
                    echo $html;
                ?>
            </div>
            <input type="submit" name="team_category" value="Set Category">
        </form>
    </div>
    <script src="../static/main.js"></script>
</body>
</html>