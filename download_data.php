<?php
    $command = "python ./get-data.py 4 asdf 2";
    $output = exec($command);
    echo $output;
?>