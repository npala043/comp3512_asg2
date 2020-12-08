<?php

require_once 'config.inc.php';
include 'asg2-db-classes.inc.php';
session_start();

?>

<html lang="en">

<head>
    <title>Assignment 2</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/about.css">
    <script src="js/navbar.js"></script>
</head>

<body>
    <header>
        <?php include("header.php"); ?>
    </header>
    <div id="info">
        <h2>Assignment 2</h2>

        <div id="intro">
            <p>
                COMP-3512
                Mount Royal Univesity
                Randy Connolly
                Fall 2020
            </p>
        </div>
        <div id="description">
            <h3>Brief Description</h3>
            <p>This is a multi page website that will utilize HTML, CSS, MySQL, JavaScript and PHP to facilitate its function. The functionality of the website is instructed within the Assignment 2 pdf.
                The website allows a user to sign into the website to view their own homepage. From there, the user will be able to browse through galleries and paintings throughout the world.
                They are also able to add paintings to their favorite list for later use. Once they are done, the user is able to log out.</p>
        </div>
        <div id="technology">
            <h3>Technologies Used</h3>
            <p>???</p>
        </div>
        <div id="members">
            <h3>Group Members</h3>
            <p>
                Hatoon Al-Nakshabandi <a href="https://github.com/halna399">(Git Repository: halna399)</a><br>
                Anthony Dang <a href="https://github.com/AnthonyDang307">(Git Repository: AnthonyDang307)</a><br>
                Darren Lam <a href="https://github.com/dlam071">(Git Repository: dlam071)</a><br>
                Mason Lee <a href="https://github.com/mlee950">(Git Repository: mlee950)</a><br>
                Nahuel Paladino <a href="https://github.com/npala043">(Git Repository: npala043)</a><br>

            </p>
            <a href="https://github.com/npala043/comp3512_asg2">Group Repository</a>
        </div>

        <div id="external">
            <h3>External Sources</h3>
            <p>
                <a href="https://www.w3schools.com/howto/howto_js_tabs.asp"> Single Paintings Tabs</a><br>
                <a href="https://itnext.io/how-to-build-a-responsive-navbar-using-flexbox-and-javascript-eb0af24f19bf">Responsive Nav Bar</a>
            </p>
        </div>
    </div>
</body>

</html>