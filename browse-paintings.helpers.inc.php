<?php

function filterIsSet()
{
    if (isset($_GET['title']) || isset($_GET['artist']) || isset($_GET['gallery']) || isset($_GET['time-period'])) {
        return true;
    } else {
        return false;
    }
}

function submitNothing()
{
    if ($_GET['title'] == "" && $_GET['before'] == "" && $_GET['after'] == "" && $_GET['between-before'] == "" && $_GET['between-after'] == "") {
        return true;
    } else {
        return false;
    }
}

function displayFilteredPaintings($connection)
{
    $paintingGateway = new PaintingDB($connection);
}

function displayDefaultPaintings($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAll();
    foreach ($list as $row) { ?>
        <tr class="tempTr">
            <td class="img">
                <!-- Gotta fix -->
                <?= $row['ImageFileName'] ?>
            </td>
            <td class="artist"><?= $row['ArtistID'] ?></td>
            <td class="title" id="<?= $row['ImageFileName'] ?>" style="text-align:center;"><?= $row['Title'] ?></td>
            <td class="year"><?= $row['YearOfWork'] ?></td>
            <td><button>Add to Favorites</button></td>
            <td><button>View</button></td>
        </tr>
<?php }

    function generateQueryString($sortCategory)
    {
        return "browse-paintings.php?sort=$sortCategory&title=$_GET[title]&";
    }
}
