<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$articles = [];
$currentUser = $authDB->isLoggedin();

if (!$currentUser) {
  header('Location: /');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once 'includes/head.php' ?>
  <title>Mon profil</title>
</head>

<body>
  <div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
      <h1>Mon espace</h1>
      <h2>Mes informations</h2>
      <div class="info-container">
        <ul>
          <li>
            <strong>Prénom :</strong>
            <p><?= $currentUser['firstname'] ?></p>
          </li>
          <li>
            <strong>Nom :</strong>
            <p><?= $currentUser['lastname'] ?></p>
          </li>
          <li>
            <strong>Email :</strong>
            <p><?= $currentUser['email'] ?></p>
          </li>
          <br>
          <br>
          <?php if ($isAdmin) : ?>
          <li>
            <a href="/form-article.php" class="Addproduct">Ajouter un produit <i class="fas fa-plus"></i></a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>

</body>

</html>