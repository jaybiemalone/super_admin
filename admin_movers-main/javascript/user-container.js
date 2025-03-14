document.getElementById("showContent1").addEventListener("click", function() {
    document.getElementById("content1").style.display = "block";
    document.getElementById("content2").style.display = "none";
    document.getElementById("content3").style.display = "none";
});

document.getElementById("showContent2").addEventListener("click", function() {
    document.getElementById("content1").style.display = "none";
    document.getElementById("content2").style.display = "block";
    document.getElementById("content3").style.display = "none";
});

document.getElementById("showContent3").addEventListener("click", function() {
  document.getElementById("content1").style.display = "none";
  document.getElementById("content2").style.display = "none";
  document.getElementById("content3").style.display = "block";
});

document.getElementById("add-employee").addEventListener("click", function() {
    document.getElementById("add-employee-content").style.display = "block";
    document.getElementById("add-work-content").style.display = "none";
    document.getElementById("add-vacation-content").style.display = "none";
});

document.getElementById("add-work").addEventListener("click", function() {
    document.getElementById("add-employee-content").style.display = "none";
    document.getElementById("add-work-content").style.display = "block";
    document.getElementById("add-vacation-content").style.display = "none";
});

document.getElementById("add-vacation").addEventListener("click", function() {
    document.getElementById("add-vacation-content").style.display = "block";
    document.getElementById("add-employee-content").style.display = "none";
    document.getElementById("add-work-content").style.display = "none";
});

// Get the modal
var umodal = document.getElementById("user-Modal");

// Get the button that opens the modal
var btn = document.getElementById("user-open-modal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("user-modal-close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
  umodal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  umodal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    umodal.style.display = "none";
  }
}