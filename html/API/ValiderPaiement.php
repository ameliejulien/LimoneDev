<?php
require "../../lib/service/ServicePaiement.php";

header('Content-Type: application/json');

validerFormulaire();

http_response_code(200);
echo json_encode($data);
?>