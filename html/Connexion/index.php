<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/Connexion/connexion.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <title>Connexion au compte</title>
</head>
<body>

  <?php require_once '../ui/header.php'; ?>
  <h1>Connexion</h1>
  <form class="formulaire" method="POST">
    <div class="divForm">
      <label for="mail">Adresse mail</label>
      <input type="email" name="mail" required>
    </div>
    
    <div class="divForm">
      <label for="mdp">Mot de passe</label>
      <input type="password" name="mdp" required minlength="8">
    </div>
    
    <input type="submit" value="Se connecter" class="submit"/>
  </form>

  <div class="snackbar">
    <h3 class="snackbarTitle"></h3>
    <p class="snackbarText"></p>
  </div>

  <script src="../snackbar.js"></script>

  <script>
    const form = document.querySelector(".formulaire");

    // écouteur des requêtes du formulaire
    form.addEventListener("submit", function (event) {
      
      // empêche l'envoi du formulaire sans exécuter le code qui suit
      event.preventDefault(); 

      // récupération des infos du formulaire
      const formData = {
        mail: form.mail.value,
        motDePasse : form.mdp.value,
      }

      console.log(formData);

      // fetch vers le dossier API de création client
      fetch("../API/Connexion.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
      .then(response => {
        if (response.status == 200) {
          // afficherSnackBar('Notification','Connexion réussie !'); // alerte de la création du compte
          window.location.href = "../Catalogue";
        } else {
          afficherSnackBar('Notification','Connexion échouée !'); // alerte de l'échec de la connexion
        }
      })
    });
</script>

</body>
</html>