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
    <title>Profil client</title>
  </head>
  <body>
    <h1>Profil</h1>
    <form method="POST">

      <div class="divForm">
        <label for="picture">Photo de profil</label>
        <img src=<?=$infosClient['pp_utilisateur']; ?> alt="Photo de profil" class="profile-picture" width="200" height="200">
      </div>

      <div class="divForm">
        <label for="username">Nom utilisateur</label>
        <output type="text" name="username" required value="<?=$infosClient['nom_utilisateur']; ?>">Pseudo</output>
      </div>
    
      <div class="divForm">
        <label for="mail">Adresse mail</label>
        <output type="email" name="mail" required value="<?=$infosClient['email_utilisateur']; ?>">mail@example.com</output>
      </div>

      <div class="divForm">
        <label for="phone">Numéro de téléphone</label>
        <output type="tel" name="phone" required value="<?=$infosClient['telephone_utilisateur']; ?>">06 12 34 56 78</output>
      </div>
      
      <div class="divForm">
        <label for="address">Adresse postale</label>
        <output type="text" name="address" required value="<?=$infosClient['adresse']; ?>">5 Rue de la Paix</output>
      </div>

      <div class="divForm">
        <label for="address">Code postal</label>
        <output type="text" name="address" required value="<?=$infosClient['code_postal_adresse']; ?>">29200</output>
      </div>

      <div class="divForm">
        <label for="address">Ville</label>
        <output type="text" name="address" required value="<?=$infosClient['ville_adresse']; ?>">Brest</output>
      </div>
      <a href="ModifierCompteClient.php"><input type="button" value="Modifier"/></a>
    </form>
  </body>
</html>