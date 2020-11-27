<?php
require_once 'config.inc.php';
require_once 'asg2-db-classes.inc.php';

// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new GalleryDB($conn);

    if (!$_GET) {
        // If no query, get all galleries
        $data = $gateway->getAll();
    } else if (isCorrectQueryStringInfo("id")) {
        // If id supplied, return single painting info
        $data = $gateway->getPainting($_GET['id']);
    } else {
        // If query other than 'id' supplied, throw error
        throw new Exception("Invalid query");
    }

    echo json_encode($data, JSON_NUMERIC_CHECK);
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
