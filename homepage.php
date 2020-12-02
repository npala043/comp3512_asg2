<?php

if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
    $msg = "<h2>Welcome!</h2>";
} else {
    $msg = "<h2>Please Login</h2>";
}

?>

<html lang="en">
    <head>
        <title>Assignment 2</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/homepage.css">
    </head>
    
    <body>
        <?= $msg; ?>
    </body>
</html>