<?php
  include "ServiceClient.php";
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client.css">
    <title>Modifier le profil</title>
  </head>
  <body>
    <h1>Profil</h1>
    <form method="POST">

      <div class="divForm">
        <label for="picture">Photo de profil</label>
        <img id="changementImage" src="johncena.jpeg" alt="Photo de profil" class="photoProfil" height="200" width="200">
        <input type="file" name="picture" accept="image/*" onchange="changerImage(event)">
      </div>

      <div class="divForm">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" required>
      </div>
    
      <div class="divForm">
        <label for="mail">Adresse mail</label>
        <input type="email" name="mail" required>
      </div>

      <div class="divForm">
        <label for="phone">Numéro de téléphone</label>
        <input type="tel" name="phone" required>
      </div>
      
      <div class="divForm">
        <label for="address">Adresse postale</label>
        <input type="text" name="address" required>
      </div>

      <div class="divForm">
        <label for="address">Code postal</label>
        <input type="text" name="address" required>
      </div>

      <div class="divForm">
        <label for="address">Ville</label>
        <input type="text" name="address" required>
      </div>
      <input type="submit" value="Enregistrer les modifications"/>
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
</script>