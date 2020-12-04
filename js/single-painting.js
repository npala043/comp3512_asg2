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
        colourBlocks(document.cookie);

    });


    function tabs(tabActivated, information) {
        // let allTabs = document.querySelectorAll(".tabs");
        let allTabContent = document.querySelectorAll(".tabContent");

        for (let a of allTabContent) {
            a.style.display = "none";
        }

        // for (let tab of allTabs) {
        //     tab.className.replace("active", " ");
        // }

        document.querySelector(information).style.display = "block";
        tabActivated.classList.toggle("active");



    }

    /*creates the colour blocks based on the colours that is most prominent within the single painting.  */
    function colourBlocks(painting) {
        // let painting = JSON.parse(jsoncolours);
        console.log(document.cookie);
        console.log("hello?");
        let div = document.querySelector("#coloursBlock")
        div.textContent = "";
        for (let p of painting.dominantColors) {
            let span = document.createElement("span");
            let colour = p.web;
            span.style.backgroundColor = colour;
            span.style.padding = "15px 25px";
            span.style.margin = "5px";
            span.title = `${colour}, ${p.name}`;
            div.appendChild(span);

        }
    }




});