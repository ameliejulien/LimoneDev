<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="client.css">
  <title>Compte Client</title>
</head>
<body>
  <h1>Connexion au compte client</h1>
  <form method="POST">
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

  <script>
    const form = document.querySelector("form");

    // écouteur des requêtes du formulaire
    form.addEventListener("submit", function (event) {
      
      // empêche l'envoi du formulaire sans exécuter le code qui suit
      event.preventDefault(); 

      // récupération des infos du formulaire
      const formData = {
        mail: form.mail.value,
        motDePasse : form.mdp.value,
        typeRequete: "connexion"
      }

      // fetch vers le dossier API de création client
      fetch("../API/CreerClient.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
      .then(response => response.json())  // transforme la réponse http en json exploitable
      .then(json => {
        console.log(json);      // test affichage retour
        if (json.reponse == 200) {
          alert("Connexion réussie !"); // alerte de la création du compte
        
        } else {
          alert("Connexion échouée !"); // alerte de l'échec de la connexion
        }
      })
    });
</script>

</body>
</html>