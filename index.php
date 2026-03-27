<?php
session_start();
require_once(__DIR__ . '/config/database.php');

// récup 3 produits pour la page d'accueil
$stmt = $pdo->query("SELECT * FROM products ORDER BY product_id LIMIT 3");
$produitsAccueil = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Bonnes Pièces - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<!-- Messages de succès -->
<div class="container mt-3">
    <?php if (isset($_SESSION['LOGIN_SUCCESS_MESSAGE'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $_SESSION['LOGIN_SUCCESS_MESSAGE']; unset($_SESSION['LOGIN_SUCCESS_MESSAGE']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['REGISTER_SUCCESS_MESSAGE'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $_SESSION['REGISTER_SUCCESS_MESSAGE']; unset($_SESSION['REGISTER_SUCCESS_MESSAGE']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['LOGOUT_SUCCESS_MESSAGE'])): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?php echo $_SESSION['LOGOUT_SUCCESS_MESSAGE']; unset($_SESSION['LOGOUT_SUCCESS_MESSAGE']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>

<!-- Hero Section -->
<section class="hero bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 mb-4">Bienvenue chez Les Bonnes Pièces</h1>
        <p class="lead mb-4">Votre spécialiste en pièces automobiles de qualité</p>
        <a href="catalogue.php" class="btn btn-light btn-lg">Voir le catalogue complet</a>
    </div>
</section>

<!-- Produits populaires -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Nos produits populaires</h2>
        <div class="row">
            <?php foreach ($produitsAccueil as $produit): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <img src="<?php echo $produit['image']; ?>" class="card-img-top" style="height: 250px; object-fit: contain; padding: 30px; background: #f8f9fa;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $produit['name']; ?></h5>
                            <p class="text-muted"><?php echo $produit['category']; ?></p>
                            <p class="h3 text-primary"><?php echo number_format($produit['price'], 2); ?> €</p>
                            <p class="text-success"><?php echo $produit['disponibilite'] ? 'En stock' : 'Rupture de stock'; ?></p>
                        </div>
                        <div class="card-footer bg-white border-0 text-center pb-4">
                            <a href="catalogue.php" class="btn btn-primary w-75">Voir le catalogue</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="catalogue.php" class="btn btn-primary btn-lg px-5">Découvrir tous nos produits →</a>
        </div>
    </div>
</section>

<!-- Section avantages -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-4">
                    <div class="mb-3" style="font-size: 3rem;">✓</div>
                    <h3>Qualité garantie</h3>
                    <p class="text-muted">Toutes nos pièces sont certifiées et testées</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4">
                    <div class="mb-3" style="font-size: 3rem;">€</div>
                    <h3>Prix compétitifs</h3>
                    <p class="text-muted">Les meilleurs prix du marché automobile</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4">
                    <div class="mb-3" style="font-size: 3rem;">⚡</div>
                    <h3>Livraison rapide</h3>
                    <p class="text-muted">Expédition sous 24h partout en France</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-0">Les Bonnes Pièces</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
