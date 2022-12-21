function openForm(id) {
    document.getElementById(id).style.display = "block";
    document.getElementById("background").style.display = "block";
  }

  function closeForm(id) {
    document.getElementById(id).style.display = "none";
    document.getElementById("background").style.display = "none";
  }

  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function nextstep() {
  document.getElementById('first-step').style.display = "none";
  document.getElementById('second-step').style.display = "block";
  document.getElementById('first-step-buttons').style.display = "none";
  document.getElementById('second-step-buttons').style.display = "block";
}

function previousstep(){
  document.getElementById('first-step').style.display = "block";
  document.getElementById('second-step').style.display = "none";
  document.getElementById('first-step-buttons').style.display = "block";
  document.getElementById('second-step-buttons').style.display = "none";
}

function afficher_image(){
  var img = document.createElement("img");
  img.src = '../avatar/avatars_amy.png';
  var block = document.getElementById("x");
  block.appendChild(img);
}

function changeAvatar(){
  var text=document.getElementById('f_selectTrie').options[document.getElementById('f_selectTrie').selectedIndex].value;
  document.getElementById('avatar').src=text;
}