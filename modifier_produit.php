<?php
require 'db.php';
require 'header.php';
require_once 'saveimages.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = floatval($_POST['prix']);
    $categorie = mysqli_real_escape_string($conn, $_POST['categorie']);
    $stock = intval($_POST['stock']);

    $uploadedImagePath = uploadImage('image');
    
    if ($uploadedImagePath) {
        $image = mysqli_real_escape_string($conn, $uploadedImagePath);
        $query = "UPDATE produits SET nom='$nom', categorie='$categorie', prix=$prix, image='$image', stock=$stock WHERE id=$id";
    } else {
        $query = "UPDATE produits SET nom='$nom', categorie='$categorie', prix=$prix, stock=$stock WHERE id=$id";
    }
    
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
        exit;
    } else {
        $message = "Erreur lors de la modification.";
    }
}

$query = "SELECT * FROM produits WHERE id=$id";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) === 0) {
    die("Produit introuvable.");
}
$produit = mysqli_fetch_assoc($result);
?>

<div class="container" style="max-width: 600px;">
    <h2>Modifier un Produit</h2>
    <?php if ($message): ?>
        <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-label">Nom du produit</label>
            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($produit['nom']) ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label">Catégorie</label>
            <select name="categorie" class="form-control" required>
                <option value="Smartphone" <?= strtolower($produit['categorie']) == 'smartphone' ? 'selected' : '' ?>>Smartphone</option>
                <option value="Laptop" <?= strtolower($produit['categorie']) == 'laptop' ? 'selected' : '' ?>>Laptop</option>
                <option value="Tablette" <?= strtolower($produit['categorie']) == 'tablette' ? 'selected' : '' ?>>Tablette</option>
                <option value="Autre" <?= strtolower($produit['categorie']) == 'autre' ? 'selected' : '' ?>>Autre</option>
           </select>
        </div>
        <div class="form-group">
            <label class="form-label">Prix (€)</label>
            <input type="number" step="0.01" name="prix" class="form-control" value="<?= htmlspecialchars($produit['prix']) ?>" required>
        </div>
        <style>
            .custom-file-input::-webkit-file-upload-button {
                background: var(--primary, #00C896);
                
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
            <label class="form-label">Image actuelle</label>
            <?php if (!empty($produit['image'])): ?>
                <br><img src="<?= htmlspecialchars($produit['image']) ?>" alt="Image" style="max-height: 100px; margin-bottom: 1rem; border-radius: 8px;">
            <?php else: ?>
                <p style="color:var(--on-surface-variant); font-size: 0.875rem;">Aucune image</p>
            <?php endif; ?>
            <label class="form-label">Remplacer l'image (optionnel)</label>
            <input type="file" name="image" class="form-control custom-file-input" style="padding: 0.4rem; background: var(--surface, #1e1e2e); border: 1px solid var(--border, #333); border-radius: 8px; cursor: pointer;">
        </div>
        <div class="form-group">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= htmlspecialchars($produit['stock']) ?>" required>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Enregistrer</button>
            <a href="index.php" class="btn btn-secondary" style="flex: 1;">Annuler</a>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>
