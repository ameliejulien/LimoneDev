<!DOCTYPE html>
<html>

<head>
    <title>Stock vendeur</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="../snackbar.js"></script>
</head>

<body class="bg-[#fffdea]">
    <?php
        require_once '../ui/header.php'; 
        require_once __DIR__ . '/../../lib/service/ServiceStock.php';
        require_once __DIR__ . '/../../lib/repo/UtilisateurRepo.php';
        require_once __DIR__ . '/../../lib/service/ServiceUtilisateur.php';

        droitsAccesPage($_COOKIE['uuid'], 2);

        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);
        $lstArticles = getStock($idVendeur);
    ?>

    <h1>Stock des produits</h1>
        
    <form class="tableau">
        <table>
            <tr>
                <th>Identifiant produit</th>
                <th>Image produit</th>
                <th>Nom produit</th>
                <th>Quantité produit</th>
                <th>Catalogué</th>
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
                    </tr>
            <?php
                }
            ?>

            
        </table>

        
        <div class="tableNav">
            <button type="button" onclick="pagePrecedente(this)">Page précedente</button>
            <input type="text" class="numPage" value="1">
            <button type="button" onclick="pageSuivante(this)">Page suivante</button>
        </div>
    
        <div class="sumbitDiv">
            <input type="submit" value="Enregistrer" class="submit"/>
            <button type="button" onclick="window.location.href = '../Vendeur/ConsulterCompteVendeur.php';">Retour</button>
        </div>

    </form>
        <div class="snackbar">
        <h3 class="snackbarTitle"></h3>
        <p class="snackbarText"></p>
    </div>

    <script src="../snackbar.js"></script>
    <script src="stock.js"></script>
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
                    if (response.status == 200) {
                        afficherSnackBar('Notification','Mise à jour des données réussie !'); // alerte de la création du compte
                        window.location.href = "../Catalogue";
                    } else {
                        afficherSnackBar('Notification','Mise à jour des données échouée !'); // alerte de l'échec de la connexion
                    }
            
                });
        });
    </script>
    <?php require_once '../ui/footer.php' ?> 
</body>

</html>