<?php
    /*
    * Below functions fetchs tasks for a given team.
    *     
    */
    class Issues {
        function get_tasks($curs, $team) {
            $sql = "select id, title, status, date_format(date_created, '%Y'), month(date_created), day(date_created), date_format(deadline, '%Y'), month(deadline), day(deadline) from todo_list where team_name = ? order by date_created";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt -> bind_param("s", $team);
            $stmnt -> execute();
            $results = $stmnt -> get_result();
            return $results;
        }
        
        // pie chart inner array to data table
        function pie_data($curs, $team) {
            $sql = "select status, count(*) from todo_list where team_name = ? group by status";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt->bind_param("s", $team);
            $stmnt->execute();
            $results = $stmnt->get_result();
            $chart_data = "[['Status', 'Task Count'],";
        
            while($row = mysqli_fetch_assoc($results)) {
                $chart_data .= "['".$row['status']."', ".$row["count(*)"]."],";
            }
            return substr($chart_data, 0, -1)."]";
        }
        
        // use for 2nd table in analytics view and pie chart
        function team_data($curs, $team) {
            // data for pie chart section
            $sql = "select status, count(*) from todo_list where team_name = ? group by status";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt->bind_param("s", $team);
            $stmnt->execute();
            $results = $stmnt->get_result();
            return $results;
        }

        function user_summaries($curs, $team) {
            $sql = "select status, assignee, count(*) from todo_list where team_name = ? group by assignee, status";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt->bind_param("s", $team);
            $stmnt->execute();
            $results = $stmnt->get_result();
            return $results;
        }

        // use for line graph to show tasks in progress, completed, etc. (OPTIONAL)
        function line_data($curs, $team) {
            return 0;
        }
    }
?>
