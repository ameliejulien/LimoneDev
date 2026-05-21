<?php
  include '../../lib/service/ServiceClient.php';
  $idClient = json_decode($_COOKIE['client'], true)['idClient'];
  $infosClient = recupererInfosClient($idClient);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="client.css">
  <link rel="stylesheet" href="../Global.css">
  <title>Profil client</title>
</head>

<body>
  <h1>Profil</h1>
  <form method="POST">

    <div class="divForm">
      <label for="picture">Photo de profil</label>
      <img src=<?= $infosClient[0]['pp_utilisateur'] == NULL ? "../../images/image-none.jpg" : $infosClient[0]['pp_utilisateur'] ?> alt="Photo de profil" class="profile-picture" width="200" height="200">
    </div>

    <div class="divForm">
      <label for="username">Nom utilisateur</label>
      <span>
        <?= $infosClient[0]['nom_utilisateur'] == NULL ? "Pseudo non renseigné" : $infosClient[0]['nom_utilisateur'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="mail">Adresse mail</label>
      <span>
        <?= $infosClient[0]['email_utilisateur'] == NULL ? "Mail non renseigné" : $infosClient[0]['email_utilisateur'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="phone">Numéro de téléphone</label>
      <span>
        <?= $infosClient[0]['telephone_utilisateur'] == NULL ? "Téléphone non renseigné" : $infosClient[0]['telephone_utilisateur'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="address">Adresse postale</label>
      <span> <?= $infosClient[0]['adresse'] == NULL ? "Adresse non renseignée" : $infosClient[0]['adresse'] ?> </span>
    </div>

    <div class="divForm">
      <label for="address">Code postal</label>
      <span>
        <?= $infosClient[0]['code_postal_adresse'] == NULL ? "Code postal non renseigné" : $infosClient[0]['code_postal_adresse'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="address">Ville</label>
      <span> <?= $infosClient[0]['ville_adresse'] == NULL ? "Ville non renseignée" : $infosClient[0]['ville_adresse'] ?>
      </span>
    </div>
    <a href="ModifierCompteClient.php"><input type="button" value="Modifier" /></a>
    <a href="ModifierMdpClient.php"><input type="button" value="Modifier le mot de passe" /></a>

    <div class="divBtnForm">
      <button type="button" class="buttonForm decoBtn">Déconnexion</button>
    </div>
  </form>

  <script>
    const decoBtn = document.querySelector(".decoBtn");

    decoBtn.addEventListener("click", function (event) {
      console.log("click jaaj");

      const formData = {
        typeRequete: "deconnexion"
      }

      // fetch vers le dossier API de création client
      fetch("../API/Client.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
        .then(response => response.json())  // transforme la réponse http en json exploitable
        .then(json => {
          if (json.reponse == 200) {
            alert("Compte déconnecté!"); // alert de la création du compte
            window.location.href = "../Catalogue/";
          }
        })
        .catch(err => {
          console.error("Erreur :", err);
        });
    });
  </script>
</body>

</html>