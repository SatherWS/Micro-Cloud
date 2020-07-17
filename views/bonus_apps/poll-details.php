<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include("./templates/head.php");
        ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL); 
    ?>
</head>
<body>
<?php
    include("./templates/nav.php");
    //include("../../controllers/add_entry.php");
    include_once ('../../config/database.php');
    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select admin, topic from polls where id = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_GET["poll"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    $row = mysqli_fetch_assoc($results);

    // cast vote to selected poll if vote btn is clicked
    if ( $_POST["ballot"]) {
        $sql = "insert into votes(topic_id, vote, username) values (?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_GET["poll"], $_POST["ballot"], $_POST["usr"]);
        $stmnt -> execute();
    }

    function hasVoted($curs, $voted) {
        $sql = "select id from votes where username = ? and topic_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $voted, $_GET["poll"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            return false;
        }
        else {
            return true;
        }
    }
?>
<div class="svg-bg">
    <form method="post" id="vote-caster">
        <div class="log-header">
            <?php
                if (hasVoted($curs, $_SERVER['REMOTE_ADDR'])) {
                    include("./templates/poll-headers/not-voted.php");
                }
                else {
                    include("./templates/poll-headers/voted.php");
                }
            ?>
        </div>
    </form>
</div>
<!-- Put Bar Graph Results Here -->
<div class="log-container">
    <?php echo "<h2 class='poll-topic'>Poll Topic: ".$row['topic']."</h2>";?>
    <div class="chart-container">
        <canvas style="position: relative; width: 600px; height: 460px;" id="myChart"></canvas>
    </div>
</div>
<?php
    // data for bar graph visual
    $sql2 = "select vote, count(*) as counts from votes where topic_id = ? group by vote";
    $stmnt2 = mysqli_prepare($curs, $sql2);
    $stmnt2 -> bind_param("s", $_GET["poll"]);
    $stmnt2 -> execute();
    $results2 = $stmnt2 -> get_result();
    $yes_count = $no_count = $maybe_count = 0;

    if (mysqli_num_rows($results2) > 0) {
        while($row = mysqli_fetch_assoc($results2)) {
            if ($row["vote"] == "yes") {
                $yes_count = $row["counts"];
            }
            if ($row["vote"] == "no") {
                $no_count = $row["counts"];
            }
            if ($row["vote"] == "maybe") {
                $maybe_count = $row["counts"];
            }
        }
    }
?>
<!--Graph Script-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        
        // The data for our dataset
        data: {
            labels: ['Yes', 'No', 'Maybe'],
            datasets: [{
                data: [<?php echo $yes_count.",".$no_count.",". $maybe_count;?>],
                backgroundColor: [
                    '#2b9eb3',
                    '#f8333c',
                    '#28a745'
                ],
                borderColor: '#fff'
            }]
        },
        // Configuration options go here
        options: {
            maintainAspectRatio:false
            ,scales: {
                yAxes: [{
                gridLines: {
                        color:"#222326"
                },  
                ticks: {
                        beginAtZero: true,
                        fontColor: "white",
                        fontSize: 16
                    }
                }]
                ,xAxes: [{
                    gridLines: {
                        color:"#222326"
                    },
                    ticks: {
                        fontColor: "black",
                        fontSize: 24,
                    }
                }]
            }
            ,legend: {
                display: false,
                labels: {
                    fontColor: "white",
                    fontSize: 18,
                }
            },
            tooltips: {
                callbacks: {
                label: function(tooltipItem) {
                        return tooltipItem.yLabel;
                        }
                }
            }    
        }
    });
</script>
<script src="../../static/main.js"></script>
</body>
</html>