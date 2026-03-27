<?php
session_start();
require_once(__DIR__ . '/functions.php');

// supprime les données de l'utilisateur
unset($_SESSION['LOGGED_USER']);

// message de succès (avant redirect)
$_SESSION['LOGOUT_SUCCESS_MESSAGE'] = 'Vous avez été déconnecté avec succès.';

// redirige vers accueil
redirectToUrl('index.php');
