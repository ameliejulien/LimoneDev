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
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" required>

            <label for="nom">Nom</label>
            <input type="text" name="nom" required>

            <label for="email">Adresse mail</label>
            <input type="email" name="email" required>

            <label for="telephone">Numéro de téléphone</label>
            <input type="tel" name="telephone" required placeholder="exemple : 0606060606">
        </div>

        <div class="divForm">
            <h2>Livraison</h2>
            <label for="ville">Ville</label>
            <input type="text" name="ville" required>

            <label for="adressePostal">Adresse postal</label>
            <input type="text" name="adressePostal" required>

            <label for="codePostal">Code postal</label>
            <input type="text" name="codePostal" required>

            <label for="villeFacturation">Ville</label>
            <input type="text" name="villeFacturation" required>

            <label for="adressePostalFacturation">Adresse de facturation</label>
            <input type="text" name="adressePostalFacturation" required>

            <label for="codePostalFacturation">Code postal</label>
            <input type="text" name="codePostalFacturation" required>
        </div>

        <div class="divForm">
            <h2>Informations de paiement</h2>
            <label for="carteBancaire">Carte bancaire</label>
            <input type="text" name="carteBancaire" required>

            <label for="titulaireCB">Nom du titulaire</label>
            <input type="text" name="titulaireCB" required>

            <label for="codeSecretCB">Code secret</label>
            <input type="text" name="codeSecretCB" required>
        </div>

        <input type="submit" value="Valider" class="submit"/>
    </form>
</main>

<script src="paiement.js"></script>
</html>