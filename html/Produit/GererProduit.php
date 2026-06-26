<?php
    include_once '../../lib/service/ServiceProduit.php';
    include_once '../../lib/service/ServiceUtilisateur.php';

    droitsAccesPage($_COOKIE['uuid'] ?? null, 2);

    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $produit = $id > 0 ? recupererProduitParId($id) : null; ?>

    <script>
        var idProduit;
    </script>

    <?php if (!$produit) {
        $nomProduit     = "";
        $prix           = "";
        $tva            = "";
        $stockProduit        = "";
        $descProduit    = "";
        $estCatalogue   = false;
        $vendeur        = "";
        $cateProduit    = "";
        $photo_produit  = 0;
        
        // Set une variable produit ID = 0 dans le JS ?> 
        <script>
            idProduit = 0;
        </script> 
        
    <?php } else {
        $nomProduit     = $produit['nom_produit'];
        $prix           = $produit['prix_ht_produit'];
        $tva            = $produit['tva_produit'];
        $stockProduit   = $produit['stock_produit'];
        $descProduit    = $produit['description_produit'];
        $estCatalogue   = $produit['catalogue_produit'];
        $vendeur        = $produit['vendeur_produit'];
        $cateProduit    = $produit['nom_categorie'];
        $photo_produit  = $produit['photo_produit'];

        // Set une variable produit ID dans le JS ?> 
        <script>
            idProduit           = <?= $produit['id_produit'] ?>;
            const arrayProduit  = <?= json_encode($produit) ?>;
        </script> 
    <?php }

    $listCategories = recupererLesCategories();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id > 0 ? "$nomProduit" : "Création de produit" ?> — Alizon</title>
    <link rel="stylesheet" href="../Global.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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

    <a href="../Catalogue/index.php" class="retour-catalogue">
        <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
    </a>

    <!-- Contenu principal -->
    <main>
        <form class="produit-page" action="." method="post" enctype="multipart/form-data">
            <!-- Colonne image -->
            <section class="produit-galerie">
                <div class="image-principale-wrapper">
                    <img id="imageProduit" src="<?= $photo_produit > 0 ? "../imagesProduits/".$photo_produit : '../imagesProduits/placeholder.png' ?>" 
                         alt="Image du produit" width="300" height="300">
                </div>
                <input type="file" class="button" id="champImageProduit" name="champImageProduit" 
                       accept="image/*" onchange="changerImage(event)" <?= $photo_produit > 0 ? '' : 'required' ?>>
            </section>

            <!-- Colonne détails -->
            <section class="produit-details">

                <div class="produit-header">
                    <span class="vendeur-tag">
                        <i class="fa-solid fa-location-dot"></i>
                        <?php if (isset($produit['denomination_vendeur'])) $produit['denomination_vendeur']; ?>
                    </span>
                    <span class="categorie-tag">
                        <select name="categorieProduit" id="categorieProduit" required>
                            <?php if ($cateProduit == "") { ?>
                                <option value="">Aucune categorie</option>
                            <?php } ?>
                            <?php foreach ($listCategories as $categorie) { 
                                if ($cateProduit != "" 
                                &&  $cateProduit == $categorie["nom_categorie"]) { ?>
                                    <option value="<?= $categorie["id_categorie"] ?>" selected><?= $categorie["nom_categorie"] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $categorie["id_categorie"] ?>"><?= $categorie["nom_categorie"] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </span>
                </div>

                <h1 class="produit-nom">
                    <div class="form__group field">
                        <input class="form__field" type="text" name="nomProduit" id="nomProduit"
                            placeholder="Nom du produit" required pattern="^.{2}(.?){98}$"
                            title="Nom du produit" value="<?= $nomProduit ?>">
                        <label for="nomProduit" class="form__label">Nom du produit</label>
                    </div>
                </h1>

                <!-- Disponibilité -->
                <div class="stock-ligne form__group field">
                    <input type="text" class="form__field" name="qteProduit" id="qteProduit"
                        placeholder="Quantité produit" pattern="[0-9]+" required
                        title="Quantité du produit" value="<?= $stockProduit ?>">
                    <label for="qteProduit" class="form__label">Quantité produit</label>
                </div>

                <!-- Prix -->
                <div class="prix-bloc">
                    <div class="tva-produit">
                        <div class="form__group field">
                            <input type="text" class="form__field" name="tva" id="tva"
                                placeholder="TVA" pattern="^[0-9]?[0-9][.,]?([0-9]?){2}$" required
                                title="% de TVA appliqué au prix HT" value="<?= $tva ?>">
                            <label for="tva" class="form__label">TVA</label>
                            <span>%</span>
                        </div>
                    </div>
                    <div class="prix-principal">
                        <div class="form__group field">
                            <input type="text" class="form__field" name="prixProduit" id="prixProduit"
                                placeholder="Prix produit" pattern="^[0-9]+[.,]?([0-9]?){2}$" required
                                title="Prix du produit HT" value="<?= $prix ?>">
                            <label for="prixProduit" class="form__label">Prix produit</label>
                            <span class="monnaie"> € HT</span>
                        </div>
                    </div>
                    <div class="prix-ttc">
                        soit <strong id="prixAvecTaxe">0</strong> € TTC (TVA <span id="tvaAffiche">0</span>%)
                    </div>
                </div>

                <div>
                    <span class="indication_champ">Afficher dans le catalogue : </span>
                    <input type="checkbox" name="estDansCatalogue" id="estDansCatalogue"
                           title="Le produit doit etre afficher dans le catalogue"
                           <?php if ($estCatalogue) {?> checked <?php }?>>
                </div>

                <!-- Description -->
                <div class="description-bloc">
                    <div class="form__group field">
                        <textarea class="form__field form__textarea" name="descriptionProduit" id="descriptionProduit"
                                  placeholder="Description" required rows="1" 
                                  oninput="resizeDescription()"
                                  title="Description du produit" minlength="40" maxlength="256"><?= $descProduit ?></textarea>
                        <label for="descriptionProduit" class="form__label">Description</label>
                    </div>
                </div>

                <!-- Quantité + Ajout panier -->
                <div class="action-bloc">
                    <button type="submit"><?= $id > 0 ? "Modifier" : "Créer" ?></button>
                </div>
            </section>
        </form>
    </main>
    <?php require_once '../ui/footer.php'; ?>
</body>
<script src="scriptCreation.js"></script>
<script src="../snackbar.js"></script>
</html>