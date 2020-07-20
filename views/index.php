<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ./login.html");
    }
?>
<!DOCTYPE html>
<!-- Possibly rename to Conscience Console -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consciencec | Dashboard</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="dash-bg">
    <?php include("./components/header.php");?>
    <main>
        <div class="home-intro">
            <h1 class="intro-header">Welcome back <?php echo $_SESSION["user"];?></h1>
            <h3>Team: <?php echo $_SESSION["team"];?></h3>
        </div>
        <div class="grid-container">
            <div>
                <a class="dash-item" href="./logs.php">
                    <i class="fa  fa-pencil spc-1"></i>
                    <br>
                    <span class="sup-text">View Notes</span>
                </a>
            </div>
            <div>
                <a class="dash-item" href="./show-tasks.php">
                    <i class="fa fa-list-ol spc-1"></i>
                    <br>
                   <span class="sup-text">View Tasks</span> 
                </a>
            </div>
            <div>
                <a class="dash-item" href="./analytics.php">
                    <i class="fa fa-line-chart spc-1"></i>
                    <br>
                   <span class="sup-text">Analytics</span> 
                </a>
            </div>  
        </div>
        <div class="todo-flex">
            <h1 class="intro-header">My Team's Activity</h1>
            <form method="POST">
                <select class="main-selector" name="teams-a" id="myselect" onchange="this.form.submit()">
                    <option value="show_all" selected>All Teams</option>
                    <option value="posts">placeholder 1</option>
                    <option value="tasks">placeholder 2</option>
                </select>
                <select class="main-selector" name="options-a" id="myselect" onchange="this.form.submit()">
                    <option value="show_all" selected>Show All</option>
                    <option value="posts">Posts</option>
                    <option value="tasks">Tasks</option>
                </select>
            </form>
        </div>

        <div class="activity">
            <div class="todo-flex">
                <h2>Task: Some Title</h2>
                <h3>Deadline: 9:00pm 4/20/2020</h3>
            </div>
            <div class="todo-flex">
                <p class="activity-item">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolor esse delectus assumenda corrupti cupiditate odit tempore, animi inventore repellendus?</p>
                <small>Posted on: 2/21/12</small>
            </div>
        </div>
        <div class="activity">
            <div class="todo-flex">
                <h2>Post: Some Title</h2>
                <h3>Category: Personal</h3>
            </div>
            <div class="todo-flex">
                <p class="activity-item">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolor esse delectus assumenda corrupti cupiditate odit tempore, animi inventore repellendus?</p>
                <small>Posted on: 2/21/12</small>
            </div>
        </div>
    </main>
    <script src="./static/main.js"></script>
</body>
</html>
