<?php

  require_once ('../../lib/service/ServiceVendeur.php');
  require_once ('../../lib/service/ServiceUtilisateur.php');
  require_once __DIR__ . '/../../lib/Constantes.php';


  droitsAccesPage($_COOKIE['uuid'], 2);

  $infosVendeur = recupererInfosVendeur();
  $v = $infosVendeur[0]; // raccourci

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="vendeur.css">
  <link rel="stylesheet" href="../Global.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Modifier le compte vendeur</title>
</head>
<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Modification du compte</h1>

  <form method="POST" class="formulaire">

    <div class="form__row">
      <div class="form__group form__group--grow-3">
        <input type="text" id="denomination" name="denomination" class="form__field" placeholder=" " required
          value="<?= htmlspecialchars($v['denomination_vendeur']) ?>">
        <label for="denomination" class="form__label">Dénomination vendeur</label>
      </div>

      <div class="form__group form__group--grow-2">
        <input type="tel" id="telephone" name="telephone" class="form__field" placeholder=" " required
          value="<?= htmlspecialchars($v['telephone_utilisateur']) ?>">
        <label for="telephone" class="form__label">Numéro de téléphone</label>
      </div>
    </div>

    <div class="form__group">
      <input type="email" id="mail" name="mail" class="form__field" placeholder=" " required
        value="<?= htmlspecialchars($v['email_utilisateur']) ?>">
      <label for="mail" class="form__label">Adresse mail</label>
    </div>

    <div class="form__group">
      <input type="text" id="adresseVendeur" name="adresseVendeur" class="form__field" placeholder=" " required
        value="<?= htmlspecialchars($v['adresse']) ?>">
      <label for="adresseVendeur" class="form__label">Adresse postale</label>
    </div>

    <div class="form__row">
      <div class="form__group form__group--grow-2">
        <input type="text" id="villeVendeur" name="villeVendeur" class="form__field" placeholder=" " required
          value="<?= htmlspecialchars($v['ville_adresse']) ?>">
        <label for="villeVendeur" class="form__label">Ville</label>
      </div>

      <div class="form__group form__group--grow-1">
        <input type="text" id="codePostalVendeur" name="codePostalVendeur" class="form__field" placeholder=" " required maxlength="5"
          value="<?= htmlspecialchars($v['code_postal_adresse']) ?>">
        <label for="codePostalVendeur" class="form__label">Code postal</label>
      </div>
    </div>

    <div class="form__row form__row--actions">
      <a href="ConsulterCompteVendeur.php" class="profil__bouton">Retour</a>
      <input type="submit" value="Valider les modifications" class="profil__bouton"/>
    </div>

    <div class="snackbar">
      <h3 class="snackbarTitle"></h3>
      <p class="snackbarText"></p>
    </div>

  </form>

  <script src="../js/form.js"></script>
  <script src="../snackbar.js"></script>
  <?php require_once '../ui/footer.php'; ?>
</body>
</html>