
<?php
    class FormGenerator {
        
        public function showDefault($id) {
            $msg = "'Do you really want to submit the form?'";
            $form = "<form action='./journal-details.php' method='post' onsubmit='return confirm($msg);'>";
            $form .= "<button type='submit' name='delete' value='$id' class='add-btn'>";
            $form .= "<i class='fa fa-close'></i><span class='opt-desc'>Delete Note</span></button></form>";
            $form .= "<form action='./journal-details.php' method='post'>";
            $form .= "<button class='add-btn' type='submit' name='edit' value='$id'>";
            $form .= "<i class='fa fa-edit'></i><span class='opt-desc'>Edit Note</span></button></form>";
            echo $form;
        }
        public function showEditor($id) {
            $form = "<button onclick='triggerForm()' name='edit' value='$id' class='add-btn'>";
            $form .= "<i class='fa fa-save'></i><span class='opt-desc'>Save Changes</span></button>";
            echo $form;
        }
    }
?>