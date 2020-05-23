<!-- This is a bonus feature use select element to sort through categories -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select or create a category</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body class="todo-bg">
    <?php
        include("./components/header.php");
        include("./components/modal.php");
        include("../controllers/edit_entry.php");
        include_once("../config/database.php");

        $database = new Database();
        $curs = $database->getConnection();
        $sql = "select category from journal where category is not null";
        $result = mysqli_query($curs, $sql);
        echo $_GET['id'];
    ?>
    <form action="../controllers/add_entry.php" method="post">
        <div class="cat-grid">
            <div>
                <a href="#" id="myBtn">
                    <i class="fa fa-plus">
                        Add Category
                    </i>
                </a>
            </div>
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<div><button type='submit' name='category' value='".$row["category"]."'>".$row["category"]."</button></div>";
                    }
                }
            ?>
        </div>
    </form>
    <script src="../static/modal.js"></script>
    <script src="../static/main.js"></script>
</body>
</html>