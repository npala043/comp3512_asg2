<!-- Nahuel is working on this -->

<?php

require_once 'config.inc.php';
require_once 'asg2-db-classes.inc.php';

session_start();
// do we have a favourites array already?
if (!isset($_SESSION["favourites"])) {
    // Doesn't exist, so init one
    $_SESSION["favourites"] = [];
}

// retrieve any existing favourites
$fav = $_SESSION["favourites"];

// add passed painting info to the array
if (isset($_GET['id']) && isset($_GET['title']) && isset($_GET['filename'])) {

    $fav[] = array(
        "id" => $_GET['id'],
        "title" => $_GET['title'],
        "filename" => $_GET['filename']
    );

    // re-save modified array back to session state
    $_SESSION["favourites"] = $fav;
} else {
    // some sort of error message?
}

// redirect back to the requesting page
header("Location:" . $_SERVER["HTTP_REFERER"]);
?>