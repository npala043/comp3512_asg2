<!-- Nahuel will work on this -->

<?php

session_start();

if (isset($_SESSION['user'])) {
    session_unset();
    header('Location: homepage.php');
}

?>