<!-- Mason Will Start This Page -->
<?php

require_once 'config.inc.php';
include 'asg2-db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new GalleryDB($conn);
    $galleries = $gateway->getAll();
    $gateway2 = new PaintingDB($conn);
    $paintings = $gateway2->getAll();
    if (isset($_GET['galleryID'])) {
        $galleryPaintings = $gateway2->getAllForGallery($_GET['galleryID']);
        $galleryInfo = $gateway->getGallery($_GET['galleryID']);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Galleries Page</title>

    <!-- <link rel="stylesheet" href="css/galleries.css"> -->
    <!-- <link rel="stylesheet" href="css/style.css"> -->

    <style>
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

        .info {
            grid-column: 2 / span 1;
            grid-row: 1 / span 1;
            height: 260px;
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

                /* .info,
                .paintings {
                    display: grid;
                    border: blue 1px solid;

                }

                .info,
                .paintings {
        display: none;
                } */
    </style>
</head>

<body>
    <!-- Title for galleries page -->
    <header>
        <h1> Galleries Page </h1>
    </header>
    <!-- We located the html information from lab10-text05 -->
    <main>
        <!-- Creates the gallery list  -->
        <div class="box list">
            <section>
                <h2>Gallery List </h2>
                <ul id="galleryList">
                    <?php

                    foreach ($galleries as $row) {
                        echo "<li><a href='galleries.php?galleryID=" . $row['GalleryID'] . "'>" . $row['GalleryName'] . "</a></li>";
                    }
                    ?>

                    <!-- insert il using js -->
                </ul>
            </section>
        </div>

        <!-- Creates the gallery info -->
        <div class="box info">
            <section>
                <?php
                if (isset($_GET['galleryID'])) {
                    foreach ($galleryInfo as $row) {
                ?>
                        <label> <?= $row['GalleryName'] ?> </label>
                        <h2 id="galleryName"></h2>
                        <label>Native Name: <?= $row['GalleryNativeName'] ?></label>
                        <span id="galleryNative"></span>
                        <label>Address: <?= $row['GalleryAddress'] ?></label>
                        <span id="galleryAddress"></span>
                        <label>City: <?= $row['GalleryCity'] ?></label>
                        <span id="galleryCity"></span>
                        <label>Country: <?= $row['GalleryCountry'] ?></label>
                        <span id="galleryCountry"></span>
                        <label>Website:</label>
                        <span><a href="<?= $row['GalleryWebSite'] ?>" id="galleryWebsite"> Website </a></span>
                <?php
                    }
                }
                ?>
            </section>
        </div>

        <!-- Creates the map where the gallery is located -->
        <div class="box map">
            <p>map</p>
            <!-- insert map given -->
        </div>

        <!-- Creates a table list of the paintings within the gallery -->
        <div class="box paintings">
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
                        <?php
                        if (isset($_GET['galleryID'])) {
                            foreach ($galleryPaintings as $row) {
                        ?>
                                <tr>
                                    <td><img src='images/paintings/square-medium/<?= $row['ImageFileName'] ?>.jpg'></td>
                                    <td>
                                        <?php
                                        if (is_null($row['FirstName'])) {
                                            echo $row['LastName'];
                                        } else if (is_null($row['LastName'])) {
                                            echo $row['FirstName'];
                                        } else {
                                            echo $row['FirstName'] . " " . $row['LastName'];
                                        }
                                        ?>
                                    </td>
                                    <td id="title"><a href="single-painting.php?id=<?= $row['PaintingID'] ?>"><?= $row['Title'] ?></a></td>
                                    <td><?= $row['YearOfWork'] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>

    </main>

    <script src="js/galleries.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4uNdwAr_TMLM_3ZvKejjqMmGER11AoEU&callback=initMap" async defer></script>
</body>

</html>