<?php
    $cmd = "corona -m";  
    $result = shell_exec($cmd);

    echo '<pre>';
    print_r($result);
    echo '</pre>';
?>