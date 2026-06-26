<?php
    require_once ("../../lib/service/ServiceProduit.php");
    require_once ("../../lib/service/ServiceUtilisateur.php");

    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $produit = $id > 0 ? recupererProduitParId($id) : recupererPremierProduit();

    if (!$produit) {
        header('Location: Catalogue');
        exit;
    }

    if ($id <= 0) {
        header('Location: Produit.php?id=' . $produit['id_produit']);
        exit;
    }

    $prixEntier  = explode(".", strval($produit['prix_ht_produit']))[0];
    $prixDecimal = explode(".", strval($produit['prix_ht_produit']))[1] ?? '00';

    $tva       = $produit['tva_produit'] ?? 20;
    $prixTtc   = round($produit['prix_ht_produit'] * (1 + $tva / 100), 2);

    $prixEntier  = explode(".", strval($prixTtc))[0];
    $prixDecimal = explode(".", strval($prixTtc))[1] ?? '00';

    $enStock    = $produit['stock_produit'] > 0;

    $promotion  = $produit['promotion_produit'] ?? false;
    $reduction  = $produit['reduction_produit'] ?? 0;
    $prixBarre  = null;
    if ($promotion && $reduction > 0) {
        $prixBarre = round($produit['prix_ht_produit'] * (1 + $tva / 100), 2); // barré en TTC aussi, pour rester cohérent avec le prix principal
    }

    droitsAccesPageProduit($_COOKIE['uuid'], 2);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($produit['nom_produit']) ?> — Alizon</title>
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
        <main class="produit-page">

            <!-- Colonne image -->
            <section class="produit-galerie">
                <div class="image-principale-wrapper">
                    <?php if ($promotion && $reduction > 0): ?>
                        <span class="badge-promo">-<?= $reduction ?>%</span>
                    <?php endif; ?>
                    <img
                        src="<?= $produit['photo_produit'] ? "../imagesProduits/" . $produit['photo_produit'] : '../imagesProduits/placeholder.png' ?>"
                        alt="<?= htmlspecialchars($produit['nom_produit']) ?>"
                        class="image-principale"
                    >
                </div>
            </section>

            <!-- Colonne détails -->
            <section class="produit-details">

                <div class="produit-header">
                    <span class="vendeur-tag">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= htmlspecialchars($produit['denomination_vendeur']) ?>
                    </span>
                    <span class="categorie-tag"><?= htmlspecialchars($produit['nom_categorie']) ?></span>
                </div>

                <h1 class="produit-nom"><?= htmlspecialchars($produit['nom_produit']) ?></h1>

                <!-- Disponibilité -->
                <div class="stock-ligne <?= $enStock ? 'en-stock' : 'rupture' ?>">
                    <i class="fa-solid fa-circle"></i>
                    <span><?= $enStock ? 'En stock' : 'Rupture de stock' ?></span>
                    <?php if ($enStock && $produit['stock_produit'] <= 5): ?>
                        <span class="stock-alerte">— Plus que <?= $produit['stock_produit'] ?> disponible<?= $produit['stock_produit'] > 1 ? 's' : '' ?></span>
                    <?php endif; ?>
                </div>

                <!-- Prix -->
                <div class="prix-bloc">
                    <?php if ($prixBarre): ?>
                        <span class="prix-barre"><?= number_format($prixBarre, 2, ',', ' ') ?> €</span>
                    <?php endif; ?>
                    <div class="prix-principal">
                        <span class="montant-entier"><?= $prixEntier ?></span><span class="montant-decimal">,<?= str_pad($prixDecimal, 2, '0') ?><span class="monnaie"> €</span></span>
                        <span class="mention-ht">TTC</span>
                    </div>
                    <div class="prix-ttc">
                        soit <strong><?= number_format($produit['prix_ht_produit'], 2, ',', ' ') ?> €</strong> HT (TVA <?= $tva ?>%)
                    </div>
                </div>

                <!-- Description -->
                <?php if (!empty($produit['description_produit'])): ?>
                <div class="description-bloc">
                    <h2>Description</h2>
                    <p><?= nl2br(htmlspecialchars($produit['description_produit'])) ?></p>
                </div>
                <?php endif; ?>

                <!-- Quantité + Ajout panier -->
                <div class="action-bloc">
                    <!-- Si l'utilisateur est connecté en tant que vendeur, il n'a pas de bouton ajout au panier, mais il peut modifier le produit -->
                    <?php if (droitsAccesProduit($_COOKIE['uuid'], 2) == false): ?>
                    <div class="quantite-selector">
                        <button type="button" class="qty-btn" id="btn-moins" aria-label="Diminuer la quantité">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="qty-val" id="quantite">1</span>
                        <button type="button" class="qty-btn" id="btn-plus" aria-label="Augmenter la quantité">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (droitsAccesProduit($_COOKIE['uuid'], 2) == true): ?>
                    <button type="button" class="bouton-panier" data-id="<?= $produit['id_produit'] ?>"
                            onclick="window.location.href = '../Produit/GererProduit.php?id=<?= $produit['id_produit'] ?>';">
                            Modifier le produit
                    </button>
                    <?php else: ?>
                    <button
                        type="button"
                        class="bouton-panier <?= !$enStock ? 'disabled' : '' ?>"
                        id="bouton-ajouter"
                        <?= !$enStock ? 'disabled' : '' ?>
                        data-id="<?= $produit['id_produit'] ?>"
                        data-stock="<?= (int) $produit['stock_produit'] ?>"
                    >
                        <i class="fa-solid fa-basket-shopping"></i>
                        <?= $enStock ? 'Ajouter au panier' : 'Indisponible' ?>
                    </button>
                    <?php endif; ?>
                </div>

                <!-- Infos livraison -->
                <?php if (droitsAccesProduit($_COOKIE['uuid'], 2) == true): ?>
                <div class="infos-livraison hide">
                <?php else: ?>
                <div class="infos-livraison">
                <?php endif; ?>
                    <div class="info-item">
                        <i class="fa-solid fa-truck"></i>
                        <span>Livraison estimée sous 3 à 5 jours ouvrés</span>
                    </div>
                    <div class="info-item">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Retours acceptés sous 14 jours</span>
                    </div>
                </div>

            </section>
        </main>
        <?php require_once '../ui/footer.php'; ?>
    </body>
    <script src="../js/produit.js"></script>
    <script src="../snackbar.js"></script>
</html>