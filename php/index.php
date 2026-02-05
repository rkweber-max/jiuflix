<?php
// Porta 8001

// Definir o tipo de resposta como JSON
header('Content-Type: application/json');

// Pegando método e o URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Roteamento
if ($method === 'POST' && $uri === '/aluno/create') {
    // Ler o body da requisição
    $body = json_decode(file_get_contents('php://input'), true);

    if (empty($body['name']) || empty($body['type_graduation'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Conectar ao banco de dados
    try {
        $pdo = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=jiuflix', 'maxter', 'admin', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
        exit;
    }

    // Inserir o aluno no banco de dados
    $sql = "INSERT INTO aluno (name, type_graduation) VALUES (:name, :type_graduation)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $body['name']);
    $stmt->bindValue(':type_graduation', $body['type_graduation']);
    $stmt->execute();

    // Retornar o aluno criado
    http_response_code(201);
    echo json_encode(['message' => 'Aluno criado com sucesso']);
    exit;
}

// Caso não encontre a rota, retornar 404
http_response_code(404);
echo json_encode(['error' => 'Route not found']);
exit;