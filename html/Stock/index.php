<!DOCTYPE html>
<html>

<head>
    <title>Catalogue</title>
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
        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);
        $lstArticles = getStock($idVendeur);

        $pageCourante = 1;
        $ligneParPage = 7;

        $nbPage =  intdiv(count($lstArticles), $ligneParPage);
        if (count($lstArticles) % $ligneParPage != 0) {
            $nbPage = $nbPage + 1;
        }

    ?>

    <h1>Stock des produits</h1>
        
    <form class="tableau">
        <table>
            <tr>
                <th>Identifiant produit</th>
                <th>Nom produit</th>
                <th>Quantité produit</th>
                <th>Catalogué</th>
            </tr>

            <?php
                foreach( $lstArticles as $article ) {
            ?>
                    <tr>
                        <td><?= $article['id_produit'] ?></td>
                        <td><?= $article['nom_produit']?></td>
                        <td>
                            <div class="ligne_qte">
                                <button class="btn-moins" onclick="diminuerQuantite(this, 1)">−</button>
                                <input type="text" class="qte" value="<?= intval($article['stock_produit']) ?>" min="0">
                                <button class="btn-plus" onclick="augmenterQuantite(this, 4)">+</button>
                            </div>
                        </td>
                        <td><input type="checkbox" <?= boolval($article['catalogue_produit']) ? 'checked' : '' ?>></td>
                    </tr>
            <?php
                }
            ?>

            
        </table>

        
        <div class="tableNav">
            <button onclick="pagePrecedente(this)">Page précedente</button>
            <input type="text" class="numPage" value="1">
            <button onclick="pageSuivante(this)">Page suivante</button>
        </div>
    
        <div class="sumbitDiv">
            <input type="submit" value="Enregistrer" class="submit"/>
        </div>

</form>
    <script src="stock.js"></script>
    <script>
    // récupération des lignes du tableau
    let lignesDepart = getLignes();
    const tableau = document.querySelector(".tableau");
    
    // écouteur des requêtes du formulaire
    tableau.addEventListener("submit", function (event) {
      
      // empêche l'envoi du formulaire sans exécuter le code qui suit
      event.preventDefault(); 

      let lignesSubmit = getLignes();
      let lignesModifiees = compareLignes(lignesDepart,lignesSubmit);

      // TODO => mettre la valeur de l'input du nombre du stock
      const formData = {
        lignesModifiees: lignesModifiees,
        typeRequete: "update"
      }

      // fetch vers le dossier API de création client
      
      fetch("../API/Stock.php", {
        method: "POST",
        body: JSON.stringify(formData)  // fait une string JSON du tableau
      })
      .then(response => response.json())  // transforme la réponse http en json exploitable
      .then(json => {
        if (json.reponse == 200) {
          afficherSnackBar('Notification','Connexion réussie !'); // alerte de la création du compte
          window.location.href = "../Vendeur/ConsulterCompteVendeur.php";
        
        } else {
          afficherSnackBar('Notification','Connexion échouée !'); // alerte de l'échec de la connexion
        }
      })
        
    });
</script>
</body>

</html>