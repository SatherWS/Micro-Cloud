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
<body class="todo-bg">
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
                <textarea rows="7" placeholder="Text area for creating a post..." name="note"></textarea>
                <br><br>
                <label class="container">
                    <input type="checkbox" name="omit">
                    <span class="checkmark"></span>
                    Make Private
                </label>
                <div class="sec-2">
                    <!--
                    <input type="range" min="0" max="10" value="5" class="slider" id="myRange" name="rating" required>
                    <div class="j-box">
                        <div>
                            <label class="container">
                                <input type="checkbox" name="omit">
                                <span class="checkmark"></span>
                                Omit Mood Rating
                            </label>
                        </div>
                        <label style="text-align: left;">Mood Rating: <span id="demo"></span></label>
                    </div>
                    -->
                    <input name="add-journal" class="spc-n spc-m" type="submit" id="form-control2">
                </div>
            </div>
        </div>
    </form>
    
    <script src="../static/main.js"></script>
    <script>
        // range slider display
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;
        
        slider.oninput = function() {
          output.innerHTML = this.value;
        }
    </script>
    <!-- jQuery then Javascript libraries
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     -->
</body>
</html>
