<!-- Delete a journal post with confirmation message -->
<form action="./journal-details.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" class="ml2rem">
    <button class="add-btn" type='submit' name='delete' value="<?php echo $id;?>">
    <i class='fa fa-close'></i>Delete Article
</button>
</form>
<!-- Save a journal post after editing -->
<button onclick='triggerForm()' name='save' class='add-btn mr2rem'>
    <i class='fa fa-save'></i><span class='opt-desc'>Save Changes</span>
</button>
