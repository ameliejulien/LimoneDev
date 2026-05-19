<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="paiement.css">
    <title>Paiement</title>
</head>
<main>
    <?php
    chdir(__DIR__ . '/../../');
    require('lib/service/ServicePaiement.php');
    if (validerPaiement()) { ?>
        Paiement vaildé
    <?php } else {?>
        Paiement refusé
    <?php } ?>
</main>

</html>