<!DOCTYPE HTML>
<html>
<head>
    
    
    <title>Micro Cloud</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
    <body>
    <?php
        include("./components/header.php");
        include_once "../config/database.php";
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
            print_r($result);

            $total = mysqli_num_rows($result);
        } 
        else {
            $sql = "select rating, date(date_created) as dr from journal";
            $result = mysqli_query($curs, $sql);
            $total = mysqli_num_rows($result);
        }
        
        $dataPoints = array();
        while($row = mysqli_fetch_assoc($result)) {
            $data = array("y" => $row["rating"], "label" => $row["dr"]);
            array_push($dataPoints, $data);
        }

        $taskPoints = array();
        $sql1 = "select status, count(*) from todolist group by status";
        $rt = mysqli_query($curs, $sql1);
        while($row = mysqli_fetch_assoc($rt)) {
            $data = array("y" => $row["count(*)"], "label" => $row["status"]);
            array_push($taskPoints, $data);
        }
        // below sum was causing errors
        //$total_tasks =  $taskPoints[0]+$taskPoints[1]+$taskPoints[2]+$taskPoints[3];

    ?>
    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h3 id='logs-title'>Mood Statistics</h3>
            </div>

            <div class="add-log">
                <form action="./stats.php" method="POST">
                    <input type="date" name="start-date" id="">
                    <input type="date" name="end-date" id="">
                    <input type="submit" value="Set Range" name="range" class="date-btn">
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
    <?php

    ?>
    <div class="pie-box">
        <div class="pie-data">
            <h2>TODO List Statistics</h2>
            <table>
                <tr>
                    <td>Tasks Completed</td>
                    <td style="text-align: right"><?php echo $taskPoints[0]["y"] ?></td>
                </tr>
                <tr>
                    <td>Tasks Stuck</td>
                    <td style="text-align: right"><?php echo $taskPoints[1]["y"] ?></td>
                </tr>
                <tr>
                    <td>Tasks Not Started</td>
                    <td style="text-align: right"><?php echo $taskPoints[2]["y"] ?></td>
                </tr>
                <tr>
                    <td>Tasks In Progress</td>
                    <td style="text-align: right"><?php echo $taskPoints[3]["y"] ?></td>
                </tr>
            </table>
            <h3>Total Tasks: <?php echo $taskPoints[0]["y"]+$taskPoints[1]["y"]+$taskPoints[2]["y"]+$taskPoints[3]["y"] ?></h3>
        </div>
        <div id="pieContainer" style="height: 370px; width: 100%;"></div>
    </div>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            
	    // line graph code
	    var chart = new CanvasJS.Chart("chartContainer", {
                axisY: {
                    lineThickness: 0
                },

                data: [{
                    type: "splineArea",
                    dataPoints: <?php 
                    echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
                    lineThickness: 5
                }]
            });
            chart.render();

            // pie chart code
            var chart2 = new CanvasJS.Chart("pieContainer", {
                animationEnabled: true,
      
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0\"\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($taskPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart2.render();
        }
    </script>
    <script src="../static/main.js"></script>
    </body>
</html>   
