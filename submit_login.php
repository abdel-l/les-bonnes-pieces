<?php
session_start();
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/functions.php');

$postData = $_POST;

if (isset($postData['email']) && isset($postData['password'])) {
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide.';
        redirectToUrl('login.php');
    }

    // cherche l'user dans la bdd
    $stmt = $pdo->prepare('SELECT user_id, email, username, password FROM users WHERE email = :email');
    $stmt->execute(['email' => $postData['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // check le mdp
    if ($user && password_verify($postData['password'], $user['password'])) {
        $_SESSION['LOGGED_USER'] = [
            'email'    => $user['email'],
            'username' => $user['username'],
            'user_id'  => $user['user_id'],
        ];
        // message de succès
        $_SESSION['LOGIN_SUCCESS_MESSAGE'] = 'Connexion réussie ! Bienvenue ' . $user['username'] . '.';
        redirectToUrl('index.php');
    } else {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Email ou mot de passe incorrect.';
        redirectToUrl('login.php');
    }
}

redirectToUrl('login.php');
