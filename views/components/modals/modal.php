<form action="../controllers/add_entry.php" method="post">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create or Join a Project</h2>
            <p>Create a new project with a unique name or search for an existing project to send an application to the project admin.</p>
            <div class="todo-flex r-cols">
                <label class="container">Create Project
                    <input type="radio" checked="checked" name="radio" value="create" class="pro-op">
                    <span class="checkmark"></span>
                </label>
                <label class="container" onclick="disableTextarea()">Join Project
                    <input type="radio" name="radio" value="join" class="pro-op">
                    <span class="checkmark"></span>
                </label>
            </div>
            <input type="text" class="spc-n" name="teamname" placeholder="Enter the project's name" required>
            <br>
            <br>
            <textarea name="description" id="txt-area" placeholder="Enter a description of the project."></textarea>
            <br>
            <br>
            <input type="submit" name="send-project" value="Submit">
        </div>
    </div>
</form>
<script>
function disableTextarea() {
    var x = document.getElementById("txt-area");
    if (x.value == "")
    x.style.display = "None";
    /*
    x.disabled = true;
    x.placeholder = "This input is disabled";
    */
}
</script>