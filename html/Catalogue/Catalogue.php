<?php
    include '../../lib/service/ServiceProduit.php';

    $images = recupererTouslesProduits();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Catalogue</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body>
        <div class="grid grid-cols-5 m-auto">
            <?php 
                foreach($images as $row) {
                    $imageData = stream_get_contents($row['photo_produit']);
                    $base64 = base64_encode($imageData);  
            ?>
                <div class="flex flex-col">
                    <img src=<?="data:image/jpeg;base64,$base64" ?> class="w-50 h-50">
                    <h3><?= $row['nom_produit'] ?></h3>
                </div>
            <?php } ?>
        </div>
    </body>
</html> 