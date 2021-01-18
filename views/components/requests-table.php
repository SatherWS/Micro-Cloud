
<div class="invites">
    <form action="../controllers/auth_user.php" method="post">
        <table class="data journal-tab">
        <tr class="tbl-head">
            <th>ACTION</th>
            <th>PROJECT</th>
            <th>SENDER</th>
            <th>RECEIVER</th>
            <th>STATUS</th>
            <th>DATE SUBMITTED</th>
        </tr>
        <?php
        if (mysqli_num_rows($results3) > 0) {
            while ($row = mysqli_fetch_assoc($results3)) {
                $id = $row["sender"];
                if ($row["status"] != "pending") {
                    echo "<tr><td></td>";
                }
                else if ($_SESSION["unq_user"] == $row["receiver"] ) {
                    echo "<tr><td><button class='accept-btn' type='submit' name='accept' value='$id'>Accept</button>";
                    echo "<button class='deny-btn' type='submit' name='deny' value='$id'>Deny</button></td>";
                }
                else {
                    echo "<tr><td></td>";
                }
                echo "<td>".$row["team_name"]."</td>";
                echo "<td>".$row["sender"]."</td>";
                echo "<td>".$row["receiver"]."</td>";
                echo "<td>".$row["status"]."</td>";
                echo "<td>".$row["date_created"]."</td>";
            }
        }
        else {
            echo "<h4>No requests have been made yet...</h4>";
        }
        ?>
        </table>
    </form>
</div>