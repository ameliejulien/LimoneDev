<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../repo/UtilisateurRepo.php';
require_once __DIR__ . '/../repo/A2FRepo.php';

use OTPHP\TOTP;

function creationA2F($uuid, $secret, $otp) {
    $dbh = connecterBDD();
    $dbh->beginTransaction();    
    try {
        $totp = TOTP::createFromSecret($secret);

        if ($totp->verify($otp)) {
            $id = trouverIDUtilisateur($uuid);

            mettreSecretBDD($id, $secret);
        } else {
            throw new Exception("IncorrectOTP");
        }
        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        throw $e;
    }
}

function utilisateurASecret($uuid) {
    $secret = getSecretParUUID($uuid);

    return !empty($secret);
}

function verifierOTP($secret, $otp) {
    $totp = TOTP::createFromSecret($secret);

    return $totp->verify($otp);
}

?>