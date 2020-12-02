<!-- Hatoon will work on this :) -->

<?php

require_once 'config.inc.php';
include 'asg2-db-classes.inc.php';


try {
    $id = $_GET['id'];
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new PaintingDB($conn);
    $paintings = $gateway->getAll();
    $painting = "";
    foreach ($paintings as $row) {
        if ($id == $row['PaintingID']) {
            $painting = $row;
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
    <style>
        /* will be using this until i can get the external file to work */
        main {
            background-color: lightblue;
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 10px;
        }


        #favsButton {
            position: absolute;
            right: 100px;
            top: 50px;
        }

        /* #description {
            width: 50%;

        } */

        /* div.tab {
            border: lightskyblue 1px solid;
            width: 50%;
            padding: 10px;

        } */

        .tab {
            overflow: hidden;
            border: 1px solid lightskyblue;
            background-color: powderblue;
        }

         .tab {
            background-color: whitesmoke;
            float: center;
            border-radius: 5px;
            outline: none;
            padding: 16px;
            font-size: 16px;
            

        }
        

        .tab button.active {
            background-color: steelblue;
        }

        .tabContent {
            display: none;
            padding: 6px 12px;
            border: 1px solid lightskyblue;
            background-color: powderblue;
            border-top: none;
        }
/* 
        #description,
        #details,
        #colors {
            display: none;
        } */
    </style>


    <!-- external link is not working for some reason <link rel="stlyesheet" href="css\single-painting.css" > -->
</head>

<body>
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
            <button id="favsButton">Add To Favourites</button>

            <button class="tab desctab"> Description </button>
            <button class="tab detailstab"> Details </button>
            <button class="tab colorstab"> Colors </button>

            <div id="description" class="tabContent">
                <h5>Description </h5>
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
                <h5>Details </h5>
                <p>Meduim: <?= $painting['Medium'] ?></p>
                <p>Width: <?= $painting['Width'] ?></p>
                <p>Height: <?= $painting['Height'] ?></p>
                <p>Copyright Text: <?= $painting['CopyrightText'] ?></p>
                <?php
                //if the wikilink is null then don't add the markup for it 
                if (!is_null($painting['WikiLink'])) {
                    echo "<a href=" .  $painting['WikiLink'] . ">wikiLink</a>";
                }
                ?>

                <!-- <a href="<?= $painting['WikiLink'] ?>">wikiLink</a> -->
                <a href="<?= $painting['MuseumLink'] ?>">Museum Link</a>
            </div>
            <div id="colors" class="tabContent">
                <h5> Colors </h5>
                <img src="" alt="">
                <p>Hex Value:</p>
                <p>Color Name:</p>
            </div>


        </section>
    </main>
</body>

</html>