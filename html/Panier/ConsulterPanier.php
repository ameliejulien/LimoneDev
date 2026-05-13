<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="panier.css">
    <script src="consulterPanier.js"></script>
    <title>Compte Client</title>
</head>


<?php

?>

<body>
    <h1>
        Panier
    </h1>
    <div class="cart">
        <h2>Articles du panier</h2>

        <div class="article-container">
            <?php
            foreach ($val as $panier) {
                ?>

                <div class="article">

                    <div class="article-image">
                        <img src="./beurre.png" />
                    </div>

                    <div class="article-content">

                        <h3 class="article-name">Beurre demi-sel</h3>

                        <span class="article-description">

                            Le beurre salé est l'une des trois variétés de beurre les plus consommées,
                            avec le beurre doux et le beurre demi-sel.
                            Il est à la fois utilisé en cuisine et consommé en tartines, seul ou
                            accommodé d'autres éléments.

                        </span>

                        <div class="article-price">

                            <span>2.54€</span>

                        </div>
                    </div>
                </div>
                <?
            }
            ?>
        </div>
    </div>
</body>

</html>