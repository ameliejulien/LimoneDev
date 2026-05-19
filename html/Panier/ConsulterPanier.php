<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="panier.css">
    <script src="consulterPanier.js"></script>
    <title>Compte Client</title>
</head>

<?php
chdir(__DIR__ . '/../../');
require_once 'lib/service/ServicePanier.php';

// setcookie('panier', json_encode([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])); // TODO Penser à changer ça =)

$panier = getPanierIDs();
$arts = getPanierArticles($panier);
print_r("COOKIE PANIER = " . $_COOKIE['panier']);
?>

<body>
    <h1>
        Panier
    </h1>
    <div class="cart">
        <h2>Articles du panier</h2>

        <?php
        foreach ($arts as $art) {
            $imageData = stream_get_contents($art['photo_produit']);
            $base64 = base64_encode($imageData);
            ?>

            <div class="article-container">
                <div class="article">

                    <div class="article-image">
                        <img src=<?= "data:image/jpeg;base64,$base64" ?> class="image">
                    </div>

                    <div class="article-content">

                        <h3 class="article-name"><?= $art["nom_produit"] ?></h3>

                        <span class="article-description">

                            <?= $art["description_produit"] ?>

                        </span>

                        <div class="article-price">

                            <span><?= $art["prix_ht_produit"] ?>€</span>

                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
</body>

</html>