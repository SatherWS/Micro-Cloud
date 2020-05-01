<?php
    include_once "./config/database.php";
    $db = new database();
    $curs = $db->getConnection();
    $total = 0;

    if ($_POST["range"]) {
        $sql = "select rating, date(date_created) as dr from journal where date_created between ? and ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_POST["start-date"], $_POST["end-date"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        $total = mysqli_num_rows($result);
    } else {
        $sql = "select rating, date(date_created) as dr from journal";
        $result = mysqli_query($curs, $sql);
        $total = mysqli_num_rows($result);
    }
    
    $dataPoints = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data = array("y" => $row["rating"], "label" => $row["dr"]);
        array_push($dataPoints, $data);
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                axisY: {
                    lineThickness: 0
                },

                data: [{
                    type: "splineArea",
                    showInLegend: true,
                    dataPoints: <?php 
                    echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
                    lineThickness: 5
                }]
            });
            chart.render();
        }
    </script>
    <title>Micro Cloud</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
    <body>
    <nav class="topnav index-nav" id="myTopnav">
        <ul>
            <li>
                <a href="./index.html" class="active">Micro Cloud</a>
                <i class="fa fa-mixcloud"></i>
            </li>
            <li>
                <a href="./stats.php">User Stats</a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Todo App</a>
                <div class="dropdown-content">
                    <a href="./todo-list.html">Add Task</a>
                    <a href="./views/show-tasks.php">Manage Tasks</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Journal App</a>
                <div class="dropdown-content">
                    <a href="./journal.html">Create Entry</a>
                    <a href="./views/logs.php">All Entries</a>
                </div>
            </li>
            <li style="float:right"><a href="#">Donate</a></li>
            <li style="float:right"><a href="#">GitHub</a></li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </nav>
    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h2 id='logs-title'>User Statistics</h2>
            </div>

            <div class="add-log">
                <form action="./stats.php" method="POST">
                    <input type="date" name="start-date" id="">
                    <input type="date" name="end-date" id="">
                    <input type="submit" value="Set Range" name="range">
                </form>
            </div>
        </div>
    </div>
    <?php
        $sql = "select avg(rating) from journal";
        $result = mysqli_query($curs, $sql);
        $avg = $result -> fetch_row();
    ?>
    <div class="avgs">
        <h3>Mood Average: <?php print_r($avg[0]) ?></h3>
        <h3>
            <?php 
                if ($_POST['range'])
                    echo "All ".$total. " ratings from ".$_POST['start-date']." to ".$_POST['end-date'];
                else
                    echo "All ".$total." Ratings";
            ?>
        </h3>
    </div>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>   