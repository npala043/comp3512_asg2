<!-- Nahuel will work on this :) -->

<?php
session_start();
// if (!isset($_SESSION["favourites"])) {
//     $fav = [];
// } else {
//     $fav = $_SESSION["favourites"];
// }

// For testing
$fav = [5, 7, 8];

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