<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../../authentication/login.php");
    }
    include_once ("../../config/database.php");
    $db = new database();
    $curs = $db->getConnection();
    $total = 0;

    if ($_POST["range2"]) {
        $sql = "select rating, date(date_created) as dr from rating where (date_created between ? and ?) and user_email = ?";
        mysqli_query($curs, $sql);
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_POST["start-date"], $_POST["end-date"], $_SESSION["unq_user"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        print_r($result);

        $total = mysqli_num_rows($result);
    } 
    else {
        $sql = "select rating, date(date_created) as dr from ratings";
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./templates/head.php");?>
</head>
<body class="todo-bg">
    <?php include("./templates/nav.php");?>
    <!-- Pain Rating Section Start ================================-->
    <form action="../controllers/add_entry.php" method="post" class="app"  id="post-journal">
    <div class="form-container">
        <div class="todo-panel">
            <div class="pain-rating">
                <h1>On a scale from 1 to 10 how would you rate your pain?</h1>
            </div>

            <div class="sec-2">
                <input type="range" min="0" max="10" value="5" class="slider" id="myRange" name="rating" required>
                <div class="j-box">
                    <label>Pain Rating: <span id="demo"></span></label>
                </div>
                <input name="add-journal" class="spc-n spc-m" type="submit" id="form-control2">
            </div>
        </div>
    </div>
    </form>
    <!-- Mood Ratings Section ==========================-->
    <?php   
        $sql = "select avg(rating) from ratings";
        $result = mysqli_query($curs, $sql);
        $avg = $result -> fetch_row();
    ?>
    <div class="todo-flex log-container">
        <h2>Mood Average: <?php print_r($avg[0]) ?></h2>
        <h2>
        <?php 
            if ($_POST['range'])
                echo "All ".$total. " ratings from ".$_POST['start-date']." to ".$_POST['end-date'];
            else
                echo "All ".$total." Ratings";
        ?>
        </h2>
    </div>

    <!-- Line Graph Section Start ================================-->
    <form action="./analytics.php" method="POST">
        <div class="log-container todo-flex">    
            <div class="review">
                <input type="date" name="start-date" id=""> 
            </div>
            <div class="todo-flex flex-end">
                <input type="date" name="end-date" id="">
                <input type="submit" value="Set Range" name="range2" class="date-btn">
            </div>
        </div>
    </form>
    <!-- canvas js line graph -->
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>

    <script src="../../static/main.js"></script>
    <script>
        // range slider display
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;
        
        slider.oninput = function() {
          output.innerHTML = this.value;
        }
    </script>

    <!-- Canvas JS scripts -->
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
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
                    lineThickness: 5
                }]
            });
            chart.render();
        }
    </script>
</body>
</html>
