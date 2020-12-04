<!-- Nahuel will work on this :) -->

<?php
session_start();
// if (!isset($_SESSION["favourites"])) { // manually added paintings for testing
//     $fav = [];
// } else {
//     $fav = $_SESSION["favourites"];
// }

// For testing
$fav = [];
$fav[] = 5;
$fav[] = 7;
$fav[] = 8;

$paintings = file_get_contents("http://localhost/web2/f2020-assign2-master/api-paintings.php");
$allPaintings = json_decode($paintings, true);

foreach ($allPaintings as $p) {
    if ($p['PaintingID'] == 0) {
    }
}
// For testing

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
            <tr>
                <th></th> <!-- Painting Thumbnail -->
                <th>Artist</th>
                <th>Title</th>
                <th>Year</th>
            </tr>
            <?php
            if (empty($fav)) {
                echo "No favourites to display!";
            } else {
                foreach ($fav as $f) { ?>
                    <tr>
                        <td></td> <!-- Painting Thumbnail -->
                        <td><?= $f ?></td> <!-- Artist -->
                        <td></td> <!-- Title -->
                        <td></td> <!-- Year -->
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
</body>

</html>