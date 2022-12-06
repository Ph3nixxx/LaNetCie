<?php
define('DB_HOST', 'mysql:host=localhost;dbname=groupomania');
define('DB_USER', 'Ph3nixxx');
define('DB_PASSWORD', 'argent');

try {
    // Connexion à la base
    $connexion = new PDO(DB_HOST, DB_USER, DB_PASSWORD);
    $connexion->exec('SET NAMES "UTF8"');
} catch(PDOException $error) {
    echo 'Erreur : ' . $error->getMessage();
    die();
}