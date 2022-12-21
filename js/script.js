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
  document.getElementById('first-step').style.display = "none"
  document.getElementById('second-step').style.display = "block"
}

function previousstep(){
  document.getElementById('first-step').style.display = "block"
  document.getElementById('second-step').style.display = "none"
}