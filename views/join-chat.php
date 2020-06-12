<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Chat Room</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
        include_once ('../config/database.php');
        include("./components/header.php");
        include("./components/chatroom-modal.php"); 
        $database = new Database();
        $curs = $database->getConnection();
        $sql = "select * from chatroom";
        $result = mysqli_query($curs, $sql);
    ?>
    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h3 id='logs-title'>Available Chatrooms</h3>
            </div>
            <div class="add-btn">
                <a href="#" id="myBtn">
                    <span>Create Chatroom</span>
                    <i class="fa fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="log-container">
        <form action="" method="post">
            <table>
                <tr class="tbl-head">
                    <th>ID</th>
                    <th>SUBJECT</th>
                    <th>CREATED BY</th>
                    <th>MESSAGE COUNT</th>
                    <th>CREATED ON</th>
                </tr>
            <?php
                function count_msgs($curs, $uname_id) {
                    $sql = "select count(*) from messages where room_id = ?";
                    $stmnt = mysqli_prepare($curs, $sql);
                    $stmnt -> bind_param("s", $uname_id);
                    $stmnt -> execute();
                    $results = $stmnt -> get_result();
                    $count = mysqli_fetch_row($results);
                    return $count[0];
                }
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $id = $row["id"];
                        echo "<tr onclick='myFunction($id)' name='btn-submit' value='".$id."'> <td>". $id. "</td>";
                        echo "<td>". $row["subject"]. "</td>";
                        echo "<td>".$row["creator"]."</td>";
                        echo "<td>".count_msgs($curs, $id)."</td>";
                        echo "<td>".$row["time_created"]. "</td></tr>";
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
        window.location='./chat-details.php?room='+id;
    }
    </script>
    <script src="../static/main.js"></script>
    <script src="../static/modal.js"></script>
</body>
</html>