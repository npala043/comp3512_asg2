<header>
    <h2>Assignment 2</h2>
    <h5>Hatoon Al-Nakshabandi, Anthony Dang, Darren Lam, Mason Lee, Nahuel Paladino</h5>
</header>

<nav>
    <img src="images/logo/logo.jpg" alt="log" width="100px">
    <a href="homepage.php">Home</a>
    <a href="about.php">About</a>
    <a href="browse-paintings.php">Browse Paintings</a>
    <!-- should only be avaliable if the user is logged in -->
    <?php
    if (isset($_SESSION['user'])) {
        echo  "<a href=" . 'favorites.php' . ">Favorties</a>";
        echo  "<a href=" . 'logout.php' . ">Logout</a>";
    } else {
        echo  "<a href=" . 'login.php' . ">Login</a>";
    }
    ?>
</nav>