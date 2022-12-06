<?php include 'components/header.php'; ?>

<?php
// On démarre une session pour utiliser $_SESSION
session_start();

// Si tout est conforme
if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['first_name']) && !empty($_POST['first_name'])
    && isset($_POST['last_name']) && !empty($_POST['last_name'])
    && isset($_POST['email']) && !empty($_POST['email'])) {
        // Ajout à la base de données
        // On inclut la connexion à la base
        require_once('config/database.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $email = strip_tags($_POST['email']);

        $sql = "UPDATE users SET `first_name`=:first_name, `last_name`=:last_name, `email`=:email WHERE `id`=:id";

        $query = $connexion->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $query->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['message'] = "Modifications effectuées";
        header('Location: inscrit.php?id={$id}');
    } else {
        $_SESSION['erreur'] = $connexion;
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('config/database.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = "SELECT * FROM users WHERE `id` = :id";

    // On prépare la requête
    $query = $connexion->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $id = $query->fetch();

    // On vérifie si le produit existe
    if(!$id){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: inscrits.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: inscrits.php');
}
?>

<section>
    <h1>Veuillez modifier les informations remplies :</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div>
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control <?php echo $first_nameErr ? 'is-invalid' : null ?>" id="first_name" name="first_name" value="<?= $id['first_name']?>">
            <div class="invalid"></div>
        </div>
        <div>
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control <?php echo $last_nameErr ? 'is-invalid' : null ?>" id="last_name" name="last_name" value="<?= $id['last_name']?>">
            <div class="invalid"></div>
        </div>
        <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null ?>" id="email" name="email" value="<?= $id['email']?>">
            <div class="invalid-feedback"></div>
        </div>
        <div class="buttons">
            <input type="hidden" value="<?= $id['id']?>" name="id">
            <a>
                <input type="submit" name="submit" value="Valider les modifications">
            </a>
            <a href="inscrit.php?id=<?= $id['id'] ?>">
                <input type="button" name="button" value="Retour">
            </a>
        </div>
    </form>
</section>

<?php include 'components/footer.php'; ?>