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
      <label for="mdp">Mot de passe</label>
      <input type="password" name="mdp" required minlength="8">
    </div>
    
    <div class="divForm">
      <label for="confMdp">Confirmation du mot de passe</label>
      <input type="password" name="confMdp" required  minlength="8">
    </div>
    <input type="submit" value="S'inscrire"/>
  </form>



<?php

  // méthodes liées aux informations bancaires ?
  
  

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