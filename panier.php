<?php
require 'db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
$total = 0;
?>

<h2>Mon Panier</h2>

<?php if (empty($panier)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <div style="background-color: var(--surface-container-low); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($panier as $id => $quantite): 
                    $query = "SELECT * FROM produits WHERE id = $id";
                    $result = mysqli_query($conn, $query);
                    $produit = mysqli_fetch_assoc($result);
                    if (!$produit) continue;
                    $sous_total = $produit['prix'] * $quantite;
                    $total += $sous_total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nom']) ?></td>
                    <td><?= htmlspecialchars($produit['prix']) ?> MRU</td>
                    <td>
                        <form method="POST" action="cart_actions.php" style="display: flex; gap: 0.5rem; align-items: center;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="produit_id" value="<?= $id ?>">
                            <input type="number" name="quantite" class="form-control" value="<?= $quantite ?>" min="1" max="<?= $produit['stock'] ?>" style="width: 80px; padding: 0.5rem; border-radius: 8px;">
                            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem;">Mettre à jour</button>
                        </form>
                    </td>
                    <td><?= number_format($sous_total, 2) ?> MRU</td>
                    <td>
                        <form method="POST" action="cart_actions.php">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="produit_id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Retirer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(43,77,86,0.3); padding-top: 1.5rem; margin-top: 1.5rem;">
            <h3>Total : <?= number_format($total, 2) ?> MRU</h3>
            <form method="POST" action="checkout.php">
                <button type="submit" class="btn btn-primary" >Valider la commande</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>
