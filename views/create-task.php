<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List App</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body class="todo-bg">
    <?php include("./components/header.php")?>
    <form action="../controllers/add_entry.php" method="post" class="app">
        <div class="form-container">
            <div></div>
            <div class="todo-panel">
                <h1>TODO List</h1>
                <div class="form-body">
                    <label>Task Description</label><br>
                    <input type="text" name="subs" 
                    placeholder="Type Task Description" class="todo-item spc-n" required>
                    <br><br>
                    <label>Date Due</label><br>
                    <input type="date" name="end-date" class="todo-item spc-n" required><br><br>
                    <label>Time Due</label><br>
                    <input type="time" name="time-due" class="todo-item spc-n" required>
                    <br><br>
                    <label>Additional Options</label><br>
                    <select name="importance" class="spc-n" required>
                        <option value="none" selected disabled hidden> 
                            Rank Importance
                        </option>
                        <option value="Low">Low Importance</option>
                        <option value="Medium">Medium Importance</option>
                        <option value="High">High Importance</option>
                    </select>

                    <select name="repeat" class="spc-n rep-item" required>
                        <option value="none" selected disabled hidden> 
                            Repeat? 
                        </option>
                        <option value="daily">do not</option>
                        <option value="daily">daily</option>
                        <option value="weekly">weekly</option>
                        <option value="monthly">monthly</option>
                        <option value="yearly">yearly</option>
                    </select>
                </div>
                <br>
                <input type="submit" name="add-task" id="form-control2" class="spc-n" value="Add Task">
            </div>
            <div></div>
        </div>
    </form>
    <script src="../static/main.js"></script>
    <!-- jQuery then Javascript libraries
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     -->
</body>
</html>
