/**
 * Affiche une snack bar dans le haut droit de l'écran pour y placer des informations pour l'utilisateur
 * @param {String} titre 
 * @param {String} contenu 
 */
function afficherSnackBar(titre, contenu) {

    const snackbar = document.getElementsByClassName("snackbar")[0];
    const snackbarTitle = document.getElementsByClassName("snackbarTitle")[0];
    const snackbarText = document.getElementsByClassName("snackbarText")[0];

    snackbarTitle.textContent = titre;
    snackbarText.textContent = contenu;

    // force le re-déclenchement de l'animation si déjà affichée
    snackbar.classList.remove("show");
    void snackbar.offsetWidth; // reflow

    snackbar.classList.add("show");

    setTimeout(function () {
        snackbar.classList.remove("show");
    }, 3000);
}