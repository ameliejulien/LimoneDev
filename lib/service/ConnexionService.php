<?php
include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/UtilisateurRepo.php';

function connexion($mail, $mdp): int
{
    try {
        $mail = strtolower($mail);

        file_put_contents("/tmp/debug.log", print_r("début fonction", true) . "\n", FILE_APPEND);
        getMdpHashFromMail($mail);
        file_put_contents("/tmp/debug.log", print_r("après call", true) . "\n", FILE_APPEND);



        $debug = [
            'mail' => $mail,
            'mdp' => $mdp,
            // 'uuid' => $uuid ? $uuid : "EMPTY UUID",
            'hashfrommail' => getMdpHashFromMail($mail),
            'verif' => password_verify($mdp, getMdpHashFromMail($mail)) ? "check" : "LOUD INCORRECT BUZZER"
        ];
        error_log("yo"); // pb dans getmdphashfrommail je pense
        $uuid = trouverUUID($mail);
        file_put_contents("/tmp/debug.log", print_r($debug, true) . "\n", FILE_APPEND);




        if ($uuid && password_verify($mdp, getMdpHashFromMail($mail))) {
            file_put_contents("/tmp/debug.log", "Condition is true !", FILE_APPEND);
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