<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/style.css">
        <title>Assignment 1</title>
        <style>
            header {
                display: block;
                border-radius: 5px;
                padding: 10px 20px;
                margin: 20px 0px;
                background-color: #C4DFE6;
                color: #003b46;
            }
            main {
                display: grid;
                grid-gap: 15px;
                grid-template-columns: 20rem 25rem auto;
                height: 650px;
            }

            .box {
                background-color: #C4DFE6;
                color: #003b46;
                border-radius: 5px;
                padding: 10px 20px;
                font-size: 1rem;
            }

            .list {
                grid-column: 1 / span 1;
                grid-row: 1 / span 3;
                overflow: auto;
                height: 600px;
            }

            ul#galleryList {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            .info {
                grid-column: 2 / span 1;
                grid-row: 1 / span 1;
                height: 260px;
            }

            div.info section {
                display: none;
                grid-gap: 5px;
                grid-template-columns: 6rem auto;
            }

            .map {
                grid-column: 2 / span 1;
                grid-row: 2 / span 2;
                height: 305px;
            }

            .paintings {
                grid-column: 3 / span 1;
                grid-row: 1 / span 3;
                overflow: auto;
                height: 600px;
            }

            table {
                width: 100%;
                margin: 5px 10px 5px 5px;
            }

            th {
                text-align: left;
                padding: 5px;
            }

            td {
                padding: 5px;
            }

        </style>
</head>

<body>  
    <?php include("header.php"); ?>
    <!-- We located the html information from lab10-text05 -->
    <main>
        <!-- Button to toggle list -->
        <button type="button" id="toggle">Hide Gallery List</button>
        <!-- Creates the gallery list  -->
        <div class = "box list"> 
            <section>
                <h2>Galleries</h2>
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

    <!-- Connects the html to the javascript -->
    <script src="js/gallerypage.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4uNdwAr_TMLM_3ZvKejjqMmGER11AoEU&callback=initMap"
        async defer></script>
</body>
</html>