<?php
    require_once("../../lib/service/ServiceClient.php");

    $infosClient=recupererInfosClient()

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Paiement/paiement.css">
    <title>Paiement</title>
</head>
<?php require('../ui/header.php'); ?>
<main>
    <h1>Paiement</h1>
    <form method="POST" class="formPaiement" action="/Paiement/PaiementValide.php">
        <div class="divForm form-contact">
            <h2 class="category-titre">Contact</h2>
            <div class="input-group prenom-input">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" required 
                value =>
            </div>

            <div class="input-group nom-input">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="input-group mail-input">
                <label for="email">Adresse mail</label>
                <input type="email" name="email" id="mail" required pattern="[a-zA-Z0-9\.\-]+@[a-zA-Z0-9\-\.]+\.[a-z]+" placeholder="example@example.com"
                value=" <?= $infosClient[0]['email_utilisateur'] == NULL ? "" : $infosClient[0]['email_utilisateur'] ?>"
                >
            </div>

            <div class="input-group tel-input">
                <label for="telephone">Numéro de téléphone</label>
                <input type="tel" name="telephone" id="numtel" required placeholder="Format : 0123456789"
                    value="<?= $infosClient[0]['telephone_utilisateur'] == NULL ? "" : $infosClient[0]['telephone_utilisateur'] ?>"
                >
            </div>
        </div>

        <div class="divForm form-livraison">
            <h2 class="category-titre">Livraison</h2>
            <div class="input-group adresse-input">
                <label for="adressePostal">Adresse postale</label>
                <input type="text" name="adressePostal" id="adresse" required
                    value = "<?= $infosClient[0]['adresse'] == NULL ? "" : $infosClient[0]['adresse'] ?>"
                >
            </div>

            <div class="input-group ville-input">
                <label for="ville">Ville</label>
                <input type="text" name="ville" id="ville" required 
                    value="<?= $infosClient[0]['ville_adresse'] == NULL ? "" : $infosClient[0]['ville_adresse'] ?>"
                >
            </div>

            <div class="input-group code-postal-input">
                <label for="codePostal">Code postal</label>
                <input type="text" name="codePostal" id="codepostal" pattern="[0-9]{5}" required placeholder="00000"
                    value="<?= $infosClient[0]['code_postal_adresse'] == NULL ? "" : $infosClient[0]['code_postal_adresse'] ?>"
                >
            </div>

            <div class="input-group adresse-fac-input">
                <label for="adressePostalFacturation">Adresse de facturation</label>
                <input type="text" name="adressePostalFacturation" id="adressefac" required 
                    value = "<?= $infosClient[0]['adresse'] == NULL ? "" : $infosClient[0]['adresse'] ?>"
                >
            </div>

            <div class="input-group ville-fac-input">
                <label for="villeFacturation">Ville de facturation</label>
                <input type="text" name="villeFacturation" id="villefac" required
                    value="<?= $infosClient[0]['ville_adresse'] == NULL ? "" : $infosClient[0]['ville_adresse'] ?>"
                >
            </div>

            <div class="input-group code-postal-fac-input">
                <label for="codePostalFacturation">Code postal de facturation</label>
                <input type="text" name="codePostalFacturation" id="codepostalfac" pattern="[0-9]{5}" required
                    value="<?= $infosClient[0]['code_postal_adresse'] == NULL ? "" : $infosClient[0]['code_postal_adresse'] ?>"
                >
            </div>
        </div>

        <div class="divForm form-paiement">
            <h2 class="category-titre">Informations de paiement</h2>
            <div class="input-group code-cb-input">
                <label for="carteBancaire">Carte bancaire</label>
                <input type="text" name="carteBancaire" id="cartebancaire" pattern="[0-9]{16}" required placeholder="0000 0000 0000 0000">
            </div>

            <div class="input-group cvv-input">
                <label for="codeSecretCB">Code secret</label>
                <input type="text" name="codeSecretCB" id="codesecret" required placeholder="123">
            </div>

            <div class="input-group nom-titulaire-input">
                <label for="titulaireCB">Nom du titulaire</label>
                <input type="text" name="titulaireCB" id="titulairecb" required>
            </div>

            <input type="submit" value="Valider" class="submit bouton-valider" />
        </div>
    </form>
</main>

<script src="/Paiement/paiement.js"></script>

</html>