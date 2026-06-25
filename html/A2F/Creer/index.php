<?php
    require_once __DIR__ . '/../../../lib/service/ServiceUtilisateur.php';

    droitsAccesPage($_COOKIE['uuid'] ?? null, 1);

    require_once __DIR__ . '/../../../vendor/autoload.php';

    use OTPHP\InternalClock;
    use OTPHP\TOTP;

    $clock = new InternalClock();

    $totp = TOTP::generate($clock);

    $secret = $totp->getSecret(); 

    $totp = $totp->withLabel('Label of your web');
    $QRCodeUri = $totp->getQrCodeUri(
        'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
        '[DATA]'
    );
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Création A2F</title>
        <link rel="stylesheet" type="text/css" href="/A2F/style.css">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body class="flex flex-col min-h-screen">
        <?php require_once '../../ui/header.php'; ?>
        <main class="flex flex-col flex-1 items-center justify-center">
                <div class="flex flex-col items-center gap-[22px] bg-white w-[460px] mt-[32px] p-[32px] rounded-[18px] shadow-md">
                    <div class="flex flex-col w-[300px]">
                        <label htmlFor="secret">Secret :</label>
                        <input class="focus:border-[#1C2D30] rounded-md" type="text" id="secret" name="secret" value=<?= $secret ?> readonly>
                    </div>

                    <img class="m-auto" src=<?= $QRCodeUri ?> alt="Secret QRCode" width="300px">
                    
                    <div class="otp-wrapper">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                    </div>
                    <p class="text-red-600 hidden" id="not-full">Veuillez remplir le mot de passe en entier</p>
                    
                    <button class="w-full" type="submit" id="submit">Valider</button>
                </div>
            </main>
            <?php require_once '../../ui/footer.php'; ?>
        </body>
        <script src="/A2F/Creer/script.js"></script>
</html>