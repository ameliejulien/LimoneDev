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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Profil vendeur</title>
  </head>
  <body>
    <?php require_once '../ui/header.php'; ?>
    <h1>Profil Vendeur</h1>
    <form class="formulaire">
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
      <div class="divBtnForm">
        <button type="button" class="buttonForm" onclick="window.location.href='ModifierCompteVendeur.php'">Modifier Compte</button>
        <button type="button" class="buttonForm" onclick="window.location.href='ModifierMdpVendeur.php'">Modifier mot de passe</button>
        <button type="button" class="buttonForm decoBtn">Déconnexion</button>
      </div>
    </form>

    <script>
      const decoBtn = document.querySelector(".decoBtn");

      decoBtn.addEventListener("click", function (event) {
        
        const formData = {
          typeRequete: "deconnexion"
        }

        // fetch vers le dossier API de création client
        fetch("../API/Vendeur.php", {
          method: "POST",
          body: JSON.stringify(formData)  // fait une string JSON du tableau
        })
        .then(response => {
          if (response.status === 200) {
            window.location.href = "../Catalogue/";
          }
        })
        .catch(err => {
          console.error("Erreur :", err); 
        });
      });
    </script>
  </body>
</html>