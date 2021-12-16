<?php
if (session_id() == '' || !isset($_SESSION)) {session_start();}
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
$currentUser = $authDB->isLoggedin();
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'includes/head.php' ?>
    <title>Panier</title>
</head>
<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <h1>Panier :</h1>
            <div class="Cart">
            <div class="shopping-cart">
                <div class="shopping-cart-header">
                    <?php if (isset($_SESSION["cart"]) && $sum > 0) : ?>
                    <i class="fa fa-shopping-cart cart-icon"></i><span class="badge" id="panier2"> <?php if(isset($_SESSION["cart"])) {echo($json['sum']);} ?></span><span class="nbr-article" > Articles</span>
                    <div class="shopping-cart-total">
                        <span class="lighter-text">Total : </span>
                        <span><span id="total"><?php if(isset($_SESSION["cart"])) {echo($json['total']);} ?></span> €</span>
                    </div>
                    <?php else : ?>
                        <span class="vide">votre panier est vide. </span>
                    <?php endif; ?>
                </div>
                <?php if( isset($_SESSION["cart"]) && $json['panier'] > 0) foreach ($json['panier'] as $a => $json['qty']) : ?>
                <?php $result = $pdo->query('SELECT title, image, price FROM article WHERE id=' . $a) ?>
                <?php if($json['qty'] > 0) foreach ($result as $b) : ?>
                    <ul class="shopping-cart-items">
                        <div class="item-image" style="background-image:url(<?= $b['image'] ?>"></div>
                        <li class="clearfix">
                            <span class="item-name"><?= ($b["title"]) ?></span>
                            <span class="item-price"><?= ($b["price"]) ?>€</span>
                            <span class="item-quantity">Quantity : <span class="item-quantity qty<?php echo($a) ?>" ><?php  {echo($json['qty']);} ?></span></span>
                        </li>
                        <div class="item-add">
                        <a class="addPanier" href="/updown-cart.php?id=<?= $a ?>"><i class="fas fa-minus"></i></a>
                        <a class="addPanier" href="/update-cart.php?id=<?= $a ?>"><i class="fas fa-plus"></i></a>
                        </div>
                    </ul>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <div class="checkout-card">
                <div id="paypal-button-container"></div>
            </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
    <script>paypal.Buttons({
    createOrder: function(data, actions) {
        // This function sets up the details of the transaction, including the amount and line item details.
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: <?= $json['total'] ?>
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
          // This function shows a transaction success message to your buyer.
          alert('Transaction completed by ' + details.payer.name.given_name);
        });
      }
}).render('#paypal-button-container');</script>
