
<div class="add-btn">
	<button>
	    <a href="./show-tasks.php">
		    <i class='fa fa-arrow-circle-o-left'></i>Go Back
	    </a>
	</button>
</div>
<form action="./task-details.php" method="post">
    <button onclick="hideSubRanger()" class="add-btn" type="submit" name="edit" value="<?php echo $_GET['task']; ?>" tabindex=1><i class="fa fa-edit"></i>Edit Task</button>
</form>