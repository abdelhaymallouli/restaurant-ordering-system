<header>
    <a href="index.php" class="logo"><i class="fas fa-utensils"></i>M2l Restaurant</a>
    <nav class="navbar">
        <div class="card-shopping">
            <img src="frontend/icons/shopping-cart.png" alt="Shopping Cart" id="cart-icon">
            <span class="cart-count">3</span> 
            
            <div class="cart-dropdown" id="cart-dropdown" style="display: none;">
                <p>Your cart is empty</p>
                <a href="order.php" class="checkout-btn">View Cart</a>
            </div>
        </div>

        <?php if (isset($_SESSION['client_name'])) { ?>
            <div class="profile-dropdown">
    <button id="profileButton" class="profile-btn">
        <img src="frontend/icons/young-bearded-man-with-striped-shirt.jpg" alt="Profile" class="profile-img">
        <span class="client-name"><?= htmlspecialchars($_SESSION['client_name']) ?></span>
        <i class="fas fa-chevron-down"></i>
    </button>
    <div id="dropdownMenu" class="dropdown-menu">
        <a href="profile.php">Profile</a>
        <a href="#">Settings</a>
        <a href="logout.php">Log Out</a>
    </div>
</div>

        <?php } else { ?>
            <a href="login.php"><button class="btn0">Sign Up</button></a>
        <?php } ?>
    </nav>
</header>

