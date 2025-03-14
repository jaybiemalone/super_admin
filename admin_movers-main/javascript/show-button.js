document.getElementById("Issue").addEventListener("click", function () {
    document.getElementById("bottom").style.display = "block";
    document.getElementById("bottom2").style.display = "none";
    document.getElementById("bottom3").style.display = "none";
});

document.getElementById("Solve").addEventListener("click", function () {
    document.getElementById("bottom").style.display = "none";
    document.getElementById("bottom2").style.display = "block";
    document.getElementById("bottom3").style.display = "none";
});

document.getElementById("Actived").addEventListener("click", function () {
    document.getElementById("bottom").style.display = "none";
    document.getElementById("bottom2").style.display = "none";
    document.getElementById("bottom3").style.display = "block";
});