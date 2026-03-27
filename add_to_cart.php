<?php
session_start();
require_once(__DIR__ . '/functions.php');

if (isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    $quantity  = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // init le panier si existe pas
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ajoute ou modifie la quantité
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    $_SESSION['CART_MESSAGE'] = 'Produit ajouté au panier';
}

// retour à la page précédente
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'catalogue.php';
redirectToUrl($referer);
