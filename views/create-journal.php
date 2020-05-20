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
                <textarea rows="7" cols="55" placeholder="Text area for writting notes" name="note"></textarea>
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
                        <!-- Use in Music App Possibly
                          <p class="attach"><a href="#" id="myBtn">Add Attachment</a></p>
                        -->
                        </div>
                    </div>
                </div>
                <input name="add-journal" class="spc-n spc-m" type="submit">
            </div>
            <div></div>
        </div>

        <!-- Modal Use in Music App Possibly -->
        <div id="myModal" class="modal">
          <!-- Modal content -->
          <div class="modal-content">
              <span class="close">&times;</span>
              <p>Either provide a url to an image or upload a file directly</p>
              <input type="file" name="" id="">
              <input type="text" placeholder="Enter URL Here" id="form-control" class="spc-n">
              <br><br>
              <span class="other-close attach">Add Attachment</span>
          </div>
        </div>
    </form>
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
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
        
    </script>
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
