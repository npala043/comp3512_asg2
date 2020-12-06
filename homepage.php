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
        $gate = new CustomersDB($conn);
        $data = $gate->getByCustomerID($_SESSION['user']);
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/homepage.css">

    <style>
        body {
            margin: 0;
            height: 100%;
            overflow: hidden;
        }

        section.logout {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100%;
            overflow: hidden;
            background-image: url("https://wallpapercave.com/wp/wp4158371.jpg");
            opacity: 50%;
            background-position: center;
            background-size: cover;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        button {
            width: 160px;
            height: 60px;
            font-size: 26px;
            border-radius: 5px;
            margin: 10px;
            text-decoration: none;
        }

        button>a {
            text-decoration: none;
            color: inherit;
        }

        input {
            width: 390px;
            height: 60px;
            font-size: 26px;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
        }

        section.login {
            grid-template-columns: 50% 50%;
            grid-template-rows: 20% 30% 50%;
        }

        header {
            grid-column: 1 / span 2;
        }
    </style>

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
        <div class="userInfo">
            <h2>Full Name</h2>
            <p>City, Country</p>
            <?php
            echo print_r($data);
            ?>

        </div>
        <div class="search">
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
        <div class="favorites">
            <h2>Your Favorite Paintings</h2>

            <?php
            if (isset($_SESSION['favourites'])) {
                $favs = $_SESSION['favourites'];
            } else {
                echo "<p>You don't have any favorites yet!</p>";
                echo "<button class='browse'><a href='browse-paintings.php'> Browse Paintings </a></button>";
            }
            ?>
        </div>
        <div class="youMayLike">
            <h2>Paintings You May Like</h2>
        </div>
    </section>
</body>

</html>