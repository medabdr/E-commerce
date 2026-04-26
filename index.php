<?php
require 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// 1. Traitement ajout/modification par l'admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marque']) && isset($_POST['statut'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $marque = mysqli_real_escape_string($conn, trim($_POST['marque']));
        $statut = mysqli_real_escape_string($conn, $_POST['statut']);
        
        $check_stmt = "SELECT id FROM produitstatus WHERE nom = '$marque'";
        $check_res = mysqli_query($conn, $check_stmt);
        
        if (mysqli_num_rows($check_res) > 0) {
            mysqli_query($conn, "UPDATE produitstatus SET statut = '$statut' WHERE nom = '$marque'");
        } else {
            mysqli_query($conn, "INSERT INTO produitstatus (nom, statut) VALUES ('$marque', '$statut')");
        }
        
        header("Location: index.php");
        exit;
    }
}

// 2. Traitement recherche par le client
$statut_trouve = null;
$recherche = null;
if (isset($_GET['recherche_statut']) && !empty(trim($_GET['recherche_statut']))) {
    $recherche = trim($_GET['recherche_statut']);
    $recherche_safe = mysqli_real_escape_string($conn, $recherche);
    
    $search_query = "SELECT statut FROM produitstatus WHERE nom = '$recherche_safe'";
    $search_res = mysqli_query($conn, $search_query);
    
    if ($row = mysqli_fetch_assoc($search_res)) {
        $statut_trouve = strtolower($row['statut']);
    } else {
        $statut_trouve = 'pas trouve';
    }
}

require 'header.php';

$query = "SELECT * FROM produits ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$categories = [
    'Smartphone' => [],
    'Laptop' => [],
    'Tablette' => [],
    'Autre' => []
];


