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
    });

    // TODO Verifier le format du telephone

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