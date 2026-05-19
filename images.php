#!/usr/bin/php
<?php
    try {
        $PDO = new PDO("pgsql:host=localhost;dbname=saedb", "sae", "LimoneDev.121");

        print("Connection successful\n");

        $PDO->exec("SET SCHEMA 'limone';");

        $stmt = $PDO->prepare("INSERT INTO photo_produit (photo_produit, photo_principale) VALUES (:data, :main)");

        for ($i = 1; $i <= 100; $i++) {
            $imageData = file_get_contents("./images/$i.jpg");

            $stmt->bindValue(":data", $imageData, PDO::PARAM_LOB);
            $stmt->bindValue(":main", true);

            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>