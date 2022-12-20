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