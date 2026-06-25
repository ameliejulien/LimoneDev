<?php 
require_once __DIR__ . '/../../lib/Constantes.php';

?>
<footer class="footer">
    <div class="footer-interieur">
        <?php if ($typeUtilisateur !== TYPE_VENDEUR): ?>
            <a href="/Catalogue/index.php">
                <img src="/ui/img/logo.png" alt="Logo Alizon" class="footer-logo" />
            </a>
        <?php else: ?>
            <a href="/Catalogue/CatalogueVendeur.php">
                <img src="/ui/img/logo.png" alt="Logo Alizon" class="footer-logo" />
            </a>
        <?php endif; ?>
        <span class="footer-copyright">© <?= date('Y') ?> Alizon — Tous droits réservés</span>
    </div>
</footer>