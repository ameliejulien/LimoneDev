function validerFormulaire() {
    var inputs = document.querySelectorAll('input');
    var probleme = false;

    const nom = document.getElementById("nom");
    const prenom = document.getElementById("prenom");
    const numtel = document.getElementById("numtel");

    const email = document.getElementById("mail");
    const adresse = document.getElementById("adresse");
    const ville = document.getElementById("ville");
    const codepostal = document.getElementById("codepostal");
    const adressefac = document.getElementById("adressefac");
    const codepostalfac = document.getElementById("codepostalfac");
    const villefac = document.getElementById("villefac");
    const cartebancaire = document.getElementById("cartebancaire");
    const codesecret = document.getElementById("codesecret");
    const titulairecb = document.getElementById("titulairecb");

    email.addEventListener("input", (event) => {
        if(email.validity.patternMismatch){
            email.setCustomValidity("Veuillez entrer une adresse mail valide.");
        }else if (email.validity.typeMismatch) {
            email.setCustomValidity("Veuillez entrer une adresse mail valide de type example@example.com")
        } else if (email.validity.valueMissing) {
            email.setCustomValidity("Veuillez entrer une adresse mail.");
        } else {
            email.setCustomValidity("");
        }
    });

    adresse.addEventListener("input", (event) => {
        if (adresse.validity.valueMissing) {
            adresse.setCustomValidity("Veuillez entrer une adresse.");
        } else {
            adresse.setCustomValidity("");
        }
    });

    codepostal.addEventListener("input", (event) => {
        if (codepostal.validity.patternMismatch) {
            codepostal.setCustomValidity("Veuillez entrer un code postal valide.");
        } else {
            codepostal.setCustomValidity("");
        }
    });

    codepostalfac.addEventListener("input", (event) => {
        if (codepostalfac.validity.patternMismatch) {
            codepostalfac.setCustomValidity("Veuillez entrer un code postal valide.");
        } else {
            codepostalfac.setCustomValidity("");
        }
    });

    cartebancaire.addEventListener("input", (event) => {
        if (cartebancaire.validity.patternMismatch) {
            cartebancaire.setCustomValidity("Veuillez entrer un code de CB valide.");
        } else {
            cartebancaire.setCustomValidity("");
        }
    });

    codesecret.addEventListener("input", (event) => {
        if (codesecret.validity.patternMismatch) {
            codesecret.setCustomValidity("Veuillez entrer un CVV valide. (3 ou 4 chiffres)");
        } else {
            codesecret.setCustomValidity("");
        }
    });

    return !probleme;
}

// Récupère le html entity du formulaire
var form = document.querySelector('form');

// Ajoute un écouteur pour récuperer le moment ou l'utilisateur soumet le formulaire
form.addEventListener('submit', function (event) {
    event.preventDefault();

    // Si le formulaire est invalide alors il ne faut pas l'envoyer
    if (validerFormulaire()) {
        form.submit();
    }
});