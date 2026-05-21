<?php
include '../../lib/service/ServiceProduit.php';
include '../../lib/service/ServiceVendeur.php';

$produits = recupererlesProduits();

$prix = array_column($produits, 'prix_ht_produit');
$prixMin = (int) floor(min($prix));
$prixMax = (int) ceil(max($prix));

$categories = recupererLesCategories();

$vendeurs = recupererLesVendeurs();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Catalogue</title>
        <link rel="stylesheet" type="text/css" href="/Catalogue/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="../snackbar.js"></script>
    </head>
    <body class="bg-[#fffdea]">

        <?php require_once '../ui/header.php'; ?>

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
                        <span class="card-prix-display"><span class="prix-min-val"><?= $prixMin ?></span> € — <span
                                class="prix-max-val"><?= $prixMax ?></span> €</span>
                    </div>
                    <div class="range-slider">
                        <div class="range-fill"></div>
                        <input type="range" class="min-price" min="<?= $prixMin ?>" max="<?= $prixMax ?>"
                            value="<?= $prixMin ?>" step="1">
                        <input type="range" class="max-price" min="<?= $prixMin ?>" max="<?= $prixMax ?>"
                            value="<?= $prixMax ?>" step="1">
                    </div>
                </div>

                <div>
                    <div class="card-titre">
                        <h4>Catégories</h4>
                    </div>
                    <div class="categories">
                        <div class="categorie">
                            <input type="radio" id="c-0" name="c" value="Tous" checked>
                            <label for="c-0">Tous</label>
                        </div>
                        <?php
                        foreach ($categories as $c) {
                            ?>
                            <div class="categorie">
                                <input type="radio" id="c-<?= $c['id_categorie'] ?>" name="c"
                                    value="<?= $c['nom_categorie'] ?>">
                                <label for="c-<?= $c['id_categorie'] ?>"><?= $c['nom_categorie'] ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div>
                    <div class="card-titre">
                        <h4>Vendeurs</h4>
                    </div>
                    <div class="vendeurs">
                        <div class="vendeur">
                            <input type="radio" id="v-0" name="v" value="Tous" checked>
                            <label for="v-0">Tous</label>
                        </div>
                        <?php
                        foreach ($vendeurs as $v) {
                            ?>
                            <div class="vendeur">
                                <input type="radio" id="v-<?= $v['id_vendeur'] ?>" name="v"
                                    value="<?= $v['denomination_vendeur'] ?>">
                                <label for="v-<?= $v['id_vendeur'] ?>"><?= $v['denomination_vendeur'] ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="affichage-produits">

                <div class="tete-produits">
                    <h2 class="compte-produits"><strong class="nombre-produits"><?= count($produits) ?></strong> produits
                        trouvés</h2>
                    <select class="tri">
                        <option value="dec">Prix décroissant</option>
                        <option value="cro">Prix croissant</option>
                        <option value="AZ">A -> Z</option>
                        <option value="ven">Nombre de ventes</option>
                    </select>
                </div>

                <div class="grille-produit">
                    <?php
                    foreach ($produits as $row) {
                        ?>
                        <article class="carte-produit" id_produit="<?= $row['id_produit'] ?>"
                            data-prix="<?= $row['prix_ht_produit'] ?>" data-categorie="<?= $row['id_categorie'] ?>"
                            data-vendeur="<?= $row['id_vendeur'] ?>" data-ventes="<?= $row['nb_ventes_produit'] ?>">
                            <img src=<?= $row['photo_produit'] ? "../imagesProduits/" . $row['photo_produit'] : '../imagesProduits/placeholder.png' ?> class="w-50 h-50 object-contain m-auto mt-3">
                            <div class="info-produit">
                                <span class="producteur"><i
                                        class="fa-solid fa-location-dot"></i><?= $row['denomination_vendeur'] ?></span>
                                <h3><?= $row['nom_produit'] ?></h3>
                                <span class="stock <?= $row['stock_produit'] < 1 ? "rupture" : "" ?>">
                                    <i class="fa-solid fa-circle"></i>
                                    <?= $row['stock_produit'] > 0 ? "En stock" : "Rupture de stock" ?>
                                </span>
                                <div class="pied-produit">
                                    <div class="prix-produit">
                                        <span class="montant"><?= explode(".", strval($row['prix_ht_produit']))[0] ?>,<span
                                                style="font-size:0.7em"><?= explode(".", strval($row['prix_ht_produit']))[1] ?><span
                                                    class="monnaie"> €</span></span></span>
                                    </div>
                                    <button class="button" aria-label="Ajouter au panier"
                                        id_produit="<?= $row['id_produit'] ?>">
                                        <i class="fa-solid fa-basket-shopping"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>

            </div>
        </div>
    </body>
    <script>
        const sliderMin = document.querySelector('.min-price');
        const sliderMax = document.querySelector('.max-price');
        const fill = document.querySelector('.range-fill');
        const valMin = document.querySelector('.prix-min-val');
        const valMax = document.querySelector('.prix-max-val');
        const grille = document.querySelector('.grille-produit');
        const tri = document.querySelector('.tri');
        const compteProduits = document.querySelector('.nombre-produits');
        const produits = document.querySelectorAll('.carte-produit');
        const searchBar = document.querySelector('.header-recherche-champ');

        const params = new URLSearchParams(document.location.search);
        const searchParam = params.get('q');

        produits.forEach(produit => {
            produit.addEventListener('click', (e) => {
                const id = produit.getAttribute('id_produit');
                window.location.href = `../Produit/Produit.php?id=${id}`;
            });
        });

        document.querySelectorAll('button').forEach(bouton => {
            bouton.addEventListener('click', (e) => {
                e.stopPropagation();
                const loader = document.getElementById('loader');
                loader.classList.remove('hidden');

                fetch('../API/AjoutPanier.php', {
                    method: 'POST',
                    body: JSON.stringify({ id_produit: e.currentTarget.getAttribute('id_produit') })
                }).then(response => {
                    if (response.status === 200) {
                        afficherSnackBar('Succes', 'Le produit a été ajouté au panier avec succès');
                    } else {
                        afficherSnackBar('Erreur', 'Une erreur est survenue');
                    }
                }).finally(() => {
                    loader.classList.add('hidden');

                    const cookies = Object.fromEntries(
                        document.cookie.split('; ').map(c => {
                            const [key, val] = c.split('=');
                            return [key, JSON.parse(decodeURIComponent(val))];
                        })
                    );

                    document.querySelector('.header-panier-compteur').textContent = cookies.panier.length;
                });
            })
        });

        function filtrerProduits() {
            let i = produits.length;

            //////////
            // Prix //
            //////////

            const min = parseInt(sliderMin.value);
            const max = parseInt(sliderMax.value);
            const total = sliderMin.max - sliderMin.min;

            fill.style.left = ((min - sliderMin.min) / total) * 100 + '%';
            fill.style.right = (((sliderMin.max - sliderMax.value) / total) * 100) + '%';

            valMin.textContent = min;
            valMax.textContent = max;

            produits.forEach(produit => {
                const prix = parseFloat(produit.dataset.prix);

                if (prix >= min && prix <= max) {
                    produit.style.display = '';
                } else {
                    produit.style.display = 'none';
                    i--;
                }
            });

            ///////////////
            // Catégorie //
            ///////////////

            const categorie = document.querySelector('input[name="c"]:checked');

            produits.forEach(produit => {
                const categorieProduit = produit.dataset.categorie;
                if ((categorie.id.split('-')[1] === '0' || categorie.id.split('-')[1] === categorieProduit) && produit.style.display !== 'none') {
                    produit.style.display = '';
                } else if (produit.style.display === 'none') {
                    produit.style.display = 'none';
                } else {
                    produit.style.display = 'none';
                    i--;
                }
            });

            /////////////
            // Vendeur //
            /////////////

            const vendeur = document.querySelector('input[name="v"]:checked');

            produits.forEach(produit => {
                const vendeurProduit = produit.dataset.vendeur;
                if ((vendeur.id.split('-')[1] === '0' || vendeur.id.split('-')[1] === vendeurProduit) && produit.style.display !== 'none') {
                    produit.style.display = '';
                } else if (produit.style.display === 'none') {
                    produit.style.display = 'none';
                } else {
                    produit.style.display = 'none';
                    i--;
                }
            });

            ///////////////
            // Recherche //
            ///////////////

            if (searchParam) {
                searchBar.value = searchParam;

                produits.forEach(produit => {
                    if ((produit.children[1].children[1].textContent.includes(searchParam.toLowerCase())) && produit.style.display !== 'none') {
                        produit.style.display = '';
                    } else if (produit.style.display === 'none') {
                        produit.style.display = 'none';
                    } else {
                        produit.style.display = 'none';
                        i--;
                    }
                });
            }

            compteProduits.textContent = i;
        }

        sliderMin.addEventListener('input', () => {
            if (parseInt(sliderMin.value) > parseInt(sliderMax.value))
                sliderMin.value = sliderMax.value;
            filtrerProduits();
        });
        
        sliderMax.addEventListener('input', () => {
            if (parseInt(sliderMax.value) < parseInt(sliderMin.value))
                sliderMax.value = sliderMin.value;
            filtrerProduits();
        });
        
        document.querySelectorAll('.categorie').forEach(categorie => {
            categorie.addEventListener('change', (e) => {
                filtrerProduits();
            });
        });

        document.querySelectorAll('.vendeur').forEach(categorie => {
            categorie.addEventListener('change', (e) => {
                filtrerProduits();
            });
        });

        function trierProduits() {
            switch (tri.value) {
                case 'cro':
                    [...grille.children].sort((a, b) =>
                        parseFloat(a.dataset.prix) > (b.dataset.prix)).forEach(node => {
                            grille.appendChild(node);
                        }
                        );
                    break;
                case 'dec':
                    [...grille.children].sort((a, b) =>
                        parseFloat(a.dataset.prix) < (b.dataset.prix)).forEach(node => {
                            grille.appendChild(node);
                        }
                        );
                    break;
                case 'AZ':
                    [...grille.children].sort((a, b) =>
                        a.children[1].children[1].textContent > b.children[1].children[1].textContent).forEach(node => {
                            grille.appendChild(node);
                        }
                        );
                    break;
                case 'ven':
                    [...grille.children].sort((a, b) =>
                        parseInt(a.dataset.ventes) < parseInt(b.dataset.ventes)).forEach(node => {
                            grille.appendChild(node);
                        }
                        );
                    break;
            }
        }

        document.querySelector('.tri').addEventListener('change', (e) => {
            trierProduits();
        });

        filtrerProduits();
        trierProduits();
    </script>
</html>