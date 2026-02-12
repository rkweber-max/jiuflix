<?php

function validateTypegraduation ($typeGraduation) {
    $strips = ["BRANCA", "PRETA", "AZUL"];

    if (!in_array($typeGraduation, $strips)) {
        http_response_code(404);
        echo json_encode(['message' => 'Type graduation not found']);
        die();
    }
}