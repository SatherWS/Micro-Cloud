<?php
    class TaskEditor {
        function create_selector($curs, $team) {
            $selector = "<select name='change-assignee' class='spc-n' required>";
            $selector .= "<option value=''>None</option>";
            $sql = "select assignee from todo_list where team_name = ?";
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
            $html = "<h2>Editing Main Task: ".$row['title']."</h2>";
            $html .= "<div class='r-cols todo-grid'>";
            $html .= "<div><label>Change Status</label><br>";
            $html .= "<select name='change-status' class='spc-n' required>";
            $html .= "<option value='".$row["status"]."' selected>".$row["status"]."</option>";
            $html .= "<option value='IN PROGRESS'>IN PROGRESS</option>";
            $html .= "<option value='COMPLETED'>COMPLETED</option>";
            $html .= "<option value='STUCK'>STUCK</option></select><br><br>";
            $html .= "<lable>Change Start Date</lable><br>";
            $html .= "<input type='date' name='start-date' class='spc-n' value='".$row["date_created"]."' required><br><br>";
            $html .= "<lable>Change Deadline</lable><br>";
            $html .= "<input type='date' name='end-date' class='spc-n' value='".$row["deadline"]."' required></div>";
            $html .= "<div><label>Change Importance Level</label><br>";
            $html .= "<select name='importance' class='spc-n' required>";
            $html .= "<option value='".$row["importance"]."' selected>".$row["importance"]."</option>";
            $html .= "<option value='Low'>Low Importance</option>";
            $html .= "<option value='Medium'>Medium Importance</option>";
            $html .= "<option value='High'>High Importance</option></select><br><br>";
            $html .= "<input type='hidden' name='mod-task' value='$id'>";
            return $html;
        }
        function additionals($row) {
            $html = "<br><div>";
            $html .= "<lable>Edit Title</lable><br>";
            $html .= "<input class='spc-n' name='title' value='".$row['title']."' required><br><br>";
            $html .= "<lable>Edit Description</lable><br>";
            $html .= "<textarea name='description' value='".$row['description']."'>".$row['description']."</textarea></div>";
            return $html;
        }
    }
?>