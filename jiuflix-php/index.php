<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\ClassmateController;
use App\Logging\LoggerFactory;

$log = LoggerFactory::getLogger(); 

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', trim($uri, '/'));

if ($method === "PUT" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $body = json_decode(file_get_contents('php://input'), true);

    $controller = new ClassmateController();

    $classmate = $controller->update($body['name'], $body['type_graduation'], $id);

    http_response_code(200);
    echo json_encode([
        'id' => $id,
        'name' => $classmate->name,
        'type_graduation' => $classmate->type_graduation
    ]);

    $log->info('service.classmate.updated', ['message' => 'Classmate updated successfuly']);
    exit;
}

if ($method === 'POST' && $uri === '/aluno/create') {
    $body = json_decode(file_get_contents('php://input'), true);

    $controller = new ClassmateController();

    $classmate = $controller->create($body['name'], $body['type_graduation']);

    http_response_code(201);
    echo json_encode([
        'id' => $classmate[0]['id'],
        'name' => $classmate[0]['name'],
        'type_graduation' => $classmate[0]['type_graduation']
    ]);

    $log->info('controller.classmate.created', ['message' => 'Classmate created successfuly']);
    exit;
}

if ($method === "GET" && $uri === '/alunos') {
    $controller = new ClassmateController();

    $controller->getAll();
}

if ($method ===  "GET" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $controller = new ClassmateController();

    http_response_code(200);
    echo json_encode([
        'id' => $controller->getByID($id),
        'message' => 'Aluno encontrado com sucesso!'
    ]);

    $log->info('controller.classmate.bet_by_id', ['message' => 'Classmate founded successfuly']);
    exit;
}

if ($method === "DELETE" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $controller = new ClassmateController();

    http_response_code(200);
    echo json_encode([
        'id' => $controller->delete($id),
        'message' => 'Aluno deletado com sucesso!'
    ]);

    $log->info('controller.classmate.deleted', ['message' => 'Classmates deleted successfuly']);
    exit();
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);

$log = LoggerFactory::getLogger();
$log->error('route_not_found', ['message' => 'Route not found']);
exit;
