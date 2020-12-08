

document.addEventListener("DOMContentLoaded", function () {

    let desciption = document.querySelector(".desctab");
    let details = document.querySelector(".detailstab");
    let colors = document.querySelector(".colorstab");
    let descid = document.querySelector("#description");
    let detailsid = document.querySelector("#details");
    let colorsid = document.querySelector("#colors");

    desciption.addEventListener("click", function () {
        tabs(desciption, descid);

    });

    details.addEventListener("click", function () {
        tabs(details, detailsid);

    });

    colors.addEventListener("click", function () {

        tabs(colors, colorsid);

    });

    console.log(document.querySelector("#thing"));

    function tabs(tabActivated, id) {
        let allTabs = document.querySelectorAll(".tabs");
        let allTabContent = document.querySelectorAll(".tabContent");

        for (let a of allTabContent) {
            a.style.display = "none";
        }

        for (let tab of allTabs) {
            tab.className.replace("active", " ");
        }
        console.log(id);
        id.style.display = "block";
        tabActivated.classList.toggle("active");



    }


});