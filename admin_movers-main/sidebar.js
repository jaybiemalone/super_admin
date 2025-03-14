const sidebtn = document.getElementById("sidebtn");
const sideshow = document.getElementById("sideshow");

sidebtn.addEventListener("click", Event =>{

    if(sideshow.style.visibility === "hidden"){
        sideshow.style.visibility ="visible";
    }
    else{
        sideshow.style.visibility = "hidden";
    }
});