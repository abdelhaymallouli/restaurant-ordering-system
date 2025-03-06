<?php
$totalPrice = 0;
?>
<header>
    <a href="index.php" class="logo"><i class="fas fa-utensils"></i>M2l Restaurant</a>
    <nav class="navbar">
        <!-- Cart Dropdown -->
        <div class="card-shopping" id="cartDropdown">
            <button class="cart-btn">
                <img src="frontend/icons/shopping-cart.png" alt="Shopping Cart" id="cart-icon">
                <span class="cart-count">
                    <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                </span>
            </button>
            <div class="cart-dropdown">
                <?php if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0): ?>
                    <p class="empty-cart">Your cart is empty.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <?php
                            $subtotal = $item['price'] * $item['quantity'];
                            $totalPrice += $subtotal;
                            ?>
                            <li>
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                <div class="order-details">
                                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                                    <p><?= htmlspecialchars($item['price']) ?> DH</p>
                                </div>
                                <div class="order-controls">
                                    <a href="order.php?update=decrease&id=<?= $item['id'] ?>">-</a>
                                    <span><?= $item['quantity'] ?></span>
                                    <a href="order.php?update=increase&id=<?= $item['id'] ?>">+</a>
                                </div>
                                <a href="order.php?remove=<?= $item['id'] ?>" class="delete-item">X</a>
                            </li>
                            <p>Subtotal: <span class="subtotal"><?= $subtotal ?></span> DH</p>
                        <?php endforeach; ?>
                    </ul>
                    <div class="cart-total">
                        <h3>Total: <span id="grand-total"><?= $totalPrice ?></span> DH</h3>
                    </div>
                    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Profile Dropdown -->
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