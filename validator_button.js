//runs toggleSearchButton and toggleWarningButton
function toggleButtons(){
  var keyword = document.getElementById("keyword");
  var searchButton = document.getElementById("searchButton");
  var warningButton = document.getElementById("warningButton");
  toggleSearchButton(keyword, searchButton);
  toggleWarningButton(keyword, warningButton);
}

//Toggles the searchButton, either clickable/submitable or not. Runs once onload.
function toggleSearchButton(keyword, searchButton){
  if(keyword.value.length >= 3){
    searchButton.disabled = false;
    timerValidator = false; //runFunction skips timed event next time
  }
  else{
    searchButton.disabled = true;
  }
}

//Toggles warningButton, either display it or not.
function toggleWarningButton(keyword, warningButton){
  var fadeTime = 200;
  if(keyword.value.length >= 3){
    if(warningButton.style.opacity == "1"){
      animation("fadeOut "+fadeTime+"ms", warningButton);
      warningButton.style.display = "none";
    }
  }
  else{
    animation("fadeIn "+fadeTime+"ms", warningButton);
    warningButton.style.display = "";
    warningButton.style.opacity = "1";
  }
}
