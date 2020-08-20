//change tabColor depending on session var, if not set default selected tab is Part
function tabColor(){
  var lastClicked = sessionStorage.getItem("lastClicked"); //fetch session var
  if(lastClicked == "parts"){
    focus("parts");
  }
  else if(lastClicked == "sets"){
    focus ("sets");
  }
  else{
    focus("parts");
  }
}

//change tabcolor denpending on clicked item
function changeTab(clicked){
  keyword.focus(); //set autofocus for searchbar

  if(clicked == "searchParts"){
    focus("parts");
    lastClicked = "parts";
    sessionStorage.setItem("lastClicked", lastClicked);
  }
  else if(clicked == "searchSets"){
    focus("sets");
    lastClicked = "sets";
    sessionStorage.setItem("lastClicked", lastClicked);
  }
}

//help function for changing all necessary vars both visually and logically
function focus(type){
  //fetch vars
  var searchSets = document.getElementById('searchSets');
  var searchParts = document.getElementById('searchParts');
  var aboutTab = document.getElementById('aboutTab');
  var keyword = document.getElementById("keyword");
  var formTag = document.getElementsByTagName('form')[0];

  if(type == "parts"){
    searchSets.style.backgroundColor = "#1A237E";
    searchParts.style.backgroundColor = "#3F51B5"; //gives this tab lighter color

    //change placeholder and form action
    keyword.placeholder = "Search for Parts";
    formTag.action = "choose_part.php";
  }
  else if(type == "sets") {
    searchSets.style.backgroundColor = "#3F51B5"; //gives this tab lighter color
    searchParts.style.backgroundColor = "#1A237E";

    //change placeholder and form action
    keyword.placeholder = "Search for Sets";
    formTag.action = "choose_set.php";
  }
}
