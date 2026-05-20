<?php
    include '../../lib/service/ServiceProduit.php';

    $images = recupererTouslesProduits();

    $prix = array_column($images, 'prix_ht_produit');
    $prixMin = (int) floor(min($prix));
    $prixMax = (int) ceil(max($prix));

    $categories = array_unique(array_column($images, 'nom_categorie'));
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Catalogue</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="../snackbar.js"></script>
    </head>
    <body class="bg-[#fffdea]">
        <div id="loader" class="hidden">
            <span class="loader"></span>
            <div class="loader-background"></div>
        </div>

        <div class="snackbar">
            <h3 class="snackbarTitle"></h3>
            <p class="snackbarText"></p>
        </div>

        <div class="main-frame">
            <div class="card">
                <div>
                    <div class="card-titre">
                        <h4>Prix</h4>
                        <span class="card-prix-display"><span class="prix-min-val"><?= $prixMin ?></span> € — <span class="prix-max-val"><?= $prixMax ?></span> €</span>
                    </div>
                    <div class="range-slider">
                        <div class="range-fill"></div>
                        <input type="range" class="min-price" min="<?= $prixMin ?>" max="<?= $prixMax ?>" value="<?= $prixMin ?>" step="1">
                        <input type="range" class="max-price" min="<?= $prixMin ?>" max="<?= $prixMax ?>" value="<?= $prixMax ?>" step="1">
                    </div>
                </div>
                
                <div>
                    <div class="card-titre">
                        <h4>Catégories</h4>
                    </div>
                    <div class="categories">
                        <?php 
                            foreach ($categories as $c) {
                        ?>
                            <div>
                                <input type="checkbox" id="cat-<?= $c ?>" name="<?= $c ?>">
                                <label for="cat-<?= $c ?>"><?= $c ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
                
            <div class="grille-produit">
                <?php 
                    foreach($images as $row) {
                        $imageData = stream_get_contents($row['photo_produit']);
                        $base64 = base64_encode($imageData);  
                ?>
                    <article class="carte-produit" id_produit="<?= $row['id_produit'] ?>" data-prix="<?= $row['prix_ht_produit'] ?>" categorie="<?= $row['id_categorie'] ?>">
                        <img src=<?="data:image/jpeg;base64,$base64" ?> class="w-50 h-50 object-contain m-auto mt-3">
                        <div class="info-produit">
                            <span class="producteur"><i class="fa-solid fa-location-dot"></i><?= $row['denomination_vendeur'] ?></span>
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
        </div>
    </body>
    <script>
        const sliderMin   = document.querySelector('.min-price');
        const sliderMax   = document.querySelector('.max-price');
        const fill        = document.querySelector('.range-fill');
        const valMin      = document.querySelector('.prix-min-val');
        const valMax      = document.querySelector('.prix-max-val');

        function updateSlider() {
            const min   = parseInt(sliderMin.value);
            const max   = parseInt(sliderMax.value);
            const total = sliderMin.max - sliderMin.min;

            fill.style.left  = ((min - sliderMin.min) / total) * 100 + '%';
            fill.style.right = (((sliderMin.max - sliderMax.value) / total) * 100) + '%';
            
            valMin.textContent = min;
            valMax.textContent = max;

            document.querySelectorAll('.carte-produit').forEach(carte => {
                const prix = parseFloat(carte.dataset.prix);
                carte.style.display = (prix >= min && prix <= max) ? '' : 'none';
            });
        }

        sliderMin.addEventListener('input', () => {
            if (parseInt(sliderMin.value) > parseInt(sliderMax.value))
                sliderMin.value = sliderMax.value;
            updateSlider();
        });

        sliderMax.addEventListener('input', () => {
            if (parseInt(sliderMax.value) < parseInt(sliderMin.value))
                sliderMax.value = sliderMin.value;
            updateSlider();
        });

        updateSlider();

        let boutonsAjouter = document.getElementsByClassName('bouton-ajouter');

        for (let i = 0; i < boutonsAjouter.length; i++) {
            boutonsAjouter[i].addEventListener('click', (e) => {
                const loader = document.getElementById('loader');
                loader.classList.remove('hidden');

                fetch('../API/AjoutPanier.php', {
                    method: 'POST',
                    body: JSON.stringify({id_produit: e.currentTarget.getAttribute('id_produit')})
                }).then(response => {
                    if (response.status === 200) {
                        afficherSnackBar('Succes', 'Le produit a été ajouté au panier avec succes');
                    } else {
                        afficherSnackBar('Erreur', 'Une erreur est survenue');
                    }
                }).finally(() => {
                    loader.classList.add('hidden');
                });
            })
        }
    </script>
</html>