<?php
    /*
    Below function fetchs tasks for a given team    
    */
    class Issues {
        function get_tasks($curs, $team) {
            $sql = "select id, title, status, date_format(date_created, '%Y'), month(date_created), day(date_created), date_format(deadline, '%Y'), month(deadline), day(deadline) from todo_list where team_name = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $team);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            return $results;
        }
    }
?>