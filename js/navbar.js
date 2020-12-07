document.addEventListener("DOMContentLoaded", function() {

    let hamburger = document.querySelector(".toggle");
    let navBar = document.querySelector("#navList");
    console.log("heeloo?");
    console.log(navBar);
    console.log(hamburger);

    navBar.addEventListener('click', function() {
        console.log('hello')
        hamburger.classList.toggle("active");
    });




});