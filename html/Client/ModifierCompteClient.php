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
    <form method="POST" action="ConsulterCompteClient.php">

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
        <label for="code">Code postal</label>
        <input type="text" name="code" required value="<?= $infosClient[0]['code_postal_adresse'];?>">
      </div>

      <div class="divForm">
        <label for="ville">Ville</label>
        <input type="text" name="ville" required value="<?= $infosClient[0]['ville_adresse'];?>">
      </div>
      <input type="submit" value="Enregistrer les modifications" class="submit"/>
      <a href="ConsulterCompteClient.php"><input type="button" value="Annuler"/></a>
    </form>
  </body>
</html>

<script>

  function changerImage(event) {

    const fichier = event.target.files[0];

    // Vérification qu'une image a été choisie
    if (fichier) {

      const lecture = new FileReader();

      lecture.onload = function(selec) {

        // Changement de la photo de profil avec l'image choisie par l'utilisateur
        document.getElementById('changementImage').src = selec.target.result;

      }

      lecture.readAsDataURL(fichier);
    }
  }

  const form = document.querySelector("form");

  // Ecouteur
  form.addEventListener("submit", function (event) {
    
    // Assure la bonne exécution du code avant l'envoi du formulaire
    event.preventDefault(); 

    // Récupération des données du client
    const formData = {
      pp_utilisateur: form.picture.value,
      nom_utilisateur: form.username.value,
      email_utilisateur: form.mail.value,
      telephone_utilisateur: form.phone.value,
      adresse: form.address.value,
      code_postal_adresse: form.code.value,
      ville_adresse: form.ville.value,
      typeRequete: "modification"
    }

<<<<<<< Updated upstream
    // fetch vers le dossier API de création client
    fetch("../API/Client.php", {
=======
    // Fetch vers le dossier API de création client
    fetch("../API/CreerClient.php", {
>>>>>>> Stashed changes
      method: "POST",
      body: JSON.stringify(formData)
    })

    .then(response => response.json()) // http vers json
    .then(json => {
      console.log(json); // Test affichage

      // Compte modifié avec succès
      if (json.reponse == 200) {
        alert("Compte modifié !");
        window.location.href = "ConsulterCompteClient.php";
        form.submit();
      }
      
    })
    
    .catch(err => {
      console.error("Erreur :", err); 
    });

  });

</script>
