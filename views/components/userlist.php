<?php
    include_once("../config/database.php");
    $db = new Database();
    $curs = $db -> getConnection();
    $sql = "select username from users where team = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    while ($row = mysqli_fetch_assoc($results)) {
        echo "<option value='".$row["username"]."'>".$row["username"]."</option>";
    }
?>

