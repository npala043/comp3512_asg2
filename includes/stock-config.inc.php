
<?php
// set error reporting on to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// you may need to change these for your own environment
$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'], '/');
define('DBCONNECTION', "mysql:host=$hostname;dbname=$database");
define('DBUSER', $username);
define('DBPASS', $password);

// auto load all classes so we don't have to explicitly include them
spl_autoload_register(function ($class) {
  $file = 'lib/' . $class . '.class.php';
  if (file_exists($file))
    include $file;
});

// connect to the database
$connection = DatabaseHelper::createConnection(array(DBCONNECTION, DBUSER, DBPASS));

// we can then pass this connection variable to other classes that need it

?>
