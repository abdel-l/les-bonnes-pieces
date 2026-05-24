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

$productId = $_GET['id'] ?? 0;

// récup le produit
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    redirectToUrl('admin_products.php');
}

// si le formulaire est envoyé
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $disponibilite = isset($_POST['disponibilite']) ? 1 : 0;

    // update dans la bdd
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ?, disponibilite = ? WHERE product_id = ?");
    $stmt->execute([$name, $description, $price, $category, $image, $disponibilite, $productId]);

    $_SESSION['ADMIN_MESSAGE'] = 'Produit modifié';
    redirectToUrl('admin_products.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier un produit - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<div class="container my-5">
    <h1>Modifier le produit</h1>

    <form method="POST">
        <div class="mb-3">
            <label>Nom du produit</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Prix</label>
            <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Catégorie</label>
            <input type="text" class="form-control" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Image (chemin)</label>
            <input type="text" class="form-control" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" required>
        </div>

        <div class="mb-3">
            <label>
                <input type="checkbox" name="disponibilite" <?php echo $product['disponibilite'] ? 'checked' : ''; ?>> En stock
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="admin_products.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
