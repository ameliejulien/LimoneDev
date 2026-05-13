<?php
  include "ClassClient.php";
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
        <img src="johncena.jpeg" alt="Photo de profil" class="profile-picture" onclick="document.getElementById('willChangeImage').src='henriche.png'">
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
    </form>
  </body>
</html>