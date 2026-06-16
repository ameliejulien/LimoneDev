<?php
    include __DIR__ . '/../../connect_params.php';
    include __DIR__ . '/../repo/UtilisateurRepo.php';

    function connexion($mail, $mdp): int {
        try {
            $mail = strtolower($mail);
            $mdp = hash('sha256', $mdp);
            $uuid = trouverUUID($mail, $mdp);

            if ($uuid) {
                creerCookieConnexion($uuid);
            } else {
                return 400;
            }
        } catch (Exception $e) {
            return 500;
        }

        return 200;
    }

    function creerCookieConnexion($uuid) {

        setcookie(
            'uuid',
            $uuid,
            time() + 3 * 24 * 60 * 60,
            "/"
        );
    }

?>