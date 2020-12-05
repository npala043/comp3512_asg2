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

function displayByArtist($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByArtist();
    generateTable($list);
}

function displayByYear($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByYear();
    generateTable($list);
}

function displayByTitle($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByTitle();
    generateTable($list);
}

function generateTable($list)
{
    foreach ($list as $row) { ?>
        <tr class="tempTr">
            <td class="img">
                <img src='images/paintings/square-medium/<?= $row['ImageFileName'] ?>.jpg' />
            </td>
            <td class="artist"><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
            <td class="title" id="<?= $row['ImageFileName'] ?>" style="text-align:center;"><?= $row['Title'] ?></td>
            <td class="year"><?= $row['YearOfWork'] ?></td>
            <td><button><a href="add-to-favorites.php?id=<?= $row['PaintingID'] ?>&title=<?= $row['Title'] ?>&filename=<?= $row['ImageFileName'] ?>">Add to Favorites</a></button></td>
            <td><button><a href="single-painting.php?id=<?= $row['PaintingID'] ?>">View</a></button></td>
        </tr>
<?php }
}

function generateQueryString($sortCategory)
{
    return "browse-paintings.php?sort=$sortCategory&title=$_GET[title]&";
}
