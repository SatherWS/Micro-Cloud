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
        
        // use for 2nd table in analytics view and pie chart
        function team_data($curs, $team) {
            // data for pie chart section
            $sql = "select status, count(*) from todo_list where team_name = ? group by status";
            $stmnt = mysqli_prepare($curs, $sql2);
            $stmnt->bind_param("s", $team);
            $stmnt->execute();
            $result = $stmnt->get_result();
            return $results;
        }

        // use for line graph to show tasks in progress, completed, etc. (OPTIONAL)
        function line_data($curs, $team) {
            return 0;
        }
    }

    /* delete later
    class Summary {
        function summary_table($curs, $team) {
            // data for pie chart section
            $sql2 = "select status, count(*) from todo_list where team_name = ? group by status";
            $stmnt2 = mysqli_prepare($curs, $sql2);
            $stmnt2->bind_param("s", $_SESSION["team"]);
            $stmnt2->execute();
            $result2 = $stmnt2->get_result();
        }
    }
    */
?>