<?php
    session_start();
    $_SESSION['team'] = $_GET['switched'];
    header("Location: ../views/dashboard.php");
?>