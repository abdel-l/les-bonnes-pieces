<?php
// démarre la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// connexion bdd pour vérifier le rôle
require_once(__DIR__ . '/config/database.php');

$isLoggedIn = isset($_SESSION['LOGGED_USER']);
$username   = $isLoggedIn ? $_SESSION['LOGGED_USER']['username'] : '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="logo-les-bonnes-pieces.png" height="40" alt="Logo" class="d-inline-block align-text-top">
            Les Bonnes Pièces
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogue.php">Catalogue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        Panier
                        <?php
                        // compte le nombre d'articles
                        $cartCount = 0;
                        if (isset($_SESSION['cart'])) {
                            $cartCount = array_sum($_SESSION['cart']);
                        }
                        if ($cartCount > 0):
                        ?>
                            <span class="badge bg-danger"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if ($isLoggedIn): ?>
                    <?php
                    // check si admin pour afficher le lien
                    $stmtRole = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
                    $stmtRole->execute([$_SESSION['LOGGED_USER']['user_id']]);
                    $userRole = $stmtRole->fetch();
                    if ($userRole && $userRole['role'] == 'admin'):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <span class="nav-link">Bonjour, <?php echo htmlspecialchars($username); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
