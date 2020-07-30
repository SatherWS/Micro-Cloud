<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once ("../config/database.php");
    $database = new Database();
    $curs = $database->getConnection();
    $sql = "select id, subject, creator, team_name, category, substring(message,1, 55) as preview, date_created from journal where team_name = ? order by date_created desc";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_SESSION["team"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    $total = mysqli_num_rows($results);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body class="log-bg">
    <?php include("./components/header.php");?>
    <div class="svg-bg">
        <div class="todo-flex">
            <div class="review">
                <h3 id="logs-title"><?php echo $total;?> Posts</h3>
            </div>    
            <div class="add-btn">
                <h3 class="mr2rem">
                    <a href="./create-journal.php">
                        <span>Add Entry</span>
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </h3>
            </div>

        </div>
    </div>
    <div class="log-container">
        <form id="notes" action="./journal-details.php" method="post">
            <table class="data journal-tab">
                <tr class="tbl-head">
                    <th>ID</th>
                    <th>SUBJECT</th>
                    <th>PREVIEW</th>
                    <th>CREATOR</th>
                    <th>TEAM</th>
                    <th>CATEGORY</th>
                    <th>DATE & TIME CREATED</th>
                </tr>
                <?php
                    $filter = $_GET["category"];
                    // TODO: CLEAN UP THIS QUERY
                    $search = "select id, subject, creator, category, substring(message,1, 55) as preview, date_created from journal where category = '$filter' and team_name = '".$_SESSION['team']."order by date_created desc";
                    if ($filter) {
                        $result = mysqli_query($curs, $search);
                    }
                    if (mysqli_num_rows($results) > 0) {
                        while($row = mysqli_fetch_assoc($results)) {
                            $id = $row['id'];
                            echo "<tr onclick='myFunction($id)' name='btn-submit' value='".$row["id"]."'> <td>". $row["id"]. "</td>";
                            echo "<td>". $row["subject"]. "</td>";
                            echo "<td>".strip_tags($row["preview"], '<br><b><i>'). "...</td>";
                            echo "<td>".$row["creator"]."</td>";
                            echo "<td>".$row["team_name"]."</td>";
                            echo "<td>". $row["category"]. "</td>";
                            echo "<td>".$row["date_created"]."</td></tr>";
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
