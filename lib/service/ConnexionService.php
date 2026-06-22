<?php
include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/UtilisateurRepo.php';

function connexion($mail, $mdp): int
{
    try {
        $mail = strtolower($mail);

        getMdpHashFromMail($mail);

        $uuid = trouverUUID($mail);

        if ($uuid && password_verify($mdp, getMdpHashFromMail($mail))) {
            creerCookieConnexion($uuid);
            return 200;
        } else {
            return 400;
        }
    } catch (Exception $e) {
        echo $e;
        return 500;
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