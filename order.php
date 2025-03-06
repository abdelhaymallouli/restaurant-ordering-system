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
    header("Location: index.php");
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
    header("Location: index.php");
    exit();
}

 ?>

