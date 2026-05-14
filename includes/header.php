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
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <div class="glow-path"></div>
    <header class="nav">
        <div class="nav-brand"><a href="<?= BASE_URL ?>index.php">Alternatives à la Résistance</a></div>
        <div class="nav-links">
            <a href="<?= BASE_URL ?>index.php"><i class="fa fa-home"></i> Produits</a>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'client'): ?>
                <a href="<?= BASE_URL ?>pages/panier.php"><i class="fa fa-shopping-cart"></i> Panier</a>
                <a href="<?= BASE_URL ?>pages/historique.php"><i class="fa fa-history"></i> Historique</a>            
                <a href="<?= BASE_URL ?>pages/logout.php"> <i class="fa fa-sign-out" style="color: #f17373ff;"></i> Déconnexion </a>
            <?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>pages/admin/liste_commandes.php" ><i class="fa fa-list"></i> Commandes </a>
                <a href="<?= BASE_URL ?>pages/logout.php"> <i class="fa fa-sign-out" style="color: #f17373ff;"></i> Déconnexion </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>pages/login.php"><i class="fa fa-sign-in" style="color: #61ee3eff;"></i> Connexion</a>
                
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
