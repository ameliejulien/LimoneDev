<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../repo/UtilisateurRepo.php';
require_once __DIR__ . '/../repo/A2FRepo.php';

use OTPHP\TOTP;

function creationA2F($uuid, $secret, $otp) {
    $totp = TOTP::createFromSecret($secret);

    if ($totp->verify($otp)) {
        $id = trouverIDUtilisateur($uuid);

        mettreSecretBDD($id, $secret);
    } else {
        throw new Exception("IncorrectOTP");
    }
}

?>