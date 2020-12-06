<?php

function formIsFilled()
{
    if (isset($_GET['title']) || isset($_GET['artist']) || isset($_GET['gallery']) || isset($_GET['before']) || isset($_GET['after']) || isset($_GET['between-before']) || isset($_GET['between-after'])) {
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
    $queryString = "";
    foreach ($_GET as $key => $value) {
        if ($key != 'sort') {
            $queryString = $queryString . "$key=$value&";
        }
    }
    return "browse-paintings.php?sort=$sortCategory&" . $queryString;
}

function createFilter($title, $artist, $gallery, $before, $after, $connection)
{

    $firstFilter = true;
    $filter = "";

    if ($title) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " Title LIKE '%" . $title . "%'";
    }

    if ($artist) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " Paintings.ArtistID=" . $artist;
    }

    if ($gallery) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " Paintings.GalleryID=" . $gallery;
    }

    if ($before) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " YearOfWork < " . $before;
    }

    if ($after) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " YearOfWork > " . $after;
    }

    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->createFilterList($filter);
    generateTable($list);
}
