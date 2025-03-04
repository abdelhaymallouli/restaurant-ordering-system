<?php 
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = trim($_POST['last_name']);
    $firstname = trim($_POST['first_name']);
    $phone = trim($_POST['Phone_nb']);

    $stmt = $pdo->prepare("SELECT * FROM client WHERE telCl = ?");
    $stmt->execute([$phone]);
    $existingClient = $stmt->fetch();

    if ($existingClient) {
        $error = "Phone number already registered. Please log in.";
    } else {
        $stmt = $pdo->prepare("SELECT MAX(idClient) AS last_id FROM client");
        $stmt->execute();
        $row = $stmt->fetch();
        $new_id = ($row['last_id'] ?? 0) + 1;

        $stmt = $pdo->prepare("INSERT INTO client (idClient, nomCL, prenomCl, telCl) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$new_id, $lastname, $firstname, $phone])) {
            $_SESSION['client_id'] = $new_id;
            $_SESSION['client_name'] = "$lastname $firstname";

            header("Location: index.php");
            exit();
        } else {
            $error = "Error: Signing up; Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="frontend/css/sign-up.css?v=<?php echo time(); ?>">
    <title>Sign Up</title>
</head>
<body>
    <div class="signup-container">
        <h2 class="form-heading">Create an Account</h2>
        <form action="" method="POST">
            <input type="text" name="last_name" placeholder="Last name" required>
            <input type="text" name="first_name" placeholder="First name" required>
            <input type="text" name="Phone_nb" placeholder="Phone number" required>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
        <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
