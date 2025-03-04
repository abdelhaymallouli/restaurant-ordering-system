<?php
session_start();
require 'config.php';

$typeCuisine = isset($_GET['typeCuisine']) ? $_GET['typeCuisine'] : 'ALL';
$categoriePlat = isset($_GET['categoriePlat']) ? $_GET['categoriePlat'] : 'ALL';

$sql = "SELECT * FROM plat";
$params = [];

if ($typeCuisine !== 'ALL' && $categoriePlat !== 'ALL') {
    $sql .= " WHERE typeCuisine = :typeCuisine AND categoriePlat = :categoriePlat";
    $params = ['typeCuisine' => $typeCuisine, 'categoriePlat' => $categoriePlat];
} elseif ($typeCuisine !== 'ALL') {
    $sql .= " WHERE typeCuisine = :typeCuisine";
    $params['typeCuisine'] = $typeCuisine;
} elseif ($categoriePlat !== 'ALL') {
    $sql .= " WHERE categoriePlat = :categoriePlat";
    $params['categoriePlat'] = $categoriePlat;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$plats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$platsByCuisine = [];
foreach ($plats as $plat) {
    $platsByCuisine[$plat['TypeCuisine']][] = $plat;
}

// Handle adding to cart
if (isset($_GET['add_to_order'])) {
    $idPlat = $_GET['add_to_order'];

    // Fetch the item details from the database
    $stmt = $pdo->prepare("SELECT * FROM plat WHERE idPlat = ?");
    $stmt->execute([$idPlat]);
    $plat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($plat) {
        $item = [
            'id' => $plat['idPlat'],
            'name' => $plat['nomPlat'],
            'price' => $plat['prix'],
            'image' => $plat['image'],
            'quantity' => 1
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if item is already in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] == $idPlat) {
                $cartItem['quantity'] += 1;
                $found = true;
                break;
            }
        }

        // If not found, add new item
        if (!$found) {
            $_SESSION['cart'][] = $item;
        }
    }

    // Redirect to prevent re-adding on refresh
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="frontend/css/style.css?v=<?php echo time(); ?>">
    <title>M2l Restaurant</title>
</head>
<body>

    <?php include 'header.php'; ?>

    <section class="home" id="home">
        <div class="content">
            <h3>Tasty Bites</h3>
            <p>Welcome to Tasty Bites, where every meal is a culinary masterpiece delivered straight to your door.</p>
            <a href="#PLats" class="btn">order now</a>
        </div>
        <div class="image">
            <img src="frontend/img/home-img.png" alt="">
        </div>
    </section>

    <section class="Plats" id="PLats">
        <h1 class="heading">Our <span>Popular</span> Foods</h1>

        <div class="form-filter">
            <form class="form-select" method="get" action="">
                <select name="categoriePlat">
                    <option value="ALL">All Categories</option>
                    <option value="plat principal">Plat Principal</option>
                    <option value="entrée">Entrée</option>
                    <option value="dessert">Dessert</option>
                </select>

                <select name="typeCuisine">
                    <option value="ALL">All Cuisines</option>
                    <option value="Marocaine">Marocaine</option>
                    <option value="Chinoise">Chinoise</option>
                    <option value="Espagnole">Espagnole</option>
                    <option value="Francaise">Francaise</option>
                    <option value="Italienne">Italienne</option>
                </select>

                <button class="button-filter" type="submit">Filter</button>
            </form>
        </div>

        <?php foreach ($platsByCuisine as $cuisineType => $cuisinePlats): ?>
            <h2 class="cuisine-heading"><?= htmlspecialchars($cuisineType) ?> Cuisine</h2>
            <div class="box-container">
                <?php foreach ($cuisinePlats as $plat): ?>
                    <div class="box">
                        <span class="price"><?= htmlspecialchars($plat['prix']) ?> DH</span>
                        <img src="<?= htmlspecialchars($plat['image']) ?>" alt="<?= htmlspecialchars($plat['nomPlat']) ?>">
                        <h3><?= htmlspecialchars($plat['nomPlat']) ?></h3>
                        <div class="stars">
                            <p>Categorie : <?= htmlspecialchars($plat['categoriePlat']) ?></p>
                        </div>
                        <a href="index.php?add_to_order=<?= $plat['idPlat'] ?>" class="btn">order now</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>

    <?php include 'footer.php'; ?>
    <a href="#home" class="fas fa-angle-up" id="scroll-top"></a>

</body>
<script src="frontend/js/script.js" defer></script>
</html>
