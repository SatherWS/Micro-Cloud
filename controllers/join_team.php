<?php
session_start();
include_once("../config/database.php");
$db = new Database();
$curs = $db->getConnection();

function getAdmin($curs, $project) {
    $sql = "select admin from teams where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("s", $project);
    $stmnt->execute();
    $result = $stmnt->get_result();
    $set = mysqli_fetch_assoc($result);
    return $set["admin"];
}

if (!isset($_SESSION["unq_user"]))
    header("Location: ../authentication/login.php");

else if (isset($_SESSION["unq_user"])) {
    $admin = getAdmin($curs, $_POST["teamname"]);
    $sql = "insert into invites(team_name, sender, receiver) values(?, ?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("sss", $_POST["teamname"], $_SESSION["unq_user"], $admin);
    $stmnt->execute();
}
?>