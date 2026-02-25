<?php

namespace App\Services;

use App\Logging\LoggerFactory;

class ValidatorsService {
    public function validateRequiredFields($name, $typeGraduation) {
        if (empty($name) || empty($typeGraduation)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);

            $log = LoggerFactory::getLogger();
            $log->error('validator.required_fields', ['message' => 'Validation required fields']);
            exit;
        }
    }

    public function validateTypegraduation ($typeGraduation) {
        $strips = ["BRANCA", "PRETA", "AZUL"];
    
        if (!in_array($typeGraduation, $strips)) {
            http_response_code(404);
            echo json_encode(['message' => 'Type graduation not found']);

            $log = LoggerFactory::getLogger();
            $log->error('validator.type_graduation', ['message' => 'Validation type graduation']);
            die();
        }
    }
}