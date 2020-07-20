<?php
/*
*   This script controls how users are created and authenticated
*   7/18/2020, Consciencec/Grouper (grooper.tech) grotech?
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
        header("Location: ../views/index.php");
    }
    else {
        header("Location: ../views/login.html");
        echo "Incorrect creds";
    }
}

/*
*   User and Team creation section
*/

function search_team($curs, $team) {
    $sql = "select team_name from teams where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $team);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    //$row = mysqli_fetch_assoc($results);
    if ($results -> num_rows > 0)
        return true;
    else
        return false;
}

// add user to db 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $sql = "insert into users(email, username, pswd) values(?,?,?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $hash = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
    $stmnt -> bind_param("sss", $_POST["email"], $_POST["usr"], $hash);
    $stmnt -> execute();
    $results = mysqli_affected_rows($curs);
    
    if (search_team($curs, $_POST["team"])) {
        $sql = "update users set team = ? where email = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST["team"], $_POST["email"]);
        $stmnt -> execute();
    }
    else {
        // add team to database
        $sql = "insert into teams(team_name) values (?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST["team"]);
        $stmnt -> execute();

        // add team to user
        $sql = "update users set team = ? where email = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST["team"], $_POST["email"]);
        $stmnt -> execute();
    }

    // if user is added correctly proceed to dashboard
    if ($results) {
        $_SESSION["unq_user"] = $_POST["email"];
        $_SESSION["user"] = $_POST["usr"];
        $_SESSION["team"] = $_POST["team"];
        header("Location: ../views/index.php");
    }
}
?>