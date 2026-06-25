<?php

require_once('../../lib/service/ServiceClient.php');
require_once('../../lib/service/ServiceUtilisateur.php');

droitsAccesPage($_COOKIE['uuid'], 1);

$infosClient = recupererInfosClient($_COOKIE['uuid']);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="client.css">
  <link rel="stylesheet" href="../Global.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Compte Client</title>
</head>

<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Modification du mot de passe</h1>

  <form method="POST" class="formulaire">

    <div class="form__group">
      <input type="password" name="mdpCourant" id="mdpCourant" class="form__field"
            placeholder="Mot de passe" required>
      <label for="mdpCourant" class="form__label">Mot de passe</label>
    </div>

    <div class="form__group">
      <input type="password" name="nouveauMdp" id="nouveauMdp" class="form__field"
            placeholder="Nouveau mot de passe" required>
      <label for="nouveauMdp" class="form__label">Nouveau mot de passe</label>
    </div>

    <div class="form__group">
      <input type="password" name="confNouveauMdp" id="confNouveauMdp" class="form__field"
            placeholder="Confirmer nouveau mot de passe" required>
      <label for="confNouveauMdp" class="form__label">Confirmer nouveau mot de passe</label>
    </div>

    <div class="divBtnForm">
      <input type="submit" value="Valider les modifications" class="submit">
      <button type="button" class="buttonForm"
              onclick="window.location.href='ConsulterCompteClient.php'">Retour</button>
    </div>

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