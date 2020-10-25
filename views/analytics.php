<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once ("../config/database.php");
    $db = new database();
    $curs = $db->getConnection();

    // fetch gantt chart data model
    include("../models/gantt.php");
    $obj = new Issues();
    $data = $obj -> get_tasks($curs, $_SESSION["team"]);
    $total = 0;
    $js = "";

    // data for gantt chart w/ range
    if ($_POST["range"]) {
        $sql = "select id, title, status, date_format(date_created, '%Y'), month(date_created), day(date_created), date_format(deadline, '%Y'), month(deadline), day(deadline) from todo_list where (date_created between ? and ?) and team_name = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_POST["start-date"], $_POST["end-date"], $_SESSION["team"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        $total = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
            $js .= "['".$row["id"]."','".$row["title"]."','".$row["status"]."',";
            $js .= "new Date(".$row["date_format(date_created, '%Y')"].",".$row["month(date_created)"].",".$row["day(date_created)"]."),";
            $js .= "new Date(".$row["date_format(deadline, '%Y')"].",".$row["month(deadline)"].",".$row["day(deadline)"]."),";
            $js .= "null, null, null],";
        }
    } 
    // data for gantt chart w/o range
    else {
        // format data from gantt model
        while ($row = mysqli_fetch_assoc($data)) {
            $m1 = $row["month(date_created)"] - 1;
            $m2 = $row["month(deadline)"] -1;
            $js .= "['".$row["id"]."','".$row["title"]."','".$row["status"]."',";
            $js .= "new Date(".$row["date_format(date_created, '%Y')"].",".$m1.",".$row["day(date_created)"]."),";
            $js .= "new Date(".$row["date_format(deadline, '%Y')"].",".$m2.",".$row["day(deadline)"]."),";
            $js .= "null, null, null],";
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="shortcut icon" href="../favicon.png" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <title>Analytics</title>
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
	// set height of gantt chart
        height: 1000,
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
    <div class="todo-flex">
        <p class="welcome"><?php echo $_SESSION["team"];?></p>
        <p class="welcome"><?php echo $_SESSION["unq_user"];?></p>
    </div>
</div>

<div class="dash-grid r-col" id="main">
    <article class="main-page">
        <div class="text-center todo-flex r-col">
        <?php
            echo "<h1>".$_SESSION["team"]." Task Analytics</h1>";
            if (isset($_POST["start-date"]) || isset($_POST["end-date"]))
                echo "<p>From ".$_POST["start-date"]." to ".$_POST["end-date"]."</p>";
            else
                echo "<p>Showing All Tasks</p>";
        ?>
        </div>
        <form action="./analytics.php" method="POST">
        <div class="todo-flex">    
            <div class="spc-container">
                <label>Start Date</label><br>
                <input type="date" name="start-date" class="simple-input"><br>
            </div>
            <div class="todo-flex flex-end spc-container">
                <div>
                    <label>End Date</label><br>
                    <input type="date" name="end-date" class="simple-input"> 
                </div>
                <div>
                    <input type="submit" value="Set Range" name="range" class="date-btn">
                </div>
            </div>
        </div>
        </form>
        <!-- Gantt chart div -->
        <div id="chart_div"></div>
        <!-- Pie chart data tables section -->
        <div class="pie-box">
            <div class="pie-data">
                <div id="piechart"></div>
                <br><br>
                <div class="text-center">
                    <a href="./show-tasks.php" class="date-btn">View Tasks</a>
                    <a href="./create-task.php" class="date-btn">Create Task</a>
                </div>
            </div>
            <div class="pie-data">
                <h2>Task List Summary</h2>
                <table class="data journal-tab">
                    <tr class="tbl-head">
                        <th>Status</th>
                        <th>Count</th>
                    </tr>
                    <?php
                        $result2 = $obj->team_data($curs, $_SESSION["team"]);
                        while ($row = mysqli_fetch_assoc($result2)) {
                            echo "<tr><td>".$row["status"]."</td>";
                            echo "<td>".$row["count(*)"]."</td></tr>";
                        }
                    ?>
                </table>
            </div>
            <div class="pie-data">
                <h2>Task Summary by User</h2>
                <table class="data journal-tab">
                    
                    <tr class="tbl-head">
                        <th>Team Mate</th>
                        <th>Staus</th>
                        <th>Count</th>
                    </tr>
                    <?php
                        $result3 = $obj->user_summaries($curs, $_SESSION["team"]);
                        while ($row = mysqli_fetch_assoc($result3)) {
                            echo "<tr><td>".$row["assignee"]."</td>";
                            echo "<td>".$row["status"]."</td>";
                            echo "<td>".$row["count(*)"]."</td></tr>";
                        }
                    ?>
                </table>
                <br><br>
            </div>
        </div>
    </article>
    <?php include("./components/sidebar.php");?>
</div>

<!-- google pie chart script =========================================-->
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(
        <?php
            echo $obj->pie_data($curs, $_SESSION["team"]);
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
