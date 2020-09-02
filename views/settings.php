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
    $sql2 = "select * from invites where sender = ? order by date_created desc";
    $stmnt2 = mysqli_prepare($curs, $sql2);
    $stmnt2->bind_param("s", $_SESSION["unq_user"]);
    $stmnt2->execute();
    $results2 = $stmnt2->get_result();
}
if (isset($_SESSION["team"]) && get_admin($curs, $_SESSION["unq_user"], $_SESSION["team"])) {
    $sql3 = "select * from invites where receiver = ? order by date_created desc";
    $stmnt3 = mysqli_prepare($curs, $sql3);
    $stmnt3->bind_param("s", $_SESSION["unq_user"]);
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
<?php include("./components/modal.php");?>
<div class="todo-bg-test">
    <div class="svg-bg">
        <div class="todo-flex">
            <p class="welcome"><?php echo $_SESSION["team"];?></p>
            <p class="welcome"><?php echo $_SESSION["unq_user"];?></p>
        </div>
    </div>
    <div class="dash-grid r-cols" id="main">
        <?php include("./components/sidebar.php");?>
        <div class="settings-space">
            <div class="settings-panel">
                <div class="settings-flex r-cols">
                    <div>
                        <h2>User Information</h2>
                        <?php 
                            if (isset($_GET["error"])) {
                                echo "<div><p>".$_GET["error"]."</p></div>";
                            }
                            echo "<p>Username: ".$_SESSION["user"]."</p>";
                            echo "<p>Email: ".$_SESSION["unq_user"]."</p>";
                            echo "<p>Team: ".$_SESSION["team"]."</p>";
                        ?>
                    </div>
                    <div>
                        <?php
                            if (isset($results)) {
                                echo "<h2>Members of ".$_SESSION['team']."</h2>";
                                while ($row = mysqli_fetch_assoc($results)) {
                                    echo "<p>".$row["email"]."</p>";
                                }
                            }
                            else
                                echo "<p>This user does not belong to a project</p>";
                        ?>
                    </div>
                </div>

                <!-- Do not include in version 2.0
                <div class="add-worker">
                    <form method="post" action="../controllers/auth_user.php">
                        <h3>Invite a new user to project: <?php //echo $_SESSION["team"];?></h3>
                        <div class="todo-flex r-cols">
                            <input type="text" name="user_email" placeholder="search member by email address" class="spc-n mr2rem" required>
                            <input type="submit" name="invite_user" value="Invite User" id="form-control2" class="settings-btn">
                        </div>
                    </form>
                    <?php //echo "<h4>".$_GET["msg"]."</h4>";?>
                </div>
                -->
                <?php
                    if (get_admin($curs, $_SESSION["unq_user"], $_SESSION["team"])) {
                        include("./components/requests-table.php");
                    }
                ?>
                <div class="invites">
                    <h3>Requests sent by <?php echo $_SESSION["unq_user"];?></h3>
                    <form action="../controllers/auth_user.php" method="post">
                        <table class="data settings-tab">
                        <tr class="tbl-head">
                            <th>STATUS</th>
                            <th>PROJECT</th>
                            <th>RECEIVER</th>
                            <th>SENDER</th>
                            <th>DATE SUBMITTED</th>
                        </tr>
                        <?php
                        if (invite_count($curs, $_SESSION["unq_user"]) > 0) {
                            while ($row = mysqli_fetch_assoc($results2)) {
                                echo "<td>".$row["status"]."</td>";
                                echo "<td>".$row["team_name"]."</td>";
                                echo "<td>".$row["receiver"]."</td>";
                                echo "<td>".$row["sender"]."</td>";
                                echo "<td>".$row["date_created"]."</td>";
                            }
                        }
                        else {
                            echo "<h4>No requests have been made yet...</h4>";
                        }
                        ?>
                        </table>
                    </form>
                </div>
                <!-- WIP 
                <h2>Danger Zone</h2>-->
            </div>
        </div>
    </div>
</div>
<script src="../static/main.js"></script>
<script src="../static/modal.js"></script>
</body>
</html>