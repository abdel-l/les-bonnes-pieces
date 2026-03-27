<?php
session_start();
require_once(__DIR__ . '/functions.php');

if (isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];

    // supprime du panier
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

redirectToUrl('cart.php');
