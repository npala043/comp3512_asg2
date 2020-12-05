<!-- Nahuel will work on this :) -->

<?php
session_start();

// If requested through post (which happens when removing paintings from favourites),
// remove paintings from $_SESSION['favourites'] with matching IDs
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_SESSION['favourites'])) {
    $remove = $_POST['id'];
    if ($remove == "all") {
        unset($_SESSION['favourites']);
    } else {
        $fav = $_SESSION['favourites'];
        foreach ($remove as $r) {
            foreach ($fav as $f) {
                if ($r == $f['id']) {
                    unset($f);
                    break;
                }
            }
        }
    }
}

if (!isset($_SESSION["favourites"])) {
    $fav = [];
} else {
    $fav = $_SESSION["favourites"];
}

// // For testing
// $fav = [
//     ["id" => 5, "title" => "first painting", "filename" => "001020"],
//     ["id" => 7, "title" => "second painting", "filename" => "001050"],
//     ["id" => 8, "title" => "third painting", "filename" => "001060"]
// ];

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
        <form action="favorites.php" method="post">
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
                                <!-- Painting Thumbnail -->
                                <a href="single-painting.php?id=<?= $f['id'] ?>">
                                    <img src="images/paintings/square-medium/<?= $f['filename'] ?>.jpg" alt="<?= $f['title'] ?>">
                                </a>
                            </td>
                            <td>
                                <!-- Title -->
                                <a href="single-painting.php?id=<?= $f['id'] ?>">
                                    <?= $f['title'] ?>
                                </a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </table>
        </form>
    </div>
</body>

</html>