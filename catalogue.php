<?php
session_start();
require_once(__DIR__ . '/config/database.php');

// récup tous les produits
$stmt = $pdo->query("SELECT * FROM products ORDER BY product_id");
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Les Bonnes Pièces - Catalogue</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<div class="container mt-3">
    <?php if (isset($_SESSION['LOGIN_SUCCESS_MESSAGE'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $_SESSION['LOGIN_SUCCESS_MESSAGE']; unset($_SESSION['LOGIN_SUCCESS_MESSAGE']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['LOGOUT_SUCCESS_MESSAGE'])): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?php echo $_SESSION['LOGOUT_SUCCESS_MESSAGE']; unset($_SESSION['LOGOUT_SUCCESS_MESSAGE']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['CART_MESSAGE'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $_SESSION['CART_MESSAGE']; unset($_SESSION['CART_MESSAGE']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>

<div class="container my-4">
    <h2>Nos produits</h2>

    <div class="row mt-3">
        <?php foreach ($produits as $produit): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $produit['image']; ?>" class="card-img-top" style="height: 200px; object-fit: contain; padding: 15px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($produit['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($produit['description']); ?></p>
                        <p><strong><?php echo number_format($produit['price'], 2); ?> €</strong></p>
                        <p>Catégorie : <?php echo htmlspecialchars($produit['category']); ?></p>
                        <p><?php echo $produit['disponibilite'] ? 'En stock' : 'Rupture de stock'; ?></p>
                    </div>
                    <div class="card-footer">
                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $produit['product_id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success w-100">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
