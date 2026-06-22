
// ----- Labels flottants -----
document.querySelectorAll(".form__group").forEach(function (group) {
  const field = group.querySelector(".form__field");
  if (!field) return;

  const syncFilledState = function () {
    group.classList.toggle("is-filled", field.value.trim() !== "");
  };

  field.addEventListener("focus", function () {
    group.classList.add("is-active");
  });
  field.addEventListener("blur", function () {
    group.classList.remove("is-active");
    syncFilledState();
  });
  field.addEventListener("input", syncFilledState);

  syncFilledState(); // au cas où le champ est pré-rempli (autocomplete navigateur, etc.)
});

// ----- Soumission du formulaire de création de compte client -----

/**
 * Initialise la soumission du formulaire de création de compte client.
 * Envoie les données du formulaire à l'API et redirige / notifie selon la réponse.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initCreationCompteClientForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  // écouteur des requêtes du formulaire
  form.addEventListener("submit", function (event) {

    // empêche l'envoi du formulaire sans exécuter le code qui suit
    event.preventDefault();

    // récupération des infos du formulaire
    const formData = {
      mail: form.mail.value,
      nomUtilisateur: form.username.value,
      telephone: form.telephone.value,
      motDePasse: form.mdp.value,
      confMotDePasse: form.confMdp.value,
      typeRequete: "creation"
    };

    // fetch vers le dossier API de création client
    fetch("../API/Client.php", {
      method: "POST",
      body: JSON.stringify(formData) // fait une string JSON du tableau
    })
      .then(response => {
        if (response.status == 201) {
          window.location.href = "/Connexion/";
        } else if (response.status == 409) {
          afficherSnackBar('Notification', 'Echec de création de compte : email déjà utilisé !');
        } else {
          afficherSnackBar('Notification', 'Echec de création de compte !');
        }
      })
      .catch(err => {
        console.error("Erreur :");
        console.error(err);
      });
  });
}

/**
 * Initialise la soumission du formulaire de connexion.
 * Envoie les identifiants à l'API et redirige / notifie selon la réponse.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initConnexionForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  // écouteur des requêtes du formulaire
  form.addEventListener("submit", function (event) {

    // empêche l'envoi du formulaire sans exécuter le code qui suit
    event.preventDefault();

    // récupération des infos du formulaire
    const formData = {
      mail: form.mail.value,
      motDePasse: form.mdp.value,
    };

    // fetch vers le dossier API de connexion
    fetch("../API/Connexion.php", {
      method: "POST",
      body: JSON.stringify(formData) // fait une string JSON du tableau
    })
      .then(response => {
        if (response.status == 200) {
          // afficherSnackBar('Notification','Connexion réussie !'); // alerte de la création du compte
          window.location.href = "../Catalogue";
        } else {
          afficherSnackBar('Notification', 'Connexion échouée !'); // alerte de l'échec de la connexion
        }
      });
  });
}

/**
 * Initialise la soumission du formulaire de création de compte vendeur.
 * Envoie les données du formulaire à l'API et notifie/redirige selon la réponse.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initCreationCompteVendeurForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  // écouteur des requêtes du formulaire
  form.addEventListener("submit", function (event) {

    // empêche l'envoi du formulaire sans exécuter le code qui suit
    event.preventDefault();

    // récupération des infos du formulaire
    const formData = {
      mail: form.mail.value,
      denomination: form.denomination.value,
      telephone: form.telephone.value,
      cleAuth: form.cleAuth.value,
      siret: form.siret.value,
      adresseVendeur: form.adresseVendeur.value,
      villeVendeur: form.villeVendeur.value,
      codePostalVendeur: form.codePostalVendeur.value,
      motDePasse: form.mdp.value,
      confMotDePasse: form.confMdp.value,
      typeRequete: "creation"
    };

    // fetch vers le dossier API de création vendeur
    fetch("../API/Vendeur.php", {
      method: "POST",
      body: JSON.stringify(formData) // fait une string JSON du tableau
    })
      .then(response => {
        console.log("RESPONSE = ");
        console.log(response); // test affichage retour

        if (response.status == 200) {
          alert("Compte créé !"); // alert de la création du compte
          window.location.href = "ConnexionCompteVendeur.php";

        } else if (response.status == 609) {
          afficherSnackBar('Notification', 'Echec de création de compte : Clé d\'authentification invalide');
        } else if (response.status == 608) {
          afficherSnackBar('Notification', 'Echec de création de compte : Le SIRET est invalide. Format : 14 chiffres');
        } else if (response.status == 607) {
          afficherSnackBar('Notification', 'Echec de création de compte : L\'adresse contient des caractères invalides');
        } else if (response.status == 606) {
          afficherSnackBar('Notification', 'Echec de création de compte : La ville contient des caractères invalides');
        } else if (response.status == 605) {
          afficherSnackBar('Notification', 'Echec de création de compte : Code postal invalide. Format : 12345');
        } else if (response.status == 604) {
          afficherSnackBar('Notification', 'Echec de création de compte : Le mot de passe renseigné est différent de la confirmation');
        } else if (response.status == 603) {
          afficherSnackBar('Notification', 'Echec de création de compte : Numéro de téléphone invalide. Format : 0123456789');
        } else if (response.status == 602) {
          afficherSnackBar('Notification', 'Echec de création de compte : La dénomination contient des caractères invalides');
        } else if (response.status == 601) {
          afficherSnackBar('Notification', 'Echec de création de compte : E-mail invalide');
        } else {
          afficherSnackBar('Notification', 'Echec de création de compte !');
        }
      })
      .catch(err => {
        console.error("Erreur :", err);
      });
  });
}

/**
 * Restreint la saisie d'un ou plusieurs champs à des chiffres uniquement.
 * Bloque toute touche non numérique et nettoie les valeurs collées (coller/copier).
 *
 * @param {...string} selectors
 *
 */
function restreindreSaisieChiffres(...selectors) {
  selectors.forEach(function (selector) {
    const champ = document.querySelector(selector);
    if (!champ) return;

    // Bloque les touches non numériques à la frappe
    champ.addEventListener("keydown", function (event) {
      const touchesAutorisees = [
        "Backspace", "Delete", "Tab", "Escape", "Enter",
        "ArrowLeft", "ArrowRight", "Home", "End"
      ];
      if (touchesAutorisees.includes(event.key)) return;
      if (event.ctrlKey || event.metaKey) return; // autorise Ctrl+C, Ctrl+V...
      if (!/^\d$/.test(event.key)) event.preventDefault();
    });

    // Nettoie les valeurs collées (copier-coller)
    champ.addEventListener("paste", function (event) {
      event.preventDefault();
      const texte = (event.clipboardData || window.clipboardData).getData("text");
      const chiffresUniquement = texte.replace(/\D/g, "");
      document.execCommand("insertText", false, chiffresUniquement);
    });
  });
}
restreindreSaisieChiffres('#numtel', '#codepostal', '#codepostalfac', '#cartebancaire', '#codesecret');
restreindreSaisieChiffres('#telephone', '#siret', '#codePostalVendeur', '#cleAuth');
initCreationCompteVendeurForm();
initConnexionForm();
initCreationCompteClientForm();