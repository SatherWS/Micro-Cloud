<form action="../controllers/add_entry.php" method="post">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create Subtask</h2>
            <input type="text" class="spc-n" name="teamname" placeholder="Enter subtask title" required>
            <br>
            <textarea name="description" id="" cols="30" rows="10">Subtask Description...</textarea>
            <br>
            <label>Set Status</label><br>
            <select name='Set-status' class='spc-n' required>
                <option selected disabled>Current Status</option>
                <option value='IN PROGRESS'>IN PROGRESS</option>
                <option value='COMPLETED'>COMPLETED</option>
                <option value='STUCK'>STUCK</option>
            </select>
            <br><br>
            <lable>Set Deadline</lable>
            <br>
            <input type='date' name='end-date' class='spc-n' required>
            <label>Set Importance Level</label><br>
            <select name='importance' class='spc-n' required>
                <option selected disabled>Importance Level</option>
                <option value='Low'>Low Importance</option>
                <option value='Medium'>Medium Importance</option>
                <option value='High'>High Importance</option>
            </select>
            <br><br>
            <input type='hidden' name='mod-task' value='$id'>
            <input type="submit" name="add-subtask" value="Submit">
        </div>
    </div>
</form>
