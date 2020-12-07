<?php

// set error reporting on to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

/* Old db connection info */
define('DBHOST', 'ixnzh1cxch6rtdrx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com');
define('DBNAME', 'yg5mav5uvc4wjekq');
define('DBUSER', 'q4mc92l607e1seit');
define('DBPASS', 'wluibgz1btfzeal4');
// define('DBCONNSTRING', 'sqlite:./databases/art.db'); // <-- SQLite
define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;"); // <-- MySQL
