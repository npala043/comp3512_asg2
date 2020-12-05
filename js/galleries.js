// // Mason's File
function initMap() {
    map = new google.maps.Map(document.querySelector(".box.map"), {
        center: { lat: 51.011238, lng: -114.133142 },
        zoom: 17,
        mapTypeId: 'satellite'
    })
}

// document.addEventListener("DOMContentLoaded", function () {

//     const galleries = "api-galleries.php";

//     fetch(galleries)
//         .then(resp => resp.json())
//         .then(gallery => {
//             document.querySelector("div.list section").style.display = "block";
//             listGalleries(gallery);
//         })
//         .catch(err => console.error(err));

//     function listGalleries(gallery) {
       
//         for (let g of gallery) {
           
//             let li = document.createElement("li");
//             li.textContent = g.GalleryName;
//             document.querySelector("#galleryList").appendChild(li);
//             li.addEventListener("click", function () {
//                 document.querySelector("div.info section").style.display = "grid";
//                 displayInfo(g);
//                 document.querySelector("div.paintings section").style.display = "block";
//                 displayPaintings(g);
//                 displayMap(g);
//             });

//             sortPaintings(g);
//         }
document.addEventListener("DOMContentLoaded", function () {
    console.log("jkasdfj");
    const galleries = "api-galleries.php";
    let list = document.querySelector("#galleryList li a");
    list.addEventListener("click", function () {
        console.log("im here");
        document.querySelector(".info ").style.display = "grid";
        document.querySelector(".paintings").style.display = "block";
    });
    displayMap(galleries);


});

//     }
//     //This function displays the gallery information that has been retrieved from the JSON file.
//     function displayInfo(gallery) {
//         document.querySelector("#galleryName").innerHTML = gallery.GalleryName;
//         document.querySelector("#galleryNative").innerHTML = gallery.GalleryNativeName;
//         document.querySelector("#galleryAddress").innerHTML = gallery.GalleryAddress;
//         document.querySelector("#galleryCity").innerHTML = gallery.GalleryCity;
//         document.querySelector("#galleryCountry").innerHTML = gallery.GalleryCountry;

//         let website = document.querySelector("#galleryWebsite");
//         website.href = gallery.GalleryWebSite;
//         website.innerHTML = "Website";
//     }

    //This function displays the location given from the JSON file 
    function displayMap(gallery) {
        map = new google.maps.Map(document.querySelector(".box.map"), {
            center: { lat: gallery.Latitude, lng: gallery.Longitude },
            zoom: 17,
            mapTypeId: 'satellite'
        });
    }
//     //This function displays the painting in order from the galleries page.
//     function displayPaintings(gallery) {
//         fetch(`api-paintings.php?gallery=${gallery.GalleryID}`)
//             .then(resp => resp.json())
//             .then(paintings => {
                
//                 createPaintingTable(paintings);
//                 sortPaintings(paintings);

//             })
//     }

//     //This function creates the painting table within the galleries page.
//     // it takes the api-galleries and creates the table with painting 
//     function createPaintingTable(paintings) {
//         document.querySelector("tbody").innerHTML = "";
        
//         for (let p of paintings) {

//             let tableBody = document.querySelector("#paintingTable tbody");
//             let tr = document.createElement("tr");
//             tr.className = "tempTr";
//             tableBody.appendChild(tr);

//             let imgTd = document.createElement("td");
//             let img = smallImage(p);
//             imgTd.appendChild(img);
//             imgTd.className = "img";
//             tr.appendChild(imgTd);


//             let artistTd = document.createElement("td");
//             artistTd.setAttribute("class", "artist");
//             let titleTd = document.createElement("td");
//             titleTd.setAttribute("class", "title");
//             titleTd.style.textDecoration = "underline";
//             let yearTd = document.createElement("td");
//             yearTd.setAttribute("class", "year");

//             if (p.FirstName == null) {
//                 artistTd.textContent = `${p.LastName}`;
//             } else if (p.LastName == null) {
//                 artistTd.textContent = `${p.FirstName}`;
//             } else {
//                 artistTd.textContent = `${p.FirstName} ${p.LastName}`;
//             }

//             titleTd.textContent = `${p.Title}`;
//             titleTd.setAttribute("id", `${p.ImageFileName}`);
//             yearTd.textContent = `${p.YearOfWork}`;

//             tr.appendChild(artistTd);
//             tr.appendChild(titleTd);
//             tr.appendChild(yearTd);

//             // titleTd.addEventListener("click", function (e) {
//             //     clickPainting(e);

//             // })
//         }
//     }

//     function clickPainting(painting) {
//         let p = `single-painting.php?id=${painting.paintingID}`;
//         document.getElementById(`${painting.paintingID}`).innerHTML = '<a href="' + p + '">Link</a>';
//     }

//     // Function lets us sort through the paintings list by clicking on artists, title, year.
//     function sortPaintings(paintings) {
//         let sortArtist = document.querySelector("#artist");
//         let sortTitle = document.querySelector("#title");
//         let sortYear = document.querySelector("#year");

//         sortArtist.addEventListener("click", function () {
//             paintings.sort((a, b) => {
//                 return a.LastName < b.LastName ? -1 : 1;
//             });
//             createPaintingTable(paintings);
//         });

//         sortTitle.addEventListener("click", function () {
//             paintings.sort((a, b) => {
//                 return a.Title < b.Title ? -1 : 1;
//             });
//             createPaintingTable(paintings);
//         });

//         sortYear.addEventListener("click", function () {
//             paintings.sort((a, b) => {
//                 return a.YearOfWork < b.YearOfWork ? -1 : 1;
//             });
//             createPaintingTable(paintings);
//         });

//     }

//     function smallImage(painting) {
//         let img = document.createElement("img");
//         img.src = `images/paintings/square-medium/${painting.ImageFileName}.jpg`;
//         img.id = `${painting.ImageFileName}`;
//         img.style.width = "20px";
//         img.style.height = "20px";
        
//         return img;
//     }
// })
