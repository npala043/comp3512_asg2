document.addEventListener("DOMContentLoaded", function() {

    let hamburger = document.querySelector(".toggle");
    let navBar = document.querySelector("nav .navList");


    hamburger.addEventListener('click', function() {
        
        navBar.classList.toggle("active");
    });




});