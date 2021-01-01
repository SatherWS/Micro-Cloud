<!-- Go back to the list page -->
<div class="ml2rem">
	<button class="add-btn">
	    <a href="./logs.php">
		 <i class='fa fa-arrow-circle-o-left'></i>Go Back
	    </a>
	</button>
</div>
<!-- Edit a journal post -->
<form action="./journal-details.php" method="post" class="mr2rem">
    <button class="add-btn" type="submit" name="edit" value="<?php echo $_GET['journal'];?>"><i class="fa fa-edit"></i>Edit Post</button>
</form>
