<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "commerce";


$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS commerce");
mysqli_select_db($conn, $dbname);


$queries = [
    "CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS produits (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        categorie VARCHAR(255) NOT NULL DEFAULT 'autre',
        prix DECIMAL(10,2) NOT NULL,
        image VARCHAR(500),
        stock INT NOT NULL DEFAULT 0
    )",
    "CREATE TABLE IF NOT EXISTS commandes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
    )",
    "CREATE TABLE IF NOT EXISTS commande_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        commande_id INT NOT NULL,
        produit_id INT NOT NULL,
        quantite INT NOT NULL,
        FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
        FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
    )"
];

foreach ($queries as $query) {
    mysqli_query($conn, $query);
}
?>
