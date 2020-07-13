<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./templates/head.php");?>
</head>
<body>
<?php
    include("./templates/nav.php"); 
    include_once ('../../config/database.php');
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
                <span>Add Poll</span>
                <i class="fa fa-plus-circle"></i>
            </a>
        </div>
    </div>
</div>
<div class="log-container">
    <form id="notes" action="./journal-details.php" method="post">
        <table class="data poll-tab">
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
        window.location='./poll-details.php?poll='+id;
    }
</script>
<script src="../../../static/main.js"></script>
</body>
</html>
