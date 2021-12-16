<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
$currentUser = $authDB->isLoggedin();
if (!$currentUser) {
  header('Location: /');
}
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
const ERROR_TITLE_TOO_SHORT = 'Le titre est trop court';
const ERROR_CONTENT_TOO_SHORT = "L'article est trop court";
const ERROR_IMAGE_URL = "L'image doit être une url valide";
const ERROR_PRICE_URL = "Veuillez renseigner un prix";
$filename = __DIR__ . '/data/articles.json';
$errors = [
  'title' => '',
  'image' => '',
  'category' => '',
  'content' => '',
  'price' => ''
];
$category = '';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';
if ($id) {
  $article = $articleDB->fetchOne($id);
  $title = $article['title'];
  $image = $article['image'];
  $category = $article['category'];
  $content = $article['content'];
  $price = $article['price'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $_POST = filter_input_array(INPUT_POST, [
    'title' => FILTER_SANITIZE_STRING,
    'image' => FILTER_SANITIZE_URL,
    'category' => FILTER_SANITIZE_STRING,
    'price' => FILTER_SANITIZE_NUMBER_INT,
    'content' => [
      'filter' => FILTER_SANITIZE_STRING,
      'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
    ]
  ]);
  $title = $_POST['title'] ?? '';
  $image = $_POST['image'] ?? '';
  $category = $_POST['category'] ?? '';
  $content = $_POST['content'] ?? '';
  $price = $_POST['price'] ?? '';


  if (!$title) {
    $errors['title'] = ERROR_REQUIRED;
  } elseif (mb_strlen($title) < 5) {
    $errors['title'] = ERROR_TITLE_TOO_SHORT;
  }

  if (!$image) {
    $errors['image'] = ERROR_REQUIRED;
  } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
    $errors['image'] = ERROR_IMAGE_URL;
  }

  if (!$price) {
    $errors['price'] = ERROR_REQUIRED;
  }

  if (!$category) {
    $errors['category'] = ERROR_REQUIRED;
  }

  if (!$content) {
    $errors['content'] = ERROR_REQUIRED;
  } elseif (mb_strlen($content) < 50) {
    $errors['content'] = ERROR_CONTENT_TOO_SHORT;
  }

  if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
    if ($id) {
      $article['title'] = $title;
      $article['image'] = $image;
      $article['category'] = $category;
      $article['content'] = $content;
      $article['price'] = $price;
      $articleDB->updateOne($article);
    } else {
      $articleDB->createOne([
        'title' => $title,
        'content' => $content,
        'category' => $category,
        'price' => $price,
        'image' => $image
      ]);
    }
    header('Location: /');
  }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once 'includes/head.php' ?>
  <link rel="stylesheet" href="/public/css/form-article.css">
  <title><?= $id ? 'Modifier' : 'Créer' ?> un article</title>
</head>

<body>
  <div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
      <div class="block p-20 form-container">
        <h1>Ajouter un article</h1>
        <form action="/form-article.php<?= $id ? "?id=$id" : '' ?>" , method="POST">
          <div class="form-control">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= $title ?? '' ?>">
            <?php if ($errors['title']) : ?>
              <p class="text-danger"><?= $errors['title'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label for="image">Image</label>
            <input type="text" name="image" id="image" value="<?= $image ?? '' ?>">
            <?php if ($errors['image']) : ?>
              <p class="text-danger"><?= $errors['image'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label for="category">Catégorie</label>
            <select name="category" id="category">
              <option <?= !$category || $category === 'technologie' ? 'selected' : '' ?> value="technologie">Technologie</option>
              <option <?= $category === 'sport' ? 'selected' : '' ?> value="sport">Sport</option>
              <option <?= $category === 'ville' ? 'selected' : '' ?> value="ville">Ville</option>
            </select>
            <?php if ($errors['category']) : ?>
              <p class="text-danger"><?= $errors['category'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label for="content">Content</label>
            <textarea name="content" id="content"><?= $content ?? '' ?></textarea>
            <?php if ($errors['content']) : ?>
              <p class="text-danger"><?= $errors['content'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" value="<?= $price ?? '' ?>">
            <?php if ($errors['price']) : ?>
              <p class="text-danger"><?= $errors['price'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-actions">
            <a href="/" class="btn btn-secondary" type="button">Annuler</a>
            <button class="btn btn-primary" type="submit"><?= $id ? 'Modifier' : 'Sauvegarder' ?></button>
          </div>
        </form>
      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>

</body>

</html>