<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compte Client</title>
</head>
<body>
  <h1>Création de compte client</h1>
  <form method="POST">
    <div>
      <label for="mail">Adresse mail</label>
      <input type="email" name="mail" required>
    </div>

    <div>
      <label for="username">Nom d'utilisateur</label>
      <input type="text" name="username" required>
    </div>
    
    <div>
      <label for="mdp">Mot de passe</label>
      <input type="password" name="mdp" required minlength="8">
    </div>
    
    <div>
      <label for="confMdp">Confirmation du mot de passe</label>
      <input type="password" name="confMdp" required  minlength="8">
    </div>
    <input type="submit" value="S'inscrire"/>
  </form>
</body>
</html>


<?php

  final class CompteClient{
   
    public $mail;
    public $nomUtilisateur;
    public $motDePasse;

    
  }
  

  /**
   * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
   * cette fonction redirige vers la page de connexion
   
   * @Return Un object Client en base de données
   */
  function confimerInscirption() {
    // Récupération des champs du formulaire
    $email = $_POST["mail"];
    $nomUtilisateur = $_POST["username"];
    $mdp = $_POST["mdp"];
    $confMdp = $_POST["confMdp"];

    // Comparaison des mots de passe
    $mdpEgaux = ($mdp == $confMdp);

    if ($mdpEgaux) {
      echo "inscription validée";
    } else {
      echo "erreur, inscription invalide";
    }
    // TODO : afficher un message de confirmation de création de compte
    // TODO : faire une redirection vers la page de connexion
  }

?>