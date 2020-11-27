<?php
require_once 'config.inc.php';
require_once 'asg2-db-classes.inc.php';

// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new PaintingDB($conn);

    if (!$_GET) {
        // If no query, get all paintings
        $paintings = $gateway->getAll();
    } else if (isCorrectQueryStringInfo("gallery")) {
        // If gallery id supplied, return all paintings from that gallery
        $paintings = $gateway->getAllForGallery($_GET["gallery"]);
    } else {
        // If query other than 'gallery' supplied, display error message
        $paintings = '{"message": "gallery does not exist"}';
    }

    echo json_encode($paintings, JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    die($e->getMessage());
}

function isCorrectQueryStringInfo($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    } else {
        return false;
    }
}
