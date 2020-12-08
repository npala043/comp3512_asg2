<!-- Nahuel -->

<?php
require_once 'config.inc.php';
require_once 'asg2-db-classes.inc.php';

session_start();
$msg = "";

if (loginDataPresent()) {
    try {
        $connection = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $gate = new CustomerLogonDB($connection);
        $data = $gate->getByUserName($_POST['email']);
        $connection = null;
        if (isset($data['Pass'])) {
            // if matching user was found, does pass match?
            if (password_verify($_POST['pass'], $data['Pass'])) { // uses bcrypt
                $_SESSION['user'] = $data['CustomerID'];
                header("Location: homepage.php");
                exit();
            } else {
                $msg = "Incorrect password";
            }
        } else {
            // No matching user was found, return error
            $msg = "User not found";
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function loginDataPresent()
{
    return isset($_POST['email']) && isset($_POST['pass']);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/navbar.js"></script>
</head>

<body>
    <?php include("header.php"); ?>
    <div>
        <p><?= $msg ?></p>
        <form action="login.php" method="post">
            <table>
                <tr>
                    <td>
                        <h2> Login </h2>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email:</label>
                    </td>
                    <td>
                        <input type="email" name="email">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="pass">Password:</label>
                    </td>
                    <td>
                        <input type="password" name="pass">
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        <input type="submit" value="Login">
                    </td>
                </tr>
        </form>
    </div>
</body>