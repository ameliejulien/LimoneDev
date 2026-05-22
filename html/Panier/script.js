// Récupère le html entity du formulaire
var form = document.querySelector('form');

// Ajoute un écouteur pour récuperer le moment ou l'utilisateur soumet le formulaire
form.addEventListener('submit', function (event) {
    event.preventDefault();
    
    // Si le formulaire est invalide alors il ne faut pas l'envoyer
    fetch('../API/ValiderPanier.php').then(response => {        
        if (response.status === 200) {
            response.json().then(json => {
                if (json['manquants'].length != 0) {

                    var confirmString = "Certains produits du paniers n'éxiste plus ou pas : " + json['manquants'];

                    if (confirm(confirmString)) {
                        form.submit();
                    }

                } else if (json['valides'].length == 0) {
                    afficherSnackBar('Erreur', "Vous n'avez pas de produits dans votre panier");
                } else {
                    form.submit();
                }
            });
        } else {
            afficherSnackBar('Erreur', 'Une erreur est survenue');
        }
    });
});

function supprimerArticleDuPanier(produitId) {
    fetch('../API/SupprimerProduitDuPanier.php', {
        method: "POST",
        body: JSON.stringify(produitId)
      }).then(response => {        
        location.href = '../Panier'
    });
}