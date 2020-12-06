// document.addEventListener("DOMContentLoaded", function () {

//     const galleries = `api-galleries.php`;
//     console.log(galleries);

//     fetch(galleries)
//         .then(resp => resp.json())
//         .then(gallery => {
//             console.log(gallery);
//             let list = document.querySelector("galleryList li a");
//             list.addEventListener("click", function () {
//                 console.log(list);
//             })
            
//         })
// });
function initMap() {
    map = new google.maps.Map(document.querySelector(".box.map"), {
        center: { lat: 44.525049, lng: -110.83819 },
        zoom: 17,
        mapTypeId: 'satellite'
    })
}

document.addEventListener("DOMContentLoaded", function () {

    const galleries = "api-galleries.php";

    fetch(galleries)
        .then(resp => resp.json())
        .then(gallery => {
            document.querySelector("div.list section").style.display = "block";
            listGalleries(gallery);
        })
        .catch(err => console.error(err));

    function listGalleries(gallery) {
        for (let g of gallery) {
            let li = document.createElement("li");
            li.textContent = g.GalleryName;

            li.addEventListener("click", function () {
                document.querySelector("div.info section").style.display = "grid";
                displayInfo(g);
                document.querySelector("div.paintings section").style.display = "block";
                displayPaintings(g);
                displayMap(g);
            });

            sortPaintings(g);
            toggleButton();
            document.querySelector("#galleryList").appendChild(li);
        }
    }

    function toggleButton() {
        let toggle = document.querySelector("#toggle")
        toggle.addEventListener("click", e => {
            let list = document.querySelector(".list");
            let info = document.querySelector(".info");
            let main = document.querySelector("main");
            let map = document.querySelector(".map");
            if (e.target.nodeName.toLowerCase() == 'button' && list.style.display != "none") {
                list.style.display = "none";
                main.style.gridTemplateColumns = "17.5% 17.5% auto";
                info.style.gridColumn = "1 / span 2";
                map.style.gridColumn = "1 / span 2";
                toggle.textContent = "Show Gallery List"
            } else {
                list.style.display = "grid";
                main.style.gridTemplateColumns = "20rem 25rem auto";
                info.style.gridColumn = "2 / span 1";
                map.style.gridColumn = "2/ span 1";
                toggle.textContent = "Hide Gallery List"

            }
        })
    }

    //This function displays the gallery information that has been retrieved from the JSON file.
    function displayInfo(gallery) {
        document.querySelector("#galleryName").innerHTML = gallery.GalleryName;
        document.querySelector("#galleryNative").innerHTML = gallery.GalleryNativeName;
        document.querySelector("#galleryAddress").innerHTML = gallery.GalleryAddress;
        document.querySelector("#galleryCity").innerHTML = gallery.GalleryCity;
        document.querySelector("#galleryCountry").innerHTML = gallery.GalleryCountry;

        let website = document.querySelector("#galleryWebsite");
        website.href = gallery.GalleryWebSite;
        website.innerHTML = "Website";
    }

    //This function displays the location given from the JSON file 
    function displayMap(gallery) {
        map = new google.maps.Map(document.querySelector(".box.map"), {
            center: { lat: gallery.Latitude, lng: gallery.Longitude },
            zoom: 17,
            mapTypeId: 'satellite'
        });
    }

    function displayPaintings(gallery) {
        fetch(`api-paintings.php?gallery=${gallery.GalleryID}`)
            .then(resp => resp.json())
            .then(paintings => {

                createPaintingTable(paintings);
                sortPaintings(paintings);

            })
    }

    function createPaintingTable(paintings) {
        document.querySelector("tbody").innerHTML = ""

        for (let p of paintings) {

            let tableBody = document.querySelector("#paintingTable tbody");
            let tr = document.createElement("tr");
            tr.className = "tempTr";
            tableBody.appendChild(tr);

            let imgTd = document.createElement("td");
            let img = smallImage(p);
            imgTd.appendChild(img);
            imgTd.className = "img";
            tr.appendChild(imgTd);


            let artistTd = document.createElement("td");
            artistTd.setAttribute("class", "artist");
            let titleTd = document.createElement("td");
            titleTd.setAttribute("class", "title");
            titleTd.style.textDecoration = "underline";
            let yearTd = document.createElement("td");
            yearTd.setAttribute("class", "year");

            if (p.FirstName == null) {
                artistTd.textContent = `${p.LastName}`;
            } else if (p.LastName == null) {
                artistTd.textContent = `${p.FirstName}`;
            } else {
                artistTd.textContent = `${p.FirstName} ${p.LastName}`;
            }

            let a = document.createElement('a');
            a.href = `single-painting.php?id=${p.PaintingID}`;
            titleTd.appendChild(a);
            a.textContent = `${p.Title}`;
            titleTd.setAttribute("id", `${p.ImageFileName}`);
            yearTd.textContent = `${p.YearOfWork}`;
            tr.appendChild(artistTd);
            tr.appendChild(titleTd);
            tr.appendChild(yearTd);

        }
    }

     // Function lets us sort through the paintings list by clicking on artists, title, year.
     function sortPaintings(paintings) {
        let sortArtist = document.querySelector("#artist");
        let sortTitle = document.querySelector("#title");
        let sortYear = document.querySelector("#year");
        
        sortArtist.addEventListener("click", function () {
            paintings.sort((a, b) => {
                return a.LastName < b.LastName ? -1 : 1;
            });
            createPaintingTable(paintings);
        });
    
        sortTitle.addEventListener("click", function () {
            paintings.sort((a, b) => {
                return a.Title < b.Title ? -1 : 1;
            });
            createPaintingTable(paintings);
        });
    
        sortYear.addEventListener("click", function () {
            paintings.sort((a, b) => {
                return a.YearOfWork < b.YearOfWork ? -1 : 1;
            });
            createPaintingTable(paintings);
        });
    
    }

    function smallImage(painting) {
        let img = document.createElement("img");
        img.src = `images/paintings/square-medium/${painting.ImageFileName}.jpg`;
        img.id = `${painting.ImageFileName}`;
        return img;
    }
});