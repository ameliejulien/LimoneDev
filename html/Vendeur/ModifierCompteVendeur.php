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
  <link rel="stylesheet" href="../Global.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Compte Vendeur</title>
</head>
<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Modification du compte vendeur</h1>
  <form method="POST">
    <div class="divForm">
      <label for="mail">Adresse mail</label>
      <input type="email" name="mail" required value="<?= $infosVendeur[0]['email_utilisateur'];?>">
    </div>

    <div class="divForm">
      <label for="denomination">Dénomination vendeur</label>
      <input type="text" name="denomination" required value="<?= $infosVendeur[0]['denomination_vendeur'];?>">
    </div>

    <div class="divForm">
      <label for="telephone">Numéro de téléphone</label>
      <input type="tel" name="telephone" required value="<?= $infosVendeur[0]['telephone_utilisateur'];?>">
    </div>

    <div class="divForm">
      <label for="adresseVendeur">Adresse du vendeur</label>
      <input type="text" name="adresseVendeur" required value="<?= $infosVendeur[0]['adresse'];?>">
    </div>

    <div class="divForm">
      <label for="villeVendeur">Ville du vendeur</label>
      <input type="text" name="villeVendeur" required value="<?= $infosVendeur[0]['ville_adresse'];?>">
    </div>

    <div class="divForm">
      <label for="codePostalVendeur">Code postal du vendeur</label>
      <input type="text" name="codePostalVendeur" required maxlength="5" value="<?= $infosVendeur[0]['code_postal_adresse'];?>">
    </div>

    <input type="submit" value="Valider les modifications" class="submit"/>
    <a href="ConsulterCompteVendeur.php"><input class="buttonForm" type="button" value="Retour"/></a>


    <div class="snackbar">
      <h3 class="snackbarTitle"></h3>
      <p class="snackbarText"></p>
    </div>

    <script src="../snackbar.js"></script>
  </form>
  <script>
    const form = document.querySelector("form");

    // écouteur des requêtes du formulaire
    form.addEventListener("submit", function (event) {
      
      // empêche l'envoi du formulaire sans exécuter le code qui suit
      event.preventDefault(); 

      // récupération des infos du formulaire
      const formData = {
        mail: form.mail.value,
        denomination: form.denomination.value,
        telephone_utilisateur: form.telephone.value,
        adresse: form.adresseVendeur.value,
        ville_adresse: form.villeVendeur.value,
        code_postal_adresse: form.codePostalVendeur.value,
        typeRequete: "modification"
      }

      // fetch vers le dossier API de création client
      fetch("../API/Vendeur.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
      .then(response => response.json())  // transforme la réponse http en json exploitable
      .then(json => {
        console.log(json);      // test affichage retour
        if (json.reponse == 200) {
          alert("Compte modifié !"); // alert de la création du compte
          window.location.href = "ConsulterCompteVendeur.php";
        
        } else  if (json.reponse == 409) {
          afficherSnackBar('Notification','Echec de modification : email déjà utilisé !'); // alert de la création du compte
          window.location.href = "ConsulterCompteVendeur.php";
        
        } else {
          afficherSnackBar('Notification','Echec de modification !');
        } 
        
      })
      .catch(err => {
        console.error("Erreur :", err); 
      });
    });
</script>
</body>
</html>