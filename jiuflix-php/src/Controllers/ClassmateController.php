<?php

namespace App\Controllers;

use App\Repositories\ClassmateRepository;
use App\Services\ClassmateService;

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
}