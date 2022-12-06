<?php include 'components/header.php'; ?>

<?php
// On démarre une session pour utiliser $_SESSION
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('config/database.php');

    // On nettoie l'id envoyé, en retirant les balises de l'id
    $id = strip_tags($_GET['id']);

    // On prépare la requête
    $sql = "SELECT * FROM users WHERE `id` = :id";
    $query = $connexion->prepare($sql);

    // On "accroche" le paramètre id
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // On récupère l'utilisateur'
    $user = $query->fetch();

    // On vérifie si l'utilisateur existe
    if(!$user){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>

<div class="">
  <h1>Détails de l'inscription :</h1>
  <div class="card">
    <p>Prénom : <?= $user['first_name'] ?></p>
    <p>Nom : <?= $user['last_name'] ?></p>
    <p>Email : <?= $user['email'] ?></p>
    <p>Inscrit le : <?= $user['date'] ?></p>
  </div>
  <div class="buttons">
    <a href="inscrits.php">
      <input type="button" name="button" value="Retour">
    </a>
    <a href="edit.php?id=<?= $user['id'] ?>">
      <input type="button" name="button" value="Modifier les informations">
    </a>
    <a href="functions/delete.php?id=<?= $user['id'] ?>">
      <input type="button" name="button" value="Supprimer l'inscription">
    </a>
  </div>
</div>

<?php include 'components/footer.php'; ?>