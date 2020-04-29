<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Details</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
<nav class="topnav" id="myTopnav">
        <ul>
            <li>
                <a href="../index.html" class="active">Micro Cloud</a>
                <i class="fa fa-mixcloud"></i>
            </li>
            <li>
                <a href="#">User Stats</a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Todo App</a>
                <div class="dropdown-content">
                    <a href="./todo-list.html">Add Task</a>
                    <a href="./show-tasks.php">Manage Tasks</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Journal App</a>
                <div class="dropdown-content">
                    <a href="../journal.html">Create Entry</a>
                    <a href="./logs.php">All Entries</a>
                </div>
            </li>
            <li style="float:right"><a href="#">Donate</a></li>
            <li style="float:right"><a href="#">Login</a></li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </nav>
    <?php 
        include_once '../config/database.php';
        $database = new Database();
        $curs = $database->getConnection();

        if ($_GET['journal']) {
            $id = $_GET['journal'];
            $sql = "select * from journal where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
        }

        if ($_POST['edit']) {
            $id = $_POST['edit'];
            $sql = "select * from journal where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
        }

        if ($_POST['delete']) {
            $sql = "delete from journal where id = ?";
            mysqli_query($curs, $sql);
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $_POST['delete']);
            $stmnt -> execute();
            header("Location: ./logs.php");
        }
    ?>
    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h2 id="logs-title">Journal ID #<?php echo $_GET['journal']; ?></h2>
            </div>
            <div class="add-log">
                <form action="./journal-details.php" method="post">
                    <button><i class="fa fa-save"></i>Save Journal Entry</button>
                    <button type="submit" name="edit" value="<?php echo $_GET['journal']; ?>"><i class="fa fa-edit"></i>Edit Journal Entry</button>
                    <button type='submit' name='delete' value="<?php echo $_GET['journal']; ?>"><i class='fa fa-close'></i>Delete Journal Entry</button>
                </form>
            </div>
        </div>
    </div>
    <div class="log-container log-details">
        <form action="../edit_entry.php" method="post">
            <?php
                if ($_GET['journal'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h2>Subject: ".$row['subject']."</h2>";
                        echo "<h3>".$row['date_created']."</h3>";
                        echo "<p>Mood Rating: ".$row['rating']."</p>";
                        echo "<p class='message-p'>".$row['message']."</p>";
                    }
                }
                if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<h3>Editing: ".$row['subject']."</h3>";
                        echo "<textarea name='edited' cols='100' rows='14'>".$row['message']."</textarea>";
                        echo "<br><button type='submit' name='edit' value='".$row['id']."'>Save Changes</button>";
                        echo "<a href='./logs.php'>Cancel</a>";    
                    }
                }
            ?>
        </form>
        <?php
            // Better way to store images
            /*
            $image = 'http://www.google.com/doodle4google/images/d4g_logo_global.jpg';
            $imageData = base64_encode(file_get_contents($image));
            echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
            */
        ?>
    </div>
    <script src="../main.js"></script>
</body>
</html>