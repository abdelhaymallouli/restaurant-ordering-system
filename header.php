<header>
    <a href="index.php" class="logo"><i class="fas fa-utensils"></i>M2l Restaurant</a>
    <nav class="navbar">
        <a class="card-shopping" href="order.php">
            <img src="frontend/icons/shopping-cart.png" alt="">
            <span class="cart-count">3</span> 
        </a>
        <?php if (isset($_SESSION['client_name'])) { ?>
            <div class="profile-dropdown">
                <button class="profile-btn">
                    <img src="frontend/icons/young-bearded-man-with-striped-shirt.jpg" alt="Profile" class="profile-img">
                    <span class="client-name"><?= htmlspecialchars($_SESSION['client_name']) ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="profile.php">Profile </a>
                    <a href="#">Settings</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        <?php } else { ?>
            <a href="login.php"><button class="btn0">Sign Up</button></a>
        <?php } ?>
    </nav>
</header>
