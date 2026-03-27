<?php
session_start();
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/functions.php');

// check si connecté
if (!isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('login.php');
}

// check si c'est un admin
$userId = $_SESSION['LOGGED_USER']['user_id'];
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user || $user['role'] != 'admin') {
    $_SESSION['ERROR_MESSAGE'] = 'Vous devez être administrateur pour accéder à cette page';
    redirectToUrl('index.php');
}

// compte les produits
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$nbProducts = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Administration - Les Bonnes Pièces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<div class="container my-5">
    <h1>Administration</h1>

    <?php if (isset($_SESSION['ADMIN_MESSAGE'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['ADMIN_MESSAGE']; unset($_SESSION['ADMIN_MESSAGE']); ?>
        </div>
    <?php endif; ?>

    <div class="alert alert-info mt-4">
        <p>Nombre de produits : <?php echo $nbProducts; ?></p>
    </div>

    <a href="admin_products.php" class="btn btn-primary">Gérer les produits</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
