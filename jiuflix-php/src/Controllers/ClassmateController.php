<?php

namespace App\Controllers;

use App\Logging\LoggerFactory;
use App\Repositories\ClassmateRepository;
use App\Services\ClassmateService;
use App\Services\ValidatorsService;

class ClassmateController {
    public function getAll() {
        $repository = new ClassmateRepository();

        http_response_code(200);
        echo json_encode(['Alunos' => $repository->getAll(), 'message' => 'Alunos retornados com sucesso!']);
        exit;
    }

    public function getByID ($id) {
        $service = new ClassmateService();

        return $service->getById($id);
    }

    public function delete ($id) {
        $service = new ClassmateService();

        return $service->delete($id);
    }

    public function create ($name, $typeGraduation) {
        $service = new ClassmateService();

        $validator = new ValidatorsService();
        $validator->validateRequiredFields($name, $typeGraduation);
        $validator->validateTypegraduation($typeGraduation);

        $log = LoggerFactory::getLogger();
        $log->info('controller.classmate.created', ['message' => 'Classmate created successfuly']);

        return $service->create($name, $typeGraduation);
    }

    public function update ($name, $typeGraduation, $id) {
        $service = new ClassmateService();

        $validator = new ValidatorsService();
        $validator->validateRequiredFields($name, $typeGraduation);
        $validator->validateTypegraduation($typeGraduation);

        return $service->update($name, $typeGraduation, $id);
    }
}