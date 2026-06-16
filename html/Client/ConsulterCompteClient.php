<?php
?>

<!DOCTYPE html>
<html lang="fr">
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client.css">
  <link rel="stylesheet" href="../Global.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Profil client</title>
</head>

<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Profil</h1>
  <form class="formulaire" method="POST">
    
    <div class="divForm">
      <label for="picture">Photo de profil</label>
      <?php 
        require '../../lib/service/ServiceClient.php';

        $uuid = $_COOKIE['uuid'];
        $infosClient = recupererInfosClient($uuid);
        $imgData = $infosClient['pp_utilisateur'];
        if (is_resource($imgData)) {
            $imgSrc = "data:image/jpeg;base64," . base64_encode(stream_get_contents($imgData));
        } elseif (!empty($imgData)) {
            $imgSrc = "data:image/jpeg;base64," . base64_encode($imgData);
        } else {
            $imgSrc = "../../imagesProduits/image-none.jpg";
        }
      ?>
      <img src="<?= $imgSrc ?>" alt="Photo de profil" class="profile-picture" width="200" height="200">
    </div>

    <div class="divForm">
      <label for="username">Nom utilisateur</label>
      <span>
        <?= $infosClient['nom_utilisateur'] == NULL ? "Pseudo non renseigné" : $infosClient['nom_utilisateur'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="mail">Adresse mail</label>
      <span>
        <?= $infosClient['email_utilisateur'] == NULL ? "Mail non renseigné" : $infosClient['email_utilisateur'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="phone">Numéro de téléphone</label>
      <span>
        <?= $infosClient['telephone_utilisateur'] == NULL ? "Téléphone non renseigné" : $infosClient['telephone_utilisateur'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="address">Adresse postale</label>
      <span> <?= $infosClient['adresse'] == NULL ? "Adresse non renseignée" : $infosClient['adresse'] ?> </span>
    </div>

    <div class="divForm">
      <label for="address">Code postal</label>
      <span>
        <?= $infosClient['code_postal_adresse'] == NULL ? "Code postal non renseigné" : $infosClient['code_postal_adresse'] ?>
      </span>
    </div>

    <div class="divForm">
      <label for="address">Ville</label>
      <span> <?= $infosClient['ville_adresse'] == NULL ? "Ville non renseignée" : $infosClient['ville_adresse'] ?>
      </span>
    </div>

    <div class="divBtnForm">
      <button type="button" class="buttonForm" onclick="window.location.href='ModifierCompteClient.php'">Modifier Compte</button>
      <button type="button" class="buttonForm" onclick="window.location.href='ModifierMdpClient.php'">Modifier mot de passe</button>
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
            alert("Compte déconnecté!"); // alerte de la déconnexion du compte
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