<?php
/* may be optional to login */

session_start();
if (!isset($_SESSION["unq_user"])){
    header("Location: ../authentication/login.php");
}
include ('../config/database.php');
$database = new Database();
$curs = $database->getConnection();

if ($curs->connect_error) {
    die("Connection failed: " . $curs->connect_error);
}
// add chatroom to database
if ($_POST['add-chatroom']) {
    $sql = "insert into chatroom(subject, creator) values(?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("ss", $_POST["room"], $_POST["username"]);
    $stmnt -> execute();
    header("Location: ../views/bonus_apps/join-chat.php");
}
$curs -> close();
?>