while ($row = mysqli_fetch_assoc($result)) {
    $cat = strtolower($row['categorie'] ?? '');
    if ($cat === 'smartphone') {
        $categories['Smartphone'][] = $row;
    } elseif ($cat === 'laptop') {
        $categories['Laptop'][] = $row;
    } elseif ($cat === 'tablette') {
        $categories['Tablette'][] = $row;
    } else {
        $categories['Autre'][] = $row;
    }
}
?>
<div style="display: flex; justify-content: space-between;padding: 1rem ; align-items: center; margin-bottom: 2rem; ;  height: 270px; border-radius: 12px ; border: 1px solid var(--primary); background-image: linear-gradient(transparent, rgba(0,0,0,0.5)), url('assets/bg8.jpeg'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <div style="filter: contrast(800%) saturate(200%) brightness(260%); width: 250px ; height: 190px ;  margin-top: 9.5rem; background-image: linear-gradient(transparent, rgba(91, 211, 58, 0)), url('assets/save.png'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;" >
         
    </div>
    <div style="display: flex; flex-direction: column;  align-items: center; margin-bottom: 2rem; ; padding: 1rem; height: 250px; border-radius: 12px ; ">
        <h1 style="color: white ; font-size: 2rem; font-weight: bold; text-align: center; font-family: 'Nocturne', serif; padding-top: 1.5rem;">DÉCOUVREZ L'ÉLECTRONIQUE ÉTHIQUE</h1>
        <h1 style="color: white; font-size: 1.5rem; font-weight: bold; text-align: center; font-family: 'Nocturne', serif; padding-top: 0.5rem;">LA TECHNOLOGIE SANS COMPROMIS,</h1>
        <h1 style="color: white; font-size: 1.5rem; font-weight: bold; text-align: center; font-family: 'Nocturne', serif; padding-top: 1rem;">100% AUCUN SOUTIEN À ISRAËL.</h1>

        <a href="index.php#noscategories" class="btn btn-primary"> Voir les catégories<i class="fa fa-arrow-down" style="margin-left: 9px;"> </i></a>
    </div>
    <div style="filter: contrast(300%) saturate(250%) brightness(110%); width: 120px ; height: 140px ;margin-left: 5.5rem;margin-right: 1.5rem;  margin-top: 9.5rem; background-image: linear-gradient(transparent, rgba(91, 211, 58, 0)), url('assets/danger'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;" >
         
    </div>
</div>

<div id="noscategories" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
    <h1>Nos Produits</h1>
    
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            
            <form method="POST" action="" style="display: flex; gap: 0.5rem; align-items: center; background: var(--surface-container-low); padding: 0.5rem; border-radius: 12px; border: 1px solid var(--on-primary);">
                <input type="text" name="marque" class="form-control" placeholder="Nom du produit" required style="width: 160px; padding: 0.5rem;">
                <select name="statut" class="form-control" required style="width: auto; padding: 0.5rem;">
                    <option value="save" style="color: #61ee3e;">Save</option>
                    <option value="danger" style="color: var(--error);">Danger</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ajouter Statut</button>
            </form>
            
            <a href="ajouter_produit.php" class="btn btn-primary">+ Ajouter un produit</a>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
        
        <form method="GET" action="" style="display: flex; gap: 0.5rem; align-items: center; background: var(--surface-container-low); padding: 0.5rem; border-radius: 12px; border: 1px solid var(--on-primary);">

            <input type="text" name="recherche_statut" class="form-control" placeholder="Vérifier une marque..." style="width: 360px; padding: 0.5rem;">
            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;"><i class="fa fa-search"> </i> Vérifier</button>
        </form>
    <?php endif; ?>
</div>

<?php if ($statut_trouve !== null): ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 1.5rem; border-radius: 12px; background: var(--surface-container-highest); border: 1px solid rgba(43,77,86,0.3);">
    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
    <h3 style="margin: 0; font-family: var(--body-font);">Résultat pour "<?= htmlspecialchars($recherche) ?>" :</h3>
    
    <?php if ($statut_trouve === 'save'): ?>
        <span style="color: #61ee3e; font-weight: bold; padding: 0.4rem 0.8rem; border: 1px solid #61ee3e; border-radius: 8px; background: rgba(97, 238, 62, 0.1); display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa fa-check-circle"></i> SAVE
        </span>
    <?php elseif ($statut_trouve === 'danger'): ?>
        <span style="color: var(--error); font-weight: bold; padding: 0.4rem 0.8rem; border: 1px solid var(--error); border-radius: 8px; background: rgba(255, 113, 108, 0.1); display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa fa-exclamation-triangle"></i> DANGER
        </span>
    <?php else: ?>
        <span style="color: var(--on-surface-variant); font-weight: bold; padding: 0.4rem 0.8rem; border: 1px dashed var(--on-surface-variant); border-radius: 8px; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa fa-question-circle"></i> PAS TROUVÉ
        </span>
    <?php endif; ?>
    </div>
    <a href="index.php" class="btn" style="background-color: transparent; color: var(--error);background-color: rgba(255, 113, 108, 0.1);"><i class="fa fa-times"></i></a>
</div>
<?php endif; ?>


<?php foreach ($categories as $nom_cat => $produits): ?>
    <h2 style="margin-top: 3rem; margin-bottom: 1.5rem; color: var(--tertiary); font-family: var(--heading-font); letter-spacing: -0.02em; padding-bottom: 0.5rem; border-bottom: 1px solid var(--surface-container-high);">
        <?= htmlspecialchars($nom_cat) ?>
    </h2>
    
    <div  class="card-grid" style="margin-top: 1.5rem; margin-bottom: 3rem;">
        <?php if (empty($produits)): ?>
            <p style="color:var(--on-surface-variant); grid-column: 1 / -1;">Aucun produit dans cette section.</p>
        <?php else: ?>
            <?php foreach ($produits as $row): ?>
                <div class="card" >
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['nom']) ?>" style="width: 100%; height: 200px; object-fit:cover;  border-radius: 12px; transition: transform 0.3s; margin-bottom: 1rem;">
                    <?php else: ?>
                        <div style="height: 200px; background-color: var(--surface-container-highest); border-radius: 12px; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; color: var(--on-surface-variant);">Pas d'image</div>
                    <?php endif; ?>
                    <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                    <h3 class="card-title"><?= htmlspecialchars($row['nom']) ?></h3>
                    <div style="color:var(--primary); font-size:0.875rem; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;"><?= htmlspecialchars($row['categorie']) ?></div>
                    </div>
                    <div class="card-price"><?= number_format($row['prix']) ?> MRU</div>
                    <div style="color:var(--on-surface-variant); font-size:0.875rem; margin-bottom: 1rem;">En stock: <?= htmlspecialchars($row['stock']) ?></div>
                    
                    <div class="card-actions">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="cart_actions.php" style="flex-grow: 1;">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="produit_id" value="<?= $row['id'] ?>">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                                <button type="submit" class="btn btn-secondary" style="width: 100%;" <?= $row['stock'] <= 0 ? 'disabled' : '' ?>>
                                    <?= $row['stock'] > 0 ? 'Ajouter au panier' : 'Rupture' ?>
                                </button>
                                <?php endif; ?>
                            </form>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="modifier_produit.php?id=<?= $row['id'] ?>" class="btn btn-secondary" title="Modifier">✎</a>
                            <a href="supprimer_produit.php?id=<?= $row['id'] ?>" class="btn btn-danger"  title="Supprimer">✖</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-secondary" style="width: 100%;">Connectez-vous pour acheter</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php 
if (mysqli_num_rows($result) === 0) {
    echo "<p style='text-align:center; color:var(--on-surface-variant); margin-top:2rem;'>La boutique est actuellement vide.</p>";
}
require 'footer.php'; 
?>
