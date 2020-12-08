document.addEventListener("DOMContentLoaded", function() {

    let hamburger = document.querySelector(".toggle");
    let navBar = document.querySelector("nav .navList");
    let header =  document.querySelector("header");

    hamburger.addEventListener('click', function() {
        navBar.classList.toggle("clicked");
        if(navBar.className = 'clicked') {
            header.style.height="auto";
        } else {
            header.style.height="30px";
        }
        
    });




});