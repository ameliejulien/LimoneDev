<?php

    require_once ("../../lib/service/ServiceUtilisateur.php");

    droitsAccesPagePanier($_COOKIE['uuid'], 2);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Panier/style.css">
    <script src="../snackbar.js"></script>
    <title>Panier</title>
</head>

<?php
require_once '../ui/header.php';
require_once '../../lib/service/ServicePanier.php';

$panier = getPanierIDs();
$arts = getPanierArticles($panier);
$quantiteProduitArray = array_count_values($panier);

$prixTotalHt  = 0;
$prixTotalTtc = 0;
?>

<body>

        <h1>Panier</h1>

        <div class="snackbar">
            <h3 class="snackbarTitle"></h3>
            <p class="snackbarText"></p>
        </div>

        <div class="panier">
            <h2>Produits du panier</h2>

            <?php
            foreach ($quantiteProduitArray as $produitId => $quantiteProduit) {
                foreach ($arts as $art) {
                    if ($art["id_produit"] == $produitId) {

                        $tvaArt = $art['tva_produit'] ?? 20;
                        $prixUnitaireTtc = round($art['prix_ht_produit'] * (1 + $tvaArt / 100), 2);
                        $sousTotalTtc    = round($prixUnitaireTtc * $quantiteProduit, 2);

                        $prixTotalHt  += $art['prix_ht_produit'] * $quantiteProduit;
                        $prixTotalTtc += $sousTotalTtc;
                        ?>

                        <div class="article-container" id="article-id-<?= $art["id_produit"] ?>">
                            <div class="article-grid">

                                <div class="article-image">
                                    <a href="<?= "/Produit/Produit.php?id=" . $art["id_produit"] ?>">
                                        <img src="<?= $art['photo_produit'] ? "../imagesProduits/" . $art['photo_produit'] : '../imagesProduits/placeholder.png' ?>" class="image">
                                    </a>
                                </div>

                                <h3 class="article-name">
                                    <a href="<?= "/Produit/Produit.php?id=" . $art["id_produit"] ?>">
                                        <?= $art["nom_produit"] ?>
                                    </a>
                                </h3>

                                <span class="article-description">
                                    <a href="<?= "/Produit/Produit.php?id=" . $art["id_produit"] ?>">
                                        <?= $art["description_produit"] ?>
                                    </a>
                                </span>

                                <div class="article-price">
                                    <span>Quantité : <?= $quantiteProduit ?></span>

                                    <div class="prix-principal-ligne">
                                        <?= number_format($prixUnitaireTtc, 2, ',', ' ') ?> €<span class="mention-ht"></span> × 
                                        <?= $quantiteProduit ?> = <strong><?= number_format($sousTotalTtc, 2, ',', ' ') ?> €</strong>
                                    </div>

                                    <button onclick="supprimerArticleDuPanier(<?= $art['id_produit'] ?>)">Supprimer</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>

            <form class="panier-options" action="/Paiement">
                <div class="total-bloc">
                    <div class="prix-principal">
                        <span class="montant-total"><?= number_format($prixTotalTtc, 2, ',', ' ') ?> €</span>
                        <span class="mention-ht">TTC</span>
                    </div>
                    <div class="prix-ttc">
                        soit <?= number_format($prixTotalHt, 2, ',', ' ') ?> € HT
                    </div>
                </div>
                <?php if (empty($quantiteProduitArray)):?>
                    <p>Votre panier est vide.</p>
                <?php else: ?>
                    <button type="submit">Payer</button>
                <?php endif; ?>
            </form>
        </div>
    <?php require '../ui/footer.php'; ?>
</body>

<script src="/Panier/script.js"></script>

</html>