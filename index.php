<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
setcookie(session_name(),session_id(),time()+ 60 * 60 * 24 * 14);
require __DIR__ . '/database/database.php';
$authDB = require_once './database/security.php';
$currentUser = $authDB->isLoggedin();
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';
$articles = $articleDB->fetchAll();
$categories = [];

$selectedCat = $_GET['cat'] ?? '';
if (count($articles)) {
    $cattmp = array_map(fn ($a) => $a['category'],  $articles);
    $categories = array_reduce($cattmp, function ($acc, $cat) {
        if (isset($acc[$cat])) {
            $acc[$cat]++;
        } else {
            $acc[$cat] = 1;
        }
        return $acc;
    }, []);
    $articlePerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article['category']])) {
            $acc[$article['category']] = [...$acc[$article['category']], $article];
        } else {
            $acc[$article['category']] = [$article];
        }
        return $acc;
    }, []);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'includes/head.php' ?>
    <title>Shop</title>
</head>
<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <h1>Nos produits :</h1>
        <div class="newsfeed-container">
        <?php require_once 'includes/sidebar.php' ?>
        <div class="newsfeed-content">
          <?php if (!$selectedCat) : ?>
              <div class="articles-container">
                <?php foreach ($articles as $a) : ?>
                  <div class="product">
                  <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                    <div class="overflow">
                      <div class="img-container" style="background-image:url(<?= $a['image'] ?>"></div>
                    </div>
                    <p><?= $a['title'] ?></p>
                    <p><?= $a['price'] ?> €</p>
                  </a>
                  <a class="add-cart addPanier" href="/update-cart.php?id=<?= $a['id'] ?>">Ajouter au panier<i class="fas fa-shopping-cart add-icon"></i></a>
                  </div>
                <?php endforeach; ?>
              </div>   
          <?php else : ?>
            <div class="articles-container">
              <?php foreach ($articlePerCategories[$selectedCat] as $a) : ?>
                <div class="product">
                <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                  <div class="overflow">
                    <div class="img-container" style="background-image:url(<?= $a['image'] ?>"></div>
                  </div>
                  <h3><?= $a['title'] ?></h3>
                  <h3><?= $a['price'] ?> €</h3>
                </a>
                <a class="add-cart addPanier" href="/update-cart.php?id=<?= $a['id'] ?>">Ajouter au panier<i class="fas fa-shopping-cart add-icon"></i></a>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
        </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div> 
    