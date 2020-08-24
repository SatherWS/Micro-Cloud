<?php
/*
*   This script controls how users are created and authenticated
*   Author: Colin Sather
*/
session_start();
include_once("../config/database.php");
$db = new Database();
$curs = $db -> getConnection();

// login as existing user using encrypted pswd
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["auth_user"])) {
    $sql = "select username, pswd from users where email = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_POST["email"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    $row = mysqli_fetch_assoc($results);

    if (password_verify($_POST["pswd"], $row["pswd"])) {
        $_SESSION["user"] = $row["username"];
        $_SESSION["unq_user"] = $_POST["email"];
        $sql = "select team_name from members where email = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt->bind_param("s", $_SESSION["unq_user"]);
        $stmnt->execute();
        $results = $stmnt -> get_result();
        $projects = mysqli_fetch_assoc($results);
        $_SESSION["team"] = $projects["team_name"];
        header("Location: ../views/dashboard.php");
    }
    else {
        header("Location: ../authentication/login.php?error='Incorrect credentials'");
    }
}

/*
*   User and Team creation section (Signup form)
*/

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $sql = "insert into users(email, username, pswd) values(?,?,?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $hash = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
    $stmnt -> bind_param("sss", $_POST["email"], $_POST["usr"], $hash);
    if ($stmnt -> execute()) {
        // create session and launch application
        $_SESSION["unq_user"] = $_POST["email"];
        $_SESSION["user"] = $_POST["usr"];
        header("Location: ../views/dashboard.php");
    }
    else {
        header("Location: ../authentication/register.php?error="."<b>Error:</b> Email account is already in use.");
    }
}

/*
*   Invite user to team via settings.php [POSSIBLY MOVE THIS TO A NEW CONTROLLER]
*/
// send invite to user if user exists and if invite is already sent
function check_invites($curs, $user, $team) {
    $sql = "select receiver, team_name from invites where receiver = ? and team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("ss", $user, $team);
    $stmnt->execute();
    $result = $stmnt->get_result();
    if (mysqli_num_rows($result) == 0)
        return false;
    else
        return true;
}
function get_admin($curs, $user, $team) {
    $sql = "select admin from teams where admin = ? and team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt = $stmnt->bind_param("ss", $user, $team);
    $stmnt->execute();
    $result = $stmnt->get_result();
    $admin = mysqli_fetch_assoc($result);
    return $admin["admin"];
}

if (isset($_POST["invite_user"]) && !check_invites($curs, $_POST["user_email"], $_SESSION["team"])) {
    $sql = "insert into invites(receiver, sender, team_name) values (?,?,?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("sss", $_POST["user_email"], $_SESSION["unq_user"], $_SESSION["team"]);
    if ($stmnt->execute())
        header("Location: ../views/settings.php?msg=Success: invitation sent!");
    else
        header("Location: ../views/settings.php?msg=Error: user does not exist");
}
else if (isset($_POST["invite_user"]) && check_invites($curs, $_POST["user_email"], $_SESSION["team"])) {
    header("Location: ../views/settings.php?msg=Error: invitation already sent or user DNE.");
}

// Receiever of the invite can either accept or deny the request
if (isset($_POST["accept"])) {
    $sql = "update members set team_name = ? where email = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("ss", $_POST["accept"], $_SESSION["unq_user"]);
    $stmnt->execute();
    if (get_admin($curs, $_SESSION["unq_user"], $_POST["accept"]) == $_SESSION["unq_user"])
        $sql = "update invites set status = 'accepted' where sender = ?";
    else
        $sql = "update invites set status = 'accepted' where receiver = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("s", $_SESSION["unq_user"]);
    $stmnt->execute();
    $_SESSION["team"] = $_POST["accept"];
    header("Location: ../views/settings.php");
}
if (isset($_POST["deny"])) {
    $sql = "delete from invites where receiver = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("s", $_SESSION["unq_user"]);
    $stmnt->execute();
    header("Location: ../views/settings.php");
}
?>