<?php 
    session_start();
    if (!isset($_SESSION["unq_user"])){
        header("Location: ../authentication/login.php");
    }
    include_once("../config/database.php");
    include("./components/scrollcontent.php");

    $db = new Database();
    $curs = $db -> getConnection();
    $sql = "select email from users where team = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List App</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
<?php include("./components/header.php");?>
<div class="todo-bg">
<!-- TODO: seperate the form from the task view -->
<form action="../controllers/add_entry.php" method="post" class="app">
    <div class="form-container">
        <div class="todo-panel">
            <div class="todo-flex r-cols">
                <!-- Contains task submit form -->
                <section> 
                <div class="form-body">
                    <label>Task Description</label><br>
                    <input type="text" name="title" placeholder="Type Task Description" class="todo-item spc-n" required>
                    <br><br>
                    <select name="assignee" class="spc-n rep-item" required>
                        <option value="none" selected disabled hidden> 
                            Select Team Member
                        </option>
                        <option value="None">None</option>
                        <option value="<?php echo $_SESSION["unq_user"]?>">Self</option>
                        <?php
                            while ($row = mysqli_fetch_assoc($results)) {
                                echo "<option value='".$row["email"]."'>".$row["email"]."</option>";
                            }
                        ?>
                    </select>
                    <br><br>
                    <textarea name="descript" cols="30" rows="10" placeholder="Additional description (optional)" class="todo-txt-area"></textarea>
                    <br><br>
                    <label>Date Due</label><br>
                    <input type="date" name="end-date" class="todo-item spc-n" required>
                    <br><br>
                    <!--
                    <label>Time Due</label><br>
                    <input type="time" name="time-due" class="todo-item spc-n" required>
                    <br><br>
                    -->
                    <label>Importance Rating</label><br>
                    <select name="importance" class="spc-n rep-item" required>
                        <option value="none" selected disabled hidden> 
                            Rank Importance
                        </option>
                        <option value="Low">Low Importance</option>
                        <option value="Medium">Medium Importance</option>
                        <option value="High">High Importance</option>
                    </select>
                </div>
                <br>
                <input type="submit" name="add-task" id="form-control2" class="spc-n" value="Add Task">
                </section>
                <!-- Preview submitted tasks -->
                <section> 
                    <div class="scroll-pane">
                        <?php 
                            $content = new Scroll();
                            $content -> scroll_content($curs);
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</form>
</div>
<script src="../static/main.js"></script>
<script>
    function getTask(id) {
        window.location = "./task-details.php?task="+id;
    }
</script>
</body>
</html>
