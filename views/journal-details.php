<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Details</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <?php 
        include("./components/header.php");
        include("./components/note-headers/forms.php");
        include_once('../config/database.php');
        $database = new Database();
        $curs = $database->getConnection();

        $form = new FormGenerator();
        $show_editor = true;

        if ($_GET['journal']) {
            $id = $_GET['journal'];
            $sql = "select * from journal where id = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            $show_editor = false;
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
                <h3 id="logs-title">
                <?php
                    $sql2 = "select * from journal where id = ".$_GET['journal'];
                    if ($_POST['edit']) {
                        $sql2 = "select * from journal where id = ".$_POST['edit'];
                    }
                    $results2 = mysqli_query($curs, $sql2);
                    if (mysqli_num_rows($results2) > 0) {
                        while ($row = mysqli_fetch_assoc($results2)) {
                            echo "Category: ".$row["category"];
                        }
                    }
                ?>
                </h3>
            </div>
            <div class="add-log">
                <?php
                    if ($show_editor) {
                        $form -> showEditor($_GET["journal"]);                        
                    }
                    else {
                        $form -> showDefault($_GET["journal"]);
                    }
                ?>
            </div>    
        </div>
    </div>
    <form action="../controllers/edit_entry.php" method="post" id="editor">
        <?php
        // display journal entry in plain text or inside a textarea
        // raw data is stored in lhapps database and decoded with nl2br() function
            if ($_GET['journal'] && mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                    echo "<div class='log-details'>";
                    echo "<div class='detail-topper'>";
                    echo "<div><h1 class='padb'>".$row['subject']."</h1>";
                    echo "<small>".$row['date_created']."</small>";
                    if ($row['rating'] == null)
                        echo "<br><small>Mood Rating: N/A</small></div>";
                    else
                        echo "<br><small>Mood Rating: ".$row['rating']."</small></div>";
                    echo "<p class='message-p'>".nl2br($row['message'])."</p>";
                    echo "</div>";
                }
            }

            if ($_POST['edit'] && mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                    echo "<div class='log-container editor'>";
                    //echo "<button class='badge'>Add Link</button>";
                    //echo "<button class='badge'>Add Table</button>";
                    //echo "<button class='badge'>Insert Media</button>";
                    echo "<textarea name='edited' cols='100' rows='14' class='edit-field'>".$row['message']."</textarea>";
                    echo "<input type='hidden' name='edit' value='".$row['id']."'></div>";
                }
            }
        ?>
    </form>
    <script>
        function triggerForm() {
            document.getElementById("editor").submit();
        }
    </script>
    <script src="../static/main.js"></script>
</body>
</html>
