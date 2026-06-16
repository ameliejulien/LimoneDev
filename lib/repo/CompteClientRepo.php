<?php
    function creerClientBdd($idClient) {
        $connectBDD = connecterBDD();
        $requeteClient = "INSERT INTO limone.Client (id_client) VALUES (:id);";
        
        $requeteClientPreparee = $connectBDD->prepare($requeteClient);
        $requeteClientPreparee->bindValue(":id", $idClient);
        
        $requeteClientPreparee->execute();                        
    }

    /**
     * @Brief cherche l'existence d'un client via son email
     * @Param array un client sous forme de map 
     * @Return bool un booléen correspondant à l'existance du client
     */
    function chercherClient($mail) {
        $connectBDD = connecterBDD();
        // requête
        $requete = 
        "SELECT 1 FROM limone.Utilisateur
        WHERE email_utilisateur = :mail";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue(":mail", $mail);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        return $row !== false;
    }


    /**
     * @Brief Envoie d'une requête dans la BDD pour récupérer les informations d'un client
     */
    function trouverInfosClient($uuidClient) {

        $connectBDD = connecterBDD();

        $requete = 
        "SELECT 
            u.pp_utilisateur, 
            u.nom_utilisateur, 
            u.email_utilisateur, 
            u.telephone_utilisateur, 
            a.adresse, a.code_postal_adresse, 
            a.ville_adresse
        FROM limone.Utilisateur u 
        LEFT JOIN limone.Adresse_Client ac ON u.id_utilisateur = ac.id_utilisateur 
        LEFT JOIN limone.Adresse a ON ac.id_adresse = a.id_adresse
        WHERE u.uuid_utilisateur = :uuidClient;";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute([':uuidClient' => $uuidClient]);
        $infosClient = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $infosClient;
    }


    function getIdClient($client){
        $connectBDD = connecterBDD();

        $requete =  "SELECT id_client FROM Client INNER JOIN Utilisateur ".
                    "ON Utilisateur.id_utilisateur = Client.id_client ".
                    "WHERE email_utilisateur = :mail;";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue(":mail", $client["mail"]);
        $requetePreparee->execute(); 
        $id = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $id;

    }


    /**
     * @Brief Changer ou ajouter les informations du client
     */
    function modifierClientBDD($client, $files = []) {

        $idClient = trouverIDUtilisateur($_COOKIE['uuid']);
        $connectBDD = connecterBDD();

        // Vérifier si le client a déjà une adresse
        $requeteGetIdAdresse = "SELECT ac.id_adresse FROM limone.Adresse_Client ac WHERE ac.id_utilisateur = :idClient";
        $requeteIdAdressePreparee = $connectBDD->prepare($requeteGetIdAdresse);
        $requeteIdAdressePreparee->execute([':idClient' => $idClient]);
        $rowAdresse = $requeteIdAdressePreparee->fetch(PDO::FETCH_ASSOC);

        // Une première vérification avec adresse existante
        if ($rowAdresse && !empty($rowAdresse['id_adresse'])) {

            // L'adresse existe déjà donc MAJ de l'adresse
            $idAdresse = $rowAdresse['id_adresse'];
            
            $requeteAdresse = "UPDATE limone.Adresse 
                            SET adresse = :adresse, ville_adresse = :ville, code_postal_adresse = :code 
                            WHERE id_adresse = :idAdresse";
            $requeteUpdateAdresse = $connectBDD->prepare($requeteAdresse);
            $requeteUpdateAdresse->execute([
                ':adresse' => $client["adresse"],
                ':ville' => $client["ville_adresse"],
                ':code' => $client["code_postal_adresse"],
                ':idAdresse' => $idAdresse
            ]);
        } 
        
        // Une seconde vérification avec adresse inexistante
        else {

            // Aucune adresse n'existe donc création de l'adresse
            $requeteInsertAdresse = "INSERT INTO limone.Adresse (adresse, ville_adresse, code_postal_adresse, facturation_adresse) 
                                    VALUES (:adresse, :ville, :code, false) RETURNING id_adresse";
            $requeteInsertAdressePreparee = $connectBDD->prepare($requeteInsertAdresse);
            $requeteInsertAdressePreparee->execute([
                ':adresse' => $client["adresse"],
                ':ville' => $client["ville_adresse"],
                ':code' => $client["code_postal_adresse"]
            ]);
            
            $rowNouvelleAdresse = $requeteInsertAdressePreparee->fetch(PDO::FETCH_ASSOC);
            $idAdresse = $rowNouvelleAdresse['id_adresse'];

            $requeteLiaison = "INSERT INTO limone.Adresse_Client (id_utilisateur, id_adresse) 
                            VALUES (:idClient, :idAdresse)";
            $requeteLiaisonPreparee = $connectBDD->prepare($requeteLiaison);
            $requeteLiaisonPreparee->execute([
                ':idClient' => $idClient,
                ':idAdresse' => $idAdresse
            ]);
        }

        // Une troisième vérification avec modification des autres infos avec image
        if (isset($files['picture']) && $files['picture']['error'] == UPLOAD_ERR_OK) {
            // L'utilisateur a choisi une image
            $requeteUtilisateur = "UPDATE limone.Utilisateur 
                                SET nom_utilisateur = :nom, email_utilisateur = :email, telephone_utilisateur = :phone, pp_utilisateur = :pp
                                WHERE id_utilisateur = :idClient";
            
            $requeteUpdateUtilisateur = $connectBDD->prepare($requeteUtilisateur);
            
            $imageFlux = fopen($files['picture']['tmp_name'], 'rb');
            
            $requeteUpdateUtilisateur->bindValue(':nom', $client["nom_utilisateur"]);
            $requeteUpdateUtilisateur->bindValue(':email', $client["email_utilisateur"]);
            $requeteUpdateUtilisateur->bindValue(':phone', $client["telephone_utilisateur"]);
            $requeteUpdateUtilisateur->bindValue(':idClient', $idClient);
            $requeteUpdateUtilisateur->bindValue(':pp', $imageFlux, PDO::PARAM_LOB);
            
            $requeteUpdateUtilisateur->execute();

            if (is_resource($imageFlux)) {
                fclose($imageFlux);
            }
        } 
        
        // Une quatrième vérification avec modification des autres infos sans image
        else {
            // L'utilisateur n'a pas choisi d'image
            $requeteUtilisateur = "UPDATE limone.Utilisateur 
                                SET nom_utilisateur = :nom, email_utilisateur = :email, telephone_utilisateur = :phone 
                                WHERE id_utilisateur = :idClient";

            $requeteUpdateUtilisateur = $connectBDD->prepare($requeteUtilisateur);
            $requeteUpdateUtilisateur->execute([
                ':nom' => $client["nom_utilisateur"],
                ':email' => $client["email_utilisateur"],
                ':phone' => $client["telephone_utilisateur"],
                ':idClient' => $idClient
            ]);
        }

        return 200;
    }

?>
