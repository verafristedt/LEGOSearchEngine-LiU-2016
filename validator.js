//adds timed event, therefor, warning message doesn't display right away
var timerValidator = true;
function runFunction(){
  if(timerValidator == true){
    setTimeout(checkLength, 5000);
  }
  else if(timerValidator == false){
    checkLength();
  }
}

//checks length of string entered in searchbar.
function checkLength(){
  timerValidator = false; //runFunction skips timed event next time
  var keyword = document.getElementById("keyword");
  if(keyword.value.length >= 3 || keyword.value.length == 0){
    displayWarning("none");
  }
  else{
    displayWarning("block");
  }
}

//simulates warningButton to work like type=submit, so the enterKey toggles warning message.
function enterKeyActivation(event){
  var keyword = document.getElementById("keyword");
  var lengthCondition = (keyword.value.length < 3);
  var keyCondition = (event.keyCode == 13 || event.which == 13); //13 is the keyCode for the Enter (a.k.a. Return) button.
  if(lengthCondition && keyCondition){
    warningButtonClick();
  }
}

//if the warningButton is pressed, checks if the warning message should be displayed.
function warningButtonClick(){
  timerValidator = false; //runFunction skips timed event next time
  var keyword = document.getElementById("keyword");
  keyword.focus(); //autofocus for the searchbar, even if it was out of focus previously
  if(keyword.value.length >= 3){ //displays even if nothing is entered yet.
    displayWarning("none");
  }
  else{
    displayWarning("block");
  }
}

//reveals warning message if entered string is too short.
function displayWarning(visual){
  var alert = document.getElementsByClassName("alertWarning")[0];
  var fadeTime = 250;
  if (visual == "none"){
    if(alert.style.opacity == "1"){ //Error message showing? if not, don't fadeOut.
      animation("fadeOut "+fadeTime+"ms", alert);
      alert.style.opacity = "0"; //keeps error message OFF
    }
  }
  else if (visual == "block"){
    animation("fadeIn "+fadeTime+"ms", alert);
    alert.style.opacity = "1"; //keeps error message ON
  }
}
