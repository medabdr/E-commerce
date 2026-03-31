<?php
require 'db.php';
require 'header.php';
require_once 'saveimages.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = floatval($_POST['prix']);
    $categorie = mysqli_real_escape_string($conn, $_POST['categorie']);
    $uploadedImagePath = uploadImage('image');
    $image = $uploadedImagePath ? mysqli_real_escape_string($conn, $uploadedImagePath) : '';
    $stock = intval($_POST['stock']);

    $query = "INSERT INTO produits (nom, categorie, prix, image, stock) VALUES ('$nom', '$categorie', $prix, '$image', $stock)";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
        exit;
    } else {
        $message = "Erreur lors de l'ajout.";
    }
}
?>

<div class="container" style="max-width: 600px;">
    <h2>Ajouter un Produit</h2>
    <?php if ($message): ?>
        <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-label">Nom du produit</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">catégorie</label>
            <select name="categorie" class="form-control" required>
            <option value="Smartphone">Smartphone</option>
            <option value="Laptop">Laptop</option>
            <option value="Tablette">Tablette</option>
            <option value="Autre">Autre</option>


           </select>
            
            
        </div>
        <div class="form-group">
            <label class="form-label">Prix MRU</label>
            <input type="number" step="0.01" name="prix" class="form-control" required>
        </div>
        <style>
            .custom-file-input::-webkit-file-upload-button {
                background: var(--primary, #00C896);
                color: var();
                border: none;
                padding: 0.4rem 1rem;
                border-radius: 4px;
                cursor: pointer;
                font-family: inherit;
                font-weight: 500;
                transition: background 0.3s;
                margin-right: 10px;
            }
            .custom-file-input::-webkit-file-upload-button:hover {
                background: var(--primary-dim, #00A37A);
            }
        </style>
        <div class="form-group">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control custom-file-input" style="padding: 0.4rem; background: var(--surface, #1e1e2e);  border: 1px solid var(--border, #333); border-radius: 8px; cursor: pointer;">
        </div>
        <div class="form-group">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="10" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Ajouter</button>
    </form>
</div>

<?php require 'footer.php'; ?>
