<?php
require 'db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT c.id as commande_id, c.date, 
          SUM(p.prix * cd.quantite) as total_prix,
          SUM(cd.quantite) as total_articles
          FROM commandes c
          JOIN commande_details cd ON c.id = cd.commande_id
          JOIN produits p ON cd.produit_id = p.id
          WHERE c.user_id = $user_id
          GROUP BY c.id
          ORDER BY c.date DESC";

$result = mysqli_query($conn, $query);
?>

<h2>Historique des commandes</h2>

<?php if (mysqli_num_rows($result) === 0): ?>
    <p>Vous n'avez pas encore passé de commande.</p>
<?php else: ?>
    <div style="background-color: var(--surface-container-low); border-radius: 16px; padding: 1.5rem; margin-top: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>Numéro de Commande</th>
                    <th>Date</th>
                    <th>Articles</th>
                    <th>Total</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                <style>
                    .toggle-checkbox { display: none; }
                    .details-row { display: none; background-color: var(--surface-container-highest); }
                    tr:has(.toggle-checkbox:checked) + .details-row { display: table-row; }
                </style>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?= htmlspecialchars($row['commande_id']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['total_articles']) ?></td>
                    <td style="color:var(--primary); font-weight:bold;"><?= number_format($row['total_prix']) ?> MRU</td>
                    <td>
                        <input type="checkbox" id="toggle_<?= $row['commande_id'] ?>" class="toggle-checkbox">
                        <label for="toggle_<?= $row['commande_id'] ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; cursor: pointer; margin: 0; display: inline-block;">Voir détail</label>
                    </td>
                </tr>
                <tr id="details_<?= $row['commande_id'] ?>" class="details-row">
                    <td colspan="5" style="padding: 1.5rem;">
                        <strong>Produits :</strong>
                        <ul style="margin-top: 0.5rem; color:var(--on-surface-variant);">
                            <?php
                                $c_id = $row['commande_id'];
                                $det_query = "SELECT p.nom, p.prix, cd.quantite FROM commande_details cd JOIN produits p ON cd.produit_id = p.id WHERE cd.commande_id = $c_id";
                                $det_result = mysqli_query($conn, $det_query);
                                while($det_row = mysqli_fetch_assoc($det_result)){
                                    echo "<li>" . htmlspecialchars($det_row['nom']) . " - " . htmlspecialchars($det_row['quantite']) . " x " . number_format($det_row['prix']) . " MRU</li>";
                                }
                            ?>
                        </ul>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>
