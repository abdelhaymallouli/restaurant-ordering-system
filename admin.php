<?php 
require_once 'config.php';
session_start();

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


// get today orders
$queryTodayOrders = "SELECT  c.idCmd, c.dateCmd, c.Statut, cl.nomCl, cl.prenomCl 
                    FROM commande c 
                    JOIN client cl on c.idCl = cl.idClient
                    WHERE DATE(c.dateCmd) = :today";
$stmtTodayOrders = $pdo->prepare($queryTodayOrders);
$stmtTodayOrders->execute(['today'=> $today]);
$orders = $stmtTodayOrders->fetchAll(PDO::FETCH_ASSOC); 


if(isset($_POST['updateStatus'])){
    $statusUpdates = $_POST['status'];

    foreach($statusUpdates as $orderId => $status){
        $queryUpdateStatus = "UPDATE commande SET Statut = :status WHERE idCmd = :orderId";
        $stmtUpdateStatus = $pdo->prepare($queryUpdateStatus);
        $stmtUpdateStatus->execute(['status'=> $status, 'orderId'=> $orderId]);
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
            <a href="#">Home Page</a>
            <a href="#">Sign Out</a>
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
                                    <option value="en cours" <?php echo $order['Statut'] == 'en cours' ? 'selected' : ''; ?>>En Cours</option>
                                    <option value="expédiée" <?php echo $order['Statut'] == 'expédiée' ? 'selected' : ''; ?>>Expédiée</option>
                                    <option value="livrée" <?php echo $order['Statut'] == 'livrée' ? 'selected' : ''; ?>>Livrée</option>
                                    <option value="annulée" <?php echo $order['Statut'] == 'annulée' ? 'selected' : ''; ?>>Annulée</option>
                                </select>
                                <button type="submit" name="updateStatus" class="btn"> +</button>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>

        <div class="footer">
            <div class="credit">Created by <span>Your Name</span></div>
        </div>
    </div>

</body>

</html>
