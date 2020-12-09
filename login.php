<!-- Nahuel -->

<?php
require_once 'includes/config.inc.php';
require_once 'includes/asg2-db-classes.inc.php';

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
            if (password_verify($_POST['pass'], $data['Pass'])) {
                // password bcrypt does match
                $_SESSION['user'] = $data['CustomerID']; // save user id in session, redirect to their homepage
                header("Location: index.php");
                exit();
            } else {
                // password bcrypt did not match
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
                    <td></td>
                    <td>
                        <input type="submit" value="Login">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><label>Don't have an account?</label></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="button">Sign up</button>
                    </td>
                </tr>
            </table>
        </form>
        <br>


    </div>
</body>