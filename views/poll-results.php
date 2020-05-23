<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        include("./components/header.php");
        include("../controllers/add_entry.php");
    ?>
    <h1 class="greeting">Thanks for voting!</h1>
    <div class="chart-container">
        <canvas style="position: relative; width: 600px; height: 460px;" id="myChart"></canvas>
    </div>    
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
                data: [<?php echo $yesCount;?>,<?php echo $noCount;?>,<?php echo $maybeCount;?>],
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
                        fontColor: "white",
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
    
</body>
</html>