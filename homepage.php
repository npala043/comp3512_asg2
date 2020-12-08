<?php

require_once 'includes/config.inc.php';
include 'includes/asg2-db-classes.inc.php';
include 'browse-paintings.helpers.inc.php';
session_start();

// check for user session data
if (isset($_SESSION['user'])) {
    // user session data found: show logged in homepage
    $displayIn = "grid";
    $displayOut = "none";
    $displayHeader = "block";

    try {
        // create new CustomerDB gateway with user session data
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $customerGate = new CustomersDB($conn);
        $customerData = $customerGate->getByCustomerID($_SESSION['user']);
        $conn = null;
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    // user session data not found: show logged out homepage
    $displayIn = "none";
    $displayOut = "flex";
    $displayHeader = "none";
}

?>

<html lang="en">

<head>
    <title>Assignment 2</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/homepage.css">
    <meta name="viewport" content="width=device-width">
    <script src="js/navbar.js"></script>

</head>

<body>
    <section class="logout" style="display:<?= $displayOut ?>;">
        <div class="out">
            <a href="login.php"><button class="login"> Login </button></a>
            <button class="join"> Join </button>


        </div>
        <div class="out">
            <form method="GET" action="homepage.php">
                <input type="text" name="title" placeholder="Search for paintings">
                <button class="search" type="submit" value="Submit"> Search </button>
            </form>

            <?php
            if (isset($_GET['title'])) {
                header("Location: browse-paintings.php?title=" . $_GET['title'] . "&artist=0&gallery=0&before=&after=&between-before=&between-after=");
            }
            ?>
        </div>
    </section>

    <section style="display:<?= $displayHeader ?>;">
        <?php include("header.php"); ?>
    </section>

    <section class="login" style="display:<?= $displayIn ?>;">

        <div class="login" id="userInfo">
            <h2><?= $customerData['FirstName'] ?> <?= $customerData['LastName'] ?></h2>
            <p><?= $customerData['Address'] ?></p>
            <p><?= $customerData['City'] ?>, <?= $customerData['Country'] ?></p>
            <p><?= $customerData['Postal'] ?></p>
            <p><?= $customerData['Phone'] ?></p>
            <p><?= $customerData['Email'] ?></p>

        </div>
        <div class="login" id="search">
            <form method="GET" action="homepage.php">
                <input type="text" name="title" placeholder="Search for paintings">
                <button class="search" type="submit" value="Submit"> Search </button>
            </form>

            <?php
            if (isset($_GET['title'])) {
                header("Location: browse-paintings.php?title=" . $_GET['title'] . "&artist=0&gallery=0&before=&after=&between-before=&between-after=");
            }
            ?>
        </div>
        <div class="login" id="favourites">
            <h2>Your Favorite Paintings</h2>

            <?php
            // check for favourites session data
            if (isset($_SESSION['favourites'])) {
                // favourites session data found: store for use
                $favs = $_SESSION['favourites'];
                // loop through favourites array, extract filenames and use to create thumbnail link
                foreach ($favs as $f) { ?>
                    <a href="single-painting.php?id=<?= $f['id'] ?>">
                        <img src="images/paintings/square-medium/<?= $f['filename'] ?>.jpg" alt="<?= $f['title'] ?>">
                    </a>
            <?php }
            } else {
                // no favourites session data found: give option to browse paintings
                echo "<p>You don't have any favorites yet!</p>";
                echo "<a href='browse-paintings.php'><button class='browse'> Browse Paintings </button></a>";
            }
            ?>
        </div>
        <div class="login" id="recommended">
            <h2>Paintings You May Like</h2>

            <?php
            // check for favourites session data
            if (isset($_SESSION['favourites'])) {
                // favourites session data found: store needed info
                $favs = $_SESSION['favourites'];
                $paintings = array();
                $artist = $favs[0]['artistid'];
                $year = $favs[0]['yearofwork'];
                $minYear = 0;
                $maxYear = 0;

                // create array of painting ids being displayed
                foreach ($favs as $f) {
                    $paintings[] = $f['id'];
                }

                // determine era of favourite painting chosen
                if ($year < 1400) {
                    $maxYear = 1399;
                } elseif ($year >= 1400 && $year < 1550) {
                    $minYear = 1400;
                    $maxYear = 1549;
                } elseif ($year >= 1550 && $year < 1700) {
                    $minYear = 1550;
                    $maxYear = 1699;
                } elseif ($year >= 1700 && $year < 1875) {
                    $minYear = 1700;
                    $maxYear = 1874;
                } elseif ($year >= 1875 && $year < 1945) {
                    $minYear = 1875;
                    $maxYear = 1944;
                } else {
                    $minYear = 1945;
                    $maxYear = 2020;
                }

                // create new PaintingDB gateway with favourites session data
                try {
                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                    $artistGate = new PaintingDB($conn);
                    $artistData = $artistGate->getAllForArtist($artist);

                    $yearGate = new PaintingDB($conn);
                    $yearData = $yearGate->getAllSortByYear();
                    $conn = null;
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                $count = 0;
                $added = 0;

                // display up to 6 paintings of an artist found in favourites
                for ($i = 0; $i < count($artistData) && $added < 6; $i++) {
                    // don't add paintings that are already displayed
                    if (!in_array($artistData[$i]['PaintingID'], $paintings)) {
                        $count++;
                        $added++; ?>
                        <a class="likeArtist" href="single-painting.php?id=<?= $artistData[$i]['PaintingID'] ?>">
                            <img src="images/paintings/square-medium/<?= $artistData[$i]['ImageFileName'] ?>.jpg" alt="<?= $artistData[$i]['Title'] ?>">
                        </a>
                        <?php
                        // add new painting id to list of paintings displayed
                        $paintings[] = $artistData[$i]['PaintingID'];
                    }
                }

                $added = 0;

                // display up to 6 paintings of an era found in favourites
                for ($i = 0; $added < 6 && $yearData[$i]['YearOfWork'] < $maxYear; $i++) {
                    // don't display paintings outside of min/max years of era
                    if ($yearData[$i]['YearOfWork'] >= $minYear && $yearData[$i]['YearOfWork'] <= $maxYear) {
                        // dont add paintings that are already displayed
                        if (!in_array($yearData[$i]['PaintingID'], $paintings)) {
                            $count++;
                            $added++; ?>
                            <a class="likeEra" href="single-painting.php?id=<?= $yearData[$i]['PaintingID'] ?>">
                                <img src="images/paintings/square-medium/<?= $yearData[$i]['ImageFileName'] ?>.jpg" alt="<?= $yearData[$i]['Title'] ?>">
                            </a>
                        <?php
                            // add new painting id to list of paintings displayed
                            $paintings[] = $yearData[$i]['PaintingID'];
                        }
                    }
                }
                // if less than 12 paintings are recommended, add more from top of painting table until 12 are displayed.
                if ($count < 12) {
                    $artistData = $artistGate->getAll();
                    for ($i = 0; $count < 12; $i++, $count++) { ?>
                        <a class="fill" href="single-painting.php?id=<?= $artistData[$i]['PaintingID'] ?>">
                            <img src="images/paintings/square-medium/<?= $artistData[$i]['ImageFileName'] ?>.jpg" alt="<?= $artistData[$i]['Title'] ?>">
                        </a>
                    <?php }
                }
            } else {
                // if no favourites found, display 12 paintings from top of painting table
                try {
                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                    $artistGate = new PaintingDB($conn);
                    $artistData = $artistGate->getAll();
                    $con = null;
                } catch (Exception $e) {
                    die($e->getMessage());
                }
                $count = 0;
                for ($i = 0; $count < 12; $i++, $count++) { ?>
                    <a class="fill" href="single-painting.php?id=<?= $artistData[$i]['PaintingID'] ?>">
                        <img src="images/paintings/square-medium/<?= $artistData[$i]['ImageFileName'] ?>.jpg" alt="<?= $artistData[$i]['Title'] ?>">
                    </a>
            <?php }
            }
            ?>
        </div>
    </section>
</body>

</html>