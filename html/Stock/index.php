<!DOCTYPE html>
<html>

<head>
    <title>Stock vendeur</title>
    <link rel="stylesheet" type="text/css" href="/Stock/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Global.css">   
    <link rel="stylesheet" href="/Stock/style.css"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="../snackbar.js"></script>
</head>

<body class="bg-[#fffdea]">
    <?php
        require_once '../ui/header.php'; 
        require_once __DIR__ . '/../../lib/service/ServiceStock.php';
        require_once __DIR__ . '/../../lib/repo/UtilisateurRepo.php';
        require_once __DIR__ . '/../../lib/service/ServiceUtilisateur.php';
        require_once __DIR__ . '/../../lib/Constantes.php';


        droitsAccesPage($_COOKIE['uuid'], 2);

        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);
        $lstArticles = getStock($idVendeur);

        $lstVide = count( $lstArticles) == 0;
    ?>

        
    <?php if ( !$lstVide) { ?>
        <h1>Stock des produits</h1>
        <form class="tableau">
            <table>
                <tr>
                    <th>Identifiant produit</th>
                    <th>Image produit</th>
                    <th>Nom produit</th>
                    <th>Quantité produit</th>
                    <th>Catalogué</th>
                    <th></th>
                </tr>

                <?php
                    foreach( $lstArticles as $article ) {
                ?>
                        <tr>
                            <td><?= $article['id_produit'] ?></td>
                            <td><img src=<?= $article['photo_produit'] ? "../imagesProduits/" . $article['photo_produit'] : '../imagesProduits/placeholder.png' ?> class="photoProduit"></td>
                            <td><?= $article['nom_produit']?></td>
                            <td>
                                <div class="ligne_qte">
                                    <button type="button" class="btn-moins" onclick="diminuerQuantite(this, 1)">−</button>
                                    <input type="text" class="qte" value="<?= intval($article['stock_produit']) ?>" min="0">
                                    <button type="button" class="btn-plus" onclick="augmenterQuantite(this, 4)">+</button>
                                </div>
                            </td>
                            <td><input type="checkbox" <?= boolval($article['catalogue_produit']) ? 'checked' : '' ?>></td>
                            <td class="deleteCase"><button type="button" class="deleteButton" onclick="popupSuppression(this)"><i class="material-icons">delete</i></button></td>
                        </tr>
                <?php
                    }
                ?> 
            </table>
     
            <div class="tableNav">
                <button type="button" onclick="pagePrecedente(this)"><i class='fas fa-angle-left'></i></button>
                <input type="text" class="numPage" value="1">
                <button type="button" onclick="pageSuivante(this)"><i class='fas fa-angle-right'></i></button>
            </div>
        
            <div class="sumbitDiv">
                <button type="button" onclick="window.location.href = '../Catalogue';">Retour</button>
                <input type="submit" value="Enregistrer" class="submit"/>
            </div>
        <?php } else {?>
            <h1>Stock vide</h1>
        <?php }?>

    </form>
    <div class="snackbar">
        <h3 class="snackbarTitle"></h3>
        <p class="snackbarText"></p>
    </div>

    <div class="modal__overlay" id="modalDeco">
        <div class="modal__boite">
        <p class="modal__message">Souhaitez-vous vraiment supprimer cet article ?</p>
            <div class="modal__actions">
                <button type="button" class="profil__bouton" id="modalConfirmer" onclick="confirmerSuppression()">Oui</button>
                <button type="button" class="profil__bouton profil__bouton--deco" id="modalAnnuler" onclick="cancelSuppression()">Non</button>
            </div>
        </div>
    </div>

    <script src="../snackbar.js"></script>
    <script src="/Stock/stock.js"></script>
    <script>
        // récupération des lignes du tableau
        let lignesDepart = getLignes();
        const form = document.querySelector("form");
        
        // écouteur des requêtes du formulaire
        form.addEventListener("submit", function (event){
        
            // empêche l'envoi du formulaire sans exécuter le code qui suit
            event.preventDefault(); 

            let lignesSubmit = getLignes();
            let lignesModifiees = compareLignes(lignesDepart,lignesSubmit);

            const formData = {
                lignesModifiees: lignesModifiees,
                typeRequete: "update"
            }

            // fetch vers le dossier API de création client
            
            fetch("../API/Stock.php", {
                method: "POST",
                body: JSON.stringify(formData)  // fait une string JSON du tableau
            })
            .then(response => {
                    console.log(response.status)
                    if (response.status == <?= HTTP_OK ?>) {
                        afficherSnackBar('Notification','Mise à jour des données réussie !');
                        window.location.href = "../Catalogue";
                    } else {
                        afficherSnackBar('Notification','Mise à jour des données échouée !');
                    }
            
                });
        });
    </script>
    <?php require_once '../ui/footer.php' ?> 
</body>

</html>