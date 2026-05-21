<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="paiement.css">
    <title>Paiement validé</title>
</head>
<main>
    <?php 
    require('../ui/header.php');
    require('../../lib/service/ServicePaiement.php');
    if (validerPaiement()) { ?>
        <h1>Paiement vaildé</h1>
    <?php } else {?>
        <h1>Paiement refusé</h1>
    <?php } ?>
</main>

</html>