<header>
    <nav id="navbar">
        <img src="images/logo/hamburger-menu.jpg" class="toggle">
        <!-- <img src="images/logo/logo.jpg" alt="log" id="logo"> -->
        <ul id="navList">
            <img src="images/logo/logo.jpg" alt="log" id="logo">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="galleries.php">Galleries</a></li>
            <li><a href="browse-paintings.php">Browse Paintings</a></li>
            <!-- should only be avaliable if the user is logged in -->
            <?php
            if (isset($_SESSION['user'])) {
                echo  "<li><a href=" . 'favorites.php' . ">Favorties</a></li>";
                echo  "<li><a href=" . 'logout.php' . ">Logout</a></li>";
            } else {
                echo  "<li><a href=" . 'login.php' . ">Login</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>