<?php

namespace App\Controllers;

use App\Logging\LoggerFactory;
use App\Repositories\ClassmateRepository;
use App\Services\ClassmateService;
use App\Services\ValidatorsService;

class ClassmateController {
    private $log;

    public function __construct() {
        $this->log = LoggerFactory::getLogger();
    }

    public function getAll() {
        $repository = new ClassmateRepository();
        
        $classmates = $repository->getAll();

        http_response_code(200);
        echo json_encode(['Alunos' => $classmates, 'message' => 'Alunos retornados com sucesso!']);

        $this->log->info('controller.classmate.get_all', ['message' => 'Classmates founded']);
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

        $this->log->info('controller.classmate.created', ['message' => 'Classmate created successfuly']);

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