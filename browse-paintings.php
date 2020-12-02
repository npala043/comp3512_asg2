<!-- Tony Babiluboni will do this-->
<?php

include_once('config.inc.php');
include_once('asg2-db-classes.inc.php');

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
            <form method="post">
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
                    <option value=0>Choose an artist</option>
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
            </form>
        </div>

        <div id="paintings">
        </div>
    </main>
</body>

</html>