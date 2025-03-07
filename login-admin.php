<?php
require_once 'config.php';
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM admin WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $password === $admin['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="frontend/css/admin.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap');

        :root {
            --blue: rgb(30, 48, 80);
            --blue-hover: rgb(54, 85, 138);
        }

        * {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
            text-transform: capitalize;
            transition: all .2s linear;
        }

        body {
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0 2rem;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .login-box {
            background: #fff;
            padding: 3rem;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: .7rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 2.5rem;
            color: var(--blue);
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 1.2rem;
            font-size: 1.6rem;
            border: 2px solid var(--blue);
            border-radius: .5rem;
            margin-bottom: 1.5rem;
            outline: none;
            transition: border-color .3s ease;
        }

        input:focus {
            border-color: var(--blue-hover);
        }

        button {
            width: 100%;
            padding: 1.5rem;
            background: var(--blue);
            color: #fff;
            font-size: 1.8rem;
            border-radius: .5rem;
            cursor: pointer;
            transition: background-color .3s ease;
        }

        button:hover {
            background: var(--blue-hover);
        }

        .error {
            color: red;
            margin-top: 1rem;
            font-size: 1.4rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Username</label>
                <input type="text" name="username" required autocomplete="off" autocapitalize="none" spellcheck="false">

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
