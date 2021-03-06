// Creates the map that displays the musuem. Default set to mount royal university.
function initMap() {
    map = new google.maps.Map(document.querySelector(".box.map"), {
        center: { lat: 51.011608, lng: -114.133074 },
        zoom: 17,
        mapTypeId: 'satellite'
    })
}

document.addEventListener("DOMContentLoaded", function () {

    const galleries = "apis/api-galleries.php";

    //Fetches galleries api and stores it within local storage. If api is already stored set api to local storage
    if (localStorage.getItem("gallery") === null) {
    fetch(galleries)
        .then(resp => resp.json())
        .then(gallery => {
            localStorage.setItem("gallery", JSON.stringify(gallery));
            
            document.querySelector("div.list section").style.display = "block";
            listGalleries(gallery);
        })
        .catch(err => console.error(err));
    } else {
        const gallery = JSON.parse(localStorage.getItem("gallery"));
        listGalleries(gallery);
    }

    //Lists the Galleries given from the Galleries API
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

            document.querySelector("#galleryList").appendChild(li);
        }
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

    //Displays the paintings within the given gallery ID
    function displayPaintings(gallery) {
        fetch(`apis/api-paintings.php?gallery=${gallery.GalleryID}`)
            .then(resp => resp.json())
            .then(paintings => {
                paintings.sort((a, b) => {
                    return a.YearOfWork < b.YearOfWork ? -1 : 1;
                });
                
                createPaintingTable(paintings);
                sortPaintings(paintings);

            })
    }

    //Creates the painting table within the table element using a for loop.
    function createPaintingTable(paintings) {
        document.querySelector("tbody").innerHTML = ""

        for (let p of paintings) {

            let tableBody = document.querySelector("#paintingTable tbody");
            let tr = document.createElement("tr");
            tr.className = "tempTr";
            tableBody.appendChild(tr);

            let imgTd = document.createElement("td");
            let img = smallImage(p);
            let a1 = document.createElement('a');
            a1.href = `single-painting.php?id=${p.PaintingID}`;
            a1.appendChild(img);
            imgTd.appendChild(a1);
            imgTd.className = "img";
            tr.appendChild(imgTd);


            let artistTd = document.createElement("td");
            artistTd.setAttribute("class", "artist");
            let titleTd = document.createElement("td");
            titleTd.setAttribute("class", "title");
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

    // Displays the image within the paintings table.
    function smallImage(painting) {
        let img = document.createElement("img");
        img.src = `images/paintings/square-medium/${painting.ImageFileName}.jpg`;
        img.id = `${painting.ImageFileName}`;
        img.height = "20px";
        img.width = "20px";
        return img;
    }
});