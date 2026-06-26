<?php
include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/UtilisateurRepo.php';
require_once __DIR__ . '/ServiceA2F.php';
require_once __DIR__ . '/../Constantes.php';

function connexion($mail, $mdp, $otp = null): int
{
    try {
        $mail = strtolower($mail);

        $uuid = trouverUUID($mail);

        if ($uuid && password_verify($mdp, getMdpHashFromMail($mail))) {
            $secret = getSecretParMail($mail);

            // L'A2F n'est prise en compte que si l'utilisateur a configuré un secret
            if (!empty($secret)) {
                if (empty($otp)) {
                    return HTTP_A2F_REQUISE;
                }

                if (!verifierOTP($secret, $otp)) {
                    return HTTP_A2F_INVALIDE;
                }
            }

            creerCookieConnexion($uuid);
            return HTTP_OK;
        } else {
            return HTTP_ERR_CONNEXION;
        }
    } catch (Exception $e) {
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