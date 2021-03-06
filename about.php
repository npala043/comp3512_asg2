<?php

require_once 'includes/config.inc.php';
include 'includes/asg2-db-classes.inc.php';
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
                Mount Royal University
                Randy Connolly
                Fall 2020
            </p>
        </div>
        <div id="description">
            <h3>Brief Description</h3>
            <p>This is a multi-page website that utilizes HTML, CSS, MySQL, JavaScript and PHP to facilitate its function. The functionality of the website is instructed within the Assignment 2 pdf.
                The website allows a user to sign into the website to view their own homepage. From there, the user is able to browse galleries and paintings throughout the world.
                They are also able to add paintings to their favorite list for later viewing. Once they are done, the user is able to log out.</p>
        </div>
        <div id="technology">
            <h3>Technologies Used</h3>
            <p>HTML, CSS, JavaScript, PHP, MySQL, and JSON</p>
        </div>
        <div id="members">
            <h3>Group Members</h3>
            <p>
                Hatoon Al-Nakshabandi <a href="https://github.com/halna399">(Git User: halna399)</a><br>
                Anthony Dang <a href="https://github.com/AnthonyDang307">(Git User: AnthonyDang307)</a><br>
                Darren Lam <a href="https://github.com/dlam071">(Git User: dlam071)</a><br>
                Mason Lee <a href="https://github.com/mlee950">(Git User: mlee950)</a><br>
                Nahuel Paladino <a href="https://github.com/npala043">(Git User: npala043)</a><br>

            </p>
            <a href="https://github.com/npala043/comp3512_asg2" id="groupButton">Group Repository</a>
        </div>

        <div id="external">
            <h3>External Sources</h3>
            <ul>
                <li><a href="https://www.w3schools.com/howto/howto_js_tabs.asp"> Single Paintings Tabs - (w3schools.com - How TO - Tabs)</a></li>
                <li><a href="https://itnext.io/how-to-build-a-responsive-navbar-using-flexbox-and-javascript-eb0af24f19bf">Responsive Nav Bar - (itnext.io - How to Build a Responsive Navigation Bar using CSS Flexbox and Javascript)</a></li>
                <li><a href="https://www.w3schools.com/howto/howto_css_custom_scrollbar.asp">Custom Scroll Bar - (w3schools.com - How TO - Custom Scrollbar)</a></li>
                <li><a href="https://www.media3.hw-static.com/media/2017/12/wenn_owenwilson_122917-1800x1200.jpg">Logo Image - (media3.hw)</a></li>
                <li><a href="https://www.factinate.com/wp-content/uploads/2018/06/owen-wilson-widescreen-wallpaper-54595-56329-hd-wallpapers.jpg">Hero Image - (factinate.com)</a></li>
                <li><a href="https://c7.uihere.com/files/145/68/895/5bbc22bc7e518-thumb.jpg">Favorites Image - (c7.uihere.com)</a></li>
            </ul>
        </div>
    </div>
</body>

</html>