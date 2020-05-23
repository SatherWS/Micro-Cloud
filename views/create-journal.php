<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal App</title>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body class="todo-bg">
    <?php include("./components/header.php");?>
    <form action="../controllers/add_entry.php" method="post" class="app"  id="post-journal">
        <div class="form-container">
            <div></div>
            <div class="todo-panel">
                <h1>Journal Application</h1>
                <input type="text" name="jsubject" placeholder="Type Subject of Entry" id="form-control" class="spc-n" required>
                <br><br>
                <textarea rows="7" placeholder="Text area for writting notes" name="note"></textarea>
                <br><br>
    		        <div class="sec-2">
                    <input type="range" min="0" max="10" value="5" class="slider" id="myRange" name="rating" required>
                    <div class="j-box">
                        <label>Mood Rating: <span id="demo"></span></label>
                        <div style="text-align: left;">
                        <label class="container">
                          <input type="checkbox" name="omit">
                          <span class="checkmark"></span>
                          Omit Mood Rating
                        </label>
                        </div>
                    </div>
                </div>
                <input name="add-journal" class="spc-n spc-m" type="submit">
            </div>
            <div></div>
        </div>
    </form>
    
    <script src="../static/main.js"></script>
    <script>
        // range slider display
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;
        
        slider.oninput = function() {
          output.innerHTML = this.value;
        }
    </script>
    <!-- jQuery then Javascript libraries
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     -->
</body>
</html>
