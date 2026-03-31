<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    header('Location: panier.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Begin theoretically safer transaction via tables
    // In procedural mysqli, without full try-catch blocks just insert step-by-step
    
    // 1. Create order
    $insert_commande = "INSERT INTO commandes (user_id) VALUES ($user_id)";
    if (mysqli_query($conn, $insert_commande)) {
        $commande_id = mysqli_insert_id($conn);
        
        // 2. Insert details and update stock
        foreach ($_SESSION['panier'] as $produit_id => $quantite) {
            $insert_detail = "INSERT INTO commande_details (commande_id, produit_id, quantite) VALUES ($commande_id, $produit_id, $quantite)";
            mysqli_query($conn, $insert_detail);
            
            // update stock
            $update_stock = "UPDATE produits SET stock = stock - $quantite WHERE id = $produit_id";
            mysqli_query($conn, $update_stock);
        }
        
        // Clear cart
        $_SESSION['panier'] = [];
        
        require 'header.php';
        echo "<div class='container' style='text-align:center; padding: 4rem 0;'>";
        echo "<h2>Commande validée avec succès !</h2>";
        echo "<p style='color:var(--on-surface-variant); margin-top:1rem;'>Merci pour votre achat.</p>";
        echo "<a href='historique.php' class='btn btn-primary' style='margin-top: 2rem;'>Voir mes commandes</a>";
        echo "</div>";
        require 'footer.php';
        exit;
    } else {
        die("Erreur lors de la création de la commande.");
    }
} else {
    header('Location: panier.php');
}
?>
