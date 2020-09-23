<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include("../controllers/edit_entry.php");
    include_once("../config/database.php");

    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select * from team_categories";
    $result = mysqli_query($curs, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select or create a category</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

.checks {
    padding: 0 2rem;
}
</style>
</head>
<body class="todo-bg">
    <?php include("../views/components/header.php");?>
    <div class="cat-panel todo-flex">
        <h2 class="text-center">Select or Create a Project Category</h2>
        <p>Multiple categories may be selected.</p>
    </div>
    <form method="post" class="cat-panel">
        <div class="checks">
            <label class="container">One
                <input type="checkbox" checked="checked">
                <span class="checkmark"></span>
            </label>
            <label class="container">Two
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
            <label class="container">Three
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
            <label class="container">Four
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
        </div>
        <div class="r-cols cat-grid">
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($_GET['subject']) {
                            echo "<div>";
                            echo "<button type='submit' name='category' value='".$row["category"]."'>".$row["category"]."</button>";
                            echo "</div>";
                        }

                        // may remove
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
    <script src="../static/main.js"></script>
</body>
</html>