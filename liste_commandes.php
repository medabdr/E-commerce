<?php
require 'db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$query = "SELECT c.id as commande_id, c.date, u.id as client_id, u.username as client_nom,
          p.nom as produit_nom, p.prix as prix_unitaire, cd.quantite as quantite,
          (p.prix * cd.quantite) as total_prix
          FROM commandes c
          JOIN utilisateurs u ON c.user_id = u.id
          JOIN commande_details cd ON c.id = cd.commande_id
          JOIN produits p ON cd.produit_id = p.id
          ORDER BY c.date DESC, c.id DESC";

$result = mysqli_query($conn, $query);
?>

<h2>Liste de toutes les commandes</h2>

<?php if (mysqli_num_rows($result) === 0): ?>
    <p>Aucune commande passée sur le site pour le moment.</p>
<?php else: ?>
    <div style="background-color: var(--surface-container-low); border-radius: 16px; padding: 1.5rem; margin-top: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>ID Client</th>
                    <th>Nom Client</th>
                    <th>ID Commande</th>
                    <th>Produit</th>
                    <th>Date</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?= htmlspecialchars($row['client_id']) ?></td>
                    <td><?= htmlspecialchars($row['client_nom']) ?></td>
                    <td>#<?= htmlspecialchars($row['commande_id']) ?></td>
                    <td><?= htmlspecialchars($row['produit_nom']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['quantite']) ?></td>
                    <td><?= number_format($row['prix_unitaire']) ?> MRU</td>
                    <td style="color:var(--primary); font-weight:bold;"><?= number_format($row['total_prix']) ?> MRU</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>
