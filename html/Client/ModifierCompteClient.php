<?php
    include '../../lib/service/ServiceClient.php';

    $infosClient = recupererInfosClient();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="../Global.css">
    <title>Modifier le profil</title>
  </head>
  <body>
    <h1>Profil</h1>
    <form method="POST">

      <div class="divForm">
        <label for="picture">Photo de profil</label>
        <img id="changementImage" src=<?= $infosClient[0]['pp_utilisateur'] == NULL ? "../../images/image-none.jpg" : $infosClient[0]['pp_utilisateur'] ?> alt="Photo de profil" class="profile-picture" width="200" height="200">
        <input type="file" name="picture" accept="image/*" onchange="changerImage(event)">
      </div>

      <div class="divForm">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" required value="<?= $infosClient[0]['nom_utilisateur'];?>">
      </div>
    
      <div class="divForm">
        <label for="mail">Adresse mail</label>
        <input type="email" name="mail" required value="<?= $infosClient[0]['email_utilisateur'];?>">
      </div>

      <div class="divForm">
        <label for="phone">Numéro de téléphone</label>
        <input type="tel" name="phone" required value="<?= $infosClient[0]['telephone_utilisateur'];?>">
      </div>
      
      <div class="divForm">
        <label for="address">Adresse postale</label>
        <input type="text" name="address" required value="<?= $infosClient[0]['adresse'];?>">
      </div>

      <div class="divForm">
        <label for="address">Code postal</label>
        <input type="text" name="address" required value="<?= $infosClient[0]['code_postal_adresse'];?>">
      </div>

      <div class="divForm">
        <label for="address">Ville</label>
        <input type="text" name="address" required value="<?= $infosClient[0]['ville_adresse'];?>">
      </div>
      <input type="submit" value="Enregistrer les modifications" class="submit"/>
      <a href="ConsulterCompteClient.php"><input type="button" value="Annuler"/></a>
    </form>
  </body>
</html>

<script>
  function changerImage(event) {
    const fichier = event.target.files[0];
    if (fichier) {
      const lecture = new FileReader();
      lecture.onload = function(selec) {
        document.getElementById('changementImage').src = selec.target.result;
      }
      lecture.readAsDataURL(fichier);
    }
  }

  const form = document.querySelector("form");

  // écouteur des requêtes du formulaire
  form.addEventListener("submit", function (event) {
    
    // empêche l'envoi du formulaire sans exécuter le code qui suit
    event.preventDefault(); 

    // récupération des infos du formulaire
    const formData = {
      mail: form.mail.value,
      nom_utilisateur: form.username.value,
      telephone_utilisateur: form.phone.value,
      adresse: form.address.value,
      ville_adresse: form.ville_adresse.value,
      code_postal_adresse: form.code_postal_adresse.value,
      typeRequete: "modification"
    }

    // fetch vers le dossier API de création client
    fetch("../API/Client.php", {
      method: "POST",
      body: JSON.stringify(formData)  // fait une string JSON du tableau
    })
    .then(response => response.json())  // transforme la réponse http en json exploitable
    .then(json => {
      console.log(json);      // test affichage retour
      if (json.reponse == 200) {
        alert("Compte modifié !"); // alert de la création du compte
        window.location.href = "ConsulterCompteClient.php";
      
      } else  if (json.reponse == 409) {
        afficherSnackBar('Notification','Echec de modification : email déjà utilisé !'); // alert de la création du compte
        window.location.href = "ConsulterCompteClient.php";
      
      } else {
        afficherSnackBar('Notification','Echec de modification !');
      } 
      
    })
    .catch(err => {
      console.error("Erreur :", err); 
    });
  });
</script>
