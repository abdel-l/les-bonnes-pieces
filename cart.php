<?php
session_start();
require_once(__DIR__ . '/config/database.php');

// récup les produits du panier
$items = [];
$total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // récup les infos produits
    $stmt = $pdo->prepare("SELECT product_id, name, price, image FROM products WHERE product_id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // calcule les totaux
    foreach ($products as $product) {
        $productId = $product['product_id'];
        $quantity  = $_SESSION['cart'][$productId];
        $subtotal  = $product['price'] * $quantity;

        $items[] = [
            'product_id' => $productId,
            'name'       => $product['name'],
            'price'      => $product['price'],
            'image'      => $product['image'],
            'quantity'   => $quantity,
            'subtotal'   => $subtotal
        ];

        $total += $subtotal;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Les Bonnes Pièces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<div class="container my-5">
    <h1 class="mb-4">Mon Panier</h1>

    <?php if (isset($_SESSION['CART_MESSAGE'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['CART_MESSAGE']; unset($_SESSION['CART_MESSAGE']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            Votre panier est vide. <a href="catalogue.php">Voir le catalogue</a>
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" style="width: 50px; height: 50px; object-fit: contain;">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </td>
                        <td><?php echo number_format($item['price'], 2); ?> €</td>
                        <td>
                            <form method="POST" action="update_cart.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                                <button type="submit" class="btn btn-sm btn-primary">Modifier</button>
                            </form>
                        </td>
                        <td><?php echo number_format($item['subtotal'], 2); ?> €</td>
                        <td>
                            <form method="POST" action="remove_from_cart.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h3>Total : <?php echo number_format($total, 2); ?> €</h3>
        </div>

        <div class="mt-4">
            <a href="catalogue.php" class="btn btn-secondary">Continuer mes achats</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
