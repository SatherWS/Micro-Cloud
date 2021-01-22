<form action="../controllers/add_entry.php" method="post">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create or join a project</h2>
            <p>Create a new project with a unique name or search for an existing project to send an application to the project admin.</p>
            <div class="todo-flex r-cols">
                <label class="container" onclick="validateTextarea()">Create Project
                    <input type="radio" checked="checked" name="radio" value="create" class="pro-op">
                    <span class="checkmark"></span>
                </label>
                <label class="container" onclick="validateTextarea()">Join Project
                    <input type="radio" name="radio" value="join" class="pro-op">
                    <span class="checkmark"></span>
                </label>
            </div>
	    <br>
            <input type="text" class="spc-n" name="teamname" placeholder="Enter the project's name" required>
            <div id="txt-area">
                <br><br>
                <textarea class="modal-txt" name="description" placeholder="Enter a description of the project."></textarea>
            </div>
            <br>
            <input type="submit" name="send-project" value="Submit" class="add-btn-2">
        </div>
    </div>
</form>
