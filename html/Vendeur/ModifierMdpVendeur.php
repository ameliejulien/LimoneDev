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
  <title>Compte Vendeur</title>
</head>
<body>
  <h1>Modification du mot de  passe vendeur</h1>
  <form method="POST">
    
  <div class="divForm">
      <label for="mail">Mot de passe</label>
      <input type="password" name="mdpCourant" required >
    </div>

    <div class="divForm">
      <label for="mail">Nouveau mot de passe</label>
      <input type="password" name="nouveauMdp" required >
    </div>

    <div class="divForm">
      <label for="mail">Confimrmer nouveau mot de passe</label>
      <input type="password" name="confNouveauMdp" required >
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
        mdpCourant: form.mdpCourant.value,
        nouveauMdp: form.nouveauMdp.value,
        confNouveauMdp: form.confNouveauMdp.value,
        typeRequete: "modificationMdp"
      }

      // fetch vers le dossier API de création client
      fetch("../API/Vendeur.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
      .then(response => response.json())  // transforme la réponse http en json exploitable
      .then(json => {
        if (json.reponse == 200) {
          alert("Mot de passe modifié !"); // alert de la création du compte
          window.location.href = "ConsulterCompteVendeur.php";
        
        } else  if (json.reponse == 409) {
          afficherSnackBar('Notification','Echec de modification : nouveau mot de passe et ancien mot de passe identiques!'); // alert de la création du compte        
        
        } else if (json.reponse == 400) {
            console.log(json);
        }
        
      })
      .catch(err => {
        console.error("Erreur :", err); 
      });
    });
</script>
</body>
</html>