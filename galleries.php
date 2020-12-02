<!-- Mason Will Start This Page -->
<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8"/>
        <title>Galleries Page</title>
        <link rel="stylesheet" href="css/galleries.css">
        <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Title for galleries page -->
    <header>
        <h1> Galleries Page </h1>
    </header>
<!-- We located the html information from lab10-text05 -->
<main>
        <!-- Creates the gallery list  -->
        <div class = "box list"> 
            <section>
                <h2>Gallery List </h2>
                <ul id="galleryList">
                    <!-- insert il using js -->
                </ul>
            </section>    
        </div>

        <!-- Creates the gallery info -->
        <div class = "box info"> 
            <section>
                <label> </label>
                <h2 id="galleryName"></h2>
                <label>Native Name:</label>
                <span id="galleryNative"></span>          
                <label>Address:</label>
                <span id="galleryAddress"></span>
                <label>City:</label>
                <span id="galleryCity"></span>          
                <label>Country:</label>
                <span id="galleryCountry"></span>            
                <label>Website:</label>
                <span><a href="" id="galleryWebsite"></a></span>
            </section>
        </div>

        <!-- Creates the map where the gallery is located -->
        <div class = "box map"> 
            <p>map</p>
            <!-- insert map given -->
        </div>

        <!-- Creates a table list of the paintings within the gallery -->
        <div class = "box paintings"> 
            <section>
                <h2>Paintings</h2>
                <table id="paintingTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th id="artist">Artist</th>
                            <th id="title">Title</th>
                            <th id="year">Year</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>
        </div>

    </main>

    <script src="js/galleries.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4uNdwAr_TMLM_3ZvKejjqMmGER11AoEU&callback=initMap"
        async defer></script>
</body>
</html>