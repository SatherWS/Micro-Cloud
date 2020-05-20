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
    <?php
        include("../views/components/header.php"); 
        include_once ('../config/database.php');
        $database = new Database();
        $curs = $database->getConnection();
        $sql = "select id, topic, admin, date_created from polls order by date_created desc";
        $result = mysqli_query($curs, $sql);
    ?>
    <div class="svg-bg rad-5">
        <div class="polls-header">    
            <div class="review">
                <h3 id='polls-title'>Election History</h3>
            </div>
            <div class="add-btn">
                <a href="./create-poll.php">
                    <span class="opt-desc">Add Poll</span>
                    <i class="fa fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="log-container">
        <!-- Latest Poll Here 
        <div class="feature-panel">
            <div>
                <h2>Latest Poll: </h2>
                <h2>By:</h2>
                <h2>Date:</h2>
            </div>
            <div class="feature-btns">
                <input type="submit" value="Cast Vote">
            </div>
        </div>
        -->
        
        <form id="notes" action="./journal-details.php" method="post">
            <table class="data">
                <tr class="tbl-head">
                    <th>ID</th>
                    <th>TOPIC</th>
                    <th>RESULT</th>
                    <th>CREATOR</th>
                    <th>YES COUNT</th>
                    <th>NO COUNT</th>
                    <th>MAYBE COUNT</th>
                    <th>DATE CREATED</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            echo "<tr onclick='myFunction($id)' name='btn-submit' value='".$id."'> <td>". $id. "</td>";
                            echo "<td>". $row["topic"]. "</td>";
                            
                            echo "<td>"."TBD". "</td>";
                            
                            echo "<td>". $row["admin"]. "</td>";
                            
                            echo "<td>"."100". "</td>";
                            echo "<td>"."0". "</td>";
                            echo "<td>"."0". "</td>";
                            
                            echo "<td>". $row["date_created"] ."</td></tr>";
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
    <script src="../static/main.js"></script>
</body>
</html>
