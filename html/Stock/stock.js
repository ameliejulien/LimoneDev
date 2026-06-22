let lignes;
const lignesParPage = 5;
let pageCourante = 1;
let nbPages;

let idArtSuppression = null;

/**
 * réupère lees lignes et affiche le tableau au chargement de la page
 */
window.onload = function() {
    lignes = document.querySelectorAll("table tr:not(:first-child)");
    nbPages = Math.ceil(lignes.length / lignesParPage);

    afficherPage(1);

}



/**
 * Fonction qui décrémente la valeur du stock de la ligne courante
 * 
 * @param {Node} btn un bouton de décrément
 */
function diminuerQuantite(btn) {
    const input = btn.parentElement.querySelector('.qte');
    let val = parseInt(input.value);
    if (val > 0) input.value = val - 1;
}


/**
 * Fonction qui incrémente la valeur du sotck de la ligne courante
 * 
 * @param {Node} btn un bouton d'incrément
 */
function augmenterQuantite(btn) {
    const input = btn.parentElement.querySelector('.qte');
    let val = parseInt(input.value);
    input.value = val + 1;
}

/**
 * Fonction qui récupère les lignes de la table
 * 
 * @returns {Array} tabRetour un tableau contenant l'id, la quantité et si le produit est catalogué
 */
function getLignes() {
    // récup des lignes de la table sauf la première
    let tab = document.querySelectorAll("table tr:not(:first-child)");
    
    // transformation de tab en array avec les valeurs de la table
    let tabRetour = Array.from(tab).map(ligne => ({
        id: ligne.querySelector("td:nth-child(1)").textContent.trim(),
        stock: ligne.querySelector(".qte").value,
        catalogue: ligne.querySelector("input[type='checkbox']").checked.toString()
    }));

    console.log(tabRetour);
    return tabRetour;
}



/**
 * Fonction comparant le stock avant et après submit
 * 
 * @param {Array} tab1 
 * @param {Array} tab2 
 * @returns {Array} un tableau contenant les lignes modifiées
 */
function compareLignes(tab1, tab2) {
    let ligneDiff = [];

    for (let i = 0 ; i < tab1.length ; i++) {
        // compare le stock et le catalogue et si l'un est différent, la ligne est ajourée
        if (tab1[i].stock !== tab2[i].stock || tab1[i].catalogue !== tab2[i].catalogue ) {
            ligneDiff.push(tab2[i]);
        }
    }
    return ligneDiff;
}


/**
 * Fonction affichant la page précédente dans le tableau
 * @param {Node} btn 
 */
function pagePrecedente(btn) {
    if (pageCourante > 1) {
        pageCourante--;
        afficherPage(pageCourante);
    }
}


/**
 * Fonction affichant la page suivante dans le tableau
 * @param {Node} btn 
 */
function pageSuivante(btn) {
    if (pageCourante < nbPages) {
        pageCourante++;
        afficherPage(pageCourante);
    }
}

/**
 * Affiche les lignes du tableau comprises entre debut et fin
 * @param {number} page le numéro de la page à afficher
 */
function afficherPage(page) {
    lignes.forEach((ligne, index) => {

        let debut = (page - 1) * lignesParPage;
        let fin = debut + lignesParPage;

        if (index >= debut && index < fin) {
            ligne.style.display = "";
        } else {
            ligne.style.display = "none";
        }
    });

    document.querySelector(".numPage").value = page + " / " + nbPages;
}

function popupSuppression(node) {
    const confirmation = document.getElementsByClassName("deleteConfirmation")[0];
    confirmation.hidden = false;

    idArtSuppression = node.closest("tr").querySelector("td:nth-child(1)").textContent.trim();
    console.log("id : "+idArtSuppression)
}


function confirmerSuppression(){
    const confirmation = document.getElementsByClassName("deleteConfirmation")[0];
    confirmation.hidden = true;
    const formData = {
                idArt: idArtSuppression,
                typeRequete: "delete"
            }
    // TODO faire le fetch 
    fetch("../API/Stock.php", {
                method: "POST",
                body: JSON.stringify(formData)  // fait une string JSON du tableau
            })
            .then(response => {
                    console.log(response.status)
                    if (response.status == 200) {
                        afficherSnackBar('Notification','Suppression réussie !'); // alerte de la création du compte
                        window.location.reload();
                    } else {
                        afficherSnackBar('Notification','Supression échouée !'); // alerte de l'échec de la connexion
                    }
            
                });
    idArtSuppression = null

}


function cancelSuppression(){
    const confirmation = document.getElementsByClassName("deleteConfirmation")[0];
    confirmation.hidden = true;
}