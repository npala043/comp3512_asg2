<?php

// This isn't in the includes folder because we kept getting a "file doesn't exist" error when including the add-to-favorites.php page, even with the seemingly correct path (../add-to-favorites.php)

include_once "add-to-favorites.php";

// Checks to see if any field within the form has been filled out.
function formIsFilled()
{
    if (isset($_GET['title']) || isset($_GET['artist']) || isset($_GET['gallery']) || isset($_GET['before']) || isset($_GET['after']) || isset($_GET['between-before']) || isset($_GET['between-after'])) {
        return true;
    } else {
        return false;
    }
}

// Makes connection to PaintingDB and calls a method to display by Artist
function displayByArtist($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByArtist();
    $connection = null;
    generateTable($list);
}

// Makes connection to PaintingDB and calls a method to display by Year
function displayByYear($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByYear();
    $connection = null;
    generateTable($list);
}

// Makes connection to PaintingDB and calls a method to display by Title
function displayByTitle($connection)
{
    $paintingGateway = new PaintingDB($connection);
    $list = $paintingGateway->getAllSortByTitle();
    $connection = null;
    generateTable($list);
}

// Helper function for the three methods above to create the layout for the table.
function generateTable($list)
{
    foreach ($list as $row) { ?>
        <tr class="tempTr">
            <td class="img">
                <a href="single-painting.php?id=<?= $row['PaintingID'] ?>">
                    <img src='images/paintings/square-medium/<?= $row['ImageFileName'] ?>.jpg' />
                </a>
            </td>
            <td class="artist"><?= formatName($row) ?></td>
            <td class="title" id="<?= $row['ImageFileName'] ?>">
                <a href="single-painting.php?id=<?= $row['PaintingID'] ?>"><?= $row['Title'] ?></a>
            </td>
            <td class="year"><?= $row['YearOfWork'] ?></td>
            <td>
                <!-- Provides information when user clicks on add to favorites -->
                <form method="post">
                    <input type="hidden" name="addToFavorites">
                    <input type="hidden" name="PaintingID" value="<?= $row['PaintingID'] ?>">
                    <input type="hidden" name="ArtistID" value="<?= $row['ArtistID'] ?>">
                    <input type="hidden" name="Title" value="<?= $row['Title'] ?>">
                    <input type="hidden" name="ImageFileName" value="<?= $row['ImageFileName'] ?>">
                    <input type="hidden" name="YearOfWork" value="<?= $row['YearOfWork'] ?>">
                    <input type="submit" value="Add to Favorites">
                </form>
            </td>
            <td><button><a href="single-painting.php?id=<?= $row['PaintingID'] ?>">View</a></button></td>
        </tr>
<?php }
}

// Helper function to neatly format an artist's name depending if they only have a first name, last name or both
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

// Helper method to preserve the current querystring while adding on another field 
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

// Creates the necessary SQL to run on the table dependent on what the user has inputted
function createFilter($title, $artist, $gallery, $before, $after, $sort, $connection)
{

    $firstFilter = true; // Checks to see if it is the first filter that was used, if so, add the WHERE keyword to the SQL then set it to false afterwards
    $filter = "";

    // Checks if title is empty
    if ($title) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " Title LIKE '%" . $title . "%'";
    }

    // Checks if artist is empty
    if ($artist) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " Paintings.ArtistID=" . $artist;
    }

    // Checks if gallery is empty
    if ($gallery) {
        if ($firstFilter) {
            $filter = $filter . "WHERE";
            $firstFilter = false;
        } else {
            $filter = $filter . " AND ";
        }
        $filter = $filter . " Paintings.GalleryID=" . $gallery;
    }

    // Checks if a radio button was clicked
    if (isset($_GET['time-period'])) {
        // Checks if the radio button that was clicked was the before button
        if ($_GET['time-period'] == 'before') {
            // Checks if the before field is empty
            if ($before) {
                if ($firstFilter) {
                    $filter = $filter . "WHERE";
                    $firstFilter = false;
                } else {
                    $filter = $filter . " AND ";
                }
                $filter = $filter . " YearOfWork < " . $before;
            }
            // Checks if the radio button that was clicked was the after button
        } else if ($_GET['time-period'] == 'after') {
            // Checks if the after field is empty
            if ($after) {
                if ($firstFilter) {
                    $filter = $filter . "WHERE";
                    $firstFilter = false;
                } else {
                    $filter = $filter . " AND ";
                }
                $filter = $filter . " YearOfWork > " . $after;
            }
            // Checks if the radio button that was clicked was the between button
        } else if ($_GET['time-period'] == 'between') {
            // Checks if both the before AND after field is empty
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


    // If a sort has been specified, order the SQL by that sort category
    if ($sort) {
        $filter = $filter . " ORDER BY " . $sort;
    } else {
        $filter = $filter . " ORDER BY YearOfWork";
    }

    $paintingGateway = new PaintingDB($connection); // Make connection to PaintingDB
    $list = $paintingGateway->createFilterList($filter); // Pass the newly created SQL to the DB to run a method that will return the correct paintings
    $connection = null; // Close the connection
    generateTable($list); // Create the table with the data received from the database
}
