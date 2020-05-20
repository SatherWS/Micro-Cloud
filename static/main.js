// functionality for mobile nav
function navToggle() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } 
    else {
      x.className = "topnav";
    }
}

// hide journal form after submit
function hideForm() {
  document.getElementById('post-journal').style.display = 'none';
}
/*
// journal app - error does not allow clicking other options
$("#notes").on('click','tr',function(e){
  e.preventDefault();
  var id = $(this).attr('value');
  confirm("View Journal #"+id+"?");
  var $form = $('#notes');
  $form.submit();
  
});
*/

/*
$("form").on('click','tr',function(e){
  e.preventDefault();
  var id = $(this).attr('value');
  alert("View Journal #"+id+"?");
  var $form = $('#notes');
  // set the input value
  $form.find('input').val(id);
  $form.submit();
});
*/