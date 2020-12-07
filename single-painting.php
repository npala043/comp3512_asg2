<!-- Hatoon will work on this :) -->

<?php

require_once 'config.inc.php';
include 'asg2-db-classes.inc.php';
session_start();

try {
    $id = $_GET['id'];
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new PaintingDB($conn);
    $paintings = $gateway->getAll();

    $painting = "";
    $json = "";

    foreach ($paintings as $row) {
        if ($id == $row['PaintingID']) {
            $painting = $row;
            $json = json_decode($row['JsonAnnotations'], true);
        }
    }
} catch (Exception $e) {
    die($e->getMessage());
}




?>


<html>

<head>
    <title></title>
    <meta charset=utf-8>
    <script src="js\single-painting.js"></script>
    <script src="js/navbar.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/single-painting.css">
</head>

<body>

    <?php include('header.php') ?>


    <main>
        <div id="imgBox">
            <img src="images\paintings\square\<?= $painting['ImageFileName'] ?>.jpg" alt="<?= $painting['Title'] ?>" width="500px">
        </div>

        <section>
            <h1><?= $painting['Title'] ?></h1>
            <h3>
                <?php

                if (is_null($painting['FirstName'])) {
                    echo $painting['LastName'];
                } else if (is_null($painting['LastName'])) {
                    echo $painting['FirstName'];
                } else {
                    echo $painting['FirstName'] .  " " . $painting['LastName'];
                }

                ?>
            </h3>
            <h3><?= $painting['GalleryName'] ?>, <?= $painting['YearOfWork'] ?></h3>
            <button id="favsButton"><a href="add-to-favorites.php?id=<?= $painting['PaintingID'] ?>&artistid=<?= $row['ArtistID'] ?>&title=<?= $painting['Title'] ?>&filename=<?= $painting['ImageFileName'] ?>&yearofwork=<?= $painting['YearOfWork'] ?>"> Add to Favourites</a></button>
            <?php

            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>

            <button class="tab desctab"> Description </button>
            <button class="tab detailstab"> Details </button>
            <button class="tab colorstab"> Colors </button>

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