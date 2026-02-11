<?php

$body = json_decode(file_get_contents('php://input'), true);

function created ($name, $typeGraduation) {
    $pdo = connectionDatabase();
    $sql = "INSERT INTO aluno (name, type_graduation) VALUES (:name, :type_graduation)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':type_graduation', $typeGraduation);
    $stmt->execute();
}

function updated ($name, $typeGraduation, $id) {
    $pdo = connectionDatabase();

    $sql = "UPDATE aluno SET name = :name, type_graduation = :type_graduation WHERE id = :id ORDER BY";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':type_graduation', $typeGraduation, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function getAll () {
    $pdo = connectionDatabase();
    $sql = "SELECT * FROM aluno";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $array = $stmt->fetchALL(PDO::FETCH_OBJ);

    http_response_code(200);
    echo json_encode(['Alunos' => $array, 'message' => 'Alunos retornados com sucesso!']);
    exit;
}

function getById($id) {
    $pdo =  connectionDatabase();

    $sql = "SELECT * FROM aluno WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}

function deleted($id) {
    $pdo = connectionDatabase();

    $sql = "DELETE FROM aluno WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}
