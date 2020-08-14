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
    $sql = "select username, team, pswd from users where email = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_POST["email"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    $row = mysqli_fetch_assoc($results);

    if (password_verify($_POST["pswd"], $row["pswd"])) {
        $_SESSION["user"] = $row["username"];
        $_SESSION["team"] = $row["team"];
        $_SESSION["unq_user"] = $_POST["email"];
        header("Location: ../views/dashboard.php");
    }
    else {
        header("Location: ../authentication/login.php?error='Incorrect credentials'");
    }
}

/*
*   User and Team creation section (Signup form)
*/
function search_team($curs, $team) {
    $sql = "select team_name from teams where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $team);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    if ($results -> num_rows > 0)
        return true;
    else
        return false;
}

// TODO: SEND INVITATION REQUEST INSTEAD OF UPDATING USERS TABLE RIGHT AWAY
// add user to db if search_team = false create new team 
// check which radio is selected and make sure the team exists or can be created
// below if statement is an attempt at a minimum password length

//if (strlen($_POST["pswd"]) >= 8 && isset($_POST["add_user"])) {
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    if ($_POST["radio"] == "join" && search_team($curs, $_POST["team"])) {
        $sql = "insert into users(email, team, username, pswd) values(?,?,?,?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $hash = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
        $stmnt -> bind_param("ssss", $_POST["email"], $_POST["team"], $_POST["usr"], $hash);
        $stmnt -> execute();

        // create session and launch application
        $_SESSION["unq_user"] = $_POST["email"];
        $_SESSION["user"] = $_POST["usr"];
        $_SESSION["team"] = $_POST["team"];
        header("Location: ../views/dashboard.php");
    }

    else if ($_POST["radio"] == "create" && !search_team($curs, $_POST["team"])){
        // add team to database, then add user account
        $sql = "insert into teams(team_name) values (?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST["team"]);
        $stmnt -> execute();

        // create user account
        $sql = "insert into users(email, team, username, pswd) values(?,?,?,?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $hash = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
        $stmnt -> bind_param("ssss", $_POST["email"], $_POST["team"], $_POST["usr"], $hash);
        $stmnt -> execute();

        // create session and launch application
        $_SESSION["unq_user"] = $_POST["email"];
        $_SESSION["user"] = $_POST["usr"];
        $_SESSION["team"] = $_POST["team"];
        header("Location: ../views/dashboard.php");
    }
    // error messages: team dne or user non unique
    else if ($_POST["radio"] == "join" && !search_team($curs, $_POST["team"])) {
        $msg = "Error: team does not exist";
        header("Location: ../authentication/signup.php?error='$msg'");
    }
    else if ($_POST["radio"] == "create" && search_team($curs, $_POST["team"])){
        header("Location: ../authentication/signup.php?error="."Error: email accounts must be unique");
    }
}
/*
else if (strlen($_POST["pswd"]) < 8) {
    header("Location: ../authentication/signup.php?error=Error: password isn't long enough");
}
*/

// send invite to user if user exists and if invite is already sent
function check_invites($curs, $user, $team) {
    $sql = "select receiver, team_name from invites where receiver = ? and team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("ss", $user, $team);
    if ($stmnt->execute)
        return true;
    else
        return false;
}

if (isset($_POST["invite_user"]) && check_invites($curs, $_POST["user_email"], $_SESSION["team"])) {
    $sql = "insert into invites(receiver, sender, team_name) values (?,?,?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("sss", $_POST["user_email"], $_SESSION["unq_user"], $_SESSION["team"]);
    if ($stmnt->execute())
        header("Location: ../views/settings.php?msg=Success: invitation sent!");
    else
        header("Location: ../views/settings.php?msg=Error: user does not exist");
}
else if (isset($_POST["invite_user"]) && !check_invites($curs, $_POST["user_email"], $_SESSION["team"])) {
    header("Location: ../views/settings.php?msg=Error: invitation already sent or user DNE.");
}

// Receiever of invite either accepts or denies
if (isset($_POST["accept"])) {
    $sql = "update users set team = ? where email = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("ss", $_POST["accept"], $_SESSION["unq_user"]);
    $stmnt->execute();
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