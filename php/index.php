<?php

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' && $uri === '/aluno/create') {
    $body = json_decode(file_get_contents('php://input'), true);

    if (empty($body['name']) || empty($body['type_graduation'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $pdo = connectionDatabase();

    $sql = "INSERT INTO aluno (name, type_graduation) VALUES (:name, :type_graduation)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $body['name']);
    $stmt->bindValue(':type_graduation', $body['type_graduation']);
    $stmt->execute();

    http_response_code(201);
    echo json_encode(['message' => 'Aluno criado com sucesso']);
    exit;
}

if ($method === "GET" && $uri === '/alunos') {
    $pdo = connectionDatabase();
    $sql = "SELECT * FROM aluno";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $array = $stmt->fetchALL(PDO::FETCH_OBJ);

    http_response_code(200);
    echo json_encode(['Alunos' => $array, 'message' => 'Alunos retornados com sucesso']);
    exit;
}

function debug($param) {
    print_r('<pre>');
    var_dump($param);
    print_r('</pre>');
    die();
} 

function connectionDatabase () {
    try {
        return new PDO('pgsql:host=127.0.0.1;port=5432;dbname=jiuflix', 'maxter', 'admin', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
        exit;
    }
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
exit;