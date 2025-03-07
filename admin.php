<?php
require_once 'config.php';
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login-admin.php");
    exit();
}



$today = date("Y-m-d");

// get the total number order of today
$query = "SELECT count(*) AS totalOrders FROM commande WHERE DATE(dateCmd) = :today";
$stmt = $pdo->prepare($query);
$stmt->execute(['today' => $today]);
$totalOrders = $stmt->fetch(PDO::FETCH_ASSOC)['totalOrders'];


// get the number of clients
$queryCl = "SELECT COUNT(*) AS totalclients FROM client";
$stmtCls = $pdo->query($queryCl);
$totalCls = $stmtCls->fetch(PDO::FETCH_ASSOC)['totalclients'];


// get total of canceleted order today
$queryCanceled = "SELECT COUNT(*) AS canceledOrders FROM commande WHERE DATE(dateCmd) = :today AND Statut = 'annulée'";
$stmtCanceled = $pdo->prepare($queryCanceled);
$stmtCanceled->execute(['today' => $today]);
$canceledOrders = $stmtCanceled->fetch(PDO::FETCH_ASSOC)['canceledOrders'];


// get the number of plat
$queryCl = "SELECT COUNT(*) AS totalplat FROM plat";
$stmtplats = $pdo->query($queryCl);
$totalplats = $stmtplats->fetch(PDO::FETCH_ASSOC)['totalplat'];

// get today orders
$queryTodayOrders = "SELECT  c.idCmd, c.dateCmd, c.Statut, cl.nomCl, cl.prenomCl 
                    FROM commande c 
                    JOIN client cl on c.idCl = cl.idClient
                    WHERE DATE(c.dateCmd) = :today";
$stmtTodayOrders = $pdo->prepare($queryTodayOrders);
$stmtTodayOrders->execute(['today' => $today]);
$orders = $stmtTodayOrders->fetchAll(PDO::FETCH_ASSOC);


// Get top ordered plats today
$queryTopPlats = "SELECT p.nomPlat, SUM(cp.qte) AS totalOrdered 
                  FROM commande_plat cp
                  JOIN plat p ON cp.idPlat = p.idPlat
                  JOIN commande c ON cp.idCmd = c.idCmd
                  WHERE DATE(c.dateCmd) = :today
                  GROUP BY p.nomPlat
                  ORDER BY totalOrdered DESC
                  LIMIT 5";

$stmtTopPlats = $pdo->prepare($queryTopPlats);
$stmtTopPlats->execute(['today' => $today]);
$topPlats = $stmtTopPlats->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['updateStatus'])) {
    $statusUpdates = $_POST['status'];

    foreach ($statusUpdates as $orderId => $status) {
        $queryUpdateStatus = "UPDATE commande SET Statut = :status WHERE idCmd = :orderId";
        $stmtUpdateStatus = $pdo->prepare($queryUpdateStatus);
        $stmtUpdateStatus->execute(['status' => $status, 'orderId' => $orderId]);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="frontend/css/admin.css?v=<?php echo time(); ?>">

</head>

<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <nav>
            <a href="admin.php">Home Page</a>
            <a href="client-admin.php">Clients</a>
            <a href="logout-admin.php">Sign Out</a>
        </nav>
    </div>


    <div class="main-content">
        <h1>Admin Dashboard Overview</h1>
        <div class="stats-cards">
            <div class="card">
                <h3>Total Orders Today</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div class="card">
                <h3>Total Clients</h3>
                <p><?php echo $totalCls; ?></p>
            </div>
            <div class="card">
                <h3>Total Canceled Orders Today</h3>
                <p><?php echo $canceledOrders; ?></p>
            </div>
            <div class="card">
                <h3>Total Plats</h3>
                <p><?php echo $totalplats; ?></p>
            </div>
        </div>

        <h2>Today's Orders (<?php echo date('d-m-Y', strtotime($today)); ?>)</h2>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Client Name</th>
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['idCmd']; ?></td>
                            <td><?php echo $order['dateCmd']; ?></td>
                            <td><?php echo $order['Statut']; ?></td>
                            <td><?php echo $order['nomCl'] . ' ' . $order['prenomCl']; ?></td>
                            <td>
                                <select name="status[<?php echo $order['idCmd']; ?>]" class="status-select">
                                    <option value="en attente" <?php echo $order['Statut'] == 'en attente' ? 'selected' : ''; ?>>En Attente</option>
                                    <option value="en cours" <?php echo $order['Statut'] == 'en cours' ? 'selected' : ''; ?>>
                                        En Cours</option>
                                    <option value="expédiée" <?php echo $order['Statut'] == 'expédiée' ? 'selected' : ''; ?>>
                                        Expédiée</option>
                                    <option value="livrée" <?php echo $order['Statut'] == 'livrée' ? 'selected' : ''; ?>>
                                        Livrée</option>
                                    <option value="annulée" <?php echo $order['Statut'] == 'annulée' ? 'selected' : ''; ?>>
                                        Annulée</option>
                                </select>
                                <button type="submit" name="updateStatus" class="btn"><img src="frontend/icons/check.png" alt=""></button>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>

        <h2>Top Ordered Plats Today</h2>
        <table>
            <thead>
                <tr>
                    <th>Plat Name</th>
                    <th>Quantity Ordered</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topPlats as $plat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($plat['nomPlat']); ?></td>
                        <td><?php echo $plat['totalOrdered']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="footer">
            <div class="credit">Created by <span>Your Name</span></div>
        </div>
    </div>

</body>

</html>