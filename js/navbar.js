document.addEventListener("DOMContentLoaded", function() {

    let hamburger = document.querySelector(".toggle");
    let navBar = document.querySelector("nav .navList");
    console.log("heeloo?");
    console.log(navBar);
    console.log(hamburger);

    hamburger.addEventListener('click', function() {
        console.log('hello')
        navBar.classList.toggle("active");
    });




});