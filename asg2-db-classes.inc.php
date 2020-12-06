<?php
class DatabaseHelper
{
    /* Returns a connection object to a database */
    public static function createConnection($values = array())
    {
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
        return $pdo;
    }

    /*
 Runs the specified SQL query using the passed connection and
 the passed array of parameters (null if none)
*/
    public static function runQuery(
        $connection,
        $sql,
        $parameters = array()
    ) {
        // Ensure parameters are in an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }
        $statement = null;
        if (count($parameters) > 0) {
            // Use a prepared statement if parameters
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if (!$executedOk) throw new PDOException;
        } else {
            // Execute a normal query
            $statement = $connection->query($sql);
            if (!$statement) throw new PDOException;
        }
        return $statement;
    }
}

class ArtistDB
{
    private static $baseSQL = "SELECT * FROM Artists ORDER BY LastName";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class PaintingDB
{
    private static $baseSQL = "SELECT PaintingID, Paintings.ArtistID,
    FirstName, LastName, Paintings.GalleryID, GalleryName, YearOfWork, Paintings.Description,
    Medium, Width, Height, CopyrightText, WikiLink, Paintings.MuseumLink, JsonAnnotations, 
    ImageFileName, Title, Excerpt FROM Galleries INNER JOIN (Artists
    INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON
    Galleries.GalleryID = Paintings.GalleryID ";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    public function getAllForArtist($artistID)
    {
        $sql = self::$baseSQL . " WHERE Paintings.ArtistID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($artistID)
        );
        return $statement->fetchAll();
    }
    public function getAllForGallery($galleryID)
    {
        $sql = self::$baseSQL . " WHERE Paintings.GalleryID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($galleryID)
        );
        return $statement->fetchAll();
    }
    public function getAllSortByArtist()
    {
        $sql = self::$baseSQL . " ORDER BY FirstName";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            null
        );
        return $statement->fetchAll();
    }
    public function getAllSortByTitle()
    {
        $sql = self::$baseSQL . " ORDER BY Title";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            null
        );
        return $statement->fetchAll();
    }
    public function getAllSortByYear()
    {
        $sql = self::$baseSQL . " ORDER BY YearOfWork";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            null
        );
        return $statement->fetchAll();
    }
    public function createFilterList($filter)
    {
        $sql = self::$baseSQL . $filter;

        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            null
        );
        return $statement->fetch();
    }
}

class GalleryDB
{
    private static $baseSQL = "SELECT Galleries.GalleryID, GalleryName, GalleryNativeName, 
    GalleryCity, GalleryAddress, GalleryCountry, Latitude, Longitude, GalleryWebSite, 
    GooglePlaceID FROM Galleries";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL . " ORDER BY GalleryName";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getGallery($galleryID)
    {
        $sql = self::$baseSQL . " WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($galleryID)
        );
        return $statement->fetchAll();
    }
}

class CustomerLogonDB
{
    private static $baseSQL = "SELECT CustomerID, UserName, Pass, Salt, Password_sha256
    DateJoined, DateLastModified FROM customerlogon";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getByUserName($user)
    {
        $sql = self::$baseSQL . " WHERE UserName=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($user)
        );
        return $statement->fetch();
    }
    public function updatePassword($id, $pass, $shaPass)
    { // Not sure this is needed

    }
}

class CustomersDB
{
    private static $baseSQL = "SELECT CustomerID, FirstName, LastName, Address, City, Region, Country, 
    Postal, Phone, Email, Privacy FROM customers";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getByCustomerID($id)
    {
        $sql = self::$baseSQL . " WHERE CustomerID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($id)
        );
        return $statement->fetch();
    }
}
