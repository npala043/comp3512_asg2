<!-- Nahuel is working on this -->

<?php
require_once 'config.inc.php';
require_once 'asg2-db-classes.inc.php';

session_start();
$msg = "";

if (loginDataPresent()) {
    try {
        $connection = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $gate = new CustomerLoginDB($connection);
        $data = $gate->getByUserName($_POST['email']);
        $connection = null;

        if (isset($data['pass'])) { // if matching user was found, does pass match?
            if (password_verify($_POST['pass'], $data['pass'])) { // uses bcrypt

            }
        } else {
            $msg = "User not found";
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function loginDataPresent()
{
    return isset($_POST['email']) && isset($_POST['pass']) ? true : false;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("header.php"); ?>
    <div>
        <h2>Login</h2>
        <p><?= $msg ?></p>
        <form action="login.php" method="post">
            <label for="email">Email</label>
            <input type="email" name="email">

            <label for="pass">Password</label>
            <input type="password" name="pass">

            <input type="submit" value="Login">
        </form>
    </div>
</body>