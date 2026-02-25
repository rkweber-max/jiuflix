<?php

namespace App\Services;

use App\Repositories\ClassmateRepository;
use App\Logging\LoggerFactory;

class ClassmateService {
    public function getById ($id) {
        $repository = new ClassmateRepository();

        $classmateId = $repository->getById($id);

        if (!$classmateId) {
            http_response_code(404);
            echo json_encode([
                'id' => $id,
                'message' => 'Aluno não encontrado!'
            ]);
            exit;
        }

        return $classmateId[0]['id'];
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
            exit;
        }

        return $classmateId->id;
    }

    public function create ($name, $typeGraduation) {
        $repository = new ClassmateRepository();

        $classmate = $repository->create($name, $typeGraduation);

        $log = LoggerFactory::getLogger();
        $log->info('User created successfuly', ['message' => 'User created successfuly']);

        return $classmate;
    }

    public function update ($name, $typeGraduation, $id) {
        $repository = new ClassmateRepository();

        $classmate = $repository->updated($name, $typeGraduation, $id);

        if (!$classmate) {
            http_response_code(404);
            echo json_encode([
                'id' => $id,
                'message' => 'Aluno não encontrado!'
            ]);
            exit;
        }

        return $classmate;
    }
}