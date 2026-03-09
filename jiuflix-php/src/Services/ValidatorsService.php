<?php

namespace App\Services;

use App\DTOs\ClassmateRequestDTO;
use App\Logging\LoggerFactory;

class ValidatorsService {
    public function validateRequiredFields(ClassmateRequestDTO $dto) {
        if (empty($dto->name) || empty($dto->typeGraduation) || empty($dto->age) || empty($dto->gender) || empty($dto->category)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);

            $log = LoggerFactory::getLogger();
            $log->error('validator.required_fields', ['message' => 'Validation required fields']);
            exit;
        }
    }

    public function validateTypegraduation (ClassmateRequestDTO $dto) {
        $strips = ["BRANCA", "PRETA", "AZUL"];
    
        if (!in_array($dto->typeGraduation, $strips)) {
            http_response_code(404);
            echo json_encode(['message' => 'Type graduation not found']);

            $log = LoggerFactory::getLogger();
            $log->error('validator.type_graduation', ['message' => 'Validation type graduation']);
            die();
        }
    }
}