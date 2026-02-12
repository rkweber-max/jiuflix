<?php

require_once __DIR__ . '../../jiuflix-php/imports.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', trim($uri, '/'));

if ($method === "PUT" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $body = json_decode(file_get_contents('php://input'), true);

    if (empty($body['name']) || empty($body['type_graduation'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    validateTypegraduation($body['type_graduation']);

    updated($body['name'], $body['type_graduation'], $id);

    http_response_code(200);
    echo json_encode(['message' => 'Aluno atualizado com sucesso']);
    exit;
}

if ($method === 'POST' && $uri === '/aluno/create') {
    $body = json_decode(file_get_contents('php://input'), true);

    if (empty($body['name']) || empty($body['type_graduation'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    created($body['name'], $body['type_graduation']);

    http_response_code(201);
    echo json_encode(['message' => 'Aluno criado com sucesso']);
    exit;
}

if ($method === "GET" && $uri === '/alunos') {
    getAll();
}

if ($method ===  "GET" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    getById($id);

    http_response_code(200);
    echo json_encode(['message' => 'Aluno encontrado com sucesso!']);
    exit;
}   

if ($method === "DELETE" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    deleted($id);

    http_response_code(200);
    echo json_encode(['message' => 'Aluno deletado com sucesso!']);
    exit();
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
exit;