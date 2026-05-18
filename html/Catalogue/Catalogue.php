<?php
    try {
        $PDO = new PDO("pgsql:host=localhost;dbname=limone", "squidos", "limone");

        $PDO->exec("SET SCHEMA 'limone'");
        
        $images = $PDO->query("SELECT * FROM photo_produit")->fetchAll();

        } catch (PDOException $e) {
            print($e->getMessage());
            }
            ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Catalogue</title>
    </head>
    <body>
        <?php 
            foreach($images as $row) {
                $imageData = stream_get_contents($row['photo_produit']);
                $base64 = base64_encode($imageData);  
        ?>
            <img src=<?="data:image/jpeg;base64,$base64" ?> width="200" height="200" >
        <?php } ?>
    </body>
</html> 