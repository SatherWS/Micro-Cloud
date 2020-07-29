<?php
    session_start();
    if (!isset($_SESSION["unq_user"]))
        header("Location: ../authentication/login.php");
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $sql = "select email from users where team = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamswoop | User Settings</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <?php include("./components/header.php");?>
    <div class="todo-bg">
        <div class="settings-space">
            <div class="settings-panel">
                <h1>User & Team Settings</h1>
                <div class="settings-flex r-cols">
                    <div>
                        <h2>Your User Info</h2>
                        <?php 
                            echo "<p>Username: ".$_SESSION["user"]."</p>";
                            echo "<p>Email: ".$_SESSION["unq_user"]."</p>";
                            echo "<p>Team: ".$_SESSION["team"]."</p>";
                        ?>
                    </div>
                    <form action="">
                        <h2>Members of <?php echo $_SESSION["team"];?></h2>
                        <input type="text" name="user_email" placeholder="Add a new Team member" class="simple-input" required>
                        <br><br>
                        <input type="submit" value="Invite User">
                        <?php
                            while ($row = mysqli_fetch_assoc($results)) {
                                echo "<p>".$row["email"]."</p>";
                            }
                        ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>