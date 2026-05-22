<?php
include_once('../../lib/repo/FacturationRepo.php');
include_once('../../lib/repo/CommandeRepo.php');
include_once('../../lib/repo/AchatRepo.php');
include_once('../../lib/service/ServicePanier.php');

/**
 * Valide le format des champs de l'utilisateur coté serveur, pour éviter les bypass du JS
 */
function validerPaiement() {
    $valeurs = $_POST;
    $champsVide = false;

    foreach ($valeurs as $valeur) {
        $estVide = trim($valeur) === "";

        if ($estVide) {
            $champsVide = true;
            return false;
        }
    }

    if ($champsVide) {
        return false;
    } else { // Valider la commande (la mettre en BDD)
        // Todo Verification plus profonde : chaque champs un par un

        // Verifie le format de l'email
        $regex = '/^[a-zA-Z0-9.\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/';
        if (preg_match($regex, $_POST['email']) !== 1) {
            return false;
        }

        // Verifie le format du numero de telephone
        $regex = '/^0[0-9]( ?[0-9]{2}){4}$/';
        if (preg_match($regex, $_POST['telephone']) !== 1) {
            return false;
        }

        // Verifie le format de la carte de paiement
        $regex = '/^[0-9]{16}$/';
        if (preg_match($regex, $_POST['carteBancaire']) !== 1) {
            return false;
        }

        // Verifie le format du code secret CB
        $regex = '/^[0-9]{3}$/';
        if (preg_match($regex, $_POST['codeSecretCB']) !== 1) {
            return false;
        }

        $panier = getPanierArticles((array) getPanierIDs());
        $quantiteMap = array_count_values((array) json_decode($_COOKIE['panier']));

        // Crée une commande
        $commandeId = enregistrerCommande();

        // Créer une facture
        $factureId = enregistrerFacture(
            $_POST['prenom']." ".$_POST['nom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['ville'],
            $_POST['adressePostal'],
            $_POST['codePostal'],
            $_POST['villeFacturation'],
            $_POST['adressePostalFacturation'],
            $_POST['codePostalFacturation']
        );

        $nomArticle = "";
        $prixHt = 0;
        $TVA = 0;

        // Créer une ligne de commande par produit
        foreach ($quantiteMap as $articleId => $quantite) {
            foreach ($panier as $article) {
                if ($article['id_produit'] == $articleId) {
                    $nomArticle = $article["nom_produit"];
                    $prixHt = $article["prix_ht_produit"];
                    $TVA = ($article["prix_ht_produit"] * 1.2) - $article["prix_ht_produit"];
                }
            }

            enreigstrerLigneCommande($commandeId, $articleId, $nomArticle, $quantite, $prixHt, $TVA);

            if ($_COOKIE['client'] != null) {
                $client = (array) json_decode($_COOKIE['client']);
                enregistrerAchat($commandeId, $articleId, $factureId, $client["idClient"]);
            } else {
                enregistrerAchat($commandeId, $articleId, $factureId);
            }
        }

        // Communication avec la banque
        return true;
    }
}

?>
