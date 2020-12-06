<!-- Tony Babiluboni will do this-->
<?php

include_once('config.inc.php');
include_once('asg2-db-classes.inc.php');
include_once('browse-paintings.helpers.inc.php');


?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Browse Paintings</title>
</head>

<body>
    <?php
    include_once('header.php');
    ?>
    <main>
        <div id="filters">
            <form method="GET" action="browse-paintings.php">
                <label>Title</label>
                <input type="text" name="title" />
                <br />
                <br />

                <label>Artist</label>
                <!-- Create Select List of Artists -->
                <select>
                    <option value=0>Choose an artist</option>
                    <?php
                    try {
                        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                        $artistGateway = new ArtistDB($conn);
                        $data = $artistGateway->getAll();
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }

                    foreach ($data as $row) { ?>
                        <option value='<?= $row['ArtistID'] ?>'><?= $row['LastName'] ?>, <?= $row['FirstName'] ?></option>
                    <?php }
                    ?>
                </select>
                <br />
                <br />

                <label>Gallery</label>
                <!-- Create Select List of Gallery -->
                <select>
                    <option value=0>Choose a Gallery</option>
                    <?php
                    try {
                        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                        $galleryGateway = new GalleryDB($conn);
                        $data = $galleryGateway->getAll();
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }

                    foreach ($data as $row) { ?>
                        <option value='<?= $row['GalleryID'] ?>'><?= $row['GalleryName'] ?></option>
                    <?php }
                    ?>
                </select>
                <br />
                <br />

                <label>Year</label>
                <br />
                <input type="radio" id="before" name="time-period" value="before" />
                <label>Before</label>
                <input type="text" name="before" />
                <br />
                <br />

                <input type="radio" id="after" name="time-period" value="after" />
                <label>After</label>
                <input type="text" name="after" />
                <br />
                <br />

                <input type="radio" id="between" name="time-period" value="between" />
                <label>Between</label>
                <input type="text" name="between-before" />
                <br />
                <input type="text" name="between-after" />
                <br />
                <br />
                <button type="submit" value="Submit">Submit</button>
                <button type="reset" value="Reset"><a href="browse-paintings.php">Clear</a></button>
            </form>
        </div>

        <div id="paintings">
            <h2>Paintings</h2>
            <table id="paintingTable">
                <thead>
                    <tr>
                        <th></th>
                        <th id="artist"><a href="<?= generateQueryString('artist') ?>">Artist</a></th>
                        <th id="title"><a href="<?= generateQueryString('title') ?>">Title</a></th>
                        <th id="year"><a href="<?= generateQueryString('year') ?>">Year</a></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));

                        //createFilter($_GET['title'], $_GET['artist'], $_GET['gallery'], $_GET['before'], $_GET['after'], $conn);
                        if (isset($_GET['sort'])) {
                            if ($_GET['sort'] == 'artist') {
                                displayByArtist($conn);
                            } else if ($_GET['sort'] == 'title') {
                                displayByTitle($conn);
                            } else if ($_GET['sort'] == 'year') {
                                displayByYear($conn);
                            }
                        } else {
                            displayByYear($conn);
                        }
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>