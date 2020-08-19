<?php
    class TaskEditor {
        function create_editor($row) {
            $id = $row["id"];
            $html = "<div class='r-cols todo-grid'>";
            $html .= "<div><h2>Editing: ".$row['title']."</h2>";
            $html .= "<lable>Edit Title</lable><br>";
            $html .= "<input class='spc-n' name='title' value='".$row['title']."' required><br><br>";
            $html .= "<lable>Edit Description</lable><br>";
            $html .= "<textarea name='description' value='".$row['description']."'>".$row['description']."</textarea></div>";
            $html .= "<div><lable>Change Deadline</lable><br>";
            $html .= "<input type='date' name='end-date' class='spc-n' value='".$row["deadline"]."' required><br><br>";
            $html .= "<label>Change Importance Level</label><br>";
            $html .= "<select name='importance' class='spc-n' required>";
            $html .= "<option value='".$row["importance"]."' selected>".$row["importance"]."</option>";
            $html .= "<option value='Low'>Low Importance</option>";
            $html .= "<option value='Medium'>Medium Importance</option>";
            $html .= "<option value='High'>High Importance</option></select><br><br>";
            $html .= "<label>Change Status</label><br>";
            $html .= "<select name='change-status' class='spc-n' required>";
            $html .= "<option value='".$row["status"]."' selected>".$row["status"]."</option>";
            $html .= "<option value='COMPLETED'>COMPLETED</option>";
            $html .= "<option value='IN PROGRESS'>IN PROGRESS</option>";
            $html .= "<option value='STUCK'>STUCK</option>";
            $html .= "<option value='DISTRACTED'>DISTRACTED</option></select>";
            $html .= "<input type='hidden' name='mod-task' value='$id'>";
            $html .= "</div></div>";
            return $html;
        }
    }
?>