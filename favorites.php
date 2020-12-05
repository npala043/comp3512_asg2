<!-- Nahuel will work on this :) -->

<?php
session_start();
// if (!isset($_SESSION["favourites"])) {
//     $fav = [];
// } else {
//     $fav = $_SESSION["favourites"];
// }

// For testing
$fav = [
    ["id" => 1, "title" => "first painting", "filename" => "001020"],
    ["id" => 2, "title" => "second painting", "filename" => "001050"],
    ["id" => 3, "title" => "third painting", "filename" => "001060"]
];

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
                <th>Title</th>
            </tr>
            <?php
            if (empty($fav)) {
                echo "No favourites to display!";
            } else {
                foreach ($fav as $f) { ?>
                    <tr>
                        <td>
                            <img src="images/paintings/square-medium/<?= $f['filename'] ?>.jpg" alt="<?= $f['title'] ?>">
                        </td> <!-- Painting Thumbnail -->
                        <td><?= $f['title'] ?></td> <!-- Title -->
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
</body>

</html>