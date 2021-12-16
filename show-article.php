<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
$currentUser = $authDB->isLoggedin();
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';


if (!$id) {
  header('Location: /');
} else {
  $article = $articleDB->fetchOne($id);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once 'includes/head.php' ?>
  <link rel="stylesheet" href="/public/css/show-article.css">
  <title>Article</title>
</head>

<body>
  <div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
    <h1><?= $article['title'] ?>:</h1>
    <div class="show-article-container">
    <ul class="category-container">
    <a class="article-back" href="/">Retour à la liste des articles</a>
    </ul>
      <div class="article-container">
        <div class="article-card">
        <div class="card-flex">
        <div class="article-cover-img" style="background-image:url(<?= $article['image'] ?>)"></div>
        <div class="info-flex">
        <div class="title-price-flex">
        <h1 class="article-title"><?= $article['title'] ?></h1>
        <p class="article-title"><?= $article['price'] ?> €</p>
        </div>
        <p class="article-content"><?= $article['content'] ?></p>
        <div class="action">
        <?php if ($isAdmin) : ?>
          <a class="btn btn-secondary" href="/delete-article.php?id=<?= $article['id'] ?>"><i class="fas fa-trash-alt"></i></a>
          <a class="btn btn-primary" href="/form-article.php?id=<?= $article['id'] ?>"><i class="fas fa-pen"></i></a>
          <?php endif; ?>
          <a class="btn btn-primary addPanier" href="/update-cart.php?id=<?= $article['id'] ?>">Ajouter au panier <i class="fas fa-shopping-cart add-icon"></i></a>
          </div>
          </div>
        </div>
        </div>
      </div>
     </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>

</body>

</html>