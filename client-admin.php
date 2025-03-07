<?php
require_once 'config.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login-admin.php");
    exit();
}

// Delete client
if (isset($_GET['delete'])) {
    $clientId = $_GET['delete'];
    
    // Delete the client from the database
    $query = "DELETE FROM client WHERE idClient = :clientId";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['clientId' => $clientId]);

    // Redirect to the same page to refresh the table after deletion
    header("Location: client-admin.php");
    exit();
}

// Fetch all clients
$query = "SELECT * FROM client";
$stmt = $pdo->query($query);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management</title>
    <link rel="stylesheet" href="frontend/css/admin.css">
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
        <header>
            <h1>Client Management</h1>
        </header>

        <!-- Table of Clients -->
        <table>
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo $client['idClient']; ?></td>
                        <td><?php echo $client['nomCl']; ?></td>
                        <td><?php echo $client['prenomCl']; ?></td>
                        <td><?php echo $client['telCl']; ?></td>
                        <td>
                            <a href="client-admin.php?delete=<?php echo $client['idClient']; ?>">
                                <button onclick="return confirm('Are you sure you want to delete this client?')">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>