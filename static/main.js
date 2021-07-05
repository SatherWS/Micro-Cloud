
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

// hide the side navbar on media query
var vis = true;
function check_mediaq(x) {
  if (x.matches) { // If media query matches
    hideSideBar();
  } 
}

var x = window.matchMedia("(max-width: 750px)");
check_mediaq(x);
x.addListener(check_mediaq);
