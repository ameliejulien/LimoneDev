<?php
    include __DIR__ . '/../../connect_params.php';
    include __DIR__ . '/../repo/ConnexionRepo.php';

    function connecter($data) {
        $data["motDePasse"] = hash('sha256', $data["motDePasse"]);
        return connexionBDD($data);
    }   

    function creerCookieConnexion($data, $typeUtilisateur) {
    
    $tab = [
        "mail" => $data["email_utilisateur"],
        "idUtilisateur" => $data["id_utilisateur"],
        "typeUtilisateur" => $data["type_utilisateur"]
    ];

    setcookie(
        $typeUtilisateur,
        json_encode($tab),
        time() + 3 * 24 * 60 * 60,
        "/"
    );
}

?>