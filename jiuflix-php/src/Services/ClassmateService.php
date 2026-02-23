<?php

namespace App\Services;

use App\Repositories\ClassmateRepository;

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

        return $classmate;
    }
}