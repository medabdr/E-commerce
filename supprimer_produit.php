<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM produits WHERE id=$id";
    mysqli_query($conn, $query);
}

header('Location: index.php');
exit;
?>
