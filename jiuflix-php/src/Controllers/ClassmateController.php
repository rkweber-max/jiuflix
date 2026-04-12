<?php

namespace App\Controllers;

use App\Databases\Database;
use App\DTOs\ClassmateRequestDTO;
use App\DTOs\ClassmateResponseDTO;
use App\Logging\LoggerFactory;
use App\Exceptions\InvalidTypeGraduationException;
use App\Repositories\ClassmateRepository;
use App\Services\ClassmateService;
use App\Services\ValidatorsService;

class ClassmateController {
    private $log;
    private ClassmateRepository $repository;
    private ClassmateService $service;

    public function __construct() {
        $this->log = LoggerFactory::getLogger();
        $pdo = (new Database())->connectionDatabase();
        $this->repository = new ClassmateRepository($pdo);
        $this->service = new ClassmateService($this->repository);
    }

    public function getAll() {
        $classmates = $this->repository->getAll();

        http_response_code(200);
        echo json_encode(['Alunos' => $classmates, 'message' => 'Alunos retornados com sucesso!']);

        $this->log->info('controller.classmate.get_all', ['message' => 'Classmates founded']);
        exit;
    }

    public function getByID ($id) {
        return $this->service->getById($id);
    }

    public function delete ($id) {
        return $this->service->delete($id);
    }

    public function create (ClassmateRequestDTO $dto): ClassmateResponseDTO {
        $validator = new ValidatorsService();
        $validator->validateRequiredFields($dto);
        try {
            $validator->validateTypegraduation($dto);
        } catch (InvalidTypeGraduationException) {
            http_response_code(404);
            echo json_encode(['message' => 'Type graduation not found']);
            exit;
        }

        $this->log->info('controller.classmate.created', ['message' => 'Classmate created successfuly']);

        return $this->service->create($dto);
    }

    public function update(ClassmateRequestDTO $dto): ClassmateResponseDTO
    {
        $validator = new ValidatorsService();
        $validator->validateRequiredFields($dto);
        try {
            $validator->validateTypegraduation($dto);
        } catch (InvalidTypeGraduationException) {
            http_response_code(404);
            echo json_encode(['message' => 'Type graduation not found']);
            exit;
        }

        return $this->service->update($dto, $dto->id);
    }
}
