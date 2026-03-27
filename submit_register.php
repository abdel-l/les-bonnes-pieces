<?php
session_start();
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/functions.php');

$postData = $_POST;

// vérifie que tous les champs sont remplis
if (
    empty($postData['username'])
    || empty($postData['email'])
    || empty($postData['password'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
) {
    $_SESSION['REGISTER_ERROR_MESSAGE'] = 'Tous les champs sont obligatoires.';
    redirectToUrl('register.php');
}

$username = trim(strip_tags($postData['username']));
$email    = $postData['email'];
$password = $postData['password'];

// check si l'email ou le pseudo existe déjà
$checkStmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email OR username = :username');
$checkStmt->execute(['email' => $email, 'username' => $username]);

if ($checkStmt->fetch()) {
    $_SESSION['REGISTER_ERROR_MESSAGE'] = 'Cet email ou ce nom d\'utilisateur est déjà utilisé.';
    redirectToUrl('register.php');
}

// inscription de l'utilisateur (mdp hashé)
$insertStmt = $pdo->prepare('INSERT INTO users(username, email, password) VALUES (:username, :email, :password)');
$insertStmt->execute([
    'username' => $username,
    'email'    => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT),
]);

// connecte l'user direct après inscription
$_SESSION['LOGGED_USER'] = [
    'email'    => $email,
    'username' => $username,
    'user_id'  => $pdo->lastInsertId(),
];

// message de succès
$_SESSION['REGISTER_SUCCESS_MESSAGE'] = 'Inscription réussie ! Bienvenue ' . $username . '.';

redirectToUrl('index.php');
