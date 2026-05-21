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
        foreach ($arts as $art) {
            $imageData = stream_get_contents($art['photo_produit']);
            $base64 = base64_encode($imageData);
            $prixTotal = $prixTotal + $art["prix_ht_produit"];
            ?>

            <div class="article-container">
                <div class="article-grid">

                    <div class="article-image">
                        <img src=<?= "data:image/jpeg;base64,$base64" ?> class="image">
                    </div>

                    <h3 class="article-name"><?= $art["nom_produit"] ?></h3>

                    <span class="article-description">

                        <?= $art["description_produit"] ?>

                    </span>

                    <div class="article-price">
                        <span><?= $art["prix_ht_produit"] ?>€</span>
                        <button onclick="">Supprimer</button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <form class="panier-options" action="/Paiement">
            <h3>Prix hors taxes : <?= $prixTotal?>€</h3>
            <button type="submit">Payer</button>
        </form>
    </div>
</body>

<script src="/Panier/script.js"></script>
</html>