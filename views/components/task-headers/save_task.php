<!-- Save a journal post after editing -->
<form action="./task-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this task? All sub tasks of the main tasks will be deleted.');">
    <button class="add-btn" type='submit' name='delete' value="<?php echo $_GET['task']; ?>"><i class='fa fa-close'></i>Delete Task</button>
</form>
<button onclick='triggerForm2()' class='add-btn'>
<i class='fa fa-save'></i><span class='opt-desc'>Save Changes</span></button>