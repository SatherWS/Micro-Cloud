<form action="../controllers/add_entry.php" method="post">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create URL Link</h2>
            <p>Link to external resources.</p>
            <div class="todo-flex r-cols">
            <input type="text" class="spc-n" name="teamname" placeholder="Enter the text to display..." required>
            <br><br>
            <input type="text" class="spc-n" name="teamname" placeholder="Enter the URL to a website..." required>
            <br><br>
            <input type="submit" name="send-project" value="Submit">
        </div>
    </div>
</form>