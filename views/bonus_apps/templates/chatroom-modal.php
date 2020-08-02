<form method="post" action="../controllers/add_entry.php">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create New Chat Room</h2>
            <input type="text" name="room" placeholder="Enter a Name for the New Category" id="form-control" class="spc-n">
            <br>
            <h3>Your Username is <?php echo $_SERVER['REMOTE_ADDR']; ?></h3>
            <input type="hidden" name="username" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
            <br>
            <input type="submit" name="add-chatroom" class="other-close attach">
        </div>
    </div>
</form>