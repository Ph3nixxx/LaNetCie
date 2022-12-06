<?php include 'components/header.php'; ?>

<?php
$first_name = $last_name = $email = '';
$first_nameErr = $last_nameErr = $emailErr = '';

// Formulaire
if (isset($_POST['submit'])) {

    // Prénom conforme
    if (empty($_POST['first_name'])) {
        $first_nameErr = "Le prénom est requis !";
    } else {
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    // Nom conforme
    if (empty($_POST['last_name'])) {
        $last_nameErr = "Le nom de famille est requis !";
    } else {
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    // Email conforme
    if (empty($_POST['email'])) {
        $emailErr = "L'email est requis !";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }

    // Si tout est conforme
    if (empty($first_nameErr) && empty($last_nameErr) && empty($emailErr)) {
        // Ajout à la base de données
        // On inclut la connexion à la base
        require_once('config/database.php');

        // On nettoie les données envoyées
        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $email = strip_tags($_POST['email']);
    
        $sql = "INSERT INTO users (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";

        $query = $connexion->prepare($sql);
        $query->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $query->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['message'] = "Inscription réussie";
        header('Location: inscrits.php');
    } else {
        $_SESSION['erreur'] = $connexion;
    }
}
?>

<!-- HTML -->

<main>
    <h1>Voyage Qatar</h1>
    <div id="qatar">
        <img alt="image du Qatar" src='img/qatar.jpg'/>
        <p>Voyage de 7 jours & 6 nuits à Doha</p>
    </div>
</main>

<section>
    <h2>Si vous souhaitez vous inscrire, merci de remplir le formulaire ci-dessous :</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div>
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control <?php echo $first_nameErr ? 'is-invalid' : null ?>" id="first_name" name="first_name" placeholder="Saisissez votre prénom">
            <div class="invalid">
                <?php echo $first_nameErr; ?>
            </div>
        </div>
        <div>
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control <?php echo $last_nameErr ? 'is-invalid' : null ?>" id="last_name" name="last_name" placeholder="Saisissez votre nom">
            <div class="invalid">
                <?php echo $last_nameErr; ?>
            </div>
        </div>
        <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null ?>" id="email" name="email" placeholder="Entrez votre email">
            <div class="invalid">
                <?php echo $emailErr; ?>
            </div >
        </div>
        <div>
            <input type="submit" name="submit" value="Valider l'inscription">
        </div>
    </form>
</section>

<?php include 'components/footer.php'; ?>