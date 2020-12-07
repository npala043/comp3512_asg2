<?php

// set error reporting on to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// $url = getenv('JAWSDB_URL');
// $dbparts = parse_url($url);
// $hostname = $dbparts['host'];
// $username = $dbparts['user'];
// $password = $dbparts['pass'];
// $database = ltrim($dbparts['path'], '/');

/*manually setting because of getenv() error 
(it returns null for some reason, why can't it read?)*/
define('DBUSER', 'q4mc92l607e1seit');
define('DBPASS', 'wluibgz1btfzeal4');
define('DBCONNSTRING', "mysql:host=ixnzh1cxch6rtdrx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=yg5mav5uvc4wjekq;charset=utf8mb4;");

/* Old db connection info */
// define('DBHOST', 'localhost');
// define('DBNAME', 'art');
// define('DBUSER', 'root');
// define('DBPASS', '');
// // define('DBCONNSTRING', 'sqlite:./databases/art.db'); // <-- SQLite
// define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;"); // <-- MySQL
