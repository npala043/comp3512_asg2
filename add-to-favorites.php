<!-- Nahuel is working on this -->

<?php
session_start();
// do we have a favourites array already?
if (!isset($_SESSION["favourites"])) {
    // Doesn't exist, so init one
    $_SESSION["favourites"] = [];
}

// retrieve any existing favourites
$fav = $_SESSION["favourites"];

// add passed painting id to the array
if ($_GET && isset($_GET['id'])) {
    $fav[] = $_GET["id"];
    // re-save modified array back to session state
    $_SESSION["favourites"] = $fav;
}

// redirect back to the requesting page
header("Location:" . $_SERVER["HTTP_REFERRER"]);
?>