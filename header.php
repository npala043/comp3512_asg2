<header class="header">
    <nav id="navbar">
        <img src="images/logo/hamburger-menu.jpg" class="toggle">
        <img src="images/logo/owenlogo.jpg" alt="log" id="logo">
        <ul class="navList">

            <a href="homepage.php">
                <li>Home</li>
            </a>
            <a href="about.php">
                <li>About</li>
            </a>
            <a href="galleries.php">
                <li>Galleries</li>
            </a>
            <a href="browse-paintings.php">
                <li>Browse Paintings</li>
            </a>

            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="galleries.php">Galleries</a></li>
            <li><a href="browse-paintings.php">Browse Paintings</a></li>

            <?php
            if (isset($_SESSION['user'])) {
                // should only be avaliable if the user is logged in 
                echo  "<a href=" . 'favorites.php' . "><li>Favorites</li></a>";
                echo  "<a href=" . 'logout.php' . "><li>Logout</li></a>";
            } else {
                echo  "<a href=" . 'login.php' . "><li>Login</li></a>";
            }
            ?>
        </ul>
    </nav>
</header>