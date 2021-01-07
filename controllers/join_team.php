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
    $sql = "insert into invites(team_name, sender, receiver) values(?, ?, ?) where not exists(select sender, receiver from invites where sender = ? and receiver = ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt->bind_param("sssss", $_POST["teamname"], $_SESSION["unq_user"], $admin, $_SESSION["unq_user"], $admin);
    if ($stmnt->execute()) 
        header("Location: ../index.php?msg=request sent to the admin of ".$_POST["teamname"]);
    else 
        header("Location: ../index.php?error=request did not send to admin of ".$_POST["teamname"]);
}
?>