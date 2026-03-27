<?php
session_start();
require_once(__DIR__ . '/functions.php');

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = (int)$_POST['product_id'];
    $quantity  = (int)$_POST['quantity'];

    // modifie la quantité
    if ($quantity > 0) {
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        // si quantité = 0, on supprime
        unset($_SESSION['cart'][$productId]);
    }
}

redirectToUrl('cart.php');
