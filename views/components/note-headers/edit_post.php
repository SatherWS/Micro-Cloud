<!-- Edit a journal post -->
<form action="./journal-details.php" method="post" class="mr2rem">
    <button class="add-btn" type="submit" name="edit" value="<?php echo $_GET['journal'];?>"><i class="fa fa-edit"></i>Edit Post</button>
</form>
<!-- Delete a journal post with confirmation message -->
<form action="./journal-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" class="mr2rem">
    <button class="add-btn" type='submit' name='delete' value="<?php echo $_GET['journal'];?>"><i class='fa fa-close'></i>Delete</button>
</form>