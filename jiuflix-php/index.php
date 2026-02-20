<?php

require __DIR__ . '/imports.php';
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\ClassmateController;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', trim($uri, '/'));

if ($method === "PUT" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $body = json_decode(file_get_contents('php://input'), true);

    validateRequiredFields($body['name'], $body['type_graduation']);

    validateTypegraduation($body['type_graduation']);

    $result = AlunosRepository::updated($body['name'], $body['type_graduation'], $id);
    if ($result == null) {
        http_response_code(404);
        echo json_encode([
            'id' => $id,
            'message' => 'Aluno não encontrado!'
        ]);
        exit;
    }

    http_response_code(200);
    echo json_encode([
        'id' => $result->id,
        'name' => $result->name,
        'type_graduation' => $result->type_graduation
    ]);
    exit;
}

if ($method === 'POST' && $uri === '/aluno/create') {
    $body = json_decode(file_get_contents('php://input'), true);

    validateRequiredFields($body['name'], $body['type_graduation']);
    validateTypegraduation($body['type_graduation']);

    $result = AlunosRepository::created($body['name'], $body['type_graduation']);

    http_response_code(201);
    echo json_encode([
        'id' => $result[0]['id'],
        'name' => $result[0]['name'],
        'type_graduation' => $result[0]['type_graduation']
    ]);
    exit;
}

if ($method === "GET" && $uri === '/alunos') {
    $controller = new ClassmateController();

    $controller->getAll();
}

if ($method ===  "GET" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $result = AlunosRepository::getById($id);

    if ($result == null) {
        http_response_code(404);
        echo json_encode([
            'id' => $id,
            'message' => 'Aluno não encontrado!'
        ]);
        exit;
    }

    http_response_code(200);
    echo json_encode([
        'id' => $result[0]['id'],
        'message' => 'Aluno encontrado com sucesso!'
    ]);
    exit;
}

if ($method === "DELETE" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $result = AlunosRepository::deleted($id);

    if ($result == null) {
        http_response_code(404);
        echo json_encode([
            'id' => $id,
            'message' => 'Aluno não encontrado'
        ]);
        exit();
    }

    http_response_code(200);
    echo json_encode([
        'id' => $id,
        'message' => 'Aluno deletado com sucesso!'
    ]);
    exit();
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
exit;
