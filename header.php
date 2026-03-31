<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Alternative</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <div class="glow-path"></div>
    <header class="nav">
        <div class="nav-brand"><a href="index.php">L'Alternative Éthique</a></div>
        <div class="nav-links">
            <a href="index.php"><i class="fa fa-home"></i> Produits</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="panier.php"><i class="fa fa-shopping-cart">
                     
                </i> Panier</a>
                <a href="historique.php"><i class="fa fa-history"></i> Historique</a>
                <a href="logout.php"> <i class="fa fa-sign-out" style="color: #f17373ff;"></i> Déconnexion </a>
            <?php else: ?>
                <a href="login.php"><i class="fa fa-sign-in" style="color: #61ee3eff;"></i> Connexion</a>
                
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
