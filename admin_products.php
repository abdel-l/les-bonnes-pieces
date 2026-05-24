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

// récup tous les produits
$stmt = $pdo->query("SELECT * FROM products ORDER BY product_id");
$data = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion produits - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<div class="container my-5">
    <h1>Gestion des produits</h1>

    <?php if (isset($_SESSION['ADMIN_MESSAGE'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['ADMIN_MESSAGE']; unset($_SESSION['ADMIN_MESSAGE']); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="admin_product_add.php" class="btn btn-success">Ajouter un produit</a>
        <a href="admin.php" class="btn btn-secondary">Retour</a>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Catégorie</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($data as $product): ?>
            <tr>
                <td><?php echo $product['product_id']; ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo number_format($product['price'], 2); ?> €</td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td><?php echo $product['disponibilite'] ? 'Oui' : 'Non'; ?></td>
                <td>
                    <a href="admin_product_edit.php?id=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-primary">Modifier</a>
                    <form method="POST" action="admin_product_delete.php" style="display:inline;" onsubmit="return confirm('Supprimer ce produit ?')">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
