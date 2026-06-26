<?php

  require_once ("../../lib/service/ServiceVendeur.php");
  require_once ("../../lib/service/ServiceUtilisateur.php");
  require_once ("../../lib/service/ServiceA2F.php");
  require_once __DIR__ . "/../../lib/Constantes.php";

  droitsAccesPage($_COOKIE['uuid'], 2);

  $infosVendeur = recupererInfosVendeur();
  $v = $infosVendeur[0]; // raccourci

  $a2fConfiguree = utilisateurASecret($_COOKIE['uuid']);

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendeur.css">
    <link rel="stylesheet" href="../Global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Profil</title>
  </head>
  <body>
    <?php require_once '../ui/header.php'; ?>
    <h1>Profil</h1>

    <div class="profil__carte">

      <div class="profil__champ">
        <span class="profil__label">Dénomination</span>
        <span class="profil__valeur"><?= htmlspecialchars($v['denomination_vendeur']) ?></span>
      </div>

      <div class="profil__champ">
        <span class="profil__label">Adresse mail</span>
        <span class="profil__valeur"><?= $v['email_utilisateur'] ?? 'Non renseigné' ?></span>
      </div>

      <div class="profil__champ">
        <span class="profil__label">Numéro de téléphone</span>
        <span class="profil__valeur"><?= $v['telephone_utilisateur'] ?? 'Non renseigné' ?></span>
      </div>

      <div class="profil__champ">
        <span class="profil__label">SIRET</span>
        <span class="profil__valeur"><?= $v['siret_vendeur'] ?? 'Non renseigné' ?></span>
      </div>

      <div class="profil__champ">
        <span class="profil__label">Adresse postale</span>
        <span class="profil__valeur"><?= $v['adresse'] ?? 'Non renseignée' ?></span>
      </div>

      <div class="profil__champ">
        <span class="profil__label">Ville</span>
        <span class="profil__valeur"><?= $v['ville_adresse'] ?? 'Non renseignée' ?></span>
      </div>

      <div class="profil__champ">
        <span class="profil__label">Code postal</span>
        <span class="profil__valeur"><?= $v['code_postal_adresse'] ?? 'Non renseigné' ?></span>
      </div>

      <div class="profil__actions">
        <button type="button" class="profil__bouton" onclick="window.location.href='ModifierCompteVendeur.php'">Modifier le compte</button>
        <button type="button" class="profil__bouton" onclick="window.location.href='ModifierMdpVendeur.php'">Modifier le mot de passe</button>
        <?php if (!$a2fConfiguree): ?>
          <button type="button" class="profil__bouton" onclick="window.location.href='/A2F/Creer/'">Activer la double authentification</button>
        <?php endif; ?>
        <button type="button" class="profil__bouton profil__bouton--deco" id="btnDeconnexionVendeur">Déconnexion</button>
      </div>

    </div>

    <div class="modal__overlay" id="modalDecoVendeur">
      <div class="modal__boite">
        <p class="modal__message">Souhaitez-vous vraiment vous déconnecter ?</p>
        <div class="modal__actions">
          <button type="button" class="profil__bouton" id="modalConfirmerVendeur">Se déconnecter</button>
          <button type="button" class="profil__bouton profil__bouton--deco" id="modalAnnulerVendeur">Annuler</button>
        </div>
      </div>
    </div>  

<script src="../js/form.js"></script>
<?php require_once '../ui/footer.php'; ?>
  </body>
</html>