<form action="../controllers/add_subtask.php" method="post">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create Subtask</h2>
            <input type="text" class="spc-n" name="st-title" placeholder="Enter subtask title" required>
            <br><br>
            <select name="assignee" class="spc-n rep-item">
                <option value="none" selected disabled hidden> 
                    Select Team Member
                </option>
                <option value="">None</option>
                <?php
                    /*
                    while ($row = mysqli_fetch_assoc($results)) {
                        if ($row["email"] == $_SESSION["unq_user"])
                            echo "<option value='".$row["email"]."'>Self</option>";
                        else
                            echo "<option value='".$row["email"]."'>".$row["email"]."</option>";
                    }
                    */
                ?>
            </select>
            <br><br>
            <textarea name="st-desc" id="subt-txt-area" cols="30" rows="10" placeholder="Subtask Description..."></textarea>
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
            <input type='hidden' name='mod-subtask' value='<?php echo $_GET['task'];?>'>
            <input type="submit" name="add-subtask" value="Submit">
        </div>
    </div>
</form>
