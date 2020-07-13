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
        if ($row["rating"] != null) {
            $data = array("y" => $row["rating"], "label" => $row["dr"]);
            array_push($dataPoints, $data);
        }
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
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micro Cloud</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        ['2014Spring', 'Spring 2014', 'spring',
         new Date(2014, 2, 22), new Date(2014, 5, 20), null, 100, null],
        ['2014Summer', 'Summer 2014', 'summer',
         new Date(2014, 5, 21), new Date(2014, 8, 20), null, 100, null],
        ['2014Autumn', 'Autumn 2014', 'autumn',
         new Date(2014, 8, 21), new Date(2014, 11, 20), null, 100, null],
        ['2014Winter', 'Winter 2014', 'winter',
         new Date(2014, 11, 21), new Date(2015, 2, 21), null, 100, null],
        ['2015Spring', 'Spring 2015', 'spring',
         new Date(2015, 2, 22), new Date(2015, 5, 20), null, 50, null],
        ['2015Summer', 'Summer 2015', 'summer',
         new Date(2015, 5, 21), new Date(2015, 8, 20), null, 0, null],
        ['2015Autumn', 'Autumn 2015', 'autumn',
         new Date(2015, 8, 21), new Date(2015, 11, 20), null, 0, null],
        ['2015Winter', 'Winter 2015', 'winter',
         new Date(2015, 11, 21), new Date(2016, 2, 21), null, 0, null],
        ['Football', 'Football Season', 'sports',
         new Date(2014, 8, 4), new Date(2015, 1, 1), null, 100, null],
        ['Baseball', 'Baseball Season', 'sports',
         new Date(2015, 2, 31), new Date(2015, 9, 20), null, 14, null],
        ['Basketball', 'Basketball Season', 'sports',
         new Date(2014, 9, 28), new Date(2015, 5, 20), null, 86, null],
        ['Hockey', 'Hockey Season', 'sports',
         new Date(2014, 9, 8), new Date(2015, 5, 21), null, 89, null]
      ]);

      var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
<div class="svg-bg">
    <div class="log-header">    
        <div class="review">
            <h3 id='logs-title'>Analytics</h3>
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
<div id="chart_div"></div>
<div id="chart_div_line"></div>
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
<script>
    google.charts.load('current', {
        packages: ['corechart', 'line']
    });
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', 'Dogs');

        data.addRows([
            [0, 0],
            [1, 10],
            [2, 3],
            [3, 7],
            [4, 8],
            [5, 9],
            [6, 10],
            [7, 7],
            [8, 3],
            [9, 4],
            [10, 3],
            [32, 6],
            [33, 9],
            [69, 10]
        ]);

        var options = {
            hAxis: {
                title: 'Date'
            },
            vAxis: {
                title: 'Mood Rating'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_line'));

        chart.draw(data, options);
    }

</script>
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
