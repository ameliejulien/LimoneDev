<?php

    require_once ('../../lib/service/ServiceProduit.php');
    require_once ('../../lib/service/ServiceVendeur.php');

    $typeUtilisateur = trouverTypeUtilisateur($_COOKIE['uuid'])['type_utilisateur'];
    $idUtilisateur = trouverIDUtilisateur($_COOKIE['uuid']);


    $produitVide = false;
    if ($typeUtilisateur == 2) {
        $produits = trouverLesProduitsVendeur($idUtilisateur);
        if (count($produits) == 0) {
            $produitVide = true;
        }

    } else {
        $produits = recupererlesProduits();
    }

    if (count($produits) > 0) {
        $prix = array_column($produits, 'prix_ht_produit');
        if ($prix != null) {
            $prixMin = (int) floor(min($prix));
            $prixMax = (int) ceil(max($prix));  
        }
    }
    

    $categories = recupererLesCategories();

    $vendeurs = recupererLesVendeurs();
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Catalogue</title>
        <link rel="stylesheet" type="text/css" href="/Catalogue/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
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

        <?php if ($typeUtilisateur != 2) { ?>
            <section class="presentation">
                <div class="container">
                    <h1>Le meilleur de la <span class="accent">Bretagne</span>, en un seul panier.</h1>
                    <p class="lead">Pâtisseries, boissons, déco, coffrets — sélectionnés auprès de coopératives et producteurs locaux.</p>
                    <div class="presentation-stats">
                        <div class="stat"><i class="fa-solid fa-leaf"></i> <span><strong>100%</strong> origine Bretagne</span></div>
                        <div class="stat"><i class="fa-solid fa-truck-fast"></i> <span>Expédition sous <strong>48h</strong></span></div>
                    </div>
                </div>
            </section>
        <?php } ?>



        <div class="main-frame">
            <div class="partie-gauche">
                <div class="card">
                    <?php if (!$produitVide) { ?>
                        <div>
                            <div class="card-titre">
                                <h4>Prix</h4>
                                <span class="card-prix-display">
                                    <span class="prix-min-val"><?= $prixMin ?></span> € — 
                                    <span class="prix-max-val"><?= $prixMax ?></span> €</span>
                            </div>
                            <div class="range-slider">
                                <div class="range-fill"></div>
                                    <input type="range" class="min-price" min="<?= $prixMin ?>" max="<?= $prixMax ?>" value="<?= $prixMin ?>" step="1">
                                    <input type="range" class="max-price" min="<?= $prixMin ?>" max="<?= $prixMax ?>" value="<?= $prixMax ?>" step="1">
                            </div>
                        </div>
                    <?php } ?>

                    <div>
                        <?php if (!$produitVide) { ?>
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
                                    <input type="radio" id="c-<?= $c['id_categorie'] ?>" name="c" value="<?= $c['nom_categorie'] ?>">
                                    <label for="c-<?= $c['id_categorie'] ?>"><?= $c['nom_categorie'] ?></label>
                                </div>
                            <?php } ?>
                        </div>  
                        <?php } ?>
                    </div>

                    <?php if ($typeUtilisateur != 2) { ?>
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
                                        <input type="radio" id="v-<?= $v['id_vendeur'] ?>" name="v" value="<?= $v['denomination_vendeur'] ?>">
                                        <label for="v-<?= $v['id_vendeur'] ?>"><?= $v['denomination_vendeur'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } else if ($typeUtilisateur == 2) {?>
                        <div class="buttonStock">
                            <button type="button" onclick="window.location.href = '../Stock';">Consulter le stock</button>
                        </div>
                    <?php } ?>

                    <?php if ($produitVide) {?>
                        <div class="buttonStock">
                            <button type="button" onclick="window.location.href = '../Produit/CreerProduit.php';">Créer un produit</button>
                        </div>
                    <?php } ?>
                </div>

                <div id="map"></div>
            </div>

            <div class="affichage-produits">
                <?php if (!$produitVide) { ?>
                <div class="tete-produits">
                    <h2 class="compte-produits"><strong class="nombre-produits"><?= count($produits) ?></strong> produits trouvés</h2>
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
                            $tva     = $row['tva_produit'] ?? 20;
                            $prixTtc = round($row['prix_ht_produit'] * (1 + $tva / 100), 2);
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
                                            <span class="montant"><?= explode(".", strval($prixTtc))[0] ?>,<span
                                                    style="font-size:0.7em"><?= str_pad(explode(".", strval($prixTtc))[1] ?? '00', 2, '0') ?><span
                                                        class="monnaie"> €</span></span></span>
                                        </div>
                                        <?php if ($typeUtilisateur != 2) { ?>
                                            <button class="button" aria-label="Ajouter au panier"
                                                id_produit="<?= $row['id_produit'] ?>">
                                                <i class="fa-solid fa-basket-shopping"></i>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php 
            require_once '../ui/footer.php';
        ?>
    </body>
    <?php if ($typeUtilisateur != 2 ) { ?>
        <!-- Leaflet -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <?php } ?>
    <script src="/Catalogue/catalogue.js"></script>
</html>