//resets the user at the index page
function reloadPage(){
  window.location = "index.php";
}
//loads the about page
function loadAbout(){
  window.location = "about.php";
}

//takes care of animations for different browser variations
function animation(animationType, directory){
  directory.style.webkitAnimation = animationType;
  directory.style.MozAnimation = animationType;
  directory.style.msAnimation = animationType;
  directory.style.OAnimation = animationType;
  directory.style.animation = animationType;
}

//sets autofocus on certain URL's
function focusDependingOnPath(){
  //fetches the opened fileName from the opened path (the last part of the URL).
  var fileNameIndex = location.pathname.lastIndexOf('/')+1; //fetch position of the last "/" (+1), which is the start position of the fileName
  var fileName = location.pathname.substring(fileNameIndex); //creates a new string with only the fileName

  if(fileName == "index.php" || fileName == "about.php" || fileName == ""){
    document.getElementById("keyword").focus(); //set autofocus for searchbar
  }
}
