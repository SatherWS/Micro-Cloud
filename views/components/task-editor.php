<?php
    class TaskEditor {
        function create_selector($row) {
            $selector = "<select name='change-assignee' class='spc-n' required>";
            $selector .= "<option value=''>None</option>";
            $sql = "select distinct assignee from todo_list where team_name = ?";
            $stmnt = mysqli_prepare($curs, $sql);
            $stmnt->bind_param("s", $team);
            $stmnt->execute();
            $result = $stmnt->get_result();
            while ($row = mysqli_fetch_assoc($result)) {
                $selector .= "<option value='".$row["assignee"]."'>".$row["assignee"]."</option>";
            }
            $selector .= "</select>";
            return $selector;
        }
        
        function create_editor($row) {
            $id = $row["id"];
            $html .= "<div class='r-cols todo-grid'>";
            $html .= "<div><label>Change Status</label><br>";
            $html .= "<select name='change-status' class='spc-n' required tabindex=3>";
            $html .= "<option value='".$row["status"]."' selected>".$row["status"]."</option>";
            $html .= "<option value='IN PROGRESS'>IN PROGRESS</option>";
            $html .= "<option value='COMPLETED'>COMPLETED</option>";
            $html .= "<option value='STUCK'>STUCK</option></select><br><br>";
            $html .= "<lable>Change Start Date</lable><br>";
            $html .= "<input type='date' name='start-date' class='spc-n' value='".$row["date_created"]."' required tabindex=4><br><br>";
            $html .= "<lable>Change Deadline</lable><br>";
            $html .= "<input type='date' name='end-date' class='spc-n' value='".$row["deadline"]."' required tabindex=5></div>";
            $html .= "<div><label>Change Importance Level</label><br>";
            $html .= "<select name='importance' class='spc-n' required tabindex=6>";
            $html .= "<option value='".$row["importance"]."' selected>".$row["importance"]."</option>";
            $html .= "<option value='Low'>Low Importance</option>";
            $html .= "<option value='Medium'>Medium Importance</option>";
            $html .= "<option value='High'>High Importance</option></select><br><br>";
            $html .= "<input type='hidden' name='mod-task' value='$id'>";
            $html .= "<label>Change Assignee</label><br>";
            $html .= "<select name='change-assignee' class='spc-n' required tabindex=7>";
            $html .= "<option value='".$row["assignee"]."'>".$row["assignee"]."</option>";
            // insert team mate options here then close select tag
            $html .= "</select><br><br>";
            $html .= "<label>Change Creator</label><br>";
            $html .= "<select name='change-creator' class='spc-n' required tabindex=8>";
            $html .= "<option value='".$row["creator"]."'>".$row["creator"]."</option>";
            // insert team mate options here then close select tag
            $html .= "</select>";
            return $html;
        }
        function additionals($row) {
            $html = "<br><div>";
            $html .= "<lable>Edit Title</lable><br>";
            $html .= "<input class='spc-n' name='title' value='".$row['title']."' required tabindex=1><br><br>";
            $html .= "<lable>Edit Description</lable><br>";
            $html .= "<textarea name='description' value='".$row['description']."' tabindex=2>".$row['description']."</textarea></div>";
            return $html;
        }
    }
?>