////////////////
// Fonctions //
//////////////

/**
 * Affiche l'image dans le champs prévu à cette effet.
 * @param {Event} event
 */
function changerImage(event) {
  const fichier = event.target.files[0];

  // Vérification qu'une image a été choisie
  if (fichier) {
    const lecture = new FileReader();

    lecture.onload = function (selec) {
      // Changement de la photo du produit
      document.getElementById("imageProduit").src = selec.target.result;
    };

    lecture.readAsDataURL(fichier);
  }
}

/**
 * Fonction pour créer un produit, elle fait une premiere verification de champs puis envoie au serveur via l'api pour une deuxième verification
 */
function creerProduit() {}

/////////////////
// Listenners //
///////////////

// Récupère le html entity du formulaire
var form = document.querySelector("form.produit-page");

// Ajoute un écouteur pour récuperer le moment ou l'utilisateur soumet le formulaire

form.addEventListener("submit", function (event) {
  event.preventDefault();

  const inputArray = form.querySelectorAll("input, select, textarea");

  const aUneErreur = [...inputArray].some((element) => {
    if (element.type === "checkbox") return false;

    if (element.type === "file") {
      return element.files.length === 0;
    }

    if (element.value.trim() === "") return true;

    if (
      element.pattern &&
      !new RegExp(`^(?:${element.pattern})$`).test(element.value)
    )
      return true;

    if (element.minLength !== -1 && element.value.length < element.minLength)
      return true;

    return false;
  });

  if (aUneErreur) return;

  // Permet d'envoyer l'image au php
  const formData = new FormData();
  inputArray.forEach((element) =>
    formData.append(
      element.id,
      element.type === "file" ? element.files[0] : element.value,
    ),
  );

  // Si le formulaire est invalide alors il ne faut pas l'envoyer
  fetch("../API/CreerProduit.php", {
    method: "POST",
    body: formData,
  }).then((response) => {
    if (response.status === 200) {
      response.json().then((jsonResponse) => {
        if (!jsonResponse["succes"]) {
          afficherSnackBar("Erreur", jsonResponse["message"]);

          // Change la couleurs des bordures des champs invalides
          if (jsonResponse["erreurs"]) {
            jsonResponse["erreurs"].forEach((id) => {
              const element = document.getElementById(id);
              if (element) element.style.borderBottomColor = "red";
            });
          }
        } else {
          form.action = `../Produit/Produit.php?id=${jsonResponse["idProduit"]}`;
          form.submit();
        }
      });
    } else {
      afficherSnackBar("Erreur", "Une erreur est survenue");
    }
  });
});

document
  .getElementsByClassName("categorie-tag")[0]
  .addEventListener("change", function (event) {
    categorie = document.getElementById("categorieProduit").value;

    if (categorie == "") {
      document.getElementsByClassName("categorie-tag")[0].style.background =
        "#e4cacc";
    } else {
      document.getElementsByClassName("categorie-tag")[0].style.background =
        "#b3d3bc";
    }
  });

document
  .getElementById("prixProduit")
  .addEventListener("keyup", function (event) {
    tva = document.getElementById("tva").value;
    prixHT = document.getElementById("prixProduit").value;

    if (prixHT == 0 || isNaN(prixHT)) {
      document.getElementById("prixAvecTaxe").innerHTML = "0";
    } else {
      document.getElementById("prixAvecTaxe").innerHTML =
        prixHT * (1 + tva / 100);
    }
  });

document.getElementById("tva").addEventListener("keyup", function (event) {
  tva = document.getElementById("tva").value;

  if (tva == 0 || isNaN(tva)) {
    document.getElementById("tvaAffiche").innerHTML = "0";
    document.getElementById("prixAvecTaxe").innerHTML = prixHT;
  } else {
    document.getElementById("tvaAffiche").innerHTML = tva;
    document.getElementById("prixAvecTaxe").innerHTML =
      prixHT * (1 + tva / 100);
  }
});
document.getElementById("prixAvecTaxe").innerHTML = "0";

////////////////////////////////////////////////////////////////////////
// Même au reload de la page le prix est caluculé et l'image affiché //
//////////////////////////////////////////////////////////////////////

tva = document.getElementById("tva").value;
prixHT = document.getElementById("prixProduit").value;

if (tva == 0 || isNaN(tva)) {
  document.getElementById("tvaAffiche").innerHTML = "0";
} else {
  document.getElementById("tvaAffiche").innerHTML = tva;
  document.getElementById("prixAvecTaxe").innerHTML = prixHT * (1 + tva / 100);
}

if (prixHT == 0 || tva == 0 || isNaN(prixHT) || isNaN(tva)) {
  document.getElementById("prixAvecTaxe").innerHTML = "0";
} else {
  document.getElementById("prixAvecTaxe").innerHTML = prixHT * (1 + tva / 100);
}

categorie = document.getElementById("categorieProduit").value;

if (categorie == "") {
  document.getElementsByClassName("categorie-tag")[0].style.background =
    "#e4cacc";
} else {
  document.getElementsByClassName("categorie-tag")[0].style.background =
    "#b3d3bc";
}

const fichier = document.getElementById("champImageProduit").files[0];

// Vérification qu'une image a été choisie
if (fichier) {
  const lecture = new FileReader();

  lecture.onload = function (selec) {
    // Changement de la photo du produit
    document.getElementById("imageProduit").src = selec.target.result;
  };

  lecture.readAsDataURL(fichier);
}
