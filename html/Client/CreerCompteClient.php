<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="client.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Compte</title>
</head>
<body>
  <?php require_once '../ui/header.php'; ?>
  <h1>Création de compte</h1>
  <form class="formulaire">
    <div class="form__group">
      <input type="email" id="mail" name="mail" class="form__field" placeholder=" " required>
      <label for="mail" class="form__label">Adresse mail</label>
      <small class="form__hint">Exemple : test@client.fr</small>
    </div>

    <div class="form__group">
      <input type="text" id="username" name="username" class="form__field" placeholder=" " required>
      <label for="username" class="form__label">Nom d'utilisateur</label>
    </div>

    <div class="form__group">
      <input type="tel" id="telephone" name="telephone" class="form__field" placeholder=" " required minlength="10" maxlength="10">
      <label for="telephone" class="form__label">Numéro de téléphone</label>
      <small class="form__hint">Exemple : 06 12 34 56 78</small>
    </div>

    <div class="form__group">
      <input type="password" id="mdp" name="mdp" class="form__field" placeholder=" " required minlength="8">
      <label for="mdp" class="form__label">Mot de passe</label>
    </div>

    <div class="form__group">
      <input type="password" id="confMdp" name="confMdp" class="form__field" placeholder=" " required minlength="8">
      <label for="confMdp" class="form__label">Confirmation du mot de passe</label>
    </div>

    <br>
    
    <input type="submit" title="Bouton d'inscription" value="S'inscrire" class="submit profil__bouton"/>

    <div class="snackbar">
      <h3 class="snackbarTitle"></h3>
      <p class="snackbarText"></p>
    </div>

    <p class="formulaire__vendeur">Vous êtes vendeur ? : <a href="../Vendeur/CreerCompteVendeur.php" title="Page de création compte vendeur" >Cliquez ici</a></p>
</form>
  
<script src="../snackbar.js"></script>
<script src="../js/form.js"></script>
<?php require_once '../ui/footer.php'; ?>
</body>
</html>