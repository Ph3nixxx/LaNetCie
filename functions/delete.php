<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../config/database.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = "SELECT * FROM users WHERE `id` = :id";

    // On prépare la requête
    $query = $connexion->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // On récupère l'utilisateur'
    $user = $query->fetch();

    // On vérifie si l'utilisateur existe
    if(!$user){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
        die();
    }

    $sql = "DELETE FROM users WHERE `id` = :id";

    // On prépare la requête
    $query = $connexion->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $_SESSION['message'] = "Inscription supprimée";
    header('Location: ../inscrits.php');
} else {
    $_SESSION['erreur'] = "URL invalide";
}