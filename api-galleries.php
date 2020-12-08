<?php
require_once 'includes/config.inc.php';
require_once 'includes/asg2-db-classes.inc.php';

// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new GalleryDB($conn);

    if (!$_GET) {
        // If no query, get all galleries
        $galleries = $gateway->getAll();
    } else if (isCorrectQueryStringInfo("id")) {
        // If id supplied, return single gallery info
        $galleries = $gateway->getGallery($_GET['id']);
    } else {
        // If query other than 'id' supplied, display error message
        $galleries = ["message" => "gallery doesnt exist"];
    }

    echo json_encode($galleries, JSON_NUMERIC_CHECK);
    $conn = null;
} catch (Exception $e) {
    die($e->getMessage());
}

function isCorrectQueryStringInfo($param)
{
    return isset($_GET[$param]) && !empty($_GET[$param]);
}
