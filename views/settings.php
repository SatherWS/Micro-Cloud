<?php
    include_once("../config/database.php");
    include("../models/settings.php");

    session_start();
    if (!isset($_SESSION["unq_user"]))
        header("Location: ../authentication/login.php");
    
    $db = new Database();
    $curs = $db -> getConnection();
    $sql = "select email from users where team = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();

    if (isset($_POST["search_user"])) {
        $search = "select email from users where email = ?";
        $stmnt = mysqli_prepare($curs, $search);
        $stmnt -> bind_param("s", $_POST["user_email"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        if ($result) {
            // this is temporary pseudocode
            $push_user = new Pusher();
            $add_guy = $push_user->add_guy();
        }

    }
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
                    <div class="add-worker">
                        <form method="post">
                            <h2>Add New Team Member</h2>
                            <input type="text" name="user_email" placeholder="Search member by email address" class="spc-n simple-input" required>
                            <br><br>
                            <input type="submit" name="search_user" value="Invite User">
                        </form>
                        
                        <?php
                            if (isset($_GET["error"])) {
                                echo "<div><p>".$_GET["error"]."</p></div>";
                            }
                            echo "<h2>Team Members of ".$_SESSION['team']."</h2>";
                            while ($row = mysqli_fetch_assoc($results)) {
                                echo "<p>".$row["email"]."</p>";
                            }
                        ?>
                    </div>
                    <div>
                        <h2>Current User Info</h2>
                        <?php 
                            echo "<p>Username: ".$_SESSION["user"]."</p>";
                            echo "<p>Email: ".$_SESSION["unq_user"]."</p>";
                            echo "<p>Team: ".$_SESSION["team"]."</p>";
                        ?>
                    </div>

                </div>
                <!-- WIP
                <h1>Danger Zone</h1>
                -->
            </div>
        </div>
    </div>
</body>
</html>