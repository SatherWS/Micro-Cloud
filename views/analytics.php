<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once ("../config/database.php");
    $db = new database();
    $curs = $db->getConnection();
    $total = 0;

    /*
    if ($_POST["range2"]) {
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
    */
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
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
<?php include("./components/header.php");?>
<div class="svg-bg">
    <div class="todo-flex">    
        <div class="review">
        <label>Start Date:</label><br>
                <input type="date" name="start-date" id=""> <br>
        </div>
        <div class="mr2rem">
            <form action="./analytics.php" method="POST">
               
                <label>End Date:</label><br>
                <input type="date" name="end-date" id=""> <br><br>
                <input type="submit" value="Set Range" name="range" class="date-btn">
                <br>
            </form>
        </div>
    </div>
</div>
<article class="main-page">
<!-- Task List Section ===========================================-->

<!-- Gantt chart div -->
<div id="chart_div"></div>

<!-- Google pie chart section =================================-->
<div class="pie-box">
    <div class="pie-data">
        <h2>Task List Summary</h2>
        <table class="data journal-tab">
            <tr class="tbl-head">
                <th>Status</th>
                <th>Count</th>
            </tr>
            <?php
                $sql3 = "select status, count(*) from todo_list group by status";
                $result2 = mysqli_query($curs, $sql3);
            
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr><td>".$row["status"]."</td>";
                    echo "<td>".$row["count(*)"]."</td></tr>";
                }
            ?>
        </table>
        <br><br>
        <a href="./show-tasks.php" class="date-btn">View Tasks</a>
        <a href="./create-task.php" class="date-btn">Create Task</a>
    </div>
    <div class="a-panel">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
</div>

</article>

<!-- google pie chart script =========================================-->
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(
        <?php
            $sql1 = "select status, count(*) from todo_list group by status";
            $rt = mysqli_query($curs, $sql1);
            $chart_data = "[['Status', 'Task Count'],";
        
            while($row = mysqli_fetch_assoc($rt)) {
                $chart_data .= "['".$row['status']."', ".$row["count(*)"]."],";
            }
            echo substr($chart_data, 0, -1)."]";
        ?>);

        var options = {
            title: 'Task History',
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>

<script src="../static/main.js"></script>
</body>
</html>   
