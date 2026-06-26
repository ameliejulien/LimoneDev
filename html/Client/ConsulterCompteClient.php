<?php

  require_once ('../../lib/service/ServiceClient.php');
  require_once ('../../lib/service/ServiceUtilisateur.php');
  require_once ('../../lib/service/ServiceA2F.php');

  droitsAccesPage($_COOKIE['uuid'], 1);

  $infosClient = recupererInfosClient($_COOKIE['uuid']);

  $uuid = $_COOKIE['uuid'];
  $a2fConfiguree = utilisateurASecret($uuid);
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
  <title>Profil</title>
</head>

<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Profil</h1>

  <div class="profil__carte">

    <div class="profil__champ">
      <img src="<?= $imgSrc ?>" alt="Photo de profil" class="profil__photo">
    </div>

    <div class="profil__champ">
      <span class="profil__label">Nom utilisateur</span>
      <span class="profil__valeur">
        <?= $infosClient['nom_utilisateur'] ?? 'Pseudo non renseigné' ?>
      </span>
    </div>

    <div class="profil__champ">
      <span class="profil__label">Adresse mail</span>
      <span class="profil__valeur">
        <?= $infosClient['email_utilisateur'] ?? 'Mail non renseigné' ?>
      </span>
    </div>

    <div class="profil__champ">
      <span class="profil__label">Numéro de téléphone</span>
      <span class="profil__valeur">
        <?= $infosClient['telephone_utilisateur'] ?? 'Téléphone non renseigné' ?>
      </span>
    </div>

    <div class="profil__champ">
      <span class="profil__label">Adresse postale</span>
      <span class="profil__valeur">
        <?= $infosClient['adresse'] ?? 'Adresse non renseignée' ?>
      </span>
    </div>

    <div class="profil__champ">
      <span class="profil__label">Code postal</span>
      <span class="profil__valeur">
        <?= $infosClient['code_postal_adresse'] ?? 'Code postal non renseigné' ?>
      </span>
    </div>

    <div class="profil__champ">
      <span class="profil__label">Ville</span>
      <span class="profil__valeur">
        <?= $infosClient['ville_adresse'] ?? 'Ville non renseignée' ?>
      </span>
    </div>

    <div class="profil__actions">
      <button type="button" class="profil__bouton" onclick="window.location.href='ModifierCompteClient.php'">Modifier Compte</button>
      <button type="button" class="profil__bouton" onclick="window.location.href='ModifierMdpClient.php'">Modifier mot de passe</button>
      <?php if (!$a2fConfiguree): ?>
        <button type="button" class="profil__bouton" onclick="window.location.href='/A2F/Creer/'">Activer la double authentification</button>
      <?php endif; ?>
      <button type="button" class="profil__bouton profil__bouton--deco" id="btnDeconnexion">Déconnexion</button>
    </div>

  </div>

  <div class="modal__overlay" id="modalDeco">
    <div class="modal__boite">
      <p class="modal__message">Souhaitez-vous vraiment vous déconnecter ?</p>
      <div class="modal__actions">
        <button type="button" class="profil__bouton" id="modalConfirmer">Se déconnecter</button>
        <button type="button" class="profil__bouton profil__bouton--deco" id="modalAnnuler">Annuler</button>
      </div>
    </div>
  </div>

<script src="../js/form.js"></script>
<?php require_once '../ui/footer.php'; ?>
</body>

</html>