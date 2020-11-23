<?php
define('DBHOST', 'localhost');
define('DBNAME', 'art');
define('DBUSER', 'root');
define('DBPASS', '');

// define('DBCONNSTRING', 'sqlite:./databases/art.db'); // <-- SQLite
define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;"); // <-- MySQL
