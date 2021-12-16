<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
$currentUser = $currentUser ?? false;
$isAdmin = $currentUser['isAdmin'] ?? false;


if(isset($_SESSION["cart"])) {
  $json['panier'] = $_SESSION['cart'];
  $sum = 0;
  foreach($json['panier'] as $product => $quantity) {
  $sum+= $quantity;
}
$json['sum'] = $sum;
}

if(isset($_SESSION["cart"])) {
$json['panier'] = $_SESSION['cart'];
$total = 0;
foreach ($json['panier'] as $a => $quantity) { 
    $result = $pdo->query('SELECT title, image, price FROM article WHERE id=' . $a);
    foreach ($result as $b) {
         $total+=$b["price"] * $quantity;
    }
  }

$json['a'] = $a;
$json['qty'] = $quantity;
$json['total'] = $total;
}
?>

<head>
  <?php require_once 'includes/head.php' ?>
  <link rel="stylesheet" href="/public/css/header.css">
</head>

<header>
<a href="index.php"><h1>Shop</h1></a>
    <div  class="header-search" id="searchbar">
    <i class="fas fa-search"></i>
    <input v-model="searchKey" type="search" class="search" placeholder="Chercher un produit">
    <ul class="header-search-result" v-if="searchKey?.length">
    <a class="prd" v-for="product, id in search" :key="product.id" v-bind:href="'/show-article.php?id=' + product.id">{{product.title}}</a>
    </ul>
    </div>
  <ul class="header-menu" id="menu">
    <li>
      <a href="/index.php"><i class="fas fa-home cart-icon"></i></a>
    </li>
    <li><a href="#"><i class="fas fa-user cart-icon"></i></a>
      <ul class="Level1">
      <?php if ($currentUser) : ?>
    <li>
      <a href="/profile.php">Profil</a>
    </li>
    <li>
      <a href="/auth-logout.php">Logout</a>
    </li>
    <?php else : ?>
    <li>
      <a href="/auth-login.php">Login</a>
    </li>
    <li>
      <a href="/auth-register.php">Register</a>
    </li>
    <?php endif; ?>
      </ul>
    </li>
    <li>
      <a href="/cart.php"><i class="fas fa-shopping-cart cart-icon"></i><span id="panier"> <?php if(isset($_SESSION["cart"])) {echo($json['sum']);} ?> </span></a>
    </li>
  </ul>
</header>