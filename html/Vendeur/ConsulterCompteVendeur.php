<?php
    include '../../lib/service/ServiceVendeur.php';

    $infosVendeur = recupererInfosVendeur();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendeur.css">
    <title>Profil vendeur</title>
  </head>
  <body>
    <h1>Profil Vendeur</h1>
    <form>
      <div class="consultDiv">
        <label>Dénomination : </label>
        <span> <?= $infosVendeur[0]['denomination_vendeur'];?> </span>
      </div>
    
      <div class="consultDiv">
        <label for="mail">Adresse mail : </label>
        <span> <?= $infosVendeur[0]['email_utilisateur'];?> </span>
      </div>

      <div class="consultDiv">
        <label for="phone">Numéro de téléphone : </label>
        <span> <?= $infosVendeur[0]['telephone_utilisateur'];?> </span>
      </div>
      
      <div class="consultDiv">
        <label for="address">Adresse postale : </label>
        <span> <?= $infosVendeur[0]['adresse'];?> </span>
      </div>

      <div class="consultDiv">
        <label for="address">Code postal : </label>
        <span> <?= $infosVendeur[0]['code_postal_adresse'];?> </span>
      </div>

      <div class="consultDiv">
        <label for="address">Ville : </label>
        <span> <?= $infosVendeur[0]['ville_adresse'];?> </span>
      </div>
      <a href="ModifierCompteVendeur.php"><input type="button" value="Modifier"/></a>
    </form>
  </body>
</html>