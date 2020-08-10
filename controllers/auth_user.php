<?php
/*
*   This script controls how users are created and authenticated
*   7/24/2020, Teamswoop
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    // we need to check which radio is selected and make sure the team exists or can be created
    /*
    $sql = "insert into users(email, team, username, pswd) values(?,?,?,?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $hash = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
    $stmnt -> bind_param("ssss", $_POST["email"], $_POST["team"], $_POST["usr"], $hash);
    $stmnt -> execute();
    $results = mysqli_affected_rows($curs);
    */
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
    else if ($_POST["radio"] == "join" && !search_team($curs, $_POST["team"])) {
        // team dne return error message
        $msg = "Error: team does not exist";
        header("Location: ../authentication/signup.php?error='$msg'");
    }
    else if ($_POST["radio"] == "create" && !search_team($curs, $_POST["team"])){
        // add team to database, then add user account
        $sql = "insert into teams(team_name) values (?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST["team"]);
        $stmnt -> execute();

        // update team name to user account (TODO: CHANGE TO ADD THEN CHECK FOR UNIQUENESS)
        $sql = "update users set team = ? where email = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST["team"], $_POST["email"]);
        $stmnt -> execute();

        // create session and launch application
        $_SESSION["unq_user"] = $_POST["email"];
        $_SESSION["user"] = $_POST["usr"];
        $_SESSION["team"] = $_POST["team"];
        header("Location: ../views/dashboard.php");
    }
    else if ($_POST["radio"] == "create" && search_team($curs, $_POST["team"])){
        header("Location: ../authentication/signup.php?error="."Error: email accounts must be unique");
    }
    else {
        // PLACEHOLDER
        //header("Location: ../authentication/signup.php?error="."Error: email accounts must be unique");
    }
}
?>