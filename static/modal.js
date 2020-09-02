  /* components/modal.php */
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
  span.onclick = function() {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // close window on click outside of modal
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
