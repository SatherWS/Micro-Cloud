<?php
    include("../config/database.php");
    $db = new Database();
    $curs = $db->getConnection();
    if (isset($_POST["confirm"])) {
        $sql = "update users set team = ? where email = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_GET["team"], $_GET["email"]);
        $stmnt -> execute();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamswoop | Confirm</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <div class="todo-bg">
        <form  method="post" class="spc-pt">
            <div class="form-container">
                <div class="todo-panel">
                    <h1>Do you want to join team <?php echo $_GET["team"];?></h1>
                    <p><a href="#">Confirm</a></p>
                </div>
            </div>
        </form>
    </div>    
</body>
</html>