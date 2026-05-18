<?php
  include "ServiceClient.php";
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
        <img src="<?php echo('".$test."'); ?>" alt="Photo de profil" class="profile-picture">
      </div>

      <div class="divForm">
        <label for="username">Nom d'utilisateur</label>
        <output type="text" name="username" required value="<?php echo('".$test."'); ?>">John Cena</output>
      </div>
    
      <div class="divForm">
        <label for="mail">Adresse mail</label>
        <output type="email" name="mail" required value="<?php echo('".$email_utilisateur."'); ?>">john.cena@example.com</output>
      </div>

      <div class="divForm">
        <label for="phone">Numéro de téléphone</label>
        <output type="tel" name="phone" required value="<?php echo('".$test."'); ?>">06 12 34 56 78</output>
      </div>
      
      <div class="divForm">
        <label for="address">Adresse postale</label>
        <output type="text" name="address" required value="<?php echo('".$test."'); ?>">5 Rue de la Paix</output>
      </div>

      <div class="divForm">
        <label for="address">Code postal</label>
        <output type="text" name="address" required value="<?php echo('".$test."'); ?>">22300</output>
      </div>

      <div class="divForm">
        <label for="address">Ville</label>
        <output type="text" name="address" required value="<?php echo('".$test."'); ?>">Lannion</output>
      </div>
      <a href="ModifierCompteClient.php"><input type="button" value="Modifier"/></a>
    </form>
  </body>
</html>