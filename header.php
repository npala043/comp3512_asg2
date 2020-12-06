<header>
    <!-- <h1> Assignment 2</h1> -->
    <img src="images/logo/logo.jpg" alt="log" id="logo">
    <span> Assignment 2</span>
    <nav>
    
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
</header>