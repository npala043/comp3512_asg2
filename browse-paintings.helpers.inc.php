<?php

include_once('add-to-favorites.php');

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
    $connection = null;
    generateTable($list);
}

function displayByYear($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByYear();
    $connection = null;
    generateTable($list);
}

function displayByTitle($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByTitle();
    $connection = null;
    generateTable($list);
}

function generateTable($list)
{
    foreach ($list as $row) { ?>
        <tr class="tempTr">
            <td class="img">
                <img src='images/paintings/square-medium/<?= $row['ImageFileName'] ?>.jpg' />
            </td>
            <td class="artist"><?= formatName($row) ?></td>
            <td class="title" id="<?= $row['ImageFileName'] ?>"><?= $row['Title'] ?></td>
            <td class="year"><?= $row['YearOfWork'] ?></td>
            <td>
                <form>
                    <input type="hidden" name="addToFavorites">
                    <input type="submit" value="Add to Favorites">
                </form>
                <?php
                if (isset($_POST['addToFavorites'])) {
                    addToFavorites($painting['PaintingID'], $painting['ArtistID'], $painting['Title'], $painting['ImageFileName'], $painting['YearOfWork']);
                }
                ?>
            </td>
            <td><button><a href="single-painting.php?id=<?= $row['PaintingID'] ?>">View</a></button></td>
        </tr>
<?php }
}

function formatName($row)
{
    if (is_null($row['FirstName'])) {
        return $row['LastName'];
    } else if (is_null($row['LastName'])) {
        return $row['FirstName'];
    } else {
        return $row['LastName'] .  ", " . $row['FirstName'];
    }
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

function createFilter($title, $artist, $gallery, $before, $after, $sort, $connection)
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

    if (isset($_GET['time-period'])) {
        if ($_GET['time-period'] == 'before') {
            if ($before) {
                if ($firstFilter) {
                    $filter = $filter . "WHERE";
                    $firstFilter = false;
                } else {
                    $filter = $filter . " AND ";
                }
                $filter = $filter . " YearOfWork < " . $before;
            }
        } else if ($_GET['time-period'] == 'after') {
            if ($after) {
                if ($firstFilter) {
                    $filter = $filter . "WHERE";
                    $firstFilter = false;
                } else {
                    $filter = $filter . " AND ";
                }
                $filter = $filter . " YearOfWork > " . $after;
            }
        } else if ($_GET['time-period'] == 'between') {
            if ($_GET['between-before'] && $_GET['between-after']) {
                if ($firstFilter) {
                    $filter = $filter . "WHERE";
                    $firstFilter = false;
                } else {
                    $filter = $filter . " AND ";
                }
                $filter = $filter . " YearOfWork > " . $_GET['between-after'] . " AND " . "YearOfWork < " . $_GET['between-before'];
            }
        }
    }


    if ($sort) {
        $filter = $filter . " ORDER BY " . $sort;
    } else {
        $filter = $filter . " ORDER BY YearOfWork";
    }

    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->createFilterList($filter);
    $connection = null;
    generateTable($list);
}
