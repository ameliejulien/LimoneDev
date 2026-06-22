<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="vendeur.css">
  <link rel="stylesheet" href="../Global.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Compte Vendeur</title>
</head>

<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Création de compte vendeur</h1>
  <form method="POST" class="formulaire">
    <div class="form__group">
      <input type="email" id="mail" name="mail" class="form__field" placeholder=" " required>
      <label for="mail" class="form__label">Adresse mail</label>
      <small class="form__hint">Exemple : test@vendeur.fr</small>
    </div>

    <div class="form__row">
      <div class="form__group form__group--grow-3">
        <input type="text" id="denomination" name="denomination" class="form__field" placeholder=" " required>
        <label for="denomination" class="form__label">Dénomination vendeur</label>
      </div>

      <div class="form__group form__group--grow-2">
        <input type="tel" id="telephone" name="telephone" class="form__field" placeholder=" " required minlength="10" maxlength="10">
        <label for="telephone" class="form__label">Numéro de téléphone</label>
        <small class="form__hint">Exemple : 0612345678</small>
      </div>
    </div>

    <div class="form__group">
      <input type="text" id="adresseVendeur" name="adresseVendeur" class="form__field" placeholder=" " required>
      <label for="adresseVendeur" class="form__label">Adresse du vendeur</label>
    </div>

    <div class="form__row">
      <div class="form__group form__group--grow-2">
        <input type="text" id="villeVendeur" name="villeVendeur" class="form__field" placeholder=" " required>
        <label for="villeVendeur" class="form__label">Ville du vendeur</label>
      </div>

      <div class="form__group form__group--grow-1">
        <input type="text" id="codePostalVendeur" name="codePostalVendeur" class="form__field" placeholder=" " required minlength="5" maxlength="5">
        <label for="codePostalVendeur" class="form__label">Code postal du vendeur</label>
        <small class="form__hint">Exemple : 29000</small>
      </div>
    </div>

    <div class="form__row">
      <div class="form__group form__group--grow-2">
        <input type="text" id="siret" name="siret" class="form__field" placeholder=" " required minlength="14" maxlength="14">
        <label for="siret" class="form__label">Siret vendeur</label>
        <small class="form__hint">Exemple : 12345678900012</small>
      </div>

      <div class="form__group form__group--grow-3">
        <input type="text" id="cleAuth" name="cleAuth" class="form__field" placeholder=" " required minlength="9" maxlength="9">
        <label for="cleAuth" class="form__label">Clé d'authentification</label>
        <small class="form__hint">Exemple : 0123456789</small>
      </div>
    </div>

    <div class="form__row">
      <div class="form__group form__group--grow-1">
        <input type="password" id="mdp" name="mdp" class="form__field" placeholder=" " required minlength="8">
        <label for="mdp" class="form__label">Mot de passe</label>
      </div>

      <div class="form__group form__group--grow-1">
        <input type="password" id="confMdp" name="confMdp" class="form__field" placeholder=" " required minlength="8">
        <label for="confMdp" class="form__label">Confirmation du mot de passe</label>
      </div>
    </div>

    <br>

    <input type="submit" value="S'inscrire" class="submit" />

    <div class="snackbar">
      <h3 class="snackbarTitle"></h3>
      <p class="snackbarText"></p>
    </div>
  </form>

<script src="../snackbar.js"></script>
<script src="../js/form.js"></script>
<?php require_once '../ui/footer.php'; ?>
</body>

</html>