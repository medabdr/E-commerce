    </div> <!-- End of main container -->

    <footer class="main-footer" style="margin-top: 4rem; padding: 3rem 2rem; background: var(--surface-container-low); border-top: 1px solid rgba(97, 238, 62, 0.2); position: relative; overflow: hidden;">
        <div class="glow-path" style="top: -150px; opacity: 0.15;"></div>
        <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; text-align: left;">
            <div>
                <h3 style="color: white; font-family: 'Nocturne', serif; margin-bottom: 1rem; font-size: 1.2rem;">Alternatives à la Résistance</h3>
                <p style="color: var(--on-surface-variant); font-size: 0.9rem; line-height: 1.6;">
                    L'électronique éthique sans compromis. Soutenez la cause en choisissant des produits 100% non boycottés.
                </p>
            </div>
            
            <div>
                <h4 style="color: var(--primary); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.9rem;">Liens Rapides</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.8rem;">
                    <li><a href="<?= BASE_URL ?>index.php" style="color: var(--on-surface-variant); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--on-surface-variant)'"><i class="fa fa-angle-right" style="margin-right: 5px;"></i> Accueil</a></li>
                    <li><a href="<?= BASE_URL ?>pages/panier.php" style="color: var(--on-surface-variant); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--on-surface-variant)'"><i class="fa fa-angle-right" style="margin-right: 5px;"></i> Panier</a></li>
                    <li><a href="<?= BASE_URL ?>pages/login.php" style="color: var(--on-surface-variant); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--on-surface-variant)'"><i class="fa fa-angle-right" style="margin-right: 5px;"></i> Connexion</a></li>
                </ul>
            </div>
            
            <div>
                <h4 style="color: var(--primary); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.9rem;">Contact</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.8rem; color: var(--on-surface-variant); font-size: 0.9rem;">
                    <li><i class="fa fa-envelope" style="margin-right: 0.5rem; color: var(--primary);"></i> contact@alternative.mr</li>
                    <li><i class="fa fa-phone" style="margin-right: 0.5rem; color: var(--primary);"></i> +222 34 84 30 10</li>
                    <li><i class="fa fa-map-marker" style="margin-right: 0.5rem; color: var(--primary);"></i> Nouakchott, Mauritanie</li>
                </ul>
            </div>
        </div>
        
        <div style="max-width: 1200px; margin: 3rem auto 0; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); color: var(--on-surface-variant); font-size: 0.8rem; text-align: center;">
            &copy; <?= date('Y') ?> Alternatives à la Résistance. Tous droits réservés.
        </div>
    </footer>
</body>
</html>
