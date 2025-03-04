<?php
session_start();

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    header("Location: order.php");
    exit();
}

if (isset($_GET['update']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            if ($_GET['update'] == "increase") {
                $item['quantity'] += 1;
            } elseif ($_GET['update'] == "decrease" && $item['quantity'] > 1) {
                $item['quantity'] -= 1;
            }
            break;
        }
    }
    header("Location: order.php");
    exit();
}

$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="frontend/css/order.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="frontend/css/style.css?v=<?php echo time(); ?>">
    <title>Cart - M2l Restaurant</title>
</head>
<body>

<?php include 'header.php'; ?>


<section class="cart">
<a href="index.php" class="btn checkout">Go Back</a>

    <h1 class="heading">Your <span>Cart</span></h1>

    <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php else: ?>
        <div class="cart-container">
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <?php 
                    $subtotal = $item['price'] * $item['quantity']; 
                    $totalPrice += $subtotal;
                ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="cart-details">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>Price: <span class="item-price"><?= htmlspecialchars($item['price']) ?></span> DH</p>
                        <p>Subtotal: <span class="subtotal"><?= $subtotal ?></span> DH</p>
                        <div class="quantity-controls">
                            <a href="order.php?update=decrease&id=<?= $item['id'] ?>" class="btn">-</a>
                            <span><?= $item['quantity'] ?></span>
                            <a href="order.php?update=increase&id=<?= $item['id'] ?>" class="btn">+</a>
                        </div>
                        <a href="order.php?remove=<?= $item['id'] ?>" class="btn remove">X</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-total">
            <h3>Total: <span id="grand-total"><?= $totalPrice ?></span> DH</h3>
        </div>

        <div class="cart-actions">
            <a href="checkout.php" class="btn checkout">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
