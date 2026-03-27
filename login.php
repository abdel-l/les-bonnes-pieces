<?php
session_start();
require_once(__DIR__ . '/functions.php');

// si déjà connecté on redirige
if (isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Bonnes Pièces - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/navbar.php'); ?>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Connexion</h2>

                        <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                                unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="submit_login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="vous@exemple.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>
                        <hr>
                        <p class="text-center mb-0">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
