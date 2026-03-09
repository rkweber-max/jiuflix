<?php

namespace App\Services;

use App\DTOs\ClassmateRequestDTO;
use App\DTOs\ClassmateResponseDTO;
use App\Repositories\ClassmateRepository;
use App\Logging\LoggerFactory;

class ClassmateService {
    private $log;

    public function __construct()
    {
        $this->log = LoggerFactory::getLogger();
    }

    public function getById ($id) {
        $repository = new ClassmateRepository();

        $classmateId = $repository->getById($id);
        $this->log->info('service.classmate.get_by_id', ['message' => 'Classmate founded']);

        if (!$classmateId) {
            http_response_code(404);
            echo json_encode([
                'id' => $id,
                'message' => 'Aluno não encontrado!'
            ]);

            $this->log->error('service.classmate.get_by_id.not_found', ['message' => 'Classmate not found']);
            exit;
        }

        return $classmateId[0];
    }

    public function delete ($id) {
        $repository = new ClassmateRepository();

        $classmateId = $repository->delete($id);

        if (!$classmateId) {
            http_response_code(404);
            echo json_encode([
                'id' => $id,
                'message' => 'Aluno não encontrado!'
            ]);

            $this->log->error('service.classmate.deleted.not_found', ['message' => 'Classmate not found']);
            exit;
        }

        return $classmateId->id;
    }

    public function create (ClassmateRequestDTO $dto): ClassmateResponseDTO {
        $repository = new ClassmateRepository();

        $classmate = $repository->create($dto);

        return $classmate;
    }

    public function update (ClassmateRequestDTO $dto, $id) {
        $repository = new ClassmateRepository();

        $classmate = $repository->updated($dto->name, $dto->typeGraduation, $id);

        if (!$classmate) {
            http_response_code(404);
            echo json_encode([
                'id' => $dto->id,
                'message' => 'Aluno não encontrado!'
            ]);

            $this->log->error('service.classmate.updated.not_found', ['message' => 'Classmate not found']);
            exit;
        }

        return $classmate;
    }
}