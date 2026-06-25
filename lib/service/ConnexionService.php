<?php
include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/UtilisateurRepo.php';
require_once __DIR__ . '../Constantes.php';

function connexion($mail, $mdp): int
{
    try {
        $mail = strtolower($mail);

        getMdpHashFromMail($mail);

        $uuid = trouverUUID($mail);

        if ($uuid && password_verify($mdp, getMdpHashFromMail($mail))) {
            creerCookieConnexion($uuid);
            return HTTP_OK;
        } else {
            return HTTP_ERR_CONNEXION;
        }
    } catch (Exception $e) {
        echo $e;
        return HTTP_ERR_GENERIQUE;
    }
}

function creerCookieConnexion($uuid)
{
    setcookie(
        'uuid',
        $uuid,
        time() + 3 * 24 * 60 * 60,
        "/"
    );
}

?>