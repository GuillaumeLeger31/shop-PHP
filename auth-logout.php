<?php
require_once './database/database.php';
$authDB = require_once './database/security.php';

$sessionId = $_COOKIE['session'];
if ($sessionId) {
  $authDB->logout($sessionId);
  header('Location: /auth-login.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once 'includes/head.php' ?>
  <link rel="stylesheet" href="/public/css/auth-logout.css">
  <title>Deconnexion</title>
</head>

<body>

    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <h1>Deconnexion</h1>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
    
</body>

</html>