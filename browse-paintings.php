<!-- Anthony Dang will do this-->
<?php

include_once('includes/config.inc.php');
include_once('includes/asg2-db-classes.inc.php');
include_once('browse-paintings.helpers.inc.php');
session_start();


?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Browse Paintings</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/browse-paintings.css">
    <script src="js/navbar.js"></script>
</head>

<body>
    <?php
    include_once('header.php');
    ?>
    <main class="container">
        <div id="filters">
            <form method="GET" action="browse-paintings.php">
                <table>
                    <!--Cell 1 = Fieldname -->
                    <!-- Cell 2 = Field -->
                    <tr>
                        <th colspan="2">Painting Filters</th>
                    </tr>
                    <tr>
                        <td class="category">
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" class="filter" />
                        </td>
                    </tr>

                    <tr>
                        <td class="category">
                            <label>Artist</label>
                        </td>
                        <td>
                            <!-- Creates Select List of Artists -->
                            <select name="artist" class="dropdown">
                                <option value=0>Choose an artist</option>
                                <?php
                                try {
                                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                                    $artistGateway = new ArtistDB($conn);
                                    $data = $artistGateway->getAll();
                                    $conn = null;
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }

                                foreach ($data as $row) { ?>
                                    <option value='<?= $row['ArtistID'] ?>'><?= $row['LastName'] ?>, <?= $row['FirstName'] ?></option>
                                <?php }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="category">
                            <label>Gallery</label>
                        </td>
                        <td>
                            <!-- Creates Select List of Gallery -->
                            <select name="gallery" class="dropdown">
                                <option value=0>Choose a Gallery</option>
                                <?php
                                try {
                                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                                    $galleryGateway = new GalleryDB($conn);
                                    $data = $galleryGateway->getAll();
                                    $conn = null;
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }

                                foreach ($data as $row) { ?>
                                    <option value='<?= $row['GalleryID'] ?>'><?= $row['GalleryName'] ?></option>
                                <?php }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <!-- Breakline for the table -->
                        <td><br /></td>
                        <td><br /></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Year</label>
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <!-- Before Field -->
                        <td class="category">
                            <input type="radio" id="before" name="time-period" value="before" />
                            <label>Before </label>
                        </td>
                        <td>
                            <input type="text" name="before" class="filter" />
                        </td>
                    </tr>

                    <tr>
                        <!-- After field -->
                        <td class="category">
                            <input type="radio" id="after" name="time-period" value="after" />
                            <label>After</label>
                        </td>
                        <td>
                            <input type="text" name="after" class="filter" />
                        </td>
                    </tr>

                    <tr>
                        <!-- Between Field -->
                        <td class="category">
                            <input type="radio" id="between" name="time-period" value="between" />
                            <label>Between</label>
                        </td>
                        <td>
                            <input type="text" name="between-before" class="between" /> and
                            <input type="text" name="between-after" class="between" />
                        </td>
                    </tr>

                    <tr>
                        <!-- Between Field Cont. -->
                        <td></td>
                        <td>

                        </td>
                    </tr>
                </table>

                <button type="submit" value="Submit">Filter</button>
                <button type="reset" value="Reset"><a href="browse-paintings.php">Clear</a></button>
            </form>
        </div>

        <!-- Creates the table of Paintings -->
        <div id="paintings">
            <p><?php
                if (isset($_SESSION['favMessage'])) {
                    echo $_SESSION['favMessage'];
                    unset($_SESSION['favMessage']);
                }
                ?> </p>
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
                        // Checks to see if any fields have been filled out within the form.
                        if (formIsFilled()) {
                            $sort = "";
                            if (isset($_GET['sort'])) {
                                if ($_GET['sort'] == 'artist') {
                                    $sort = 'LastName';
                                } else if ($_GET['sort'] == 'title') {
                                    $sort = 'Title';
                                } else if ($_GET['sort'] == 'year') {
                                    $sort = 'YearOfWork';
                                }
                            }
                            createFilter($_GET['title'], $_GET['artist'], $_GET['gallery'], $_GET['before'], $_GET['after'], $sort, $conn);
                        } else { // Otherwise, allows user to sort the default table by any field (default being year).
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
                        }
                        $conn = null;
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