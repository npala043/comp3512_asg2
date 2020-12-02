<!-- Nahuel is working on this -->

<?php
session_start();
// do we have a favourites array already?
if (isset($_SESSION["favourites"])) {
    // Doesn't exists, so init one
    $_SESSION["favourites"] = [];
}
// retrieve any existing favourites
$fav = $_SESSION["favourites"];
// now add passed product id to the array
$fav[] = $_GET["id"]; // Note: should first ensure the query string, parameter exists
// re-save modified array back to session state
$_SESSION["favourites"] = $fav;
// session is updated ... now what?
// Generally, we will simply redirect back to the page that requested us
header("Location:" . $_SERVER["HTTP_REFERRER"]);
?>