<?php

    require_once("../../lib/service/ServiceClient.php");
    require_once ("../../lib/service/ServiceUtilisateur.php");
    require_once ("../../lib/service/ServicePanier.php");

    $panier = getPanierIDs();
    $quantiteProduitArray = array_count_values($panier);

    droitsAccesPagePaiement($_COOKIE['uuid'], 2, $quantiteProduitArray);

    $infosClient=recupererInfosClient($_COOKIE['uuid']);

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Paiement/paiement.css">
    <title>Paiement</title>
</head>
<?php require_once('../ui/header.php'); ?>
<main>
    <h1>Paiement</h1>
    <form method="POST" class="formPaiement" action="/Paiement/PaiementValide.php">

        <!-- Section Contact -->
        <div class="divForm form-contact">
            <h2 class="category-titre">Contact</h2>

            <div class="input-group prenom-input">
                <input type="text" name="prenom" id="prenom" class="form__field" placeholder=" " required>
                <label for="prenom" class="form__label">Prénom</label>
            </div>

            <div class="input-group nom-input">
                <input type="text" name="nom" id="nom" class="form__field" placeholder=" " required>
                <label for="nom" class="form__label">Nom</label>
            </div>

            <div class="input-group mail-input">
                <input type="email" name="email" id="mail" class="form__field"
                    placeholder=" "
                    pattern="[a-zA-Z0-9\.\-]+@[a-zA-Z0-9\-\.]+\.[a-z]+"
                    value="<?= $infosClient[0]['email_utilisateur'] ?? '' ?>"
                    required>
                <label for="mail" class="form__label">Adresse mail</label>
                <small class="form__hint">Exemple : test@vendeur.fr</small>
            </div>

            <div class="input-group tel-input">
                <input type="tel" name="telephone" id="numtel" class="form__field"
                    placeholder=" "
                    value="<?= $infosClient[0]['telephone_utilisateur'] ?? '' ?>"
                    minlength="10" maxlength="10"
                    required>
                <label for="numtel" class="form__label">Numéro de téléphone</label>
                <small class="form__hint">Exemple : 06 12 34 56 78</small>
            </div>
        </div>

        <!-- Section Livraison -->
        <div class="divForm form-livraison">
            <h2 class="category-titre">Livraison</h2>

            <div class="input-group adresse-input">
                <input type="text" name="adressePostal" id="adresse" class="form__field"
                    placeholder=" "
                    value="<?= $infosClient[0]['adresse'] ?? '' ?>"
                    required>
                <label for="adresse" class="form__label">Adresse postale</label>
            </div>

            <div class="input-group ville-input">
                <input type="text" name="ville" id="ville" class="form__field"
                    placeholder=" "
                    value="<?= $infosClient[0]['ville_adresse'] ?? '' ?>"
                    required>
                <label for="ville" class="form__label">Ville</label>
            </div>

            <div class="input-group code-postal-input">
                <input type="text" name="codePostal" id="codepostal" class="form__field"
                    placeholder=" "
                    pattern="[0-9]{5}"
                    maxlength="5"
                    minlength="5"
                    value="<?= $infosClient[0]['code_postal_adresse'] ?? '' ?>"
                    required>
                <label for="codepostal" class="form__label">Code postal</label>
                <small class="form__hint">Exemple : 22000</small>
            </div>

            <div class="input-group adresse-fac-input">
                <input type="text" name="adressePostalFacturation" id="adressefac" class="form__field"
                    placeholder=" "
                    value="<?= $infosClient[0]['adresse'] ?? '' ?>"
                    required>
                <label for="adressefac" class="form__label">Adresse de facturation</label>
            </div>

            <div class="input-group ville-fac-input">
                <input type="text" name="villeFacturation" id="villefac" class="form__field"
                    placeholder=" "
                    value="<?= $infosClient[0]['ville_adresse'] ?? '' ?>"
                    required>
                <label for="villefac" class="form__label">Ville de facturation</label>
            </div>

            <div class="input-group code-postal-fac-input">
                <input type="text" name="codePostalFacturation" id="codepostalfac" class="form__field"
                    placeholder=" "
                    pattern="[0-9]{5}"
                    maxlength="5"
                    minlength="5"
                    value="<?= $infosClient[0]['code_postal_adresse'] ?? '' ?>"
                    required>
                <label for="codepostalfac" class="form__label">Code postal de facturation</label>
                <small class="form__hint">Exemple : 29000</small>
            </div>
        </div>

        <!-- Section Paiement -->
        <div class="divForm form-paiement">
            <h2 class="category-titre">Informations de paiement</h2>

            <div class="input-group code-cb-input">
                <input type="text" name="carteBancaire" id="cartebancaire" class="form__field"
                    placeholder=" "
                    pattern="[0-9]{16}"
                    maxlength="16"
                    minlength="16"
                    required>
                <label for="cartebancaire" class="form__label">Numéro de carte bancaire</label>
                <small class="form__hint">Exemple : 4970 1234 5678 9000</small>
            </div>

            <div class="input-group cvv-input">
                <input type="text" name="codeSecretCB" id="codesecret" class="form__field"
                    placeholder=" "
                    maxlength="3"
                    minlength="3"
                    required>
                <label for="codesecret" class="form__label">Code secret (CVV)</label>
                <small class="form__hint">Exemple : 123</small>
            </div>

            <div class="input-group nom-titulaire-input">
                <input type="text" name="titulaireCB" id="titulairecb" class="form__field"
                    placeholder=" "
                    required>
                <label for="titulairecb" class="form__label">Nom du titulaire</label>
                <small class="form__hint"></small>
                <br>
                <br>
            </div>

            <div class="bouton-valider-wrap">
                <input type="submit" value="Valider" class="bouton-valider" />
            </div>
        </div>

    </form>
    <?php require_once '../ui/footer.php'; ?>
</main>

<script src="../js/form.js"></script>
<script src="/Paiement/paiement.js"></script>

</html>