function afficherSnackBar(titre, contenu) {

    const snackbar = document.getElementsByClassName("snackbar")[0];
    const snackbarTitle = document.getElementsByClassName("snackbarTitle")[0];
    const snackbarText = document.getElementsByClassName("snackbarText")[0];

    snackbarTitle.textContent = titre;
    snackbarText.textContent = contenu;

    // affiche la snackbar
    snackbar.style.visibility = "visible";

    // la cache après 4 secondes
    setTimeout(function () {
        snackbar.style.visibility = "hidden";
    }, 3000);
}