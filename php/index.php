<?php

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

    $pdo = connectionDatabase();

    $sql = "UPDATE aluno SET name = :name, type_graduation = :type_graduation WHERE id = :id";


    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $body['name'], PDO::PARAM_STR);
    $stmt->bindValue(':type_graduation', $body['type_graduation'], PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

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
    echo json_encode(['Alunos' => $array, 'message' => 'Alunos retornados com sucesso!']);
    exit;
}

if ($method ===  "GET" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $pdo =  connectionDatabase();

    $sql = "SELECT * FROM aluno WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['Aluno' => $result, 'message' => 'Aluno encontrado com sucesso!']);
    exit;
}

if ($method === "DELETE" && $uriParts[0] === 'aluno' && isset($uriParts[1]) && is_numeric($uriParts[1])) {
    $id = (int) $uriParts[1];

    $pdo = connectionDatabase();

    $sql = "DELETE FROM aluno WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    debug($result);

    http_response_code(200);
    echo json_encode(['Aluno' => $result, 'message' => 'Aluno deletado com sucesso!']);
    exit();
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