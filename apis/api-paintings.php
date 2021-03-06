<?php
require_once '../includes/config.inc.php';
require_once '../includes/asg2-db-classes.inc.php';

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
        $paintings = ["message" => "gallery " . $_GET['gallery'] . " doesnt exist"];
    }

    $conn = null;

    echo json_encode($paintings);
} catch (Exception $e) {
    die($e->getMessage());
}

function isCorrectQueryStringInfo($param)
{
    return isset($_GET[$param]) && !empty($_GET[$param]);
}
