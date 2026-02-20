<?php

namespace App\Controllers;

use App\Repositories\ClassmateRepository;

class ClassmateController {
    public function getAll() {
        $repository = new ClassmateRepository();

        http_response_code(200);
        echo json_encode(['Alunos' => $repository->getAll(), 'message' => 'Alunos retornados com sucesso!']);
        exit;
    }
}