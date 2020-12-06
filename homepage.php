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
                $artist = $favs[0]['artistid'];

                try {
                    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                    $paintGate = new PaintingDB($conn);
                    $paintData = $paintGate->getAllForArtist($artist);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
                $count = 0;
                for ($i = 0; $i < count($paintData) && $i < 6; $i++) {
                    $count++; ?>
                    <a href="single-painting.php?id=<?= $paintData[$i]['PaintingID'] ?>">
                        <img src="images/paintings/square-medium/<?= $paintData[$i]['ImageFileName'] ?>.jpg" alt="<?= $paintData[$i]['Title'] ?>">
                    </a>
            <?php }
            }
            ?>
        </div>
    </section>
</body>

</html>