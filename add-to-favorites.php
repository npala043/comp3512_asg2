<!-- Nahuel -->

<?php

function addToFavorites($id, $artistid, $title, $filename, $yearofwork)
{
    if (!isset($_SESSION['user'])) {
        return "Please login to access favourites";
    }

    // do we have a favourites array already?
    if (!isset($_SESSION["favourites"])) {
        // Doesn't exist, so init one
        $_SESSION["favourites"] = [];
    }

    // retrieve any existing favourites
    $fav = $_SESSION["favourites"];

    // check if painting already in favourites
    // if yes, save error message to session and redirect back
    foreach ($fav as $f) {
        if (in_array($id, $f)) {
            return "Already added to favourites";
        }
    }
    // add painting to array
    $fav[] = array(
        "id" => $id,
        "artistid" => $artistid,
        "title" => $title,
        "filename" => $filename,
        "yearofwork" => $yearofwork
    );
    // re-save modified array back to session state
    $_SESSION["favourites"] = $fav;
    return "Added to favourites!";
}

?>