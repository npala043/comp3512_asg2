document.addEventListener("DOMContentLoaded", function() {

    let toggle = document.querySelector(".toggle");
    let navBar = document.querySelector("#navList");
    console.log("heeloo?")

    navBar.addEventListener('click', function() {
        toggle.classList.toggle('active');
    });




});