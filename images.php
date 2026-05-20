#!/usr/bin/php
<?php
    require './connect_params.php';

    try {
        $PDO = new PDO("pgsql:host=$server;dbname=$dbName", "$dbUser", "$dbPassword");

        print("Connection successful\n");

        $PDO->exec("SET SCHEMA 'limone';");

        $stmt = $PDO->prepare("INSERT INTO photo_produit (id_produit, photo_produit, photo_principale) VALUES (:id, :data, :main)");

        for ($i = 1; $i <= 100; $i++) {
            $imageData = file_get_contents("./images/$i.jpg");

            $stmt->bindValue(":id", $i);
            $stmt->bindValue(":data", $imageData, PDO::PARAM_LOB);
            $stmt->bindValue(":main", true);

            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>