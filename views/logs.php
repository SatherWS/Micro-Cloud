<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="topnav" id="myTopnav">
        <ul>
            <li>
                <a href="../index.html" class="active">Micro Cloud</a>
                <i class="fa fa-mixcloud"></i>
            </li>
            <li>
                <a href="../stats.php">User Stats</a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Todo App</a>
                <div class="dropdown-content">
                    <a href="../todo-list.html">Add Task</a>
                    <a href="./show-tasks.php">Manage Tasks</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Journal App</a>
                <div class="dropdown-content">
                    <a href="../journal.html">Create Entry</a>
                    <a href="./logs.php">All Entries</a>
                </div>
            </li>
            <li style="float:right"><a href="#">Sign Up</a></li>
            <li style="float:right"><a href="#">Github</a></li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </nav>
    <?php 
        //include_once '../edit_entry.php';
        include_once '../config/database.php';
        $database = new Database();
        $curs = $database->getConnection();
        $sql = "select id, subject, substring(message,1, 45) as preview, rating, date_created from journal order by date_created desc";
        $result = mysqli_query($curs, $sql);
    ?>

    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h2 id='logs-title'>All Journals</h2>
            </div>
            <div class="add-log">
                <a href="../journal.html"><i class="fa fa-plus-circle"></i>
                <span class="opt-desc">Add Entry</span></a>
            </div>
        </div>
    </div>
    <div class="log-container">
        <form id="notes" action="./journal-details.php" method="post">
            <table class="data">
                <tr class="tbl-head">
                    <th>ID</th>
                    <th>SUBJECT</th>
                    <th>PREVIEW</th>
                    <th>MOOD RATING</th>
                    <th>DATE & TIME CREATED</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            echo "<tr onclick='myFunction($id)' name='btn-submit' value='".$row["id"]."'> <td>". $row["id"]. "</td>";
                            echo "<td>". $row["subject"]. "</td>";
                            echo "<td>".strip_tags($row["preview"], '<br><b><i>'). "...</td>";
                            //echo "<td>". $row["preview"]. "...</td>";
                            echo "<td>". $row["rating"]. "</td>";
                            echo "<td>". $row["date_created"] ."</td></tr>";
                            /*
                            $icon_str = "<td><button id='options' type='submit' name='btn-submit' value='".$row["id"];
                            $icon_str .= "'><i class='fa fa-eye'></i></button>";
                            $icon_str .= "<button id='options' type='submit' name='edit' value='".$row["id"];
                            $icon_str .= "'><i class='fa fa-edit'></i></button>";
                            $icon_str .= "<button id='options' type='submit' name='delete' value='".$row["id"];
                            $icon_str .= "'><i class='fa fa-close'></i></button</td>";
                            */
                        }
                    } 
                    else {
                        echo "<p>0 results</p>";
                    }
                    $curs -> close();
                ?>
            </table>
        </form>
    </div>
    <script>
    function myFunction(id) {
        window.location='./journal-details.php?journal='+id;
    }
    </script>
    <script src="../main.js"></script>
</body>
</html>