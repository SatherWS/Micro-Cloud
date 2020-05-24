<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Details</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
        include("./components/header.php");
        include_once ('../config/database.php');
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
            <div class="add-log">
                <form action="./journal-details.php" method="post">
                    <button type="submit" name="edit" value="<?php echo $_GET['journal']; ?>">
                    <i class="fa fa-edit"></i><span class="opt-desc">Edit Journal Entry</span></button>

                    <button type='submit' name='delete' value="<?php echo $_GET['journal']; ?>">
                    <i class='fa fa-close'></i><span class="opt-desc">Delete Journal Entry</span></button>
                </form>
            </div>    
            <div class="review">
                <h3 id="logs-title">
                <?php
                    $sql2 = "select * from journal where id = ".$_GET['journal'];
                    if ($_POST['edit'])
                        $sql2 = "select * from journal where id = ".$_POST['edit'];
                    $results2 = mysqli_query($curs, $sql2);
                    if (mysqli_num_rows($results2) > 0) {
                        while ($row = mysqli_fetch_assoc($results2)) {
                            echo "Subject: ".$row["subject"];
                        }
                    }
                ?>
                </h3>
            </div>
        </div>
    </div>
    <form action="../controllers/edit_entry.php" method="post">
        <?php
            if ($_GET['journal'] && mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                    echo "<div class='detail-topper'>";
                    echo "<h4>".$row['date_created']."</h4>";
                    if ($row['rating'] == null)
                        echo "<h4>Mood Rating: N/A</h4>";
                    else
                        echo "<h4>Mood Rating: ".$row['rating']."</h4>";
                    echo "</div>";
                    echo "<div class='log-container log-details'>";
                    echo "<p class='message-p'>".$row['message']."</p>";
                    echo "</div>";
                }
            }
            if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                    echo "<div class='log-container log-details editor'>";
                    echo "<textarea name='edited' cols='100' rows='14'>".$row['message']."</textarea>";
                    echo "<br><button type='submit' name='edit' value='".$row['id']."'>Save Changes</button>";
                    echo "<a href='./logs.php'>Cancel</a>"; 
                    echo "</div>";
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
    <script src="../static/main.js"></script>
</body>
</html>
