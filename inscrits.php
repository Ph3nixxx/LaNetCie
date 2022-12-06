<?php include 'components/header.php'; ?>

<?php
$sql = 'SELECT * FROM users';
$query = $connexion->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Liste des inscrits :</h1>

<?php if (empty($users)) : ?>
  <p>Aucun utilisateur n'est inscrit actuellement.</p>
<?php endif; ?>

<?php foreach ($users as $user) : ?>
  <div class="card">
    <div>
      <?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
      <div>
        inscrit le <?php echo $user['date']; ?>
      </div>
      <div>
        <a href="inscrit.php?id=<?= $user['id'] ?>">
          <input type="button" name="button" value="Gérer l'inscription">
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<?php include 'components/footer.php'; ?>