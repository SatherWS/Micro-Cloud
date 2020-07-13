<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Uploader</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.png" >
</head>
<body>
    <?php
        include("./components/header.php"); 
        include("./components/upload-modal.php"); 
        include_once ("../config/database.php");
        $database = new Database();
        $curs = $database->getConnection();
    ?>

    <div class="svg-bg">
        <div class="log-header">    
            <div class="review">
                <h3>Current User: <?php echo getenv("username");?></h3>
            </div>
            <div class="add-btn">
                <a href="#" id="myBtn">Upload Data <i class="fa fa-upload"></i></a>
            </div>
        </div>
    </div>
    <div class="log-container">
        <form id="notes" action="" method="post">
            <table class="data">
                <tr class="tbl-head">
                    <th>ID</th>
                    <th>NAME</th>
                    <th>SIZE</th>
                    <th>LOCATION</th>
                    <th>SOURCE IP</th>
                    <th>DATE & TIME UPLOADED</th>
                </tr>
                <?php
                /*
                    $filter = $_GET["category"];
                    if ($filter) {
                        $result = mysqli_query($curs, "select id, subject, category, substring(message,1, 45) as preview, rating, date_created from journal where category = '$filter' order by date_created desc");
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            echo "<tr onclick='myFunction($id)' name='btn-submit' value='".$row["id"]."'> <td>". $row["id"]. "</td>";
                            echo "<td>". $row["subject"]. "</td>";
                            echo "<td>".strip_tags($row["preview"], '<br><b><i>'). "...</td>";
                            echo "<td>". $row["category"]. "</td>";
                            echo "<td>". $row["rating"]. "</td>";
                            echo "<td>". $row["date_created"] ."</td></tr>";
                        }
                    } 
                    else {
                        echo "<p>0 results</p>";
                    }
                    $curs -> close();
                */
                ?>
            </table>
        </form>
    </div>
    <script>
        // NOT IN USE 6/11/2020
        function myFunction(id) {
            window.location='./journal-details.php?journal='+id;
        }
    </script>
    <script src="../static/main.js"></script>
    <!--
    <script>
        // Get the modal, open and close buttons
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];
        var end = document.getElementsByClassName("other-close")[0];
        
        // When the user clicks the button, open the modal 
        btn.onclick = function() {
        modal.style.display = "block";
        }
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }
        
        // Close when the user clicks add attachment button
        end.onclick = function() {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    -->
    <script src="../static/modal.js"></script>
</body>
</html>
