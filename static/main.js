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
// hide the side navbar
var vis = true;
function hideSideBar() {
  vis = !vis;
  var x = document.getElementById("side-bar");
  var y = document.getElementById("main");
  var z = document.getElementById("mini-btn");
  if (vis) {
    x.style.display = "block";
    y.classList.remove('hidden-sidebar');
    z.style.display = "none";
  }
  else {
    x.style.display = "none";
    y.classList.add('hidden-sidebar');
    z.style.display = "block";
  }
}
