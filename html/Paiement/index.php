<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="paiement.css">
    <title>Paiement</title>
</head>
<main>
    <h1>Paiement</h1>
    <form method="POST" action="./PaiementValide.php">
        <div class="divForm">
            <h2>Contact</h2>
            <div class="input-group prenom-input">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" required>
            </div>

            <div class="input-group nom-input">

                <label for="nom">Nom</label>
                <input type="text" name="nom" required>
            </div>
            <div class="input-group mail-group">

                <label for="email">Adresse mail</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group tel-group">

                <label for="telephone">Numéro de téléphone</label>
                <input type="tel" name="telephone" required placeholder="Format : 0123456789">
            </div>
        </div>

        <div class="divForm">
            <h2>Livraison</h2>
            <div class="input-group">

            </div>
            <label for="ville">Ville</label>
            <input type="text" name="ville" required>
            <div class="input-group adresse-group">
                <label for="adressePostal">Adresse postale</label>
                <input type="text" name="adressePostal" required>
            </div>
            <div class="input-group code-postal-group">


                <label for="codePostal">Code postal</label>
                <input type="text" name="codePostal" required>
            </div>

            <div class="input-group ville-group">

                <label for="villeFacturation">Ville</label>
                <input type="text" name="villeFacturation" required>
            </div>
            <div class="input-group adresse-fac-group">

                <label for="adressePostalFacturation">Adresse de facturation</label>
                <input type="text" name="adressePostalFacturation" required>
            </div>
            <div class="input-group code-postal-fac-group">

                <label for="codePostalFacturation">Code postal de facturation</label>
                <input type="text" name="codePostalFacturation" required>
            </div>
        </div>

        <div class="divForm">
            <h2>Informations de paiement</h2>
            <div class="input-group">

                <label for="carteBancaire">Carte bancaire</label>
                <input type="text" name="carteBancaire" required>
                <div class="input-group">

                    <label for="titulaireCB">Nom du titulaire</label>
                    <input type="text" name="titulaireCB" required>
                    <div class="input-group">

                        <label for="codeSecretCB">Code secret</label>
                        <input type="text" name="codeSecretCB" required>
                    </div>

                    <input type="submit" value="Valider" class="submit" />
    </form>
</main>

<script src="paiement.js"></script>

</html>