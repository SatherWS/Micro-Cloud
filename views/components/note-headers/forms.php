
<?php
    class FormGenerator {
        
        public function showDefault($id) {
            $form = "<form action='./journal-details.php' method='post'>";
            //$script = "confirm('Are you sure you want to delete this post?')";
            $form .= "<button type='submit' name='edit' value='$id'>";
            $form .= "<i class='fa fa-edit'></i><span class='opt-desc'>Edit Note</span></button>";
            $form .= "<button type='submit' name='delete' value='$id'>";
            //$form .= "<button onsubmit='".$script."' type='submit' name='delete' value='".$id."'>";
            $form .= "<i class='fa fa-close'></i><span class='opt-desc'>Delete Note</span></button></form>";
            echo $form;
        }
        public function showEditor($id) {
            $form = "<button onclick='triggerForm()' name='edit' value='$id'>";
            $form .= "<i class='fa fa-save'></i><span class='opt-desc'>Save Changes</span></button>";
            echo $form;
        }
    }
?>