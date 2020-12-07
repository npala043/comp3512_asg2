<?php

require_once 'config.inc.php';
include 'asg2-db-classes.inc.php';
include 'browse-paintings.helpers.inc.php';
session_start();

if (isset($_SESSION['user'])) {
    $displayIn = "grid";
    $displayOut = "none";
    $searchPos = "";

    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $customerGate = new CustomersDB($conn);
        $customerData = $customerGate->getByCustomerID($_SESSION['user']);
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    $displayIn = "none";
    $displayOut = "flex";
    $searchPos = "";
}

?>

<html lang="en">

<head>
    <title>Assignment 2</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/homepage.css">

</head>

<body>
    <section class="logout" style="display:<?= $displayOut ?>;">
        <div class="out">
            <button class="login"><a href="login.php"> Login </a></button>
            <button class="join"> Join </button>


        </div>
        <div class="out">
            <form method="GET" action="homepage.php">
                <input type="text" name="title" placeholder="SEARCH BOX FOR Paintings">
                <button class="search" type="submit" value="Submit"> Search </button>
            </form>

            <?php
            if (isset($_GET['title'])) {
                header("Location: browse-paintings.php?title=" . $_GET['title'] . "&artist=0&gallery=0&before=&after=&between-before=&between-after=");
            }
            ?>
        </div>
    </section>

    <section class="login" style="display:<?= $displayIn ?>;">
        <header>
            <?php include("header.php"); ?>
        </header>
        <div class="login">
            <h2><?= $customerData['FirstName'] ?> <?= $customerData['LastName'] ?></h2>
            <p><?= $customerData['Address'] ?></p>
            <p><?= $customerData['City'] ?>, <?= $customerData['Country'] ?></p>
            <p><?= $customerData['Postal'] ?></p>
            <p><?= $customerData['Phone'] ?></p>
            <p><?= $customerData['Email'] ?></p>

        </div>
        <div class="login">
            <form method="GET" action="homepage.php">
                <input type="text" name="title" placeholder="SEARCH BOX FOR Paintings">
                <button class="search" type="submit" value="Submit"> Search </button>
            </form>

            <?php
            if (isset($_GET['title'])) {
                header("Location: browse-paintings.php?title=" . $_GET['title'] . "&artist=0&gallery=0&before=&after=&between-before=&between-after=");
            }
            ?>
        </div>
        <div class="login">
            <h2>Your Favorite Paintings</h2>

            <?php
            if (isset($_SESSION['favourites'])) {
                $favs = $_SESSION['favourites'];
                foreach ($favs as $f) { ?>
                    <a href="single-painting.php?id=<?= $f['id'] ?>">
                        <img src="images/paintings/square-medium/<?= $f['filename'] ?>.jpg" alt="<?= $f['title'] ?>">
                    </a>
            <?php }
            } else {
                echo "<p>You don't have any favorites yet!</p>";
                echo "<button class='browse'><a href='browse-paintings.php'> Browse Paintings </a></button>";
            }
            ?>
        </div>
        <div class="login">
            <h2>Paintings You May Like</h2>

            <?php
            if (isset($_SESSION['favourites'])) {
                $favs = $_SESSION['favourites'];
                $paintings = array();
                $artist = $favs[0]['artistid'];
                $year = $favs[0]['yearofwork'];
                $minYear = 0;
                $maxYear = 0;

                foreach ($favs as $f) {
                    $paintings[] = $f['id'];
                }

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

                try {
                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                    $artistGate = new PaintingDB($conn);
                    $artistData = $artistGate->getAllForArtist($artist);

                    $yearGate = new PaintingDB($conn);
                    $yearData = $yearGate->getAllSortByYear();
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                $count = 0;
                $added = 0;

                for ($i = 0; $i < count($artistData) && $added < 6; $i++) {
                    print_r($paintings);
                    if (!in_array($artistData[$i]['PaintingID'], $paintings)) {
                        $count++;
                        $added++; ?>
                        <a class="likeArtist" href="single-painting.php?id=<?= $artistData[$i]['PaintingID'] ?>">
                            <img src="images/paintings/square-medium/<?= $artistData[$i]['ImageFileName'] ?>.jpg" alt="<?= $artistData[$i]['Title'] ?>">
                        </a>
                        <?php
                        $paintings[] = $artistData[$i]['PaintingID'];
                    }
                }

                $added = 0;

                for ($i = 0; $added < 6; $i++) {
                    if ($yearData[$i]['YearOfWork'] >= $minYear && $yearData[$i]['YearOfWork'] <= $maxYear) {
                        if (!in_array($yearData[$i]['PaintingID'], $paintings)) {
                            $count++;
                            $added++; ?>
                            <a class="likeEra" href="single-painting.php?id=<?= $yearData[$i]['PaintingID'] ?>">
                                <img src="images/paintings/square-medium/<?= $yearData[$i]['ImageFileName'] ?>.jpg" alt="<?= $yearData[$i]['Title'] ?>">
                            </a>
                        <?php
                            $paintings[] = $yearData[$i]['PaintingID'];
                        }
                    }
                }

                if ($count < 12) {
                    $artistData = $artistGate->getAll();
                    for ($i = 0; $count < 12; $i++, $count++) { ?>
                        <a class="fill" href="single-painting.php?id=<?= $artistData[$i]['PaintingID'] ?>">
                            <img src="images/paintings/square-medium/<?= $artistData[$i]['ImageFileName'] ?>.jpg" alt="<?= $artistData[$i]['Title'] ?>">
                        </a>
                    <?php }
                }
            } else {
                try {
                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                    $artistGate = new PaintingDB($conn);
                    $artistData = $artistGate->getAll();
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