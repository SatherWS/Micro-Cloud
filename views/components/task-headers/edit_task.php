<form action="./task-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this task? All sub tasks of the main tasks will be deleted.');">
    <button class="add-btn" type='submit' name='delete' value="<?php echo $_GET['task']; ?>"><i class='fa fa-close'></i>Delete Task</button>
</form>
<form action="./task-details.php" method="post">
    <button onclick="hideSubRanger()" class="add-btn" type="submit" name="edit" value="<?php echo $_GET['task']; ?>"><i class="fa fa-edit"></i>Edit Task</button>
</form>