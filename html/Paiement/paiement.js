function validerFormulaire() {
    var inputs = document.querySelectorAll('input');
    var probleme = false;

    inputs.forEach(input => {
        // Vérification du vide pour tous les inputs (espaces pris en compte)
        if (input.value.trim() === "") {
            alert("Veuillez remplir ce champ : " + input.name);
            probleme = true;
            return false;
        }

        var regex;

        // Switch pour les differentes vérifications par regex
        switch (input.name) {
            case "telephone":
                regex = /0[0-9] ?([0-9]{2} ?){4}/g;
                if (!regex.test(input.value)) {
                    alert("Veuillez remplir ce champ correctement : " + input.name);
                    probleme = true;
                    return;
                }
                break;
            case "carteBancaire":
                regex = /[0-9]{16}/g;
                if (!regex.test(input.value)) {
                    alert("Veuillez remplir ce champ correctement : " + input.name);
                    probleme = true;
                    return;
                }
                break;
            case "codeSecretCB":
                regex = /[0-9]{3}/g;
                if (!regex.test(input.value)) {
                    alert("Veuillez remplir ce champ correctement : " + input.name);
                    probleme = true;
                    return;
                }
                break;
            default:
                break;
        }
    });

    return !probleme;
}

// Récupère le html entity du formulaire
var form = document.querySelector('form');

// Ajoute un écouteur pour récuperer le moment ou l'utilisateur soumet le formulaire
form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Si le formulaire est invalide alors il ne faut pas l'envoyer
    if (validerFormulaire()) {
        form.submit();
    }
});