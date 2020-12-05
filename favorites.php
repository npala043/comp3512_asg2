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
                if (empty($fav)) { ?>
                    <tr>
                        <td><img src="images/nahuel/shrug.png" alt="shrug"></td>
                        <td>No favourites to display!</td>
                    </tr>
                    <?php } else {
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