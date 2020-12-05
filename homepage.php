<?php

require_once 'config.inc.php';
include 'asg2-db-classes.inc.php';

if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
    session_start();
    $displayIn = "block";
    $displayOut = "hidden";
    $searchPos = "";
} else {
    $displayIn = "hidden";
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
        }

        input {
            width: 390px;
            height: 60px;
            font-size: 26px;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
        }
    </style>

</head>

<body>
    <section class="logout" style="display:<?= $displayOut ?>;">
        <div>
            <button class="login"> Login </button>
            <button class="join"> Join </button>
        </div>
        <div>
            <input type="text" name="title" placeholder="SEARCH BOX FOR Paintings">
        </div>
    </section>

    <section class="login" style="display:<?= $displayIn ?>;">

    </section>
</body>

</html>