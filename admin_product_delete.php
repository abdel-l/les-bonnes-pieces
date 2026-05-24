<?php
session_start();
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/functions.php');

// check si admin
$userId = $_SESSION['LOGGED_USER']['user_id'] ?? 0;
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user || $user['role'] != 'admin') {
    redirectToUrl('index.php');
}

$productId = (int)($_POST['product_id'] ?? 0);

if ($productId > 0) {
    // supprime le produit
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);

    $_SESSION['ADMIN_MESSAGE'] = 'Produit supprimé';
}

redirectToUrl('admin_products.php');
