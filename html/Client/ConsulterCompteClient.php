<?php
  include "ClassClient.php";
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
        <img src="johncena.jpeg" alt="Photo de profil" class="profile-picture">
      </div>

      <div class="divForm">
        <label for="username">Nom d'utilisateur</label>
        <output type="text" name="username" required>John Cena</output>
      </div>
    
      <div class="divForm">
        <label for="mail">Adresse mail</label>
        <output type="email" name="mail" required>john.cena@example.com</output>
      </div>

      <div class="divForm">
        <label for="phone">Numéro de téléphone</label>
        <output type="tel" name="phone" required>06 12 34 56 78</output>
      </div>
      
      <div class="divForm">
        <label for="address">Adresse postale</label>
        <output type="text" name="address" required>5 Rue de la Paix</output>
      </div>

      <div class="divForm">
        <label for="address">Code postal</label>
        <output type="text" name="address" required>22300</output>
      </div>

      <div class="divForm">
        <label for="address">Ville</label>
        <output type="text" name="address" required>Lannion</output>
      </div>
    </form>



  <?php

    /**
     * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
     * cette fonction redirige vers la page de connexion
     
    * @Return Un object Client en base de données
    */
    function confimerInscirption() {

      // Récupération des champs du formulaire
      $mail = strtolower($_POST["mail"]);
      $nomUtilisateur = $_POST["username"];
      $mdp = $_POST["mdp"];
      $confMdp = $_POST["confMdp"];

      // Comparaison des mots de passe
      $mdpEgaux = ($mdp == $confMdp);

      if ($mdpEgaux) {
        $client = new Client($mail, $nomUtilisateur, $mdp);
      ?>
        <script>alert('compte créé avec succès')</script>
        
      <?php

        echo "mail : $mail";
        // TODO : changer pour mettre le chemin de la page de connexion
        //header("Location: https://fr.wiktionary.org/wiki/jaaj");
        //exit;
      
        } else {
          ?>
          <script>alert('échec de création du compte')</script>";
          <?php
      }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      confimerInscirption();
    }


  ?>
  </body>
</html>