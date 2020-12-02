<!-- Nahuel will work on this :) -->

<?php
require_once "config.inc.php";
require_once "asg2-db-classes.inc.php";

session_start();
if (!isset($_SESSION["favourites"])) {
    $fav = [];
} else {
    $fav = $_SESSION["favourites"];
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Favorites</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <table>

        </table>
    </div>
</body>

</html>