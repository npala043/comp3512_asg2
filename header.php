<header class="header">
    <nav id="navbar">
        <img src="images/logo/hamburger-menu.jpg" class="toggle">
        <!-- <img src="images/logo/logo.jpg" alt="log" id="logo"> -->
        <img src="images/logo/owenlogo.jpg" alt="log" id="logo">
        <ul class="navList">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="galleries.php">Galleries</a></li>
            <li><a href="browse-paintings.php">Browse Paintings</a></li>
            <!-- should only be avaliable if the user is logged in -->
            <?php
            if (isset($_SESSION['user'])) {
                echo  "<li><a href=" . 'favorites.php' . ">Favorites</a></li>";
                echo  "<li><a href=" . 'logout.php' . ">Logout</a></li>";
            } else {
                echo  "<li><a href=" . 'login.php' . ">Login</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>