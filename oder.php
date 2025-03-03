<?php 
session_start();

if(isset($_GET['add_to_order'])){
    $platId = $_GET['add_to_order'];
}

require 'config.php';
$stmt = $pdo->prepare("SELECT * FROM plat WHERE idPlat = :platId");
$stmt->execute(['platId' => $platId]);
$plat = $stmt->fetch(PDO::FETCH_ASSOC);

if($plat){
    if(!isset($_SESSION['order'])){
        $_SESSION['order'] = [];
    }

    $found = false;
    foreach($_SESSION['order'] as $orderItem){
        if($orderItem['idPlat'] == $plat['idPlat']) {
            $orderItem['quantity']++;
            $found = true;
            break;
        }
    }
}

if(!$found){
    $_SESSION
}