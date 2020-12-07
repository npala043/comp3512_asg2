// reference: https://www.w3schools.com/howto/howto_js_tabs.asp

document.addEventListener("DOMContentLoaded", function () {

    let desciption = document.querySelector(".desctab");
    let details = document.querySelector(".detailstab");
    let colors = document.querySelector(".colorstab");


    desciption.addEventListener("click", function () {
        tabs(desciption, "#description");

    });

    details.addEventListener("click", function () {
        tabs(details, "#details");

    });

    colors.addEventListener("click", function () {
        tabs(colors, "#colors");

    });


    function tabs(tabActivated, information) {
        let allTabs = document.querySelectorAll(".tabs");
        let allTabContent = document.querySelectorAll(".tabContent");

        for (let a of allTabContent) {
            a.style.display = "none";
        }

        for (let tab of allTabs) {
            tab.className.replace("active", " ");
        }

        document.querySelector(information).style.display = "block";
        tabActivated.classList.toggle("active");



    }


});