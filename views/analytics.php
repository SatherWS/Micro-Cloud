<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once ("../config/database.php");
    $db = new database();
    $curs = $db->getConnection();
    $total = 0;

    // data for gantt chart w/o range
    /*
    $sql = "select date_format(deadline, '%Y'), month(deadline), day(deadline) from todo_list where team_name = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $result = $stmnt -> get_result();
    */

    // data for gantt chart range
    if ($_POST["range"]) {
        $sql = "select assignee, creator, title, status, deadline, date(date_created) as created from todo_list where (date_created between ? and ?) and team_name = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_POST["start-date"], $_POST["end-date"], $_SESSION["team"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        $total = mysqli_num_rows($result);
        $test = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($test, $row);
        }
        echo json_encode($test);
    }
    
    /* 
    else {
        $sql = "select rating, date(date_created) as dr from journal";
        $result = mysqli_query($curs, $sql);
        $total = mysqli_num_rows($result);
    }
    */

    // data for pie chart
    $sql2 = "select status, count(*) from todo_list group by status";
    $result2 = mysqli_query($curs, $sql2);

    // fetch gantt chart data 
    include("../models/gantt.php");
    $obj = new Issues();
    $data = $obj -> get_tasks($curs, $_SESSION["team"]);

    // format data from gantt model
    $js = "";
    while ($row = mysqli_fetch_assoc($data)) {
        $js .= "['".$row["id"]."','".$row["title"]."','".$row["status"]."',";
        $js .= "new Date(".$row["date_format(date_created, '%Y')"].",".$row["month(date_created)"].",".$row["day(date_created)"]."),";
        $js .= "new Date(".$row["date_format(deadline, '%Y')"].",".$row["month(deadline)"].",".$row["day(deadline)"]."),";
        $js .= "null, null, null],";
    }
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
        <?php
            // truncate remaining comma of formatted dataset
            echo substr($js, 0, -1);
        ?>
      ]);

      var options = {
        height: 400,
        gantt: {
          trackHeight: 50,
          barHeight: 35,
          criticalPathEnabled: false,
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
    <form action="./analytics.php" method="POST" class="log-container">
    <div class="todo-flex">    
        <div class="spc-container">
            <label>Start Date</label><br>
            <input type="date" name="start-date"><br>
        </div>
        <div class="todo-flex flex-end spc-container">
            <div>
                <label>End Date</label><br>
                <input type="date" name="end-date"> 
            </div>
            <div>
                <input type="submit" value="Set Range" name="range" class="date-btn">
            </div>
        </div>
    </div>
    </form>
</div>
<article class="main-page">
    <!-- Gantt chart div -->
    <h1>Task Analytics from xx-xx-xxx to xx-xx-xxxx</h1>
    <div id="chart_div"></div>

    <!-- Pie chart data tables section -->
    <div class="pie-box">
        <div class="pie-data">
            <div id="piechart"></div>
        </div>
        <div class="pie-data">
            <h2>Task List Summary</h2>
            <table class="data journal-tab">
                <tr class="tbl-head">
                    <th>Status</th>
                    <th>Count</th>
                </tr>
                <?php
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
        <div class="pie-data">
            <h2>Task List Summary</h2>
            <table class="data journal-tab">
                <tr class="tbl-head">
                    <th>Status</th>
                    <th>Count</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr><td>".$row["status"]."</td>";
                    echo "<td>".$row["count(*)"]."</td></tr>";
                }
                ?>
            </table>
            <br><br>
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
            title: 'Total Tasks',
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>

<script src="../static/main.js"></script>
</body>
</html>   
