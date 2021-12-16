<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
require_once './database/database.php';
$authDB = require_once './database/security.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$id = $_GET['id'];
if(!isset($_SESSION['cart'][$id]))
$_SESSION['cart'][$id] = 1;
else
$_SESSION['cart'][$id]++;



$json['panier'] = $_SESSION['cart'];
$sum = 0;

foreach($json['panier'] as $product => $quantity) {
    $sum+= $quantity;
}


$total = 0;
foreach ($json['panier'] as $a => $quantity) { 
    $result = $pdo->query('SELECT title, image, price FROM article WHERE id=' . $a);
    foreach ($result as $b) {
        $total+=$b["price"] * $quantity;
    }
}
$json['id'] = $id;
$json['total'] = $total;
$json['sum'] = $sum;
echo json_encode($json);

?>
