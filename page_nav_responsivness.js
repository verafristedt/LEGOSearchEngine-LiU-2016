window.onresize = function(event) {
  changeNav();
}
function changeNav() {
  if (window.innerWidth <= 520) {
    mobileNav();
  }
  else if(window.innerWidth >= 521) {
    resetNav();
  }
}
function mobileNav() {
  var listItems = document.querySelectorAll('.pageList a');
  var currentPage = document.getElementById('currentPageNum').value;
  console.log("mobile nav");
  for (var i = 0; i < listItems.length; i++) {
    if (listItems[i].innerHTML != currentPage) {
      listItems[i].style.display = "none";
    }
  }
}
function resetNav() {
  var listItems = document.querySelectorAll('.pageList a');
  console.log("resetting");
  for (var i = 0; i < listItems.length; i++) {
    listItems[i].style.display = "block";
  }
}
