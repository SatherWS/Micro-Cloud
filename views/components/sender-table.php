<h3>Requests sent by <?php echo $_SESSION["unq_user"];?></h3>
<form action="../controllers/auth_user.php" method="post">
    <table class="data settings-tab">
    <tr class="tbl-head">
        <th>STATUS</th>
        <th>PROJECT</th>
        <th>SENDER</th>
        <th>RECEIVER</th>
        <th>DATE SUBMITTED</th>
    </tr>
    <?php
    if (mysqli_num_rows($results2) > 0) {
        while ($row = mysqli_fetch_assoc($results2)) {
            echo "<tr><td>".$row["status"]."</td>";
            echo "<td>".$row["team_name"]."</td>";
            echo "<td>".$row["sender"]."</td>";
            echo "<td>".$row["receiver"]."</td>";
            echo "<td>".$row["date_created"]."</td></tr>";
        }
    }
    ?>
    </table>
</form>