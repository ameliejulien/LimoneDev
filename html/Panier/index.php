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
$prixTotal = 0;
?>

<body>

        <h1>
            Panier
        </h1>

        <div class="snackbar">
            <h3 class="snackbarTitle"></h3>
            <p class="snackbarText"></p>
        </div>

        <div class="panier">
            <h2>Articles du panier</h2>

            <?php
            // N'affiche pas plusieurs fois les produits 
            foreach ($quantiteProduitArray as $produitId => $quantiteProduit) {
                foreach ($arts as $art) {
                    if ($art["id_produit"] == $produitId) {
                        $prixTotal = $prixTotal + ($art["prix_ht_produit"] * $quantiteProduit); ?>

                        <div class="article-container" id="article-id-<?= $art["id_produit"] ?>">
                            <div class="article-grid">

                                <div class="article-image">
                                    <a href="<?= "/Produit/Produit.php?id=" . $art["id_produit"] ?>">
                                        <img src=<?= $art['photo_produit'] ? "../imagesProduits/" . $art['photo_produit'] : '../imagesProduits/placeholder.png' ?> class="image">
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
                                    <br>
                                    <span><?= $art["prix_ht_produit"] * 1.2 ?>€ x <?= $quantiteProduit ?> =
                                        <?= $art["prix_ht_produit"] * 1.2 * $quantiteProduit ?>€</span>
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
                <h3>Prix avec TVA : <?= $prixTotal * 1.2 ?>€</h3>
                <button type="submit">Payer</button>
            </form>
        </div>
    <?php require '../ui/footer.php'; ?>
</body>

<script src="/Panier/script.js"></script>

</html>