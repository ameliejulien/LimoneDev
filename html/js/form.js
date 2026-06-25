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

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = {
      mail: form.mail.value,
      nomUtilisateur: form.username.value,
      telephone: form.telephone.value,
      motDePasse: form.mdp.value,
      confMotDePasse: form.confMdp.value,
      typeRequete: "creation"
    };

    fetch("../API/Client.php", {
      method: "POST",
      body: JSON.stringify(formData)
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

// ----- Soumission du formulaire de connexion -----

/**
 * Initialise la soumission du formulaire de connexion.
 * Envoie les identifiants à l'API et redirige / notifie selon la réponse.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initConnexionForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = {
      mail: form.mail.value,
      motDePasse: form.mdp.value,
    };

    fetch("../API/Connexion.php", {
      method: "POST",
      body: JSON.stringify(formData)
    })
      .then(response => {
        if (response.status == 200) {
          window.location.href = "../Catalogue";
        } else {
          afficherSnackBar('Notification', 'Connexion échouée !');
        }
      });
  });
}

// ----- Soumission du formulaire de création de compte vendeur -----

/**
 * Initialise la soumission du formulaire de création de compte vendeur.
 * Envoie les données du formulaire à l'API et notifie/redirige selon la réponse.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initCreationCompteVendeurForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

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

    fetch("../API/Vendeur.php", {
      method: "POST",
      body: JSON.stringify(formData)
    })
      .then(response => {
        console.log("RESPONSE = ");
        console.log(response);

        if (response.status == 200) {
          alert("Compte créé !");
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

// ----- Modification du compte vendeur -----

/**
 * Initialise la soumission du formulaire de modification du compte vendeur.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initModificationCompteVendeur(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = {
      mail: form.mail.value,
      denomination: form.denomination.value,
      telephone_utilisateur: form.telephone.value,
      adresse: form.adresseVendeur.value,
      ville_adresse: form.villeVendeur.value,
      code_postal_adresse: form.codePostalVendeur.value,
      typeRequete: "modification"
    };

    fetch("../API/Vendeur.php", {
      method: "POST",
      body: JSON.stringify(formData)
    })
      .then(response => {
        if (response.status == 200) {
          window.location.href = "ConsulterCompteVendeur.php";
        } else if (response.status == 409) {
          afficherSnackBar('Notification', 'Echec de modification : email déjà utilisé !');
        } else {
          afficherSnackBar('Notification', 'Echec de modification !');
        }
      })
      .catch(err => {
        console.error("Erreur :", err);
      });
  });
}

// ----- Déconnexion client -----

/**
 * Initialise le bouton de déconnexion.
 *
 * @param {string} selector - sélecteur CSS du bouton de déconnexion (par défaut ".profil__bouton--deco")
 */
function initDeconnexion(selector = ".profil__bouton--deco") {
  const decoBtn = document.querySelector(selector);
  if (!decoBtn) return;

  decoBtn.addEventListener("click", function () {
    fetch("../API/Client.php", {
      method: "POST",
      body: JSON.stringify({ typeRequete: "deconnexion" })
    })
      .then(response => {
        if (response.status == 200) {
          window.location.href = "../Catalogue/";
        }
      })
      .catch(err => {
        console.error("Erreur :", err);
      });
  });
}

// ----- Déconnexion vendeur -----

/**
 * Initialise le bouton de déconnexion vendeur.
 *
 * @param {string} selector - sélecteur CSS du bouton (par défaut ".profil__bouton--deco")
 */
function initDeconnexionVendeur(selector = ".profil__bouton--deco") {
  const decoBtn = document.querySelector(selector);
  if (!decoBtn) return;

  decoBtn.addEventListener("click", function () {
    fetch("../API/Vendeur.php", {
      method: "POST",
      body: JSON.stringify({ typeRequete: "deconnexion" })
    })
      .then(response => {
        if (response.status === 200) {
          window.location.href = "../Catalogue/";
        }
      })
      .catch(err => {
        console.error("Erreur :", err);
      });
  });
}

// ----- Modification du compte client -----

/**
 * Initialise le formulaire de modification du compte client.
 * Gère la prévisualisation de l'image et l'envoi multipart vers l'API.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initModificationCompteClientForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData();

    const fileInput = form.picture;
    if (fileInput.files.length > 0) {
      formData.append("picture", fileInput.files[0]);
    }

    formData.append("nom_utilisateur",       form.username.value);
    formData.append("email_utilisateur",     form.mail.value);
    formData.append("telephone_utilisateur", form.phone.value);
    formData.append("adresse",               form.address.value);
    formData.append("code_postal_adresse",   form.code.value);
    formData.append("ville_adresse",         form.ville.value);
    formData.append("typeRequete",           "modification");

    fetch("../API/Client.php", {
      method: "POST",
      body: formData
    })
      .then(response => {
        if (response.status === 200) {
          window.location.href = "ConsulterCompteClient.php";
        } else {
          afficherSnackBar("Notification", "Échec de la modification du compte !");
        }
      })
      .catch(err => console.error("Erreur :", err));
  });
}

function changerImage(event) {
  const fichier = event.target.files[0];
  if (!fichier) return;

  const lecture = new FileReader();
  lecture.onload = function (selec) {
    document.getElementById("changementImage").src = selec.target.result;
  };
  lecture.readAsDataURL(fichier);
}

// ----- Modification du mot de passe client -----

/**
 * Initialise le formulaire de modification du mot de passe client.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initModificationMdpClientForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = {
      mdpCourant:     form.mdpCourant.value,
      nouveauMdp:     form.nouveauMdp.value,
      confNouveauMdp: form.confNouveauMdp.value,
      typeRequete:    "modificationMdp"
    };

    fetch("../API/Client.php", {
      method: "POST",
      body: JSON.stringify(formData)
    })
      .then(response => {
        if (response.status === 200) {
          window.location.href = "ConsulterCompteClient.php";
        } else if (response.status === 409) {
          afficherSnackBar("Notification", "Échec : nouveau mot de passe identique à l'ancien !");
        } else {
          afficherSnackBar("Notification", "Échec de la modification du mot de passe !");
        }
      })
      .catch(err => console.error("Erreur :", err));
  });
}

// ----- Restriction saisie chiffres -----

/**
 * Restreint la saisie d'un ou plusieurs champs à des chiffres uniquement.
 *
 * @param {...string} selectors
 */
function restreindreSaisieChiffres(...selectors) {
  selectors.forEach(function (selector) {
    const champ = document.querySelector(selector);
    if (!champ) return;

    champ.addEventListener("keydown", function (event) {
      const touchesAutorisees = [
        "Backspace", "Delete", "Tab", "Escape", "Enter",
        "ArrowLeft", "ArrowRight", "Home", "End"
      ];
      if (touchesAutorisees.includes(event.key)) return;
      if (event.ctrlKey || event.metaKey) return;
      if (!/^\d$/.test(event.key)) event.preventDefault();
    });

    champ.addEventListener("paste", function (event) {
      event.preventDefault();
      const texte = (event.clipboardData || window.clipboardData).getData("text");
      const chiffresUniquement = texte.replace(/\D/g, "");
      document.execCommand("insertText", false, chiffresUniquement);
    });
  });
}

/**
 * Initialise le formulaire de modification du mot de passe vendeur.
 *
 * @param {string} formSelector - sélecteur CSS du formulaire (par défaut ".formulaire")
 */
function initModificationMdpVendeurForm(formSelector = ".formulaire") {
  const form = document.querySelector(formSelector);
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = {
      mdpCourant:     form.mdpCourant.value,
      nouveauMdp:     form.nouveauMdp.value,
      confNouveauMdp: form.confNouveauMdp.value,
      typeRequete:    "modificationMdp"
    };

    fetch("../API/Vendeur.php", {
      method: "POST",
      body: JSON.stringify(formData)
    })
      .then(response => {
        if (response.status === 200) {
          window.location.href = "ConsulterCompteVendeur.php";
        } else if (response.status === 409) {
          afficherSnackBar("Notification", "Échec : nouveau mot de passe identique à l'ancien !");
        } else {
          afficherSnackBar("Notification", "Échec de la modification du mot de passe !");
        }
      })
      .catch(err => console.error("Erreur :", err));
  });
}

// ============================================================
// Chaque fonction vérifie elle-même si son élément
// existe sur la page, sans effet si l'élément est absent.
// ============================================================

restreindreSaisieChiffres('#numtel', '#codepostal', '#codepostalfac', '#cartebancaire', '#codesecret');
restreindreSaisieChiffres('#telephone', '#siret', '#codePostalVendeur', '#cleAuth');

initCreationCompteClientForm();
initConnexionForm();
initCreationCompteVendeurForm();
initModificationCompteVendeur();
initDeconnexion();
initDeconnexionVendeur();
initModificationCompteClientForm();
initModificationMdpClientForm();
initModificationMdpVendeurForm();