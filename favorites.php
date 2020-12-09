<!-- Nahuel -->

<?php
session_start();

// If requested through post (which happens when removing paintings from favourites),
// remove painting from $_SESSION['favourites'] with matching ID (or all if selected)
if (removalDataPresent()) {
    $remove = $_POST['id'];
    unset($_POST['id']);
    if ($remove == "all") {
        unset($_SESSION['favourites']);
    } else {
        $fav = $_SESSION['favourites'];
        for ($i = 0; $i < count($fav); $i++) { // loop through each painting array in favourites
            if ($remove == $fav[$i]['id']) {
                unset($fav[$i]);
                $_SESSION['favourites'] = array_values($fav);
                break;
            }
        }
    }
}

function removalDataPresent()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_SESSION['favourites']);
}

/* Format of $_SESSION['favourites'] */
// $_SESSION['favourites'] = 
//     [0] => {
//         [id] => __,
//         [title] => __,
//         [filename] => __
//     },
//     [1] => {
//         [id] => __,
//         [title] => __,
//         [filename] => __
//     ,} etc.

// If no favourites in session, create one
if (!isset($_SESSION["favourites"])) {
    $fav = [];
} else {
    //otherwise grab and store it
    $fav = $_SESSION["favourites"];
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Favorites</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/favorites.css">
    <script src="js/navbar.js"></script>
</head>

<body>
    <?php include("header.php"); ?>
    <div>
        <form action="favorites.php" method="post">
            <table>
                <tr>
                    <th></th> <!-- Remove from favs button -->
                    <th></th> <!-- Painting Thumbnail -->
                    <th>Title</th>
                </tr>
                <?php
                if (empty($fav)) { ?>
                    <!-- If no favourites, display placeholder img and msg -->
                    <tr>
                        <td></td>
                        <td><img src="images/nahuel/owenwhat.png" alt="shrug"></td>
                        <td>No favourites here</td>
                    </tr>
                    <?php } else {
                    foreach ($fav as $f) { ?>
                        <tr>
                            <!-- Removal checkbox -->
                            <td><input type="radio" name="id" value=<?= $f['id'] ?>></td>
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
            <!-- Submits chosen painting to remove -->
            <input type="submit" value="Remove">
            <!-- Removes all paintings from favourites -->
            <button type="submit" name="id" value="all">Remove All</button>
        </form>
    </div>
</body>

</html>