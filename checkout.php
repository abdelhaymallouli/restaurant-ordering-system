<?php
session_start();
require 'config.php'; 


$orderPlaced = false;
$orderDetails = [];
$orderItems = [];
$totalPrice = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    if (isset($_SESSION['client_id']) && isset($_SESSION['client_name'])) {
        try {
            // create uniaue id comande
            $sql = "SELECT MAX(idCmd) AS lastId FROM commande";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $lastId = $stmt->fetchColumn();
            if ($lastId) {
                $idCmd = $lastId + 1;
            } else {
                $idCmd = 1;
            }

            // insert intu admin
            $stmt = $pdo->prepare(query: "INSERT INTO commande (idCmd, dateCmd, Statut, idCl) VALUES (:idCmd, NOW(), 'en attente', :idCl)");
            $stmt->execute(['idCmd' => $idCmd, 'idCl' => $_SESSION['client_id']]);

            foreach ($_SESSION['cart'] as $item) {
                $stmt = $pdo->prepare("INSERT INTO commande_plat (idCmd, idPlat, qte) VALUES (:idCmd, :idPlat, :qte)");
                $stmt->execute([
                    'idCmd' => $idCmd,
                    'idPlat' => $item['id'],
                    'qte' => $item['quantity']
                ]);
            }

            $orderPlaced = true;
            
            // get order details and order items 
            $stmt = $pdo->prepare("SELECT * FROM commande WHERE idCmd = :idCmd");
            $stmt->execute(['idCmd' => $idCmd]);
            $orderDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            // 
            $stmt = $pdo->prepare("SELECT cp.*, p.nomPlat, p.prix, p.image FROM commande_plat cp JOIN plat p ON cp.idPlat = p.idPlat WHERE cp.idCmd = :idCmd");
            $stmt->execute(['idCmd' => $idCmd]);
            $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // calculate total price
            foreach ($orderItems as $item) {
                $totalPrice += $item['prix'] * $item['qte'];
            }
            

            
            unset($_SESSION['cart']);

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="frontend/css/checkout.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="frontend/css/style.css?v=<?php echo time(); ?>">
    <title>Checkout - Order Confirmation</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="checkout-section">
        <?php if ($orderPlaced): ?>
            <h1 class="heading">Thank You for Your <span>Order!</span></h1>
            
            <div class="order-confirmation">
                <p class="order-greeting">
                    Dear <span class="client-name"><?= htmlspecialchars($_SESSION['client_name']) ?></span>, 
                    your order has been placed successfully.
                </p>
                
                <div class="order-details">
                    <p class="order-date">
                        <span class="label">Order Date:</span> 
                        <?= htmlspecialchars($orderDetails['dateCmd']) ?>
                    </p>
                    <p class="order-status">
                        <span class="label">Order Status:</span> 
                        <span class="status"><?= htmlspecialchars($orderDetails['Statut']) ?></span>
                    </p>
                </div>

                <h3 class="sub-heading">Ordered Items</h3>
                <ul class="order-items">
                    <?php foreach ($orderItems as $item): ?>
                        <li class="order-item">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['nomPlat']) ?>" class="item-image">
                            <div class="item-details">
                                <span class="item-name"><?= htmlspecialchars($item['nomPlat']) ?></span>
                                <span class="item-quantity">(<?= $item['qte'] ?>)</span>
                                <span class="item-price"><?= htmlspecialchars($item['prix']) ?> DH</span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="order-total">
                <h3>Total: <span class="total-amount"><?= htmlspecialchars($totalPrice) ?> DH</span></h3>
                </div>

                <p class="order-thanks">
                    Thank you for choosing Tasty Bites! Your order will be processed soon. 
                    We will notify you once it's ready.
                </p>

                <a href="index.php" class="btn">Return to Home</a>
            </div>
        <?php else: ?>
            <div class="order-error">
                <p class="error-message">
                    There was an issue with your order. Please try again later.
                </p>
                <a href="index.php" class="btn">Return to Home</a>
            </div>
        <?php endif; ?>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>