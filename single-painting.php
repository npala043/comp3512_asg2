<!-- Hatoon will work on this :) -->

<?php

require_once 'includes/config.inc.php';
include 'includes/asg2-db-classes.inc.php';
include 'add-to-favorites.php';
session_start();

try {
    $id = $_GET['id'];
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new PaintingDB($conn);
    $paintings = $gateway->getPainting($id);
    $conn = null;
    $painting = "";
    $json = "";

    foreach ($paintings as $row) {
        $painting = $row;
        $json = json_decode($row['JsonAnnotations'], true);
    }
} catch (Exception $e) {
    die($e->getMessage());
}




?>


<html>

<head>
    <title></title>
    <meta charset=utf-8>
    <script src="js/single-painting.js"></script>
    <script src="js/navbar.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/single-painting.css">
</head>

<body>

    <?php include('header.php') ?>


    <main>
        <div>
            <img src="images\paintings\square\<?= $painting['ImageFileName'] ?>.jpg" alt="<?= $painting['Title'] ?>" id="imgBox">
        </div>

        <section>
            <h1><?= $painting['Title'] ?></h1>
            <h4>
                <?php
                // checking if author first name or last name are null
                if (is_null($painting['FirstName'])) {
                    echo $painting['LastName'];
                } else if (is_null($painting['LastName'])) {
                    echo $painting['FirstName'];
                } else {
                    echo $painting['FirstName'] .  " " . $painting['LastName'];
                }
                ?>
            </h4>
            <h4><?= $painting['GalleryName'] ?>, <?= $painting['YearOfWork'] ?></h4>

            <form method="post" id="form">
                <!-- add to favourites form button so we can like to the method in the add-to-favorites php -->
                <input type="hidden" name="addToFavorites">
                <input type="submit" value="Add to Favorites" id="favsButton">
            </form>


            <div>
                <button class="tab desctab"> Description </button>
                <button class="tab detailstab"> Details </button>
                <button class="tab colorstab"> Colors </button>
            </div>

            <?php
            //checks if the favourites button has been pressed
            if (isset($_POST['addToFavorites'])) {
                addToFavorites($painting['PaintingID'], $painting['ArtistID'], $painting['Title'], $painting['ImageFileName'], $painting['YearOfWork']);
            }
            ?>

            <div id="description" class="tabContent">
                <h4>Description </h4>
                <p>
                    <?php
                    if (is_null($painting['Description'])) {
                        echo "N/A";
                    } else {
                        echo $painting['Description'];
                    }

                    ?>
                </p>
            </div>
            <div id="details" class="tabContent">
                <h4>Details </h4>
                <p>Meduim: <?= $painting['Medium'] ?></p>
                <p>Width: <?= $painting['Width'] ?></p>
                <p>Height: <?= $painting['Height'] ?></p>
                <p>Copyright Text: <?= $painting['CopyrightText'] ?></p>
                <?php
                //if the Wikilink is null then don't add the markup for it 
                if (!is_null($painting['WikiLink'])) {
                    echo "<a href=" .  $painting['WikiLink'] . " class='link'>WikiLink</a>";
                }
                ?>
                <a href="<?= $painting['MuseumLink'] ?>" class="link">Museum Link</a>
            </div>
            <div id="colors" class="tabContent">
                <h4> Colors </h4>

                <?php
                foreach ($json['dominantColors'] as  $value) {
                    echo "<span style='background-color:" . $value['web'] . ";'></span>";
                }
                ?>
                <p><b>Hex Value: </b>
                    <?php
                    foreach ($json['dominantColors'] as  $value) {
                        echo $value['web'] . " ";
                    }
                    ?>
                </p>
                <p><b>Color Name: </b><br>
                    <ul>
                        <?php
                        foreach ($json['dominantColors'] as  $value) {
                            echo "<li>" . $value['name'] . '</li>';
                        }
                        ?>
                    </ul>
                </p>
            </div>


        </section>
    </main>
</body>

</html>