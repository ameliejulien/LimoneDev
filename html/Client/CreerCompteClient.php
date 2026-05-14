<?php
  include "ClassClient.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="client.css">
  <title>Compte Client</title>
</head>
<body>
  <h1>Création de compte client</h1>
  <form method="POST">
    <div class="divForm">
      <label for="mail">Adresse mail</label>
      <input type="email" name="mail" required>
    </div>

    <div class="divForm">
      <label for="username">Nom d'utilisateur</label>
      <input type="text" name="username" required>
    </div>

    <div class="divForm">
      <label for="telephone">Numéro de téléphone</label>
      <input type="tel" name="telephone" required placeholder="exemple : 0606060606">
    </div>
    
    <div class="divForm">
      <label for="mdp">Mot de passe</label>
      <input type="password" name="mdp" required minlength="8">
    </div>
    
    <div class="divForm">
      <label for="confMdp">Confirmation du mot de passe</label>
      <input type="password" name="confMdp" required  minlength="8">
    </div>
    <input type="submit" value="S'inscrire"/>
  </form>

</body>
</html>