<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="paiement.css">
    <title>Paiement validé</title>
</head>
<body>
    <?php require_once('../ui/header.php'); ?>
    <main>
        <?php 
        require_once('../../lib/service/ServicePaiement.php');
        if (validerPaiement()) { ?>
            <h1>Paiement validé</h1>
        <?php } else {?>
            <h1>Paiement refusé</h1>
        <?php } ?>
        <button onclick="location.href = '../Catalogue'">Retourner au catalogue</button>
    </main>
</body>
</html>