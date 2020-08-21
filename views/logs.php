<?php
    session_start();
    if (!isset($_SESSION["unq_user"])) {
        header("Location: ../authentication/login.php");
    }
    include_once ("../config/database.php");
    $database = new Database();
    $curs = $database->getConnection();
    
    if (isset($_GET["category"])) {
        $sql = "select id, subject, creator, category, team_name, substring(message,1, 55) as preview, date_created from journal where category = ? and team_name = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $_GET["category"], $_SESSION["team"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        $total = mysqli_num_rows($result);
    }
    else {
        $sql = "select id, subject, creator, team_name, category, substring(message,1, 55) as preview, date_created from journal where team_name = ? order by date_created desc";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_SESSION["team"]);
        $stmnt -> execute();
        $result = $stmnt -> get_result();
        $total = mysqli_num_rows($result);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
    <title>Swoop | Posts</title>
</head>
<body class="log-bg">
    <?php include("./components/header.php");?>
    <div class="svg-bg">
        <div class="todo-flex">
            <div class="review">
                <h4 id="logs-title"><?php echo $total;?> Posts</h4>
            </div>    
            <div class="add-btn">
                <h4 class="mr2rem">
                    <a href="./create-journal.php">
                        <span>Add Entry</span>
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </h4>
            </div>
        </div>
    </div>
    <div class="dash-grid r-cols">
        <section class="side-bar">
            <form action="" method="post">
                <div class="add-btn">
                    <h4>
                    <a href="./create-journal.php"><span>Add Project</span><i class="fa fa-plus-circle"></i></a>
                    </h4>
                </div>
            </form>
        </section>
        <div class="log-container">
            <form id="notes" action="./journal-details.php" method="post">
                <table class="data journal-tab">
                    <tr class="tbl-head">
                        <th>CATEGORY</th>
                        <th>SUBJECT</th>
                        <th>PREVIEW</th>
                        <th>CREATOR</th>
                        <th>TEAM</th>
                        <th>DATE & TIME CREATED</th>
                    </tr>
                    <?php
                        while($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            echo "<tr onclick='myFunction($id)' name='btn-submit' value='".$row["id"]."'> <td>". $row["category"]. "</td>";
                            echo "<td>". $row["subject"]. "</td>";
                            echo "<td>".strip_tags($row["preview"], '<br><b><i>'). "...</td>";
                            echo "<td>".$row["creator"]."</td>";
                            echo "<td>".$row["team_name"]."</td>";
                            echo "<td>".$row["date_created"]."</td></tr>";
                        }
                        /*
                        else {
                            echo "<p>0 results</p>";
                        }
                        */
                    ?>
                </table>
            </form>
        </div>
    </div>
    <script>
    function myFunction(id) {
        window.location='./journal-details.php?journal='+id;
    }
    </script>
    <script src="../static/main.js"></script>
</body>
</html>
