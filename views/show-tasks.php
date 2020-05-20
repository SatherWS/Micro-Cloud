
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Tasks</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        include("./components/header.php");
        include ("../config/database.php");
        $database = new Database();
        $curs = $database->getConnection();
        $result = mysqli_query($curs, "select * from todolist where status = 'IN PROGRESS' or status = 'NOT STARTED' order by deadline");
        $filter = $_POST['s-status'];
        
        if ($filter) {
            $result = mysqli_query($curs, "select * from todolist where status = '$filter' order by deadline desc");
            if ($filter == 'SHOW ALL') {
                $result = mysqli_query($curs, "select * from todolist order by deadline desc");
            }
        }
        $total = mysqli_num_rows($result)
        
    ?>
    <div class="svg-bg2">
        <div class="log-header">    
            <div class="review">
                <?php
                    echo "<h3 id='logs-title'>Total Tasks: $total</h3>";
                ?>
            </div>
            <div class="add-log">
                <form method="POST">
                    <select name="s-status" id="myselect" onchange="this.form.submit()">
                        <option value="none" selected disabled hidden>Filter Tasks by Status</option>
                        <option value="SHOW ALL">SHOW ALL</option>
                        <option value="NOT STARTED">NOT STARTED</option>
                        <option value="IN PROGRESS">IN PROGRESS</option>
                        <option value="STUCK">STUCK</option>
                        <option value="COMPLETED">COMPLETED</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="log-container">
        <form action="../edit_entry.php" method="post" id="tasks">
            <table class="data">
                <tr class="tbl-head">
                    <th>ID</th>
                    <th>DESCRIPTION</th>
                    <th>STATUS</th>
                    <th>DEADLINE</th>
                    <th>TIME DUE</th>
                    <th>IMPORTANCE</th>
                    <th>DATE & TIME CREATED</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            echo "<tr onclick='getTask($id)'><td>".$row["id"]."</td>";
                            echo "<td>".$row["description"]."</td>";
                            echo "<td>".$row["status"]."</td>";
                            echo "<td>".$row["deadline"]."</td>";
                            echo "<td>".$row["time_due"]."</td>";
                            echo "<td>".$row["importance"]."</td>";
                            echo "<td>".$row["date_created"]."</td> </tr>";
                        }
                    }
                    else {
                        echo "<p>0 Results</p>";
                    }
                    $curs->close();
                ?>
            </table>
        </form>
    </div>
    <script>
        function getTask(id) {
            window.location = "./task-details.php?task="+id;
        }
    </script>
    <script src="../static/main.js"></script>
</body>
</html>