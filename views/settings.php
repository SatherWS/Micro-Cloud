<?php
include_once("../config/database.php");
//include("../models/settings.php");

session_start();
if (!isset($_SESSION["unq_user"]))
    header("Location: ../authentication/login.php");

$db = new Database();
$curs = $db -> getConnection();

function get_admin($curs, $user, $team) {
    $sql = "select admin from teams where admin = ? and team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("ss", $user, $team);
    $stmnt->execute();
    $result = $stmnt->get_result();
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}
function invite_count($curs, $user) {
    $sql = "select count(*) from invites where sender = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $user);
    $stmnt -> execute();
    $result = $stmnt -> get_result();
    $data = mysqli_fetch_assoc($result);
    return $data["count(*)"];
}

if (isset($_SESSION["team"])) {
    $sql = "select email from members where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
}
if (invite_count($curs, $_SESSION["unq_user"]) > 0) {
    $sql2 = "select * from invites where sender = ? and team_name = ? order by date_created desc";
    $stmnt2 = mysqli_prepare($curs, $sql2);
    $stmnt2->bind_param("ss", $_SESSION["unq_user"], $_SESSION["team"]);
    $stmnt2->execute();
    $results2 = $stmnt2->get_result();
}
if (isset($_SESSION["team"]) && get_admin($curs, $_SESSION["unq_user"], $_SESSION["team"])) {
    $sql3 = "select * from invites where receiver = ? and team_name = ? order by date_created desc";
    $stmnt3 = mysqli_prepare($curs, $sql3);
    $stmnt3->bind_param("ss", $_SESSION["unq_user"], $_SESSION["team"]);
    $stmnt3->execute();
    $results3 = $stmnt3->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swoop.Team | User Settings</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="todo-bg-test">
<?php include("./components/header.php");?>
<?php include("./components/modals/modal.php");?>
<div class="todo-bg-test">
    <div class="svg-bg">
        <div class="todo-flex">
            <p class="welcome"><?php echo $_SESSION["team"];?></p>
            <p class="welcome"><?php echo $_SESSION["unq_user"];?></p>
        </div>
    </div>
    <div class="dash-grid r-cols" id="main">
        <div>
            <h2 class="ml2rem">Team Member Settings</h2>
            <div class="settings-space">
                <div class="settings-panel">
                    <div class="settings-flex r-cols">
                        <div>
                            <?php
                            if (isset($results)) 
                            {
                                echo "<h3>Members of ".$_SESSION['team']."</h3>";
                                while ($row = mysqli_fetch_assoc($results))
                                    echo "<p>".$row["email"]."</p>";
                            }
                            else
                                echo "<p>This user does not belong to a project</p>";
                            ?>
                        </div>
                        <div>
                            <h3>User Information</h3>
                            <?php 
                            if (isset($_GET["error"])) 
                                echo "<div><p>".$_GET["error"]."</p></div>";
                            echo "<p>Username: ".$_SESSION["user"]."</p>";
                            echo "<p>Email: ".$_SESSION["unq_user"]."</p>";
                            echo "<p>Team: ".$_SESSION["team"]."</p>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings-space">
                <h2 class="ml2rem">Invitation Settings</h2>
                <div class="settings-panel">
                    <div class="invites">
                        <?php
                            if (invite_count($curs, $_SESSION["unq_user"]) > 0) {
                                include("./components/sender-table.php");
                            }
                            else {
                                echo "<h4 class='stng-msg'>No requests have been sent yet...</h4>";
                            }
                        ?>
                    </div>
                    <h3>Requests to join project: <?php echo $_SESSION["team"];?></h3>
                    <?php
                        if (get_admin($curs, $_SESSION["unq_user"], $_SESSION["team"])) 
                            include("./components/requests-table.php");

                        else
                            echo "<h4 class='stng-msg'>No requests have been made yet...</h4>";
                    ?>
                </div>
                <h2 class="ml2rem">Danger Zone - Project Settings</h2>
                <div class="settings-space">
                    <div class="settings-panel">
                        <div class="settings-flex r-cols">
                            <div>
                                <h3>Delete your account: <?php echo $_SESSION["unq_user"];?></h3>
                                <form action="../controllers/delete_project.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');">
                                    <input type="hidden" name="account" value="<?php echo $_SESSION["unq_user"];?>">
                                    <input type="submit" name="delete_acct" value="DELETE ACCOUNT">
                                </form>
                            </div>
                            <div>
                                <h3>Delete your project: <?php echo $_SESSION["team"];?></h3>
                                <form action="../controllers/delete_project.php" method="post" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    <input type="hidden" name="project" value="<?php echo $_SESSION["team"];?>">
                                    <input type="submit" name="delete_proj" value="DELETE PROJECT">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br></br>
        </div>
        <?php include("./components/sidebar.php");?>
    </div>
</div>
<script src="../static/main.js"></script>
<script src="../static/modal.js"></script>
</body>
</html>
