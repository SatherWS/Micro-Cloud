<!-- Delete a journal post with confirmation message -->
<form action="./journal-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" class="mr2rem">
    <button class="add-btn" type='submit' name='delete' value="<?php echo $_GET['task']; ?>"><i class='fa fa-close'></i>Delete Post</button>
</form>