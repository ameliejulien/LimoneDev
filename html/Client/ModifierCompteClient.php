<?php

  require_once ('../../lib/service/ServiceClient.php');
  require_once ('../../lib/service/ServiceUtilisateur.php');

  droitsAccesPage($_COOKIE['uuid'], 1);

  $infosClient = recupererInfosClient($_COOKIE['uuid']);

  $uuid = $_COOKIE['uuid'];
  $imgData = $infosClient['pp_utilisateur'];
  if (is_resource($imgData)) {
      $imgSrc = "data:image/jpeg;base64," . base64_encode(stream_get_contents($imgData));
  } elseif (!empty($imgData)) {
      $imgSrc = "data:image/jpeg;base64," . base64_encode($imgData);
  } else {
      $imgSrc = "../../imagesProduits/image-none.jpg";
  }
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="../Global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Modifier le profil</title>
  </head>
  <body>
    <?php require_once '../ui/header.php'; ?>
    <h1>Profil</h1>
    <form method="POST" action="ConsulterCompteClient.php" class="formulaire" enctype="multipart/form-data">

      <!-- Photo de profil -->
      <div class="modifier__photo-wrapper">
        <img id="changementImage" src="<?= $imgSrc ?>" alt="Photo de profil" class="modifier__photo">
        <label class="modifier__photo-label" for="picture">
          <i class="fa fa-camera"></i> Changer la photo
        </label>
        <input type="file" id="picture" name="picture" accept="image/*" onchange="changerImage(event)" class="modifier__photo-input">
      </div>

      <div class="form__group">
        <input type="text" name="username" id="username" class="form__field"
              placeholder="Nom d'utilisateur" required value="<?= $infosClient['nom_utilisateur'] ?>">
        <label for="username" class="form__label">Nom d'utilisateur</label>
      </div>

      <div class="form__group">
        <input type="email" name="mail" id="mail" class="form__field"
              placeholder="Adresse mail" required value="<?= $infosClient['email_utilisateur'] ?>">
        <label for="mail" class="form__label">Adresse mail</label>
      </div>

      <div class="form__group">
        <input type="tel" name="phone" id="phone" class="form__field"
              placeholder="Numéro de téléphone" required value="<?= $infosClient['telephone_utilisateur'] ?>">
        <label for="phone" class="form__label">Numéro de téléphone</label>
      </div>

      <div class="form__group">
        <input type="text" name="address" id="address" class="form__field"
              placeholder="Adresse postale" required value="<?= $infosClient['adresse'] ?>">
        <label for="address" class="form__label">Adresse postale</label>
      </div>

      <div class="form__group">
        <input type="text" name="code" id="code" class="form__field"
              placeholder="Code postal" required value="<?= $infosClient['code_postal_adresse'] ?>">
        <label for="code" class="form__label">Code postal</label>
      </div>

      <div class="form__group">
        <input type="text" name="ville" id="ville" class="form__field"
              placeholder="Ville" required value="<?= $infosClient['ville_adresse'] ?>">
        <label for="ville" class="form__label">Ville</label>
      </div>

      <div class="divBtnForm">
        <input type="submit" value="Enregistrer les modifications" class="submit profil__bouton">
        <button type="button" class="profil__bouton" onclick="window.location.href='ConsulterCompteClient.php'">Annuler</button>
      </div>

    </form>

  <script src="../js/form.js"></script>
  <?php require_once '../ui/footer.php'; ?>
  </body>
</html>
