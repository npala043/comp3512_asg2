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

// check if id, title, and filename are present as querystring
if (isset($_GET['id']) && isset($_GET['title']) && isset($_GET['filename'])) {

    // check if painting already in favourites
    // if yes, save error message to session and redirect back
    foreach ($fav as $f) {
        if (in_array($_GET['id'], $f)) {
            $_SESSION['error'] = "<script>alert('Already added to favourites');</script>";
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit();
        }
    }

    // add painting to array
    $fav[] = array(
        "id" => $_GET['id'],
        "title" => $_GET['title'],
        "filename" => $_GET['filename']
    );

    // re-save modified array back to session state
    $_SESSION["favourites"] = $fav;
} else {
    $_SESSION['error'] =  "<script>alert('Invalid query')</script>";
}

// redirect back to the requesting page
header("Location:" . $_SERVER["HTTP_REFERER"]);
?>