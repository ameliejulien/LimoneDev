<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="client.css">
  <link rel="stylesheet" href="../Global.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Compte Client</title>
</head>
<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Création de compte client</h1>
  <form class="formulaire">
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
    <input type="submit" value="S'inscrire" class="submit"/>

    <div class="snackbar">
      <h3 class="snackbarTitle"></h3>
      <p class="snackbarText"></p>
    </div>

    
  </form>

  <p>Vous êtes vendeur ? : <a href="../Vendeur/CreerCompteVendeur.php">cliquez ici</a></p>
  <!--<script src="../snackbar.js"></script> -->
  <script>
    const form = document.querySelector(".formulaire");
    // écouteur des requêtes du formulaire
    form.addEventListener("submit", function (event) {
      
      // empêche l'envoi du formulaire sans exécuter le code qui suit
      event.preventDefault(); 

      // récupération des infos du formulaire
      const formData = {
        mail: form.mail.value,
        nomUtilisateur: form.username.value,
        telephone: form.telephone.value,
        motDePasse : form.mdp.value,
        confMotDePasse: form.confMdp.value,
        typeRequete: "creation"
      }

      // fetch vers le dossier API de création client
      fetch("../API/Client.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
      .then(response => response.json())  // transforme la réponse http en json exploitable
      .then(json => {
        console.log(json);      // test affichage retour
        if (json.reponse == 200) {
          alert("Compte créé !"); // alert de la création du compte
          window.location.href = "/Connexion/";
        
        } else if (json.reponse == 409) {
          afficherSnackBar('Notification','Echec de création de compte : email déjà utilisé !');
        
        } else {
          afficherSnackBar('Notification','Echec de création de compte !');
        } 
        
      
      })
      .catch(err => {
        console.error("Erreur :");
        console.error(err);
      });
    });
</script>
</body>
</html>