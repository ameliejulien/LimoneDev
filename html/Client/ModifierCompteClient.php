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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Modifier le profil</title>
  </head>
  <body>
    <?php require_once '../ui/header.php'; ?>
    <h1>Profil</h1>
    <form method="POST" action="ConsulterCompteClient.php" class="formulaire">

      <div class="divForm">
        <label for="picture">Photo de profil</label>
        <?php 
          $imgData = $infosClient[0]['pp_utilisateur'];
          if (is_resource($imgData)) {
              $imgSrc = "data:image/jpeg;base64," . base64_encode(stream_get_contents($imgData));
          } else if (!empty($imgData)) {
              $imgSrc = "data:image/jpeg;base64," . base64_encode($imgData);
          } else {
              $imgSrc = "../../images/image-none.jpg";
          }
        ?>
        <img id="changementImage" src="<?= $imgSrc ?>" alt="Photo de profil" class="profile-picture" width="200" height="200">
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

  const form = document.querySelector(".formulaire");

  // Ecouteur
  form.addEventListener("submit", function (event) {
    
    // Assure la bonne exécution du code avant l'envoi du formulaire
    event.preventDefault(); 

    const formData = new FormData();

    // Ajout d'une image si l'utilisateur en a choisi une
    const fileInput = form.picture;
    if (fileInput.files.length > 0) {
        formData.append("picture", fileInput.files[0]);
    }

    // Récupération des données du client
    formData.append("nom_utilisateur", form.username.value);
    formData.append("email_utilisateur", form.mail.value);
    formData.append("telephone_utilisateur", form.phone.value);
    formData.append("adresse", form.address.value);
    formData.append("code_postal_adresse", form.code.value);
    formData.append("ville_adresse", form.ville.value);
    formData.append("typeRequete", "modification");

    // fetch vers le dossier API de création client
    fetch("../API/Client.php", {
      method: "POST",
      body: formData //JSON.stringify(formData)
    })

    .then(response => response.json()) // http vers json
    .then(json => {
      console.log(json); // Test affichage

      // Compte modifié avec succès
      if (json.reponse == 200) {
        alert("Compte modifié !");
        window.location.href = "ConsulterCompteClient.php";
        /*form.submit();*/
      }
      
    })
    
    .catch(err => {
      console.error("Erreur :", err); 
    });

  });

</script>
