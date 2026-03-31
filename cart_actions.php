<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $produit_id = intval($_POST['produit_id']);

    if ($action === 'add') {
        if (isset($_SESSION['panier'][$produit_id])) {
            $_SESSION['panier'][$produit_id]++;
        } else {
            $_SESSION['panier'][$produit_id] = 1;
        }
        header('Location: panier.php');
        exit;
    } elseif ($action === 'remove') {
        if (isset($_SESSION['panier'][$produit_id])) {
            unset($_SESSION['panier'][$produit_id]);
        }
        header('Location: panier.php');
        exit;
    } elseif ($action === 'update') {
        $quantite = intval($_POST['quantite']);
        if ($quantite > 0) {
            $_SESSION['panier'][$produit_id] = $quantite;
        } else {
            unset($_SESSION['panier'][$produit_id]);
        }
        header('Location: panier.php');
        exit;
    }
}

header('Location: index.php');
exit;
?>
