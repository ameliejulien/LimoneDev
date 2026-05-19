<?php
    include '../../lib/service/ServiceProduit.php';

    $images = recupererTouslesProduits();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Catalogue</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body class="bg-[#fffdea]">
        <div class="grille-produit">
            <?php 
                foreach($images as $row) {
                    $imageData = stream_get_contents($row['photo_produit']);
                    $base64 = base64_encode($imageData);  
            ?>
                <article class="carte-produit" id_produit="<?= $row['id_produit'] ?>">
                    <img src=<?="data:image/jpeg;base64,$base64" ?> class="w-50 h-50 object-contain m-auto mt-3">
                    <div class="info-produit">
                        <span class="producteur"><i class="fa-solid fa-location-dot"></i>BRETON</span>
                        <h3><?= $row['nom_produit'] ?></h3>
                        <span class="stock <?= $row['stock_produit'] < 1 ? "rupture" : "" ?>">
                            <i class="fa-solid fa-circle"></i>
                            <?= $row['stock_produit'] > 0 ? "En stock" : "Rupture de stock" ?>
                        </span>
                        <div class="pied-produit">
                        <div class="prix-produit">
                            <span class="montant"><?= explode(".", strval($row['prix_ht_produit']))[0] ?>,<span style="font-size:0.7em"><?= explode(".", strval($row['prix_ht_produit']))[1] ?><span class="monnaie"> €</span></span></span>
                        </div>
                        <button class="bouton-ajouter" aria-label="Ajouter au panier" id_produit="<?= $row['id_produit'] ?>">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </div>
    </body>
    <script>
        let panier = [];

        // On créer une date pour mettre une date d'expiration au cookie
        // Sans ça le cookie n'est pas sauvegardé
        const date = new Date();
        date.setDate(date.getDate() + 3 * 24 * 60 * 60 * 1000);

        // Si un cookie existe, on remplit panier avec
        if (document.cookie !== "") {
            panier = JSON.parse(document.cookie.split(';')[0].split('=')[1]);
        }

        let boutonsAjouter = document.getElementsByClassName('bouton-ajouter');

        for (let i = 0; i < boutonsAjouter.length; i++) {
            boutonsAjouter[i].addEventListener('click', (e) => {
                panier.push(parseInt(e.currentTarget.getAttribute('id_produit')));

                // path=/ informe que le cookie est accessible depuis tout le site
                document.cookie = `panier=[${panier}]; expires=${date.toUTCString()}; path=/`;
                console.log(document.cookie);
            });
        }
    </script>
</html> 